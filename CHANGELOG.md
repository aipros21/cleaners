# FindMyCleaner — Development Changelog

**Site:** https://cleaners-247.com
**Repo:** https://github.com/gmzgit21/cleaners
**Stack:** PHP 8+, MySQL, Bootstrap 4, cPanel hosting
**Deployment:** GitHub Actions FTP (auto on push to main)

---

## Phase 1 — Initial Build & Security Hardening (Feb 16, 2026)

### Security & Core Fixes
- **Lead form fix** — critical form submission was broken; fixed validation and processing
- **Security hardening** — CSRF protection, input sanitization, XSS prevention across all forms
- **Production error config** — `display_errors=0`, proper error logging, no leaking to users
- **Newsletter field fix** — fixed broken email subscription in footer
- **Password reset** — validated token expiry, fixed reset flow
- **Stripe helper** — added placeholder integration for future payment processing
- **reCAPTCHA v2→v3 migration** — invisible reCAPTCHA on all forms (contact, get-quotes, registration)
- **Password strength meter** — added to cleaner registration form

### SEO Implementation
- **Google Analytics** — enabled with tracking ID `G-796SX09N7Q`
- **Google Search Console** — verification meta tag added
- **Sitemap** — dynamic `sitemap.xml` generated from DB (all pages, blog posts, cleaner profiles, categories)
- **robots.txt** — allows all crawlers; blocks `/api/`, `/includes/`, `/dashboard/`, `/admin/`, `/sql/`
- **Canonical URLs** — proper `<link rel="canonical">` on all pages
- **Trailing slash redirect** — 301 redirect for consistency
- **noindex** — applied to login, register, search, 404, 403, 500 pages
- **Schema.org markup** — Organization, BreadcrumbList, FAQ, LocalBusiness, Review schemas
- **FAQ page** — created with structured data (FAQ schema)
- **Related posts** — added to blog post pages
- **Blog reading time** — estimated reading time displayed on posts
- **Image alt tags** — meaningful alt text on all images
- **404 tracking** — logs 404 hits for monitoring broken links
- **State landing pages** — SEO content for state-level cleaner browsing

### Visual & Content
- **Homepage category cards** — added image cards to "Browse by Category" section
- **Cleaner demo images** — added trade-specific Unsplash images to all 52 demo cleaners (logos, covers, portfolio photos)
- **Default blog image** — fallback `blog-default.webp` for posts without featured images
- **Minified CSS/JS assets** — performance optimization

---

## Phase 2 — Admin Panel & UI Polish (Feb 16–17, 2026)

### Admin Panel Fixes
- **Admin layout broken** — dashboard.css wasn't loading; fixed include path
- **Admin routes intercepted** — `.htaccess` state landing page rule was catching `/admin/*` URLs; added exclusion
- **Locations page SQL error** — query referenced nonexistent `state_id`/`city_id` columns; fixed to use correct column names
- **Chart.js v3 compatibility** — updated admin dashboard charts from v2 to v3 API
- **Slug auto-generation** — fixed JS slug check on category/page editors
- **Toggle icons** — fixed broken toggle buttons in admin lists
- **mainForm reference error** — fixed undefined form reference in admin JS

### Admin User Management (NEW)
- **Created `/admin/admins.php`** — full CRUD for admin users
  - List all admins with status, last login, creation date
  - Create new admin (modal form with validation)
  - Edit admin (name, email, password — modal form)
  - Reset password (dedicated modal)
  - Activate / Suspend toggle
  - Delete admin (with confirmation)
  - Self-protection: cannot suspend/delete own account
  - "You" badge on current user's row
  - Activity logging for all operations
- **Added to sidebar** — Admins link with separator at bottom of admin nav

