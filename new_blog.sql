-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2024 at 07:39 PM
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
-- Database: `new_blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `comment`, `date`) VALUES
(1, 4, 1, 'very nice!', '2024-10-10 19:51:36'),
(2, 4, 2, 'It\'s very good to see this', '2024-10-10 19:58:33'),
(5, 7, 5, 'Inspiring!!', '2024-10-11 19:23:48'),
(7, 8, 5, 'Very helpful, thanks for sharing!', '2024-10-12 10:52:15');

-- --------------------------------------------------------

--
-- Table structure for table `likes_dislikes`
--

CREATE TABLE `likes_dislikes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `action` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes_dislikes`
--

INSERT INTO `likes_dislikes` (`id`, `user_id`, `post_id`, `action`) VALUES
(6, 2, 4, 'like'),
(7, 3, 4, 'like'),
(8, 4, 4, 'dislike'),
(10, 1, 4, 'like'),
(13, 1, 7, 'like'),
(14, 1, 6, 'like'),
(15, 1, 5, 'dislike'),
(16, 5, 7, 'like'),
(17, 5, 6, 'dislike'),
(18, 5, 5, 'like'),
(19, 5, 4, 'like'),
(20, 3, 8, 'like'),
(21, 3, 7, 'dislike'),
(22, 3, 6, 'like'),
(23, 3, 5, 'like'),
(24, 3, 9, 'like'),
(25, 4, 10, 'like'),
(28, 5, 8, 'like'),
(30, 6, 10, 'dislike');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author` varchar(100) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `dislikes` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `author`, `date`, `image`, `likes`, `dislikes`) VALUES
(4, 'Discovering the Enchanting Backwaters of Kerala', 'Kerala, often referred to as God\'s Own Country, is a tropical paradise known for its lush landscapes, tranquil backwaters, and rich cultural heritage. Nestled along the southwestern coast of India, this idyllic state offers a unique blend of stunning natural beauty and vibrant traditions. The backwaters of Alleppey, dotted with charming houseboats, provide a serene escape as you glide through palm-fringed canals and witness the local life unfold along the water\'s edge. Kerala\'s hill stations, such as Munnar, offer breathtaking views of rolling tea plantations and mist-covered mountains, inviting adventure enthusiasts to explore trekking trails and waterfalls. The state\'s rich cultural tapestry is woven into its festivals, like Onam, where vibrant celebrations showcase traditional music, dance, and sumptuous feasts. Don\'t miss the opportunity to savor Kerala\'s culinary delights, from spicy seafood dishes to the famous banana chips. With its Ayurveda retreats promoting holistic wellness, Kerala is not just a destination; it\'s a rejuvenating journey that nourishes the body and soul, leaving visitors enchanted and longing to return.', 'Aarti N', '2024-10-10 18:25:10', 'kerala.jpg', 4, 1),
(5, 'Wanderlust Adventures: Top 10 Hidden Gems to Explore in India', 'India is a land of breathtaking landscapes and diverse cultures, yet some of its most beautiful destinations remain under the radar. Hidden gems like Spiti Valley, located in the northern Himalayan region of Himachal Pradesh, offer stunning views of snow-capped mountains and a unique Tibetan culture. The ancient monasteries perched on cliff sides, such as Key Monastery and Tabo Monastery, provide spiritual solace and a glimpse into the region\'s rich history. Another hidden gem, Ziro Valley in Arunachal Pradesh, is famous for its lush rice fields and the indigenous Apatani tribe. The valley is also known for the Ziro Music Festival, where visitors can immerse themselves in local music and culture amid breathtaking natural beauty.\r\n\r\nExploring these lesser-known destinations not only allows for a more intimate travel experience but also supports local economies. By venturing off the beaten path, travelers can engage with local communities, taste authentic cuisine, and experience traditions that may not be found in tourist hotspots. Other notable hidden gems include Tawang, famous for its stunning monasteries and landscapes, and Khajjiar, often referred to as the “Mini Switzerland of India” due to its rolling meadows and pine forests. These destinations promise unforgettable adventures and a deeper connection to India’s cultural tapestry.', 'User1', '2024-10-11 16:57:18', 'ladakh.jpg', 2, 1),
(6, 'Culinary Journeys: Exploring the Flavors of India', 'India’s culinary landscape is as diverse as its culture, making it a paradise for food lovers. From the spicy street foods of Delhi to the aromatic biryanis of Hyderabad, each region boasts its own unique flavors and culinary traditions. In Delhi, indulge in local favorites such as chaat, a savory snack made from potatoes, chickpeas, and tangy chutneys, or savor a plate of butter chicken paired with naan. Don’t miss the vibrant food markets, where the aromas of freshly prepared dishes beckon you to try everything from sweet jalebis to savory pakoras.\r\n\r\nIn contrast, the coastal city of Kolkata is renowned for its sweets and fish dishes. Experience the rich flavors of Bengali cuisine with dishes like macher jhol (fish curry) and the delectable rasgulla (syrup-soaked cheese balls). Joining a cooking class can further enhance your culinary journey, allowing you to learn the secrets behind these iconic dishes. By exploring India’s food scene, you not only satisfy your taste buds but also gain insight into the country’s rich cultural heritage and the stories behind each dish.', 'User2', '2024-10-11 17:05:20', 'pexels-marion-pintaux-1381717-2670327.jpg', 2, 1),
(7, 'The Ultimate Guide to Solo Travel: Embrace Your Journey in India', 'Embarking on a solo journey through India can be one of the most enriching experiences of your life. The country is a tapestry of vibrant cultures, ancient history, and breathtaking landscapes, making it an ideal destination for solo travelers. Cities like Varanasi, with its mesmerizing ghats along the Ganges River, offer a unique spiritual experience that encourages self-reflection and mindfulness. As you wander through the narrow alleyways, you\'ll encounter colorful markets, local artisans, and spiritual practices that make the city feel alive. The warmth and hospitality of the locals often make it easy to strike up conversations, helping you connect with the culture on a deeper level.\r\n\r\nTraveling solo in India also provides the freedom to create your own itinerary. From the serene backwaters of Kerala to the majestic forts of Rajasthan, you can choose experiences that resonate with you personally. Many hostels and guesthouses cater specifically to solo travelers, offering shared spaces and organized activities, making it easy to meet like-minded individuals. Moreover, the extensive train network allows you to explore various regions safely and efficiently. With a little planning and an open mind, your solo adventure in India can lead to unforgettable memories and newfound friendships.', 'Shraddha', '2024-10-11 17:14:12', 'shutterstock_425416219_jlva28.jpg', 2, 1),
(8, 'Family Travel: Tips for Planning a Memorable Vacation in Rajasthan', 'Rajasthan, with its majestic forts, vibrant culture, and rich history, is an excellent destination for family vacations. Cities like Jaipur and Udaipur offer a plethora of activities that cater to all ages. In Jaipur, families can explore the iconic Amer Fort, where kids can enjoy elephant rides while learning about the royal history of the region. The interactive exhibits at the Jaipur Wax Museum and the colorful bazaars filled with handicrafts create a fun and educational experience for the entire family.\r\n\r\nIn Udaipur, families can take a boat ride on Lake Pichola, visiting the stunning Jag Mandir Palace, which offers picturesque views and plenty of photo opportunities. Moreover, Rajasthan’s festivals, such as the Pushkar Camel Fair, provide unique cultural experiences that the whole family can enjoy together. By incorporating local traditions, interactive activities, and family-friendly accommodations, a trip to Rajasthan can become an unforgettable adventure that strengthens family bonds while exploring the beauty of India.', 'User3', '2024-10-11 19:22:24', 'Rajasthan.jpg', 2, 0),
(9, 'Cultural Etiquette: Navigating Local Customs in South India', 'South India is renowned for its rich cultural heritage, and understanding local customs is essential for travelers looking to immerse themselves in the experience. In cities like Madurai, where the historic Meenakshi Temple stands, visitors should dress modestly and respect the customs of worship. It\'s important to remove your shoes before entering temples and to follow any specific rituals or guidelines. Engaging with locals and showing respect for their traditions can lead to enriching interactions and memorable experiences.\r\n\r\nAdditionally, in regions like Coorg, known for its coffee plantations and breathtaking landscapes, understanding the local practice of hospitality is vital. Coorgi families are known for their warmth and generosity, often inviting travelers to enjoy a cup of freshly brewed coffee. Being polite, greeting locals with a smile, and learning a few basic phrases in the local language can go a long way in fostering positive connections. By embracing cultural etiquette, travelers can deepen their understanding of South India’s diverse heritage and create meaningful connections with the people they meet along the way.', 'user1', '2024-10-11 19:33:47', 'South-India-Temple-Tour-Packages.jpg', 1, 0),
(10, 'Adventure Awaits: Top Outdoor Activities in Uttarakhand', 'For outdoor enthusiasts, Uttarakhand is a paradise brimming with adventure. The state offers an array of exciting activities amidst some of India’s most dramatic landscapes. Auli, known for its world-class skiing slopes, is a must-visit for winter sports lovers. During the snow season, visitors can enjoy skiing and snowboarding against the stunning backdrop of the Nanda Devi and Nar Parvat mountains. Auli is also great for hiking during the summer months, with trails leading to scenic vistas and the pristine alpine meadows of Gorson Bugyal.\r\n\r\nFor water-based adventures, Rishikesh is the undisputed hub of white-water rafting in India. Brave the rapids of the Ganges River while soaking in the surrounding beauty of the Himalayan foothills. Rishikesh also offers bungee jumping, zip-lining, and trekking, making it an adventure hotspot for thrill-seekers. For a more serene experience, take to the hills and explore the trekking routes in Har Ki Dun valley, where lush forests and rivers provide the perfect setting for camping and nature walks. Uttarakhand’s wide range of outdoor activities ensures there’s something for every type of adventurer, whether you\'re looking for an adrenaline rush or a tranquil escape.', 'Shraddha', '2024-10-11 19:36:30', 'rishikesh-scaled.jpg', 1, 1),
(12, 'Spiritual Journeys: Discovering India’s Sacred Sites', 'India is a land steeped in spirituality, with sacred sites that draw seekers from around the globe. One of the most revered destinations is Varanasi, often referred to as the spiritual capital of India. The ancient city is home to the Ganges River, where pilgrims come to perform rituals and cleanse themselves in its holy waters. Witnessing the mesmerizing Ganga Aarti, a nightly ceremony of lights and chants, offers a profound experience that encapsulates the spiritual essence of Varanasi. Exploring the narrow, winding lanes lined with temples, ashrams, and ghats reveals a city where every corner holds a story, making it an essential pilgrimage for those seeking spiritual enlightenment.\r\n\r\nAnother significant spiritual destination is Rishikesh, known for its yoga and meditation retreats. Nestled in the foothills of the Himalayas, Rishikesh is often called the “Yoga Capital of the World.” Visitors can participate in various yoga classes, meditation sessions, and wellness workshops designed to rejuvenate the mind, body, and spirit. The serene environment, coupled with the sacred Ganges River flowing alongside, creates an ideal setting for spiritual reflection and personal growth. Rishikesh’s vibrant atmosphere, infused with the teachings of ancient Indian wisdom, encourages travelers to embark on their own spiritual journey, leaving them with a deeper understanding of themselves and the universe.', 'user5', '2024-10-17 11:04:29', '107497203.webp', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'Shraddha', '123@gmail.com', 'blog27'),
(2, 'Aarti N', 'aartin@gmail.com', 'blog1'),
(3, 'user1', 'user1@gmail.com', 'User1'),
(4, 'user2', 'user2@gmail.com', 'User2'),
(5, 'User3', 'user3@gmail.com', 'user3'),
(6, 'user5', 'user5@gmail.com', 'user5');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `likes_dislikes`
--
ALTER TABLE `likes_dislikes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `likes_dislikes`
--
ALTER TABLE `likes_dislikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `likes_dislikes`
--
ALTER TABLE `likes_dislikes`
  ADD CONSTRAINT `likes_dislikes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `likes_dislikes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
