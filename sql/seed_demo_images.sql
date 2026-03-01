-- ============================================================
-- seed_demo_images.sql
-- Cleaning-themed Unsplash images for all 60 demo cleaners
-- Logos (200x200), Cover images (1200x400), Portfolio photos (800x600)
-- All images served from Unsplash CDN - free for commercial use
-- ============================================================

SET NAMES utf8mb4;

-- ============================================================
-- CLEANER LOGOS & COVER IMAGES
-- ============================================================

-- FL cleaners (1-10)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1484154218962-a197022b5858?w=1200&h=400&fit=crop'
WHERE slug = 'sparkle-home-cleaning';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1585421514284-efb74c2b69ba?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1552321554-5fefe8c9ef14?w=1200&h=400&fit=crop'
WHERE slug = 'miami-maid-service';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1628177142898-93e36e4e3a50?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1502005097973-6a7082348e28?w=1200&h=400&fit=crop'
WHERE slug = 'florida-fresh-clean';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1563453392212-326f5e854473?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1646980241033-cd7abda2ee88?w=1200&h=400&fit=crop'
WHERE slug = 'sunshine-deep-clean';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1556761175-4b46a572b786?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1533090161767-e6ffed986c88?w=1200&h=400&fit=crop'
WHERE slug = 'gulf-coast-commercial-cleaning';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1549637642-90187f64f420?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1597665863042-47e00964d899?w=1200&h=400&fit=crop'
WHERE slug = 'tampa-bay-carpet-pros';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1718152470408-cfeebeb6b9fc?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1718152423985-2d7909a96fa1?w=1200&h=400&fit=crop'
WHERE slug = 'orlando-pressure-wash';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1651481127251-60027d79519f?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1635445818409-64a0ff92eb39?w=1200&h=400&fit=crop'
WHERE slug = 'palm-beach-window-masters';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1742353980377-b8e42932c590?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1605702755163-4f303492e55f?w=1200&h=400&fit=crop'
WHERE slug = 'fort-lauderdale-pool-care';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1504297050568-910d24c426d3?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1622127148478-d5bcca029d56?w=1200&h=400&fit=crop'
WHERE slug = 'jacksonville-janitorial';

-- CA cleaners (11-18)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1647381518264-97ff1835026f?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1554995207-c18c203602cb?w=1200&h=400&fit=crop'
WHERE slug = 'la-pristine-cleaning';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1713110824336-f78c320dcf8e?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1550963295-019d8a8a61c5?w=1200&h=400&fit=crop'
WHERE slug = 'bay-area-eco-clean';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1675756544970-968f9e3f7ca5?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?w=1200&h=400&fit=crop'
WHERE slug = 'socal-carpet-tile';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1595332997730-1cc9c994f652?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1644338784985-d14b4031022a?w=1200&h=400&fit=crop'
WHERE slug = 'golden-state-window-cleaning';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1581578949510-fa7315c4c350?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1541123437800-1bb1317badc2?w=1200&h=400&fit=crop'
WHERE slug = 'sacramento-move-clean';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1557777948-261e80e1abc7?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1718220216044-006f43e3a9b1?w=1200&h=400&fit=crop'
WHERE slug = 'san-diego-office-clean';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1528740561666-dc2479dc08ab?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1583847268964-b28dc8f51f92?w=1200&h=400&fit=crop'
WHERE slug = 'malibu-vacation-clean';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1524758631624-e2822e304c36?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1618506487216-4e8c60a64c73?w=1200&h=400&fit=crop'
WHERE slug = 'silicon-valley-janitorial';

-- TX cleaners (19-26)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1601160458000-2b11f9fa1a0e?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1740657254989-42fe9c3b8cce?w=1200&h=400&fit=crop'
WHERE slug = 'houston-house-helpers';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1642505172378-a6f5e5b15580?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1627905646269-7f034dcc5738?w=1200&h=400&fit=crop'
WHERE slug = 'dallas-deep-clean-crew';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1669101602108-fa5ba89507ee?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1669101602124-f5b78895d91c?w=1200&h=400&fit=crop'
WHERE slug = 'austin-eco-maids';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1718152521147-817b3a991291?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1718152422704-bd21030a1a99?w=1200&h=400&fit=crop'
WHERE slug = 'san-antonio-pressure-pros';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1495576775051-8af0d10f19b1?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1622126977176-bf029dbf6ed0?w=1200&h=400&fit=crop'
WHERE slug = 'dfw-commercial-services';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1603712725038-e9334ae8f39f?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1580256081112-e49377338b7f?w=1200&h=400&fit=crop'
WHERE slug = 'texas-air-duct-specialists';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1556911220-bff31c812dba?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1597962261938-8714a29fa42c?w=1200&h=400&fit=crop'
WHERE slug = 'houston-restaurant-cleaning';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1686178827149-6d55c72d81df?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1534350752840-1b1b71b4b4fe?w=1200&h=400&fit=crop'
WHERE slug = 'fort-worth-post-construction';