### Navigation & UI Fixes
- **Admin sidebar links** — changed from muted gray (#a0a0b0) to white (#e0e0e0) for readability
- **Admin top navbar** — made links fully white (#ffffff) with bold weight, green hover (#55efc4)
- **"Get Free Quotes" button** — fixed text wrapping to two lines in navbar; added `white-space:nowrap`
- **Cleaner profile hero** — company info was pushed to bottom overlapping thumbnail; centered content, increased height from 320px to 380px with proper padding

### Contact Page
- **Hero face cropping** — image was cutting off the support lady's face; added `object-position:top`
- **Hero size** — increased from 300px to 450px max-height to show more of the image

### Blog
- **Unique featured images** — all 10 blog posts had NULL images (showing same default); updated DB with topic-specific Unsplash photos:
  1. Roofing — roof repair workers
  2. Kitchen Remodel — modern kitchen with marble island
  3. HVAC — outdoor AC unit
  4. General Cleaner — construction professional
  5. Bathroom Remodel — modern bathroom
  6. Licensing — signing contract/paperwork
  7. Home Improvement — renovation project
  8. Emergency Plumber — plumbing work
  9. DIY vs Pro — workshop with tools
  10. Getting Quotes — business handshake

---

## Phase 3 — Cloudflare R2 Image Storage (Feb 17, 2026)

### Upload System Rewrite
- **Switched from Cloudflare Images to Cloudflare R2** — the old CF Images API had placeholder credentials and was non-functional
- **Rewrote `includes/inc_upload.php`** — pure PHP implementation using:
  - AWS Signature V4 signing (no external dependencies)
  - S3-compatible PUT requests to R2
  - Organized file paths by type:
    - `cleaners/{id}/portfolio/{file}` — portfolio photos
    - `cleaners/{id}/logo/{file}` — company logos
    - `cleaners/{id}/cover/{file}` — cover images
    - `blog/{file}` — blog post images
    - `banners/{file}` — site banners
    - `categories/{file}` — category images
    - `pages/{file}` — static page images
  - Unique filenames via `random_bytes(12)` hex
  - Content-type detection via `mime_content_type()`
  - Upload from URL support (downloads then uploads to R2)
  - Delete support
- **Backwards-compatible aliases** — `upload_to_cloudflare_images()`, `delete_cloudflare_image()`, `cf_image_url()` all still work, redirecting to R2 functions
- **8 pages use uploads** — all work without modification:
  - `dashboard/photos.php` — cleaner portfolio
  - `dashboard/profile.php` — logo and cover image
  - `admin/cleaner-edit.php` — admin cleaner editing
  - `admin/blog-edit.php` — blog featured images
  - `admin/banner-edit.php` — site banners
  - `admin/category-edit.php` — category images
  - `admin/page-edit.php` — static page images

### R2 Configuration
- **Bucket:** `cleaners`
- **Public URL:** `https://pub-1889522084704718a7eace6b130b9c7b.r2.dev`
- **Credentials:** stored in `.env` on server (R2_ACCOUNT_ID, R2_ACCESS_KEY_ID, R2_SECRET_ACCESS_KEY, R2_BUCKET_NAME, R2_PUBLIC_URL)
- **GitHub secrets:** R2 credentials also stored on the `gmzgit21/cleaners` repo for future workflow use
- **Tested:** upload and delete verified working from cleaner dashboard

---

## Current State & Known Limitations

### Working
- Full public website with SEO (sitemap, schema, analytics, search console)
- Cleaner registration, login, dashboard
- Admin panel with full management (cleaners, customers, leads, reviews, blog, categories, locations, banners, pages, settings, activity log, reports, admins)
- Photo uploads via Cloudflare R2
- Contact form with reCAPTCHA v3
- Get quotes / lead system
- Blog with 10 published posts

### Not Yet Configured
- **Stripe payments** — keys are `sk_test_placeholder` / `pk_test_placeholder`; subscription and sponsored placement features are built but non-functional
- **Mailgun email** — API key is set but delivery not verified
- **Cloudflare Images** — removed in favor of R2 (old CF_ACCOUNT_ID/CF_IMAGES_API_TOKEN no longer needed)

### Credentials & Access
- **Admin panel:** https://cleaners-247.com/admin
- **Deployment:** auto on push to `main` branch via GitHub Actions FTP
- **Database:** MySQL on 142.11.204.39 (credentials in `.env`)
- **R2 bucket:** `cleaners` on Cloudflare account 907575d3124d57e96fdd0af96c22bd31

---

## Git Commits (chronological)

```
4d2fb7d Security & UX improvements
9dcaf33 Add default blog image for posts without featured images
3200572 Add password strength meter to cleaner registration
6d35699 Migrate reCAPTCHA from v2 to v3 across all forms
26fca79 Add trade-specific demo images to all 52 cleaners
9b260d8 Add image cards to Browse by Category section on homepage
5abadcb SEO quick wins: minify assets, noindex 404, dynamic sitemap, related posts, review schema
3d15bd8 Fix sitemap rewrite: move before static file check
ad71276 SEO medium impact: reading time, image alt tags, 404 tracking, state content
2a0ed7d Add Google Search Console verification meta tag
9ac6c73 Enable Google Analytics with fallback ID G-796SX09N7Q
4af3569 SEO: trailing slash redirect, FAQ page with schema, noindex error pages
6067772 SEO: noindex auth/search pages, fix canonicals, add schema, cleanup
c650fcb Fix critical lead form, security hardening, performance & accessibility
59497e5 Fix newsletter field, validate reset token, production error config, Stripe helper
ac6eb5e Fix admin panel bugs: mainForm, Chart.js v3, slug checks, toggle icons
3459436 Fix admin layout: load dashboard.css for sidebar styles
2353995 Fix admin/dashboard routes intercepted by state landing rule
beeee18 Fix locations page: use state_id/city_id instead of nonexistent columns
da0b1c3 Add admin user management page and fix nav readability
be3bc62 Make top navbar links fully white with bold weight
2ab900a Add password field to admin edit modal
e221617 Fix Get Free Quotes button text wrapping in navbar
528bc98 Fix cleaner profile hero: center content instead of bottom-aligned
57d3f7b Increase profile hero height and add bottom padding for better spacing
4166d89 Switch file uploads from Cloudflare Images to Cloudflare R2
4588333 Fix contact hero face cropping and add unique blog post images
2e78845 Increase contact hero image height from 300px to 450px
```
