-- ============================================================
-- seed_demo_images.sql
-- Add trade-specific Unsplash images to all demo cleaners
-- Logos (200x200), Cover images (1200x400), Portfolio photos (800x600)
-- All images served from Unsplash CDN - no files on our server
-- ============================================================

SET NAMES utf8mb4;

-- ============================================================
-- CLEANER LOGOS & COVER IMAGES
-- ============================================================

-- 1. Sunshine Roofing Co. (roofing, gutters)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1553169507-38833977274b?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1763665814965-b5c4b3547908?w=1200&h=400&fit=crop'
WHERE slug = 'sunshine-roofing-co';

-- 2. Metro Plumbing Solutions (plumbing)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1593276907429-22dcc91c368a?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1585406666850-82f7532fdae3?w=1200&h=400&fit=crop'
WHERE slug = 'metro-plumbing-solutions';

-- 3. Coastal Kitchen & Bath (bathroom, kitchen, home remodeling)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1760438492655-63efac635f61?w=1200&h=400&fit=crop'
WHERE slug = 'coastal-kitchen-and-bath';

-- 4. Florida Comfort HVAC (hvac)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1698479603408-1a66a6d9e80f?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1665826254141-bfa10685e002?w=1200&h=400&fit=crop'
WHERE slug = 'florida-comfort-hvac';

-- 5. Palm City Electrical (electrical)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1758101755915-462eddc23f57?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1467733238130-bb6846885316?w=1200&h=400&fit=crop'
WHERE slug = 'palm-city-electrical';

-- 6. Tampa Bay Bath Remodeling (bathroom, plumbing)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1762418362644-a4daad168fb9?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1758448018619-4cbe2250b9ad?w=1200&h=400&fit=crop'
WHERE slug = 'tampa-bay-bath-remodeling';

-- 7. First Coast General Contracting (general cleaner, home remodeling)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1692166567037-4009225486ac?w=1200&h=400&fit=crop'
WHERE slug = 'first-coast-general-contracting';

-- 8. Bay Area Roofing Pros (roofing, siding)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1681049400158-0ff6249ac315?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1744975748338-d226c7535d49?w=1200&h=400&fit=crop'
WHERE slug = 'bay-area-roofing-pros';

-- 9. Pacific Plumbing & Drain (bathroom, plumbing)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1577522892450-868e30731cee?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1763485956294-407e7388f63b?w=1200&h=400&fit=crop'
WHERE slug = 'pacific-plumbing-and-drain';

-- 10. SoCal Pro Painting (painting)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1573257318373-58d4f226e7f9?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1643804475756-ca849847c78a?w=1200&h=400&fit=crop'
WHERE slug = 'socal-pro-painting';

-- 11. Golden State HVAC (hvac, insulation)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1637327534911-ee8057d51aec?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1647022528152-52ed9338611d?w=1200&h=400&fit=crop'
WHERE slug = 'golden-state-hvac';

-- 12. LA Decks & Outdoor Living (decks, fencing)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1764061148640-f08811bf9e4d?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1766603636772-52b1273c655d?w=1200&h=400&fit=crop'
WHERE slug = 'la-decks-and-outdoor-living';

-- 13. SF Tile & Flooring (kitchen, flooring)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1650831341595-5408b892c486?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1617262869711-2f5006b61073?w=1200&h=400&fit=crop'
WHERE slug = 'sf-tile-and-flooring';

-- 14. Sacramento Fence & Gate (fencing)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1769831190663-95fe8454d8c9?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1759502141256-45d54807853b?w=1200&h=400&fit=crop'
WHERE slug = 'sacramento-fence-and-gate';

-- 15. Lone Star Roofing & Construction (roofing, general cleaner)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1632759145351-1d592919f522?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1628774942553-bd4b553e7457?w=1200&h=400&fit=crop'
WHERE slug = 'lone-star-roofing-and-construction';

-- 16. Texas Handyman Services (handyman)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1584677191047-38f48d0db64e?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1533780898421-b118c81ac26b?w=1200&h=400&fit=crop'
WHERE slug = 'texas-handyman-services';

-- 17. Dallas Kitchen Design Studio (kitchen, home remodeling)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1736390800504-d3963b553aa3?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1749704647283-3ad79f4acc6a?w=1200&h=400&fit=crop'
WHERE slug = 'dallas-kitchen-design-studio';

-- 18. Austin Home Renovations (general cleaner, home renovation)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1634586648651-f1fb9ec10d90?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1768321902290-54497eeb9cf6?w=1200&h=400&fit=crop'
WHERE slug = 'austin-home-renovations';

-- 19. SA Town Electric (electrical)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1612203264166-e00118d63b94?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1467733238130-bb6846885316?w=1200&h=400&fit=crop'
WHERE slug = 'sa-town-electric';

-- 20. Texas Concrete Works (concrete, decks)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1565077745796-e03908990c99?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1591188185682-41f5c74781f6?w=1200&h=400&fit=crop'
WHERE slug = 'texas-concrete-works';

-- 21. Houston Siding Experts (siding, gutters)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1628625251827-77fa98fb34fa?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1639084932127-8723db70834c?w=1200&h=400&fit=crop'
WHERE slug = 'houston-siding-experts';

-- 22. Empire State Roofing (roofing)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1627591637320-fcfe8c34b62d?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1683551739934-a25185351214?w=1200&h=400&fit=crop'
WHERE slug = 'empire-state-roofing';

-- 23. NYC Master Plumbing (bathroom, plumbing)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1650246363606-a2402ec42b08?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1761353855019-05f2f3ed9c43?w=1200&h=400&fit=crop'
WHERE slug = 'nyc-master-plumbing';

-- 24. Brooklyn Bath Design (bathroom, flooring)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1763485955425-a61e722832ca?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1768413292551-10011d6c354e?w=1200&h=400&fit=crop'
WHERE slug = 'brooklyn-bath-design';

-- 25. Buffalo Insulation Pros (insulation)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1628744448838-c04e09b1ba03?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1634231647709-06609f7dd3ca?w=1200&h=400&fit=crop'
WHERE slug = 'buffalo-insulation-pros';

-- 26. Rochester Pro Painting (handyman, painting)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1573257318373-58d4f226e7f9?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1758448511533-e1502259fff6?w=1200&h=400&fit=crop'
WHERE slug = 'rochester-pro-painting';

-- 27. Chicago Roofing Authority (roofing, siding, gutters)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1763665814965-b5c4b3547908?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1553169507-38833977274b?w=1200&h=400&fit=crop'
WHERE slug = 'chicago-roofing-authority';

-- 28. Windy City HVAC Services (hvac)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1695124348827-6b66b4771432?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1677326140858-47e96c706b4e?w=1200&h=400&fit=crop'
WHERE slug = 'windy-city-hvac-services';

-- 29. Chicagoland Flooring Co. (flooring)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1693948568453-a3564f179a84?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1622653416662-5a74e75717db?w=1200&h=400&fit=crop'
WHERE slug = 'chicagoland-flooring-co';

-- 30. Aurora Handyman Connection (handyman, painting)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1683115097173-f24516d000c6?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1731694411560-050e5b91e943?w=1200&h=400&fit=crop'
WHERE slug = 'aurora-handyman-connection';

-- 31. Peachtree Builders Group (general cleaner, home renovation)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1768321914537-4193b29eec13?w=1200&h=400&fit=crop'
WHERE slug = 'peachtree-builders-group';

-- 32. Atlanta Gutter Solutions (gutters)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1581374244633-1a564f179a84?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1628625251833-04eeafb7a2db?w=1200&h=400&fit=crop'
WHERE slug = 'atlanta-gutter-solutions';

