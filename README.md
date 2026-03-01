# FindMyCleaner

**URL**: https://cleaners-247.com
**Repo**: aipros21/cleaners
**Hosting**: cPanel shared hosting (142.11.204.39), FTP deploy via GitHub Actions
**Stack**: PHP 8+ / MySQL / Bootstrap 4 / jQuery

---

## What Was Built (Feb 16, 2026)

### Phase 1: Foundation & Database
- **18 database tables**: users, cleaners, categories, states, cities, cleaner_categories, cleaner_photos, cleaner_specialties, cleaner_discounts, cleaner_service_areas, leads, lead_assignments, reviews, banners, sponsored_listings, pages, payments, settings
- **7 SQL seed files**: schema, 20 categories, 51 states (50 + DC), 209 cities, 30 site settings, 52 demo cleaners, 168 demo reviews, 10 blog posts
- **Core includes**: env loader, PDO database singleton, auth/session management, helpers, Mailgun email, Stripe payments, R2 uploads, reCAPTCHA, schema.org markup, banner system
- **CSS**: Main stylesheet + dashboard.css + admin.css (Blue #1A73E8 + Green #34A853 color scheme)
- **JS**: Main script + dashboard.js + admin.js
- **.htaccess**: Clean URL rewrites, HTTPS redirect, security headers, caching

### Phase 2: Public Pages
- **Homepage** (`index.php`): Hero with search, 20 category cards, featured cleaners, how-it-works, testimonials, CTA
- **Directory** (`cleaners.php`): Handles `/cleaners/`, `/cleaners/{category}/`, `/cleaners/{category}/{state}/`, `/cleaners/{category}/{city}-{state}/`. Card grid with pagination, sidebar filters, sponsored placements
- **Cleaner Profile** (`cleaner-profile.php`): Full profile with gallery, reviews, badges, map, quote CTA, JSON-LD schema
- **Lead Form** (`get-quotes.php`): Multi-step form (category → details → contact info), honeypot + reCAPTCHA
- **Search** (`search.php`): FULLTEXT search across cleaners + blog
- **State Landings** (`state-landing.php`): `/{state}/cleaners/` SEO pages
- **Blog** (`blog.php`, `blog-single.php`): Card grid listing + single post with sidebar
- **Auth**: Login, register, join (cleaner signup), forgot/reset password
- **Static Pages**: About, contact, pricing (4 plans: Free/$29/$79/$149), privacy, terms, 404
- **API Handlers**: login, register, lead submission, reviews, contact form, search autocomplete

### Phase 3: Cleaner Dashboard
- **10 dashboard pages**: Home (stats + recent leads), profile editor, photo gallery (Dropzone uploads), specialties, discounts, leads management, reviews + responses, subscription (Stripe Checkout), sponsored listings, account settings
- Sidebar navigation, stat cards, responsive layout

### Phase 4: Admin Panel
- **16 admin pages**: KPI dashboard (Chart.js), cleaner management, customer management, leads table + detail view, review moderation, banner ad management, sponsored listings, category editor, locations viewer, blog post editor, static pages editor, site settings, activity log, revenue reports
- Full CRUD operations, filters, search, pagination

### Phase 5: Demo Data
- 52 cleaners across 20 categories and 10+ states
- 168 reviews (realistic distribution: 60% 5-star, 25% 4-star, 10% 3-star, 5% 1-2 star)
- 10 SEO blog posts (hiring tips, cost guides)
- Admin account seeded

---

## Bugs Fixed

| Issue | Root Cause | Fix |
|-------|-----------|-----|
| `session_start()` after headers sent | `inc_auth.php` called `session_start()` but was included after HTML output began | Moved `session_start()` to `inc_db.php` (included before any output) |
| Hero search bar unclickable | `.container` inside hero had no z-index, sat behind `::before` overlay (z-index:1) | Added `.hero-section > .container { position: relative; z-index: 2; }` |
| Featured cleaner cards misaligned | HTML used `.cleaner-card-img` but CSS expected `.card-image` | Aligned HTML classes to match CSS; added flex utilities for equal heights |
| Colors unprofessional | Blue scheme didn't look right | Redesigned to Charcoal (#2d3436) + Emerald (#00b894) across 24 files |
| Navigation messy | Mega-menu CSS expected `.mega-menu-column` but HTML used Bootstrap dropdown classes | Rewrote header with clean Bootstrap dropdown (2-col, 540px); fixed `::after` underline excluding dropdown items |

---

## Next Steps

### Critical (Site Won't Fully Work Without These)

1. **Upload `.env` to server** via cPanel File Manager
   - Path: `/home/wvcxpdzy/public_html/cleaners-247.com/.env`
   - Change `DB_HOST=localhost` (not the external IP)
   - All other values same as local `.env`

2. **Mailgun DNS setup** for cleaners-247.com
   - Add SPF record: `v=spf1 include:mailgun.org ~all`
   - Add DKIM record (get from Mailgun dashboard)
   - Add MX records for receiving (if needed)
   - Verify domain in Mailgun dashboard

3. **reCAPTCHA keys** — Register cleaners-247.com at https://www.google.com/recaptcha/admin
   - Get site key + secret key
   - Update `.env` on server

### Important (Revenue Features)

4. **Stripe real keys** — Switch from test to live keys when ready
   - Update `STRIPE_SECRET_KEY`, `STRIPE_PUBLISHABLE_KEY`, `STRIPE_WEBHOOK_SECRET` in `.env`
   - Set up webhook endpoint in Stripe dashboard: `https://cleaners-247.com/api/stripe_webhook.php`

5. **Cloudflare R2 setup** for image uploads
   - Configure R2 bucket credentials in `.env`
   - Currently using placeholder images

### Visual Polish

6. **Replace placeholder images with AI-generated ones**
   - 20 category hero images
   - 50 cleaner logos
   - 130 portfolio photos
   - 5 site banners
   - Use Ideogram/Gemini workflow

7. **Cross-browser testing** — Test on Chrome, Safari, Firefox, mobile
8. **Google Lighthouse audit** — Target 90+ performance, 95+ SEO
9. **Sitemap generation** — Run `sitemap-generator.php` and submit to Google Search Console

### SEO

10. **Google Search Console** — Verify domain, submit sitemap
11. **Google Business Profile** — If applicable
12. **Schema markup validation** — Test with Google Rich Results Test
13. **Blog content strategy** — Regular posts targeting "cleaners near me" keywords

---

## File Structure (103 files)

```
cleaners/
├── .env                    # Credentials (not in repo)
├── .htaccess               # URL rewrites + security
├── index.php               # Homepage
├── cleaners.php         # Directory listings
├── cleaner-profile.php  # Individual profiles
├── get-quotes.php          # Lead capture form
├── search.php              # Search results
├── state-landing.php       # State SEO pages
├── blog.php / blog-single.php
├── login.php / join.php / register.php
├── forgot-password.php / reset-password.php
├── about.php / contact.php / pricing.php
├── privacy-policy.php / terms.php / 404.php
├── robots.txt / sitemap-generator.php
│
├── includes/
│   ├── inc_env.php         # .env loader
│   ├── inc_db.php          # PDO + session_start
│   ├── inc_auth.php        # Auth + CSRF
│   ├── inc_head.php        # <head> with meta/OG
│   ├── inc_header.php      # Top bar + nav
│   ├── inc_footer.php      # Footer + scripts
│   ├── inc_helpers.php     # Utility functions
│   ├── inc_schema.php      # JSON-LD markup
│   ├── inc_mailgun.php     # Email via Mailgun
│   ├── inc_recaptcha.php   # reCAPTCHA verify
│   ├── inc_stripe.php      # Stripe API
│   ├── inc_upload.php      # R2 image uploads
│   └── inc_banners.php     # Banner ad rendering
│
├── api/
│   ├── handle_login.php / handle_register.php
│   ├── handle_lead.php / handle_review.php
│   ├── handle_contact.php / handle_search.php
│   ├── stripe_checkout.php / stripe_webhook.php
│
├── dashboard/              # Cleaner dashboard (10 pages)
├── admin/                  # Admin panel (16 pages)
├── css/                    # style.css, dashboard.css, admin.css
├── js/                     # script.js, dashboard.js, admin.js
├── sql/                    # Schema + 6 seed files
├── images/                 # Placeholder assets
└── plugins/                # Bootstrap, jQuery, etc.
```

---

## Database

- **Server**: 142.11.204.39 (localhost from cPanel)
- **Database**: wvcxpdzy_contrau3k4jh534j5h
- **Tables**: 18
- **Demo data**: 53 users, 52 cleaners, 20 categories, 51 states, 209 cities, 168 reviews, 10 blog posts

## Deploy

Push to `main` branch triggers GitHub Actions → FTP deploy to cPanel. Deploys in ~25 seconds.
