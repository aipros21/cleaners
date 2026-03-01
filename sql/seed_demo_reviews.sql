-- ============================================================
-- seed_demo_reviews.sql
-- 180 demo reviews across 60 cleaners (3 per cleaner)
-- Distribution: ~60% 5-star, ~25% 4-star, ~10% 3-star, ~5% 1-2 star
-- All cleaning services: house, commercial, carpet, window, etc.
-- ============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- Clear existing demo reviews
TRUNCATE TABLE `reviews`;

INSERT INTO `reviews` (`cleaner_id`, `user_id`, `author_name`, `author_email`, `rating`, `title`, `content`, `status`, `is_verified`, `created_at`) VALUES

-- ============================================================
-- Cleaner 1
-- ============================================================
(1, NULL, 'Jennifer Adams', 'jadams@outlook.com', 5, 'Spotless every time!', 'We have been using this cleaning service for over a year now and our home has never looked better. They pay attention to every detail, from dusting the ceiling fans to scrubbing behind the toilets. Highly recommend to anyone looking for reliable house cleaning.', 'approved', 1, '2025-03-15 10:30:00'),
(1, NULL, 'Marco Rivera', 'marco.r@gmail.com', 5, 'Finally found a cleaner we trust', 'After going through three different cleaning services, we finally found one that meets our standards. They always arrive on time, bring their own eco-friendly supplies, and leave our house smelling fresh. The kitchen and bathrooms are always impeccable.', 'approved', 1, '2025-06-22 14:15:00'),
(1, NULL, 'Donna Mitchell', 'donna.m77@yahoo.com', 4, 'Very good overall', 'Solid house cleaning service that does a thorough job each visit. They missed a couple of spots behind the couch last time, but when I mentioned it they came back the next day to fix it at no charge. Great customer service.', 'approved', 0, '2025-10-08 09:45:00'),

-- ============================================================
-- Cleaner 2
-- ============================================================
(2, NULL, 'Robert Chen', 'rchen@email.com', 5, 'Best cleaning service in Miami', 'These folks transformed our three-bedroom house in just a few hours. The deep clean package was worth every penny. Floors were gleaming, windows were streak-free, and even the grout in our bathroom looked brand new.', 'approved', 1, '2025-04-02 11:00:00'),
(2, NULL, 'Lisa Hernandez', 'lisah@hotmail.com', 4, 'Reliable and professional', 'I have been scheduling bi-weekly cleanings for six months now and they have never missed an appointment. The team is friendly and respectful of our belongings. My only minor complaint is that they sometimes run about 15 minutes late.', 'approved', 1, '2025-07-18 15:30:00'),
(2, NULL, 'Thomas Wright', 'twright99@gmail.com', 5, 'Transformed our home before the holidays', 'Called them for a one-time deep clean before Thanksgiving and they exceeded all expectations. They cleaned inside the oven, scrubbed the baseboards, and even organized under the kitchen sink. Our guests thought we had remodeled.', 'approved', 0, '2025-11-25 08:20:00'),

-- ============================================================
-- Cleaner 3
-- ============================================================
(3, NULL, 'Patricia Moore', 'pmoore@aol.com', 5, 'Office has never looked this good', 'We hired them for our 5,000 sq ft office space and the results are outstanding. They handle everything from vacuuming and mopping to sanitizing all shared surfaces. Our employees have actually commented on how much cleaner the workplace feels.', 'approved', 1, '2025-02-10 13:00:00'),
(3, NULL, 'Kevin O''Brien', 'kobrien@email.com', 5, 'Top-notch commercial cleaning', 'As a property manager for three commercial buildings, I need dependable cleaning crews. This team has been servicing all three properties for eight months with zero complaints from tenants. Professional, thorough, and always on schedule.', 'approved', 1, '2025-05-30 10:45:00'),
(3, NULL, 'Sandra Kim', 'sandrak@gmail.com', 4, 'Great service for our retail store', 'They clean our boutique every night after closing and the store always looks pristine when we open in the morning. The floors are spotless and the display cases are always fingerprint-free. Would love if they offered window cleaning too.', 'approved', 0, '2025-09-14 17:30:00'),

-- ============================================================
-- Cleaner 4
-- ============================================================
(4, NULL, 'Michael Torres', 'mtorres@outlook.com', 5, 'Carpet looks brand new!', 'Had several pet stains on our living room carpet that I thought were permanent. Their team used a hot water extraction method and every single stain came out. The carpet looks and smells like the day we installed it. Incredible work.', 'approved', 1, '2025-01-20 09:00:00'),
(4, NULL, 'Angela Foster', 'afoster22@gmail.com', 4, 'Really impressed with the results', 'Our beige carpet in the hallway was heavily trafficked and looked gray. After their treatment it was back to its original color. They also applied a stain protector which has helped keep it cleaner longer. Well worth the investment.', 'approved', 1, '2025-04-15 14:00:00'),
(4, NULL, 'David Nguyen', 'dnguyen@yahoo.com', 5, 'Saved us from replacing the carpet', 'We were about to spend thousands on new carpeting but decided to try professional cleaning first. Best decision we made. The high-traffic areas in our office came out looking fresh and the team was in and out in under two hours.', 'approved', 0, '2025-08-30 11:15:00'),

-- ============================================================
-- Cleaner 5
-- ============================================================
(5, NULL, 'Rachel Green', 'rgreen@email.com', 5, 'Windows so clean they look invisible', 'They did all 24 windows in our two-story colonial, inside and out. Not a single streak or smudge. They even cleaned the tracks and sills which no other window cleaner has ever done for us. Absolutely fantastic job.', 'approved', 1, '2025-03-08 08:30:00'),
(5, NULL, 'William Park', 'wpark@gmail.com', 5, 'Best window cleaning service around', 'I manage a small office building and these guys handle our exterior window cleaning quarterly. They use a water-fed pole system that gets everything sparkling without leaving any residue. Always professional and safety-conscious.', 'approved', 1, '2025-06-12 12:00:00'),
(5, NULL, 'Nancy Cooper', 'ncooper@hotmail.com', 3, 'Good but had to reschedule twice', 'The actual window cleaning was excellent and our skylights look amazing. However, they had to reschedule our appointment twice due to weather and once because of a staffing issue. The end result was worth it, but the scheduling was frustrating.', 'approved', 0, '2025-10-22 16:45:00'),

-- ============================================================
-- Cleaner 6
-- ============================================================
(6, NULL, 'Christopher Hall', 'chall@outlook.com', 5, 'Made our move-out stress-free', 'We hired them for a move-out deep clean and they handled everything. Oven, fridge, bathrooms, baseboards, closets, garage floor. Our landlord said it was the cleanest unit he had ever received back. Got our full deposit returned.', 'approved', 1, '2025-02-28 10:00:00'),
(6, NULL, 'Maria Santos', 'msantos@gmail.com', 5, 'Perfect move-in cleaning', 'Before moving into our new home, we wanted everything sanitized and fresh. They deep cleaned every surface, disinfected all bathrooms and the kitchen, and even cleaned inside all the cabinets and drawers. We felt comfortable from day one.', 'approved', 1, '2025-05-14 13:30:00'),
(6, NULL, 'Brian Kelly', 'bkelly@email.com', 4, 'Great job on the apartment', 'Used them for our apartment move-out clean. They did a thorough job on the kitchen and bathrooms. The only reason I am not giving five stars is that they forgot to clean the inside of the dishwasher, but everything else was perfect.', 'approved', 0, '2025-09-01 09:15:00'),

-- ============================================================
-- Cleaner 7
-- ============================================================
(7, NULL, 'Emily Watson', 'ewatson@yahoo.com', 5, 'Deep clean that went above and beyond', 'Booked a deep clean for our four-bedroom house and they spent nearly six hours making everything shine. They cleaned behind appliances, inside light fixtures, and even the air vents. It felt like moving into a brand new home afterward.', 'approved', 1, '2025-04-20 11:30:00'),
(7, NULL, 'James Patel', 'jpatel@outlook.com', 5, 'Worth every penny', 'We schedule a quarterly deep clean and the difference is night and day. They get into all the nooks and crannies that our regular weekly cleaning misses. The baseboards, window tracks, and grout lines always come out sparkling.', 'approved', 1, '2025-07-05 14:45:00'),
(7, NULL, 'Susan Clark', 'sclark@gmail.com', 4, 'Thorough and professional', 'Very happy with the deep cleaning service. The team of three tackled our entire house methodically and communicated throughout the process. They even pointed out a small mold spot behind our washing machine that we had not noticed.', 'approved', 0, '2025-11-10 08:00:00'),