-- NY cleaners (27-33)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1527515673510-8aa78ce21f9b?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1556037843-347ddff9f4b0?w=1200&h=400&fit=crop'
WHERE slug = 'nyc-spotless-cleaning';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1565538810643-b5bdb714032a?w=1200&h=400&fit=crop'
WHERE slug = 'manhattan-maid-co';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1594040226829-7f251ab46d80?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1534889156217-d643df14f14a?w=1200&h=400&fit=crop'
WHERE slug = 'brooklyn-carpet-care';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1729101223734-0b960896644b?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1512479373983-bd28a541041b?w=1200&h=400&fit=crop'
WHERE slug = 'empire-window-cleaning';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1431540015161-0bf868a2d407?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1621953703922-8146d7127225?w=1200&h=400&fit=crop'
WHERE slug = 'queens-office-maintenance';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1534350752840-1b1b71b4b4fe?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=1200&h=400&fit=crop'
WHERE slug = 'bronx-medical-clean';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1766650424976-55949041ac85?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1544002177-59a0208c2d4d?w=1200&h=400&fit=crop'
WHERE slug = 'long-island-pool-patio';

-- IL cleaners (34-38)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1609741893026-6177a6c4ecc7?w=1200&h=400&fit=crop'
WHERE slug = 'chicago-clean-team';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1594286851359-8e5a51b36bba?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1600166898405-da9535204843?w=1200&h=400&fit=crop'
WHERE slug = 'windy-city-upholstery';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1598928473162-0316ade00bbe?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1567767326925-e2047bf469d0?w=1200&h=400&fit=crop'
WHERE slug = 'springfield-tile-masters';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1518455027359-f3f8164ba6bd?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1540821924489-7690c70c4eac?w=1200&h=400&fit=crop'
WHERE slug = 'illinois-air-quality-pros';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1556910638-6cdac31d44dc?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1593136573819-c47d148ab626?w=1200&h=400&fit=crop'
WHERE slug = 'chicago-restaurant-cleaners';

-- GA cleaners (39-42)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1610276173132-c47d148ab626?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1609741891824-2acea53d6676?w=1200&h=400&fit=crop'
WHERE slug = 'atlanta-fresh-cleaning';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1581883579507-019c44b711cb?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1593260654732-df52bea15d63?w=1200&h=400&fit=crop'
WHERE slug = 'peach-state-pressure-wash';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1511362328651-90cc517fbe31?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=1200&h=400&fit=crop'
WHERE slug = 'georgia-medical-sanitizers';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1551232864-3cc1129163dc?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1546532706-6cbd7895080c?w=1200&h=400&fit=crop'
WHERE slug = 'savannah-vacation-turnover';

-- AZ cleaners (43-46)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1556037843-347ddff9f4b0?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1598928473162-0316ade00bbe?w=1200&h=400&fit=crop'
WHERE slug = 'phoenix-tile-grout-pros';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1742483359033-13315b247c74?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1504151864552-57020b6b876b?w=1200&h=400&fit=crop'
WHERE slug = 'scottsdale-hoarding-help';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1758530274187-e0f5f22a9846?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1763023852165-4fae245043dc?w=1200&h=400&fit=crop'
WHERE slug = 'tucson-pool-cleaning';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1607113364993-4f639eb54ebb?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1616804087352-0d82fc0c37bf?w=1200&h=400&fit=crop'
WHERE slug = 'arizona-desert-clean';

-- CO cleaners (47-50)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1556911220-bff31c812dba?w=1200&h=400&fit=crop'
WHERE slug = 'denver-green-maids';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1550963295-019d8a8a61c5?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1713110824336-f78c320dcf8e?w=1200&h=400&fit=crop'
WHERE slug = 'boulder-eco-clean';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1622127148478-d5bcca029d56?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1556761175-4b46a572b786?w=1200&h=400&fit=crop'
WHERE slug = 'colorado-springs-office-pro';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1681395565141-7fef718af7e0?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1565538810643-b5bdb714032a?w=1200&h=400&fit=crop'
WHERE slug = 'aspen-vacation-clean';

-- WA cleaners (51-53)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1669101602108-fa5ba89507ee?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1484154218962-a197022b5858?w=1200&h=400&fit=crop'
WHERE slug = 'seattle-clean-scene';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1592365559101-19adfefdf294?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1718152423221-0c72ba1a2ee4?w=1200&h=400&fit=crop'
WHERE slug = 'tacoma-industrial-clean';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1597962261938-8714a29fa42c?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=1200&h=400&fit=crop'
WHERE slug = 'olympia-restaurant-sanitizers';

-- NV cleaners (54-56)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1551232864-3cc1129163dc?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1609741893026-6177a6c4ecc7?w=1200&h=400&fit=crop'
WHERE slug = 'las-vegas-strip-clean';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1580256081112-e49377338b7f?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1518455027359-f3f8164ba6bd?w=1200&h=400&fit=crop'
WHERE slug = 'reno-air-duct-clean';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1511362328651-90cc517fbe31?w=1200&h=400&fit=crop'
WHERE slug = 'vegas-medical-clean-pro';

-- NC cleaners (57-58)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1628177142898-93e36e4e3a50?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1552321554-5fefe8c9ef14?w=1200&h=400&fit=crop'
WHERE slug = 'charlotte-move-clean-pro';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1504151864552-57020b6b876b?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1742483359033-13315b247c74?w=1200&h=400&fit=crop'
WHERE slug = 'raleigh-hoarding-solutions';

