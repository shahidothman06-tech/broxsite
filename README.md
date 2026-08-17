# BROX Tech — Simple version (no database)

Three pages — Home, Services, Contact — with no database, no admin login, no
user accounts. The contact form emails you directly instead of storing leads
anywhere.

This is a trimmed-down version of the full BROX Tech PHP site. If you later
want the admin dashboard, lead storage, jobs page, or BROX Launchpad, use the
full version instead — this one intentionally leaves those out.

## Requirements

- PHP 8.1+ (that's it — no MySQL, no Composer, no Node.js needed to run it)

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
- **No Jobs or BROX Launchpad pages** — just Home, Services, Contact.
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

## Testing performed

Verified locally with PHP's built-in server: all three pages return 200 with
no database configured at all, contact form submission succeeds end-to-end,
CSRF-token mismatch correctly returns 403, missing/invalid fields correctly
return 400 with specific messages, an XSS payload in the message field was
confirmed to be escaped before being placed in the notification email body,
and the file-based rate limiter was confirmed to return 429 once the
per-IP threshold is hit (and confirmed to persist correctly across separate
server restarts, since it's file-backed rather than in-memory).
