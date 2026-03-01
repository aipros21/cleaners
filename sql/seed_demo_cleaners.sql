-- ============================================================
-- seed_demo_cleaners.sql
-- 1 admin + 60 cleaning businesses across 20 categories
-- States: FL(10), CA(5), TX(44), NY(33), IL(14), GA(11),
--         AZ(3), CO(6), WA(48), NV(29), NC(34), NJ(31)
-- ============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- Clear existing data
TRUNCATE TABLE `cleaner_specialties`;
TRUNCATE TABLE `cleaner_categories`;
TRUNCATE TABLE `cleaner_discounts`;
TRUNCATE TABLE `cleaner_service_areas`;
TRUNCATE TABLE `cleaner_photos`;
TRUNCATE TABLE `reviews`;
TRUNCATE TABLE `lead_assignments`;
TRUNCATE TABLE `leads`;
TRUNCATE TABLE `sponsored_listings`;
TRUNCATE TABLE `payments`;
TRUNCATE TABLE `cleaners`;
DELETE FROM `users`;
ALTER TABLE `users` AUTO_INCREMENT = 1;
ALTER TABLE `cleaners` AUTO_INCREMENT = 1;

-- ============================================================
-- ADMIN USER (ID=1)
-- ============================================================
INSERT INTO `users` (`email`, `password`, `role`, `first_name`, `last_name`, `phone`, `email_verified`, `status`) VALUES
('admin@cleaners-247.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'Admin', 'User', '305-555-0100', 1, 'active');

-- ============================================================
-- CLEANER USERS (IDs 2-61)
-- ============================================================
INSERT INTO `users` (`email`, `password`, `role`, `first_name`, `last_name`, `phone`, `email_verified`, `status`) VALUES
-- Florida (1-10)
('info@sparklehomecleaning.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Maria', 'Gonzalez', '305-555-0201', 1, 'active'),
('info@miamimaidservice.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Jessica', 'Perez', '305-555-0202', 1, 'active'),
('info@floridafreshclean.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Laura', 'Chen', '561-555-0203', 1, 'active'),
('info@sunshinedeepclean.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Angela', 'Rivera', '954-555-0204', 1, 'active'),
('info@gulfcoastcommercial.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Robert', 'Williams', '813-555-0205', 1, 'active'),
('info@tampacarpetpros.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'James', 'Thompson', '813-555-0206', 1, 'active'),
('info@orlandopressurewash.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Carlos', 'Martinez', '407-555-0207', 1, 'active'),
('info@pbwindowmasters.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'David', 'Lee', '561-555-0208', 1, 'active'),
('info@ftlpoolcare.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Anthony', 'Garcia', '954-555-0209', 1, 'active'),
('info@jaxjanitorial.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Marcus', 'Johnson', '904-555-0210', 1, 'active'),
-- California (11-18)
('info@lapristinecleaning.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Michelle', 'Kim', '310-555-0211', 1, 'active'),
('info@bayareaecoclean.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Sarah', 'Nguyen', '415-555-0212', 1, 'active'),
('info@socalcarpettile.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Daniel', 'Rodriguez', '619-555-0213', 1, 'active'),
('info@goldenstatewindow.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Kevin', 'Park', '213-555-0214', 1, 'active'),
('info@sacmoveclean.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Jennifer', 'Taylor', '916-555-0215', 1, 'active'),
('info@sdofficeclean.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Brian', 'Anderson', '619-555-0216', 1, 'active'),
('info@malibuvacationclean.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Rachel', 'White', '310-555-0217', 1, 'active'),
('info@svjanitorial.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Andrew', 'Patel', '408-555-0218', 1, 'active'),
-- Texas (19-26)
('info@houstonhousehelpers.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Rosa', 'Hernandez', '713-555-0219', 1, 'active'),
('info@dallasdeepclean.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Michael', 'Davis', '214-555-0220', 1, 'active'),
('info@austinecomaids.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Emily', 'Wilson', '512-555-0221', 1, 'active'),
('info@sapressurepros.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Jose', 'Lopez', '210-555-0222', 1, 'active'),
('info@dfwcommercial.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Thomas', 'Brown', '817-555-0223', 1, 'active'),
('info@txairductpros.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Steven', 'Miller', '214-555-0224', 1, 'active'),
('info@houstonrestaurantclean.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Patricia', 'Moore', '713-555-0225', 1, 'active'),
('info@fwpostconstruction.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Richard', 'Clark', '817-555-0226', 1, 'active'),
-- New York (27-33)
('info@nycspotless.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Anna', 'Petrov', '212-555-0227', 1, 'active'),
('info@manhattanmaidco.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Lisa', 'Chang', '212-555-0228', 1, 'active'),
('info@brooklyncarpetcare.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'William', 'O\'Brien', '718-555-0229', 1, 'active'),
('info@empirewindowcleaning.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Gregory', 'Santos', '212-555-0230', 1, 'active'),
('info@queensofficemaint.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Kenneth', 'Ali', '718-555-0231', 1, 'active'),
('info@bronxmedicalclean.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Sandra', 'Washington', '718-555-0232', 1, 'active'),
('info@lipoolpatio.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Frank', 'DeLuca', '516-555-0233', 1, 'active'),
-- Illinois (34-38)
('info@chicagocleanteam.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Natalie', 'Brooks', '312-555-0234', 1, 'active'),
('info@windycityupholstery.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Derek', 'Foster', '312-555-0235', 1, 'active'),
('info@springfieldtile.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Paul', 'Mitchell', '217-555-0236', 1, 'active'),
('info@ilairqualitypros.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Raymond', 'Scott', '312-555-0237', 1, 'active'),
('info@chirestaurantclean.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Christina', 'Reyes', '312-555-0238', 1, 'active'),
-- Georgia (39-42)
('info@atlantafreshclean.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Keisha', 'Jackson', '404-555-0239', 1, 'active'),
('info@peachstatepw.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Brandon', 'Harris', '404-555-0240', 1, 'active'),
('info@gamedicalclean.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Diana', 'Powell', '678-555-0241', 1, 'active'),
('info@savannahvacation.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Brittany', 'Cooper', '912-555-0242', 1, 'active'),
-- Arizona (43-46)
('info@phxtilegrout.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Nathan', 'Reed', '602-555-0243', 1, 'active'),
('info@scottsdalehoardinghelp.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Samantha', 'Torres', '480-555-0244', 1, 'active'),
('info@tucsonpoolclean.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Victor', 'Ramirez', '520-555-0245', 1, 'active'),
('info@azdesertclean.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Cynthia', 'Bell', '602-555-0246', 1, 'active'),
-- Colorado (47-50)
('info@denvergreenmaids.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Megan', 'Evans', '303-555-0247', 1, 'active'),
('info@boulderecoclean.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Tyler', 'Hughes', '303-555-0248', 1, 'active'),
('info@csofficepro.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Christine', 'Murphy', '719-555-0249', 1, 'active'),
('info@aspenvacationclean.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Jason', 'Sullivan', '970-555-0250', 1, 'active'),
-- Washington (51-53)
('info@seattlecleanscene.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Amy', 'Nakamura', '206-555-0251', 1, 'active'),
('info@tacomaindustrialclean.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Patrick', 'Kelly', '253-555-0252', 1, 'active'),
('info@olympiarestaurantclean.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Hannah', 'Stewart', '360-555-0253', 1, 'active'),
-- Nevada (54-56)
('info@vegasstripclean.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Marco', 'Rossi', '702-555-0254', 1, 'active'),
('info@renoairductclean.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Diane', 'Collins', '775-555-0255', 1, 'active'),
('info@vegasmedicalclean.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'George', 'Adams', '702-555-0256', 1, 'active'),
-- North Carolina (57-58)
('info@charlottemoveclean.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Stephanie', 'Barnes', '704-555-0257', 1, 'active'),
('info@raleighhoarding.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Larry', 'Griffin', '919-555-0258', 1, 'active'),
-- New Jersey (59-60)
('info@jerseywindowclean.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Vincent', 'Romano', '201-555-0259', 1, 'active'),
('info@newarkwarehouseclean.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cleaner', 'Janice', 'Price', '973-555-0260', 1, 'active');

-- ============================================================
-- CLEANER PROFILES (IDs 1-60, user_id 2-61)
-- state_id: FL=10, CA=5, TX=44, NY=33, IL=14, GA=11, AZ=3, CO=6, WA=48, NV=29, NC=34, NJ=31
-- ============================================================
INSERT INTO `cleaners` (`user_id`, `business_name`, `slug`, `tagline`, `description`, `phone`, `email`, `website`, `address`, `city_id`, `state_id`, `zip_code`, `lat`, `lng`, `license_number`, `license_verified`, `is_insured`, `is_verified`, `is_featured`, `years_experience`, `employees_count`, `plan`, `avg_rating`, `review_count`, `profile_views`, `leads_received`, `status`, `created_at`) VALUES

-- FL cleaners (1-10)
(2, 'Sparkle Home Cleaning', 'sparkle-home-cleaning', 'Making homes sparkle since 2015', 'Professional house cleaning and deep cleaning services in Miami-Dade County. Our trained team uses premium products to leave your home spotless. Weekly, bi-weekly, and one-time cleaning packages available.', '305-555-0201', 'info@sparklehomecleaning.com', 'https://sparklehomecleaning.com', '2847 NW 7th Ave, Miami, FL', NULL, 10, '33127', 25.7990, -80.2110, 'FL-CLN-10234', 1, 1, 1, 1, 9, '8-15', 'premium', 4.87, 3, 1245, 89, 'active', '2024-03-15 10:00:00'),

(3, 'Miami Maid Service', 'miami-maid-service', 'Your trusted Miami cleaning team', 'Full-service residential cleaning company specializing in house cleaning and move-in/move-out services. Licensed and insured with background-checked employees. Serving all of Miami-Dade.', '305-555-0202', 'info@miamimaidservice.com', 'https://miamimaidservice.com', '1540 Brickell Ave, Miami, FL', NULL, 10, '33129', 25.7580, -80.1920, 'FL-CLN-10567', 1, 1, 1, 1, 7, '5-10', 'pro', 4.73, 3, 980, 67, 'active', '2024-05-20 09:00:00'),

(4, 'Florida Fresh Clean', 'florida-fresh-clean', 'Eco-friendly cleaning for Florida homes', 'Green cleaning service using only plant-based, non-toxic products. Safe for kids, pets, and the environment. Residential cleaning throughout Palm Beach County.', '561-555-0203', 'info@floridafreshclean.com', 'https://floridafreshclean.com', '320 S County Rd, Palm Beach, FL', NULL, 10, '33480', 26.7056, -80.0364, 'FL-CLN-10890', 1, 1, 1, 0, 5, '3-5', 'basic', 4.60, 3, 520, 34, 'active', '2024-08-10 11:00:00'),

(5, 'Sunshine Deep Clean Co.', 'sunshine-deep-clean', 'Deep cleaning specialists in South Florida', 'Intensive deep cleaning for homes and offices in Fort Lauderdale and surrounding areas. We tackle every surface, appliance, and hidden corner. Perfect for spring cleaning or pre-event prep.', '954-555-0204', 'info@sunshinedeepclean.com', 'https://sunshinedeepclean.com', '901 SE 17th St, Fort Lauderdale, FL', NULL, 10, '33316', 26.0998, -80.1240, 'FL-CLN-11023', 1, 1, 1, 0, 6, '5-10', 'pro', 4.80, 3, 710, 52, 'active', '2024-06-05 10:30:00'),

(6, 'Gulf Coast Commercial Cleaning', 'gulf-coast-commercial-cleaning', 'Tampa Bay commercial cleaning experts', 'Full-service commercial and office cleaning company serving Tampa Bay businesses. Daily, weekly, or monthly contracts available. Floor care, restroom sanitization, and common area maintenance.', '813-555-0205', 'info@gulfcoastcommercial.com', 'https://gulfcoastcommercial.com', '4220 W Boy Scout Blvd, Tampa, FL', NULL, 10, '33607', 27.9525, -82.5080, 'FL-CLN-11456', 1, 1, 1, 1, 12, '15-30', 'premium', 4.90, 3, 890, 78, 'active', '2024-02-28 08:00:00'),

(7, 'Tampa Bay Carpet Pros', 'tampa-bay-carpet-pros', 'Professional carpet and upholstery care', 'Expert carpet cleaning with truck-mounted steam extraction. We also handle upholstery, area rugs, and pet stain removal. Serving Tampa, St. Pete, and Clearwater.', '813-555-0206', 'info@tampacarpetpros.com', 'https://tampacarpetpros.com', '5628 E Hillsborough Ave, Tampa, FL', NULL, 10, '33610', 27.9889, -82.3890, 'FL-CLN-11789', 1, 1, 1, 0, 8, '3-5', 'basic', 4.53, 3, 445, 38, 'active', '2024-07-12 09:30:00'),

(8, 'Orlando Pressure Wash', 'orlando-pressure-wash', 'Power washing Orlando driveways and homes', 'Professional pressure washing for driveways, sidewalks, pool decks, building exteriors, and roofs. Commercial and residential services throughout Central Florida.', '407-555-0207', 'info@orlandopressurewash.com', 'https://orlandopressurewash.com', '3900 S Orange Ave, Orlando, FL', NULL, 10, '32806', 28.5043, -81.3730, 'FL-CLN-12012', 1, 1, 1, 0, 10, '5-10', 'pro', 4.67, 3, 620, 45, 'active', '2024-04-18 10:00:00'),

(9, 'Palm Beach Window Masters', 'palm-beach-window-masters', 'Crystal-clear windows guaranteed', 'Interior and exterior window cleaning for homes, condos, and commercial buildings in Palm Beach County. We also offer pressure washing and gutter cleaning. Licensed and insured.', '561-555-0208', 'info@pbwindowmasters.com', 'https://pbwindowmasters.com', '710 N Flagler Dr, West Palm Beach, FL', NULL, 10, '33401', 26.7210, -80.0530, 'FL-CLN-12345', 1, 1, 1, 0, 6, '3-5', 'basic', 4.47, 3, 380, 28, 'active', '2024-09-01 11:00:00'),

(10, 'Fort Lauderdale Pool Care', 'fort-lauderdale-pool-care', 'Keeping Broward pools crystal clear', 'Weekly pool cleaning and maintenance in Broward County. Chemical balancing, skimming, vacuuming, filter cleaning, and equipment repair. Residential and commercial pools.', '954-555-0209', 'info@ftlpoolcare.com', 'https://ftlpoolcare.com', '2100 E Las Olas Blvd, Fort Lauderdale, FL', NULL, 10, '33301', 26.1180, -80.1290, 'FL-CLN-12678', 1, 1, 1, 0, 11, '5-10', 'pro', 4.70, 3, 550, 42, 'active', '2024-03-22 09:00:00'),

(11, 'Jacksonville Janitorial', 'jacksonville-janitorial', 'Northeast Florida janitorial experts', 'Comprehensive janitorial and commercial cleaning services for offices, medical facilities, schools, and retail spaces in Jacksonville and Northeast Florida.', '904-555-0210', 'info@jaxjanitorial.com', 'https://jaxjanitorial.com', '1601 Prudential Dr, Jacksonville, FL', NULL, 10, '32207', 30.3180, -81.6410, 'FL-CLN-13001', 1, 1, 1, 0, 15, '30-50', 'premium', 4.83, 3, 670, 56, 'active', '2024-01-15 08:30:00'),

-- CA cleaners (11-18 => cleaner IDs 11-18, user_ids 12-19)
(12, 'LA Pristine Cleaning', 'la-pristine-cleaning', 'Los Angeles premium home cleaning', 'High-end residential cleaning in Los Angeles and Beverly Hills. Our uniformed, bonded teams deliver meticulous house cleaning and deep cleaning services tailored to luxury homes.', '310-555-0211', 'info@lapristinecleaning.com', 'https://lapristinecleaning.com', '9460 Wilshire Blvd, Beverly Hills, CA', NULL, 5, '90212', 34.0660, -118.3990, 'CA-CLN-20123', 1, 1, 1, 1, 8, '10-20', 'premium', 4.93, 3, 1320, 95, 'active', '2024-02-10 10:00:00'),

(13, 'Bay Area Eco Clean', 'bay-area-eco-clean', 'San Francisco green cleaning leaders', 'Certified green cleaning service using only EWG-rated, plant-based products. Serving San Francisco, Oakland, and the entire Bay Area. Carbon-neutral operations.', '415-555-0212', 'info@bayareaecoclean.com', 'https://bayareaecoclean.com', '580 Market St, San Francisco, CA', NULL, 5, '94104', 37.7890, -122.4010, 'CA-CLN-20456', 1, 1, 1, 0, 6, '5-10', 'pro', 4.77, 3, 780, 58, 'active', '2024-06-15 09:00:00'),

(14, 'SoCal Carpet & Tile', 'socal-carpet-tile', 'Southern California floor care experts', 'Professional carpet cleaning, tile and grout restoration, and natural stone care throughout San Diego and Orange County. Truck-mounted steam cleaning and hand-sealed grout.', '619-555-0213', 'info@socalcarpettile.com', 'https://socalcarpettile.com', '750 B St, San Diego, CA', NULL, 5, '92101', 32.7157, -117.1611, 'CA-CLN-20789', 1, 1, 1, 0, 9, '5-10', 'pro', 4.63, 3, 510, 40, 'active', '2024-04-20 10:30:00'),

(15, 'Golden State Window Cleaning', 'golden-state-window-cleaning', 'Spotless windows across California', 'Residential and commercial window cleaning in the Greater Los Angeles area. High-rise, storefront, and post-construction window services. Fully insured with safety certifications.', '213-555-0214', 'info@goldenstatewindow.com', 'https://goldenstatewindow.com', '801 S Grand Ave, Los Angeles, CA', NULL, 5, '90017', 34.0470, -118.2600, 'CA-CLN-21012', 1, 1, 1, 0, 11, '8-15', 'pro', 4.57, 3, 430, 32, 'active', '2024-07-08 11:00:00'),

(16, 'Sacramento Move Clean', 'sacramento-move-clean', 'Move-in/move-out cleaning specialists', 'Sacramento area specialists in move-in and move-out cleaning. We work with realtors, property managers, and tenants to ensure homes pass inspection. Deep cleaning included.', '916-555-0215', 'info@sacmoveclean.com', 'https://sacmoveclean.com', '1515 K St, Sacramento, CA', NULL, 5, '95814', 38.5816, -121.4944, 'CA-CLN-21345', 1, 1, 1, 0, 4, '3-5', 'basic', 4.50, 3, 340, 25, 'active', '2024-09-12 09:30:00'),

(17, 'San Diego Office Clean', 'san-diego-office-clean', 'Professional office cleaning in San Diego', 'Daily and weekly office cleaning contracts for San Diego businesses. Restroom care, floor maintenance, trash removal, kitchen sanitization, and executive suite detailing.', '619-555-0216', 'info@sdofficeclean.com', 'https://sdofficeclean.com', '600 W Broadway, San Diego, CA', NULL, 5, '92101', 32.7194, -117.1666, 'CA-CLN-21678', 1, 1, 1, 0, 7, '10-20', 'pro', 4.70, 3, 490, 37, 'active', '2024-05-25 10:00:00'),

(18, 'Malibu Vacation Clean', 'malibu-vacation-clean', 'Premium Airbnb turnover cleaning', 'Luxury vacation rental turnover cleaning in Malibu, Santa Monica, and the Westside. Same-day turnovers, linen service coordination, and restocking. Trusted by Superhosts.', '310-555-0217', 'info@malibuvacationclean.com', 'https://malibuvacationclean.com', '22775 Pacific Coast Hwy, Malibu, CA', NULL, 5, '90265', 34.0358, -118.6880, 'CA-CLN-22001', 1, 1, 1, 1, 5, '5-10', 'premium', 4.87, 3, 650, 48, 'active', '2024-03-30 11:00:00'),

(19, 'Silicon Valley Janitorial', 'silicon-valley-janitorial', 'Tech office cleaning specialists', 'Janitorial and office cleaning for tech companies and startups in San Jose, Cupertino, and Mountain View. After-hours cleaning, server room maintenance, and green products.', '408-555-0218', 'info@svjanitorial.com', 'https://svjanitorial.com', '100 N Winchester Blvd, San Jose, CA', NULL, 5, '95128', 37.3230, -121.9470, 'CA-CLN-22234', 1, 1, 1, 0, 10, '20-50', 'premium', 4.80, 3, 570, 44, 'active', '2024-04-05 08:00:00'),

-- TX cleaners (19-26 => cleaner IDs 19-26, user_ids 20-27)
(20, 'Houston House Helpers', 'houston-house-helpers', 'Affordable house cleaning in Houston', 'Reliable and affordable house cleaning for Houston families. Weekly, bi-weekly, and monthly plans. We also specialize in move-in/move-out cleaning for apartments and homes.', '713-555-0219', 'info@houstonhousehelpers.com', 'https://houstonhousehelpers.com', '4500 Westheimer Rd, Houston, TX', NULL, 44, '77027', 29.7380, -95.4520, 'TX-CLN-30123', 1, 1, 1, 0, 6, '5-10', 'pro', 4.60, 3, 580, 43, 'active', '2024-05-10 10:00:00'),

(21, 'Dallas Deep Clean Crew', 'dallas-deep-clean-crew', 'North Texas deep cleaning experts', 'Intensive deep cleaning services for homes and offices in Dallas-Fort Worth. We clean behind appliances, inside cabinets, ceiling fans, baseboards, and every forgotten corner.', '214-555-0220', 'info@dallasdeepclean.com', 'https://dallasdeepclean.com', '2020 Main St, Dallas, TX', NULL, 44, '75201', 32.7830, -96.7980, 'TX-CLN-30456', 1, 1, 1, 1, 8, '8-15', 'premium', 4.83, 3, 870, 64, 'active', '2024-03-18 09:00:00'),

(22, 'Austin Eco Maids', 'austin-eco-maids', 'Austin green cleaning pioneers', 'Eco-friendly residential cleaning using certified green products. Serving Austin, Round Rock, and Cedar Park. Allergy-friendly, pet-safe, and environmentally responsible.', '512-555-0221', 'info@austinecomaids.com', 'https://austinecomaids.com', '1100 Congress Ave, Austin, TX', NULL, 44, '78701', 30.2720, -97.7430, 'TX-CLN-30789', 1, 1, 1, 0, 5, '3-5', 'basic', 4.67, 3, 460, 35, 'active', '2024-07-22 10:30:00'),

(23, 'San Antonio Pressure Pros', 'san-antonio-pressure-pros', 'SA power washing specialists', 'Commercial and residential pressure washing in San Antonio. Driveways, parking lots, building exteriors, fleet washing, graffiti removal, and garage floor cleaning.', '210-555-0222', 'info@sapressurepros.com', 'https://sapressurepros.com', '300 E Commerce St, San Antonio, TX', NULL, 44, '78205', 29.4260, -98.4890, 'TX-CLN-31012', 1, 1, 1, 0, 9, '5-10', 'pro', 4.53, 3, 420, 30, 'active', '2024-06-14 09:30:00'),

(24, 'DFW Commercial Services', 'dfw-commercial-services', 'Dallas-Fort Worth commercial cleaning', 'Full-service commercial cleaning and janitorial services for DFW businesses. Office buildings, retail spaces, warehouses, and multi-tenant properties. Day and night porter service.', '817-555-0223', 'info@dfwcommercial.com', 'https://dfwcommercial.com', '500 Throckmorton St, Fort Worth, TX', NULL, 44, '76102', 32.7490, -97.3310, 'TX-CLN-31345', 1, 1, 1, 1, 14, '30-50', 'premium', 4.90, 3, 920, 72, 'active', '2024-02-05 08:00:00'),

(25, 'Texas Air Duct Specialists', 'texas-air-duct-specialists', 'HVAC and duct cleaning across Texas', 'Certified air duct, dryer vent, and HVAC cleaning for homes and businesses. Improve indoor air quality and reduce energy costs. NADCA-certified technicians. Serving DFW metro.', '214-555-0224', 'info@txairductpros.com', 'https://txairductpros.com', '3000 Pegasus Park Dr, Dallas, TX', NULL, 44, '75247', 32.8130, -96.8620, 'TX-CLN-31678', 1, 1, 1, 0, 7, '5-10', 'pro', 4.73, 3, 510, 39, 'active', '2024-08-01 10:00:00'),

(26, 'Houston Restaurant Cleaning', 'houston-restaurant-cleaning', 'Keeping Houston kitchens spotless', 'Specialized restaurant and commercial kitchen cleaning including hood vents, grease traps, floor degreasing, and equipment sanitization. Health department compliant services.', '713-555-0225', 'info@houstonrestaurantclean.com', 'https://houstonrestaurantclean.com', '2400 Navigation Blvd, Houston, TX', NULL, 44, '77003', 29.7530, -95.3510, 'TX-CLN-32001', 1, 1, 1, 0, 11, '8-15', 'pro', 4.80, 3, 480, 36, 'active', '2024-04-12 09:00:00'),

(27, 'Fort Worth Post-Construction', 'fort-worth-post-construction', 'Construction cleanup done right', 'Post-construction and renovation cleanup specialists in the Fort Worth area. Dust removal, debris hauling, window cleaning, floor polishing, and final detail clean for new builds and remodels.', '817-555-0226', 'info@fwpostconstruction.com', 'https://fwpostconstruction.com', '912 W Weatherford St, Fort Worth, TX', NULL, 44, '76102', 32.7580, -97.3340, 'TX-CLN-32234', 1, 1, 1, 0, 13, '10-20', 'pro', 4.70, 3, 390, 29, 'active', '2024-05-28 10:30:00'),

-- NY cleaners (27-33 => cleaner IDs 27-33, user_ids 28-34)
(28, 'NYC Spotless Cleaning', 'nyc-spotless-cleaning', 'Manhattan luxury home cleaning', 'Premium house cleaning and deep cleaning for Manhattan apartments, penthouses, and brownstones. Discreet, bonded teams with background checks. Weekly and bi-weekly service.', '212-555-0227', 'info@nycspotless.com', 'https://nycspotless.com', '350 5th Ave, New York, NY', NULL, 33, '10118', 40.7484, -73.9857, 'NY-CLN-40123', 1, 1, 1, 1, 10, '15-30', 'premium', 4.93, 3, 1450, 102, 'active', '2024-01-20 09:00:00'),

(29, 'Manhattan Maid Co.', 'manhattan-maid-co', 'NYC move-in/move-out specialists', 'Trusted apartment cleaning and move-in/move-out services across all five boroughs. Real estate agent preferred vendor. Guaranteed to pass landlord inspection.', '212-555-0228', 'info@manhattanmaidco.com', 'https://manhattanmaidco.com', '420 Lexington Ave, New York, NY', NULL, 33, '10170', 40.7527, -73.9753, 'NY-CLN-40456', 1, 1, 1, 0, 8, '10-20', 'pro', 4.73, 3, 880, 65, 'active', '2024-04-08 10:00:00'),

(30, 'Brooklyn Carpet Care', 'brooklyn-carpet-care', 'Brooklyn and Queens floor specialists', 'Carpet cleaning, upholstery care, and rug cleaning for Brooklyn and Queens residents. We handle Persian rugs, modern carpets, and all fabric types with care.', '718-555-0229', 'info@brooklyncarpetcare.com', 'https://brooklyncarpetcare.com', '150 Court St, Brooklyn, NY', NULL, 33, '11201', 40.6870, -73.9920, 'NY-CLN-40789', 1, 1, 1, 0, 7, '3-5', 'basic', 4.57, 3, 420, 31, 'active', '2024-06-20 11:00:00'),

(31, 'Empire Window Cleaning', 'empire-window-cleaning', 'NYC high-rise window specialists', 'Licensed high-rise and commercial window cleaning across New York City. Scaffolding, rope access, and boom lift certified. Storefronts, office towers, and residential buildings.', '212-555-0230', 'info@empirewindowcleaning.com', 'https://empirewindowcleaning.com', '30 Rockefeller Plaza, New York, NY', NULL, 33, '10112', 40.7587, -73.9787, 'NY-CLN-41012', 1, 1, 1, 1, 18, '15-30', 'premium', 4.87, 3, 760, 55, 'active', '2024-02-14 08:30:00'),

(32, 'Queens Office Maintenance', 'queens-office-maintenance', 'Office and janitorial services for Queens', 'Daily office cleaning and janitorial services for businesses in Queens, Long Island City, and Astoria. Evening and weekend shifts available. Green products upon request.', '718-555-0231', 'info@queensofficemaint.com', 'https://queensofficemaint.com', '28-17 Queens Plaza N, Long Island City, NY', NULL, 33, '11101', 40.7500, -73.9380, 'NY-CLN-41345', 1, 1, 1, 0, 9, '15-30', 'pro', 4.63, 3, 450, 33, 'active', '2024-07-15 09:30:00'),

(33, 'Bronx Medical Clean', 'bronx-medical-clean', 'Healthcare-grade cleaning in NYC', 'Certified medical facility cleaning for clinics, dental offices, urgent care centers, and medical labs. OSHA-compliant protocols, EPA-registered disinfectants, and trained biohazard teams.', '718-555-0232', 'info@bronxmedicalclean.com', 'https://bronxmedicalclean.com', '1500 Grand Concourse, Bronx, NY', NULL, 33, '10457', 40.8370, -73.9200, 'NY-CLN-41678', 1, 1, 1, 0, 12, '10-20', 'pro', 4.80, 3, 520, 40, 'active', '2024-05-03 10:00:00'),

(34, 'Long Island Pool & Patio', 'long-island-pool-patio', 'Long Island pool maintenance pros', 'Weekly pool cleaning, chemical maintenance, equipment repair, and patio pressure washing for Long Island homeowners. Seasonal openings and closings. Serving Nassau and Suffolk Counties.', '516-555-0233', 'info@lipoolpatio.com', 'https://lipoolpatio.com', '200 Old Country Rd, Mineola, NY', NULL, 33, '11501', 40.7470, -73.6400, 'NY-CLN-42001', 1, 1, 1, 0, 14, '5-10', 'pro', 4.67, 3, 380, 27, 'active', '2024-03-08 11:00:00'),

-- IL cleaners (34-38 => cleaner IDs 34-38, user_ids 35-39)
(35, 'Chicago Clean Team', 'chicago-clean-team', 'Windy City house cleaning experts', 'Professional house and deep cleaning services for Chicago homes and condos. Kitchens, bathrooms, bedrooms, and living spaces thoroughly cleaned. Licensed, bonded, and insured.', '312-555-0234', 'info@chicagocleanteam.com', 'https://chicagocleanteam.com', '233 S Wacker Dr, Chicago, IL', NULL, 14, '60606', 41.8788, -87.6359, 'IL-CLN-50123', 1, 1, 1, 1, 7, '8-15', 'premium', 4.83, 3, 920, 68, 'active', '2024-04-22 10:00:00'),

(36, 'Windy City Upholstery', 'windy-city-upholstery', 'Chicago fabric and furniture care', 'Upholstery and carpet cleaning specialists in the Chicagoland area. Sofas, sectionals, dining chairs, mattresses, and auto interiors. Stain protection treatments available.', '312-555-0235', 'info@windycityupholstery.com', 'https://windycityupholstery.com', '1540 N Clark St, Chicago, IL', NULL, 14, '60610', 41.9100, -87.6310, 'IL-CLN-50456', 1, 1, 1, 0, 6, '3-5', 'basic', 4.50, 3, 340, 24, 'active', '2024-08-15 09:30:00'),

(37, 'Springfield Tile Masters', 'springfield-tile-masters', 'Central Illinois tile restoration', 'Tile and grout cleaning, restoration, and sealing for kitchens, bathrooms, showers, and commercial floors. Serving Springfield and Central Illinois. Color sealing and grout repair.', '217-555-0236', 'info@springfieldtile.com', 'https://springfieldtile.com', '300 E Capitol Ave, Springfield, IL', NULL, 14, '62701', 39.7990, -89.6440, 'IL-CLN-50789', 1, 1, 1, 0, 8, '3-5', 'basic', 4.57, 3, 280, 20, 'active', '2024-09-05 10:30:00'),

(38, 'Illinois Air Quality Pros', 'illinois-air-quality-pros', 'Chicagoland duct and vent cleaning', 'NADCA-certified air duct and dryer vent cleaning in Chicago and suburbs. Residential and commercial HVAC cleaning, sanitization, and indoor air quality testing.', '312-555-0237', 'info@ilairqualitypros.com', 'https://ilairqualitypros.com', '300 N LaSalle Dr, Chicago, IL', NULL, 14, '60654', 41.8880, -87.6320, 'IL-CLN-51012', 1, 1, 1, 0, 10, '5-10', 'pro', 4.73, 3, 470, 35, 'active', '2024-06-28 09:00:00'),

(39, 'Chicago Restaurant Cleaners', 'chicago-restaurant-cleaners', 'Restaurant cleaning for the Windy City', 'Specialized restaurant, bar, and food service cleaning in Chicago. Kitchen deep cleaning, hood vent degreasing, floor care, and daily porter services. Health code compliant.', '312-555-0238', 'info@chirestaurantclean.com', 'https://chirestaurantclean.com', '180 N Michigan Ave, Chicago, IL', NULL, 14, '60601', 41.8850, -87.6240, 'IL-CLN-51345', 1, 1, 1, 0, 9, '10-20', 'pro', 4.67, 3, 410, 31, 'active', '2024-05-16 10:00:00'),

-- GA cleaners (39-42 => cleaner IDs 39-42, user_ids 40-43)
(40, 'Atlanta Fresh Cleaning', 'atlanta-fresh-cleaning', 'Atlanta residential cleaning you can trust', 'Dependable house and move-in/move-out cleaning in Metro Atlanta. Buckhead, Midtown, Decatur, and surrounding areas. Background-checked teams with a satisfaction guarantee.', '404-555-0239', 'info@atlantafreshclean.com', 'https://atlantafreshclean.com', '3340 Peachtree Rd NE, Atlanta, GA', NULL, 11, '30326', 33.8477, -84.3620, 'GA-CLN-60123', 1, 1, 1, 0, 5, '5-10', 'pro', 4.67, 3, 540, 40, 'active', '2024-06-10 10:00:00'),

(41, 'Peach State Pressure Wash', 'peach-state-pressure-wash', 'Georgia power washing and cleanup', 'Pressure washing and post-construction cleanup for Atlanta and North Georgia. Driveways, decks, siding, commercial buildings, and new construction final clean.', '404-555-0240', 'info@peachstatepw.com', 'https://peachstatepw.com', '191 Peachtree St NE, Atlanta, GA', NULL, 11, '30303', 33.7590, -84.3870, 'GA-CLN-60456', 1, 1, 1, 0, 8, '5-10', 'pro', 4.60, 3, 380, 28, 'active', '2024-07-20 09:30:00'),

(42, 'Georgia Medical Sanitizers', 'georgia-medical-sanitizers', 'Healthcare cleaning for GA facilities', 'Certified medical facility cleaning for hospitals, clinics, dental offices, and outpatient centers throughout Georgia. CDC-guided disinfection protocols and HIPAA-compliant service.', '678-555-0241', 'info@gamedicalclean.com', 'https://gamedicalclean.com', '550 Peachtree St NE, Atlanta, GA', NULL, 11, '30308', 33.7720, -84.3830, 'GA-CLN-60789', 1, 1, 1, 0, 11, '15-30', 'premium', 4.87, 3, 620, 47, 'active', '2024-03-25 08:00:00'),

(43, 'Savannah Vacation Turnover', 'savannah-vacation-turnover', 'Savannah short-term rental cleaning', 'Airbnb and VRBO turnover cleaning in the Savannah Historic District and Tybee Island. Linen management, restocking, and quality inspection checklists for property managers.', '912-555-0242', 'info@savannahvacation.com', 'https://savannahvacation.com', '17 W McDonough St, Savannah, GA', NULL, 11, '31401', 32.0790, -81.0920, 'GA-CLN-61012', 1, 1, 1, 0, 4, '3-5', 'basic', 4.53, 3, 310, 22, 'active', '2024-08-05 11:00:00'),

-- AZ cleaners (43-46 => cleaner IDs 43-46, user_ids 44-47)
(44, 'Phoenix Tile & Grout Pros', 'phoenix-tile-grout-pros', 'Valley tile restoration specialists', 'Professional tile and grout cleaning, restoration, and sealing in Phoenix, Scottsdale, and Mesa. Saltillo, travertine, ceramic, and porcelain tile experts.', '602-555-0243', 'info@phxtilegrout.com', 'https://phxtilegrout.com', '2020 N Central Ave, Phoenix, AZ', NULL, 3, '85004', 33.4626, -112.0740, 'AZ-CLN-70123', 1, 1, 1, 0, 9, '5-10', 'pro', 4.70, 3, 490, 37, 'active', '2024-04-15 10:00:00'),

(45, 'Scottsdale Hoarding Help', 'scottsdale-hoarding-help', 'Compassionate cleanout services', 'Sensitive hoarding cleanup, estate cleanouts, and deep cleaning for extreme situations. Trained, compassionate teams serving the greater Phoenix area. Discreet and non-judgmental.', '480-555-0244', 'info@scottsdalehoardinghelp.com', 'https://scottsdalehoardinghelp.com', '7000 E Mayo Blvd, Phoenix, AZ', NULL, 3, '85054', 33.6570, -111.9530, 'AZ-CLN-70456', 1, 1, 1, 0, 6, '3-5', 'pro', 4.80, 3, 340, 25, 'active', '2024-07-01 09:00:00'),

(46, 'Tucson Pool Cleaning', 'tucson-pool-cleaning', 'Southern Arizona pool care', 'Weekly and bi-weekly pool cleaning, chemical balancing, and equipment maintenance in Tucson and Marana. Seasonal start-ups and green pool recovery. Licensed contractor.', '520-555-0245', 'info@tucsonpoolclean.com', 'https://tucsonpoolclean.com', '150 N Stone Ave, Tucson, AZ', NULL, 3, '85701', 32.2247, -110.9747, 'AZ-CLN-70789', 1, 1, 1, 0, 12, '3-5', 'basic', 4.47, 3, 300, 21, 'active', '2024-05-22 10:30:00'),

(47, 'Arizona Desert Clean', 'arizona-desert-clean', 'Hoarding and construction cleanup AZ', 'Hoarding remediation and post-construction cleanup in the Phoenix metro area. Full cleanout, hazmat-certified technicians, deep sanitization, and property restoration services.', '602-555-0246', 'info@azdesertclean.com', 'https://azdesertclean.com', '3443 N Central Ave, Phoenix, AZ', NULL, 3, '85012', 33.4810, -112.0740, 'AZ-CLN-71012', 1, 1, 1, 0, 10, '5-10', 'pro', 4.63, 3, 360, 26, 'active', '2024-06-08 09:30:00'),

-- CO cleaners (47-50 => cleaner IDs 47-50, user_ids 48-51)
(48, 'Denver Green Maids', 'denver-green-maids', 'Denver eco-friendly home cleaning', 'Certified green residential cleaning using only non-toxic, plant-based products. Serving Denver, Lakewood, and Aurora. B-Corp certified with carbon offset programs.', '303-555-0247', 'info@denvergreenmaids.com', 'https://denvergreenmaids.com', '1600 California St, Denver, CO', NULL, 6, '80202', 39.7459, -104.9870, 'CO-CLN-80123', 1, 1, 1, 1, 6, '8-15', 'premium', 4.87, 3, 720, 53, 'active', '2024-03-12 10:00:00'),

(49, 'Boulder Eco Clean', 'boulder-eco-clean', 'Boulder sustainable cleaning services', 'Environmentally conscious deep cleaning and regular house cleaning in Boulder and Broomfield. 100% biodegradable products, reusable supplies, and zero-waste practices.', '303-555-0248', 'info@boulderecoclean.com', 'https://boulderecoclean.com', '1942 Broadway, Boulder, CO', NULL, 6, '80302', 40.0190, -105.2750, 'CO-CLN-80456', 1, 1, 1, 0, 4, '3-5', 'basic', 4.60, 3, 350, 25, 'active', '2024-08-20 09:00:00'),

(50, 'Colorado Springs Office Pro', 'colorado-springs-office-pro', 'COS commercial cleaning experts', 'Professional office and commercial cleaning for Colorado Springs businesses. USAA, Fort Carson, and Peterson AFB area. Day and evening cleaning schedules available.', '719-555-0249', 'info@csofficepro.com', 'https://csofficepro.com', '102 S Tejon St, Colorado Springs, CO', NULL, 6, '80903', 38.8317, -104.8253, 'CO-CLN-80789', 1, 1, 1, 0, 8, '10-20', 'pro', 4.70, 3, 440, 33, 'active', '2024-05-14 10:30:00'),

(51, 'Aspen Vacation Clean', 'aspen-vacation-clean', 'Luxury vacation rental turnovers', 'Premium vacation rental cleaning for Aspen, Vail, and Breckenridge properties. Ski season and summer turnovers, luxury linen service, and property inspection. Trusted by top management companies.', '970-555-0250', 'info@aspenvacationclean.com', 'https://aspenvacationclean.com', '415 E Hyman Ave, Aspen, CO', NULL, 6, '81611', 39.1905, -106.8175, 'CO-CLN-81012', 1, 1, 1, 1, 7, '5-10', 'premium', 4.90, 3, 580, 43, 'active', '2024-04-02 11:00:00'),

-- WA cleaners (51-53 => cleaner IDs 51-53, user_ids 52-54)
(52, 'Seattle Clean Scene', 'seattle-clean-scene', 'Seattle eco home cleaning', 'Green residential cleaning in Seattle, Bellevue, and Kirkland. Non-toxic products safe for families and pets. Weekly, bi-weekly, and deep cleaning services.', '206-555-0251', 'info@seattlecleanscene.com', 'https://seattlecleanscene.com', '1501 4th Ave, Seattle, WA', NULL, 48, '98101', 47.6101, -122.3371, 'WA-CLN-90123', 1, 1, 1, 0, 5, '5-10', 'pro', 4.73, 3, 530, 39, 'active', '2024-06-18 10:00:00'),

(53, 'Tacoma Industrial Clean', 'tacoma-industrial-clean', 'Warehouse and construction cleanup', 'Industrial cleaning, warehouse maintenance, and post-construction cleanup in Tacoma and South King County. Concrete floor polishing, equipment cleaning, and OSHA-compliant services.', '253-555-0252', 'info@tacomaindustrialclean.com', 'https://tacomaindustrialclean.com', '1120 Pacific Ave, Tacoma, WA', NULL, 48, '98402', 47.2529, -122.4443, 'WA-CLN-90456', 1, 1, 1, 0, 11, '10-20', 'pro', 4.60, 3, 370, 27, 'active', '2024-07-25 09:30:00'),

(54, 'Olympia Restaurant Sanitizers', 'olympia-restaurant-sanitizers', 'Restaurant and medical cleaning WA', 'Restaurant kitchen cleaning and medical facility sanitization in Olympia and South Puget Sound. Hood vent degreasing, OSHA compliance, and healthcare-grade disinfection.', '360-555-0253', 'info@olympiarestaurantclean.com', 'https://olympiarestaurantclean.com', '119 Capitol Way N, Olympia, WA', NULL, 48, '98501', 47.0451, -122.9023, 'WA-CLN-90789', 1, 1, 1, 0, 8, '5-10', 'pro', 4.57, 3, 290, 20, 'active', '2024-08-10 10:00:00'),

-- NV cleaners (54-56 => cleaner IDs 54-56, user_ids 55-57)
(55, 'Las Vegas Strip Clean', 'las-vegas-strip-clean', 'Vegas vacation and restaurant cleaning', 'Vacation rental turnovers and restaurant cleaning on the Las Vegas Strip and surrounding areas. Fast same-day turnovers for Airbnb, condo-hotels, and food service establishments.', '702-555-0254', 'info@vegasstripclean.com', 'https://vegasstripclean.com', '3900 S Las Vegas Blvd, Las Vegas, NV', NULL, 29, '89119', 36.1033, -115.1744, 'NV-CLN-A0123', 1, 1, 1, 1, 6, '8-15', 'premium', 4.80, 3, 690, 51, 'active', '2024-03-20 09:00:00'),

(56, 'Reno Air Duct Clean', 'reno-air-duct-clean', 'Northern Nevada indoor air quality', 'Air duct cleaning, dryer vent cleaning, and upholstery care in Reno, Sparks, and Carson City. NADCA-certified technicians. Residential and commercial HVAC systems.', '775-555-0255', 'info@renoairductclean.com', 'https://renoairductclean.com', '100 N Sierra St, Reno, NV', NULL, 29, '89501', 39.5261, -119.8126, 'NV-CLN-A0456', 1, 1, 1, 0, 9, '3-5', 'basic', 4.53, 3, 320, 23, 'active', '2024-07-05 10:30:00'),

(57, 'Vegas Medical Clean Pro', 'vegas-medical-clean-pro', 'Healthcare cleaning in Las Vegas', 'Medical office and dental practice cleaning in Henderson and Las Vegas. EPA-registered hospital-grade disinfectants, OSHA-trained staff, and nightly cleaning schedules.', '702-555-0256', 'info@vegasmedicalclean.com', 'https://vegasmedicalclean.com', '2300 W Sahara Ave, Las Vegas, NV', NULL, 29, '89102', 36.1446, -115.1800, 'NV-CLN-A0789', 1, 1, 1, 0, 7, '5-10', 'pro', 4.67, 3, 410, 30, 'active', '2024-05-30 09:30:00'),

-- NC cleaners (57-58 => cleaner IDs 57-58, user_ids 58-59)
(58, 'Charlotte Move Clean Pro', 'charlotte-move-clean-pro', 'Charlotte move-in/out specialists', 'Move-in and move-out deep cleaning in Charlotte, Huntersville, and Concord. We work with property managers, realtors, and tenants. Walls, appliances, floors, and full sanitization.', '704-555-0257', 'info@charlottemoveclean.com', 'https://charlottemoveclean.com', '401 S Tryon St, Charlotte, NC', NULL, 34, '28202', 35.2222, -80.8451, 'NC-CLN-B0123', 1, 1, 1, 0, 5, '5-10', 'pro', 4.67, 3, 430, 32, 'active', '2024-06-22 10:00:00'),

(59, 'Raleigh Hoarding Solutions', 'raleigh-hoarding-solutions', 'Triangle area hoarding remediation', 'Professional hoarding cleanup and estate cleanouts in the Raleigh-Durham area. Compassionate, licensed, and discreet. Sorting, organizing, hauling, and deep sanitization.', '919-555-0258', 'info@raleighhoarding.com', 'https://raleighhoarding.com', '150 Fayetteville St, Raleigh, NC', NULL, 34, '27601', 35.7796, -78.6382, 'NC-CLN-B0456', 1, 1, 1, 0, 7, '3-5', 'basic', 4.73, 3, 280, 19, 'active', '2024-08-28 09:00:00'),

-- NJ cleaners (59-60 => cleaner IDs 59-60, user_ids 60-61)
(60, 'Jersey Shore Window Clean', 'jersey-shore-window-clean', 'NJ coastal window and pressure washing', 'Window cleaning and pressure washing along the Jersey Shore and Central NJ. Oceanfront condos, storefronts, and residential homes. Salt spray removal specialists.', '201-555-0259', 'info@jerseywindowclean.com', 'https://jerseywindowclean.com', '700 Cookman Ave, Asbury Park, NJ', NULL, 31, '07712', 40.2206, -74.0021, 'NJ-CLN-C0123', 1, 1, 1, 0, 10, '5-10', 'pro', 4.60, 3, 350, 26, 'active', '2024-04-30 10:00:00'),

(61, 'Newark Warehouse Clean', 'newark-warehouse-clean', 'NJ industrial and janitorial services', 'Warehouse, garage, and industrial space cleaning in Newark and North Jersey. Floor scrubbing, loading dock cleaning, janitorial contracts, and trash management.', '973-555-0260', 'info@newarkwarehouseclean.com', 'https://newarkwarehouseclean.com', '50 Park Pl, Newark, NJ', NULL, 31, '07102', 40.7363, -74.1724, 'NJ-CLN-C0456', 1, 1, 1, 0, 13, '10-20', 'pro', 4.53, 3, 310, 22, 'active', '2024-05-18 09:30:00');

-- ============================================================
-- CLEANER CATEGORIES (many-to-many assignments)
-- Each category has 3+ cleaners
-- cat: 1=House, 2=Commercial, 3=Carpet, 4=Pressure, 5=Window,
--      6=MoveInOut, 7=Deep, 8=Office, 9=PostConstruction, 10=Pool,
--      11=Janitorial, 12=Upholstery, 13=AirDuct, 14=TileGrout,
--      15=Hoarding, 16=GreenEco, 17=VacationRental, 18=Restaurant,
--      19=Medical, 20=GarageWarehouse
-- ============================================================
INSERT INTO `cleaner_categories` (`cleaner_id`, `category_id`) VALUES
-- Cat 1: House Cleaning (15 cleaners)
(1,1),(2,1),(3,1),(4,1),(11,1),(12,1),(17,1),(19,1),(21,1),(27,1),(28,1),(34,1),(39,1),(47,1),(51,1),
-- Cat 2: Commercial Cleaning (8)
(5,2),(10,2),(16,2),(23,2),(25,2),(32,2),(41,2),(49,2),
-- Cat 3: Carpet Cleaning (6)
(6,3),(13,3),(20,3),(29,3),(35,3),(36,3),
-- Cat 4: Pressure Washing (6)
(7,4),(8,4),(22,4),(33,4),(40,4),(59,4),
-- Cat 5: Window Cleaning (4)
(8,5),(14,5),(30,5),(59,5),
-- Cat 6: Move-In/Move-Out (7)
(2,6),(15,6),(19,6),(28,6),(39,6),(50,6),(57,6),
-- Cat 7: Deep Cleaning (10)
(1,7),(4,7),(11,7),(15,7),(20,7),(27,7),(34,7),(44,7),(48,7),(57,7),
-- Cat 8: Office Cleaning (5)
(5,8),(16,8),(18,8),(31,8),(49,8),
-- Cat 9: Post-Construction Cleanup (4)
(26,9),(40,9),(46,9),(52,9),
-- Cat 10: Pool Cleaning (3)
(9,10),(33,10),(45,10),
-- Cat 11: Janitorial Services (5)
(10,11),(18,11),(23,11),(31,11),(60,11),
-- Cat 12: Upholstery Cleaning (4)
(6,12),(29,12),(35,12),(55,12),
-- Cat 13: Air Duct Cleaning (3)
(24,13),(37,13),(55,13),
-- Cat 14: Tile & Grout Cleaning (3)
(13,14),(36,14),(43,14),
-- Cat 15: Hoarding Cleanup (3)
(44,15),(46,15),(58,15),
-- Cat 16: Green/Eco Cleaning (6)
(3,16),(12,16),(21,16),(47,16),(48,16),(51,16),
-- Cat 17: Vacation Rental Cleaning (4)
(17,17),(42,17),(50,17),(54,17),
-- Cat 18: Restaurant Cleaning (4)
(25,18),(38,18),(53,18),(54,18),
-- Cat 19: Medical Facility Cleaning (4)
(32,19),(41,19),(53,19),(56,19),
-- Cat 20: Garage & Warehouse Cleaning (5)
(7,20),(22,20),(26,20),(52,20),(60,20);

-- ============================================================
-- CLEANER SPECIALTIES (2-4 per cleaner)
-- ============================================================
INSERT INTO `cleaner_specialties` (`cleaner_id`, `name`) VALUES
-- Cleaner 1
(1, 'Weekly House Cleaning'), (1, 'Bi-Weekly Maintenance'), (1, 'Spring Cleaning'),
-- Cleaner 2
(2, 'Move-Out Deep Clean'), (2, 'Apartment Cleaning'), (2, 'Real Estate Showing Prep'),
-- Cleaner 3
(3, 'Non-Toxic Cleaning'), (3, 'Pet-Safe Products'), (3, 'Allergy-Friendly Service'),
-- Cleaner 4
(4, 'Intensive Deep Cleaning'), (4, 'Appliance Interior Cleaning'), (4, 'Pre-Party Cleaning'),
-- Cleaner 5
(5, 'Office Building Cleaning'), (5, 'Retail Store Cleaning'), (5, 'Day Porter Service'),
-- Cleaner 6
(6, 'Steam Carpet Cleaning'), (6, 'Pet Stain Removal'), (6, 'Area Rug Cleaning'),
-- Cleaner 7
(7, 'Driveway Pressure Washing'), (7, 'Roof Soft Washing'), (7, 'Concrete Cleaning'),
-- Cleaner 8
(8, 'High-Rise Window Cleaning'), (8, 'Storefront Windows'), (8, 'Pressure Washing'),
-- Cleaner 9
(9, 'Chemical Balancing'), (9, 'Filter Maintenance'), (9, 'Green Pool Recovery'),
-- Cleaner 10
(10, 'Nightly Janitorial'), (10, 'Floor Stripping & Waxing'), (10, 'Restroom Sanitization'),
-- Cleaner 11
(11, 'Luxury Home Cleaning'), (11, 'Penthouse Service'), (11, 'Same-Day Booking'),
-- Cleaner 12
(12, 'Green Product Only'), (12, 'Carbon Neutral Service'), (12, 'EWG-Rated Products'),
-- Cleaner 13
(13, 'Tile Restoration'), (13, 'Natural Stone Care'), (13, 'Grout Color Sealing'),
-- Cleaner 14
(14, 'Commercial Window Cleaning'), (14, 'Post-Construction Windows'), (14, 'Safety Certified'),
-- Cleaner 15
(15, 'Apartment Turnover'), (15, 'Realtor Partnerships'), (15, 'Inspection Guarantee'),
-- Cleaner 16
(16, 'Daily Office Cleaning'), (16, 'After-Hours Service'), (16, 'Kitchen Sanitization'),
-- Cleaner 17
(17, 'Airbnb Turnover'), (17, 'Linen Coordination'), (17, 'Guest-Ready Checklists'),
-- Cleaner 18
(18, 'Tech Office Specialist'), (18, 'Server Room Cleaning'), (18, 'Green Certified'),
-- Cleaner 19
(19, 'Affordable Packages'), (19, 'Monthly Plans'), (19, 'Move-In Cleaning'),
-- Cleaner 20
(20, 'Behind-Appliance Cleaning'), (20, 'Cabinet Interior Cleaning'), (20, 'Baseboard Detailing'),
-- Cleaner 21
(21, 'Certified Green Products'), (21, 'Pet-Friendly Cleaning'), (21, 'Zero-Waste Supplies'),
-- Cleaner 22
(22, 'Commercial Pressure Washing'), (22, 'Graffiti Removal'), (22, 'Fleet Washing'),
-- Cleaner 23
(23, 'Multi-Tenant Properties'), (23, 'Warehouse Cleaning'), (23, 'Day & Night Service'),
-- Cleaner 24
(24, 'NADCA Certified'), (24, 'Dryer Vent Cleaning'), (24, 'Indoor Air Testing'),
-- Cleaner 25
(25, 'Hood Vent Degreasing'), (25, 'Grease Trap Cleaning'), (25, 'Kitchen Equipment Sanitization'),
-- Cleaner 26
(26, 'New Construction Final Clean'), (26, 'Debris Removal'), (26, 'Floor Polishing'),
-- Cleaner 27
(27, 'Manhattan Apartments'), (27, 'Brownstone Cleaning'), (27, 'Penthouse Service'),
-- Cleaner 28
(28, 'All Five Boroughs'), (28, 'Landlord Inspection Ready'), (28, 'Same-Day Move-Out'),
-- Cleaner 29
(29, 'Persian Rug Specialist'), (29, 'Fabric Protection'), (29, 'Stain Removal Expert'),
-- Cleaner 30
(30, 'Rope Access Certified'), (30, 'Scaffolding Work'), (30, 'Storefront Windows'),
-- Cleaner 31
(31, 'Evening & Weekend Cleaning'), (31, 'Green Products Available'), (31, 'Multi-Floor Buildings'),
-- Cleaner 32
(32, 'OSHA Compliant'), (32, 'Biohazard Certified'), (32, 'EPA Disinfectants'),
-- Cleaner 33
(33, 'Pool Opening & Closing'), (33, 'Equipment Repair'), (33, 'Patio Pressure Washing'),
-- Cleaner 34
(34, 'Condo Cleaning'), (34, 'Kitchen & Bath Focus'), (34, 'Licensed & Bonded'),
-- Cleaner 35
(35, 'Sofa & Sectional Cleaning'), (35, 'Mattress Sanitization'), (35, 'Auto Interior Cleaning'),
-- Cleaner 36
(36, 'Shower Tile Restoration'), (36, 'Grout Repair'), (36, 'Color Sealing'),
-- Cleaner 37
(37, 'Residential HVAC Cleaning'), (37, 'Commercial Systems'), (37, 'Air Quality Testing'),
-- Cleaner 38
(38, 'Kitchen Deep Clean'), (38, 'Floor Degreasing'), (38, 'Health Code Compliance'),
-- Cleaner 39
(39, 'Buckhead Homes'), (39, 'Midtown Apartments'), (39, 'Move-Out Guarantee'),
-- Cleaner 40
(40, 'Building Exterior Washing'), (40, 'Construction Debris Cleanup'), (40, 'Deck Restoration'),
-- Cleaner 41
(41, 'CDC Protocol Cleaning'), (41, 'HIPAA Compliant'), (41, 'Hospital-Grade Disinfection'),
-- Cleaner 42
(42, 'Historic District Properties'), (42, 'Tybee Island Rentals'), (42, 'Linen Management'),
-- Cleaner 43
(43, 'Saltillo Tile Expert'), (43, 'Travertine Restoration'), (43, 'Outdoor Tile Cleaning'),
-- Cleaner 44
(44, 'Compassionate Approach'), (44, 'Estate Cleanouts'), (44, 'Extreme Cleaning'),
-- Cleaner 45
(45, 'Desert Climate Pool Care'), (45, 'Chemical-Free Options'), (45, 'Equipment Diagnostics'),
-- Cleaner 46
(46, 'Hazmat Certified'), (46, 'Property Restoration'), (46, 'Post-Renovation Cleanup'),
-- Cleaner 47
(47, 'B-Corp Certified'), (47, 'Carbon Offset Programs'), (47, 'Plant-Based Products'),
-- Cleaner 48
(48, 'Zero-Waste Cleaning'), (48, 'Biodegradable Products'), (48, 'Reusable Supplies'),
-- Cleaner 49
(49, 'Military Base Clearance'), (49, 'Day & Evening Shifts'), (49, 'Large Office Complexes'),
-- Cleaner 50
(50, 'Ski Season Turnovers'), (50, 'Luxury Linen Service'), (50, 'Property Inspections'),
-- Cleaner 51
(51, 'Pacific NW Green Cleaning'), (51, 'Rain-Season Deep Clean'), (51, 'Family-Safe Products'),
-- Cleaner 52
(52, 'Concrete Floor Polishing'), (52, 'Loading Dock Cleaning'), (52, 'OSHA Compliant'),
-- Cleaner 53
(53, 'Hood Vent Cleaning'), (53, 'Healthcare Sanitization'), (53, 'Food Safety Certified'),
-- Cleaner 54
(54, 'Same-Day Turnovers'), (54, 'Condo-Hotel Cleaning'), (54, 'Strip Restaurant Kitchens'),
-- Cleaner 55
(55, 'NADCA Certified Tech'), (55, 'Residential & Commercial'), (55, 'Furniture Cleaning'),
-- Cleaner 56
(56, 'Dental Practice Specialist'), (56, 'Nightly Medical Cleaning'), (56, 'OSHA-Trained Staff'),
-- Cleaner 57
(57, 'Realtor Preferred Vendor'), (57, 'Appliance Deep Clean'), (57, 'Wall Washing'),
-- Cleaner 58
(58, 'Sorting & Organizing'), (58, 'Junk Hauling'), (58, 'Deep Sanitization'),
-- Cleaner 59
(59, 'Oceanfront Properties'), (59, 'Salt Spray Removal'), (59, 'Gutter Cleaning'),
-- Cleaner 60
(60, 'Warehouse Floor Scrubbing'), (60, 'Trash Compactor Maintenance'), (60, 'Janitorial Contracts');

SET FOREIGN_KEY_CHECKS = 1;