-- NJ cleaners (59-60)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1644338785159-6c0a9dd037b2?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1743614675019-6878e5ce76df?w=1200&h=400&fit=crop'
WHERE slug = 'jersey-shore-window-clean';

UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1718152422485-f2d62ea3f5a8?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1718152521364-b9655b8a7926?w=1200&h=400&fit=crop'
WHERE slug = 'newark-warehouse-clean';

-- ============================================================
-- PORTFOLIO PHOTOS (3 per cleaner in cleaner_photos table)
-- ============================================================

TRUNCATE TABLE `cleaner_photos`;

INSERT INTO `cleaner_photos` (`cleaner_id`, `url`, `caption`, `sort_order`) VALUES
-- Cleaner 1 - House Cleaning
(1, 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=800&h=600&fit=crop', 'Spotless living room after deep clean', 1),
(1, 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=800&h=600&fit=crop', 'Kitchen counters gleaming', 2),
(1, 'https://images.unsplash.com/photo-1552321554-5fefe8c9ef14?w=800&h=600&fit=crop', 'Fresh and clean bathroom', 3),
-- Cleaner 2
(2, 'https://images.unsplash.com/photo-1585421514284-efb74c2b69ba?w=800&h=600&fit=crop', 'Move-out cleaning complete', 1),
(2, 'https://images.unsplash.com/photo-1556911220-bff31c812dba?w=800&h=600&fit=crop', 'Kitchen deep clean', 2),
(2, 'https://images.unsplash.com/photo-1609741893026-6177a6c4ecc7?w=800&h=600&fit=crop', 'Modern kitchen sparkling clean', 3),
-- Cleaner 3
(3, 'https://images.unsplash.com/photo-1628177142898-93e36e4e3a50?w=800&h=600&fit=crop', 'Eco-friendly products we use', 1),
(3, 'https://images.unsplash.com/photo-1502005097973-6a7082348e28?w=800&h=600&fit=crop', 'Clean and fresh living space', 2),
(3, 'https://images.unsplash.com/photo-1484154218962-a197022b5858?w=800&h=600&fit=crop', 'Beautiful clean kitchen', 3),
-- Cleaner 4
(4, 'https://images.unsplash.com/photo-1563453392212-326f5e854473?w=800&h=600&fit=crop', 'Deep cleaning in progress', 1),
(4, 'https://images.unsplash.com/photo-1646980241033-cd7abda2ee88?w=800&h=600&fit=crop', 'Bathroom sanitization', 2),
(4, 'https://images.unsplash.com/photo-1565538810643-b5bdb714032a?w=800&h=600&fit=crop', 'Bedroom cleaning completed', 3),
-- Cleaner 5 - Commercial
(5, 'https://images.unsplash.com/photo-1556761175-4b46a572b786?w=800&h=600&fit=crop', 'Office space after cleaning', 1),
(5, 'https://images.unsplash.com/photo-1533090161767-e6ffed986c88?w=800&h=600&fit=crop', 'Clean commercial lobby', 2),
(5, 'https://images.unsplash.com/photo-1622127148478-d5bcca029d56?w=800&h=600&fit=crop', 'Conference room cleaning', 3),
-- Cleaner 6 - Carpet
(6, 'https://images.unsplash.com/photo-1549637642-90187f64f420?w=800&h=600&fit=crop', 'Steam carpet cleaning', 1),
(6, 'https://images.unsplash.com/photo-1597665863042-47e00964d899?w=800&h=600&fit=crop', 'Professional carpet care', 2),
(6, 'https://images.unsplash.com/photo-1594040226829-7f251ab46d80?w=800&h=600&fit=crop', 'Before and after carpet clean', 3),
-- Cleaner 7 - Pressure Washing
(7, 'https://images.unsplash.com/photo-1718152470408-cfeebeb6b9fc?w=800&h=600&fit=crop', 'Driveway pressure washing', 1),
(7, 'https://images.unsplash.com/photo-1718152423985-2d7909a96fa1?w=800&h=600&fit=crop', 'Commercial exterior cleaning', 2),
(7, 'https://images.unsplash.com/photo-1593260654732-df52bea15d63?w=800&h=600&fit=crop', 'Sidewalk power washing', 3),
-- Cleaner 8 - Window
(8, 'https://images.unsplash.com/photo-1651481127251-60027d79519f?w=800&h=600&fit=crop', 'Window cleaning in progress', 1),
(8, 'https://images.unsplash.com/photo-1635445818409-64a0ff92eb39?w=800&h=600&fit=crop', 'Crystal clear windows', 2),
(8, 'https://images.unsplash.com/photo-1595332997730-1cc9c994f652?w=800&h=600&fit=crop', 'Streak-free results', 3),
-- Cleaner 9 - Pool
(9, 'https://images.unsplash.com/photo-1742353980377-b8e42932c590?w=800&h=600&fit=crop', 'Crystal clear pool water', 1),
(9, 'https://images.unsplash.com/photo-1605702755163-4f303492e55f?w=800&h=600&fit=crop', 'Pool maintenance service', 2),
(9, 'https://images.unsplash.com/photo-1544002177-59a0208c2d4d?w=800&h=600&fit=crop', 'Sparkling clean pool', 3),
-- Cleaner 10 - Janitorial
(10, 'https://images.unsplash.com/photo-1504297050568-910d24c426d3?w=800&h=600&fit=crop', 'Office janitorial service', 1),
(10, 'https://images.unsplash.com/photo-1431540015161-0bf868a2d407?w=800&h=600&fit=crop', 'Floor polishing', 2),
(10, 'https://images.unsplash.com/photo-1621953703922-8146d7127225?w=800&h=600&fit=crop', 'Restroom sanitization', 3),
-- Cleaner 11 - LA House
(11, 'https://images.unsplash.com/photo-1647381518264-97ff1835026f?w=800&h=600&fit=crop', 'Luxury home cleaning', 1),
(11, 'https://images.unsplash.com/photo-1554995207-c18c203602cb?w=800&h=600&fit=crop', 'Designer kitchen clean', 2),
(11, 'https://images.unsplash.com/photo-1556911220-bff31c812dba?w=800&h=600&fit=crop', 'Modern kitchen spotless', 3),
-- Cleaner 12 - Eco Clean
(12, 'https://images.unsplash.com/photo-1713110824336-f78c320dcf8e?w=800&h=600&fit=crop', 'Green cleaning products', 1),
(12, 'https://images.unsplash.com/photo-1550963295-019d8a8a61c5?w=800&h=600&fit=crop', 'Eco-friendly home clean', 2),
(12, 'https://images.unsplash.com/photo-1628177142898-93e36e4e3a50?w=800&h=600&fit=crop', 'Plant-based supplies', 3),
-- Cleaner 13 - Carpet & Tile CA
(13, 'https://images.unsplash.com/photo-1675756544970-968f9e3f7ca5?w=800&h=600&fit=crop', 'Carpet deep extraction', 1),
(13, 'https://images.unsplash.com/photo-1598928473162-0316ade00bbe?w=800&h=600&fit=crop', 'Tile restoration work', 2),
(13, 'https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?w=800&h=600&fit=crop', 'Grout cleaning results', 3),
-- Cleaner 14 - Window CA
(14, 'https://images.unsplash.com/photo-1595332997730-1cc9c994f652?w=800&h=600&fit=crop', 'High-rise window cleaning', 1),
(14, 'https://images.unsplash.com/photo-1644338784985-d14b4031022a?w=800&h=600&fit=crop', 'Commercial windows', 2),
(14, 'https://images.unsplash.com/photo-1512479373983-bd28a541041b?w=800&h=600&fit=crop', 'Storefront window shine', 3),
-- Cleaner 15 - Move Clean CA
(15, 'https://images.unsplash.com/photo-1581578949510-fa7315c4c350?w=800&h=600&fit=crop', 'Move-out deep clean', 1),
(15, 'https://images.unsplash.com/photo-1541123437800-1bb1317badc2?w=800&h=600&fit=crop', 'Empty apartment spotless', 2),
(15, 'https://images.unsplash.com/photo-1552321554-5fefe8c9ef14?w=800&h=600&fit=crop', 'Bathroom sparkling clean', 3),
-- Cleaner 16 - Office CA
(16, 'https://images.unsplash.com/photo-1557777948-261e80e1abc7?w=800&h=600&fit=crop', 'Office deep cleaning', 1),
(16, 'https://images.unsplash.com/photo-1718220216044-006f43e3a9b1?w=800&h=600&fit=crop', 'Workspace maintenance', 2),
(16, 'https://images.unsplash.com/photo-1495576775051-8af0d10f19b1?w=800&h=600&fit=crop', 'Meeting room ready', 3),
-- Cleaner 17 - Vacation CA
(17, 'https://images.unsplash.com/photo-1528740561666-dc2479dc08ab?w=800&h=600&fit=crop', 'Vacation rental turnover', 1),
(17, 'https://images.unsplash.com/photo-1583847268964-b28dc8f51f92?w=800&h=600&fit=crop', 'Guest-ready bedroom', 2),
(17, 'https://images.unsplash.com/photo-1551232864-3cc1129163dc?w=800&h=600&fit=crop', 'Airbnb cleaning complete', 3),
-- Cleaner 18 - Janitorial CA
(18, 'https://images.unsplash.com/photo-1524758631624-e2822e304c36?w=800&h=600&fit=crop', 'Tech office cleaning', 1),
(18, 'https://images.unsplash.com/photo-1618506487216-4e8c60a64c73?w=800&h=600&fit=crop', 'Startup workspace clean', 2),
(18, 'https://images.unsplash.com/photo-1556761175-4b46a572b786?w=800&h=600&fit=crop', 'After-hours janitorial', 3),
-- Cleaner 19 - House TX
(19, 'https://images.unsplash.com/photo-1601160458000-2b11f9fa1a0e?w=800&h=600&fit=crop', 'House cleaning in Houston', 1),
(19, 'https://images.unsplash.com/photo-1740657254989-42fe9c3b8cce?w=800&h=600&fit=crop', 'Living room refreshed', 2),
(19, 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=800&h=600&fit=crop', 'Kitchen sanitized', 3),
-- Cleaner 20 - Deep Clean TX
(20, 'https://images.unsplash.com/photo-1642505172378-a6f5e5b15580?w=800&h=600&fit=crop', 'Intensive deep clean', 1),
(20, 'https://images.unsplash.com/photo-1627905646269-7f034dcc5738?w=800&h=600&fit=crop', 'Behind appliance cleaning', 2),
(20, 'https://images.unsplash.com/photo-1563453392212-326f5e854473?w=800&h=600&fit=crop', 'Baseboard detailing', 3),
-- Cleaner 21 - Eco TX
(21, 'https://images.unsplash.com/photo-1669101602108-fa5ba89507ee?w=800&h=600&fit=crop', 'Eco-friendly products', 1),
(21, 'https://images.unsplash.com/photo-1669101602124-f5b78895d91c?w=800&h=600&fit=crop', 'Green cleaning service', 2),
(21, 'https://images.unsplash.com/photo-1550963295-019d8a8a61c5?w=800&h=600&fit=crop', 'Pet-safe cleaning', 3),
-- Cleaner 22 - Pressure TX
(22, 'https://images.unsplash.com/photo-1718152521147-817b3a991291?w=800&h=600&fit=crop', 'Driveway power washing', 1),
(22, 'https://images.unsplash.com/photo-1718152422704-bd21030a1a99?w=800&h=600&fit=crop', 'Commercial pressure clean', 2),
(22, 'https://images.unsplash.com/photo-1581883579507-019c44b711cb?w=800&h=600&fit=crop', 'Concrete cleaning', 3),
-- Cleaner 23 - Commercial TX
(23, 'https://images.unsplash.com/photo-1495576775051-8af0d10f19b1?w=800&h=600&fit=crop', 'DFW office complex clean', 1),
(23, 'https://images.unsplash.com/photo-1622126977176-bf029dbf6ed0?w=800&h=600&fit=crop', 'Warehouse floor care', 2),
(23, 'https://images.unsplash.com/photo-1431540015161-0bf868a2d407?w=800&h=600&fit=crop', 'Commercial restrooms', 3),
-- Cleaner 24 - Air Duct TX
(24, 'https://images.unsplash.com/photo-1603712725038-e9334ae8f39f?w=800&h=600&fit=crop', 'HVAC duct cleaning', 1),
(24, 'https://images.unsplash.com/photo-1580256081112-e49377338b7f?w=800&h=600&fit=crop', 'Dryer vent service', 2),
(24, 'https://images.unsplash.com/photo-1518455027359-f3f8164ba6bd?w=800&h=600&fit=crop', 'Indoor air quality', 3),
-- Cleaner 25 - Restaurant TX
(25, 'https://images.unsplash.com/photo-1556911220-bff31c812dba?w=800&h=600&fit=crop', 'Restaurant kitchen clean', 1),
(25, 'https://images.unsplash.com/photo-1597962261938-8714a29fa42c?w=800&h=600&fit=crop', 'Hood vent degreasing', 2),
(25, 'https://images.unsplash.com/photo-1593136573819-c47d148ab626?w=800&h=600&fit=crop', 'Equipment sanitization', 3),
-- Cleaner 26 - Post-Construction TX
(26, 'https://images.unsplash.com/photo-1686178827149-6d55c72d81df?w=800&h=600&fit=crop', 'Construction cleanup', 1),
(26, 'https://images.unsplash.com/photo-1534350752840-1b1b71b4b4fe?w=800&h=600&fit=crop', 'Dust and debris removal', 2),
(26, 'https://images.unsplash.com/photo-1607113364993-4f639eb54ebb?w=800&h=600&fit=crop', 'Final detail clean', 3),
-- Cleaner 27 - NYC House
(27, 'https://images.unsplash.com/photo-1527515673510-8aa78ce21f9b?w=800&h=600&fit=crop', 'Manhattan apartment clean', 1),
(27, 'https://images.unsplash.com/photo-1556037843-347ddff9f4b0?w=800&h=600&fit=crop', 'NYC penthouse service', 2),
(27, 'https://images.unsplash.com/photo-1609741893026-6177a6c4ecc7?w=800&h=600&fit=crop', 'Luxury kitchen cleaning', 3),
-- Cleaner 28 - Move NYC
(28, 'https://images.unsplash.com/photo-1585421514284-efb74c2b69ba?w=800&h=600&fit=crop', 'Move-out apartment clean', 1),
(28, 'https://images.unsplash.com/photo-1541123437800-1bb1317badc2?w=800&h=600&fit=crop', 'Inspection-ready home', 2),
(28, 'https://images.unsplash.com/photo-1565538810643-b5bdb714032a?w=800&h=600&fit=crop', 'Bedroom deep clean', 3),
-- Cleaner 29 - Carpet NY
(29, 'https://images.unsplash.com/photo-1594040226829-7f251ab46d80?w=800&h=600&fit=crop', 'Brooklyn carpet steam clean', 1),
(29, 'https://images.unsplash.com/photo-1534889156217-d643df14f14a?w=800&h=600&fit=crop', 'Rug cleaning service', 2),
(29, 'https://images.unsplash.com/photo-1594286851359-8e5a51b36bba?w=800&h=600&fit=crop', 'Upholstery restoration', 3),
-- Cleaner 30 - Window NY
(30, 'https://images.unsplash.com/photo-1729101223734-0b960896644b?w=800&h=600&fit=crop', 'High-rise window service', 1),
(30, 'https://images.unsplash.com/photo-1512479373983-bd28a541041b?w=800&h=600&fit=crop', 'Commercial building windows', 2),
(30, 'https://images.unsplash.com/photo-1644338785159-6c0a9dd037b2?w=800&h=600&fit=crop', 'Streak-free glass', 3),
-- Cleaner 31 - Office NY
(31, 'https://images.unsplash.com/photo-1431540015161-0bf868a2d407?w=800&h=600&fit=crop', 'Queens office cleaning', 1),
(31, 'https://images.unsplash.com/photo-1621953703922-8146d7127225?w=800&h=600&fit=crop', 'Workspace sanitization', 2),
(31, 'https://images.unsplash.com/photo-1557777948-261e80e1abc7?w=800&h=600&fit=crop', 'Meeting room ready', 3),
-- Cleaner 32 - Medical NY
(32, 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=800&h=600&fit=crop', 'Medical facility cleaning', 1),
(32, 'https://images.unsplash.com/photo-1511362328651-90cc517fbe31?w=800&h=600&fit=crop', 'Clinic sanitization', 2),
(32, 'https://images.unsplash.com/photo-1534350752840-1b1b71b4b4fe?w=800&h=600&fit=crop', 'Healthcare-grade disinfection', 3),
-- Cleaner 33 - Pool NY
(33, 'https://images.unsplash.com/photo-1766650424976-55949041ac85?w=800&h=600&fit=crop', 'Pool maintenance service', 1),
(33, 'https://images.unsplash.com/photo-1544002177-59a0208c2d4d?w=800&h=600&fit=crop', 'Sparkling pool water', 2),
(33, 'https://images.unsplash.com/photo-1770967307107-446055488c0d?w=800&h=600&fit=crop', 'Patio pressure washing', 3),
-- Cleaner 34 - House IL
(34, 'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=800&h=600&fit=crop', 'Chicago home cleaning', 1),
(34, 'https://images.unsplash.com/photo-1609741893026-6177a6c4ecc7?w=800&h=600&fit=crop', 'Kitchen deep clean', 2),
(34, 'https://images.unsplash.com/photo-1567767326925-e2047bf469d0?w=800&h=600&fit=crop', 'Bathroom refresh', 3),
-- Cleaner 35 - Upholstery IL
(35, 'https://images.unsplash.com/photo-1594286851359-8e5a51b36bba?w=800&h=600&fit=crop', 'Sofa steam cleaning', 1),
(35, 'https://images.unsplash.com/photo-1600166898405-da9535204843?w=800&h=600&fit=crop', 'Furniture restoration', 2),
(35, 'https://images.unsplash.com/photo-1549637642-90187f64f420?w=800&h=600&fit=crop', 'Mattress sanitization', 3),
-- Cleaner 36 - Tile IL
(36, 'https://images.unsplash.com/photo-1598928473162-0316ade00bbe?w=800&h=600&fit=crop', 'Tile grout cleaning', 1),
(36, 'https://images.unsplash.com/photo-1567767326925-e2047bf469d0?w=800&h=600&fit=crop', 'Shower restoration', 2),
(36, 'https://images.unsplash.com/photo-1556910638-6cdac31d44dc?w=800&h=600&fit=crop', 'Floor tile polishing', 3),
-- Cleaner 37 - Air Duct IL
(37, 'https://images.unsplash.com/photo-1518455027359-f3f8164ba6bd?w=800&h=600&fit=crop', 'Duct cleaning equipment', 1),
(37, 'https://images.unsplash.com/photo-1540821924489-7690c70c4eac?w=800&h=600&fit=crop', 'HVAC system cleaning', 2),
(37, 'https://images.unsplash.com/photo-1603712725038-e9334ae8f39f?w=800&h=600&fit=crop', 'Air quality improvement', 3),
-- Cleaner 38 - Restaurant IL
(38, 'https://images.unsplash.com/photo-1556910638-6cdac31d44dc?w=800&h=600&fit=crop', 'Commercial kitchen clean', 1),
(38, 'https://images.unsplash.com/photo-1593136573819-c47d148ab626?w=800&h=600&fit=crop', 'Floor degreasing', 2),
(38, 'https://images.unsplash.com/photo-1597962261938-8714a29fa42c?w=800&h=600&fit=crop', 'Restaurant sanitization', 3),
-- Cleaner 39 - House GA
(39, 'https://images.unsplash.com/photo-1610276173132-c47d148ab626?w=800&h=600&fit=crop', 'Atlanta home clean', 1),
(39, 'https://images.unsplash.com/photo-1609741891824-2acea53d6676?w=800&h=600&fit=crop', 'Fresh living space', 2),
(39, 'https://images.unsplash.com/photo-1556911220-bff31c812dba?w=800&h=600&fit=crop', 'Kitchen counters clean', 3),
-- Cleaner 40 - Pressure GA
(40, 'https://images.unsplash.com/photo-1581883579507-019c44b711cb?w=800&h=600&fit=crop', 'Building exterior wash', 1),
(40, 'https://images.unsplash.com/photo-1593260654732-df52bea15d63?w=800&h=600&fit=crop', 'Deck restoration', 2),
(40, 'https://images.unsplash.com/photo-1616804087352-0d82fc0c37bf?w=800&h=600&fit=crop', 'Concrete power wash', 3),
-- Cleaner 41 - Medical GA
(41, 'https://images.unsplash.com/photo-1511362328651-90cc517fbe31?w=800&h=600&fit=crop', 'Clinic cleaning service', 1),
(41, 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=800&h=600&fit=crop', 'Medical office sanitization', 2),
(41, 'https://images.unsplash.com/photo-1534350752840-1b1b71b4b4fe?w=800&h=600&fit=crop', 'Healthcare disinfection', 3),
-- Cleaner 42 - Vacation GA
(42, 'https://images.unsplash.com/photo-1551232864-3cc1129163dc?w=800&h=600&fit=crop', 'Vacation rental ready', 1),
(42, 'https://images.unsplash.com/photo-1546532706-6cbd7895080c?w=800&h=600&fit=crop', 'Guest bedroom turnover', 2),
(42, 'https://images.unsplash.com/photo-1528740561666-dc2479dc08ab?w=800&h=600&fit=crop', 'Property inspection', 3),
-- Cleaner 43 - Tile AZ
(43, 'https://images.unsplash.com/photo-1556037843-347ddff9f4b0?w=800&h=600&fit=crop', 'Tile restoration work', 1),
(43, 'https://images.unsplash.com/photo-1598928473162-0316ade00bbe?w=800&h=600&fit=crop', 'Grout color sealing', 2),
(43, 'https://images.unsplash.com/photo-1567767326925-e2047bf469d0?w=800&h=600&fit=crop', 'Bathroom tile cleaning', 3),
-- Cleaner 44 - Hoarding AZ
(44, 'https://images.unsplash.com/photo-1742483359033-13315b247c74?w=800&h=600&fit=crop', 'Cleanout service', 1),
(44, 'https://images.unsplash.com/photo-1504151864552-57020b6b876b?w=800&h=600&fit=crop', 'Property restoration', 2),
(44, 'https://images.unsplash.com/photo-1686178827149-6d55c72d81df?w=800&h=600&fit=crop', 'Deep sanitization', 3),
-- Cleaner 45 - Pool AZ
(45, 'https://images.unsplash.com/photo-1758530274187-e0f5f22a9846?w=800&h=600&fit=crop', 'Arizona pool cleaning', 1),
(45, 'https://images.unsplash.com/photo-1763023852165-4fae245043dc?w=800&h=600&fit=crop', 'Chemical balancing', 2),
(45, 'https://images.unsplash.com/photo-1605702755163-4f303492e55f?w=800&h=600&fit=crop', 'Pool equipment care', 3),
-- Cleaner 46 - Hoarding/Construction AZ
(46, 'https://images.unsplash.com/photo-1607113364993-4f639eb54ebb?w=800&h=600&fit=crop', 'Post-renovation cleanup', 1),
(46, 'https://images.unsplash.com/photo-1616804087352-0d82fc0c37bf?w=800&h=600&fit=crop', 'Hazmat cleanup', 2),
(46, 'https://images.unsplash.com/photo-1592365559101-19adfefdf294?w=800&h=600&fit=crop', 'Property restoration', 3),
-- Cleaner 47 - Green CO
(47, 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=800&h=600&fit=crop', 'Eco home cleaning', 1),
(47, 'https://images.unsplash.com/photo-1556911220-bff31c812dba?w=800&h=600&fit=crop', 'Green kitchen clean', 2),
(47, 'https://images.unsplash.com/photo-1628177142898-93e36e4e3a50?w=800&h=600&fit=crop', 'Plant-based products', 3),
-- Cleaner 48 - Eco CO
(48, 'https://images.unsplash.com/photo-1550963295-019d8a8a61c5?w=800&h=600&fit=crop', 'Sustainable cleaning', 1),
(48, 'https://images.unsplash.com/photo-1713110824336-f78c320dcf8e?w=800&h=600&fit=crop', 'Zero-waste products', 2),
(48, 'https://images.unsplash.com/photo-1669101602108-fa5ba89507ee?w=800&h=600&fit=crop', 'Biodegradable supplies', 3),
-- Cleaner 49 - Office CO
(49, 'https://images.unsplash.com/photo-1622127148478-d5bcca029d56?w=800&h=600&fit=crop', 'Office building clean', 1),
(49, 'https://images.unsplash.com/photo-1556761175-4b46a572b786?w=800&h=600&fit=crop', 'Workspace maintenance', 2),
(49, 'https://images.unsplash.com/photo-1524758631624-e2822e304c36?w=800&h=600&fit=crop', 'Conference room ready', 3),
-- Cleaner 50 - Vacation CO
(50, 'https://images.unsplash.com/photo-1681395565141-7fef718af7e0?w=800&h=600&fit=crop', 'Ski lodge turnover', 1),
(50, 'https://images.unsplash.com/photo-1565538810643-b5bdb714032a?w=800&h=600&fit=crop', 'Luxury rental clean', 2),
(50, 'https://images.unsplash.com/photo-1551232864-3cc1129163dc?w=800&h=600&fit=crop', 'Guest-ready property', 3),
-- Cleaner 51 - House WA
(51, 'https://images.unsplash.com/photo-1484154218962-a197022b5858?w=800&h=600&fit=crop', 'Seattle home cleaning', 1),
(51, 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=800&h=600&fit=crop', 'Living room refresh', 2),
(51, 'https://images.unsplash.com/photo-1609741891824-2acea53d6676?w=800&h=600&fit=crop', 'Kitchen sanitization', 3),
-- Cleaner 52 - Warehouse WA
(52, 'https://images.unsplash.com/photo-1592365559101-19adfefdf294?w=800&h=600&fit=crop', 'Industrial floor care', 1),
(52, 'https://images.unsplash.com/photo-1718152423221-0c72ba1a2ee4?w=800&h=600&fit=crop', 'Warehouse cleaning', 2),
(52, 'https://images.unsplash.com/photo-1718152521147-817b3a991291?w=800&h=600&fit=crop', 'Loading dock wash', 3),
-- Cleaner 53 - Restaurant WA
(53, 'https://images.unsplash.com/photo-1597962261938-8714a29fa42c?w=800&h=600&fit=crop', 'Kitchen deep clean', 1),
(53, 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=800&h=600&fit=crop', 'Medical-grade sanitization', 2),
(53, 'https://images.unsplash.com/photo-1556910638-6cdac31d44dc?w=800&h=600&fit=crop', 'Food service cleaning', 3),
-- Cleaner 54 - Vacation NV
(54, 'https://images.unsplash.com/photo-1551232864-3cc1129163dc?w=800&h=600&fit=crop', 'Vegas rental turnover', 1),
(54, 'https://images.unsplash.com/photo-1609741893026-6177a6c4ecc7?w=800&h=600&fit=crop', 'Condo-hotel cleaning', 2),
(54, 'https://images.unsplash.com/photo-1593136573819-c47d148ab626?w=800&h=600&fit=crop', 'Strip restaurant clean', 3),
-- Cleaner 55 - Air Duct NV
(55, 'https://images.unsplash.com/photo-1580256081112-e49377338b7f?w=800&h=600&fit=crop', 'Duct cleaning service', 1),
(55, 'https://images.unsplash.com/photo-1518455027359-f3f8164ba6bd?w=800&h=600&fit=crop', 'Vent cleaning process', 2),
(55, 'https://images.unsplash.com/photo-1594286851359-8e5a51b36bba?w=800&h=600&fit=crop', 'Upholstery care', 3),
-- Cleaner 56 - Medical NV
(56, 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=800&h=600&fit=crop', 'Medical office clean', 1),
(56, 'https://images.unsplash.com/photo-1511362328651-90cc517fbe31?w=800&h=600&fit=crop', 'Dental practice sanitization', 2),
(56, 'https://images.unsplash.com/photo-1534350752840-1b1b71b4b4fe?w=800&h=600&fit=crop', 'Hospital-grade service', 3),
-- Cleaner 57 - Move NC
(57, 'https://images.unsplash.com/photo-1628177142898-93e36e4e3a50?w=800&h=600&fit=crop', 'Move-in clean service', 1),
(57, 'https://images.unsplash.com/photo-1552321554-5fefe8c9ef14?w=800&h=600&fit=crop', 'Bathroom deep scrub', 2),
(57, 'https://images.unsplash.com/photo-1585421514284-efb74c2b69ba?w=800&h=600&fit=crop', 'Appliance cleaning', 3),
-- Cleaner 58 - Hoarding NC
(58, 'https://images.unsplash.com/photo-1504151864552-57020b6b876b?w=800&h=600&fit=crop', 'Compassionate cleanout', 1),
(58, 'https://images.unsplash.com/photo-1742483359033-13315b247c74?w=800&h=600&fit=crop', 'Estate cleanup', 2),
(58, 'https://images.unsplash.com/photo-1686178827149-6d55c72d81df?w=800&h=600&fit=crop', 'Deep sanitization', 3),
-- Cleaner 59 - Window NJ
(59, 'https://images.unsplash.com/photo-1644338785159-6c0a9dd037b2?w=800&h=600&fit=crop', 'Oceanfront window cleaning', 1),
(59, 'https://images.unsplash.com/photo-1743614675019-6878e5ce76df?w=800&h=600&fit=crop', 'Storefront window care', 2),
(59, 'https://images.unsplash.com/photo-1718152470408-cfeebeb6b9fc?w=800&h=600&fit=crop', 'Pressure washing combo', 3),
-- Cleaner 60 - Warehouse NJ
(60, 'https://images.unsplash.com/photo-1718152422485-f2d62ea3f5a8?w=800&h=600&fit=crop', 'Warehouse floor scrubbing', 1),
(60, 'https://images.unsplash.com/photo-1718152521364-b9655b8a7926?w=800&h=600&fit=crop', 'Loading dock maintenance', 2),
(60, 'https://images.unsplash.com/photo-1622126977176-bf029dbf6ed0?w=800&h=600&fit=crop', 'Industrial janitorial', 3);
