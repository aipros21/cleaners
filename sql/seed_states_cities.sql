-- ============================================================
-- seed_states_cities.sql
-- All 50 US States + DC and Top 200 US Cities
-- ============================================================

-- ------------------------------------------------------------
-- STATES: All 50 states + District of Columbia
-- Columns: name, code, slug, lat, lng
-- ------------------------------------------------------------

INSERT INTO states (name, code, slug, lat, lng) VALUES
('Alabama', 'AL', 'alabama', 32.3182, -86.9023),
('Alaska', 'AK', 'alaska', 64.2008, -152.4937),
('Arizona', 'AZ', 'arizona', 34.0489, -111.0937),
('Arkansas', 'AR', 'arkansas', 35.2010, -91.8318),
('California', 'CA', 'california', 36.7783, -119.4179),
('Colorado', 'CO', 'colorado', 39.5501, -105.7821),
('Connecticut', 'CT', 'connecticut', 41.6032, -73.0877),
('Delaware', 'DE', 'delaware', 38.9108, -75.5277),
('District of Columbia', 'DC', 'district-of-columbia', 38.9072, -77.0369),
('Florida', 'FL', 'florida', 27.6648, -81.5158),
('Georgia', 'GA', 'georgia', 32.1656, -82.9001),
('Hawaii', 'HI', 'hawaii', 19.8968, -155.5828),
('Idaho', 'ID', 'idaho', 44.0682, -114.7420),
('Illinois', 'IL', 'illinois', 40.6331, -89.3985),
('Indiana', 'IN', 'indiana', 40.2672, -86.1349),
('Iowa', 'IA', 'iowa', 41.8780, -93.0977),
('Kansas', 'KS', 'kansas', 39.0119, -98.4842),
('Kentucky', 'KY', 'kentucky', 37.8393, -84.2700),
('Louisiana', 'LA', 'louisiana', 30.9843, -91.9623),
('Maine', 'ME', 'maine', 45.2538, -69.4455),
('Maryland', 'MD', 'maryland', 39.0458, -76.6413),
('Massachusetts', 'MA', 'massachusetts', 42.4072, -71.3824),
('Michigan', 'MI', 'michigan', 44.3148, -85.6024),
('Minnesota', 'MN', 'minnesota', 46.7296, -94.6859),
('Mississippi', 'MS', 'mississippi', 32.3547, -89.3985),
('Missouri', 'MO', 'missouri', 37.9643, -91.8318),
('Montana', 'MT', 'montana', 46.8797, -110.3626),
('Nebraska', 'NE', 'nebraska', 41.4925, -99.9018),
('Nevada', 'NV', 'nevada', 38.8026, -116.4194),
('New Hampshire', 'NH', 'new-hampshire', 43.1939, -71.5724),
('New Jersey', 'NJ', 'new-jersey', 40.0583, -74.4057),
('New Mexico', 'NM', 'new-mexico', 34.5199, -105.8701),
('New York', 'NY', 'new-york', 40.7128, -74.0060),
('North Carolina', 'NC', 'north-carolina', 35.7596, -79.0193),
('North Dakota', 'ND', 'north-dakota', 47.5515, -101.0020),
('Ohio', 'OH', 'ohio', 40.4173, -82.9071),
('Oklahoma', 'OK', 'oklahoma', 35.4676, -97.5164),
('Oregon', 'OR', 'oregon', 43.8041, -120.5542),
('Pennsylvania', 'PA', 'pennsylvania', 41.2033, -77.1945),
('Rhode Island', 'RI', 'rhode-island', 41.5801, -71.4774),
('South Carolina', 'SC', 'south-carolina', 33.8361, -81.1637),
('South Dakota', 'SD', 'south-dakota', 43.9695, -99.9018),
('Tennessee', 'TN', 'tennessee', 35.5175, -86.5804),
('Texas', 'TX', 'texas', 31.9686, -99.9018),
('Utah', 'UT', 'utah', 39.3210, -111.0937),
('Vermont', 'VT', 'vermont', 44.5588, -72.5778),
('Virginia', 'VA', 'virginia', 37.4316, -78.6569),
('Washington', 'WA', 'washington', 47.7511, -120.7401),
('West Virginia', 'WV', 'west-virginia', 38.5976, -80.4549),
('Wisconsin', 'WI', 'wisconsin', 43.7844, -88.7879),
('Wyoming', 'WY', 'wyoming', 43.0760, -107.2903);


