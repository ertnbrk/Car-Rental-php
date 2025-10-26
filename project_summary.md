# Car Rental PHP – Project Summary

## Overview
- A simple car rental website built with plain PHP, PDO (MySQL), Bootstrap, jQuery, and Owl Carousel.
- Public features: home slider, fleet listing with currency info, testimonials, team, static/dynamic pages, contact form, registration/login, and a reservation modal.
- Admin features: dashboard, manage cars, slider images, testimonials, team, pages, offers/discounts, and view incoming contact messages and active orders.

## Technology Stack
- Language: PHP 8.x (plain PHP, no framework)
- Database: MySQL (schema dump in `components/ip-g__z-final.sql`)
- DB Access: PDO with prepared statements (mixed quality)
- Frontend: Bootstrap, jQuery, Owl Carousel; static assets under `css/`, `js/`, `images/`, `fonts/`
- Sessions: PHP sessions, started within `components/navbar.php`
- External dependency: Live FX rates pulled from TCMB XML (`https://www.tcmb.gov.tr/kurlar/today.xml`) in `fleet.php`

## Architecture
- Structure: Page-per-script, mixing PHP, HTML, and SQL in the same files (no MVC).
- Includes: Shared pieces in `components/` (navbar, footer, contact form, DB connection).
- Routing: Direct PHP files (e.g., `index.php`, `fleet.php`, `page.php`, `login.php`, `register.php`, `admin.php`).
- State: Session-driven authorization flags (`$_SESSION['user']`, `$_SESSION['admin']`).
- Configuration: Hardcoded DB credentials in `components/connection.php`.

## Data Model (from SQL dump)
- `cars(id, names, years, images, capacity, Kapi, Bagaj, Vites, ozellik, Fiyat, miktar)`
- `orders(customer_id, Customer_name, Customer_num, delivered_loc, return_loc, return_date, deliver_date, car, indirim)`
- `pages(id, title, summary, content, order)`
- `testimonials(counts, names, title, images, comment, star)`
- `team(id, isim, soyisim, Pozisyon, images)`
- `slider(idslider, resim)`
- `contact(id, fullname, email, messag)`
- `offers(teklif, kosul, aktif)`
- `Uye` (user table; referenced in code as `A...` due to encoding issues): fields include TC, Ad, Soyad, Telefon, Adres, Mail, Sifre, and `admin` flag.

## Key Business Logic
- Home Slider (`index.php`)
  - Loads all slides from `slider` and renders carousel.
- Dynamic Pages Menu (`components/navbar.php`)
  - Builds “More” dropdown from `pages` table, special-casing the contact page.
- Testimonials/Team (`index.php`, `page.php`)
  - Lists testimonials and team members from DB (star rating rendered as icons).
- Fleet Listing & Reservation (`fleet.php`)
  - Fetches USD/EUR FX rates live from TCMB XML.
  - Shows available cars (`cars.miktar > 0`).
  - Reads active offer (`offers.aktif = 1`) and, for logged-in users, applies a discount every `kosul`-th order: front-end price label uses `%teklif` off; server inserts `indirim` field into `orders`.
  - Cleanup on each page load: any orders with `return_date < today` increment the car stock and delete those orders.
  - Reservation form posts into the same page; on submit:
    - If logged out, captures PII (name, TC, email, phone) from the form.
    - If logged in, pulls PII from session.
    - Validates only that `deliver_date <= return_date`; inserts to `orders`; decrements `cars.miktar`.
- Auth (`register.php`, `login.php`, `logout.php`)
  - Register: inserts new user with SHA1 password; immediately logs user in by setting session values and meta-refresh to `index.php`.
  - Login: checks user by TC and `sha1(password)`; sets `$_SESSION['admin']='1'` if user has admin flag; meta-refresh to `index.php`.
  - Logout: destroys session and redirects to home.
- Admin (`admin.php`)
  - Dashboard counts: active rentals, contact messages.
  - Manage cars (CRUD), team (CRUD), slider (CRUD), testimonials (CRUD), pages (CRUD), offers (toggle/values), read contact messages, view active orders (JOINed with cars).

## Current Problems and Risks

Development/Architecture
- Mixed concerns: business logic, SQL, presentation tightly coupled across large monolithic files.
- `session_start()` inside the navbar include causes header redirects to fail in multiple places; comments confirm header() issues, leading to meta-refresh hacks.
- Hardcoded DB credentials and schema name in `components/connection.php`.
- Character encoding is inconsistent: mis-encoded Turkish characters across UI and SQL dump, pointing to file encodings or wrong connection charset handling.
- Incomplete/buggy code left in `fleet.php` (`$musteri = $conn->prepare("SELECT * FROM orders WHERE ")`).
- Fragile date logic: concatenating `'20' . date('y-m-d')` to force 4-digit years.
- Live FX fetch on every fleet page load; no timeout, error handling, or caching.
- Admin gating happens after rendering navbar output; `header()` redirect can fail due to prior output.

Security
- Weak password hashing (SHA1) and password pre-filled as "root" in forms; stores raw password in session on register.
- Credentials hardcoded (`root`/`123456`), local host/DB visible in repo.
- No CSRF protection on any POST forms (admin and public).
- Client-controlled pricing: hidden `fiyat` input is trusted on the client; no server-side price calculation or verification.
- Potential XSS: many DB fields (pages content, testimonials, names) are echoed unescaped into HTML.
- File uploads in admin (images) appear to lack strong MIME/extension validation and size limits (based on patterns; verify in admin code thoroughly).
- Session fixation/management not hardened (no regenerate on login, no cookie flags, no inactivity expiry).
- Authorization is coarse: checks only `$_SESSION['admin'] == '1'`; no per-action authorization in admin.

