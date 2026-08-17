# BROX Tech — Simple version (no database)

Four pages — Home, Services, Careers, Contact — with no database, no admin
login, no user accounts. The contact form and job applications email you
directly instead of storing anything.

This is a trimmed-down version of the full BROX Tech PHP site. If you later
want the admin dashboard, lead storage, or BROX Launchpad, use the full
version instead — this one intentionally leaves those out.

## Requirements

- PHP 8.1+ — no MySQL, no Composer, no Node.js needed to run it
- The **mbstring** extension (used for length validation and email headers)
- The **openssl** extension, only if you want emails to actually send
  (the mailer connects over `ssl://`)

Most shared hosts enable both by default. If mbstring is missing, form
submissions fail with an empty 500 response and the browser shows a generic
error — check `storage/logs/php-error.log` to confirm. On a stock Windows
PHP build neither is enabled until you create a `php.ini` and uncomment
`extension=mbstring` and `extension=openssl`.

## Setup (local, on your own computer)

1. Copy `.env.example` to `.env`
2. Set `ADMIN_EMAIL` to the address you want contact-form submissions sent to
3. (Optional) Fill in `SMTP_USER` / `SMTP_PASS` if you want emails to actually
   send. Leave them blank while testing locally — the form will still work,
   it just won't send an email (it logs that it skipped, instead of failing).
4. Point your local server at the `public/` folder. Easiest way, using PHP's
   built-in server:
   ```
   php -S localhost:8000 -t public
   ```
   Then open `http://localhost:8000`.

If you're using XAMPP instead: copy this whole folder into `htdocs`, start
Apache, and visit `http://localhost/brox-simple/public/`.

## Setup (real hosting)

1. Set `.env` with real values, especially `SMTP_USER`/`SMTP_PASS` (a Gmail
   app password works, or any SMTP provider)
2. Point your web server's document root at `public/` — not the project root.
   `config/`, `includes/`, and `storage/` must not be web-accessible.
3. Done — there's no database to set up for this version.

## What's different from the full version

- **No database.** The contact form sends an email and that's it — nothing
  is stored or listed anywhere. If your inbox fills up and you need a proper
  leads list, that's the signal to move to the full version.
- **No admin login / leads dashboard** — nothing to log into.
- **No BROX Launchpad pages** — no founder submissions or investor listings.
- **Job applications are emailed, not stored.** The Careers page sends each
  application (with the CV attached) to `ADMIN_EMAIL`. There's no applicant
  list to review later, so if an email fails to send, that application is
  gone — failures are logged to `storage/logs/php-error.log`. CVs are capped
  at 4 MB and limited to PDF/DOC/DOCX.
- **Simpler contact form** — name, email, company, service checkboxes, and a
  message box. The full version's budget/timeline/product-type fields were
  dropped to keep this version genuinely simple.
- **Rate limiting is file-based instead of database-based** — a small JSON
  file per visitor IP under `storage/ratelimits/`, locked with `flock()` so
  concurrent requests can't race each other. Good enough for a low-traffic
  contact form on one server. The full version's DB-backed version
  (`rate_limits` table) is a drop-in upgrade if you ever need it.
- Still has: CSRF protection, a honeypot field, input validation, and
  HTML-escaping everywhere user input is displayed or emailed — the same
  security posture as the full version, just without the parts that need a
  database to exist.

## Editing the styles

`public/assets/css/app.css` is a compiled Tailwind bundle and is committed, so
the site runs with no build step. If you change any class in a `.php` file,
rebuild it:

```
npm install
npx tailwindcss -i src/input.css -o public/assets/css/app.css --minify
```

Skipping the rebuild means new classes simply have no styles.

## Testing performed

Verified locally with PHP's built-in server (PHP 8.4, mbstring + openssl on):
all four pages return 200 with no database configured, and both the contact
form and the job application form succeed end-to-end.

Rejection paths confirmed on the application endpoint: CSRF mismatch returns
403; an unknown role id, an invalid email, and a too-short message each return
400 with a specific message; a `.exe` attachment, malformed base64, and a 5 MB
file are each rejected; and the honeypot field returns a fake success without
sending. The per-IP rate limiter was confirmed to allow 5 applications and
return 429 on the 6th.

A CV filename containing `"` and CRLF was confirmed to be sanitised before
reaching the MIME headers in `mailer.php`, which interpolates the filename
without escaping it. Note that sanitising replaces non-ASCII characters with
underscores, so an Arabic or accented filename arrives readable but altered.