-- ------------------------------------------------------------
-- CITIES: Top 200 US cities by population
-- Columns: state_id, name, slug, lat, lng, population
-- Uses subqueries to reference state IDs
-- ------------------------------------------------------------

INSERT INTO cities (state_id, name, slug, lat, lng, population) VALUES

-- California (10 cities)
((SELECT id FROM states WHERE code = 'CA'), 'Los Angeles', 'los-angeles', 34.0522, -118.2437, 3898747),
((SELECT id FROM states WHERE code = 'CA'), 'San Diego', 'san-diego', 32.7157, -117.1611, 1386932),
((SELECT id FROM states WHERE code = 'CA'), 'San Jose', 'san-jose', 37.3382, -121.8863, 1013240),
((SELECT id FROM states WHERE code = 'CA'), 'San Francisco', 'san-francisco', 37.7749, -122.4194, 873965),
((SELECT id FROM states WHERE code = 'CA'), 'Fresno', 'fresno', 36.7378, -119.7871, 542107),
((SELECT id FROM states WHERE code = 'CA'), 'Sacramento', 'sacramento', 38.5816, -121.4944, 524943),
((SELECT id FROM states WHERE code = 'CA'), 'Long Beach', 'long-beach', 33.7701, -118.1937, 466742),
((SELECT id FROM states WHERE code = 'CA'), 'Oakland', 'oakland', 37.8044, -122.2712, 433031),
((SELECT id FROM states WHERE code = 'CA'), 'Bakersfield', 'bakersfield', 35.3733, -119.0187, 403455),
((SELECT id FROM states WHERE code = 'CA'), 'Anaheim', 'anaheim', 33.8366, -117.9143, 350365),

-- Texas (8 cities)
((SELECT id FROM states WHERE code = 'TX'), 'Houston', 'houston', 29.7604, -95.3698, 2304580),
((SELECT id FROM states WHERE code = 'TX'), 'San Antonio', 'san-antonio', 29.4241, -98.4936, 1547253),
((SELECT id FROM states WHERE code = 'TX'), 'Dallas', 'dallas', 32.7767, -96.7970, 1304379),
((SELECT id FROM states WHERE code = 'TX'), 'Austin', 'austin', 30.2672, -97.7431, 978908),
((SELECT id FROM states WHERE code = 'TX'), 'Fort Worth', 'fort-worth', 32.7555, -97.3308, 918915),
((SELECT id FROM states WHERE code = 'TX'), 'El Paso', 'el-paso', 31.7619, -106.4850, 678815),
((SELECT id FROM states WHERE code = 'TX'), 'Arlington', 'arlington', 32.7357, -97.1081, 394266),
((SELECT id FROM states WHERE code = 'TX'), 'Corpus Christi', 'corpus-christi', 27.8006, -97.3964, 317863),

-- Florida (7 cities)
((SELECT id FROM states WHERE code = 'FL'), 'Jacksonville', 'jacksonville', 30.3322, -81.6557, 949611),
((SELECT id FROM states WHERE code = 'FL'), 'Miami', 'miami', 25.7617, -80.1918, 442241),
((SELECT id FROM states WHERE code = 'FL'), 'Tampa', 'tampa', 27.9506, -82.4572, 384959),
((SELECT id FROM states WHERE code = 'FL'), 'Orlando', 'orlando', 28.5383, -81.3792, 307573),
((SELECT id FROM states WHERE code = 'FL'), 'St. Petersburg', 'st-petersburg', 27.7676, -82.6403, 258308),
((SELECT id FROM states WHERE code = 'FL'), 'Hialeah', 'hialeah', 25.8576, -80.2781, 223109),
((SELECT id FROM states WHERE code = 'FL'), 'Fort Lauderdale', 'fort-lauderdale', 26.1224, -80.1373, 182760),

-- New York (5 cities)
((SELECT id FROM states WHERE code = 'NY'), 'New York City', 'new-york-city', 40.7128, -74.0060, 8336817),
((SELECT id FROM states WHERE code = 'NY'), 'Buffalo', 'buffalo', 42.8864, -78.8784, 278349),
((SELECT id FROM states WHERE code = 'NY'), 'Rochester', 'rochester', 43.1566, -77.6088, 211328),
((SELECT id FROM states WHERE code = 'NY'), 'Yonkers', 'yonkers', 40.9312, -73.8987, 211569),
((SELECT id FROM states WHERE code = 'NY'), 'Syracuse', 'syracuse', 43.0481, -76.1474, 148620),