-- ============================================================
-- Cleaner 8
-- ============================================================
(8, NULL, 'Daniel Lopez', 'dlopez@email.com', 5, 'Our office has never been cleaner', 'They service our law firm five nights a week and the quality has been consistently excellent for over a year. Desks are wiped down, trash is emptied, restrooms are sanitized, and the kitchen area is spotless every morning.', 'approved', 1, '2025-01-15 16:00:00'),
(8, NULL, 'Karen White', 'kwhite@hotmail.com', 4, 'Solid office cleaning crew', 'Switched to this company after our previous cleaning service kept missing things. They have been much more thorough and responsive to feedback. The conference rooms and lobby always look presentation-ready. Very satisfied.', 'approved', 1, '2025-04-28 10:30:00'),
(8, NULL, 'Steven Brown', 'sbrown@gmail.com', 5, 'Professional and consistent', 'Managing a co-working space means cleanliness is critical for member satisfaction. This team handles our 8,000 sq ft facility nightly and we have received multiple compliments from members about how clean and well-maintained the space is.', 'approved', 0, '2025-08-15 12:15:00'),

-- ============================================================
-- Cleaner 9
-- ============================================================
(9, NULL, 'Amanda Rodriguez', 'arodriguez@yahoo.com', 5, 'Post-construction mess completely gone', 'After a major kitchen renovation, our house was covered in drywall dust and debris. This team came in and spent an entire day cleaning every surface. They even got the fine dust out of our HVAC vents. You would never know construction happened.', 'approved', 1, '2025-03-22 09:00:00'),
(9, NULL, 'Jason Miller', 'jmiller@outlook.com', 4, 'Handled a tough job well', 'We had a bathroom remodel and the contractor left quite a mess. The cleanup crew was thorough with removing grout haze from new tile, cleaning up adhesive residue, and wiping down all new fixtures. Good work overall.', 'approved', 1, '2025-06-30 15:00:00'),
(9, NULL, 'Catherine Lee', 'clee@gmail.com', 5, 'Essential service after renovation', 'Had our entire first floor renovated and the post-construction cleanup was massive. They handled everything: dust removal, window cleaning, floor polishing, and debris hauling. Saved us days of work. The house was move-in ready in one day.', 'approved', 0, '2025-10-05 11:45:00'),

-- ============================================================
-- Cleaner 10
-- ============================================================
(10, NULL, 'Gregory Taylor', 'gtaylor@email.com', 5, 'Pool is crystal clear all year', 'They handle our weekly pool maintenance and the water has never looked better. Chemical balance is always perfect, the filter is cleaned regularly, and they even skim the surface and brush the walls each visit. Truly turnkey service.', 'approved', 1, '2025-02-14 10:00:00'),
(10, NULL, 'Melissa Young', 'myoung@gmail.com', 4, 'Reliable pool service', 'We have a saltwater pool that requires specific care and this company knows exactly what they are doing. They monitor chlorine generation, check pH weekly, and keep the equipment running smoothly. Only wish their monthly report was more detailed.', 'approved', 1, '2025-05-20 13:00:00'),
(10, NULL, 'Frank Russo', 'frusso@hotmail.com', 5, 'Brought our neglected pool back to life', 'We bought a foreclosure with a green, swampy pool. They did a complete drain, acid wash, re-balance, and had it sparkling in three days. Now they maintain it weekly and it looks resort-quality. Neighbors are jealous.', 'approved', 0, '2025-09-28 14:30:00'),

-- ============================================================
-- Cleaner 11
-- ============================================================
(11, NULL, 'Victoria James', 'vjames@outlook.com', 5, 'Our building has never been this clean', 'They provide full janitorial services for our six-story office building. From lobby maintenance to restroom sanitation, every area is consistently spotless. The night crew is reliable and the day porter handles any issues immediately.', 'approved', 1, '2025-01-08 09:30:00'),
(11, NULL, 'Henry Watson', 'hwatson@email.com', 4, 'Excellent janitorial team', 'Hired them for our warehouse and office combo facility. They keep the office areas clean and tidy while also handling the warehouse floor sweeping and restroom maintenance. Good communication from the account manager as well.', 'approved', 1, '2025-04-10 11:00:00'),
(11, NULL, 'Rosa Delgado', 'rdelgado@gmail.com', 5, 'Dependable and thorough', 'As the facilities director for a school, I need a janitorial company I can count on. They have not missed a single scheduled cleaning in eight months. Classrooms, cafeteria, gym, and restrooms are always ready for students each morning.', 'approved', 0, '2025-08-22 16:15:00'),

-- ============================================================
-- Cleaner 12
-- ============================================================
(12, NULL, 'Stephanie Parker', 'sparker@yahoo.com', 5, 'Couch looks like we just bought it', 'Our cream-colored sectional had years of stains from kids and pets. After their upholstery cleaning treatment, it looks brand new. They also did our dining chairs and an armchair. The colors are vibrant again and everything smells fresh.', 'approved', 1, '2025-03-05 10:00:00'),
(12, NULL, 'Andrew Kim', 'akim@gmail.com', 5, 'Amazing upholstery restoration', 'Had our antique sofa professionally cleaned and I was nervous about potential damage. The technician was incredibly careful, tested a hidden spot first, and used the appropriate method for the fabric. The results were stunning with zero damage.', 'approved', 1, '2025-06-18 14:30:00'),
(12, NULL, 'Diane Foster', 'dfoster@hotmail.com', 3, 'Decent job but pricey', 'They cleaned our three sofas and four armchairs. The quality of the work was good and the stains did come out, but the final price was significantly higher than the initial estimate. Would use them again but would want a firm quote first.', 'approved', 0, '2025-10-12 09:00:00'),

-- ============================================================
-- Cleaner 13
-- ============================================================
(13, NULL, 'Paul Anderson', 'panderson@email.com', 5, 'Breathing easier since the duct cleaning', 'Had all the air ducts in our home cleaned and the difference in air quality was immediate. The technician showed us before-and-after photos of the ductwork and the amount of dust and debris that came out was shocking. Money well spent.', 'approved', 1, '2025-02-20 11:00:00'),
(13, NULL, 'Laura Martinez', 'lmartinez@outlook.com', 4, 'Noticed a real difference', 'After years of neglecting our HVAC ducts, we finally had them professionally cleaned. The team was efficient and covered all the furniture to prevent any mess. Our allergies have improved noticeably since the cleaning.', 'approved', 1, '2025-05-28 15:45:00'),
(13, NULL, 'Nathan Brooks', 'nbrooks@gmail.com', 5, 'Professional duct cleaning service', 'They cleaned the ducts in our 3,000 sq ft home including the dryer vent. The technicians were knowledgeable and explained everything they were doing. They also found and sealed a small leak in one of the runs. Excellent work.', 'approved', 0, '2025-09-15 08:30:00'),

-- ============================================================
-- Cleaner 14
-- ============================================================
(14, NULL, 'Michelle Turner', 'mturner@yahoo.com', 5, 'Tile floors look incredible', 'Our ceramic tile floors in the kitchen and bathrooms were dull and the grout was almost black. After their tile and grout cleaning, the floors look like they were just installed. The grout sealing they applied should keep them looking great for years.', 'approved', 1, '2025-01-30 10:30:00'),
(14, NULL, 'Carlos Mendez', 'cmendez@gmail.com', 5, 'Grout restoration was amazing', 'We were quoted eight thousand dollars to re-tile our shower because the grout was so stained and damaged. Instead, we spent a fraction of that on professional grout cleaning and color sealing. The shower looks brand new. Incredible savings.', 'approved', 1, '2025-04-22 13:15:00'),
(14, NULL, 'Theresa Robinson', 'trobinson@email.com', 4, 'Very satisfied with the results', 'They cleaned and sealed all the tile and grout in our entryway and kitchen. The difference is dramatic. The only minor issue was that the sealant took a bit longer to dry than they estimated, but the final result was perfect.', 'approved', 0, '2025-08-08 12:00:00'),

-- ============================================================
-- Cleaner 15
-- ============================================================
(15, NULL, 'George Phillips', 'gphillips@outlook.com', 5, 'Compassionate and professional', 'They handled a hoarding cleanup for my elderly mother''s home with incredible sensitivity and professionalism. The team was patient, respectful, and never judgmental. They sorted, cleaned, and sanitized the entire three-bedroom house in two days.', 'approved', 1, '2025-03-12 09:00:00'),
(15, NULL, 'Rebecca Hall', 'rhall@gmail.com', 5, 'Handled a difficult situation with care', 'After a family member passed away, their home needed extensive cleaning. This team handled the entire job, including biohazard materials, with discretion and compassion. They communicated clearly throughout and the home was restored beautifully.', 'approved', 1, '2025-06-25 11:30:00'),
(15, NULL, 'Timothy Scott', 'tscott@email.com', 4, 'Thorough cleanup of a tough job', 'Hired them for a garage and basement cleanup that had accumulated years of clutter and debris. They brought a large crew and had everything sorted and hauled away in one day. Good work, though the estimate could have been more accurate.', 'approved', 0, '2025-10-30 14:00:00'),

