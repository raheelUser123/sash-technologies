Sash Technologies form fix

Replace these live files:
1. /public_html/contact-handler.php
2. /public_html/contact.php
3. /public_html/schedule.php
4. /public_html/lead-capture-system.php
5. Your live main.js file (usually /public_html/assets/js/main.js)

Important:
- Keep config.php and config.local.php as they are.
- Keep /vendor/ installed.
- Clear browser/cache/CDN cache after replacing main.js.
- Test each form at least 20 seconds apart because FORM_RATE_LIMIT_SECONDS is 20.

What was fixed:
- All forms use a safer honeypot field.
- A Thank You redirect now happens only after admin email succeeds.
- ClickUp failure no longer blocks email success.
- The browser displays the actual email error while testing.
- Non-JSON PHP errors are detected instead of silently redirecting.
- Duplicate submissions are prevented.

After testing successfully, you may remove the email_error item from the final respond(false, ...) block in contact-handler.php so SMTP details are never shown to visitors.