-- Illinois (5 cities)
((SELECT id FROM states WHERE code = 'IL'), 'Chicago', 'chicago', 41.8781, -87.6298, 2693976),
((SELECT id FROM states WHERE code = 'IL'), 'Aurora', 'aurora', 41.7606, -88.3201, 180542),
((SELECT id FROM states WHERE code = 'IL'), 'Naperville', 'naperville', 41.7508, -88.1535, 149540),
((SELECT id FROM states WHERE code = 'IL'), 'Joliet', 'joliet', 41.5250, -88.0817, 150362),
((SELECT id FROM states WHERE code = 'IL'), 'Rockford', 'rockford', 42.2711, -89.0940, 148655),

-- Pennsylvania (5 cities)
((SELECT id FROM states WHERE code = 'PA'), 'Philadelphia', 'philadelphia', 39.9526, -75.1652, 1603797),
((SELECT id FROM states WHERE code = 'PA'), 'Pittsburgh', 'pittsburgh', 40.4406, -79.9959, 302971),
((SELECT id FROM states WHERE code = 'PA'), 'Allentown', 'allentown', 40.6084, -75.4902, 126092),
((SELECT id FROM states WHERE code = 'PA'), 'Erie', 'erie', 42.1292, -80.0851, 101786),
((SELECT id FROM states WHERE code = 'PA'), 'Reading', 'reading', 40.3357, -75.9269, 95112),

-- Ohio (5 cities)
((SELECT id FROM states WHERE code = 'OH'), 'Columbus', 'columbus', 39.9612, -82.9988, 905748),
((SELECT id FROM states WHERE code = 'OH'), 'Cleveland', 'cleveland', 41.4993, -81.6944, 372624),
((SELECT id FROM states WHERE code = 'OH'), 'Cincinnati', 'cincinnati', 39.1031, -84.5120, 309317),
((SELECT id FROM states WHERE code = 'OH'), 'Toledo', 'toledo', 41.6528, -83.5379, 270871),
((SELECT id FROM states WHERE code = 'OH'), 'Akron', 'akron', 41.0814, -81.5190, 190469),

-- Georgia (5 cities)
((SELECT id FROM states WHERE code = 'GA'), 'Atlanta', 'atlanta', 33.7490, -84.3880, 498715),
((SELECT id FROM states WHERE code = 'GA'), 'Augusta', 'augusta', 33.4735, -82.0105, 202081),
((SELECT id FROM states WHERE code = 'GA'), 'Columbus', 'columbus-ga', 32.4610, -84.9877, 206922),
((SELECT id FROM states WHERE code = 'GA'), 'Savannah', 'savannah', 32.0809, -81.0912, 147780),
((SELECT id FROM states WHERE code = 'GA'), 'Athens', 'athens', 33.9519, -83.3576, 127585),

-- North Carolina (5 cities)
((SELECT id FROM states WHERE code = 'NC'), 'Charlotte', 'charlotte', 35.2271, -80.8431, 874579),
((SELECT id FROM states WHERE code = 'NC'), 'Raleigh', 'raleigh', 35.7796, -78.6382, 467665),
((SELECT id FROM states WHERE code = 'NC'), 'Greensboro', 'greensboro', 36.0726, -79.7920, 299035),
((SELECT id FROM states WHERE code = 'NC'), 'Durham', 'durham', 35.9940, -78.8986, 283506),
((SELECT id FROM states WHERE code = 'NC'), 'Winston-Salem', 'winston-salem', 36.0999, -80.2442, 249545),

-- Michigan (5 cities)
((SELECT id FROM states WHERE code = 'MI'), 'Detroit', 'detroit', 42.3314, -83.0458, 639111),
((SELECT id FROM states WHERE code = 'MI'), 'Grand Rapids', 'grand-rapids', 42.9634, -85.6681, 198917),
((SELECT id FROM states WHERE code = 'MI'), 'Warren', 'warren', 42.5145, -83.0147, 139387),
((SELECT id FROM states WHERE code = 'MI'), 'Sterling Heights', 'sterling-heights', 42.5803, -83.0302, 134346),
((SELECT id FROM states WHERE code = 'MI'), 'Ann Arbor', 'ann-arbor', 42.2808, -83.7430, 123851),