-- ============================================================
-- Cleaner 16
-- ============================================================
(16, NULL, 'Samantha Cruz', 'scruz@yahoo.com', 5, 'Love the eco-friendly approach', 'Finally found a cleaning service that uses only plant-based, non-toxic products. Our home smells clean without any harsh chemical odors. They even bring their own reusable microfiber cloths. Perfect for our family with young kids and pets.', 'approved', 1, '2025-02-05 10:00:00'),
(16, NULL, 'Jonathan Hill', 'jhill@gmail.com', 4, 'Green cleaning that actually works', 'I was skeptical that eco-friendly cleaning products could perform as well as conventional ones, but this service proved me wrong. Our bathrooms and kitchen are spotless and there are no chemical fumes. Great for our family''s health.', 'approved', 1, '2025-05-10 14:00:00'),
(16, NULL, 'Kimberly Perez', 'kperez@hotmail.com', 5, 'Excellent eco-conscious service', 'As someone with chemical sensitivities, finding a cleaning service that uses truly green products has been life-changing. They use certified non-toxic cleaners and the results are just as good as any traditional service. Highly recommend.', 'approved', 0, '2025-09-20 08:45:00'),

-- ============================================================
-- Cleaner 17
-- ============================================================
(17, NULL, 'Brandon Lee', 'blee@outlook.com', 5, 'Vacation rental always guest-ready', 'They handle the turnover cleaning for our Airbnb property and have been flawless for over a year. Fresh linens, sparkling bathrooms, fully stocked kitchen, and a beautiful presentation every time. Our reviews consistently mention how clean the place is.', 'approved', 1, '2025-01-25 12:00:00'),
(17, NULL, 'Nicole Garcia', 'ngarcia@gmail.com', 5, 'Lifesaver for our rental business', 'We manage four vacation rental properties and this team handles all the turnover cleanings. They are incredibly flexible with scheduling, accommodate same-day requests when needed, and maintain a consistently high standard across all properties.', 'approved', 1, '2025-04-30 09:30:00'),
(17, NULL, 'Ryan Thompson', 'rthompson@email.com', 4, 'Great turnaround service', 'They clean our beach condo between guest stays and do an excellent job. Bathrooms are sanitized, kitchen is spotless, and all linens are replaced. Occasionally they miss restocking toiletries, but overall very dependable service.', 'approved', 0, '2025-08-05 15:15:00'),

-- ============================================================
-- Cleaner 18
-- ============================================================
(18, NULL, 'Christina Morgan', 'cmorgan@yahoo.com', 5, 'Restaurant passes every health inspection', 'Since hiring this cleaning company, our restaurant has scored perfect marks on every health inspection. They deep clean the kitchen, sanitize all food prep surfaces, clean the exhaust hoods, and keep the dining area immaculate. Essential service.', 'approved', 1, '2025-03-18 10:00:00'),
(18, NULL, 'Derek Washington', 'dwashington@gmail.com', 5, 'Kitchen and dining area are spotless', 'They handle the nightly deep clean of our 150-seat restaurant and the quality is outstanding. Grease traps, kitchen floors, stainless steel equipment, walk-in coolers, and all dining surfaces are thoroughly cleaned. Our kitchen staff loves arriving to a clean workspace.', 'approved', 1, '2025-06-08 16:30:00'),
(18, NULL, 'Amy Nelson', 'anelson@hotmail.com', 4, 'Very good restaurant cleaning', 'They have been cleaning our family restaurant for six months. The kitchen sanitation is excellent and the dining area always looks great. We had some initial communication issues about the scope of work, but once that was sorted out, everything has been smooth.', 'approved', 0, '2025-10-18 11:00:00'),

-- ============================================================
-- Cleaner 19
-- ============================================================
(19, NULL, 'Jeffrey Adams', 'jadams2@outlook.com', 5, 'Meets all healthcare compliance standards', 'They clean our medical office and understand the unique requirements of healthcare facility sanitation. Biohazard waste handling, exam room disinfection, and waiting area maintenance are all handled with strict adherence to protocols.', 'approved', 1, '2025-02-12 09:00:00'),
(19, NULL, 'Heather Martin', 'hmartin@email.com', 5, 'Trusted partner for our clinic', 'As the office manager for a busy dental practice, I need a cleaning service that takes infection control seriously. This team uses hospital-grade disinfectants, follows proper protocols, and keeps detailed cleaning logs. Could not ask for more.', 'approved', 1, '2025-05-22 13:30:00'),
(19, NULL, 'Roger Campbell', 'rcampbell@gmail.com', 4, 'Professional medical facility cleaning', 'They handle the nightly cleaning of our urgent care center. All exam rooms, restrooms, and common areas are thoroughly disinfected. The crew is well-trained in healthcare cleaning standards. Solid service.', 'approved', 0, '2025-09-08 10:15:00'),

-- ============================================================
-- Cleaner 20
-- ============================================================
(20, NULL, 'Pamela White', 'pwhite@yahoo.com', 5, 'Garage looks like a showroom', 'Had our three-car garage deep cleaned and the concrete floor was power-washed, degreased, and sealed. They also cleaned the walls, shelving, and even the garage door tracks. It looks like a brand new space. We can actually use it now.', 'approved', 1, '2025-01-10 11:00:00'),
(20, NULL, 'Victor Alvarez', 'valvarez@gmail.com', 4, 'Great warehouse cleaning', 'They cleaned our 10,000 sq ft warehouse including the floors, loading dock, and break room area. The industrial floor scrubbing made a huge difference. We plan to schedule this quarterly going forward.', 'approved', 1, '2025-04-05 14:45:00'),
(20, NULL, 'Janet Collins', 'jcollins@hotmail.com', 5, 'Transformed our storage area', 'Our warehouse had years of grime built up on the floors and walls. Their industrial cleaning crew came in with heavy-duty equipment and the transformation was remarkable. Even the overhead beams and fixtures were cleaned.', 'approved', 0, '2025-08-25 08:30:00'),

-- ============================================================
-- Cleaner 21
-- ============================================================
(21, NULL, 'Raymond Harris', 'rharris@email.com', 5, 'Absolutely love this cleaning team', 'They clean our four-bedroom house every other week and the quality is always exceptional. The team lead checks every room before they leave. Bathrooms sparkle, floors are mopped to perfection, and they always fold the toilet paper into a nice point.', 'approved', 1, '2025-03-28 10:00:00'),
(21, NULL, 'Teresa Ramirez', 'tramirez@outlook.com', 5, 'Consistent quality every visit', 'We have had the same cleaning team for nine months and they know exactly how we like things done. They even remember our preferences like using the gentle cleaner on the marble countertops and not moving certain decorative items.', 'approved', 1, '2025-07-14 12:30:00'),
(21, NULL, 'Howard Price', 'hprice@gmail.com', 3, 'Good service but communication could improve', 'The cleaning itself is quite good. Floors, surfaces, and bathrooms are always well done. However, scheduling changes are sometimes communicated last minute. Would be five stars if the office staff were as attentive as the cleaning crew.', 'approved', 0, '2025-11-02 09:00:00'),

-- ============================================================
-- Cleaner 22
-- ============================================================
(22, NULL, 'Deborah Evans', 'devans@yahoo.com', 5, 'Commercial cleaning at its finest', 'They service our corporate headquarters with 200 employees and the facilities are always impeccable. The janitorial crew is respectful of confidential documents and secure areas. We have received nothing but positive feedback from staff.', 'approved', 1, '2025-02-18 11:30:00'),
(22, NULL, 'Kenneth Wright', 'kwright@gmail.com', 4, 'Reliable commercial service', 'They clean our strip mall with five retail units every night. Each tenant is happy with the service and the common areas are always well-maintained. The account manager is responsive and handles any special requests promptly.', 'approved', 1, '2025-06-02 15:00:00'),
(22, NULL, 'Linda Baker', 'lbaker@email.com', 5, 'Impressed from day one', 'Switched to this commercial cleaning company after our previous one became unreliable. From the initial walkthrough to the daily service, everything has been professional and thorough. Our business looks great for clients.', 'approved', 0, '2025-10-15 08:00:00'),

