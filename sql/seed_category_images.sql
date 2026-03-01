-- ============================================================
-- seed_category_images.sql
-- Add AI-generated images to all 20 cleaning categories
-- Images hosted on Cloudflare R2 CDN
-- ============================================================

UPDATE categories SET image = 'https://pub-532352f22580429d98f84286f6a24fd4.r2.dev/cleaners/images/cat-house-cleaning.webp' WHERE slug = 'house-cleaning';
UPDATE categories SET image = 'https://pub-532352f22580429d98f84286f6a24fd4.r2.dev/cleaners/images/cat-commercial-cleaning.webp' WHERE slug = 'commercial-cleaning';
UPDATE categories SET image = 'https://pub-532352f22580429d98f84286f6a24fd4.r2.dev/cleaners/images/cat-carpet-cleaning.webp' WHERE slug = 'carpet-cleaning';
UPDATE categories SET image = 'https://pub-532352f22580429d98f84286f6a24fd4.r2.dev/cleaners/images/cat-pressure-washing.webp' WHERE slug = 'pressure-washing';
UPDATE categories SET image = 'https://pub-532352f22580429d98f84286f6a24fd4.r2.dev/cleaners/images/cat-window-cleaning.webp' WHERE slug = 'window-cleaning';
UPDATE categories SET image = 'https://pub-532352f22580429d98f84286f6a24fd4.r2.dev/cleaners/images/cat-move-in-move-out-cleaning.webp' WHERE slug = 'move-in-move-out-cleaning';
UPDATE categories SET image = 'https://pub-532352f22580429d98f84286f6a24fd4.r2.dev/cleaners/images/cat-deep-cleaning.webp' WHERE slug = 'deep-cleaning';
UPDATE categories SET image = 'https://pub-532352f22580429d98f84286f6a24fd4.r2.dev/cleaners/images/cat-office-cleaning.webp' WHERE slug = 'office-cleaning';
UPDATE categories SET image = 'https://pub-532352f22580429d98f84286f6a24fd4.r2.dev/cleaners/images/cat-post-construction-cleanup.webp' WHERE slug = 'post-construction-cleanup';
UPDATE categories SET image = 'https://pub-532352f22580429d98f84286f6a24fd4.r2.dev/cleaners/images/cat-pool-cleaning.webp' WHERE slug = 'pool-cleaning';
UPDATE categories SET image = 'https://pub-532352f22580429d98f84286f6a24fd4.r2.dev/cleaners/images/cat-janitorial-services.webp' WHERE slug = 'janitorial-services';
UPDATE categories SET image = 'https://pub-532352f22580429d98f84286f6a24fd4.r2.dev/cleaners/images/cat-upholstery-cleaning.webp' WHERE slug = 'upholstery-cleaning';
UPDATE categories SET image = 'https://pub-532352f22580429d98f84286f6a24fd4.r2.dev/cleaners/images/cat-air-duct-cleaning.webp' WHERE slug = 'air-duct-cleaning';
UPDATE categories SET image = 'https://pub-532352f22580429d98f84286f6a24fd4.r2.dev/cleaners/images/cat-tile-grout-cleaning.webp' WHERE slug = 'tile-grout-cleaning';
UPDATE categories SET image = 'https://pub-532352f22580429d98f84286f6a24fd4.r2.dev/cleaners/images/cat-hoarding-cleanup.webp' WHERE slug = 'hoarding-cleanup';
UPDATE categories SET image = 'https://pub-532352f22580429d98f84286f6a24fd4.r2.dev/cleaners/images/cat-green-eco-cleaning.webp' WHERE slug = 'green-eco-cleaning';
UPDATE categories SET image = 'https://pub-532352f22580429d98f84286f6a24fd4.r2.dev/cleaners/images/cat-vacation-rental-cleaning.webp' WHERE slug = 'vacation-rental-cleaning';
UPDATE categories SET image = 'https://pub-532352f22580429d98f84286f6a24fd4.r2.dev/cleaners/images/cat-restaurant-cleaning.webp' WHERE slug = 'restaurant-cleaning';
UPDATE categories SET image = 'https://pub-532352f22580429d98f84286f6a24fd4.r2.dev/cleaners/images/cat-medical-facility-cleaning.webp' WHERE slug = 'medical-facility-cleaning';
UPDATE categories SET image = 'https://pub-532352f22580429d98f84286f6a24fd4.r2.dev/cleaners/images/cat-garage-warehouse-cleaning.webp' WHERE slug = 'garage-warehouse-cleaning';