-- New Jersey (5 cities)
((SELECT id FROM states WHERE code = 'NJ'), 'Newark', 'newark', 40.7357, -74.1724, 311549),
((SELECT id FROM states WHERE code = 'NJ'), 'Jersey City', 'jersey-city', 40.7178, -74.0431, 292449),
((SELECT id FROM states WHERE code = 'NJ'), 'Paterson', 'paterson', 40.9168, -74.1718, 159732),
((SELECT id FROM states WHERE code = 'NJ'), 'Elizabeth', 'elizabeth', 40.6640, -74.2107, 137298),
((SELECT id FROM states WHERE code = 'NJ'), 'Trenton', 'trenton', 40.2171, -74.7429, 90871),

-- Virginia (5 cities)
((SELECT id FROM states WHERE code = 'VA'), 'Virginia Beach', 'virginia-beach', 36.8529, -75.9780, 459470),
((SELECT id FROM states WHERE code = 'VA'), 'Norfolk', 'norfolk', 36.8508, -76.2859, 244703),
((SELECT id FROM states WHERE code = 'VA'), 'Chesapeake', 'chesapeake', 36.7682, -76.2875, 249422),
((SELECT id FROM states WHERE code = 'VA'), 'Richmond', 'richmond', 37.5407, -77.4360, 226610),
((SELECT id FROM states WHERE code = 'VA'), 'Arlington', 'arlington-va', 38.8799, -77.1068, 238643),

-- Washington (5 cities)
((SELECT id FROM states WHERE code = 'WA'), 'Seattle', 'seattle', 47.6062, -122.3321, 737015),
((SELECT id FROM states WHERE code = 'WA'), 'Spokane', 'spokane', 47.6588, -117.4260, 228989),
((SELECT id FROM states WHERE code = 'WA'), 'Tacoma', 'tacoma', 47.2529, -122.4443, 219346),
((SELECT id FROM states WHERE code = 'WA'), 'Vancouver', 'vancouver-wa', 45.6387, -122.6615, 190915),
((SELECT id FROM states WHERE code = 'WA'), 'Bellevue', 'bellevue', 47.6101, -122.2015, 151854),

-- Arizona (5 cities)
((SELECT id FROM states WHERE code = 'AZ'), 'Phoenix', 'phoenix', 33.4484, -112.0740, 1608139),
((SELECT id FROM states WHERE code = 'AZ'), 'Tucson', 'tucson', 32.2226, -110.9747, 542629),
((SELECT id FROM states WHERE code = 'AZ'), 'Mesa', 'mesa', 33.4152, -111.8315, 504258),
((SELECT id FROM states WHERE code = 'AZ'), 'Chandler', 'chandler', 33.3062, -111.8413, 275987),
((SELECT id FROM states WHERE code = 'AZ'), 'Scottsdale', 'scottsdale', 33.4942, -111.9261, 241361),

-- Massachusetts (5 cities)
((SELECT id FROM states WHERE code = 'MA'), 'Boston', 'boston', 42.3601, -71.0589, 675647),
((SELECT id FROM states WHERE code = 'MA'), 'Worcester', 'worcester', 42.2626, -71.8023, 206518),
((SELECT id FROM states WHERE code = 'MA'), 'Springfield', 'springfield-ma', 42.1015, -72.5898, 155929),
((SELECT id FROM states WHERE code = 'MA'), 'Cambridge', 'cambridge', 42.3736, -71.1097, 118403),
((SELECT id FROM states WHERE code = 'MA'), 'Lowell', 'lowell', 42.6334, -71.3162, 115554),

-- Tennessee (5 cities)
((SELECT id FROM states WHERE code = 'TN'), 'Nashville', 'nashville', 36.1627, -86.7816, 689447),
((SELECT id FROM states WHERE code = 'TN'), 'Memphis', 'memphis', 35.1495, -90.0490, 633104),
((SELECT id FROM states WHERE code = 'TN'), 'Knoxville', 'knoxville', 35.9606, -83.9207, 190740),
((SELECT id FROM states WHERE code = 'TN'), 'Chattanooga', 'chattanooga', 35.0456, -85.3097, 181099),
((SELECT id FROM states WHERE code = 'TN'), 'Clarksville', 'clarksville', 36.5298, -87.3595, 166722),

