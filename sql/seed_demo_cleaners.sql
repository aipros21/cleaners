-- ============================================================
-- seed_demo_cleaners.sql
-- Demo cleaner data: 1 admin + 50 cleaners with users,
-- category assignments, and specialties
-- ============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ============================================================
-- ADMIN USER
-- ============================================================
INSERT INTO `users` (`email`, `password`, `role`, `first_name`, `last_name`, `phone`, `email_verified`, `status`) VALUES
('admin@cleaners-247.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'Admin', 'User', '305-555-0100', 1, 'active');

-- ============================================================
-- CLEANER USERS (50 users with role 'cleaner')
-- ============================================================
INSERT INTO `users` (`email`, `password`, `role`, `first_name`, `last_name`, `phone`, `email_verified`, `status`) VALUES
-- Florida cleaners (1-7)
('carlos.martinez@sunshineroofing.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Carlos', 'Martinez', '305-555-0101', 1, 'active'),
('james.wilson@metroplumbing.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'James', 'Wilson', '305-555-0102', 1, 'active'),
('maria.rodriguez@coastalkitchens.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Maria', 'Rodriguez', '786-555-0103', 1, 'active'),
('david.johnson@floridahvac.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'David', 'Johnson', '954-555-0104', 1, 'active'),
('anthony.garcia@palmelectrical.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Anthony', 'Garcia', '407-555-0105', 1, 'active'),
('robert.brown@tampabathrooms.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Robert', 'Brown', '813-555-0106', 1, 'active'),
('michael.thomas@gcflorida.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Michael', 'Thomas', '904-555-0107', 1, 'active'),

-- California cleaners (8-14)
('william.davis@bayarearoofing.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'William', 'Davis', '415-555-0108', 1, 'active'),
('daniel.lee@pacificplumbing.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Daniel', 'Lee', '310-555-0109', 1, 'active'),
('kevin.chen@socalpaint.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Kevin', 'Chen', '619-555-0110', 1, 'active'),
('brian.taylor@goldenstatehvac.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Brian', 'Taylor', '408-555-0111', 1, 'active'),
('steven.kim@ladeckspatios.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Steven', 'Kim', '213-555-0112', 1, 'active'),
('jason.nguyen@sftileandfloor.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Jason', 'Nguyen', '510-555-0113', 1, 'active'),
('richard.moore@sacramentofencing.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Richard', 'Moore', '916-555-0114', 1, 'active'),

-- Texas cleaners (15-21)
('mark.hernandez@lonestarroofing.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Mark', 'Hernandez', '713-555-0115', 1, 'active'),
('paul.smith@texashandyman.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Paul', 'Smith', '214-555-0116', 1, 'active'),
('donald.white@dallaskitchens.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Donald', 'White', '469-555-0117', 1, 'active'),
('jose.perez@austinhomereno.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Jose', 'Perez', '512-555-0118', 1, 'active'),
('andrew.jackson@satownelectric.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Andrew', 'Jackson', '210-555-0119', 1, 'active'),
('chris.lopez@texasconcrete.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Chris', 'Lopez', '817-555-0120', 1, 'active'),
('george.martinez2@houstonsiding.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'George', 'Martinez', '281-555-0121', 1, 'active'),

-- New York cleaners (22-26)
('frank.rossi@empireroofing.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Frank', 'Rossi', '212-555-0122', 1, 'active'),
('john.murphy@nycplumbing.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'John', 'Murphy', '718-555-0123', 1, 'active'),
('peter.sullivan@brooklynbath.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Peter', 'Sullivan', '917-555-0124', 1, 'active'),
('tom.kelly@buffaloinsulation.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Tom', 'Kelly', '716-555-0125', 1, 'active'),
('mike.oconnor@rochesterpainting.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Mike', 'O\'Connor', '585-555-0126', 1, 'active'),

-- Illinois cleaners (27-30)
('edward.kowalski@chicagoroofing.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Edward', 'Kowalski', '312-555-0127', 1, 'active'),
('tony.russo@windycityhvac.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Tony', 'Russo', '773-555-0128', 1, 'active'),
('matt.nowak@chicagoflooring.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Matt', 'Nowak', '630-555-0129', 1, 'active'),
('jim.brady@aurorahandyman.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Jim', 'Brady', '331-555-0130', 1, 'active'),

-- Georgia cleaners (31-33)
('derek.washington@peachtreebuilders.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Derek', 'Washington', '404-555-0131', 1, 'active'),
('marcus.hall@atlantagutters.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Marcus', 'Hall', '678-555-0132', 1, 'active'),
('leon.carter@savannahgarage.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Leon', 'Carter', '912-555-0133', 1, 'active'),

-- North Carolina cleaners (34-36)
('kevin.harris@charlotteremodel.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Kevin', 'Harris', '704-555-0134', 1, 'active'),
('alex.young@raleighdecks.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Alex', 'Young', '919-555-0135', 1, 'active'),
('travis.scott@durhambasements.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Travis', 'Scott', '984-555-0136', 1, 'active'),

-- Ohio cleaners (37-39)
('ryan.miller@buckeyeroofing.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Ryan', 'Miller', '614-555-0137', 1, 'active'),
('greg.clark@clevelandhvac.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Greg', 'Clark', '216-555-0138', 1, 'active'),
('sean.baker@cincinnatiplumbing.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Sean', 'Baker', '513-555-0139', 1, 'active'),

-- Pennsylvania cleaners (40-42)
('nick.campbell@phillyhomereno.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Nick', 'Campbell', '215-555-0140', 1, 'active'),
('dave.stewart@pittsburghelectric.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Dave', 'Stewart', '412-555-0141', 1, 'active'),
('pat.morgan@keystoneconcrete.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Pat', 'Morgan', '610-555-0142', 1, 'active'),

-- Arizona cleaners (43-45)
('ray.gonzalez@desertroofing.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Ray', 'Gonzalez', '602-555-0143', 1, 'active'),
('scott.turner@phoenixhvac.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Scott', 'Turner', '480-555-0144', 1, 'active'),
('adam.ramirez@tucsonhandyman.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Adam', 'Ramirez', '520-555-0145', 1, 'active'),

-- Washington cleaners (46-47)
('eric.anderson@seattledecks.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Eric', 'Anderson', '206-555-0146', 1, 'active'),
('tyler.wright@pugetsoundplumbing.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Tyler', 'Wright', '253-555-0147', 1, 'active'),

-- Colorado cleaners (48-49)
('ben.foster@milehighroofing.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Ben', 'Foster', '303-555-0148', 1, 'active'),
('luke.ward@denverinsulation.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Luke', 'Ward', '720-555-0149', 1, 'active'),

-- New Jersey (50)
('sam.diaz@gardenstatepainting.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Sam', 'Diaz', '201-555-0150', 1, 'active'),

-- Virginia (51)
('craig.reed@virginiabuilders.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Craig', 'Reed', '757-555-0151', 1, 'active'),

-- Massachusetts (52)
('ian.burke@bostonbathremodel.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Ian', 'Burke', '617-555-0152', 1, 'active');


-- ============================================================
-- CLEANER PROFILES (50 cleaners)
-- ============================================================

-- Florida cleaners (1-7)
INSERT INTO `cleaners` (`user_id`, `business_name`, `slug`, `tagline`, `description`, `phone`, `email`, `city_id`, `state_id`, `zip_code`, `license_number`, `license_verified`, `is_insured`, `is_verified`, `is_featured`, `years_experience`, `employees_count`, `plan`, `avg_rating`, `review_count`, `status`) VALUES

-- 1. Sunshine Roofing Co. - Miami, FL
((SELECT id FROM users WHERE email = 'carlos.martinez@sunshineroofing.com'),
'Sunshine Roofing Co.', 'sunshine-roofing-co',
'Miami''s Most Trusted Roofing Experts',
'Sunshine Roofing Co. has been protecting South Florida homes for over 18 years. We specialize in hurricane-resistant roof installations, tile and shingle replacements, and emergency storm damage repairs. Our team is fully licensed, insured, and committed to delivering exceptional craftsmanship on every project.',
'305-555-0101', 'info@sunshineroofing.com',
(SELECT id FROM cities WHERE slug = 'miami' AND state_id = (SELECT id FROM states WHERE code = 'FL')),
(SELECT id FROM states WHERE code = 'FL'),
'33130', 'CCC1330456', 1, 1, 1, 1, 18, '11-25', 'premium', 4.85, 12, 'active'),

-- 2. Metro Plumbing Solutions - Miami, FL
((SELECT id FROM users WHERE email = 'james.wilson@metroplumbing.com'),
'Metro Plumbing Solutions', 'metro-plumbing-solutions',
'Fast, Reliable Plumbing Services',
'Metro Plumbing Solutions provides comprehensive plumbing services throughout the Miami-Dade area. From emergency leak repairs and water heater installations to full bathroom plumbing rough-ins, our licensed plumbers arrive on time and get the job done right. We offer upfront pricing with no hidden fees.',
'305-555-0102', 'service@metroplumbing.com',
(SELECT id FROM cities WHERE slug = 'miami' AND state_id = (SELECT id FROM states WHERE code = 'FL')),
(SELECT id FROM states WHERE code = 'FL'),
'33125', 'CFC1429871', 1, 1, 1, 1, 12, '6-10', 'pro', 4.70, 8, 'active'),

-- 3. Coastal Kitchen & Bath - Fort Lauderdale, FL
((SELECT id FROM users WHERE email = 'maria.rodriguez@coastalkitchens.com'),
'Coastal Kitchen & Bath', 'coastal-kitchen-and-bath',
'Stunning Kitchen & Bath Transformations',
'Coastal Kitchen & Bath is a full-service remodeling company specializing in luxury kitchen and bathroom renovations. We handle everything from design consultation to final installation, using premium materials and skilled craftspeople. Our portfolio includes hundreds of successful projects across Broward County.',
'786-555-0103', 'design@coastalkitchens.com',
(SELECT id FROM cities WHERE slug = 'fort-lauderdale' AND state_id = (SELECT id FROM states WHERE code = 'FL')),
(SELECT id FROM states WHERE code = 'FL'),
'33301', 'CGC1527890', 1, 1, 1, 1, 15, '11-25', 'premium', 4.90, 10, 'active'),

-- 4. Florida Comfort HVAC - Orlando, FL
((SELECT id FROM users WHERE email = 'david.johnson@floridahvac.com'),
'Florida Comfort HVAC', 'florida-comfort-hvac',
'Keeping Florida Cool Since 2008',
'Florida Comfort HVAC delivers expert heating and cooling solutions for homes and businesses across Central Florida. We install, repair, and maintain all major HVAC brands, and we are a Carrier Factory Authorized Dealer. Our technicians are NATE-certified and available for same-day service calls.',
'954-555-0104', 'service@floridahvac.com',
(SELECT id FROM cities WHERE slug = 'orlando' AND state_id = (SELECT id FROM states WHERE code = 'FL')),
(SELECT id FROM states WHERE code = 'FL'),
'32801', 'CAC1821345', 1, 1, 1, 0, 16, '11-25', 'pro', 4.60, 7, 'active'),

-- 5. Palm City Electrical - Orlando, FL
((SELECT id FROM users WHERE email = 'anthony.garcia@palmelectrical.com'),
'Palm City Electrical', 'palm-city-electrical',
'Licensed Electricians You Can Trust',
'Palm City Electrical provides safe, code-compliant electrical services for residential and commercial properties. We handle everything from panel upgrades and whole-house rewiring to smart home installations and generator hookups. Available 24/7 for emergency electrical repairs.',
'407-555-0105', 'info@palmelectrical.com',
(SELECT id FROM cities WHERE slug = 'orlando' AND state_id = (SELECT id FROM states WHERE code = 'FL')),
(SELECT id FROM states WHERE code = 'FL'),
'32803', 'EC13009876', 1, 1, 1, 0, 10, '6-10', 'pro', 4.50, 5, 'active'),

-- 6. Tampa Bay Bath Remodeling - Tampa, FL
((SELECT id FROM users WHERE email = 'robert.brown@tampabathrooms.com'),
'Tampa Bay Bath Remodeling', 'tampa-bay-bath-remodeling',
'Beautiful Bathrooms on Any Budget',
'Tampa Bay Bath Remodeling transforms outdated bathrooms into stunning, functional spaces. We specialize in walk-in showers, tub-to-shower conversions, custom vanities, and ADA-accessible remodels. Most projects are completed within 5-7 business days with minimal disruption to your home.',
'813-555-0106', 'info@tampabathrooms.com',
(SELECT id FROM cities WHERE slug = 'tampa' AND state_id = (SELECT id FROM states WHERE code = 'FL')),
(SELECT id FROM states WHERE code = 'FL'),
'33602', 'CGC1530012', 1, 1, 0, 0, 8, '6-10', 'basic', 4.40, 6, 'active'),

-- 7. First Coast General Contracting - Jacksonville, FL
((SELECT id FROM users WHERE email = 'michael.thomas@gcflorida.com'),
'First Coast General Contracting', 'first-coast-general-contracting',
'Your Total Home Building Partner',
'First Coast General Contracting manages residential and commercial construction projects of all sizes in the Jacksonville metro area. From new home builds and room additions to major renovations and tenant buildouts, our experienced project managers ensure every job is completed on time and on budget.',
'904-555-0107', 'projects@gcflorida.com',
(SELECT id FROM cities WHERE slug = 'jacksonville' AND state_id = (SELECT id FROM states WHERE code = 'FL')),
(SELECT id FROM states WHERE code = 'FL'),
'32202', 'CGC1528901', 1, 1, 1, 0, 22, '26-50', 'pro', 4.75, 9, 'active'),

-- California cleaners (8-14)

-- 8. Bay Area Roofing Pros - San Francisco, CA
((SELECT id FROM users WHERE email = 'william.davis@bayarearoofing.com'),
'Bay Area Roofing Pros', 'bay-area-roofing-pros',
'Premium Roofing for the Bay Area',
'Bay Area Roofing Pros is the top-rated roofing company serving San Francisco and the surrounding Bay Area. We specialize in flat roof systems, slate and tile roofing, and green roof installations. Our crews have completed over 2,000 roofing projects and carry a 10-year workmanship warranty.',
'415-555-0108', 'info@bayarearoofing.com',
(SELECT id FROM cities WHERE slug = 'san-francisco' AND state_id = (SELECT id FROM states WHERE code = 'CA')),
(SELECT id FROM states WHERE code = 'CA'),
'94102', 'CSLB-1045678', 1, 1, 1, 1, 20, '11-25', 'premium', 4.95, 15, 'active'),

-- 9. Pacific Plumbing & Drain - Los Angeles, CA
((SELECT id FROM users WHERE email = 'daniel.lee@pacificplumbing.com'),
'Pacific Plumbing & Drain', 'pacific-plumbing-and-drain',
'LA''s Go-To Plumbing Experts',
'Pacific Plumbing & Drain has been serving the greater Los Angeles area for over 25 years. We handle all residential and commercial plumbing needs including sewer line repair, tankless water heater installation, and repiping. Our fleet of 15 trucks means we can be at your door fast.',
'310-555-0109', 'dispatch@pacificplumbing.com',
(SELECT id FROM cities WHERE slug = 'los-angeles' AND state_id = (SELECT id FROM states WHERE code = 'CA')),
(SELECT id FROM states WHERE code = 'CA'),
'90012', 'CSLB-987654', 1, 1, 1, 1, 25, '26-50', 'premium', 4.80, 11, 'active'),

-- 10. SoCal Pro Painting - San Diego, CA
((SELECT id FROM users WHERE email = 'kevin.chen@socalpaint.com'),
'SoCal Pro Painting', 'socal-pro-painting',
'Expert Interior & Exterior Painting',
'SoCal Pro Painting delivers flawless paint jobs for homes and businesses across San Diego County. We use premium Sherwin-Williams and Benjamin Moore paints, offer detailed color consultations, and guarantee clean, straight lines on every project. Free estimates with no obligation.',
'619-555-0110', 'quotes@socalpaint.com',
(SELECT id FROM cities WHERE slug = 'san-diego' AND state_id = (SELECT id FROM states WHERE code = 'CA')),
(SELECT id FROM states WHERE code = 'CA'),
'92101', 'CSLB-1098765', 1, 1, 0, 0, 9, '6-10', 'basic', 4.55, 4, 'active'),

-- 11. Golden State HVAC - San Jose, CA
((SELECT id FROM users WHERE email = 'brian.taylor@goldenstatehvac.com'),
'Golden State HVAC', 'golden-state-hvac',
'Energy-Efficient Heating & Cooling',
'Golden State HVAC specializes in energy-efficient heating and cooling solutions for Silicon Valley homes and businesses. We install high-SEER systems, ductless mini-splits, and smart thermostats. Our technicians are factory-trained on Lennox, Trane, and Daikin equipment.',
'408-555-0111', 'service@goldenstatehvac.com',
(SELECT id FROM cities WHERE slug = 'san-jose' AND state_id = (SELECT id FROM states WHERE code = 'CA')),
(SELECT id FROM states WHERE code = 'CA'),
'95110', 'CSLB-1087654', 1, 1, 1, 0, 14, '6-10', 'pro', 4.65, 6, 'active'),

-- 12. LA Decks & Outdoor Living - Los Angeles, CA
((SELECT id FROM users WHERE email = 'steven.kim@ladeckspatios.com'),
'LA Decks & Outdoor Living', 'la-decks-and-outdoor-living',
'Custom Outdoor Spaces Built to Last',
'LA Decks & Outdoor Living creates beautiful outdoor entertainment spaces across the Los Angeles area. We build custom wood and composite decks, pergolas, outdoor kitchens, and patio covers. Our designs blend seamlessly with your home architecture and maximize your outdoor living area.',
'213-555-0112', 'design@ladeckspatios.com',
(SELECT id FROM cities WHERE slug = 'los-angeles' AND state_id = (SELECT id FROM states WHERE code = 'CA')),
(SELECT id FROM states WHERE code = 'CA'),
'90015', 'CSLB-1056789', 1, 1, 0, 0, 11, '6-10', 'basic', 4.45, 5, 'active'),

-- 13. SF Tile & Flooring - San Francisco, CA
((SELECT id FROM users WHERE email = 'jason.nguyen@sftileandfloor.com'),
'SF Tile & Flooring', 'sf-tile-and-flooring',
'Beautiful Floors from Foundation Up',
'SF Tile & Flooring installs premium hardwood, tile, luxury vinyl, and natural stone flooring throughout San Francisco and Marin County. We also offer custom tile work for kitchens, bathrooms, and fireplaces. Our installers have an average of 12 years experience in the trade.',
'510-555-0113', 'info@sftileandfloor.com',
(SELECT id FROM cities WHERE slug = 'san-francisco' AND state_id = (SELECT id FROM states WHERE code = 'CA')),
(SELECT id FROM states WHERE code = 'CA'),
'94103', 'CSLB-1034567', 1, 1, 0, 0, 13, '6-10', 'basic', 4.70, 7, 'active'),

-- 14. Sacramento Fence & Gate - Sacramento, CA
((SELECT id FROM users WHERE email = 'richard.moore@sacramentofencing.com'),
'Sacramento Fence & Gate', 'sacramento-fence-and-gate',
'Quality Fences for Every Property',
'Sacramento Fence & Gate builds and repairs all types of fencing including wood privacy, vinyl, ornamental iron, and chain-link. We also install automated driveway gates and access control systems. Serving Sacramento and surrounding communities with dependable service since 2013.',
'916-555-0114', 'info@sacramentofencing.com',
(SELECT id FROM cities WHERE slug = 'sacramento' AND state_id = (SELECT id FROM states WHERE code = 'CA')),
(SELECT id FROM states WHERE code = 'CA'),
'95814', 'CSLB-1023456', 1, 1, 0, 0, 11, '2-5', 'free', 4.35, 3, 'active'),

-- Texas cleaners (15-21)

-- 15. Lone Star Roofing & Construction - Houston, TX
((SELECT id FROM users WHERE email = 'mark.hernandez@lonestarroofing.com'),
'Lone Star Roofing & Construction', 'lone-star-roofing-and-construction',
'Tough Roofs for Texas Weather',
'Lone Star Roofing & Construction protects Houston-area homes with durable, storm-resistant roofing systems. We are GAF Master Elite certified and specialize in impact-resistant shingles, metal roofing, and insurance claim assistance. Family-owned and operated since 2005.',
'713-555-0115', 'info@lonestarroofing.com',
(SELECT id FROM cities WHERE slug = 'houston' AND state_id = (SELECT id FROM states WHERE code = 'TX')),
(SELECT id FROM states WHERE code = 'TX'),
'77002', 'TRCC-29876', 1, 1, 1, 1, 19, '11-25', 'premium', 4.80, 10, 'active'),

-- 16. Texas Handyman Services - Dallas, TX
((SELECT id FROM users WHERE email = 'paul.smith@texashandyman.com'),
'Texas Handyman Services', 'texas-handyman-services',
'No Job Too Small',
'Texas Handyman Services handles all those home repairs and improvements you never seem to get to. From drywall patching and door installation to ceiling fan mounting and furniture assembly, our skilled handymen bring the tools and expertise to get it done right the first time.',
'214-555-0116', 'book@texashandyman.com',
(SELECT id FROM cities WHERE slug = 'dallas' AND state_id = (SELECT id FROM states WHERE code = 'TX')),
(SELECT id FROM states WHERE code = 'TX'),
'75201', NULL, 0, 1, 0, 0, 6, '2-5', 'free', 4.20, 4, 'active'),

-- 17. Dallas Kitchen Design Studio - Dallas, TX
((SELECT id FROM users WHERE email = 'donald.white@dallaskitchens.com'),
'Dallas Kitchen Design Studio', 'dallas-kitchen-design-studio',
'Dream Kitchens Made Real',
'Dallas Kitchen Design Studio specializes in high-end kitchen remodeling and custom cabinetry. We partner with top appliance brands and stone fabricators to deliver stunning kitchen transformations. Our in-house designers use 3D modeling to help you visualize your dream kitchen before construction begins.',
'469-555-0117', 'design@dallaskitchens.com',
(SELECT id FROM cities WHERE slug = 'dallas' AND state_id = (SELECT id FROM states WHERE code = 'TX')),
(SELECT id FROM states WHERE code = 'TX'),
'75204', 'TRCC-31234', 1, 1, 1, 1, 17, '11-25', 'pro', 4.85, 9, 'active'),

-- 18. Austin Home Renovations - Austin, TX
((SELECT id FROM users WHERE email = 'jose.perez@austinhomereno.com'),
'Austin Home Renovations', 'austin-home-renovations',
'Modernize Your Austin Home',
'Austin Home Renovations brings fresh, modern design to homes throughout the Austin metro. We specialize in whole-house renovations, open-concept conversions, and accessory dwelling unit construction. Our focus on sustainable building practices and local materials sets us apart.',
'512-555-0118', 'info@austinhomereno.com',
(SELECT id FROM cities WHERE slug = 'austin' AND state_id = (SELECT id FROM states WHERE code = 'TX')),
(SELECT id FROM states WHERE code = 'TX'),
'78701', 'TRCC-30567', 1, 1, 1, 0, 13, '6-10', 'pro', 4.70, 7, 'active'),

-- 19. SA Town Electric - San Antonio, TX
((SELECT id FROM users WHERE email = 'andrew.jackson@satownelectric.com'),
'SA Town Electric', 'sa-town-electric',
'San Antonio''s Electrical Specialists',
'SA Town Electric provides full-service electrical contracting for residential and commercial clients in San Antonio and the Hill Country. We handle new construction wiring, service panel upgrades, lighting design, and EV charger installations. Licensed, bonded, and insured for your protection.',
'210-555-0119', 'service@satownelectric.com',
(SELECT id FROM cities WHERE slug = 'san-antonio' AND state_id = (SELECT id FROM states WHERE code = 'TX')),
(SELECT id FROM states WHERE code = 'TX'),
'78205', 'TECL-34567', 1, 1, 0, 0, 9, '6-10', 'basic', 4.40, 5, 'active'),

-- 20. Texas Concrete Works - Fort Worth, TX
((SELECT id FROM users WHERE email = 'chris.lopez@texasconcrete.com'),
'Texas Concrete Works', 'texas-concrete-works',
'Solid Foundations, Beautiful Finishes',
'Texas Concrete Works pours and finishes all types of residential and commercial concrete. We build driveways, patios, pool decks, retaining walls, and decorative stamped concrete surfaces. Our experienced crews handle projects from start to finish including demolition, grading, and forming.',
'817-555-0120', 'estimate@texasconcrete.com',
(SELECT id FROM cities WHERE slug = 'fort-worth' AND state_id = (SELECT id FROM states WHERE code = 'TX')),
(SELECT id FROM states WHERE code = 'TX'),
'76102', NULL, 0, 1, 0, 0, 15, '11-25', 'basic', 4.30, 4, 'active'),

-- 21. Houston Siding Experts - Houston, TX
((SELECT id FROM users WHERE email = 'george.martinez2@houstonsiding.com'),
'Houston Siding Experts', 'houston-siding-experts',
'Protect Your Home with Quality Siding',
'Houston Siding Experts installs and repairs all types of exterior siding including James Hardie fiber cement, vinyl, LP SmartSide, and natural wood. We also handle soffit, fascia, and trim work. Our installations come with industry-leading manufacturer warranties and our own 5-year labor guarantee.',
'281-555-0121', 'info@houstonsiding.com',
(SELECT id FROM cities WHERE slug = 'houston' AND state_id = (SELECT id FROM states WHERE code = 'TX')),
(SELECT id FROM states WHERE code = 'TX'),
'77003', 'TRCC-28901', 1, 1, 0, 0, 10, '6-10', 'basic', 4.25, 3, 'active'),

-- New York cleaners (22-26)

-- 22. Empire State Roofing - New York City, NY
((SELECT id FROM users WHERE email = 'frank.rossi@empireroofing.com'),
'Empire State Roofing', 'empire-state-roofing',
'NYC''s Flat Roof Specialists',
'Empire State Roofing has been keeping New York City buildings dry for over 30 years. We specialize in commercial and residential flat roof systems including TPO, EPDM, and modified bitumen. Our team is experienced with NYC building codes, DOB permits, and landmark building requirements.',
'212-555-0122', 'info@empireroofing.com',
(SELECT id FROM cities WHERE slug = 'new-york-city' AND state_id = (SELECT id FROM states WHERE code = 'NY')),
(SELECT id FROM states WHERE code = 'NY'),
'10001', 'WC-29876-H', 1, 1, 1, 1, 30, '26-50', 'premium', 4.75, 8, 'active'),

-- 23. NYC Master Plumbing - New York City, NY
((SELECT id FROM users WHERE email = 'john.murphy@nycplumbing.com'),
'NYC Master Plumbing', 'nyc-master-plumbing',
'Licensed Master Plumbers Since 1998',
'NYC Master Plumbing provides expert plumbing services throughout all five boroughs. We handle everything from stopped-up drains and leaky pipes to complete bathroom and kitchen plumbing installations. Our master plumbers understand the unique challenges of New York City plumbing systems.',
'718-555-0123', 'service@nycplumbing.com',
(SELECT id FROM cities WHERE slug = 'new-york-city' AND state_id = (SELECT id FROM states WHERE code = 'NY')),
(SELECT id FROM states WHERE code = 'NY'),
'10002', 'MP-14567', 1, 1, 1, 0, 26, '11-25', 'pro', 4.60, 6, 'active'),

-- 24. Brooklyn Bath Design - New York City, NY
((SELECT id FROM users WHERE email = 'peter.sullivan@brooklynbath.com'),
'Brooklyn Bath Design', 'brooklyn-bath-design',
'Boutique Bathroom Renovations',
'Brooklyn Bath Design creates stylish, space-efficient bathroom renovations for Brooklyn brownstones, co-ops, and condos. We specialize in custom tile work, frameless glass showers, and heated flooring. Our designers work within your budget to maximize both beauty and function in every project.',
'917-555-0124', 'design@brooklynbath.com',
(SELECT id FROM cities WHERE slug = 'new-york-city' AND state_id = (SELECT id FROM states WHERE code = 'NY')),
(SELECT id FROM states WHERE code = 'NY'),
'11201', 'HIC-2034567', 1, 1, 0, 0, 12, '6-10', 'basic', 4.50, 5, 'active'),

-- 25. Buffalo Insulation Pros - Buffalo, NY
((SELECT id FROM users WHERE email = 'tom.kelly@buffaloinsulation.com'),
'Buffalo Insulation Pros', 'buffalo-insulation-pros',
'Keep the Cold Out, Savings In',
'Buffalo Insulation Pros helps Western New York homeowners slash their energy bills with professional insulation upgrades. We install blown-in cellulose, spray foam, fiberglass batts, and rigid foam board insulation in attics, walls, basements, and crawl spaces. Free energy assessments available.',
'716-555-0125', 'info@buffaloinsulation.com',
(SELECT id FROM cities WHERE slug = 'buffalo' AND state_id = (SELECT id FROM states WHERE code = 'NY')),
(SELECT id FROM states WHERE code = 'NY'),
'14201', 'HIC-2045678', 0, 1, 0, 0, 7, '2-5', 'free', 4.10, 3, 'active'),

-- 26. Rochester Pro Painting - Rochester, NY
((SELECT id FROM users WHERE email = 'mike.oconnor@rochesterpainting.com'),
'Rochester Pro Painting', 'rochester-pro-painting',
'Quality Painting Inside and Out',
'Rochester Pro Painting delivers professional interior and exterior painting for homes, offices, and commercial buildings. We prep surfaces thoroughly, use top-quality paints, and pay attention to every detail. Our painters are neat, punctual, and respectful of your property.',
'585-555-0126', 'quotes@rochesterpainting.com',
(SELECT id FROM cities WHERE slug = 'rochester' AND state_id = (SELECT id FROM states WHERE code = 'NY')),
(SELECT id FROM states WHERE code = 'NY'),
'14604', NULL, 0, 1, 0, 0, 5, '2-5', 'free', 4.00, 2, 'active'),

-- Illinois cleaners (27-30)

-- 27. Chicago Roofing Authority - Chicago, IL
((SELECT id FROM users WHERE email = 'edward.kowalski@chicagoroofing.com'),
'Chicago Roofing Authority', 'chicago-roofing-authority',
'Built to Handle Chicago Winters',
'Chicago Roofing Authority specializes in durable roofing systems designed to withstand harsh Midwest winters. We install architectural shingles, standing seam metal, and flat commercial systems. Our team handles ice dam prevention, attic ventilation, and emergency tarping for storm damage.',
'312-555-0127', 'info@chicagoroofing.com',
(SELECT id FROM cities WHERE slug = 'chicago' AND state_id = (SELECT id FROM states WHERE code = 'IL')),
(SELECT id FROM states WHERE code = 'IL'),
'60601', 'IL-104-017890', 1, 1, 1, 0, 21, '11-25', 'pro', 4.65, 7, 'active'),

-- 28. Windy City HVAC Services - Chicago, IL
((SELECT id FROM users WHERE email = 'tony.russo@windycityhvac.com'),
'Windy City HVAC Services', 'windy-city-hvac-services',
'Comfort Through Every Season',
'Windy City HVAC Services keeps Chicagoland homes comfortable year-round. We install and service furnaces, air conditioners, boilers, and heat pumps from top brands like Carrier, Lennox, and Rheem. We also offer preventive maintenance plans that help extend equipment life and reduce energy costs.',
'773-555-0128', 'service@windycityhvac.com',
(SELECT id FROM cities WHERE slug = 'chicago' AND state_id = (SELECT id FROM states WHERE code = 'IL')),
(SELECT id FROM states WHERE code = 'IL'),
'60614', 'IL-055-023456', 1, 1, 1, 0, 16, '6-10', 'pro', 4.55, 6, 'active'),

-- 29. Chicagoland Flooring Co. - Chicago, IL
((SELECT id FROM users WHERE email = 'matt.nowak@chicagoflooring.com'),
'Chicagoland Flooring Co.', 'chicagoland-flooring-co',
'Beautiful Floors at Honest Prices',
'Chicagoland Flooring Co. installs, refinishes, and repairs all types of flooring for homes and businesses across the greater Chicago area. We work with hardwood, engineered wood, luxury vinyl plank, tile, and carpet. Our showroom features over 500 samples to choose from.',
'630-555-0129', 'info@chicagoflooring.com',
(SELECT id FROM cities WHERE slug = 'chicago' AND state_id = (SELECT id FROM states WHERE code = 'IL')),
(SELECT id FROM states WHERE code = 'IL'),
'60606', 'IL-104-025678', 1, 1, 0, 0, 14, '6-10', 'basic', 4.50, 5, 'active'),

-- 30. Aurora Handyman Connection - Aurora, IL
((SELECT id FROM users WHERE email = 'jim.brady@aurorahandyman.com'),
'Aurora Handyman Connection', 'aurora-handyman-connection',
'Your Neighborhood Fix-It Pros',
'Aurora Handyman Connection provides reliable repair and maintenance services for homeowners in Aurora, Naperville, and surrounding suburbs. We handle drywall repair, deck staining, gutter cleaning, appliance installation, and dozens of other home tasks. Flat-rate pricing with no hourly surprises.',
'331-555-0130', 'book@aurorahandyman.com',
(SELECT id FROM cities WHERE slug = 'aurora' AND state_id = (SELECT id FROM states WHERE code = 'IL')),
(SELECT id FROM states WHERE code = 'IL'),
'60502', NULL, 0, 1, 0, 0, 4, '2-5', 'free', 4.15, 3, 'active'),

-- Georgia cleaners (31-33)

-- 31. Peachtree Builders Group - Atlanta, GA
((SELECT id FROM users WHERE email = 'derek.washington@peachtreebuilders.com'),
'Peachtree Builders Group', 'peachtree-builders-group',
'Atlanta''s Premier General Cleaner',
'Peachtree Builders Group is a full-service general contracting firm serving the greater Atlanta area. We manage new home construction, major renovations, and commercial buildouts with transparent budgeting and weekly progress updates. Our portfolio includes over 300 completed projects.',
'404-555-0131', 'info@peachtreebuilders.com',
(SELECT id FROM cities WHERE slug = 'atlanta' AND state_id = (SELECT id FROM states WHERE code = 'GA')),
(SELECT id FROM states WHERE code = 'GA'),
'30303', 'GCCO-006789', 1, 1, 1, 1, 24, '26-50', 'pro', 4.80, 8, 'active'),

-- 32. Atlanta Gutter Solutions - Atlanta, GA
((SELECT id FROM users WHERE email = 'marcus.hall@atlantagutters.com'),
'Atlanta Gutter Solutions', 'atlanta-gutter-solutions',
'Seamless Gutters Installed Right',
'Atlanta Gutter Solutions installs, repairs, and maintains seamless aluminum gutters, gutter guards, and downspout systems. We protect your home from water damage with properly pitched gutters and custom-fabricated corners. We also offer gutter cleaning service plans to keep everything flowing.',
'678-555-0132', 'service@atlantagutters.com',
(SELECT id FROM cities WHERE slug = 'atlanta' AND state_id = (SELECT id FROM states WHERE code = 'GA')),
(SELECT id FROM states WHERE code = 'GA'),
'30305', NULL, 0, 1, 0, 0, 6, '2-5', 'free', 4.20, 3, 'active'),

-- 33. Savannah Garage Transformations - Savannah, GA
((SELECT id FROM users WHERE email = 'leon.carter@savannahgarage.com'),
'Savannah Garage Transformations', 'savannah-garage-transformations',
'More Than Just a Garage',
'Savannah Garage Transformations converts underutilized garages into functional living spaces, home offices, and workshops. We also install epoxy garage flooring, custom storage systems, and insulated garage doors. Our projects add value and usable square footage to your home.',
'912-555-0133', 'info@savannahgarage.com',
(SELECT id FROM cities WHERE slug = 'savannah' AND state_id = (SELECT id FROM states WHERE code = 'GA')),
(SELECT id FROM states WHERE code = 'GA'),
'31401', 'GCCO-007890', 1, 1, 0, 0, 7, '2-5', 'free', 4.30, 4, 'active'),

-- North Carolina cleaners (34-36)

-- 34. Charlotte Home Remodeling - Charlotte, NC
((SELECT id FROM users WHERE email = 'kevin.harris@charlotteremodel.com'),
'Charlotte Home Remodeling', 'charlotte-home-remodeling',
'Transform Your Home Inside & Out',
'Charlotte Home Remodeling delivers complete home transformation services including kitchen and bath remodels, room additions, and whole-house renovations. Our design-build approach streamlines the process from concept to completion. We are a member of the Charlotte Home Builders Association.',
'704-555-0134', 'info@charlotteremodel.com',
(SELECT id FROM cities WHERE slug = 'charlotte' AND state_id = (SELECT id FROM states WHERE code = 'NC')),
(SELECT id FROM states WHERE code = 'NC'),
'28202', 'NC-GC-72345', 1, 1, 1, 1, 18, '11-25', 'pro', 4.75, 8, 'active'),

-- 35. Raleigh Custom Decks - Raleigh, NC
((SELECT id FROM users WHERE email = 'alex.young@raleighdecks.com'),
'Raleigh Custom Decks', 'raleigh-custom-decks',
'Outdoor Living Crafted to Perfection',
'Raleigh Custom Decks builds premium composite and hardwood decks, screened porches, and outdoor kitchens for Triangle-area homeowners. We use TimberTech, Trex, and Azek materials for low-maintenance beauty that lasts. Free design consultations with 3D renderings included.',
'919-555-0135', 'build@raleighdecks.com',
(SELECT id FROM cities WHERE slug = 'raleigh' AND state_id = (SELECT id FROM states WHERE code = 'NC')),
(SELECT id FROM states WHERE code = 'NC'),
'27601', 'NC-GC-74567', 1, 1, 0, 0, 10, '6-10', 'basic', 4.45, 5, 'active'),

-- 36. Durham Basement Solutions - Durham, NC
((SELECT id FROM users WHERE email = 'travis.scott@durhambasements.com'),
'Durham Basement Solutions', 'durham-basement-solutions',
'Unlock Your Basement''s Potential',
'Durham Basement Solutions specializes in basement finishing, waterproofing, and remodeling. We transform dark, unused basements into comfortable living areas, home theaters, and in-law suites. Our waterproofing systems come with a transferable lifetime warranty for total peace of mind.',
'984-555-0136', 'info@durhambasements.com',
(SELECT id FROM cities WHERE slug = 'durham' AND state_id = (SELECT id FROM states WHERE code = 'NC')),
(SELECT id FROM states WHERE code = 'NC'),
'27701', 'NC-GC-75678', 1, 1, 0, 0, 8, '6-10', 'basic', 4.35, 4, 'active'),

-- Ohio cleaners (37-39)

-- 37. Buckeye Roofing & Exteriors - Columbus, OH
((SELECT id FROM users WHERE email = 'ryan.miller@buckeyeroofing.com'),
'Buckeye Roofing & Exteriors', 'buckeye-roofing-and-exteriors',
'Central Ohio''s Roofing Experts',
'Buckeye Roofing & Exteriors provides top-quality roofing, siding, and window installations for homes across Central Ohio. We are an Owens Corning Platinum Preferred Cleaner and offer the industry''s best warranty coverage. Free drone-assisted roof inspections available.',
'614-555-0137', 'info@buckeyeroofing.com',
(SELECT id FROM cities WHERE slug = 'columbus' AND state_id = (SELECT id FROM states WHERE code = 'OH')),
(SELECT id FROM states WHERE code = 'OH'),
'43215', 'OH-RC-89012', 1, 1, 1, 0, 16, '11-25', 'pro', 4.60, 6, 'active'),

-- 38. Cleveland Climate Control - Cleveland, OH
((SELECT id FROM users WHERE email = 'greg.clark@clevelandhvac.com'),
'Cleveland Climate Control', 'cleveland-climate-control',
'Reliable Heating & Cooling Solutions',
'Cleveland Climate Control provides dependable HVAC installation, repair, and maintenance services for Northeast Ohio homes and businesses. We specialize in high-efficiency furnaces, central air systems, and ductwork design. Our comfort advisors help you choose the right system for your home and budget.',
'216-555-0138', 'service@clevelandhvac.com',
(SELECT id FROM cities WHERE slug = 'cleveland' AND state_id = (SELECT id FROM states WHERE code = 'OH')),
(SELECT id FROM states WHERE code = 'OH'),
'44113', 'OH-HVAC-56789', 1, 1, 0, 0, 11, '6-10', 'basic', 4.40, 4, 'active'),

-- 39. Cincinnati Plumbing Co. - Cincinnati, OH
((SELECT id FROM users WHERE email = 'sean.baker@cincinnatiplumbing.com'),
'Cincinnati Plumbing Co.', 'cincinnati-plumbing-co',
'Honest Plumbing at Fair Prices',
'Cincinnati Plumbing Co. has served the Greater Cincinnati and Northern Kentucky area for over 20 years. We fix leaks, unclog drains, install water heaters, and handle complete plumbing renovations. Our upfront pricing policy means you know the cost before we start any work.',
'513-555-0139', 'dispatch@cincinnatiplumbing.com',
(SELECT id FROM cities WHERE slug = 'cincinnati' AND state_id = (SELECT id FROM states WHERE code = 'OH')),
(SELECT id FROM states WHERE code = 'OH'),
'45202', 'OH-PL-67890', 1, 1, 0, 0, 20, '6-10', 'basic', 4.55, 5, 'active'),

-- Pennsylvania cleaners (40-42)

-- 40. Philly Home Renovations - Philadelphia, PA
((SELECT id FROM users WHERE email = 'nick.campbell@phillyhomereno.com'),
'Philly Home Renovations', 'philly-home-renovations',
'Revitalizing Philadelphia Homes',
'Philly Home Renovations specializes in restoring and renovating Philadelphia rowhomes, townhouses, and historic properties. We handle complete gut renovations, kitchen and bath remodels, and structural repairs while preserving architectural character. Fully licensed with Philadelphia L&I.',
'215-555-0140', 'info@phillyhomereno.com',
(SELECT id FROM cities WHERE slug = 'philadelphia' AND state_id = (SELECT id FROM states WHERE code = 'PA')),
(SELECT id FROM states WHERE code = 'PA'),
'19103', 'PA-HC-056789', 1, 1, 1, 0, 19, '11-25', 'pro', 4.70, 7, 'active'),

-- 41. Pittsburgh Electric Solutions - Pittsburgh, PA
((SELECT id FROM users WHERE email = 'dave.stewart@pittsburghelectric.com'),
'Pittsburgh Electric Solutions', 'pittsburgh-electric-solutions',
'Powering Pittsburgh Homes & Businesses',
'Pittsburgh Electric Solutions provides comprehensive electrical services for residential and commercial clients in the Pittsburgh metro. We specialize in electrical panel upgrades, code violation corrections, generator installations, and LED lighting retrofits. Available for emergency service 24/7.',
'412-555-0141', 'service@pittsburghelectric.com',
(SELECT id FROM cities WHERE slug = 'pittsburgh' AND state_id = (SELECT id FROM states WHERE code = 'PA')),
(SELECT id FROM states WHERE code = 'PA'),
'15222', 'PA-EC-045678', 1, 1, 0, 0, 14, '6-10', 'basic', 4.45, 5, 'active'),

-- 42. Keystone Concrete & Masonry - Philadelphia, PA
((SELECT id FROM users WHERE email = 'pat.morgan@keystoneconcrete.com'),
'Keystone Concrete & Masonry', 'keystone-concrete-and-masonry',
'Built on Solid Foundations',
'Keystone Concrete & Masonry pours foundations, builds retaining walls, installs brick and stone veneers, and creates beautiful stamped concrete patios. We serve the greater Philadelphia area and have experience with both new construction and restoration of historic masonry structures.',
'610-555-0142', 'estimate@keystoneconcrete.com',
(SELECT id FROM cities WHERE slug = 'philadelphia' AND state_id = (SELECT id FROM states WHERE code = 'PA')),
(SELECT id FROM states WHERE code = 'PA'),
'19106', 'PA-HC-067890', 1, 1, 0, 0, 17, '11-25', 'basic', 4.50, 4, 'active'),

-- Arizona cleaners (43-45)

-- 43. Desert Shield Roofing - Phoenix, AZ
((SELECT id FROM users WHERE email = 'ray.gonzalez@desertroofing.com'),
'Desert Shield Roofing', 'desert-shield-roofing',
'Roofing Built for the Desert Sun',
'Desert Shield Roofing installs and repairs residential and commercial roofing systems designed for Arizona''s extreme heat. We specialize in tile roofing, foam roofing, and cool roof coatings that lower energy costs. Our crews work early mornings to beat the heat and deliver quality results.',
'602-555-0143', 'info@desertroofing.com',
(SELECT id FROM cities WHERE slug = 'phoenix' AND state_id = (SELECT id FROM states WHERE code = 'AZ')),
(SELECT id FROM states WHERE code = 'AZ'),
'85004', 'ROC-298765', 1, 1, 1, 0, 14, '6-10', 'basic', 4.55, 5, 'active'),

-- 44. Phoenix Comfort HVAC - Phoenix, AZ
((SELECT id FROM users WHERE email = 'scott.turner@phoenixhvac.com'),
'Phoenix Comfort HVAC', 'phoenix-comfort-hvac',
'Desert Cooling Experts',
'Phoenix Comfort HVAC keeps Valley of the Sun residents cool and comfortable. We specialize in high-efficiency AC installations, heat pump systems, and evaporative cooler service. Our technicians understand the unique demands Arizona heat places on cooling equipment and can recommend the right solution.',
'480-555-0144', 'service@phoenixhvac.com',
(SELECT id FROM cities WHERE slug = 'phoenix' AND state_id = (SELECT id FROM states WHERE code = 'AZ')),
(SELECT id FROM states WHERE code = 'AZ'),
'85006', 'ROC-301234', 1, 1, 1, 0, 11, '6-10', 'pro', 4.60, 6, 'active'),

-- 45. Tucson Handyman Hub - Tucson, AZ
((SELECT id FROM users WHERE email = 'adam.ramirez@tucsonhandyman.com'),
'Tucson Handyman Hub', 'tucson-handyman-hub',
'Reliable Repairs, Fair Prices',
'Tucson Handyman Hub provides a full range of home repair and maintenance services to the Tucson metro area. From plumbing fixes and electrical troubleshooting to painting, tile work, and carpentry, we are your one-call solution for keeping your home in top shape.',
'520-555-0145', 'book@tucsonhandyman.com',
(SELECT id FROM cities WHERE slug = 'tucson' AND state_id = (SELECT id FROM states WHERE code = 'AZ')),
(SELECT id FROM states WHERE code = 'AZ'),
'85701', NULL, 0, 1, 0, 0, 5, '1', 'free', 3.90, 2, 'active'),

-- Washington cleaners (46-47)

-- 46. Emerald City Decks & Fencing - Seattle, WA
((SELECT id FROM users WHERE email = 'eric.anderson@seattledecks.com'),
'Emerald City Decks & Fencing', 'emerald-city-decks-and-fencing',
'Rain-Ready Outdoor Structures',
'Emerald City Decks & Fencing builds weather-resistant decks, fences, and pergolas designed for the Pacific Northwest climate. We use cedar, composite, and aluminum materials that stand up to Seattle rain. Our team also handles deck refinishing and fence repairs throughout King County.',
'206-555-0146', 'build@seattledecks.com',
(SELECT id FROM cities WHERE slug = 'seattle' AND state_id = (SELECT id FROM states WHERE code = 'WA')),
(SELECT id FROM states WHERE code = 'WA'),
'98101', 'SEATTL-L123456', 1, 1, 0, 0, 12, '6-10', 'basic', 4.50, 5, 'active'),

-- 47. Puget Sound Plumbing - Tacoma, WA
((SELECT id FROM users WHERE email = 'tyler.wright@pugetsoundplumbing.com'),
'Puget Sound Plumbing', 'puget-sound-plumbing',
'Tacoma''s Trusted Plumbers',
'Puget Sound Plumbing serves homeowners and businesses throughout the Tacoma and South Sound area. We handle sewer line repairs, water heater replacements, gas line installations, and bathroom plumbing remodels. Our flat-rate pricing means no surprise charges on your bill.',
'253-555-0147', 'dispatch@pugetsoundplumbing.com',
(SELECT id FROM cities WHERE slug = 'tacoma' AND state_id = (SELECT id FROM states WHERE code = 'WA')),
(SELECT id FROM states WHERE code = 'WA'),
'98402', 'PLUMB-WA-67890', 1, 1, 0, 0, 9, '6-10', 'free', 4.35, 3, 'active'),

-- Colorado cleaners (48-49)

-- 48. Mile High Roofing & Gutters - Denver, CO
((SELECT id FROM users WHERE email = 'ben.foster@milehighroofing.com'),
'Mile High Roofing & Gutters', 'mile-high-roofing-and-gutters',
'Denver''s Complete Exterior Solution',
'Mile High Roofing & Gutters handles all your exterior needs from the roofline down. We install asphalt shingles, metal roofing, seamless gutters, and gutter guards designed for heavy snowfall. Our hail damage specialists work directly with your insurance company to simplify the claims process.',
'303-555-0148', 'info@milehighroofing.com',
(SELECT id FROM cities WHERE slug = 'denver' AND state_id = (SELECT id FROM states WHERE code = 'CO')),
(SELECT id FROM states WHERE code = 'CO'),
'80202', 'CO-RC-234567', 1, 1, 1, 1, 15, '11-25', 'pro', 4.70, 7, 'active'),

-- 49. Denver Insulation & Energy - Denver, CO
((SELECT id FROM users WHERE email = 'luke.ward@denverinsulation.com'),
'Denver Insulation & Energy', 'denver-insulation-and-energy',
'Lower Bills, Greater Comfort',
'Denver Insulation & Energy helps Colorado homeowners reduce energy costs with professional insulation services. We install spray foam, blown-in fiberglass, and mineral wool insulation in attics, walls, and crawl spaces. We also offer home energy audits and air sealing services.',
'720-555-0149', 'info@denverinsulation.com',
(SELECT id FROM cities WHERE slug = 'denver' AND state_id = (SELECT id FROM states WHERE code = 'CO')),
(SELECT id FROM states WHERE code = 'CO'),
'80204', 'CO-IN-345678', 1, 1, 0, 0, 8, '2-5', 'free', 4.25, 3, 'active'),

-- New Jersey (50)

-- 50. Garden State Painting - Newark, NJ
((SELECT id FROM users WHERE email = 'sam.diaz@gardenstatepainting.com'),
'Garden State Painting', 'garden-state-painting',
'North Jersey''s Painting Professionals',
'Garden State Painting provides residential and commercial painting services across Northern New Jersey. We specialize in interior repaints, exterior house painting, cabinet refinishing, and deck staining. Our crews are clean, efficient, and committed to delivering a flawless finish every time.',
'201-555-0150', 'quotes@gardenstatepainting.com',
(SELECT id FROM cities WHERE slug = 'newark' AND state_id = (SELECT id FROM states WHERE code = 'NJ')),
(SELECT id FROM states WHERE code = 'NJ'),
'07102', 'NJ-HIC-13PA09876', 1, 1, 0, 0, 10, '6-10', 'free', 4.40, 4, 'active'),

-- Virginia (51)

-- 51. Virginia Coast Builders - Virginia Beach, VA
((SELECT id FROM users WHERE email = 'craig.reed@virginiabuilders.com'),
'Virginia Coast Builders', 'virginia-coast-builders',
'Hampton Roads'' Trusted GC',
'Virginia Coast Builders is a general contracting firm serving Hampton Roads and the Virginia Beach area. We manage residential construction, commercial tenant improvements, and military housing renovations. Our attention to detail and clear communication has earned us an A+ BBB rating.',
'757-555-0151', 'info@virginiabuilders.com',
(SELECT id FROM cities WHERE slug = 'virginia-beach' AND state_id = (SELECT id FROM states WHERE code = 'VA')),
(SELECT id FROM states WHERE code = 'VA'),
'23451', 'VA-CBC-2201234', 1, 1, 1, 0, 20, '11-25', 'basic', 4.60, 5, 'active'),

-- Massachusetts (52)

-- 52. Boston Bath Remodeling - Boston, MA
((SELECT id FROM users WHERE email = 'ian.burke@bostonbathremodel.com'),
'Boston Bath Remodeling', 'boston-bath-remodeling',
'New England Bathroom Specialists',
'Boston Bath Remodeling transforms Boston-area bathrooms with expert craftsmanship and top-quality materials. We specialize in tub-to-shower conversions, custom tile showers, vanity installations, and complete bathroom gut renovations. We work in homes of all styles from historic Victorians to modern condos.',
'617-555-0152', 'info@bostonbathremodel.com',
(SELECT id FROM cities WHERE slug = 'boston' AND state_id = (SELECT id FROM states WHERE code = 'MA')),
(SELECT id FROM states WHERE code = 'MA'),
'02108', 'MA-HIC-176543', 1, 1, 0, 0, 11, '6-10', 'free', 4.45, 4, 'active');


-- ============================================================
-- CLEANER CATEGORIES (link cleaners to categories)
-- Each cleaner gets 1-3 categories
-- ============================================================
INSERT INTO `cleaner_categories` (`cleaner_id`, `category_id`) VALUES

-- 1. Sunshine Roofing Co. -> Roofing, Gutters
((SELECT id FROM cleaners WHERE slug = 'sunshine-roofing-co'), 1),
((SELECT id FROM cleaners WHERE slug = 'sunshine-roofing-co'), 13),

-- 2. Metro Plumbing Solutions -> Plumbing
((SELECT id FROM cleaners WHERE slug = 'metro-plumbing-solutions'), 6),

-- 3. Coastal Kitchen & Bath -> Kitchen Remodeling, Bathroom Remodeling, Home Remodeling
((SELECT id FROM cleaners WHERE slug = 'coastal-kitchen-and-bath'), 9),
((SELECT id FROM cleaners WHERE slug = 'coastal-kitchen-and-bath'), 5),
((SELECT id FROM cleaners WHERE slug = 'coastal-kitchen-and-bath'), 15),

-- 4. Florida Comfort HVAC -> HVAC
((SELECT id FROM cleaners WHERE slug = 'florida-comfort-hvac'), 4),

-- 5. Palm City Electrical -> Electrical
((SELECT id FROM cleaners WHERE slug = 'palm-city-electrical'), 12),

-- 6. Tampa Bay Bath Remodeling -> Bathroom Remodeling, Plumbing
((SELECT id FROM cleaners WHERE slug = 'tampa-bay-bath-remodeling'), 5),
((SELECT id FROM cleaners WHERE slug = 'tampa-bay-bath-remodeling'), 6),

-- 7. First Coast General Contracting -> General Cleaner, Home Remodeling, Home Renovation
((SELECT id FROM cleaners WHERE slug = 'first-coast-general-contracting'), 2),
((SELECT id FROM cleaners WHERE slug = 'first-coast-general-contracting'), 15),
((SELECT id FROM cleaners WHERE slug = 'first-coast-general-contracting'), 18),

-- 8. Bay Area Roofing Pros -> Roofing, Siding
((SELECT id FROM cleaners WHERE slug = 'bay-area-roofing-pros'), 1),
((SELECT id FROM cleaners WHERE slug = 'bay-area-roofing-pros'), 10),

-- 9. Pacific Plumbing & Drain -> Plumbing, Bathroom Remodeling
((SELECT id FROM cleaners WHERE slug = 'pacific-plumbing-and-drain'), 6),
((SELECT id FROM cleaners WHERE slug = 'pacific-plumbing-and-drain'), 5),

-- 10. SoCal Pro Painting -> Painting
((SELECT id FROM cleaners WHERE slug = 'socal-pro-painting'), 14),

-- 11. Golden State HVAC -> HVAC, Insulation
((SELECT id FROM cleaners WHERE slug = 'golden-state-hvac'), 4),
((SELECT id FROM cleaners WHERE slug = 'golden-state-hvac'), 17),

-- 12. LA Decks & Outdoor Living -> Decks & Patios, Fencing
((SELECT id FROM cleaners WHERE slug = 'la-decks-and-outdoor-living'), 8),
((SELECT id FROM cleaners WHERE slug = 'la-decks-and-outdoor-living'), 11),

-- 13. SF Tile & Flooring -> Flooring, Kitchen Remodeling
((SELECT id FROM cleaners WHERE slug = 'sf-tile-and-flooring'), 16),
((SELECT id FROM cleaners WHERE slug = 'sf-tile-and-flooring'), 9),

-- 14. Sacramento Fence & Gate -> Fencing
((SELECT id FROM cleaners WHERE slug = 'sacramento-fence-and-gate'), 11),

-- 15. Lone Star Roofing & Construction -> Roofing, General Cleaner
((SELECT id FROM cleaners WHERE slug = 'lone-star-roofing-and-construction'), 1),
((SELECT id FROM cleaners WHERE slug = 'lone-star-roofing-and-construction'), 2),

-- 16. Texas Handyman Services -> Handyman
((SELECT id FROM cleaners WHERE slug = 'texas-handyman-services'), 3),

-- 17. Dallas Kitchen Design Studio -> Kitchen Remodeling, Home Remodeling
((SELECT id FROM cleaners WHERE slug = 'dallas-kitchen-design-studio'), 9),
((SELECT id FROM cleaners WHERE slug = 'dallas-kitchen-design-studio'), 15),

-- 18. Austin Home Renovations -> Home Renovation, Home Remodeling, General Cleaner
((SELECT id FROM cleaners WHERE slug = 'austin-home-renovations'), 18),
((SELECT id FROM cleaners WHERE slug = 'austin-home-renovations'), 15),
((SELECT id FROM cleaners WHERE slug = 'austin-home-renovations'), 2),

-- 19. SA Town Electric -> Electrical
((SELECT id FROM cleaners WHERE slug = 'sa-town-electric'), 12),

-- 20. Texas Concrete Works -> Concrete & Masonry, Decks & Patios
((SELECT id FROM cleaners WHERE slug = 'texas-concrete-works'), 7),
((SELECT id FROM cleaners WHERE slug = 'texas-concrete-works'), 8),

-- 21. Houston Siding Experts -> Siding, Gutters
((SELECT id FROM cleaners WHERE slug = 'houston-siding-experts'), 10),
((SELECT id FROM cleaners WHERE slug = 'houston-siding-experts'), 13),

-- 22. Empire State Roofing -> Roofing
((SELECT id FROM cleaners WHERE slug = 'empire-state-roofing'), 1),

-- 23. NYC Master Plumbing -> Plumbing, Bathroom Remodeling
((SELECT id FROM cleaners WHERE slug = 'nyc-master-plumbing'), 6),
((SELECT id FROM cleaners WHERE slug = 'nyc-master-plumbing'), 5),

-- 24. Brooklyn Bath Design -> Bathroom Remodeling, Flooring
((SELECT id FROM cleaners WHERE slug = 'brooklyn-bath-design'), 5),
((SELECT id FROM cleaners WHERE slug = 'brooklyn-bath-design'), 16),

-- 25. Buffalo Insulation Pros -> Insulation
((SELECT id FROM cleaners WHERE slug = 'buffalo-insulation-pros'), 17),

-- 26. Rochester Pro Painting -> Painting, Handyman
((SELECT id FROM cleaners WHERE slug = 'rochester-pro-painting'), 14),
((SELECT id FROM cleaners WHERE slug = 'rochester-pro-painting'), 3),

-- 27. Chicago Roofing Authority -> Roofing, Siding, Gutters
((SELECT id FROM cleaners WHERE slug = 'chicago-roofing-authority'), 1),
((SELECT id FROM cleaners WHERE slug = 'chicago-roofing-authority'), 10),
((SELECT id FROM cleaners WHERE slug = 'chicago-roofing-authority'), 13),

-- 28. Windy City HVAC Services -> HVAC
((SELECT id FROM cleaners WHERE slug = 'windy-city-hvac-services'), 4),

-- 29. Chicagoland Flooring Co. -> Flooring
((SELECT id FROM cleaners WHERE slug = 'chicagoland-flooring-co'), 16),

-- 30. Aurora Handyman Connection -> Handyman, Painting
((SELECT id FROM cleaners WHERE slug = 'aurora-handyman-connection'), 3),
((SELECT id FROM cleaners WHERE slug = 'aurora-handyman-connection'), 14),

-- 31. Peachtree Builders Group -> General Cleaner, Home Renovation
((SELECT id FROM cleaners WHERE slug = 'peachtree-builders-group'), 2),
((SELECT id FROM cleaners WHERE slug = 'peachtree-builders-group'), 18),

-- 32. Atlanta Gutter Solutions -> Gutters
((SELECT id FROM cleaners WHERE slug = 'atlanta-gutter-solutions'), 13),

-- 33. Savannah Garage Transformations -> Garage Renovation, Home Renovation
((SELECT id FROM cleaners WHERE slug = 'savannah-garage-transformations'), 20),
((SELECT id FROM cleaners WHERE slug = 'savannah-garage-transformations'), 18),

-- 34. Charlotte Home Remodeling -> Home Remodeling, Kitchen Remodeling, Bathroom Remodeling
((SELECT id FROM cleaners WHERE slug = 'charlotte-home-remodeling'), 15),
((SELECT id FROM cleaners WHERE slug = 'charlotte-home-remodeling'), 9),
((SELECT id FROM cleaners WHERE slug = 'charlotte-home-remodeling'), 5),

-- 35. Raleigh Custom Decks -> Decks & Patios, Fencing
((SELECT id FROM cleaners WHERE slug = 'raleigh-custom-decks'), 8),
((SELECT id FROM cleaners WHERE slug = 'raleigh-custom-decks'), 11),

-- 36. Durham Basement Solutions -> Basement Finishing, Home Renovation
((SELECT id FROM cleaners WHERE slug = 'durham-basement-solutions'), 19),
((SELECT id FROM cleaners WHERE slug = 'durham-basement-solutions'), 18),

-- 37. Buckeye Roofing & Exteriors -> Roofing, Siding
((SELECT id FROM cleaners WHERE slug = 'buckeye-roofing-and-exteriors'), 1),
((SELECT id FROM cleaners WHERE slug = 'buckeye-roofing-and-exteriors'), 10),

-- 38. Cleveland Climate Control -> HVAC, Insulation
((SELECT id FROM cleaners WHERE slug = 'cleveland-climate-control'), 4),
((SELECT id FROM cleaners WHERE slug = 'cleveland-climate-control'), 17),

-- 39. Cincinnati Plumbing Co. -> Plumbing
((SELECT id FROM cleaners WHERE slug = 'cincinnati-plumbing-co'), 6),

-- 40. Philly Home Renovations -> Home Renovation, Home Remodeling, General Cleaner
((SELECT id FROM cleaners WHERE slug = 'philly-home-renovations'), 18),
((SELECT id FROM cleaners WHERE slug = 'philly-home-renovations'), 15),
((SELECT id FROM cleaners WHERE slug = 'philly-home-renovations'), 2),

-- 41. Pittsburgh Electric Solutions -> Electrical
((SELECT id FROM cleaners WHERE slug = 'pittsburgh-electric-solutions'), 12),

-- 42. Keystone Concrete & Masonry -> Concrete & Masonry
((SELECT id FROM cleaners WHERE slug = 'keystone-concrete-and-masonry'), 7),

-- 43. Desert Shield Roofing -> Roofing
((SELECT id FROM cleaners WHERE slug = 'desert-shield-roofing'), 1),

-- 44. Phoenix Comfort HVAC -> HVAC
((SELECT id FROM cleaners WHERE slug = 'phoenix-comfort-hvac'), 4),

-- 45. Tucson Handyman Hub -> Handyman, Painting, Electrical
((SELECT id FROM cleaners WHERE slug = 'tucson-handyman-hub'), 3),
((SELECT id FROM cleaners WHERE slug = 'tucson-handyman-hub'), 14),
((SELECT id FROM cleaners WHERE slug = 'tucson-handyman-hub'), 12),

-- 46. Emerald City Decks & Fencing -> Decks & Patios, Fencing
((SELECT id FROM cleaners WHERE slug = 'emerald-city-decks-and-fencing'), 8),
((SELECT id FROM cleaners WHERE slug = 'emerald-city-decks-and-fencing'), 11),

-- 47. Puget Sound Plumbing -> Plumbing
((SELECT id FROM cleaners WHERE slug = 'puget-sound-plumbing'), 6),

-- 48. Mile High Roofing & Gutters -> Roofing, Gutters
((SELECT id FROM cleaners WHERE slug = 'mile-high-roofing-and-gutters'), 1),
((SELECT id FROM cleaners WHERE slug = 'mile-high-roofing-and-gutters'), 13),

-- 49. Denver Insulation & Energy -> Insulation
((SELECT id FROM cleaners WHERE slug = 'denver-insulation-and-energy'), 17),

-- 50. Garden State Painting -> Painting
((SELECT id FROM cleaners WHERE slug = 'garden-state-painting'), 14),

-- 51. Virginia Coast Builders -> General Cleaner, Home Renovation
((SELECT id FROM cleaners WHERE slug = 'virginia-coast-builders'), 2),
((SELECT id FROM cleaners WHERE slug = 'virginia-coast-builders'), 18),

-- 52. Boston Bath Remodeling -> Bathroom Remodeling, Flooring
((SELECT id FROM cleaners WHERE slug = 'boston-bath-remodeling'), 5),
((SELECT id FROM cleaners WHERE slug = 'boston-bath-remodeling'), 16);


-- ============================================================
-- CLEANER SPECIALTIES (2-4 per cleaner)
-- ============================================================
INSERT INTO `cleaner_specialties` (`cleaner_id`, `name`) VALUES

-- 1. Sunshine Roofing Co.
((SELECT id FROM cleaners WHERE slug = 'sunshine-roofing-co'), 'Hurricane-Resistant Roofing'),
((SELECT id FROM cleaners WHERE slug = 'sunshine-roofing-co'), 'Tile Roof Installation'),
((SELECT id FROM cleaners WHERE slug = 'sunshine-roofing-co'), 'Storm Damage Repair'),
((SELECT id FROM cleaners WHERE slug = 'sunshine-roofing-co'), 'Roof Inspections'),

-- 2. Metro Plumbing Solutions
((SELECT id FROM cleaners WHERE slug = 'metro-plumbing-solutions'), 'Emergency Leak Repair'),
((SELECT id FROM cleaners WHERE slug = 'metro-plumbing-solutions'), 'Water Heater Installation'),
((SELECT id FROM cleaners WHERE slug = 'metro-plumbing-solutions'), 'Drain Cleaning'),

-- 3. Coastal Kitchen & Bath
((SELECT id FROM cleaners WHERE slug = 'coastal-kitchen-and-bath'), 'Custom Cabinetry'),
((SELECT id FROM cleaners WHERE slug = 'coastal-kitchen-and-bath'), 'Countertop Installation'),
((SELECT id FROM cleaners WHERE slug = 'coastal-kitchen-and-bath'), 'Luxury Bath Design'),
((SELECT id FROM cleaners WHERE slug = 'coastal-kitchen-and-bath'), 'Walk-In Showers'),

-- 4. Florida Comfort HVAC
((SELECT id FROM cleaners WHERE slug = 'florida-comfort-hvac'), 'AC Installation'),
((SELECT id FROM cleaners WHERE slug = 'florida-comfort-hvac'), 'Duct Cleaning'),
((SELECT id FROM cleaners WHERE slug = 'florida-comfort-hvac'), 'Smart Thermostat Setup'),

-- 5. Palm City Electrical
((SELECT id FROM cleaners WHERE slug = 'palm-city-electrical'), 'Panel Upgrades'),
((SELECT id FROM cleaners WHERE slug = 'palm-city-electrical'), 'Whole-House Rewiring'),
((SELECT id FROM cleaners WHERE slug = 'palm-city-electrical'), 'Generator Installation'),
((SELECT id FROM cleaners WHERE slug = 'palm-city-electrical'), 'Smart Home Wiring'),

-- 6. Tampa Bay Bath Remodeling
((SELECT id FROM cleaners WHERE slug = 'tampa-bay-bath-remodeling'), 'Walk-In Shower Conversion'),
((SELECT id FROM cleaners WHERE slug = 'tampa-bay-bath-remodeling'), 'ADA-Accessible Remodels'),
((SELECT id FROM cleaners WHERE slug = 'tampa-bay-bath-remodeling'), 'Custom Vanities'),

-- 7. First Coast General Contracting
((SELECT id FROM cleaners WHERE slug = 'first-coast-general-contracting'), 'New Home Construction'),
((SELECT id FROM cleaners WHERE slug = 'first-coast-general-contracting'), 'Room Additions'),
((SELECT id FROM cleaners WHERE slug = 'first-coast-general-contracting'), 'Commercial Buildouts'),
((SELECT id FROM cleaners WHERE slug = 'first-coast-general-contracting'), 'Project Management'),

-- 8. Bay Area Roofing Pros
((SELECT id FROM cleaners WHERE slug = 'bay-area-roofing-pros'), 'Flat Roof Systems'),
((SELECT id FROM cleaners WHERE slug = 'bay-area-roofing-pros'), 'Slate Roofing'),
((SELECT id FROM cleaners WHERE slug = 'bay-area-roofing-pros'), 'Green Roof Installation'),

-- 9. Pacific Plumbing & Drain
((SELECT id FROM cleaners WHERE slug = 'pacific-plumbing-and-drain'), 'Sewer Line Repair'),
((SELECT id FROM cleaners WHERE slug = 'pacific-plumbing-and-drain'), 'Tankless Water Heaters'),
((SELECT id FROM cleaners WHERE slug = 'pacific-plumbing-and-drain'), 'Whole-House Repiping'),
((SELECT id FROM cleaners WHERE slug = 'pacific-plumbing-and-drain'), 'Hydro Jetting'),

-- 10. SoCal Pro Painting
((SELECT id FROM cleaners WHERE slug = 'socal-pro-painting'), 'Interior Painting'),
((SELECT id FROM cleaners WHERE slug = 'socal-pro-painting'), 'Exterior House Painting'),
((SELECT id FROM cleaners WHERE slug = 'socal-pro-painting'), 'Cabinet Refinishing'),

-- 11. Golden State HVAC
((SELECT id FROM cleaners WHERE slug = 'golden-state-hvac'), 'Ductless Mini-Splits'),
((SELECT id FROM cleaners WHERE slug = 'golden-state-hvac'), 'High-Efficiency Systems'),
((SELECT id FROM cleaners WHERE slug = 'golden-state-hvac'), 'Zoned Heating & Cooling'),

-- 12. LA Decks & Outdoor Living
((SELECT id FROM cleaners WHERE slug = 'la-decks-and-outdoor-living'), 'Composite Decking'),
((SELECT id FROM cleaners WHERE slug = 'la-decks-and-outdoor-living'), 'Pergolas & Arbors'),
((SELECT id FROM cleaners WHERE slug = 'la-decks-and-outdoor-living'), 'Outdoor Kitchens'),

-- 13. SF Tile & Flooring
((SELECT id FROM cleaners WHERE slug = 'sf-tile-and-flooring'), 'Hardwood Installation'),
((SELECT id FROM cleaners WHERE slug = 'sf-tile-and-flooring'), 'Custom Tile Work'),
((SELECT id FROM cleaners WHERE slug = 'sf-tile-and-flooring'), 'Luxury Vinyl Plank'),
((SELECT id FROM cleaners WHERE slug = 'sf-tile-and-flooring'), 'Floor Refinishing'),

-- 14. Sacramento Fence & Gate
((SELECT id FROM cleaners WHERE slug = 'sacramento-fence-and-gate'), 'Wood Privacy Fences'),
((SELECT id FROM cleaners WHERE slug = 'sacramento-fence-and-gate'), 'Automated Gates'),

-- 15. Lone Star Roofing & Construction
((SELECT id FROM cleaners WHERE slug = 'lone-star-roofing-and-construction'), 'Impact-Resistant Shingles'),
((SELECT id FROM cleaners WHERE slug = 'lone-star-roofing-and-construction'), 'Metal Roofing'),
((SELECT id FROM cleaners WHERE slug = 'lone-star-roofing-and-construction'), 'Insurance Claim Assistance'),

-- 16. Texas Handyman Services
((SELECT id FROM cleaners WHERE slug = 'texas-handyman-services'), 'Drywall Repair'),
((SELECT id FROM cleaners WHERE slug = 'texas-handyman-services'), 'Door & Window Installation'),
((SELECT id FROM cleaners WHERE slug = 'texas-handyman-services'), 'Furniture Assembly'),

-- 17. Dallas Kitchen Design Studio
((SELECT id FROM cleaners WHERE slug = 'dallas-kitchen-design-studio'), 'Custom Kitchen Cabinets'),
((SELECT id FROM cleaners WHERE slug = 'dallas-kitchen-design-studio'), 'Quartz & Granite Countertops'),
((SELECT id FROM cleaners WHERE slug = 'dallas-kitchen-design-studio'), '3D Kitchen Design'),
((SELECT id FROM cleaners WHERE slug = 'dallas-kitchen-design-studio'), 'Appliance Installation'),

-- 18. Austin Home Renovations
((SELECT id FROM cleaners WHERE slug = 'austin-home-renovations'), 'Whole-House Renovation'),
((SELECT id FROM cleaners WHERE slug = 'austin-home-renovations'), 'Open-Concept Conversions'),
((SELECT id FROM cleaners WHERE slug = 'austin-home-renovations'), 'ADU Construction'),

-- 19. SA Town Electric
((SELECT id FROM cleaners WHERE slug = 'sa-town-electric'), 'EV Charger Installation'),
((SELECT id FROM cleaners WHERE slug = 'sa-town-electric'), 'Lighting Design'),
((SELECT id FROM cleaners WHERE slug = 'sa-town-electric'), 'Code Violation Repair'),

-- 20. Texas Concrete Works
((SELECT id FROM cleaners WHERE slug = 'texas-concrete-works'), 'Stamped Concrete'),
((SELECT id FROM cleaners WHERE slug = 'texas-concrete-works'), 'Driveway Pouring'),
((SELECT id FROM cleaners WHERE slug = 'texas-concrete-works'), 'Retaining Walls'),
((SELECT id FROM cleaners WHERE slug = 'texas-concrete-works'), 'Pool Decks'),

-- 21. Houston Siding Experts
((SELECT id FROM cleaners WHERE slug = 'houston-siding-experts'), 'James Hardie Siding'),
((SELECT id FROM cleaners WHERE slug = 'houston-siding-experts'), 'Vinyl Siding'),
((SELECT id FROM cleaners WHERE slug = 'houston-siding-experts'), 'Soffit & Fascia'),

-- 22. Empire State Roofing
((SELECT id FROM cleaners WHERE slug = 'empire-state-roofing'), 'TPO Flat Roofing'),
((SELECT id FROM cleaners WHERE slug = 'empire-state-roofing'), 'EPDM Systems'),
((SELECT id FROM cleaners WHERE slug = 'empire-state-roofing'), 'Landmark Building Roofing'),

-- 23. NYC Master Plumbing
((SELECT id FROM cleaners WHERE slug = 'nyc-master-plumbing'), 'Boiler Repair'),
((SELECT id FROM cleaners WHERE slug = 'nyc-master-plumbing'), 'Backflow Prevention'),
((SELECT id FROM cleaners WHERE slug = 'nyc-master-plumbing'), 'Gas Line Installation'),

-- 24. Brooklyn Bath Design
((SELECT id FROM cleaners WHERE slug = 'brooklyn-bath-design'), 'Custom Tile Showers'),
((SELECT id FROM cleaners WHERE slug = 'brooklyn-bath-design'), 'Frameless Glass Enclosures'),
((SELECT id FROM cleaners WHERE slug = 'brooklyn-bath-design'), 'Heated Flooring'),

-- 25. Buffalo Insulation Pros
((SELECT id FROM cleaners WHERE slug = 'buffalo-insulation-pros'), 'Spray Foam Insulation'),
((SELECT id FROM cleaners WHERE slug = 'buffalo-insulation-pros'), 'Blown-In Cellulose'),
((SELECT id FROM cleaners WHERE slug = 'buffalo-insulation-pros'), 'Energy Audits'),

-- 26. Rochester Pro Painting
((SELECT id FROM cleaners WHERE slug = 'rochester-pro-painting'), 'Interior Repainting'),
((SELECT id FROM cleaners WHERE slug = 'rochester-pro-painting'), 'Exterior Painting'),

-- 27. Chicago Roofing Authority
((SELECT id FROM cleaners WHERE slug = 'chicago-roofing-authority'), 'Architectural Shingles'),
((SELECT id FROM cleaners WHERE slug = 'chicago-roofing-authority'), 'Standing Seam Metal'),
((SELECT id FROM cleaners WHERE slug = 'chicago-roofing-authority'), 'Ice Dam Prevention'),

-- 28. Windy City HVAC Services
((SELECT id FROM cleaners WHERE slug = 'windy-city-hvac-services'), 'Furnace Installation'),
((SELECT id FROM cleaners WHERE slug = 'windy-city-hvac-services'), 'Boiler Systems'),
((SELECT id FROM cleaners WHERE slug = 'windy-city-hvac-services'), 'Preventive Maintenance Plans'),

-- 29. Chicagoland Flooring Co.
((SELECT id FROM cleaners WHERE slug = 'chicagoland-flooring-co'), 'Hardwood Refinishing'),
((SELECT id FROM cleaners WHERE slug = 'chicagoland-flooring-co'), 'Engineered Wood Flooring'),
((SELECT id FROM cleaners WHERE slug = 'chicagoland-flooring-co'), 'Carpet Installation'),

-- 30. Aurora Handyman Connection
((SELECT id FROM cleaners WHERE slug = 'aurora-handyman-connection'), 'Deck Staining'),
((SELECT id FROM cleaners WHERE slug = 'aurora-handyman-connection'), 'Gutter Cleaning'),
((SELECT id FROM cleaners WHERE slug = 'aurora-handyman-connection'), 'Appliance Installation'),

-- 31. Peachtree Builders Group
((SELECT id FROM cleaners WHERE slug = 'peachtree-builders-group'), 'New Home Construction'),
((SELECT id FROM cleaners WHERE slug = 'peachtree-builders-group'), 'Major Renovations'),
((SELECT id FROM cleaners WHERE slug = 'peachtree-builders-group'), 'Commercial Buildouts'),
((SELECT id FROM cleaners WHERE slug = 'peachtree-builders-group'), 'Design-Build Services'),

-- 32. Atlanta Gutter Solutions
((SELECT id FROM cleaners WHERE slug = 'atlanta-gutter-solutions'), 'Seamless Aluminum Gutters'),
((SELECT id FROM cleaners WHERE slug = 'atlanta-gutter-solutions'), 'Gutter Guard Installation'),

-- 33. Savannah Garage Transformations
((SELECT id FROM cleaners WHERE slug = 'savannah-garage-transformations'), 'Garage Conversions'),
((SELECT id FROM cleaners WHERE slug = 'savannah-garage-transformations'), 'Epoxy Floor Coating'),
((SELECT id FROM cleaners WHERE slug = 'savannah-garage-transformations'), 'Custom Storage Systems'),

-- 34. Charlotte Home Remodeling
((SELECT id FROM cleaners WHERE slug = 'charlotte-home-remodeling'), 'Kitchen Remodels'),
((SELECT id FROM cleaners WHERE slug = 'charlotte-home-remodeling'), 'Bath Renovations'),
((SELECT id FROM cleaners WHERE slug = 'charlotte-home-remodeling'), 'Room Additions'),
((SELECT id FROM cleaners WHERE slug = 'charlotte-home-remodeling'), 'Design-Build'),

-- 35. Raleigh Custom Decks
((SELECT id FROM cleaners WHERE slug = 'raleigh-custom-decks'), 'Trex Composite Decks'),
((SELECT id FROM cleaners WHERE slug = 'raleigh-custom-decks'), 'Screened Porches'),
((SELECT id FROM cleaners WHERE slug = 'raleigh-custom-decks'), 'Outdoor Kitchens'),

-- 36. Durham Basement Solutions
((SELECT id FROM cleaners WHERE slug = 'durham-basement-solutions'), 'Basement Finishing'),
((SELECT id FROM cleaners WHERE slug = 'durham-basement-solutions'), 'Waterproofing'),
((SELECT id FROM cleaners WHERE slug = 'durham-basement-solutions'), 'Home Theater Rooms'),

-- 37. Buckeye Roofing & Exteriors
((SELECT id FROM cleaners WHERE slug = 'buckeye-roofing-and-exteriors'), 'Owens Corning Shingles'),
((SELECT id FROM cleaners WHERE slug = 'buckeye-roofing-and-exteriors'), 'Drone Roof Inspections'),
((SELECT id FROM cleaners WHERE slug = 'buckeye-roofing-and-exteriors'), 'Window Replacement'),

-- 38. Cleveland Climate Control
((SELECT id FROM cleaners WHERE slug = 'cleveland-climate-control'), 'High-Efficiency Furnaces'),
((SELECT id FROM cleaners WHERE slug = 'cleveland-climate-control'), 'Central Air Conditioning'),
((SELECT id FROM cleaners WHERE slug = 'cleveland-climate-control'), 'Ductwork Design'),

-- 39. Cincinnati Plumbing Co.
((SELECT id FROM cleaners WHERE slug = 'cincinnati-plumbing-co'), 'Water Heater Repair'),
((SELECT id FROM cleaners WHERE slug = 'cincinnati-plumbing-co'), 'Drain Unclogging'),
((SELECT id FROM cleaners WHERE slug = 'cincinnati-plumbing-co'), 'Plumbing Renovations'),

-- 40. Philly Home Renovations
((SELECT id FROM cleaners WHERE slug = 'philly-home-renovations'), 'Rowhome Renovations'),
((SELECT id FROM cleaners WHERE slug = 'philly-home-renovations'), 'Historic Restoration'),
((SELECT id FROM cleaners WHERE slug = 'philly-home-renovations'), 'Gut Renovations'),
((SELECT id FROM cleaners WHERE slug = 'philly-home-renovations'), 'Structural Repairs'),

-- 41. Pittsburgh Electric Solutions
((SELECT id FROM cleaners WHERE slug = 'pittsburgh-electric-solutions'), 'Electrical Panel Upgrades'),
((SELECT id FROM cleaners WHERE slug = 'pittsburgh-electric-solutions'), 'Generator Hookups'),
((SELECT id FROM cleaners WHERE slug = 'pittsburgh-electric-solutions'), 'LED Lighting Retrofits'),

-- 42. Keystone Concrete & Masonry
((SELECT id FROM cleaners WHERE slug = 'keystone-concrete-and-masonry'), 'Foundation Work'),
((SELECT id FROM cleaners WHERE slug = 'keystone-concrete-and-masonry'), 'Brick & Stone Veneer'),
((SELECT id FROM cleaners WHERE slug = 'keystone-concrete-and-masonry'), 'Stamped Concrete Patios'),

-- 43. Desert Shield Roofing
((SELECT id FROM cleaners WHERE slug = 'desert-shield-roofing'), 'Tile Roofing'),
((SELECT id FROM cleaners WHERE slug = 'desert-shield-roofing'), 'Foam Roofing'),
((SELECT id FROM cleaners WHERE slug = 'desert-shield-roofing'), 'Cool Roof Coatings'),

-- 44. Phoenix Comfort HVAC
((SELECT id FROM cleaners WHERE slug = 'phoenix-comfort-hvac'), 'High-SEER AC Systems'),
((SELECT id FROM cleaners WHERE slug = 'phoenix-comfort-hvac'), 'Heat Pump Installation'),
((SELECT id FROM cleaners WHERE slug = 'phoenix-comfort-hvac'), 'Evaporative Coolers'),

-- 45. Tucson Handyman Hub
((SELECT id FROM cleaners WHERE slug = 'tucson-handyman-hub'), 'General Home Repairs'),
((SELECT id FROM cleaners WHERE slug = 'tucson-handyman-hub'), 'Painting & Touch-Ups'),

-- 46. Emerald City Decks & Fencing
((SELECT id FROM cleaners WHERE slug = 'emerald-city-decks-and-fencing'), 'Cedar Decking'),
((SELECT id FROM cleaners WHERE slug = 'emerald-city-decks-and-fencing'), 'Composite Fencing'),
((SELECT id FROM cleaners WHERE slug = 'emerald-city-decks-and-fencing'), 'Pergola Construction'),

-- 47. Puget Sound Plumbing
((SELECT id FROM cleaners WHERE slug = 'puget-sound-plumbing'), 'Sewer Repair'),
((SELECT id FROM cleaners WHERE slug = 'puget-sound-plumbing'), 'Gas Line Installation'),
((SELECT id FROM cleaners WHERE slug = 'puget-sound-plumbing'), 'Bathroom Plumbing'),

-- 48. Mile High Roofing & Gutters
((SELECT id FROM cleaners WHERE slug = 'mile-high-roofing-and-gutters'), 'Hail Damage Repair'),
((SELECT id FROM cleaners WHERE slug = 'mile-high-roofing-and-gutters'), 'Metal Roofing'),
((SELECT id FROM cleaners WHERE slug = 'mile-high-roofing-and-gutters'), 'Gutter Guard Systems'),

-- 49. Denver Insulation & Energy
((SELECT id FROM cleaners WHERE slug = 'denver-insulation-and-energy'), 'Spray Foam Insulation'),
((SELECT id FROM cleaners WHERE slug = 'denver-insulation-and-energy'), 'Blown-In Fiberglass'),
((SELECT id FROM cleaners WHERE slug = 'denver-insulation-and-energy'), 'Home Energy Audits'),
((SELECT id FROM cleaners WHERE slug = 'denver-insulation-and-energy'), 'Air Sealing'),

-- 50. Garden State Painting
((SELECT id FROM cleaners WHERE slug = 'garden-state-painting'), 'Interior Painting'),
((SELECT id FROM cleaners WHERE slug = 'garden-state-painting'), 'Exterior Painting'),
((SELECT id FROM cleaners WHERE slug = 'garden-state-painting'), 'Deck Staining'),

-- 51. Virginia Coast Builders
((SELECT id FROM cleaners WHERE slug = 'virginia-coast-builders'), 'Residential Construction'),
((SELECT id FROM cleaners WHERE slug = 'virginia-coast-builders'), 'Commercial Improvements'),
((SELECT id FROM cleaners WHERE slug = 'virginia-coast-builders'), 'Military Housing'),

-- 52. Boston Bath Remodeling
((SELECT id FROM cleaners WHERE slug = 'boston-bath-remodeling'), 'Tub-to-Shower Conversions'),
((SELECT id FROM cleaners WHERE slug = 'boston-bath-remodeling'), 'Custom Tile Showers'),
((SELECT id FROM cleaners WHERE slug = 'boston-bath-remodeling'), 'Vanity Installation'),
((SELECT id FROM cleaners WHERE slug = 'boston-bath-remodeling'), 'Historic Home Bathrooms');

SET FOREIGN_KEY_CHECKS = 1;