-- ============================================================
-- Cleaner 23
-- ============================================================
(23, NULL, 'Philip Morris', 'pmorris@hotmail.com', 5, 'Pet stains completely gone', 'We have two dogs and a cat and our carpet was in rough shape. Their pet stain removal process was incredibly effective. Enzyme treatment, hot water extraction, and deodorizing made our carpets look and smell like new. No more pet odors.', 'approved', 1, '2025-01-22 10:00:00'),
(23, NULL, 'Angela Sullivan', 'asullivan@outlook.com', 4, 'Excellent carpet cleaning results', 'Had all five bedrooms and the stairs done. The technician was knowledgeable about different carpet fibers and adjusted his approach accordingly. Most stains came out completely, a few very old ones were significantly reduced.', 'approved', 1, '2025-05-08 13:15:00'),
(23, NULL, 'Douglas Reed', 'dreed@gmail.com', 5, 'Commercial carpet looks brand new', 'They cleaned the carpeting in our entire office of 3,500 square feet over the weekend so there was no disruption to business. Monday morning the carpet looked incredible. Professional service from start to finish.', 'approved', 0, '2025-09-30 14:00:00'),

-- ============================================================
-- Cleaner 24
-- ============================================================
(24, NULL, 'Cynthia Howard', 'choward@email.com', 5, 'Driveway and patio are gorgeous', 'They pressure washed our concrete driveway, brick patio, and pool deck. The amount of dirt and algae that came off was unbelievable. Everything looks 10 years newer. The curb appeal of our home has dramatically improved.', 'approved', 1, '2025-04-12 09:30:00'),
(24, NULL, 'Mark Simmons', 'msimmons@gmail.com', 5, 'Unbelievable transformation', 'Our commercial building exterior was covered in years of grime and mildew. After their pressure washing, the stucco looks like it was just painted. They also cleaned all the sidewalks and the parking area. Our tenants were thrilled.', 'approved', 1, '2025-07-20 11:00:00'),
(24, NULL, 'Barbara Powell', 'bpowell@yahoo.com', 4, 'Very happy with the results', 'Had our house exterior, fence, and driveway pressure washed. The house siding looks new and the fence went from green-tinged to its original cedar color. They were careful around the landscaping which I appreciated.', 'approved', 0, '2025-11-08 10:15:00'),

-- ============================================================
-- Cleaner 25
-- ============================================================
(25, NULL, 'Scott Peterson', 'speterson@outlook.com', 4, 'High-rise window cleaning pros', 'They handle the quarterly exterior window cleaning for our 12-story condo building. The results are always excellent and they work efficiently. The building management and residents are very satisfied with the service.', 'approved', 1, '2025-03-02 14:00:00'),
(25, NULL, 'Donna Mitchell', 'dmitchell@gmail.com', 5, 'Crystal clear windows every time', 'I hired them to clean all the windows in our Victorian home, including the hard-to-reach third floor dormers. They used proper equipment and safety precautions, and every window was perfectly clean. Also cleaned the screens and frames.', 'approved', 1, '2025-06-15 09:00:00'),
(25, NULL, 'Larry Butler', 'lbutler@email.com', 5, 'Storefront windows look fantastic', 'They clean the windows for our retail plaza every two weeks. The storefronts always look inviting and professional. They work early in the morning before stores open so there is no disruption to business. Great service.', 'approved', 0, '2025-10-25 16:00:00'),

-- ============================================================
-- Cleaner 26
-- ============================================================
(26, NULL, 'Alice Stewart', 'astewart@yahoo.com', 5, 'House cleaning that feels like a luxury', 'Their weekly house cleaning service makes me feel like I live in a five-star hotel. Every surface is dusted, every floor gleams, and the bathrooms are sanitized to a hospital standard. They even fold the throw blankets on the couch.', 'approved', 1, '2025-02-08 10:30:00'),
(26, NULL, 'Martin Flores', 'mflores@gmail.com', 5, 'Exceeded our expectations', 'We hired them for a one-time spring cleaning and were so impressed that we signed up for weekly service. The attention to detail was remarkable. They cleaned the tops of the kitchen cabinets, inside the microwave, and under all the beds.', 'approved', 1, '2025-05-25 12:45:00'),
(26, NULL, 'Carol Hughes', 'chughes@hotmail.com', 4, 'Consistently good cleaning', 'We have been using them for three months for bi-weekly cleanings. The house always looks great when they are done. They bring all their own supplies and are very respectful of our home. Occasionally they miss the inside of the microwave.', 'approved', 0, '2025-09-12 08:00:00'),

-- ============================================================
-- Cleaner 27
-- ============================================================
(27, NULL, 'Russell Ward', 'rward@email.com', 5, 'Outstanding deep clean service', 'Scheduled a spring deep clean and they left no stone unturned. Inside the refrigerator, behind the stove, ceiling fan blades, window blinds, light switch plates, and even the laundry room. Six hours of meticulous cleaning. Incredible.', 'approved', 1, '2025-04-08 09:00:00'),
(27, NULL, 'Frances Murphy', 'fmurphy@outlook.com', 4, 'Very thorough deep cleaning', 'They did a deep clean of our three-bedroom condo before we listed it for sale. The realtor said it was one of the cleanest properties she had ever shown. A few small things were missed in the garage, but the living spaces were perfect.', 'approved', 1, '2025-07-28 14:15:00'),
(27, NULL, 'Craig Bell', 'cbell@gmail.com', 5, 'Made our old house feel new', 'We moved into a 1960s home and wanted a deep clean before settling in. This team cleaned decades of buildup from every surface. The kitchen cabinets, bathroom tile, and hardwood floors all looked renewed. Absolutely worth it.', 'approved', 0, '2025-11-20 11:00:00'),

-- ============================================================
-- Cleaner 28
-- ============================================================
(28, NULL, 'Jean Brooks', 'jbrooks@yahoo.com', 4, 'Good office cleaning service', 'They clean our accounting firm three times a week and the quality has been consistent. The reception area, conference room, and partner offices are always presentable for clients. Restrooms are well-stocked and clean.', 'approved', 1, '2025-01-28 10:00:00'),
(28, NULL, 'Wayne Cox', 'wcox@gmail.com', 5, 'Best office cleaners we have had', 'After trying four different cleaning companies over the years, this one has been the most reliable by far. They follow a detailed checklist, the crew is trustworthy, and they even send photos confirming completion. Top marks.', 'approved', 1, '2025-05-15 13:30:00'),
(28, NULL, 'Gloria Richardson', 'grichardson@email.com', 5, 'Professional and trustworthy', 'Our tech startup has sensitive equipment and information throughout the office. This cleaning team respects our space, follows the security protocols we set, and keeps everything in great condition. Very impressed.', 'approved', 0, '2025-09-05 15:45:00'),

-- ============================================================
-- Cleaner 29
-- ============================================================
(29, NULL, 'Judy Sanders', 'jsanders@hotmail.com', 5, 'Saved our hardwood floors', 'They cleaned and refinished our original 1920s hardwood floors without having to sand them down. The deep clean removed years of wax buildup and grime, and the new finish made the grain pop beautifully. Museum-quality work.', 'approved', 1, '2025-03-30 09:30:00'),
(29, NULL, 'Peter Gonzalez', 'pgonzalez@outlook.com', 5, 'Tile restoration was phenomenal', 'Our Saltillo tile patio was stained and dull after years of neglect. They stripped, cleaned, and resealed every tile by hand. The terracotta color is vibrant again and the tiles are protected from further damage. Exceptional craftsmanship.', 'approved', 1, '2025-07-12 12:00:00'),
(29, NULL, 'Helen Barnes', 'hbarnes@gmail.com', 3, 'Good results, slow scheduling', 'The tile and grout cleaning itself was excellent. Our master bathroom looks fantastic. However, it took nearly three weeks from our initial call to get the appointment scheduled. The quality makes up for it, but faster booking would be appreciated.', 'approved', 0, '2025-11-15 10:30:00'),

-- ============================================================
-- Cleaner 30
-- ============================================================
(30, NULL, 'Roy Henderson', 'rhenderson@email.com', 5, 'Airbnb turnovers made easy', 'They handle all the turnovers for our three Airbnb properties. Same-day bookings, emergency cleanings, and linen service are all handled seamlessly. Our guest satisfaction ratings have improved dramatically since we started using them.', 'approved', 1, '2025-02-22 11:00:00'),
(30, NULL, 'Irene Cooper', 'icooper@yahoo.com', 4, 'Great vacation rental cleaning', 'They clean our beach house between rentals during the busy summer season, sometimes with only a four-hour window between checkout and check-in. They always deliver a spotless property on time. Very impressive turnaround.', 'approved', 1, '2025-06-05 14:30:00'),
(30, NULL, 'Eugene Foster', 'efoster@gmail.com', 5, 'Our rental review scores skyrocketed', 'Since switching to this turnover cleaning service, our VRBO property has gone from a 4.2 to a 4.9 cleanliness rating. They stage the property beautifully, leave welcome touches, and report any maintenance issues they notice. True partners.', 'approved', 0, '2025-10-08 09:15:00'),