-- Indiana (4 cities)
((SELECT id FROM states WHERE code = 'IN'), 'Indianapolis', 'indianapolis', 39.7684, -86.1581, 887642),
((SELECT id FROM states WHERE code = 'IN'), 'Fort Wayne', 'fort-wayne', 41.0793, -85.1394, 263886),
((SELECT id FROM states WHERE code = 'IN'), 'Evansville', 'evansville', 37.9716, -87.5711, 117429),
((SELECT id FROM states WHERE code = 'IN'), 'South Bend', 'south-bend', 41.6764, -86.2520, 103453),

-- Missouri (4 cities)
((SELECT id FROM states WHERE code = 'MO'), 'Kansas City', 'kansas-city-mo', 39.0997, -94.5786, 508090),
((SELECT id FROM states WHERE code = 'MO'), 'St. Louis', 'st-louis', 38.6270, -90.1994, 301578),
((SELECT id FROM states WHERE code = 'MO'), 'Springfield', 'springfield-mo', 37.2090, -93.2923, 169176),
((SELECT id FROM states WHERE code = 'MO'), 'Columbia', 'columbia-mo', 38.9517, -92.3341, 126254),

-- Maryland (4 cities)
((SELECT id FROM states WHERE code = 'MD'), 'Baltimore', 'baltimore', 39.2904, -76.6122, 585708),
((SELECT id FROM states WHERE code = 'MD'), 'Frederick', 'frederick', 39.4143, -77.4105, 78171),
((SELECT id FROM states WHERE code = 'MD'), 'Rockville', 'rockville', 39.0840, -77.1528, 68401),
((SELECT id FROM states WHERE code = 'MD'), 'Gaithersburg', 'gaithersburg', 39.1434, -77.2014, 69657),

-- Wisconsin (4 cities)
((SELECT id FROM states WHERE code = 'WI'), 'Milwaukee', 'milwaukee', 43.0389, -87.9065, 577222),
((SELECT id FROM states WHERE code = 'WI'), 'Madison', 'madison', 43.0731, -89.4012, 269840),
((SELECT id FROM states WHERE code = 'WI'), 'Green Bay', 'green-bay', 44.5133, -88.0133, 107395),
((SELECT id FROM states WHERE code = 'WI'), 'Kenosha', 'kenosha', 42.5847, -87.8212, 99889),

-- Colorado (5 cities)
((SELECT id FROM states WHERE code = 'CO'), 'Denver', 'denver', 39.7392, -104.9903, 715522),
((SELECT id FROM states WHERE code = 'CO'), 'Colorado Springs', 'colorado-springs', 38.8339, -104.8214, 478961),
((SELECT id FROM states WHERE code = 'CO'), 'Aurora', 'aurora-co', 39.7294, -104.8319, 386261),
((SELECT id FROM states WHERE code = 'CO'), 'Fort Collins', 'fort-collins', 40.5853, -105.0844, 169810),
((SELECT id FROM states WHERE code = 'CO'), 'Lakewood', 'lakewood', 39.7047, -105.0814, 155984),

-- Minnesota (4 cities)
((SELECT id FROM states WHERE code = 'MN'), 'Minneapolis', 'minneapolis', 44.9778, -93.2650, 429954),
((SELECT id FROM states WHERE code = 'MN'), 'St. Paul', 'st-paul', 44.9537, -93.0900, 311527),
((SELECT id FROM states WHERE code = 'MN'), 'Rochester', 'rochester-mn', 44.0121, -92.4802, 121395),
((SELECT id FROM states WHERE code = 'MN'), 'Duluth', 'duluth', 46.7867, -92.1005, 90936),

-- South Carolina (4 cities)
((SELECT id FROM states WHERE code = 'SC'), 'Charleston', 'charleston', 32.7765, -79.9311, 150227),
((SELECT id FROM states WHERE code = 'SC'), 'Columbia', 'columbia-sc', 34.0007, -81.0348, 136632),
((SELECT id FROM states WHERE code = 'SC'), 'North Charleston', 'north-charleston', 32.8546, -79.9748, 115382),
((SELECT id FROM states WHERE code = 'SC'), 'Greenville', 'greenville', 34.8526, -82.3940, 72095),