-- 33. Savannah Garage Transformations (home renovation, garage)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1635108198854-26645ffe6714?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1635108198165-1773945e506e?w=1200&h=400&fit=crop'
WHERE slug = 'savannah-garage-transformations';

-- 34. Charlotte Home Remodeling (bathroom, kitchen, home remodeling)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1765959990052-fab57c043979?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1760067537022-eb0ddf877249?w=1200&h=400&fit=crop'
WHERE slug = 'charlotte-home-remodeling';

-- 35. Raleigh Custom Decks (decks, fencing)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1769184617504-be7e08f3a8b3?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1560990883-9b76fec399a9?w=1200&h=400&fit=crop'
WHERE slug = 'raleigh-custom-decks';

-- 36. Durham Basement Solutions (home renovation, basement)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1559126698-1906840f3c95?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1668934835931-0733ef258073?w=1200&h=400&fit=crop'
WHERE slug = 'durham-basement-solutions';

-- 37. Buckeye Roofing & Exteriors (roofing, siding)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1681049400158-0ff6249ac315?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1603416422796-e2081ae0c0c0?w=1200&h=400&fit=crop'
WHERE slug = 'buckeye-roofing-and-exteriors';

-- 38. Cleveland Climate Control (hvac, insulation)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1647022528152-52ed9338611d?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1698479603408-1a66a6d9e80f?w=1200&h=400&fit=crop'
WHERE slug = 'cleveland-climate-control';

-- 39. Cincinnati Plumbing Co. (plumbing)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1657558665549-bd7d82afed8c?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1577522892450-868e30731cee?w=1200&h=400&fit=crop'
WHERE slug = 'cincinnati-plumbing-co';

-- 40. Philly Home Renovations (general cleaner, home remodeling)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1686987537277-516791dabf61?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1768321901750-f7b96d774456?w=1200&h=400&fit=crop'
WHERE slug = 'philly-home-renovations';

-- 41. Pittsburgh Electric Solutions (electrical)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1758101755915-462eddc23f57?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1612203264166-e00118d63b94?w=1200&h=400&fit=crop'
WHERE slug = 'pittsburgh-electric-solutions';

-- 42. Keystone Concrete & Masonry (concrete)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1661592409266-609fbaba5421?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1666693938797-964e0f2d85b4?w=1200&h=400&fit=crop'
WHERE slug = 'keystone-concrete-and-masonry';

-- 43. Desert Shield Roofing (roofing)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1632759145351-1d592919f522?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1744975748338-d226c7535d49?w=1200&h=400&fit=crop'
WHERE slug = 'desert-shield-roofing';

-- 44. Phoenix Comfort HVAC (hvac)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1665826254141-bfa10685e002?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1637327534911-ee8057d51aec?w=1200&h=400&fit=crop'
WHERE slug = 'phoenix-comfort-hvac';

-- 45. Tucson Handyman Hub (handyman, electrical, painting)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1585406666850-82f7532fdae3?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1763798816055-9a03df62bd65?w=1200&h=400&fit=crop'
WHERE slug = 'tucson-handyman-hub';

-- 46. Emerald City Decks & Fencing (decks, fencing)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1474547385661-ef98b8799dce?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1769831190663-95fe8454d8c9?w=1200&h=400&fit=crop'
WHERE slug = 'emerald-city-decks-and-fencing';

-- 47. Puget Sound Plumbing (plumbing)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1593276907429-22dcc91c368a?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1650246363606-a2402ec42b08?w=1200&h=400&fit=crop'
WHERE slug = 'puget-sound-plumbing';

-- 48. Mile High Roofing & Gutters (roofing, gutters)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1627591637320-fcfe8c34b62d?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1763665814965-b5c4b3547908?w=1200&h=400&fit=crop'
WHERE slug = 'mile-high-roofing-and-gutters';

-- 49. Denver Insulation & Energy (insulation)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1628744448838-c04e09b1ba03?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1634231647709-06609f7dd3ca?w=1200&h=400&fit=crop'
WHERE slug = 'denver-insulation-and-energy';

-- 50. Garden State Painting (painting)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1645620359029-fa938a6c389c?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1758448511533-e1502259fff6?w=1200&h=400&fit=crop'
WHERE slug = 'garden-state-painting';

-- 51. Virginia Coast Builders (general cleaner, home renovation)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1692166567037-4009225486ac?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1628625251844-d89ea6c1fb1e?w=1200&h=400&fit=crop'
WHERE slug = 'virginia-coast-builders';

-- 52. Boston Bath Remodeling (bathroom, flooring)
UPDATE cleaners SET
  logo = 'https://images.unsplash.com/photo-1762418362644-a4daad168fb9?w=200&h=200&fit=crop',
  cover_image = 'https://images.unsplash.com/photo-1763485956294-407e7388f63b?w=1200&h=400&fit=crop'
WHERE slug = 'boston-bath-remodeling';


-- ============================================================
-- CLEANER PORTFOLIO PHOTOS (3-5 per cleaner)
-- ============================================================

-- Helper: Clear any existing photos first
DELETE FROM cleaner_photos WHERE cleaner_id IN (SELECT id FROM cleaners);

-- 1. Sunshine Roofing Co. (roofing)
INSERT INTO cleaner_photos (cleaner_id, url, thumbnail, caption, sort_order) VALUES
((SELECT id FROM cleaners WHERE slug = 'sunshine-roofing-co'),
 'https://images.unsplash.com/photo-1763665814965-b5c4b3547908?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1763665814965-b5c4b3547908?w=300&h=225&fit=crop',
 'New tile roof installation', 1),
((SELECT id FROM cleaners WHERE slug = 'sunshine-roofing-co'),
 'https://images.unsplash.com/photo-1681049400158-0ff6249ac315?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1681049400158-0ff6249ac315?w=300&h=225&fit=crop',
 'Roof repair in progress', 2),
((SELECT id FROM cleaners WHERE slug = 'sunshine-roofing-co'),
 'https://images.unsplash.com/photo-1744975748338-d226c7535d49?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1744975748338-d226c7535d49?w=300&h=225&fit=crop',
 'Completed residential roof', 3),
((SELECT id FROM cleaners WHERE slug = 'sunshine-roofing-co'),
 'https://images.unsplash.com/photo-1628774942553-bd4b553e7457?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1628774942553-bd4b553e7457?w=300&h=225&fit=crop',
 'Roof tile detail', 4);

-- 2. Metro Plumbing Solutions (plumbing)
INSERT INTO cleaner_photos (cleaner_id, url, thumbnail, caption, sort_order) VALUES
((SELECT id FROM cleaners WHERE slug = 'metro-plumbing-solutions'),
 'https://images.unsplash.com/photo-1593276907429-22dcc91c368a?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1593276907429-22dcc91c368a?w=300&h=225&fit=crop',
 'Professional pipe installation', 1),
((SELECT id FROM cleaners WHERE slug = 'metro-plumbing-solutions'),
 'https://images.unsplash.com/photo-1585406666850-82f7532fdae3?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1585406666850-82f7532fdae3?w=300&h=225&fit=crop',
 'Plumbing tools and equipment', 2),
((SELECT id FROM cleaners WHERE slug = 'metro-plumbing-solutions'),
 'https://images.unsplash.com/photo-1577522892450-868e30731cee?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1577522892450-868e30731cee?w=300&h=225&fit=crop',
 'Water heater installation', 3);

-- 3. Coastal Kitchen & Bath (kitchen, bathroom)
INSERT INTO cleaner_photos (cleaner_id, url, thumbnail, caption, sort_order) VALUES
((SELECT id FROM cleaners WHERE slug = 'coastal-kitchen-and-bath'),
 'https://images.unsplash.com/photo-1760438492655-63efac635f61?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1760438492655-63efac635f61?w=300&h=225&fit=crop',
 'Modern kitchen with island', 1),