-- ============================================================
-- Cleaner 31
-- ============================================================
(31, NULL, 'Tiffany Ross', 'tross@outlook.com', 5, 'Move-in cleaning was perfect', 'Hired them to deep clean our new house before the movers arrived. Every closet, cabinet, and shelf was wiped down. Bathrooms were disinfected and the kitchen was spotless. We felt completely comfortable bringing our newborn into the home.', 'approved', 1, '2025-04-18 08:30:00'),
(31, NULL, 'Dennis Price', 'dprice@email.com', 4, 'Apartment move-out went smoothly', 'Needed a move-out clean for our two-bedroom apartment on short notice and they accommodated us the next day. Walls, floors, appliances, and fixtures were all cleaned thoroughly. Landlord was satisfied and we got our deposit back.', 'approved', 1, '2025-08-10 13:00:00'),
(31, NULL, 'Martha Gray', 'mgray@gmail.com', 5, 'Stress-free moving experience', 'Moving is stressful enough without worrying about cleaning. They handled both the move-out clean of our old place and the move-in clean of the new one. Both properties were left in pristine condition. Invaluable service.', 'approved', 0, '2025-12-01 10:00:00'),

-- ============================================================
-- Cleaner 32
-- ============================================================
(32, NULL, 'Albert Long', 'along@yahoo.com', 5, 'Post-renovation cleanup done right', 'After a full kitchen and bath remodel, the construction dust was everywhere. This team spent two full days doing a meticulous cleanup. They cleaned inside every cabinet, wiped down every surface, and got the dust out of all the vents.', 'approved', 1, '2025-01-18 09:00:00'),
(32, NULL, 'Sharon Butler', 'sbutler@gmail.com', 4, 'Handled the mess beautifully', 'Our contractor left quite a disaster after a room addition project. The cleanup crew tackled paint splatters, drywall dust, caulk residue, and construction debris efficiently. The new room was ready to furnish in just one day.', 'approved', 1, '2025-05-05 12:30:00'),
(32, NULL, 'Earl Watson', 'ewatson2@hotmail.com', 5, 'Essential after any renovation', 'Had a major bathroom remodel and the fine dust had gotten into every room in the house. They did a whole-house post-construction clean that took care of everything. HVAC vents, light fixtures, window tracks, and all surfaces. Spotless.', 'approved', 0, '2025-09-22 14:45:00'),

-- ============================================================
-- Cleaner 33
-- ============================================================
(33, NULL, 'Kathleen Reed', 'kreed@email.com', 5, 'Pool maintenance we can count on', 'Reliable weekly pool service that keeps our pool swim-ready year round. The technician is thorough with chemical testing, skimming, brushing, and filter maintenance. We have not had a single issue since they took over.', 'approved', 1, '2025-03-10 10:30:00'),
(33, NULL, 'Jesse Howard', 'jhoward@outlook.com', 5, 'Green pool completely restored', 'Inherited a badly neglected pool when we bought our house. They shocked it, scrubbed it, replaced the filter, and had crystal clear water within a week. Now they maintain it weekly and it always looks beautiful.', 'approved', 1, '2025-06-28 11:45:00'),
(33, NULL, 'Norma Young', 'nyoung@gmail.com', 4, 'Solid pool cleaning service', 'They have been maintaining our community pool for a season now. Water chemistry is always balanced and the pool deck is kept clean. Response time for equipment issues could be a little faster, but overall very satisfied.', 'approved', 0, '2025-10-20 09:00:00'),

-- ============================================================
-- Cleaner 34
-- ============================================================
(34, NULL, 'Harold Alexander', 'halexander@yahoo.com', 5, 'Exceptional janitorial service', 'They provide janitorial services for our medical office building and meet all our stringent cleanliness requirements. Waiting rooms, exam rooms, and common areas are always sanitized properly. We receive regular quality audits as well.', 'approved', 1, '2025-02-15 13:00:00'),
(34, NULL, 'Bonnie Russell', 'brussell@gmail.com', 5, 'Church cleaning is always perfect', 'They clean our church sanctuary, fellowship hall, and classrooms weekly. The attention to detail in the sanctuary is particularly impressive. Pews are dusted, floors are polished, and the altar area is always immaculate.', 'approved', 1, '2025-05-30 10:00:00'),
(34, NULL, 'Christian Diaz', 'cdiaz@email.com', 4, 'Reliable and professional janitorial crew', 'Our fitness center requires daily cleaning and this team handles it well. Locker rooms, equipment surfaces, mirrors, and floors are all maintained to a high standard. Members regularly comment on the cleanliness of our facility.', 'approved', 0, '2025-09-18 16:30:00'),

-- ============================================================
-- Cleaner 35
-- ============================================================
(35, NULL, 'Doris Powell', 'dpowell@hotmail.com', 5, 'Mattress and sofa are like new', 'Had our king-sized mattress, two sofas, and four dining chairs cleaned. The mattress had visible stains from a toddler and they all came out. The upholstery is bright and fresh again. The team was careful and professional.', 'approved', 1, '2025-04-25 09:30:00'),
(35, NULL, 'Wayne Jackson', 'wjackson@outlook.com', 4, 'Great upholstery cleaning', 'They cleaned a set of antique wingback chairs for us and did a wonderful job. The technician identified the fabric type and chose the appropriate cleaning method. Colors are vibrant again and there was no shrinkage or damage.', 'approved', 1, '2025-08-02 12:00:00'),
(35, NULL, 'Evelyn Wood', 'ewood@gmail.com', 5, 'Car interior upholstery is spotless', 'They also offer auto upholstery cleaning and did all three of our cars in one visit. Cloth seats, floor mats, and headliners all look fantastic. Way cheaper than a full auto detail and the results on the upholstery were even better.', 'approved', 0, '2025-12-05 11:30:00'),

-- ============================================================
-- Cleaner 36
-- ============================================================
(36, NULL, 'Randy Morris', 'rmorris@email.com', 5, 'Air quality dramatically improved', 'After having our entire duct system cleaned, we noticed an immediate reduction in dust accumulation on furniture. The technician also discovered and removed a bird nest from one of the exterior vents. Well worth the investment for our family''s health.', 'approved', 1, '2025-01-12 10:00:00'),
(36, NULL, 'Brenda Turner', 'bturner@yahoo.com', 4, 'Professional duct service', 'They cleaned the ducts in our 20-year-old home and the amount of debris that came out was alarming. The before and after photos were eye-opening. Our HVAC system is running more efficiently now too. Good experience overall.', 'approved', 1, '2025-04-20 14:15:00'),
(36, NULL, 'Adam Perry', 'aperry@gmail.com', 5, 'Complete HVAC and duct cleaning', 'They did a comprehensive cleaning of our entire HVAC system including supply and return ducts, registers, coils, and the blower motor. The system runs quieter and our energy bills have actually decreased. Very thorough service.', 'approved', 0, '2025-08-18 09:30:00'),

-- ============================================================
-- Cleaner 37
-- ============================================================
(37, NULL, 'Virginia Allen', 'vallen@hotmail.com', 5, 'Eco cleaning that exceeds expectations', 'We switched to this green cleaning service when our daughter developed asthma. The all-natural products they use have made a noticeable difference in our indoor air quality. Our home is just as clean as before, but without the harsh chemicals.', 'approved', 1, '2025-03-05 11:00:00'),
(37, NULL, 'Jose Rivera', 'jrivera@gmail.com', 5, 'Green cleaning done right', 'As someone who cares deeply about environmental impact, I appreciate that they use biodegradable products, drive electric vehicles, and minimize waste. The cleaning quality itself is outstanding. Nice to know you can be clean and green.', 'approved', 1, '2025-06-22 13:45:00'),
(37, NULL, 'Carolyn Martin', 'cmartin@email.com', 3, 'Good cleaning, limited product effectiveness', 'The eco-friendly approach is admirable and the team is hardworking. However, I found that some tough kitchen grease and hard water stains required additional passes to fully remove. The standard clean is great but stubborn spots need extra effort.', 'approved', 0, '2025-10-28 08:15:00'),

