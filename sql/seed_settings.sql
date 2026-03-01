-- Default site settings
INSERT INTO `settings` (`setting_key`, `setting_value`, `setting_group`) VALUES
-- General
('site_name', 'FindMyCleaner', 'general'),
('site_tagline', 'Find Trusted Local Cleaners', 'general'),
('site_url', 'https://cleaners-247.com', 'general'),
('site_email', 'info@cleaners-247.com', 'general'),
('site_phone', '1-800-CLEAN-PRO', 'general'),
('site_address', 'Miami, FL', 'general'),
('site_description', 'FindMyCleaner connects homeowners and businesses with top-rated local cleaning professionals across 20 service categories. Get free quotes and hire with confidence.', 'general'),

-- Lead Pricing
('lead_price_default', '25.00', 'pricing'),
('lead_price_house_cleaning', '20.00', 'pricing'),
('lead_price_commercial_cleaning', '35.00', 'pricing'),
('lead_price_post_construction', '40.00', 'pricing'),
('lead_price_medical_facility', '40.00', 'pricing'),

-- Subscription Plans
('plan_basic_price', '29.00', 'plans'),
('plan_basic_leads', '10', 'plans'),
('plan_basic_photos', '10', 'plans'),
('plan_pro_price', '79.00', 'plans'),
('plan_pro_leads', '30', 'plans'),
('plan_pro_photos', '30', 'plans'),
('plan_premium_price', '149.00', 'plans'),
('plan_premium_leads', 'unlimited', 'plans'),
('plan_premium_photos', '50', 'plans'),

-- Free Plan Limits
('plan_free_leads', '3', 'plans'),
('plan_free_photos', '3', 'plans'),

-- Sponsored Listing Prices
('sponsored_price_weekly', '49.00', 'pricing'),
('sponsored_price_monthly', '149.00', 'pricing'),

-- SEO
('google_analytics_id', '', 'seo'),
('default_meta_title', 'FindMyCleaner - Find Trusted Local Cleaning Services', 'seo'),
('default_meta_description', 'Find top-rated local cleaning services for house cleaning, commercial cleaning, carpet cleaning, pressure washing, and more. Get free quotes from verified professionals near you.', 'seo'),

-- Email
('email_new_lead_subject', 'New Lead: {category} in {location}', 'email'),
('email_welcome_subject', 'Welcome to FindMyCleaner!', 'email');