((SELECT id FROM cleaners WHERE slug = 'coastal-kitchen-and-bath'),
 'https://images.unsplash.com/photo-1749704647283-3ad79f4acc6a?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1749704647283-3ad79f4acc6a?w=300&h=225&fit=crop',
 'Kitchen island with pendant lights', 2),
((SELECT id FROM cleaners WHERE slug = 'coastal-kitchen-and-bath'),
 'https://images.unsplash.com/photo-1762418362644-a4daad168fb9?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1762418362644-a4daad168fb9?w=300&h=225&fit=crop',
 'Bathroom with double vanity', 3),
((SELECT id FROM cleaners WHERE slug = 'coastal-kitchen-and-bath'),
 'https://images.unsplash.com/photo-1758448018619-4cbe2250b9ad?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1758448018619-4cbe2250b9ad?w=300&h=225&fit=crop',
 'Marble bathroom design', 4),
((SELECT id FROM cleaners WHERE slug = 'coastal-kitchen-and-bath'),
 'https://images.unsplash.com/photo-1765959990052-fab57c043979?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1765959990052-fab57c043979?w=300&h=225&fit=crop',
 'Kitchen cabinet installation', 5);

-- 4. Florida Comfort HVAC (hvac)
INSERT INTO cleaner_photos (cleaner_id, url, thumbnail, caption, sort_order) VALUES
((SELECT id FROM cleaners WHERE slug = 'florida-comfort-hvac'),
 'https://images.unsplash.com/photo-1698479603408-1a66a6d9e80f?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1698479603408-1a66a6d9e80f?w=300&h=225&fit=crop',
 'AC unit installation', 1),
((SELECT id FROM cleaners WHERE slug = 'florida-comfort-hvac'),
 'https://images.unsplash.com/photo-1665826254141-bfa10685e002?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1665826254141-bfa10685e002?w=300&h=225&fit=crop',
 'HVAC system maintenance', 2),
((SELECT id FROM cleaners WHERE slug = 'florida-comfort-hvac'),
 'https://images.unsplash.com/photo-1637327534911-ee8057d51aec?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1637327534911-ee8057d51aec?w=300&h=225&fit=crop',
 'Commercial HVAC setup', 3);

-- 5. Palm City Electrical (electrical)
INSERT INTO cleaner_photos (cleaner_id, url, thumbnail, caption, sort_order) VALUES
((SELECT id FROM cleaners WHERE slug = 'palm-city-electrical'),
 'https://images.unsplash.com/photo-1758101755915-462eddc23f57?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1758101755915-462eddc23f57?w=300&h=225&fit=crop',
 'Electrical panel testing', 1),
((SELECT id FROM cleaners WHERE slug = 'palm-city-electrical'),
 'https://images.unsplash.com/photo-1467733238130-bb6846885316?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1467733238130-bb6846885316?w=300&h=225&fit=crop',
 'Circuit breaker installation', 2),
((SELECT id FROM cleaners WHERE slug = 'palm-city-electrical'),
 'https://images.unsplash.com/photo-1612203264166-e00118d63b94?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1612203264166-e00118d63b94?w=300&h=225&fit=crop',
 'Light switch wiring', 3);

-- 6. Tampa Bay Bath Remodeling (bathroom)
INSERT INTO cleaner_photos (cleaner_id, url, thumbnail, caption, sort_order) VALUES
((SELECT id FROM cleaners WHERE slug = 'tampa-bay-bath-remodeling'),
 'https://images.unsplash.com/photo-1762418362644-a4daad168fb9?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1762418362644-a4daad168fb9?w=300&h=225&fit=crop',
 'Modern double vanity bathroom', 1),
((SELECT id FROM cleaners WHERE slug = 'tampa-bay-bath-remodeling'),
 'https://images.unsplash.com/photo-1763485956294-407e7388f63b?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1763485956294-407e7388f63b?w=300&h=225&fit=crop',
 'Wood accent bathroom design', 2),
((SELECT id FROM cleaners WHERE slug = 'tampa-bay-bath-remodeling'),
 'https://images.unsplash.com/photo-1768413292551-10011d6c354e?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1768413292551-10011d6c354e?w=300&h=225&fit=crop',
 'Blue tile bathroom renovation', 3),
((SELECT id FROM cleaners WHERE slug = 'tampa-bay-bath-remodeling'),
 'https://images.unsplash.com/photo-1761353855019-05f2f3ed9c43?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1761353855019-05f2f3ed9c43?w=300&h=225&fit=crop',
 'Chrome fixtures detail', 4);

-- 7. First Coast General Contracting (general cleaner)
INSERT INTO cleaner_photos (cleaner_id, url, thumbnail, caption, sort_order) VALUES
((SELECT id FROM cleaners WHERE slug = 'first-coast-general-contracting'),
 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=300&h=225&fit=crop',
 'Construction site overview', 1),
((SELECT id FROM cleaners WHERE slug = 'first-coast-general-contracting'),
 'https://images.unsplash.com/photo-1692166567037-4009225486ac?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1692166567037-4009225486ac?w=300&h=225&fit=crop',
 'Team at work on site', 2),
((SELECT id FROM cleaners WHERE slug = 'first-coast-general-contracting'),
 'https://images.unsplash.com/photo-1768321902290-54497eeb9cf6?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1768321902290-54497eeb9cf6?w=300&h=225&fit=crop',
 'Interior renovation project', 3),
((SELECT id FROM cleaners WHERE slug = 'first-coast-general-contracting'),
 'https://images.unsplash.com/photo-1628625251827-77fa98fb34fa?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1628625251827-77fa98fb34fa?w=300&h=225&fit=crop',
 'Completed home exterior', 4);

-- 8. Bay Area Roofing Pros (roofing)
INSERT INTO cleaner_photos (cleaner_id, url, thumbnail, caption, sort_order) VALUES
((SELECT id FROM cleaners WHERE slug = 'bay-area-roofing-pros'),
 'https://images.unsplash.com/photo-1744975748338-d226c7535d49?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1744975748338-d226c7535d49?w=300&h=225&fit=crop',
 'Residential roofing project', 1),
((SELECT id FROM cleaners WHERE slug = 'bay-area-roofing-pros'),
 'https://images.unsplash.com/photo-1681049400158-0ff6249ac315?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1681049400158-0ff6249ac315?w=300&h=225&fit=crop',
 'Crew working on roof', 2),
((SELECT id FROM cleaners WHERE slug = 'bay-area-roofing-pros'),
 'https://images.unsplash.com/photo-1553169507-38833977274b?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1553169507-38833977274b?w=300&h=225&fit=crop',
 'Finished roof with chimney', 3);

-- 9. Pacific Plumbing & Drain (plumbing, bathroom)
INSERT INTO cleaner_photos (cleaner_id, url, thumbnail, caption, sort_order) VALUES
((SELECT id FROM cleaners WHERE slug = 'pacific-plumbing-and-drain'),
 'https://images.unsplash.com/photo-1577522892450-868e30731cee?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1577522892450-868e30731cee?w=300&h=225&fit=crop',
 'Pipe system installation', 1),
((SELECT id FROM cleaners WHERE slug = 'pacific-plumbing-and-drain'),
 'https://images.unsplash.com/photo-1650246363606-a2402ec42b08?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1650246363606-a2402ec42b08?w=300&h=225&fit=crop',
 'Clean plumbing work', 2),
((SELECT id FROM cleaners WHERE slug = 'pacific-plumbing-and-drain'),
 'https://images.unsplash.com/photo-1763485956294-407e7388f63b?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1763485956294-407e7388f63b?w=300&h=225&fit=crop',
 'Bathroom plumbing renovation', 3);