-- Alabama (4 cities)
((SELECT id FROM states WHERE code = 'AL'), 'Birmingham', 'birmingham', 33.5207, -86.8025, 200733),
((SELECT id FROM states WHERE code = 'AL'), 'Montgomery', 'montgomery', 32.3792, -86.3077, 200603),
((SELECT id FROM states WHERE code = 'AL'), 'Huntsville', 'huntsville', 34.7304, -86.5861, 215006),
((SELECT id FROM states WHERE code = 'AL'), 'Mobile', 'mobile', 30.6954, -88.0399, 187041),

-- Louisiana (4 cities)
((SELECT id FROM states WHERE code = 'LA'), 'New Orleans', 'new-orleans', 29.9511, -90.0715, 383997),
((SELECT id FROM states WHERE code = 'LA'), 'Baton Rouge', 'baton-rouge', 30.4515, -91.1871, 227470),
((SELECT id FROM states WHERE code = 'LA'), 'Shreveport', 'shreveport', 32.5252, -93.7502, 187593),
((SELECT id FROM states WHERE code = 'LA'), 'Lafayette', 'lafayette', 30.2241, -92.0198, 126185),

-- Kentucky (4 cities)
((SELECT id FROM states WHERE code = 'KY'), 'Louisville', 'louisville', 38.2527, -85.7585, 633045),
((SELECT id FROM states WHERE code = 'KY'), 'Lexington', 'lexington', 38.0406, -84.5037, 322570),
((SELECT id FROM states WHERE code = 'KY'), 'Bowling Green', 'bowling-green', 36.9685, -86.4808, 78268),
((SELECT id FROM states WHERE code = 'KY'), 'Owensboro', 'owensboro', 37.7719, -87.1112, 60183),

-- Oregon (4 cities)
((SELECT id FROM states WHERE code = 'OR'), 'Portland', 'portland', 45.5152, -122.6784, 652503),
((SELECT id FROM states WHERE code = 'OR'), 'Salem', 'salem', 44.9429, -123.0351, 175535),
((SELECT id FROM states WHERE code = 'OR'), 'Eugene', 'eugene', 44.0521, -123.0868, 176654),
((SELECT id FROM states WHERE code = 'OR'), 'Gresham', 'gresham', 45.5001, -122.4302, 114247),

-- Oklahoma (4 cities)
((SELECT id FROM states WHERE code = 'OK'), 'Oklahoma City', 'oklahoma-city', 35.4676, -97.5164, 681054),
((SELECT id FROM states WHERE code = 'OK'), 'Tulsa', 'tulsa', 36.1540, -95.9928, 413066),
((SELECT id FROM states WHERE code = 'OK'), 'Norman', 'norman', 35.2226, -97.4395, 128026),
((SELECT id FROM states WHERE code = 'OK'), 'Broken Arrow', 'broken-arrow', 36.0609, -95.7975, 113540),

-- Connecticut (4 cities)
((SELECT id FROM states WHERE code = 'CT'), 'Bridgeport', 'bridgeport', 41.1865, -73.1952, 148529),
((SELECT id FROM states WHERE code = 'CT'), 'New Haven', 'new-haven', 41.3083, -72.9279, 134023),
((SELECT id FROM states WHERE code = 'CT'), 'Hartford', 'hartford', 41.7658, -72.6734, 121054),
((SELECT id FROM states WHERE code = 'CT'), 'Stamford', 'stamford', 41.0534, -73.5387, 135470),

-- Utah (4 cities)
((SELECT id FROM states WHERE code = 'UT'), 'Salt Lake City', 'salt-lake-city', 40.7608, -111.8910, 199723),
((SELECT id FROM states WHERE code = 'UT'), 'West Valley City', 'west-valley-city', 40.6916, -112.0011, 140230),
((SELECT id FROM states WHERE code = 'UT'), 'Provo', 'provo', 40.2338, -111.6585, 115162),
((SELECT id FROM states WHERE code = 'UT'), 'West Jordan', 'west-jordan', 40.6097, -111.9391, 116961),

-- Nevada (4 cities)
((SELECT id FROM states WHERE code = 'NV'), 'Las Vegas', 'las-vegas', 36.1699, -115.1398, 641903),
((SELECT id FROM states WHERE code = 'NV'), 'Henderson', 'henderson', 36.0395, -114.9817, 320189),
((SELECT id FROM states WHERE code = 'NV'), 'Reno', 'reno', 39.5296, -119.8138, 264165),
((SELECT id FROM states WHERE code = 'NV'), 'North Las Vegas', 'north-las-vegas', 36.1989, -115.1175, 262527),