-- ============================================================
-- Cleaner 38
-- ============================================================
(38, NULL, 'Tammy Bailey', 'tbailey@outlook.com', 5, 'Best house cleaning in the area', 'They have been cleaning our five-bedroom house weekly for over a year. The consistency is what impresses me most. Every visit is thorough, from vacuuming under furniture to cleaning light switches and door handles. Five stars every time.', 'approved', 1, '2025-02-25 10:30:00'),
(38, NULL, 'Louis Morgan', 'lmorgan@yahoo.com', 5, 'Attention to detail is unmatched', 'I have used many cleaning services over the years and this one stands out. They clean places most services ignore: top of the refrigerator, behind toilets, under the kitchen sink, and inside trash cans. Truly thorough.', 'approved', 1, '2025-06-10 14:00:00'),
(38, NULL, 'Megan Campbell', 'mcampbell@gmail.com', 4, 'Wonderful cleaning service', 'Our bi-weekly house cleaning is always something we look forward to. Coming home to a freshly cleaned house is such a treat. The team is friendly, efficient, and respectful. Would give five stars but wish they offered weekend appointments.', 'approved', 0, '2025-10-02 09:00:00'),

-- ============================================================
-- Cleaner 39
-- ============================================================
(39, NULL, 'Philip Bennett', 'pbennett@email.com', 4, 'Good commercial cleaning partner', 'They clean our retail location nightly and the store is always ready for customers each morning. Floors are mopped, windows are cleaned, and displays are dusted. The stock room could use a bit more attention but the customer-facing areas are great.', 'approved', 1, '2025-04-15 12:30:00'),
(39, NULL, 'Lillian Torres', 'ltorres@hotmail.com', 5, 'Warehouse cleaning was excellent', 'Had them do a deep clean of our distribution warehouse. They power-scrubbed the floors, cleaned the break room, sanitized the restrooms, and even cleaned the loading dock area. The facility looked better than when we first moved in.', 'approved', 1, '2025-08-08 10:00:00'),
(39, NULL, 'Gerald Hayes', 'ghayes@gmail.com', 5, 'Outstanding commercial service', 'They handle cleaning for our chain of three salons and each location is maintained beautifully. Stations are sanitized between clients, floors are spotless, and restrooms are always clean. Our clients notice and appreciate it.', 'approved', 0, '2025-12-10 15:30:00'),

-- ============================================================
-- Cleaner 40
-- ============================================================
(40, NULL, 'Dorothy Patterson', 'dpatterson@yahoo.com', 5, 'Carpet looks years younger', 'Hired them to clean the carpet in our entire home before hosting a family reunion. Every room came out looking fantastic. The high traffic areas in the hallway that were dark and matted are now fluffy and bright again. Amazing results.', 'approved', 1, '2025-01-30 09:00:00'),
(40, NULL, 'Ronald Wood', 'rwood@outlook.com', 5, 'Stain removal experts', 'We had red wine, coffee, and ink stains on various carpets throughout our home. They treated each stain specifically and every single one came out completely. I did not think it was possible without replacing the carpet. True professionals.', 'approved', 1, '2025-05-18 13:00:00'),
(40, NULL, 'Christine Price', 'cprice@gmail.com', 4, 'Very effective carpet cleaning', 'They cleaned the carpeting in our office building lobby and conference rooms. The results were excellent and the carpets dried faster than expected. The only minor issue was the strong cleaning agent smell, which dissipated by the next morning.', 'approved', 0, '2025-09-25 11:15:00'),

-- ============================================================
-- Cleaner 41
-- ============================================================
(41, NULL, 'Judith Rogers', 'jrogers@email.com', 5, 'Pressure washing transformed our property', 'They pressure washed our entire house exterior, driveway, sidewalk, and pool cage. The house looks like it was freshly painted. Neighbors keep stopping to ask who did it. Best money we have spent on home maintenance this year.', 'approved', 1, '2025-03-20 10:00:00'),
(41, NULL, 'Terry Clark', 'tclark@gmail.com', 4, 'Great results on the driveway', 'Had years of oil stains on our concrete driveway from old cars. Their degreasing and pressure washing process removed nearly all of it. The driveway looks 90% better. They also cleaned the sidewalk and front walkway.', 'approved', 1, '2025-07-08 14:30:00'),
(41, NULL, 'Ruby Walker', 'rwalker@hotmail.com', 5, 'Commercial building looks brand new', 'They pressure washed our strip mall including all the storefronts, sidewalks, and the parking lot curbs. The improvement was dramatic and several tenants have commented positively. We will be scheduling this quarterly.', 'approved', 0, '2025-11-12 08:45:00'),

-- ============================================================
-- Cleaner 42
-- ============================================================
(42, NULL, 'Cheryl Jenkins', 'cjenkins@yahoo.com', 5, 'High-rise window perfection', 'They clean the exterior windows of our 20-story residential building twice a year. The crews are professional, safety-conscious, and the results are flawless. Every unit has crystal-clear views after they finish. Highly recommend for condo associations.', 'approved', 1, '2025-02-05 11:30:00'),
(42, NULL, 'Frank Nelson', 'fnelson@outlook.com', 5, 'Residential window cleaning excellence', 'They did every window in our two-story colonial, including the storm windows and screens. Inside and out, everything is spotless. The natural light flooding into the house is noticeably brighter. Will definitely become a regular customer.', 'approved', 1, '2025-06-18 09:00:00'),
(42, NULL, 'Marie Sanders', 'msanders@gmail.com', 4, 'Reliable window service', 'We use them quarterly for our storefront windows and they are always reliable. The windows are left streak-free and they clean the entrance glass doors as well. Once they accidentally left a bucket behind but returned for it quickly.', 'approved', 0, '2025-10-30 13:30:00'),

-- ============================================================
-- Cleaner 43
-- ============================================================
(43, NULL, 'Joyce Simmons', 'jsimmons@email.com', 5, 'Deep clean that changed everything', 'After neglecting our house during a particularly busy season at work, we called for a deep clean. The team of four spent seven hours restoring order. The kitchen grease buildup, bathroom soap scum, and dusty corners are all gone. Life-changing.', 'approved', 1, '2025-04-02 08:00:00'),
(43, NULL, 'Eugene Barnes', 'ebarnes@yahoo.com', 4, 'Thorough spring cleaning', 'Had them do a full spring deep clean. They moved furniture, cleaned behind and under everything, washed all the interior windows, and even cleaned the laundry room top to bottom. Minor scuff on one baseboard, but otherwise excellent.', 'approved', 1, '2025-07-25 12:30:00'),
(43, NULL, 'Ruth Henderson', 'rhenderson2@gmail.com', 5, 'Pre-listing deep clean was worth it', 'Real estate agent recommended a deep clean before listing our home. These professionals made the house show-ready. Kitchen appliances gleamed, bathrooms sparkled, and every surface was dust-free. We got an offer within the first week.', 'approved', 0, '2025-11-28 10:00:00'),

-- ============================================================
-- Cleaner 44
-- ============================================================
(44, NULL, 'Wanda Rivera', 'wrivera@hotmail.com', 2, 'Disappointed with the service', 'The initial cleaning was decent but subsequent visits dropped in quality significantly. Several areas were consistently missed and when I raised concerns, the response was slow. Eventually had to switch to a different provider.', 'approved', 1, '2025-03-25 11:00:00'),
(44, NULL, 'Harry Cox', 'hcox@gmail.com', 4, 'Much improved after feedback', 'Had some initial issues with consistency but after speaking with the manager, the service improved dramatically. The new team assigned to our home is thorough and reliable. Kitchen and bathrooms are always well done.', 'approved', 0, '2025-07-15 14:00:00'),
(44, NULL, 'Janice Kelly', 'jkelly@email.com', 5, 'Excellent house cleaning', 'We have had nothing but great experiences with this service. Our cleaner Maria is detail-oriented and takes pride in her work. The house always smells fresh and looks immaculate. Bathrooms and floors are particularly well done.', 'approved', 1, '2025-11-05 09:30:00'),

-- ============================================================
-- Cleaner 45
-- ============================================================
(45, NULL, 'Lawrence Ward', 'lward@outlook.com', 5, 'Restaurant kitchen is inspection-ready', 'They provide nightly deep cleaning for our restaurant kitchen. Hood vents, grease traps, prep surfaces, and floors are all thoroughly cleaned and sanitized. We have had three surprise health inspections since hiring them and passed all with flying colors.', 'approved', 1, '2025-02-10 16:00:00'),
(45, NULL, 'Annie Gray', 'agray@yahoo.com', 5, 'Dining area always spotless', 'They handle the full restaurant cleaning for our bistro. The dining room, bar area, and restrooms are always guest-ready. They even clean the outdoor patio furniture and umbrellas. Our reputation for cleanliness has become a selling point.', 'approved', 1, '2025-06-12 10:30:00'),
(45, NULL, 'Raymond Lopez', 'rlopez@gmail.com', 4, 'Solid restaurant cleaning', 'We use them for our food truck commissary kitchen and they do a very good job. Everything is sanitized to code and the floors are always clean. Communication about holiday schedule changes could be better, but the cleaning itself is excellent.', 'approved', 0, '2025-10-15 13:00:00'),