-- 10. SoCal Pro Painting (painting)
INSERT INTO cleaner_photos (cleaner_id, url, thumbnail, caption, sort_order) VALUES
((SELECT id FROM cleaners WHERE slug = 'socal-pro-painting'),
 'https://images.unsplash.com/photo-1573257318373-58d4f226e7f9?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1573257318373-58d4f226e7f9?w=300&h=225&fit=crop',
 'Exterior painting in progress', 1),
((SELECT id FROM cleaners WHERE slug = 'socal-pro-painting'),
 'https://images.unsplash.com/photo-1643804475756-ca849847c78a?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1643804475756-ca849847c78a?w=300&h=225&fit=crop',
 'Interior wall painting', 2),
((SELECT id FROM cleaners WHERE slug = 'socal-pro-painting'),
 'https://images.unsplash.com/photo-1645620359029-fa938a6c389c?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1645620359029-fa938a6c389c?w=300&h=225&fit=crop',
 'Color accent detail', 3);

-- 11-15: More portfolio photos
INSERT INTO cleaner_photos (cleaner_id, url, thumbnail, caption, sort_order) VALUES
-- 11. Golden State HVAC
((SELECT id FROM cleaners WHERE slug = 'golden-state-hvac'),
 'https://images.unsplash.com/photo-1647022528152-52ed9338611d?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1647022528152-52ed9338611d?w=300&h=225&fit=crop',
 'AC unit mounted on wall', 1),
((SELECT id FROM cleaners WHERE slug = 'golden-state-hvac'),
 'https://images.unsplash.com/photo-1695124348827-6b66b4771432?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1695124348827-6b66b4771432?w=300&h=225&fit=crop',
 'HVAC maintenance service', 2),
((SELECT id FROM cleaners WHERE slug = 'golden-state-hvac'),
 'https://images.unsplash.com/photo-1677326140858-47e96c706b4e?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1677326140858-47e96c706b4e?w=300&h=225&fit=crop',
 'Climate control system', 3),

-- 12. LA Decks & Outdoor Living
((SELECT id FROM cleaners WHERE slug = 'la-decks-and-outdoor-living'),
 'https://images.unsplash.com/photo-1766603636772-52b1273c655d?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1766603636772-52b1273c655d?w=300&h=225&fit=crop',
 'Outdoor patio with seating area', 1),
((SELECT id FROM cleaners WHERE slug = 'la-decks-and-outdoor-living'),
 'https://images.unsplash.com/photo-1769184617504-be7e08f3a8b3?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1769184617504-be7e08f3a8b3?w=300&h=225&fit=crop',
 'Outdoor patio with string lights', 2),
((SELECT id FROM cleaners WHERE slug = 'la-decks-and-outdoor-living'),
 'https://images.unsplash.com/photo-1560990883-9b76fec399a9?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1560990883-9b76fec399a9?w=300&h=225&fit=crop',
 'Outdoor living space design', 3),
((SELECT id FROM cleaners WHERE slug = 'la-decks-and-outdoor-living'),
 'https://images.unsplash.com/photo-1474547385661-ef98b8799dce?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1474547385661-ef98b8799dce?w=300&h=225&fit=crop',
 'Candlelit deck evening', 4),

-- 13. SF Tile & Flooring
((SELECT id FROM cleaners WHERE slug = 'sf-tile-and-flooring'),
 'https://images.unsplash.com/photo-1650831341595-5408b892c486?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1650831341595-5408b892c486?w=300&h=225&fit=crop',
 'Hardwood floor close-up', 1),
((SELECT id FROM cleaners WHERE slug = 'sf-tile-and-flooring'),
 'https://images.unsplash.com/photo-1617262869711-2f5006b61073?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1617262869711-2f5006b61073?w=300&h=225&fit=crop',
 'Wood flooring installation', 2),
((SELECT id FROM cleaners WHERE slug = 'sf-tile-and-flooring'),
 'https://images.unsplash.com/photo-1622653416662-5a74e75717db?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1622653416662-5a74e75717db?w=300&h=225&fit=crop',
 'Floor finishing detail', 3),

-- 14. Sacramento Fence & Gate
((SELECT id FROM cleaners WHERE slug = 'sacramento-fence-and-gate'),
 'https://images.unsplash.com/photo-1769831190663-95fe8454d8c9?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1769831190663-95fe8454d8c9?w=300&h=225&fit=crop',
 'Wooden fence with gate', 1),
((SELECT id FROM cleaners WHERE slug = 'sacramento-fence-and-gate'),
 'https://images.unsplash.com/photo-1759502141256-45d54807853b?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1759502141256-45d54807853b?w=300&h=225&fit=crop',
 'Modern fence with landscaping', 2),
((SELECT id FROM cleaners WHERE slug = 'sacramento-fence-and-gate'),
 'https://images.unsplash.com/photo-1770306924587-7884ec2753a2?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1770306924587-7884ec2753a2?w=300&h=225&fit=crop',
 'Privacy fence installation', 3),

-- 15. Lone Star Roofing
((SELECT id FROM cleaners WHERE slug = 'lone-star-roofing-and-construction'),
 'https://images.unsplash.com/photo-1632759145351-1d592919f522?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1632759145351-1d592919f522?w=300&h=225&fit=crop',
 'Roofing crew on site', 1),
((SELECT id FROM cleaners WHERE slug = 'lone-star-roofing-and-construction'),
 'https://images.unsplash.com/photo-1628774942553-bd4b553e7457?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1628774942553-bd4b553e7457?w=300&h=225&fit=crop',
 'Roof tiles close-up', 2),
((SELECT id FROM cleaners WHERE slug = 'lone-star-roofing-and-construction'),
 'https://images.unsplash.com/photo-1763665814965-b5c4b3547908?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1763665814965-b5c4b3547908?w=300&h=225&fit=crop',
 'New roof installation', 3);

-- 16-25: More portfolio photos
INSERT INTO cleaner_photos (cleaner_id, url, thumbnail, caption, sort_order) VALUES
-- 16. Texas Handyman Services
((SELECT id FROM cleaners WHERE slug = 'texas-handyman-services'),
 'https://images.unsplash.com/photo-1584677191047-38f48d0db64e?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1584677191047-38f48d0db64e?w=300&h=225&fit=crop',
 'Professional tool kit', 1),
((SELECT id FROM cleaners WHERE slug = 'texas-handyman-services'),
 'https://images.unsplash.com/photo-1533780898421-b118c81ac26b?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1533780898421-b118c81ac26b?w=300&h=225&fit=crop',
 'Organized tool collection', 2),
((SELECT id FROM cleaners WHERE slug = 'texas-handyman-services'),
 'https://images.unsplash.com/photo-1683115097173-f24516d000c6?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1683115097173-f24516d000c6?w=300&h=225&fit=crop',
 'Wall-mounted tool storage', 3),

-- 17. Dallas Kitchen Design Studio
((SELECT id FROM cleaners WHERE slug = 'dallas-kitchen-design-studio'),
 'https://images.unsplash.com/photo-1736390800504-d3963b553aa3?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1736390800504-d3963b553aa3?w=300&h=225&fit=crop',
 'White kitchen design', 1),
((SELECT id FROM cleaners WHERE slug = 'dallas-kitchen-design-studio'),
 'https://images.unsplash.com/photo-1749704647283-3ad79f4acc6a?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1749704647283-3ad79f4acc6a?w=300&h=225&fit=crop',
 'Modern kitchen with pendant lights', 2),
((SELECT id FROM cleaners WHERE slug = 'dallas-kitchen-design-studio'),
 'https://images.unsplash.com/photo-1760067537022-eb0ddf877249?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1760067537022-eb0ddf877249?w=300&h=225&fit=crop',
 'Kitchen counter with appliances', 3),