-- Arkansas (3 cities)
((SELECT id FROM states WHERE code = 'AR'), 'Little Rock', 'little-rock', 34.7465, -92.2896, 202591),
((SELECT id FROM states WHERE code = 'AR'), 'Fort Smith', 'fort-smith', 35.3859, -94.3985, 89142),
((SELECT id FROM states WHERE code = 'AR'), 'Fayetteville', 'fayetteville-ar', 36.0822, -94.1719, 93949),

-- Mississippi (3 cities)
((SELECT id FROM states WHERE code = 'MS'), 'Jackson', 'jackson', 32.2988, -90.1848, 153701),
((SELECT id FROM states WHERE code = 'MS'), 'Gulfport', 'gulfport', 30.3674, -89.0928, 72926),
((SELECT id FROM states WHERE code = 'MS'), 'Southaven', 'southaven', 34.9889, -90.0126, 55026),

-- Kansas (3 cities)
((SELECT id FROM states WHERE code = 'KS'), 'Wichita', 'wichita', 37.6872, -97.3301, 397532),
((SELECT id FROM states WHERE code = 'KS'), 'Overland Park', 'overland-park', 38.9822, -94.6708, 197238),
((SELECT id FROM states WHERE code = 'KS'), 'Kansas City', 'kansas-city-ks', 39.1142, -94.6275, 156607),

-- New Mexico (3 cities)
((SELECT id FROM states WHERE code = 'NM'), 'Albuquerque', 'albuquerque', 35.0844, -106.6504, 564559),
((SELECT id FROM states WHERE code = 'NM'), 'Las Cruces', 'las-cruces', 32.3199, -106.7637, 111385),
((SELECT id FROM states WHERE code = 'NM'), 'Rio Rancho', 'rio-rancho', 35.2328, -106.6630, 104046),

-- Nebraska (3 cities)
((SELECT id FROM states WHERE code = 'NE'), 'Omaha', 'omaha', 41.2565, -95.9345, 486051),
((SELECT id FROM states WHERE code = 'NE'), 'Lincoln', 'lincoln', 40.8136, -96.7026, 291082),
((SELECT id FROM states WHERE code = 'NE'), 'Bellevue', 'bellevue-ne', 41.1544, -95.8908, 63922),

-- Idaho (3 cities)
((SELECT id FROM states WHERE code = 'ID'), 'Boise', 'boise', 43.6150, -116.2023, 235684),
((SELECT id FROM states WHERE code = 'ID'), 'Meridian', 'meridian', 43.6121, -116.3915, 117635),
((SELECT id FROM states WHERE code = 'ID'), 'Nampa', 'nampa', 43.5407, -116.5635, 100200),

-- West Virginia (3 cities)
((SELECT id FROM states WHERE code = 'WV'), 'Charleston', 'charleston-wv', 38.3498, -81.6326, 48006),
((SELECT id FROM states WHERE code = 'WV'), 'Huntington', 'huntington', 38.4192, -82.4452, 46842),
((SELECT id FROM states WHERE code = 'WV'), 'Morgantown', 'morgantown', 39.6295, -79.9559, 30955),

-- Hawaii (3 cities)
((SELECT id FROM states WHERE code = 'HI'), 'Honolulu', 'honolulu', 21.3069, -157.8583, 350964),
((SELECT id FROM states WHERE code = 'HI'), 'Pearl City', 'pearl-city', 21.3972, -157.9753, 47698),
((SELECT id FROM states WHERE code = 'HI'), 'Hilo', 'hilo', 19.7074, -155.0847, 45703),

-- New Hampshire (3 cities)
((SELECT id FROM states WHERE code = 'NH'), 'Manchester', 'manchester', 42.9956, -71.4548, 115644),
((SELECT id FROM states WHERE code = 'NH'), 'Nashua', 'nashua', 42.7654, -71.4676, 91322),
((SELECT id FROM states WHERE code = 'NH'), 'Concord', 'concord-nh', 43.2081, -71.5376, 43976),

