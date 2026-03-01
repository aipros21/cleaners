-- ============================================================
-- seed_category_images.sql
-- Add Unsplash images to all 20 categories for homepage cards
-- All images from images.unsplash.com CDN (no server uploads)
-- ============================================================

UPDATE categories SET image = 'https://images.unsplash.com/photo-1726589004565-bedfba94d3a2?w=600&h=400&fit=crop' WHERE slug = 'roofing';
UPDATE categories SET image = 'https://images.unsplash.com/photo-1656733910965-258eaf528b40?w=600&h=400&fit=crop' WHERE slug = 'general-cleaner';
UPDATE categories SET image = 'https://images.unsplash.com/photo-1584677191047-38f48d0db64e?w=600&h=400&fit=crop' WHERE slug = 'handyman';
UPDATE categories SET image = 'https://images.unsplash.com/photo-1647022528152-52ed9338611d?w=600&h=400&fit=crop' WHERE slug = 'hvac';
UPDATE categories SET image = 'https://images.unsplash.com/photo-1682888818696-906287d759f5?w=600&h=400&fit=crop' WHERE slug = 'bathroom-remodeling';
UPDATE categories SET image = 'https://images.unsplash.com/photo-1694827893591-af9b80361599?w=600&h=400&fit=crop' WHERE slug = 'plumbing';
UPDATE categories SET image = 'https://images.unsplash.com/photo-1616621859311-19dff47afafc?w=600&h=400&fit=crop' WHERE slug = 'concrete-masonry';
UPDATE categories SET image = 'https://images.unsplash.com/photo-1768173756660-45fd2bfe6be6?w=600&h=400&fit=crop' WHERE slug = 'decks-patios';
UPDATE categories SET image = 'https://images.unsplash.com/photo-1682888818589-404faaa4dbc9?w=600&h=400&fit=crop' WHERE slug = 'kitchen-remodeling';
UPDATE categories SET image = 'https://images.unsplash.com/photo-1767701073983-3fba2358dfe0?w=600&h=400&fit=crop' WHERE slug = 'siding';
UPDATE categories SET image = 'https://images.unsplash.com/photo-1673967683504-d23d3ab5b011?w=600&h=400&fit=crop' WHERE slug = 'fencing';
UPDATE categories SET image = 'https://images.unsplash.com/photo-1751486289947-4f5f5961b3aa?w=600&h=400&fit=crop' WHERE slug = 'electrical';
UPDATE categories SET image = 'https://images.unsplash.com/photo-1635359800970-90b35af94a4a?w=600&h=400&fit=crop' WHERE slug = 'gutters';
UPDATE categories SET image = 'https://images.unsplash.com/photo-1659390825881-b9d0b451f292?w=600&h=400&fit=crop' WHERE slug = 'painting';
UPDATE categories SET image = 'https://images.unsplash.com/photo-1765277789236-18b14cb7869f?w=600&h=400&fit=crop' WHERE slug = 'home-remodeling';
UPDATE categories SET image = 'https://images.unsplash.com/photo-1693948568453-a3564f179a84?w=600&h=400&fit=crop' WHERE slug = 'flooring';
UPDATE categories SET image = 'https://images.unsplash.com/photo-1674485127842-7b63ac41db8c?w=600&h=400&fit=crop' WHERE slug = 'insulation';
UPDATE categories SET image = 'https://images.unsplash.com/photo-1768321901750-f7b96d774456?w=600&h=400&fit=crop' WHERE slug = 'home-renovation';
UPDATE categories SET image = 'https://images.unsplash.com/photo-1646592491560-e121e097dcf2?w=600&h=400&fit=crop' WHERE slug = 'basement-finishing';
UPDATE categories SET image = 'https://images.unsplash.com/photo-1635108198854-26645ffe6714?w=600&h=400&fit=crop' WHERE slug = 'garage-renovation';