((SELECT id FROM cleaners WHERE slug = 'dallas-kitchen-design-studio'),
 'https://images.unsplash.com/photo-1769326541248-5e09a8ace25b?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1769326541248-5e09a8ace25b?w=300&h=225&fit=crop',
 'Kitchen island with bar stools', 4),

-- 18. Austin Home Renovations
((SELECT id FROM cleaners WHERE slug = 'austin-home-renovations'),
 'https://images.unsplash.com/photo-1634586648651-f1fb9ec10d90?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1634586648651-f1fb9ec10d90?w=300&h=225&fit=crop',
 'Renovation in progress', 1),
((SELECT id FROM cleaners WHERE slug = 'austin-home-renovations'),
 'https://images.unsplash.com/photo-1768321902290-54497eeb9cf6?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1768321902290-54497eeb9cf6?w=300&h=225&fit=crop',
 'Interior remodel with exposed walls', 2),
((SELECT id FROM cleaners WHERE slug = 'austin-home-renovations'),
 'https://images.unsplash.com/photo-1768321901750-f7b96d774456?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1768321901750-f7b96d774456?w=300&h=225&fit=crop',
 'Room renovation project', 3),

-- 19. SA Town Electric
((SELECT id FROM cleaners WHERE slug = 'sa-town-electric'),
 'https://images.unsplash.com/photo-1612203264166-e00118d63b94?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1612203264166-e00118d63b94?w=300&h=225&fit=crop',
 'Electrical switch installation', 1),
((SELECT id FROM cleaners WHERE slug = 'sa-town-electric'),
 'https://images.unsplash.com/photo-1758101755915-462eddc23f57?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1758101755915-462eddc23f57?w=300&h=225&fit=crop',
 'Panel testing with multimeter', 2),
((SELECT id FROM cleaners WHERE slug = 'sa-town-electric'),
 'https://images.unsplash.com/photo-1467733238130-bb6846885316?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1467733238130-bb6846885316?w=300&h=225&fit=crop',
 'Breaker panel close-up', 3),

-- 20. Texas Concrete Works
((SELECT id FROM cleaners WHERE slug = 'texas-concrete-works'),
 'https://images.unsplash.com/photo-1565077745796-e03908990c99?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1565077745796-e03908990c99?w=300&h=225&fit=crop',
 'Concrete pathway installation', 1),
((SELECT id FROM cleaners WHERE slug = 'texas-concrete-works'),
 'https://images.unsplash.com/photo-1591188185682-41f5c74781f6?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1591188185682-41f5c74781f6?w=300&h=225&fit=crop',
 'Decorative concrete wall', 2),
((SELECT id FROM cleaners WHERE slug = 'texas-concrete-works'),
 'https://images.unsplash.com/photo-1666693938797-964e0f2d85b4?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1666693938797-964e0f2d85b4?w=300&h=225&fit=crop',
 'Stone walkway project', 3),

-- 21. Houston Siding Experts
((SELECT id FROM cleaners WHERE slug = 'houston-siding-experts'),
 'https://images.unsplash.com/photo-1639084932127-8723db70834c?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1639084932127-8723db70834c?w=300&h=225&fit=crop',
 'Home exterior with siding', 1),
((SELECT id FROM cleaners WHERE slug = 'houston-siding-experts'),
 'https://images.unsplash.com/photo-1628625251827-77fa98fb34fa?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1628625251827-77fa98fb34fa?w=300&h=225&fit=crop',
 'Beautiful home exterior', 2),
((SELECT id FROM cleaners WHERE slug = 'houston-siding-experts'),
 'https://images.unsplash.com/photo-1603416422796-e2081ae0c0c0?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1603416422796-e2081ae0c0c0?w=300&h=225&fit=crop',
 'Brick and siding detail', 3),

-- 22. Empire State Roofing
((SELECT id FROM cleaners WHERE slug = 'empire-state-roofing'),
 'https://images.unsplash.com/photo-1683551739934-a25185351214?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1683551739934-a25185351214?w=300&h=225&fit=crop',
 'Rooftop views after installation', 1),
((SELECT id FROM cleaners WHERE slug = 'empire-state-roofing'),
 'https://images.unsplash.com/photo-1627591637320-fcfe8c34b62d?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1627591637320-fcfe8c34b62d?w=300&h=225&fit=crop',
 'Commercial roofing work', 2),
((SELECT id FROM cleaners WHERE slug = 'empire-state-roofing'),
 'https://images.unsplash.com/photo-1553169507-38833977274b?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1553169507-38833977274b?w=300&h=225&fit=crop',
 'Roof structure detail', 3),

-- 23. NYC Master Plumbing
((SELECT id FROM cleaners WHERE slug = 'nyc-master-plumbing'),
 'https://images.unsplash.com/photo-1593276907429-22dcc91c368a?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1593276907429-22dcc91c368a?w=300&h=225&fit=crop',
 'Professional plumbing installation', 1),
((SELECT id FROM cleaners WHERE slug = 'nyc-master-plumbing'),
 'https://images.unsplash.com/photo-1761353855019-05f2f3ed9c43?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1761353855019-05f2f3ed9c43?w=300&h=225&fit=crop',
 'Chrome bathroom fixtures', 2),
((SELECT id FROM cleaners WHERE slug = 'nyc-master-plumbing'),
 'https://images.unsplash.com/photo-1657558665549-bd7d82afed8c?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1657558665549-bd7d82afed8c?w=300&h=225&fit=crop',
 'Pipe system work', 3),

-- 24. Brooklyn Bath Design
((SELECT id FROM cleaners WHERE slug = 'brooklyn-bath-design'),
 'https://images.unsplash.com/photo-1768413292551-10011d6c354e?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1768413292551-10011d6c354e?w=300&h=225&fit=crop',
 'Blue tile bathroom', 1),
((SELECT id FROM cleaners WHERE slug = 'brooklyn-bath-design'),
 'https://images.unsplash.com/photo-1763485955425-a61e722832ca?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1763485955425-a61e722832ca?w=300&h=225&fit=crop',
 'Modern sink and mirror', 2),
((SELECT id FROM cleaners WHERE slug = 'brooklyn-bath-design'),
 'https://images.unsplash.com/photo-1650831341595-5408b892c486?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1650831341595-5408b892c486?w=300&h=225&fit=crop',
 'Bathroom flooring detail', 3),

-- 25. Buffalo Insulation Pros
((SELECT id FROM cleaners WHERE slug = 'buffalo-insulation-pros'),
 'https://images.unsplash.com/photo-1628744448838-c04e09b1ba03?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1628744448838-c04e09b1ba03?w=300&h=225&fit=crop',
 'Home exterior project', 1),
((SELECT id FROM cleaners WHERE slug = 'buffalo-insulation-pros'),
 'https://images.unsplash.com/photo-1634231647709-06609f7dd3ca?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1634231647709-06609f7dd3ca?w=300&h=225&fit=crop',
 'Construction crew at work', 2),
((SELECT id FROM cleaners WHERE slug = 'buffalo-insulation-pros'),
 'https://images.unsplash.com/photo-1628625251833-04eeafb7a2db?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1628625251833-04eeafb7a2db?w=300&h=225&fit=crop',
 'Completed insulation project', 3);

-- 26-35: More portfolio photos
INSERT INTO cleaner_photos (cleaner_id, url, thumbnail, caption, sort_order) VALUES
-- 26. Rochester Pro Painting
((SELECT id FROM cleaners WHERE slug = 'rochester-pro-painting'),
 'https://images.unsplash.com/photo-1573257318373-58d4f226e7f9?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1573257318373-58d4f226e7f9?w=300&h=225&fit=crop',
 'Exterior painting project', 1),
((SELECT id FROM cleaners WHERE slug = 'rochester-pro-painting'),
 'https://images.unsplash.com/photo-1645620359029-fa938a6c389c?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1645620359029-fa938a6c389c?w=300&h=225&fit=crop',
 'Colorful door painting', 2),
