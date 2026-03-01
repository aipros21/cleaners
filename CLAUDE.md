# FindMyCleaner Project Instructions

## Repository
- **Local Path**: `/Users/iprosauto/GitHub/cleaners/`
- **GitHub**: `https://github.com/aipros21/cleaners.git`
- **Domain**: cleaners-247.com

## Architecture
- PHP 8+ with includes pattern
- Bootstrap 4 + custom CSS
- MySQL database with PDO
- Mailgun API for transactional emails
- Stripe for subscription payments
- reCAPTCHA v3 for form protection
- .env file for configuration

## Key Files
- `index.php` - Homepage with hero search, categories, how-it-works, testimonials
- `cleaners.php` - Cleaner directory listing with filters
- `cleaner-profile.php` - Individual cleaner profile page
- `get-quotes.php` - Multi-step quote request form
- `join.php` - Cleaner registration landing page
- `register.php` - Registration form
- `login.php` - Login page
- `pricing.php` - Subscription plans
- `blog.php` / `blog-single.php` - Blog system (DB-driven)
- `state-landing.php` - State-specific landing pages
- `search.php` - Site search
- `sitemap-generator.php` - Dynamic XML sitemap

## Directories
- `includes/` - Shared PHP includes (header, footer, db, auth, helpers, mailgun, schema, etc.)
- `admin/` - Admin panel (cleaners, leads, reviews, banners, blog, categories, settings)
- `dashboard/` - Cleaner dashboard (profile, photos, leads, reviews, subscription, sponsored)
- `api/` - AJAX endpoints (search, lead, contact, review, login, register, stripe)
- `sql/` - Database schema and seed data
- `css/` - Stylesheets (style.css, admin.css, dashboard.css)
- `js/` - JavaScript (script.js, admin.js, dashboard.js)
- `plugins/` - Third-party libraries (Select2, Chart.js, Dropzone, Themify Icons)

## Cleaning Service Categories (20)
1. House Cleaning
2. Commercial Cleaning
3. Carpet Cleaning
4. Pressure Washing
5. Window Cleaning
6. Move-In/Move-Out Cleaning
7. Deep Cleaning
8. Office Cleaning
9. Post-Construction Cleanup
10. Pool Cleaning
11. Janitorial Services
12. Upholstery Cleaning
13. Air Duct Cleaning
14. Tile & Grout Cleaning
15. Hoarding Cleanup
16. Green/Eco Cleaning
17. Vacation Rental Cleaning
18. Restaurant Cleaning
19. Medical Facility Cleaning
20. Garage & Warehouse Cleaning

## Brand
- Company: FindMyCleaner
- Tagline: "Find Trusted Local Cleaners"
- Primary Color: #1A73E8 (blue)
- Secondary Color: #34A853 (green)
- Dark: #1B2838 (slate)
- Fonts: Inter (headings), Source Sans Pro (body)
- Email: info@cleaners-247.com

## URL Structure
- `/cleaners/` - All cleaners
- `/cleaners/{category}/` - By category
- `/cleaners/{category}/{state}/` - By category + state
- `/cleaner/{slug}/` - Individual profile
- `/get-quotes/` - Quote request
- `/get-quotes/{category}/` - Quote request pre-filtered
- `/{state}/cleaners/` - State landing page
- `/blog/` - Blog listing
- `/blog/{slug}/` - Blog post

## Deployment
- cPanel auto-deploys from GitHub main branch via FTP
- Changes pushed to GitHub are automatically live