-- ============================================================
-- Cleaner 46
-- ============================================================
(46, NULL, 'Betty Coleman', 'bcoleman@email.com', 5, 'Medical office meets every standard', 'Our dermatology practice has strict cleaning requirements and this service meets them all. Exam rooms are disinfected between patient uses, biohazard waste is handled properly, and waiting areas are always clean and welcoming.', 'approved', 1, '2025-04-08 09:00:00'),
(46, NULL, 'Jerry Russell', 'jrussell@hotmail.com', 5, 'Trusted healthcare facility cleaner', 'They clean our physical therapy clinic and understand the importance of sanitizing treatment tables, exercise equipment, and hydrotherapy areas. Their team is trained in infection control protocols and it shows. No cross-contamination concerns.', 'approved', 1, '2025-08-20 11:45:00'),
(46, NULL, 'Sara Adams', 'sadams@gmail.com', 4, 'Reliable medical cleaning', 'We use them for our veterinary clinic. They handle the specific challenges of animal healthcare facilities well, including odor control and thorough disinfection. The waiting room and exam rooms are always presentable for pet owners.', 'approved', 0, '2025-12-08 14:30:00'),

-- ============================================================
-- Cleaner 47
-- ============================================================
(47, NULL, 'Andrea Powell', 'apowell@outlook.com', 5, 'Garage transformation was incredible', 'They cleaned our three-car garage from top to bottom. The concrete floor was power-washed and epoxy-coated, walls were wiped down, and they even cleaned the garage door mechanisms. It went from a cluttered mess to a showroom. Neighbors were stunned.', 'approved', 1, '2025-01-15 10:00:00'),
(47, NULL, 'Keith Alexander', 'kalexander@email.com', 5, 'Warehouse clean was comprehensive', 'They handled the annual deep clean of our 15,000 sq ft warehouse. Industrial floor scrubbing, racking cleanup, restroom overhaul, and break room deep clean. Everything was done over a weekend with zero disruption to our Monday operations.', 'approved', 1, '2025-05-08 13:15:00'),
(47, NULL, 'Julia Sanchez', 'jsanchez@gmail.com', 4, 'Very good industrial cleaning', 'They cleaned our auto repair shop including the service bays, customer area, and restrooms. The degreasing of the shop floor was impressive. Only small complaint is they could not schedule us as quickly as we needed initially.', 'approved', 0, '2025-09-10 08:00:00'),

-- ============================================================
-- Cleaner 48
-- ============================================================
(48, NULL, 'Arthur Mitchell', 'amitchell@yahoo.com', 5, 'Hoarding cleanup with dignity', 'My father''s home needed a compassionate cleanup after years of hoarding. This team was incredibly respectful, working patiently with our family to sort through belongings. They cleaned and sanitized the entire home over three days. We are deeply grateful.', 'approved', 1, '2025-03-15 09:30:00'),
(48, NULL, 'Grace Thompson', 'gthompson@gmail.com', 5, 'Sensitive and professional', 'They handled an estate cleanout for our family after a loss. The team was discreet, careful with sentimental items, and thorough with the cleaning. They coordinated donation pickups and proper disposal of everything. Truly a full-service operation.', 'approved', 1, '2025-07-02 12:00:00'),
(48, NULL, 'Charles Fox', 'cfox@email.com', 4, 'Thorough property cleanup', 'Hired them to clean out and sanitize a rental property that had been severely neglected by the tenant. They hauled away 4 truckloads of debris, deep cleaned every surface, and eliminated persistent odors. The property is rentable again.', 'approved', 0, '2025-11-18 14:00:00'),

-- ============================================================
-- Cleaner 49
-- ============================================================
(49, NULL, 'Phyllis Ross', 'pross@hotmail.com', 5, 'Spotless bi-weekly cleaning', 'They clean our townhome every two weeks and the quality never drops. Three bedrooms, two and a half baths, and a full kitchen are all done in about two hours. The team is efficient, quiet, and always leaves things exactly how we like them.', 'approved', 1, '2025-02-20 10:00:00'),
(49, NULL, 'Jack Stewart', 'jstewart@outlook.com', 5, 'Best cleaning service we have ever used', 'After moving from out of state, finding a trustworthy cleaning service was a priority. This company came highly recommended and has lived up to every expectation. They clean our home as if it were their own. Cannot say enough good things.', 'approved', 1, '2025-06-08 14:30:00'),
(49, NULL, 'Lois Barnes', 'lbarnes@gmail.com', 4, 'Very pleased with the service', 'Weekly house cleaning that is consistently good. They adapt to our changing needs, whether we need extra attention in the nursery or a lighter clean when we have been away. The flexibility and personal attention are much appreciated.', 'approved', 0, '2025-10-12 09:15:00'),

-- ============================================================
-- Cleaner 50
-- ============================================================
(50, NULL, 'Carl Griffin', 'cgriffin@email.com', 5, 'Commercial carpet experts', 'They cleaned 12,000 sq ft of commercial carpet in our office building over a single weekend. The traffic lanes that were visibly darker are now uniform with the rest of the carpet. Zero disruption to our Monday morning operations. Very professional.', 'approved', 1, '2025-04-22 11:00:00'),
(50, NULL, 'Marilyn Hayes', 'mhayes@yahoo.com', 4, 'Great carpet cleaning results', 'Had our living room, dining room, and stairway carpets cleaned. The pre-treatment they applied really helped lift out the old stains. The carpets dried in about four hours and looked noticeably brighter. Happy with the service.', 'approved', 1, '2025-08-14 13:30:00'),
(50, NULL, 'Vincent Roberts', 'vroberts@gmail.com', 5, 'Oriental rug cleaning specialists', 'They hand-cleaned two Persian rugs and a Turkish kilim for us. The care and attention they gave to each rug was remarkable. Colors are vibrant, fringes are clean, and they even found and repaired a small hole in one of the rugs. Experts.', 'approved', 0, '2025-12-15 10:30:00'),

-- ============================================================
-- Cleaner 51
-- ============================================================
(51, NULL, 'Lillian Gibson', 'lgibson@hotmail.com', 5, 'Exceptional house cleaning team', 'They clean our lakefront home weekly and are always meticulous. The hardwood floors are mopped perfectly, the large windows overlooking the lake are always streak-free, and the kitchen is sanitized top to bottom. We could not be happier.', 'approved', 1, '2025-01-25 09:00:00'),
(51, NULL, 'Samuel Walker', 'swalker@email.com', 4, 'Dependable weekly cleaning', 'They have been cleaning our family home for five months now. The team is polite, punctual, and thorough. Occasionally a ceiling fan or two gets missed, but overall the house looks and feels great after every visit.', 'approved', 1, '2025-05-12 12:00:00'),
(51, NULL, 'Jacqueline Brooks', 'jbrooks2@gmail.com', 5, 'Trusted with our home', 'As a working mom with three kids, a clean house is essential for my sanity. This team understands that and delivers every single week. They even pick up toys before vacuuming and organize the kids'' bathroom. Above and beyond.', 'approved', 0, '2025-09-28 15:00:00'),

-- ============================================================
-- Cleaner 52
-- ============================================================
(52, NULL, 'Frederick Cole', 'fcole@outlook.com', 5, 'Office building sparkles', 'They handle the complete cleaning of our four-story office building. Every floor gets equal attention and the quality is uniformly high. The building lobby is always presentable for visitors and the elevators are spotless. First-rate service.', 'approved', 1, '2025-03-08 10:30:00'),
(52, NULL, 'Katherine Perry', 'kperry@gmail.com', 5, 'Outstanding commercial clean', 'We are a financial services firm and first impressions matter. This cleaning company ensures our office always looks polished and professional. The conference rooms, reception area, and executive offices are immaculate. Clients notice.', 'approved', 1, '2025-07-05 14:00:00'),
(52, NULL, 'Benjamin Cruz', 'bcruz@yahoo.com', 3, 'Good but staffing inconsistency', 'The cleaning quality is good when the regular crew shows up. However, we have had substitute crews a few times that did not meet the same standard. When we brought this up, the manager was responsive and things have improved since.', 'approved', 0, '2025-11-22 08:30:00'),