((SELECT id FROM cleaners WHERE slug = 'rochester-pro-painting'),
 'https://images.unsplash.com/photo-1643804475756-ca849847c78a?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1643804475756-ca849847c78a?w=300&h=225&fit=crop',
 'Interior room painting', 3),

-- 27. Chicago Roofing Authority
((SELECT id FROM cleaners WHERE slug = 'chicago-roofing-authority'),
 'https://images.unsplash.com/photo-1763665814965-b5c4b3547908?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1763665814965-b5c4b3547908?w=300&h=225&fit=crop',
 'Roof tile installation', 1),
((SELECT id FROM cleaners WHERE slug = 'chicago-roofing-authority'),
 'https://images.unsplash.com/photo-1553169507-38833977274b?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1553169507-38833977274b?w=300&h=225&fit=crop',
 'Finished roof detail', 2),
((SELECT id FROM cleaners WHERE slug = 'chicago-roofing-authority'),
 'https://images.unsplash.com/photo-1639084932127-8723db70834c?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1639084932127-8723db70834c?w=300&h=225&fit=crop',
 'Home with new roof and siding', 3),

-- 28. Windy City HVAC
((SELECT id FROM cleaners WHERE slug = 'windy-city-hvac-services'),
 'https://images.unsplash.com/photo-1695124348827-6b66b4771432?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1695124348827-6b66b4771432?w=300&h=225&fit=crop',
 'HVAC unit installation', 1),
((SELECT id FROM cleaners WHERE slug = 'windy-city-hvac-services'),
 'https://images.unsplash.com/photo-1677326140858-47e96c706b4e?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1677326140858-47e96c706b4e?w=300&h=225&fit=crop',
 'Climate control panel', 2),
((SELECT id FROM cleaners WHERE slug = 'windy-city-hvac-services'),
 'https://images.unsplash.com/photo-1647022528152-52ed9338611d?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1647022528152-52ed9338611d?w=300&h=225&fit=crop',
 'Wall-mounted AC system', 3),

-- 29. Chicagoland Flooring
((SELECT id FROM cleaners WHERE slug = 'chicagoland-flooring-co'),
 'https://images.unsplash.com/photo-1693948568453-a3564f179a84?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1693948568453-a3564f179a84?w=300&h=225&fit=crop',
 'Wood floor craftsmanship', 1),
((SELECT id FROM cleaners WHERE slug = 'chicagoland-flooring-co'),
 'https://images.unsplash.com/photo-1622653416662-5a74e75717db?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1622653416662-5a74e75717db?w=300&h=225&fit=crop',
 'Floor finishing work', 2),
((SELECT id FROM cleaners WHERE slug = 'chicagoland-flooring-co'),
 'https://images.unsplash.com/photo-1617262869711-2f5006b61073?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1617262869711-2f5006b61073?w=300&h=225&fit=crop',
 'Installed hardwood floor', 3),

-- 30. Aurora Handyman
((SELECT id FROM cleaners WHERE slug = 'aurora-handyman-connection'),
 'https://images.unsplash.com/photo-1683115097173-f24516d000c6?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1683115097173-f24516d000c6?w=300&h=225&fit=crop',
 'Tool wall organization', 1),
((SELECT id FROM cleaners WHERE slug = 'aurora-handyman-connection'),
 'https://images.unsplash.com/photo-1731694411560-050e5b91e943?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1731694411560-050e5b91e943?w=300&h=225&fit=crop',
 'Workshop tool setup', 2),
((SELECT id FROM cleaners WHERE slug = 'aurora-handyman-connection'),
 'https://images.unsplash.com/photo-1584677191047-38f48d0db64e?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1584677191047-38f48d0db64e?w=300&h=225&fit=crop',
 'Professional tools', 3),

-- 31. Peachtree Builders
((SELECT id FROM cleaners WHERE slug = 'peachtree-builders-group'),
 'https://images.unsplash.com/photo-1768321914537-4193b29eec13?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1768321914537-4193b29eec13?w=300&h=225&fit=crop',
 'Renovation hallway project', 1),
((SELECT id FROM cleaners WHERE slug = 'peachtree-builders-group'),
 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=300&h=225&fit=crop',
 'Building construction', 2),
((SELECT id FROM cleaners WHERE slug = 'peachtree-builders-group'),
 'https://images.unsplash.com/photo-1628625251844-d89ea6c1fb1e?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1628625251844-d89ea6c1fb1e?w=300&h=225&fit=crop',
 'Completed home project', 3),

-- 32. Atlanta Gutter Solutions
((SELECT id FROM cleaners WHERE slug = 'atlanta-gutter-solutions'),
 'https://images.unsplash.com/photo-1628625251833-04eeafb7a2db?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1628625251833-04eeafb7a2db?w=300&h=225&fit=crop',
 'Home exterior with gutters', 1),
((SELECT id FROM cleaners WHERE slug = 'atlanta-gutter-solutions'),
 'https://images.unsplash.com/photo-1581374244633-1a564f179a84?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1581374244633-1a564f179a84?w=300&h=225&fit=crop',
 'Gutter system detail', 2),
((SELECT id FROM cleaners WHERE slug = 'atlanta-gutter-solutions'),
 'https://images.unsplash.com/photo-1628625251827-77fa98fb34fa?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1628625251827-77fa98fb34fa?w=300&h=225&fit=crop',
 'Finished gutter installation', 3),

-- 33. Savannah Garage Transformations
((SELECT id FROM cleaners WHERE slug = 'savannah-garage-transformations'),
 'https://images.unsplash.com/photo-1635108198854-26645ffe6714?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1635108198854-26645ffe6714?w=300&h=225&fit=crop',
 'Garage workspace setup', 1),
((SELECT id FROM cleaners WHERE slug = 'savannah-garage-transformations'),
 'https://images.unsplash.com/photo-1635108198165-1773945e506e?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1635108198165-1773945e506e?w=300&h=225&fit=crop',
 'Organized garage space', 2),
((SELECT id FROM cleaners WHERE slug = 'savannah-garage-transformations'),
 'https://images.unsplash.com/photo-1727823065187-7b11ee08c1d8?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1727823065187-7b11ee08c1d8?w=300&h=225&fit=crop',
 'Garage tool organization', 3),

-- 34. Charlotte Home Remodeling
((SELECT id FROM cleaners WHERE slug = 'charlotte-home-remodeling'),
 'https://images.unsplash.com/photo-1765959990052-fab57c043979?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1765959990052-fab57c043979?w=300&h=225&fit=crop',
 'Green cabinet kitchen remodel', 1),
((SELECT id FROM cleaners WHERE slug = 'charlotte-home-remodeling'),
 'https://images.unsplash.com/photo-1760067537022-eb0ddf877249?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1760067537022-eb0ddf877249?w=300&h=225&fit=crop',
 'Kitchen counter renovation', 2),
((SELECT id FROM cleaners WHERE slug = 'charlotte-home-remodeling'),
 'https://images.unsplash.com/photo-1762418362644-a4daad168fb9?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1762418362644-a4daad168fb9?w=300&h=225&fit=crop',
 'Bathroom remodel project', 3),

-- 35. Raleigh Custom Decks
((SELECT id FROM cleaners WHERE slug = 'raleigh-custom-decks'),
 'https://images.unsplash.com/photo-1560990883-9b76fec399a9?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1560990883-9b76fec399a9?w=300&h=225&fit=crop',
 'Outdoor living area', 1),
((SELECT id FROM cleaners WHERE slug = 'raleigh-custom-decks'),
 'https://images.unsplash.com/photo-1769184617504-be7e08f3a8b3?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1769184617504-be7e08f3a8b3?w=300&h=225&fit=crop',
 'Patio with string lights', 2),