-- Maine (3 cities)
((SELECT id FROM states WHERE code = 'ME'), 'Portland', 'portland-me', 43.6591, -70.2568, 68408),
((SELECT id FROM states WHERE code = 'ME'), 'Lewiston', 'lewiston', 44.1004, -70.2148, 37121),
((SELECT id FROM states WHERE code = 'ME'), 'Bangor', 'bangor', 44.8016, -68.7712, 31753),

-- Montana (3 cities)
((SELECT id FROM states WHERE code = 'MT'), 'Billings', 'billings', 45.7833, -108.5007, 117116),
((SELECT id FROM states WHERE code = 'MT'), 'Missoula', 'missoula', 46.8721, -114.0130, 75516),
((SELECT id FROM states WHERE code = 'MT'), 'Great Falls', 'great-falls', 47.5002, -111.3008, 60442),

-- Rhode Island (3 cities)
((SELECT id FROM states WHERE code = 'RI'), 'Providence', 'providence', 41.8240, -71.4128, 190934),
((SELECT id FROM states WHERE code = 'RI'), 'Cranston', 'cranston', 41.7798, -71.4373, 82934),
((SELECT id FROM states WHERE code = 'RI'), 'Warwick', 'warwick', 41.7001, -71.4162, 82823),

-- Delaware (3 cities)
((SELECT id FROM states WHERE code = 'DE'), 'Wilmington', 'wilmington', 39.7391, -75.5398, 70898),
((SELECT id FROM states WHERE code = 'DE'), 'Dover', 'dover', 39.1582, -75.5244, 39403),
((SELECT id FROM states WHERE code = 'DE'), 'Newark', 'newark-de', 39.6837, -75.7497, 33698),

-- South Dakota (3 cities)
((SELECT id FROM states WHERE code = 'SD'), 'Sioux Falls', 'sioux-falls', 43.5446, -96.7311, 192517),
((SELECT id FROM states WHERE code = 'SD'), 'Rapid City', 'rapid-city', 44.0805, -103.2310, 77503),
((SELECT id FROM states WHERE code = 'SD'), 'Aberdeen', 'aberdeen', 45.4647, -98.4865, 28324),

-- North Dakota (3 cities)
((SELECT id FROM states WHERE code = 'ND'), 'Fargo', 'fargo', 46.8772, -96.7898, 125990),
((SELECT id FROM states WHERE code = 'ND'), 'Bismarck', 'bismarck', 46.8083, -100.7837, 73529),
((SELECT id FROM states WHERE code = 'ND'), 'Grand Forks', 'grand-forks', 47.9253, -97.0329, 56588),

-- Alaska (3 cities)
((SELECT id FROM states WHERE code = 'AK'), 'Anchorage', 'anchorage', 61.2181, -149.9003, 291247),
((SELECT id FROM states WHERE code = 'AK'), 'Fairbanks', 'fairbanks', 64.8378, -147.7164, 32325),
((SELECT id FROM states WHERE code = 'AK'), 'Juneau', 'juneau', 58.3005, -134.4197, 32255),

-- District of Columbia
((SELECT id FROM states WHERE code = 'DC'), 'Washington', 'washington-dc', 38.9072, -77.0369, 689545),

-- Vermont (3 cities)
((SELECT id FROM states WHERE code = 'VT'), 'Burlington', 'burlington', 44.4759, -73.2121, 44743),
((SELECT id FROM states WHERE code = 'VT'), 'South Burlington', 'south-burlington', 44.4669, -73.1710, 20292),
((SELECT id FROM states WHERE code = 'VT'), 'Rutland', 'rutland', 43.6106, -72.9726, 15807),

-- Wyoming (3 cities)
((SELECT id FROM states WHERE code = 'WY'), 'Cheyenne', 'cheyenne', 41.1400, -104.8202, 65132),
((SELECT id FROM states WHERE code = 'WY'), 'Casper', 'casper', 42.8666, -106.3131, 58619),
((SELECT id FROM states WHERE code = 'WY'), 'Laramie', 'laramie', 41.3114, -105.5911, 32158),

-- Iowa (3 cities)
((SELECT id FROM states WHERE code = 'IA'), 'Des Moines', 'des-moines', 41.5868, -93.6250, 214133),
((SELECT id FROM states WHERE code = 'IA'), 'Cedar Rapids', 'cedar-rapids', 41.9779, -91.6656, 137710),
((SELECT id FROM states WHERE code = 'IA'), 'Davenport', 'davenport', 41.5236, -90.5776, 101724);
