<?php
declare(strict_types=1);

/**
 * Tiny SMTP client (SSL, e.g. Gmail on port 465) with zero dependencies —
 * no Composer/PEAR mail library required. Good enough for low-volume
 * transactional notifications (contact form, job applications, etc).
 * All values that end up in the HTML body must be pre-escaped by the caller
 * with h() — this file does not escape anything itself.
 */
function send_mail(string $to, string $subject, string $htmlBody, array $attachments = []): bool
{
    $host = env('SMTP_HOST', 'smtp.gmail.com');
    $port = (int) env('SMTP_PORT', '465');
    $user = env('SMTP_USER');
    $pass = env('SMTP_PASS');
    $fromName = env('SMTP_FROM_NAME', 'BROX Tech');

    if (!$user || !$pass) {
        error_log('[mailer] SMTP not configured, skipping send to ' . $to);
        return false;
    }

    $errno = 0;
    $errstr = '';
    $socket = @stream_socket_client(
        "ssl://$host:$port",
        $errno,
        $errstr,
        15,
        STREAM_CLIENT_CONNECT
    );

    if (!$socket) {
        error_log("[mailer] Connection failed: $errstr ($errno)");
        return false;
    }

    $read = fn() => fgets($socket, 515);
    $expect = function (string $code) use ($socket, $read): bool {
        $line = '';
        do {
            $line = $read();
            if ($line === false) return false;
        } while (isset($line[3]) && $line[3] === '-'); // multi-line response
        return str_starts_with($line, $code);
    };
    $send = function (string $cmd) use ($socket) {
        fwrite($socket, $cmd . "\r\n");
    };

    try {
        if (!$expect('220')) throw new RuntimeException('No greeting from SMTP server');

        $send('EHLO ' . ($_SERVER['SERVER_NAME'] ?? 'localhost'));
        if (!$expect('250')) throw new RuntimeException('EHLO failed');

        $send('AUTH LOGIN');
        if (!$expect('334')) throw new RuntimeException('AUTH LOGIN rejected');

        $send(base64_encode($user));
        if (!$expect('334')) throw new RuntimeException('Username rejected');

        $send(base64_encode($pass));
        if (!$expect('235')) throw new RuntimeException('Password rejected');

        $send("MAIL FROM:<$user>");
        if (!$expect('250')) throw new RuntimeException('MAIL FROM rejected');

        $send("RCPT TO:<$to>");
        if (!$expect('250')) throw new RuntimeException('RCPT TO rejected');

        $send('DATA');
        if (!$expect('354')) throw new RuntimeException('DATA rejected');

        $boundary = 'brox-' . bin2hex(random_bytes(8));
        $headers = [
            'From: ' . mb_encode_mimeheader($fromName) . " <$user>",
            "To: <$to>",
            'Subject: ' . mb_encode_mimeheader($subject),
            'MIME-Version: 1.0',
            'Date: ' . date('r'),
        ];

        if ($attachments) {
            $headers[] = "Content-Type: multipart/mixed; boundary=\"$boundary\"";
            $body = "--$boundary\r\nContent-Type: text/html; charset=UTF-8\r\n\r\n$htmlBody\r\n";
            foreach ($attachments as $att) {
                $body .= "--$boundary\r\n";
                $body .= 'Content-Type: ' . ($att['type'] ?: 'application/octet-stream') . "; name=\"{$att['name']}\"\r\n";
                $body .= "Content-Transfer-Encoding: base64\r\n";
                $body .= "Content-Disposition: attachment; filename=\"{$att['name']}\"\r\n\r\n";
                $body .= chunk_split($att['data_base64']) . "\r\n";
            }
            $body .= "--$boundary--\r\n";
        } else {
            $headers[] = 'Content-Type: text/html; charset=UTF-8';
            $body = $htmlBody;
        }

        $message = implode("\r\n", $headers) . "\r\n\r\n" . $body;
        // dot-stuff lines starting with '.' per RFC 5321
        $message = preg_replace('/\n\./', "\n..", $message);

        $send($message . "\r\n.");
        if (!$expect('250')) throw new RuntimeException('Message rejected');

        $send('QUIT');
        fclose($socket);
        return true;
    } catch (Throwable $e) {
        error_log('[mailer] ' . $e->getMessage());
        fclose($socket);
        return false;
    }
}