((SELECT id FROM cleaners WHERE slug = 'raleigh-custom-decks'),
 'https://images.unsplash.com/photo-1769831190663-95fe8454d8c9?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1769831190663-95fe8454d8c9?w=300&h=225&fit=crop',
 'Fence and deck combo', 3);

-- 36-52: Remaining portfolio photos (3 per cleaner)
INSERT INTO cleaner_photos (cleaner_id, url, thumbnail, caption, sort_order) VALUES
-- 36. Durham Basement Solutions
((SELECT id FROM cleaners WHERE slug = 'durham-basement-solutions'),
 'https://images.unsplash.com/photo-1668934835931-0733ef258073?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1668934835931-0733ef258073?w=300&h=225&fit=crop',
 'Finished basement kitchen area', 1),
((SELECT id FROM cleaners WHERE slug = 'durham-basement-solutions'),
 'https://images.unsplash.com/photo-1559126698-1906840f3c95?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1559126698-1906840f3c95?w=300&h=225&fit=crop',
 'Basement staircase renovation', 2),
((SELECT id FROM cleaners WHERE slug = 'durham-basement-solutions'),
 'https://images.unsplash.com/photo-1702248186306-f08001f71626?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1702248186306-f08001f71626?w=300&h=225&fit=crop',
 'Basement living space', 3),

-- 37. Buckeye Roofing & Exteriors
((SELECT id FROM cleaners WHERE slug = 'buckeye-roofing-and-exteriors'),
 'https://images.unsplash.com/photo-1681049400158-0ff6249ac315?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1681049400158-0ff6249ac315?w=300&h=225&fit=crop',
 'Roofing crew at work', 1),
((SELECT id FROM cleaners WHERE slug = 'buckeye-roofing-and-exteriors'),
 'https://images.unsplash.com/photo-1603416422796-e2081ae0c0c0?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1603416422796-e2081ae0c0c0?w=300&h=225&fit=crop',
 'Exterior siding and brick', 2),
((SELECT id FROM cleaners WHERE slug = 'buckeye-roofing-and-exteriors'),
 'https://images.unsplash.com/photo-1628625251827-77fa98fb34fa?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1628625251827-77fa98fb34fa?w=300&h=225&fit=crop',
 'Completed exterior project', 3),

-- 38. Cleveland Climate Control
((SELECT id FROM cleaners WHERE slug = 'cleveland-climate-control'),
 'https://images.unsplash.com/photo-1698479603408-1a66a6d9e80f?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1698479603408-1a66a6d9e80f?w=300&h=225&fit=crop',
 'AC units side by side', 1),
((SELECT id FROM cleaners WHERE slug = 'cleveland-climate-control'),
 'https://images.unsplash.com/photo-1665826254141-bfa10685e002?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1665826254141-bfa10685e002?w=300&h=225&fit=crop',
 'Indoor HVAC unit', 2),
((SELECT id FROM cleaners WHERE slug = 'cleveland-climate-control'),
 'https://images.unsplash.com/photo-1637327534911-ee8057d51aec?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1637327534911-ee8057d51aec?w=300&h=225&fit=crop',
 'HVAC system installation', 3),

-- 39. Cincinnati Plumbing Co.
((SELECT id FROM cleaners WHERE slug = 'cincinnati-plumbing-co'),
 'https://images.unsplash.com/photo-1657558665549-bd7d82afed8c?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1657558665549-bd7d82afed8c?w=300&h=225&fit=crop',
 'Pipe system work', 1),
((SELECT id FROM cleaners WHERE slug = 'cincinnati-plumbing-co'),
 'https://images.unsplash.com/photo-1577522892450-868e30731cee?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1577522892450-868e30731cee?w=300&h=225&fit=crop',
 'Plumbing connections', 2),
((SELECT id FROM cleaners WHERE slug = 'cincinnati-plumbing-co'),
 'https://images.unsplash.com/photo-1593276907429-22dcc91c368a?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1593276907429-22dcc91c368a?w=300&h=225&fit=crop',
 'Clean pipe installation', 3),

-- 40. Philly Home Renovations
((SELECT id FROM cleaners WHERE slug = 'philly-home-renovations'),
 'https://images.unsplash.com/photo-1768321901750-f7b96d774456?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1768321901750-f7b96d774456?w=300&h=225&fit=crop',
 'Room renovation in progress', 1),
((SELECT id FROM cleaners WHERE slug = 'philly-home-renovations'),
 'https://images.unsplash.com/photo-1686987537277-516791dabf61?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1686987537277-516791dabf61?w=300&h=225&fit=crop',
 'Door installation project', 2),
((SELECT id FROM cleaners WHERE slug = 'philly-home-renovations'),
 'https://images.unsplash.com/photo-1634586648651-f1fb9ec10d90?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1634586648651-f1fb9ec10d90?w=300&h=225&fit=crop',
 'Home improvement tools on site', 3),

-- 41. Pittsburgh Electric Solutions
((SELECT id FROM cleaners WHERE slug = 'pittsburgh-electric-solutions'),
 'https://images.unsplash.com/photo-1467733238130-bb6846885316?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1467733238130-bb6846885316?w=300&h=225&fit=crop',
 'Power switches installation', 1),
((SELECT id FROM cleaners WHERE slug = 'pittsburgh-electric-solutions'),
 'https://images.unsplash.com/photo-1758101755915-462eddc23f57?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1758101755915-462eddc23f57?w=300&h=225&fit=crop',
 'Electrical testing', 2),
((SELECT id FROM cleaners WHERE slug = 'pittsburgh-electric-solutions'),
 'https://images.unsplash.com/photo-1612203264166-e00118d63b94?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1612203264166-e00118d63b94?w=300&h=225&fit=crop',
 'Switch and outlet work', 3),

-- 42. Keystone Concrete & Masonry
((SELECT id FROM cleaners WHERE slug = 'keystone-concrete-and-masonry'),
 'https://images.unsplash.com/photo-1666693938797-964e0f2d85b4?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1666693938797-964e0f2d85b4?w=300&h=225&fit=crop',
 'Stone walkway project', 1),
((SELECT id FROM cleaners WHERE slug = 'keystone-concrete-and-masonry'),
 'https://images.unsplash.com/photo-1661592409266-609fbaba5421?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1661592409266-609fbaba5421?w=300&h=225&fit=crop',
 'Brick and stone work', 2),
((SELECT id FROM cleaners WHERE slug = 'keystone-concrete-and-masonry'),
 'https://images.unsplash.com/photo-1565077745796-e03908990c99?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1565077745796-e03908990c99?w=300&h=225&fit=crop',
 'Concrete pathway', 3),

-- 43. Desert Shield Roofing
((SELECT id FROM cleaners WHERE slug = 'desert-shield-roofing'),
 'https://images.unsplash.com/photo-1744975748338-d226c7535d49?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1744975748338-d226c7535d49?w=300&h=225&fit=crop',
 'Residential roofing', 1),
((SELECT id FROM cleaners WHERE slug = 'desert-shield-roofing'),
 'https://images.unsplash.com/photo-1632759145351-1d592919f522?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1632759145351-1d592919f522?w=300&h=225&fit=crop',
 'Roof work in progress', 2),
((SELECT id FROM cleaners WHERE slug = 'desert-shield-roofing'),
 'https://images.unsplash.com/photo-1627591637320-fcfe8c34b62d?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1627591637320-fcfe8c34b62d?w=300&h=225&fit=crop',
 'Completed roofing job', 3),

-- 44. Phoenix Comfort HVAC
((SELECT id FROM cleaners WHERE slug = 'phoenix-comfort-hvac'),
 'https://images.unsplash.com/photo-1637327534911-ee8057d51aec?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1637327534911-ee8057d51aec?w=300&h=225&fit=crop',
 'HVAC outdoor unit', 1),