-- ============================================================
-- Cleaner 53
-- ============================================================
(53, NULL, 'Peggy Butler', 'pbutler@email.com', 5, 'Tile floors are gleaming', 'They stripped, cleaned, and re-sealed the tile floors in our entire home. The kitchen and bathroom floors look brand new. The grout went from dingy brown back to bright white. This is a service every homeowner should do periodically.', 'approved', 1, '2025-02-28 09:00:00'),
(53, NULL, 'Tony Rivera', 'trivera@hotmail.com', 4, 'Professional tile restoration', 'Had our commercial kitchen tile and grout deep cleaned and sealed. The non-slip treatment they applied gives us peace of mind for employee safety. The kitchen looks clean and professional. Good service at a fair price.', 'approved', 1, '2025-06-15 11:30:00'),
(53, NULL, 'Elaine Russell', 'erussell@gmail.com', 5, 'Shower and bath tile look incredible', 'Our master bathroom tile had developed mold in the grout lines and no amount of home cleaning products could fix it. Their professional treatment eliminated every trace of mold and the new sealant prevents regrowth. Worth every cent.', 'approved', 0, '2025-10-08 13:00:00'),

-- ============================================================
-- Cleaner 54
-- ============================================================
(54, NULL, 'Joan Henderson', 'jhenderson@yahoo.com', 5, 'Perfect Airbnb cleaning partner', 'They do our vacation rental turnovers and are absolutely reliable. The property is always immaculate for the next guests, linens are fresh, and they send us a photo checklist after each cleaning. Our Superhost status is thanks to them.', 'approved', 1, '2025-04-30 10:00:00'),
(54, NULL, 'Roger Phillips', 'rphillips@outlook.com', 5, 'Five-star turnover service', 'Managing multiple vacation rentals requires a cleaning partner you can trust completely. This team handles four of our properties with same-day turnovers that are always perfect. They restock supplies, report damages, and stage beautifully.', 'approved', 1, '2025-08-25 12:45:00'),
(54, NULL, 'Judith Long', 'jlong@gmail.com', 4, 'Great rental cleaning service', 'They clean our mountain cabin rental between guests. It is a challenging property due to the wood burning fireplace and muddy hiking gear, but they handle it well. Ash cleanup, mud removal, and a thorough sanitization every time.', 'approved', 0, '2025-12-20 09:00:00'),

-- ============================================================
-- Cleaner 55
-- ============================================================
(55, NULL, 'Danny Morales', 'dmorales@email.com', 5, 'Move-out clean saved our deposit', 'We were worried about losing our security deposit due to cooking stains in the kitchen and mildew in the bathroom. They tackled every surface and left the apartment in better condition than when we moved in. Landlord refunded our full deposit.', 'approved', 1, '2025-01-20 11:00:00'),
(55, NULL, 'Marianne Foster', 'mfoster@hotmail.com', 5, 'Move-in clean gave us peace of mind', 'The previous tenants of our new apartment had pets and we have allergies. This team did a thorough allergen-removing deep clean including all carpets, vents, and surfaces. We moved in with zero allergy issues. Exactly what we needed.', 'approved', 1, '2025-05-28 14:00:00'),
(55, NULL, 'Patrick Bell', 'pbell@gmail.com', 4, 'Good move-out cleaning', 'Needed a quick move-out clean on short notice and they accommodated us within 48 hours. The apartment was cleaned thoroughly and the property manager signed off on it immediately. Fast and effective service.', 'approved', 0, '2025-09-15 10:30:00'),

-- ============================================================
-- Cleaner 56
-- ============================================================
(56, NULL, 'Irma Watson', 'iwatson@yahoo.com', 5, 'Post-construction perfection', 'After a full home addition project, every surface was coated in construction dust. Their cleanup team was thorough beyond belief. They cleaned inside cabinets, wiped down every window, and detailed every surface. The home was ready to enjoy immediately.', 'approved', 1, '2025-03-22 09:30:00'),
(56, NULL, 'Glen Cooper', 'gcooper@email.com', 4, 'Solid post-reno cleanup', 'We had our basement finished and the cleanup afterward was significant. Drywall dust, paint splatters, and adhesive residue were all handled efficiently. They protected the finished areas while working. Good experience overall.', 'approved', 1, '2025-07-18 13:00:00'),
(56, NULL, 'Monica Russell', 'mrussell@outlook.com', 5, 'Made the new space move-in ready', 'Our office renovation left behind a significant mess that our regular cleaning crew could not handle. This specialized post-construction team had all the right equipment and techniques. Three days later the space was pristine.', 'approved', 0, '2025-11-30 10:00:00'),

-- ============================================================
-- Cleaner 57
-- ============================================================
(57, NULL, 'Chester Hughes', 'chughes2@gmail.com', 5, 'Pool has never been this clear', 'After taking over our pool maintenance, the water went from cloudy to crystal clear within two weeks. They adjusted the chemistry, repaired a small pump leak they found, and now our pool is always swim-ready. Excellent weekly service.', 'approved', 1, '2025-02-15 10:00:00'),
(57, NULL, 'Hazel Martin', 'hmartin2@email.com', 5, 'Resort-quality pool maintenance', 'They maintain the pool and hot tub at our bed and breakfast. Guest compliments about the pool have increased dramatically. The water is always balanced, the tile line is scrubbed, and the deck area is kept tidy. Truly professional.', 'approved', 1, '2025-06-30 11:30:00'),
(57, NULL, 'Norman Ward', 'nward@yahoo.com', 4, 'Reliable pool service', 'Good weekly pool maintenance service. They keep the chemistry balanced, clean the filter, and skim regularly. Once the service was delayed without notice, but they came the following day and addressed the issue. Generally very satisfied.', 'approved', 0, '2025-10-22 14:15:00'),

-- ============================================================
-- Cleaner 58
-- ============================================================
(58, NULL, 'Marcia Lane', 'mlane@hotmail.com', 1, 'Very disappointed', 'Hired them for a deep clean and they spent less than an hour in our three-bedroom house. Major areas like behind appliances and inside cabinets were completely skipped. The team seemed rushed and disinterested. Would not recommend.', 'approved', 1, '2025-04-10 09:00:00'),
(58, NULL, 'Curtis Young', 'cyoung@gmail.com', 3, 'Average cleaning service', 'The basic cleaning is acceptable but nothing special. Floors and surfaces are wiped down, bathrooms are cleaned, but the deep corners and details are often overlooked. For the price, I expected more attention to detail.', 'approved', 0, '2025-08-12 12:00:00'),
(58, NULL, 'Stella Brooks', 'sbrooks@email.com', 4, 'Improved significantly', 'After reading some mixed reviews, I was hesitant. But our experience has been positive. They assigned us a consistent cleaner who is thorough and reliable. The house is always clean and fresh when she is done. Happy with the current service.', 'approved', 1, '2025-12-02 10:30:00'),

-- ============================================================
-- Cleaner 59
-- ============================================================
(59, NULL, 'Wilma Peterson', 'wpeterson@outlook.com', 5, 'Pressure washing pros', 'They did our entire property including the house, driveway, fence, patio, and pool enclosure. Everything looks freshly painted and brand new. The algae on the north side of the house is completely gone. Best curb appeal in the neighborhood now.', 'approved', 1, '2025-01-08 10:00:00'),
(59, NULL, 'Floyd Kelly', 'fkelly@gmail.com', 5, 'Commercial property looks amazing', 'They pressure washed our entire shopping center including all walkways, the parking garage, and the building exteriors. The improvement was dramatic and our tenants and their customers have all noticed. Scheduling a quarterly service.', 'approved', 1, '2025-05-20 14:30:00'),
(59, NULL, 'Thelma Gibson', 'tgibson@yahoo.com', 4, 'Solid pressure washing job', 'Had our brick paver driveway and patio pressure washed and re-sanded. The pavers look beautiful again and the weeds that were growing between them are completely gone. They were careful around the delicate plantings. Very satisfied.', 'approved', 0, '2025-09-30 08:30:00'),

-- ============================================================
-- Cleaner 60
-- ============================================================
(60, NULL, 'Elsie Morris', 'emorris@email.com', 5, 'Complete cleaning solution', 'They handle our bi-weekly house cleaning plus quarterly deep cleans and window washing. Having one company manage all our cleaning needs has been so convenient. The quality across all services is consistently excellent.', 'approved', 1, '2025-03-28 11:00:00'),
(60, NULL, 'Oscar Flores', 'oflores@hotmail.com', 5, 'Our go-to for everything cleaning', 'From regular house cleaning to carpet shampooing to post-party cleanup, they handle it all. We have used them for at least a dozen different cleaning jobs and every single one has been done to a high standard. True one-stop shop.', 'approved', 1, '2025-07-22 13:00:00'),
(60, NULL, 'Gladys Turner', 'gturner@gmail.com', 4, 'Wonderful all-around service', 'We use their weekly house cleaning and seasonal deep cleaning packages. The regular cleanings keep everything maintained and the deep cleans tackle the things that build up over time. Great value for the comprehensive service they provide.', 'approved', 0, '2026-01-15 09:30:00');

SET FOREIGN_KEY_CHECKS = 1;