Data Integrity
- Business actions not wrapped in DB transactions (e.g., order insert + stock decrement could become inconsistent on failure).
- Reservation availability is stock-based but lacks temporal conflict checks; multiple overlapping orders for the same physical car can occur as long as stock > 0.
- No server-side normalization/validation for dates/locations/IDs beyond basic presence.

Reliability/Operations
- No error handling strategy/logging; echoes on DB connection failure and dies.
- No configuration by environment; production secrets would require code edits.
- No caching layer for frequently read content or FX rates.

Product/Business Gaps
- Privacy/consent and terms are shown but not enforced consistently; no audit trail of consent.
- Uses TC identity number as username and stores PII broadly; no data minimization.
- No email/SMS verification, password reset, or account management flows.
- No booking confirmation flow, payment integration, invoices, or cancellation policy handling.
- Localization/i18n inconsistent and mis-encoded text degrades UX and trust.

## Developer Mistakes (Observed)
- Redirects after output due to where `session_start()`/includes are placed; reliance on meta refresh.
- SHA1 for passwords; storing plain password in session on register.
- Trusting client-side values for price and discount calculations.
- Incomplete SQL code left in production script.
- Encoding misconfigurations (files/DB/headers mismatch).
- Admin authorization check positioned after output; can be bypass-prone if headers already sent.
- Excessive logic in one file (`admin.php` ~50KB) without separation or tests.

## Business Mistakes (Observed)
- No clear pricing currency/locale handling; FX pulled but used only for display, not for pricing rules.
- Discount logic is opaque to users; applies every Nth order but not clearly communicated.
- No verified communication channel; contact submissions stored but no follow-up mechanism.
- Legal pages exist but consent capture is inconsistent; no unsubscribe or data deletion mechanisms.

## How To Improve and Make Production-Ready

Foundations
- Adopt a framework (Laravel/Symfony) or implement a clean MVC structure. Extract controllers, models, views, and services.
- Configuration via environment (`.env`, dotenv) and secrets management; remove hardcoded credentials from VCS.
- Normalize encoding: save all PHP files as UTF-8 (no BOM), set `charset=utf8mb4` in DSN and connection attributes, ensure DB/tables use `utf8mb4`.
- Centralize session/auth with middleware; move `session_start()` and auth checks to front controller and guard routes before output.

Security & Auth
- Replace SHA1 with `password_hash()`/`password_verify()`; migrate existing hashes.
- Regenerate session ID on login; set secure cookie flags (HttpOnly, Secure, SameSite=Lax/Strict) and idle/absolute timeouts.
- Add CSRF tokens to all forms (including admin) and server-side validate.
- Server-side validation and output escaping (e.g., use `htmlspecialchars()` or templating engine auto-escape).
- Recompute pricing server-side using authoritative car and offer data; ignore any price coming from the client.
- Harden file uploads: allowlist MIME/types, size limits, random filenames outside web root, scan if needed.
- Role-based authorization per admin section.

Data & Business Logic
- Use DB transactions when inserting orders and decrementing stock; add constraints (FKs, NOT NULLs) and indexes.
- Replace stock-only availability with reservation calendars per car SKU; prevent overlapping bookings.
- Add order states (pending/confirmed/cancelled/returned) and background jobs to handle expirations.
- Implement proper discount engine with clear rules and audit logs.

Reliability & Ops
- Add error handling and logging (Monolog); display friendly errors; hide stack traces in production.
- Cache FX rates with TTL and graceful fallback if the central bank is unreachable.
- Introduce migrations and seeders (e.g., Laravel migrations) instead of raw dumps.
- Automated tests (unit/feature) for auth, bookings, pricing, and admin CRUD.
- CI/CD pipeline: linting, static analysis (PHPStan/Psalm), tests, build, and deploy.
- Containerization (Docker) or standard runtime setup; Nginx + PHP-FPM; HTTPS by default.

Product & Compliance
- User management flows: email verification, password reset, profile management.
- PII and consent handling compliant with KVKK/GDPR; data retention and deletion tools.
- Notifications: booking confirmations and reminders via email/SMS provider.
- Multi-language/i18n with proper locale files.

Quick Wins (Minimal Changes In-Place)
- Move `session_start()` and admin guard before any output; remove meta-refresh in favor of `header()` redirects.
- Switch to `utf8mb4` across code and DB; fix garbled text.
- Replace SHA1 with `password_hash()`; stop storing plaintext password in session.
- Add CSRF tokens and server-side validation to critical forms.
- Compute and validate price on the server; ignore hidden `fiyat`.
- Wrap reservation insert + stock decrement in a transaction.
- Add basic try/catch + logging around external FX fetch with caching.

## File Pointers for Reference
- DB connection: `components/connection.php:1`
- Navbar/session start and dynamic menu: `components/navbar.php:1`
- Home page slider/testimonials: `index.php:1`
- Fleet and reservations: `fleet.php:1` and `fleet.php` (modal/form handling near end)
- Pages rendering: `page.php:1`
- Auth: `login.php:1`, `register.php:1`, `logout.php:1`
- Admin dashboard and CRUD: `admin.php:1`
- Contact form and storage: `components/contactpackage.php:1`
- Schema dump: `components/ip-g__z-final.sql:1`