((SELECT id FROM cleaners WHERE slug = 'phoenix-comfort-hvac'),
 'https://images.unsplash.com/photo-1665826254141-bfa10685e002?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1665826254141-bfa10685e002?w=300&h=225&fit=crop',
 'Indoor unit installation', 2),
((SELECT id FROM cleaners WHERE slug = 'phoenix-comfort-hvac'),
 'https://images.unsplash.com/photo-1647022528152-52ed9338611d?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1647022528152-52ed9338611d?w=300&h=225&fit=crop',
 'Wall-mounted climate control', 3),

-- 45. Tucson Handyman Hub
((SELECT id FROM cleaners WHERE slug = 'tucson-handyman-hub'),
 'https://images.unsplash.com/photo-1763798816055-9a03df62bd65?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1763798816055-9a03df62bd65?w=300&h=225&fit=crop',
 'Workshop tools and supplies', 1),
((SELECT id FROM cleaners WHERE slug = 'tucson-handyman-hub'),
 'https://images.unsplash.com/photo-1585406666850-82f7532fdae3?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1585406666850-82f7532fdae3?w=300&h=225&fit=crop',
 'Professional hand tools', 2),
((SELECT id FROM cleaners WHERE slug = 'tucson-handyman-hub'),
 'https://images.unsplash.com/photo-1533780898421-b118c81ac26b?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1533780898421-b118c81ac26b?w=300&h=225&fit=crop',
 'Tool chest ready for work', 3),

-- 46. Emerald City Decks & Fencing
((SELECT id FROM cleaners WHERE slug = 'emerald-city-decks-and-fencing'),
 'https://images.unsplash.com/photo-1769831190663-95fe8454d8c9?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1769831190663-95fe8454d8c9?w=300&h=225&fit=crop',
 'Wooden fence with gate', 1),
((SELECT id FROM cleaners WHERE slug = 'emerald-city-decks-and-fencing'),
 'https://images.unsplash.com/photo-1474547385661-ef98b8799dce?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1474547385661-ef98b8799dce?w=300&h=225&fit=crop',
 'Deck with evening lighting', 2),
((SELECT id FROM cleaners WHERE slug = 'emerald-city-decks-and-fencing'),
 'https://images.unsplash.com/photo-1766603636772-52b1273c655d?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1766603636772-52b1273c655d?w=300&h=225&fit=crop',
 'Patio seating area', 3),

-- 47. Puget Sound Plumbing
((SELECT id FROM cleaners WHERE slug = 'puget-sound-plumbing'),
 'https://images.unsplash.com/photo-1650246363606-a2402ec42b08?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1650246363606-a2402ec42b08?w=300&h=225&fit=crop',
 'Clean plumbing installation', 1),
((SELECT id FROM cleaners WHERE slug = 'puget-sound-plumbing'),
 'https://images.unsplash.com/photo-1593276907429-22dcc91c368a?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1593276907429-22dcc91c368a?w=300&h=225&fit=crop',
 'Pipe work detail', 2),
((SELECT id FROM cleaners WHERE slug = 'puget-sound-plumbing'),
 'https://images.unsplash.com/photo-1577522892450-868e30731cee?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1577522892450-868e30731cee?w=300&h=225&fit=crop',
 'Water system connections', 3),

-- 48. Mile High Roofing & Gutters
((SELECT id FROM cleaners WHERE slug = 'mile-high-roofing-and-gutters'),
 'https://images.unsplash.com/photo-1763665814965-b5c4b3547908?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1763665814965-b5c4b3547908?w=300&h=225&fit=crop',
 'Roof installation project', 1),
((SELECT id FROM cleaners WHERE slug = 'mile-high-roofing-and-gutters'),
 'https://images.unsplash.com/photo-1627591637320-fcfe8c34b62d?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1627591637320-fcfe8c34b62d?w=300&h=225&fit=crop',
 'Building with new roof', 2),
((SELECT id FROM cleaners WHERE slug = 'mile-high-roofing-and-gutters'),
 'https://images.unsplash.com/photo-1628625251833-04eeafb7a2db?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1628625251833-04eeafb7a2db?w=300&h=225&fit=crop',
 'Home with gutter system', 3),

-- 49. Denver Insulation & Energy
((SELECT id FROM cleaners WHERE slug = 'denver-insulation-and-energy'),
 'https://images.unsplash.com/photo-1628744448838-c04e09b1ba03?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1628744448838-c04e09b1ba03?w=300&h=225&fit=crop',
 'Energy-efficient home', 1),
((SELECT id FROM cleaners WHERE slug = 'denver-insulation-and-energy'),
 'https://images.unsplash.com/photo-1634231647709-06609f7dd3ca?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1634231647709-06609f7dd3ca?w=300&h=225&fit=crop',
 'Construction work', 2),
((SELECT id FROM cleaners WHERE slug = 'denver-insulation-and-energy'),
 'https://images.unsplash.com/photo-1628625251827-77fa98fb34fa?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1628625251827-77fa98fb34fa?w=300&h=225&fit=crop',
 'Completed insulation project', 3),

-- 50. Garden State Painting
((SELECT id FROM cleaners WHERE slug = 'garden-state-painting'),
 'https://images.unsplash.com/photo-1645620359029-fa938a6c389c?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1645620359029-fa938a6c389c?w=300&h=225&fit=crop',
 'Colorful painted door', 1),
((SELECT id FROM cleaners WHERE slug = 'garden-state-painting'),
 'https://images.unsplash.com/photo-1573257318373-58d4f226e7f9?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1573257318373-58d4f226e7f9?w=300&h=225&fit=crop',
 'Exterior painting work', 2),
((SELECT id FROM cleaners WHERE slug = 'garden-state-painting'),
 'https://images.unsplash.com/photo-1643804475756-ca849847c78a?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1643804475756-ca849847c78a?w=300&h=225&fit=crop',
 'Interior wall finish', 3),

-- 51. Virginia Coast Builders
((SELECT id FROM cleaners WHERE slug = 'virginia-coast-builders'),
 'https://images.unsplash.com/photo-1628625251844-d89ea6c1fb1e?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1628625251844-d89ea6c1fb1e?w=300&h=225&fit=crop',
 'Completed home build', 1),
((SELECT id FROM cleaners WHERE slug = 'virginia-coast-builders'),
 'https://images.unsplash.com/photo-1692166567037-4009225486ac?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1692166567037-4009225486ac?w=300&h=225&fit=crop',
 'Team on construction site', 2),
((SELECT id FROM cleaners WHERE slug = 'virginia-coast-builders'),
 'https://images.unsplash.com/photo-1768321902290-54497eeb9cf6?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1768321902290-54497eeb9cf6?w=300&h=225&fit=crop',
 'Interior renovation project', 3),

-- 52. Boston Bath Remodeling
((SELECT id FROM cleaners WHERE slug = 'boston-bath-remodeling'),
 'https://images.unsplash.com/photo-1763485956294-407e7388f63b?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1763485956294-407e7388f63b?w=300&h=225&fit=crop',
 'Wood accent bathroom', 1),
((SELECT id FROM cleaners WHERE slug = 'boston-bath-remodeling'),
 'https://images.unsplash.com/photo-1762418362644-a4daad168fb9?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1762418362644-a4daad168fb9?w=300&h=225&fit=crop',
 'Double vanity design', 2),
((SELECT id FROM cleaners WHERE slug = 'boston-bath-remodeling'),
 'https://images.unsplash.com/photo-1617262869711-2f5006b61073?w=800&h=600&fit=crop',
 'https://images.unsplash.com/photo-1617262869711-2f5006b61073?w=300&h=225&fit=crop',
 'Bathroom floor tile work', 3);
