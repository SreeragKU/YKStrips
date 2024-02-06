-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2024 at 12:43 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ykstrips_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `icon_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `icon_path`) VALUES
(1, 'Kerala', 'icons/Kerala (1).png'),
(2, 'Lakshadweep', 'icons/Lakshadweep (1).png'),
(3, 'Manali', 'icons/Manali (1).png'),
(4, 'Rajasthan', 'icons/output-onlinepngtools.png'),
(5, 'Golden Triangle', 'icons/Golden triangle (1).png');

-- --------------------------------------------------------

--
-- Table structure for table `packagedetails`
--

CREATE TABLE `packagedetails` (
  `id` int(11) NOT NULL,
  `package_name` varchar(255) NOT NULL,
  `no_of_days` int(11) NOT NULL,
  `package_description` text NOT NULL,
  `locations` varchar(255) NOT NULL,
  `package_price` decimal(10,2) NOT NULL,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `overview` text NOT NULL,
  `highlight` text NOT NULL,
  `accommodation` text DEFAULT NULL,
  `meals` text DEFAULT NULL,
  `transportation` text DEFAULT NULL,
  `itinerary` text NOT NULL,
  `cost_includes` text NOT NULL,
  `cost_excludes` text NOT NULL,
  `faqs` text NOT NULL,
  `map_link` varchar(255) NOT NULL,
  `package_image` varchar(255) NOT NULL,
  `trending` tinyint(1) NOT NULL DEFAULT 0,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `packagedetails`
--

INSERT INTO `packagedetails` (`id`, `package_name`, `no_of_days`, `package_description`, `locations`, `package_price`, `discount_price`, `overview`, `highlight`, `accommodation`, `meals`, `transportation`, `itinerary`, `cost_includes`, `cost_excludes`, `faqs`, `map_link`, `package_image`, `trending`, `category_id`) VALUES
(1, 'Golden Triangle', 6, 'Golden Triangle', 'AGRA, DELHI, JAIPUR', 25000.00, 15899.00, 'Embark on a spectacular 5-day, 4-night Golden Triangle odyssey, commencing in the dynamic capital, Delhi! 🌆 Dive into a rich tapestry of history on Day 1 and Day 2, exploring iconic landmarks like India Gate. 🏰 Day 3 leads you to the timeless beauty of Agra, where the majestic Taj Mahal beckons. 🕌 Conclude your journey in the regal hues of Jaipur on Days 4 and 5, immersing yourself in the grandeur of palaces and the vibrant bazaars. 🏰✨ #GoldenTriangleGetaway #DelhiToJaipur #TimelessTaj', 'Taj Mahal Marvel, Royal Jaipur Delights, Amber Fort Extravaganza, Delhi Fusion, Culinary Odyssey', 'Classic 3 Star Hotel', 'Breakfast & Dinner', 'Basic sedan or hatchback with standard seating capacity.', 'a:2:{i:0;a:2:{s:5:\"title\";s:16:\"Arrival in Delhi\";s:11:\"description\";s:54:\"Delhi airport or railway station, Transfer, Freshen up\";}i:1;a:2:{s:5:\"title\";s:17:\"Delhi Sightseeing\";s:11:\"description\";s:41:\"Visit Humayun\'s Tomb, Explore Qutab Minar\";}}', 'Transportation: Cost of pickup and drop from the bus stand, Local Transportation: Expenses for cab or taxi services during the trip, Meals: Budget for dinner and breakfast for each participant.', 'Personal Expenses: Individual spending on personal items or activities, Entertainment: Expenses for recreational activities or attractions, Tips and Gratuities: Additional money for tipping service providers.', 'a:2:{i:0;a:2:{s:8:\"question\";s:48:\"How can I secure entry tickets to the Taj Mahal?\";s:6:\"answer\";s:107:\"Purchase tickets online or at the counters; buying in advance is advisable, especially during peak seasons.\";}i:1;a:2:{s:8:\"question\";s:30:\"What is the best time to visit\";s:6:\"answer\";s:167:\"The ideal time to explore the Golden Triangle is during the winter months from October to March when the weather is pleasantly cool, making sightseeing more enjoyable.\";}}', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d118171.45491877178!2d78.07238916762054!3d27.20125503802054!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39740d857c2f41d9%3A0x784aef38a9523b42!2sAgra%2C%20Uttar%20Pradesh!5e0!3m2!1sen!2sin!4v17068451', 'upload/destination-1.jpg', 1, 5),
(2, 'Kerala 7D6N', 7, 'Kerala ', 'ALLEPPEY, ATHIRAPALLY, KOVALAM, MUNNAR, THEKADY, VARKALA', 40000.00, 24899.00, 'Embark on a captivating 7-day, 6-night escapade through the diverse landscapes of Kerala, commencing with the awe-inspiring Athirapilly Falls on Day 1. 🌊 Day 2 invites you to the misty hills of Munnar, followed by a thrilling visit to the highest tea plantation at Kolukkumalai on Day 3. 🌄 Explore the wildlife haven of Thekkady on Day 4, cruise the serene backwaters of Alleppey on Day 5, unwind on the golden beaches of Varkala on Day 6, and conclude your journey in the tropical paradise of Kovalam on Day 7. 🏞️✨ Immerse yourself in the rich tapestry of Kerala’s natural beauty and cultural allure. #KeralaDiscovery #TropicalEscape #NatureAndCulture', 'Athirapilly Falls Marvel🌊, CultuCoastal Charm in Varkala 🏖️🌊, Backwater Bliss in Alleppey🚤🌅, Tea Wonderland at Kolukkumalai🍵🏞️, Mystical Munnar Moments 🌲🌄', 'Classic 3 Star Hotel', 'Breakfast & Dinner', 'Basic sedan or hatchback with standard seating capacity.', 'a:2:{i:0;a:2:{s:5:\"title\";s:17:\"Arrival in Kerala\";s:11:\"description\";s:29:\"Airport or Railway, breakfast\";}i:1;a:2:{s:5:\"title\";s:14:\"Explore Munnar\";s:11:\"description\";s:22:\"Breakfast, tea gardens\";}}', 'Transportation: Cost of pickup and drop from the bus stand, Local Transportation: Expenses for cab or taxi services during the trip, Meals: Budget for dinner and breakfast for each participant.', 'Personal Expenses: Individual spending on personal items or activities, Entertainment: Expenses for recreational activities or attractions, Tips and Gratuities: Additional money for tipping service providers.', 'a:2:{i:0;a:2:{s:8:\"question\";s:49:\"What is the best time to visit Athirapilly Falls?\";s:6:\"answer\";s:136:\"The best time to visit Athirapilly Falls is during the post-monsoon season from September to January when the water flow is at its peak.\";}i:1;a:2:{s:8:\"question\";s:46:\"What are the must-visit attractions in Cochin?\";s:6:\"answer\";s:154:\"Cochin is known for the historic Fort Kochi, Mattancherry Palace, Chinese Fishing Nets, and the lively Jew Town, making it a cultural hub worth exploring.\";}}', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d31425.2244894961!2d77.07176!3d10.086542!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b0799794d099a6d%3A0x63250e5553c7e0c!2sMunnar%2C%20Kerala%20685612!5e0!3m2!1sen!2sin!4v1706845628746!5m2!1sen!2si', 'upload/destination-3.jpg', 1, 1),
(3, 'Varanasi 4d3n', 4, 'Varanasi 4d3n', 'PRAYAGRAJ, VARANASI', 22000.00, 12899.00, 'Embark on an exhilarating 4-day, 3-night Varanasi commencing in the spiritual heart of Prayagraj! 🌅 Immerse yourself in the divine aura on Day 1, where the confluence of rivers holds sacred significance. 🙏 Day 2 unfolds the enchanting mystique of Varanasi, India’s spiritual capital, while Day 3 invites exploration of Sarnath’s Buddhist heritage. 🏛️ Conclude your journey on Day 4, rediscovering the timeless charm of Varanasi’s ghats, temples, and vibrant culture. 🕊️✨ #GoldenTriangleSpirituality #PrayagrajToVaranasi #SarnathDiscovery', 'Sacred Confluence in Prayagraj🌊🙏, Buddhist Bliss in Sarnath 🏛️🕊️, Enchanting Ganga Aarti 🕯️🎶, Varanasi\'s Temples and Alleys 🏰🚶\r\nCultural Tapestry Delights 🛍️🍲', 'Classic 3 Star Hotel', 'Breakfast & Dinner', 'Basic sedan or hatchback with standard seating capacity.', 'a:2:{i:0;a:2:{s:5:\"title\";s:20:\"Arrival in Prayagraj\";s:11:\"description\";s:44:\"Prayagraj Railway Station, Arrival, Transfer\";}i:1;a:2:{s:5:\"title\";s:18:\"Travel to Varanasi\";s:11:\"description\";s:27:\"Breakfast, Varanasi Explore\";}}', 'Transportation: Cost of pickup and drop from the bus stand, Local Transportation: Expenses for cab or taxi services during the trip, Meals: Budget for dinner and breakfast for each participant.', 'Personal Expenses: Individual spending on personal items or activities, Entertainment: Expenses for recreational activities or attractions, Tips and Gratuities: Additional money for tipping service providers.', 'a:1:{i:0;a:2:{s:8:\"question\";s:50:\"What makes the Ganges Sunrise in Varanasi Special?\";s:6:\"answer\";s:178:\"The Ganges Sunrise in Varanasi is a spiritual spectacle, where the rising sun bathes the city and its iconic ghats in a divine light, creating a serene and enchanting atmosphere.\";}}', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d230816.44744362775!2d82.991109!3d25.320763!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x398e2db76febcf4d%3A0x68131710853ff0b5!2sVaranasi%2C%20Uttar%20Pradesh!5e0!3m2!1sen!2sin!4v1706845913134!5m2!1s', 'upload/destination-4.jpg', 1, NULL),
(4, 'Rajasthan', 5, 'Rajasthan', 'JAISALMER, JODHPUR, UDAIPUR', 25000.00, 16899.00, 'Embark on a captivating 5-day odyssey through the enchanting landscapes of Rajasthan! Days 1 and 2 beckon you to the romantic allure of Udaipur, where the shimmering Lake Pichola and the grandeur of City Palace set the stage for an unforgettable royal experience. On Day 3, venture into the golden city of Jaisalmer, exploring the majestic Golden Fort and immersing yourself in the vibrant culture of the Thar Desert. As the journey continues on Day 4, discover the ornate Havelis and lively markets of Jaisalmer. Concluding on Day 5 in Jodhpur, witness the towering Mehrangarh Fort and savor the rich tapestry of Rajasthan’s history and charm. 🏰🌅🏜️ #RajasthanRoyalty #UdaipurJaisalmerJodhpurMagic', 'Majestic Lake Pichola Boat Cruise, Journey into Jag Mandir\'s Elegance, Golden Fort Majesty, Thar Desert Safari & Camel Ride, Mehrangarh Fort Panorama', 'Classic 3 Star Hotel', 'Breakfast & Dinner', 'Basic sedan or hatchback with standard seating capacity.', 'a:2:{i:0;a:2:{s:5:\"title\";s:15:\"Udaipur Arrival\";s:11:\"description\";s:95:\"Pick up from Udaipur Railway Station or Airport, Transfer to the hotel, Check-in and freshen up\";}i:1;a:2:{s:5:\"title\";s:19:\"Udaipur Sightseeing\";s:11:\"description\";s:98:\"Morning: Visit Bahubali Hill, Visit Sajjangarh Monsoon Palace, Saheliyon Ki Bari, Fateh Sagar Lake\";}}', 'Transportation: Cost of pickup and drop from the bus stand, Local Transportation: Expenses for cab or taxi services during the trip, Meals: Budget for dinner and breakfast for each participant.', 'Personal Expenses: Individual spending on personal items or activities, Entertainment: Expenses for recreational activities or attractions, Tips and Gratuities: Additional money for tipping service providers', 'a:1:{i:0;a:2:{s:8:\"question\";s:50:\"How long is the Lake Pichola Boat Cruise on Day 1?\";s:6:\"answer\";s:159:\"The boat cruise typically lasts around 1 to 1.5 hours, providing ample time to enjoy the picturesque views of City Palace and experience the enchanting sunset.\";}}', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d116078.29291715489!2d73.704872!3d24.608286!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3967e56550a14411%3A0xdbd8c28455b868b0!2sUdaipur%2C%20Rajasthan!5e0!3m2!1sen!2sin!4v1706846109410!5m2!1sen!2sin', 'upload/destination-2.jpg', 1, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packagedetails`
--
ALTER TABLE `packagedetails`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `packagedetails`
--
ALTER TABLE `packagedetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
