-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2026 at 01:14 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `globetrek_adv`
--

-- --------------------------------------------------------

--
-- Table structure for table `accommodations`
--

CREATE TABLE `accommodations` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `location` varchar(200) DEFAULT NULL,
  `type` enum('hotel','guesthouse','resort','villa') DEFAULT 'hotel',
  `description` text DEFAULT NULL,
  `price_per_night` decimal(10,0) NOT NULL,
  `max_guests` int(11) DEFAULT 2,
  `image` varchar(255) DEFAULT 'default.jpg',
  `amenities` text DEFAULT NULL,
  `contact_phone` varchar(50) DEFAULT NULL,
  `contact_email` varchar(100) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accommodations`
--

INSERT INTO `accommodations` (`id`, `name`, `location`, `type`, `description`, `price_per_night`, `max_guests`, `image`, `amenities`, `contact_phone`, `contact_email`, `status`, `created_at`) VALUES
(1, 'Colombo Grand Hotel', 'Colombo', 'hotel', 'Luxury hotel located in the heart of Colombo with modern facilities.', 25000, 4, 'colombo_acc.jpeg', 'Free WiFi, Pool, Gym, Breakfast', '0711111111', 'colombo@globetrek.com', 'active', '2026-05-12 15:19:06'),
(2, 'Kandy Lake Resort', 'Kandy', 'resort', 'Beautiful resort near Kandy Lake with peaceful mountain views.', 18000, 3, 'kandy_acc.jpeg', 'Free WiFi, Restaurant, Parking', '0722222222', 'kandy@globetrek.com', 'active', '2026-05-12 15:19:06'),
(3, 'Hambantota Safari Villa', 'Hambantota', 'villa', 'Comfortable villa for safari travelers and wildlife lovers.', 22000, 5, 'hamp_acc.jpeg', 'Safari Tour, Pool, Breakfast', '0733333333', 'hambantota@globetrek.com', 'active', '2026-05-12 15:19:06'),
(4, 'Jaffna Heritage Guesthouse', 'Jaffna', 'guesthouse', 'Traditional guesthouse with Northern Sri Lankan hospitality.', 12000, 2, 'jaff_acc.jpeg', 'Free WiFi, Home Food, Parking', '0744444444', 'jaffna@globetrek.com', 'active', '2026-05-12 15:19:06'),
(5, 'Kurunegala Coconut Resort', 'Kurunegala', 'resort', 'Relaxing nature resort surrounded by coconut estates.', 15000, 4, 'kurunegala_acc.jpeg', 'Pool, Garden, Breakfast', '0755555555', 'kurunegala@globetrek.com', 'active', '2026-05-12 15:19:06'),
(6, 'Nuwara Eliya Hill Hotel', 'Nuwara Eliya', 'hotel', 'Cool climate hotel with tea plantation views.', 27000, 3, 'nuwara_acc.jpeg', 'Fireplace, Tea Bar, Free WiFi', '0766666666', 'nuwara@globetrek.com', 'active', '2026-05-12 15:19:06'),
(7, 'Polonnaruwa Ancient Resort', 'Polonnaruwa', 'resort', 'Resort located close to ancient historical sites.', 20000, 4, 'polan_acc.jpeg', 'Guide Service, Pool, Restaurant', '0777777777', 'polonnaruwa@globetrek.com', 'active', '2026-05-12 15:19:06');

-- --------------------------------------------------------

--
-- Table structure for table `accommodation_transport`
--

CREATE TABLE `accommodation_transport` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `hotel_name` varchar(200) DEFAULT NULL,
  `hotel_contact` varchar(100) DEFAULT NULL,
  `hotel_status` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `transport_type` varchar(100) DEFAULT NULL,
  `transport_contact` varchar(100) DEFAULT NULL,
  `transport_status` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `coordination_notes` text DEFAULT NULL,
  `coordinated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accommodation_transport`
--

INSERT INTO `accommodation_transport` (`id`, `booking_id`, `hotel_name`, `hotel_contact`, `hotel_status`, `transport_type`, `transport_contact`, `transport_status`, `coordination_notes`, `coordinated_by`, `created_at`, `updated_at`) VALUES
(9, 4, 'Kurunegala Coconut Resort', '0755555555', 'pending', 'Van', '6870090', 'confirmed', NULL, 4, '2026-05-13 11:54:15', '2026-05-13 11:54:15');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `travel_date` date NOT NULL,
  `num_persons` int(11) NOT NULL,
  `total_price` decimal(10,0) NOT NULL,
  `special_requests` text DEFAULT NULL,
  `status` enum('pending','confirmed','completed','cancelled') DEFAULT 'pending',
  `payment_status` enum('unpaid','paid','refunded') DEFAULT 'unpaid',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `package_id`, `travel_date`, `num_persons`, `total_price`, `special_requests`, `status`, `payment_status`, `created_at`) VALUES
(1, 2, 3, '2026-05-30', 5, 310000, 'Need a good view hotel', 'confirmed', 'paid', '2026-05-12 17:00:35'),
(2, 2, 3, '2026-05-29', 3, 186000, 'Hambatota bird park', 'cancelled', 'unpaid', '2026-05-12 17:26:10'),
(3, 2, 6, '2026-06-07', 1, 55000, 'Need a good guide', 'confirmed', 'paid', '2026-05-12 23:16:55'),
(4, 5, 5, '2026-07-15', 5, 150000, '', 'confirmed', 'paid', '2026-05-13 10:21:55'),
(5, 6, 4, '2026-05-16', 7, 490000, 'Jaffna temple vists', 'cancelled', 'unpaid', '2026-05-13 12:47:56'),
(6, 6, 4, '2026-05-16', 7, 490000, 'Jaffna temple vists', 'confirmed', 'paid', '2026-05-13 12:48:02'),
(7, 6, 5, '2026-06-25', 2, 60000, 'Coconut garden', 'confirmed', 'paid', '2026-05-13 12:52:41'),
(8, 7, 7, '2026-05-28', 5, 210000, 'Neat accomadation', 'confirmed', 'paid', '2026-05-13 13:30:11'),
(9, 7, 8, '2026-07-31', 2, 80000, '', 'pending', 'unpaid', '2026-05-13 14:01:27'),
(10, 7, 6, '2026-08-11', 2, 110000, '', 'pending', 'unpaid', '2026-05-13 14:09:44'),
(11, 7, 6, '2026-08-11', 2, 110000, '', 'pending', 'unpaid', '2026-05-13 14:09:50'),
(12, 7, 6, '2026-08-11', 2, 110000, '', 'pending', 'unpaid', '2026-05-13 14:09:57'),
(13, 7, 6, '2026-08-11', 2, 110000, '', 'pending', 'unpaid', '2026-05-13 14:10:05'),
(14, 8, 7, '2026-08-10', 5, 210000, '', 'confirmed', 'paid', '2026-05-14 09:21:03'),
(15, 5, 2, '2026-05-16', 5, 190000, 'iegjreoh[lt;bt;b,tnn', 'pending', 'unpaid', '2026-05-14 11:09:46'),
(16, 5, 2, '2026-05-16', 5, 190000, 'iegjreoh[lt;bt;b,tnn', 'confirmed', 'paid', '2026-05-14 11:09:50'),
(17, 7, 8, '2026-10-20', 4, 160000, '', 'pending', 'unpaid', '2026-05-15 00:01:23'),
(18, 7, 8, '2026-10-20', 4, 160000, '', 'confirmed', 'paid', '2026-05-15 00:01:28');

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

CREATE TABLE `destinations` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `country` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`id`, `name`, `country`, `description`, `image`) VALUES
(1, 'Colombo', 'Sri Lanka', 'Srilanka\'s modern gateway.', 'colombo.jpeg'),
(2, 'Kandy', 'Sri Lanka', 'Cultural capital and home of the Sacred Tooth Relic', 'kandy.jpeg'),
(3, 'Hambantotta', 'Sri Lanka', 'WORLD OF BIRDS', 'hambantotta.jpeg'),
(4, 'Jaffna', 'Sri Lanka', 'Northern Heritage', 'jaffna.jpeg\r\n'),
(5, 'Kurunegala', 'Sri Lanka', 'Coconut Vibes', 'kurunegala.jpeg'),
(6, 'Nuwara-eliya', 'Srilanka', 'Hill Vibes.', 'Nuwara.jpeg'),
(7, 'Polannaruwa', 'Sri Lanka', 'The Kings\' place.', 'polan.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `destination` varchar(100) DEFAULT NULL,
  `destination_id` int(11) DEFAULT 100,
  `description` text DEFAULT NULL,
  `duration_days` int(11) DEFAULT NULL,
  `price` decimal(10,0) NOT NULL,
  `max_persons` int(11) DEFAULT 10,
  `image` varchar(255) DEFAULT 'default.jpg',
  `includes` text DEFAULT NULL,
  `itinerary` text DEFAULT NULL,
  `featured` tinyint(4) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `title`, `destination`, `destination_id`, `description`, `duration_days`, `price`, `max_persons`, `image`, `includes`, `itinerary`, `featured`, `status`, `created_at`) VALUES
(2, 'Kandy Heritage Tour', 'Kandy', 2, 'Visit the Temple of the Tooth Relic and explore the cultural beauty of Kandy.', 2, 38000, 8, 'packages/pkg_1778607143_6a0364273603a.jpeg', 'Hotel, Breakfast, Cultural Show', 'Day 1 - Temple Visit | Day 2 - Botanical Garden &amp;amp; Departure', 1, 'active', '2026-05-12 15:04:21'),
(3, 'Hambantota Wildlife Adventure', 'Hambantota', 3, 'Experience wildlife safaris and bird watching in Hambantota.', 4, 62000, 12, 'hamp_pac.jpeg', 'Safari, Hotel, Meals, Transport', 'Day 1 - Arrival | Day 2 - Safari | Day 3 - Bird Park | Day 4 - Departure', 0, 'active', '2026-05-12 15:04:21'),
(4, 'Jaffna Northern Escape', 'Jaffna', 4, 'Discover the unique culture, food, and beaches of Northern Sri Lanka.', 5, 70000, 10, 'jaffna_pac.jpeg', 'Hotel, Breakfast, Transport', 'Day 1 - City Tour | Day 2 - Temple Visit | Day 3 - Beach Tour | Day 4 - Food Experience | Day 5 - Departure', 0, 'active', '2026-05-12 15:04:21'),
(5, 'Kurunegala Nature Retreat', 'Kurunegala', 5, 'Relax with scenic mountain views and coconut estates in Kurunegala.', 2, 30000, 6, 'kurunegala_pac.jpeg', 'Hotel, Nature Tour, Meals', 'Day 1 - Mountain Hiking | Day 2 - Village Tour', 0, 'active', '2026-05-12 15:04:21'),
(6, 'Nuwara Eliya Hill Country Tour', 'Nuwara-eliya', 6, 'Enjoy the cool climate, tea plantations, and waterfalls of Nuwara Eliya.', 3, 55000, 9, 'nuwara_pac.jpeg', 'Hotel, Tea Factory Visit, Breakfast', 'Day 1 - Tea Estate | Day 2 - Lake & Waterfalls | Day 3 - Departure', 1, 'active', '2026-05-12 15:04:21'),
(7, 'Polonnaruwa Ancient Kingdom Tour', 'Polonnaruwa', 7, 'Explore the ancient ruins and historical temples of Polonnaruwa.', 2, 42000, 8, 'polan_pac.jpeg', 'Hotel, Guide, Transport', 'Day 1 - Ancient City Tour | Day 2 - Museum Visit & Departure', 0, 'active', '2026-05-12 15:04:21'),
(8, 'Hikkaduwa Elephent Ride', 'Colombo', 1, 'A travel diary through the Elephent world.', 2, 40000, 5, 'colombo_pac2.jpeg', 'Transport', '4d3wercrcr', 1, 'active', '2026-05-12 15:33:56'),
(10, 'Polanaruwa Vihara tour', 'Polannaruwa', 7, 'A wholesome worshiping tour aroun Polannaruwa.', 4, 22560, 9, 'packages/pkg_1778658648_6a042d58e8f7d.jpeg', 'Worshiping things', 'Day1- Gal Viharaya', 0, 'active', '2026-05-13 13:20:48');

-- --------------------------------------------------------

--
-- Table structure for table `package_accommodations`
--

CREATE TABLE `package_accommodations` (
  `id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `accommodation_id` int(11) NOT NULL,
  `nights` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `status` enum('completed','failed','refunded') DEFAULT 'completed',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `booking_id`, `user_id`, `amount`, `payment_method`, `transaction_id`, `status`, `created_at`) VALUES
(18, 1, 2, 310000, 'visa', 'GT-VI-20260512134207-06512D', 'completed', '2026-05-12 17:12:07'),
(19, 3, 2, 55000, 'visa', 'GT-VI-20260512194840-664F03', 'completed', '2026-05-12 23:18:40'),
(20, 4, 5, 150000, 'visa', 'GT-VI-20260513070300-D3947A', 'completed', '2026-05-13 10:33:00'),
(21, 6, 6, 490000, 'visa', 'GT-VI-20260513091910-BD7193', 'completed', '2026-05-13 12:49:10'),
(22, 7, 6, 60000, 'visa', 'GT-VI-20260513092352-5949DD', 'completed', '2026-05-13 12:53:52'),
(23, 8, 7, 210000, 'visa', 'GT-VI-20260513102915-5D9F5E', 'completed', '2026-05-13 13:59:15'),
(24, 14, 8, 210000, 'visa', 'GT-VI-20260514055207-5D796E', 'completed', '2026-05-14 09:22:07'),
(25, 16, 5, 190000, 'visa', 'GT-VI-20260514074139-A6E3A2', 'completed', '2026-05-14 11:11:39'),
(26, 18, 7, 160000, 'visa', 'GT-VI-20260514203301-0904ED', 'completed', '2026-05-15 00:03:01');

-- --------------------------------------------------------

--
-- Table structure for table `queries`
--

CREATE TABLE `queries` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `reply` text DEFAULT NULL,
  `status` enum('open','replied','closed') DEFAULT 'open',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `queries`
--

INSERT INTO `queries` (`id`, `user_id`, `name`, `email`, `subject`, `message`, `reply`, `status`, `created_at`) VALUES
(15, 2, 'Irine', 'prashanjaliluxman2000@gmail.com', 'Hotels', 'It looks neat and clean. But need to change the side window.', 'Thank you and noted', 'replied', '2026-05-12 23:15:24'),
(16, 5, 'Shathurshika', 'shathu@gmail.com', 'Foods', 'I need healthy foods only', NULL, 'open', '2026-05-13 10:35:07'),
(17, 7, 'Sagar', 'sagar@gmail.com', 'Accommodation', 'Need room with bright light', NULL, 'open', '2026-05-14 23:58:39');

-- --------------------------------------------------------

--
-- Table structure for table `travel_guides`
--

CREATE TABLE `travel_guides` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `destination` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `tips` text DEFAULT NULL,
  `best_time` varchar(100) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `travel_guides`
--

INSERT INTO `travel_guides` (`id`, `title`, `destination`, `content`, `tips`, `best_time`, `status`, `created_by`, `created_at`) VALUES
(3, 'Kandy Cultural Experienced', 'Kandy', 'Kandy is the cultural capital of Sri Lanka, home to the sacred Temple of the Tooth Relic. The city sits beside the picturesque Kandy Lake and is surrounded by hills covered with tea plantations.', 'Attend the evening cultural dance show. Visit during Perahera festival for a spectacular procession. Dress modestly when entering temples.', 'Year round, best December to April', 'active', NULL, '2026-05-08 07:59:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('customer','staff','admin') DEFAULT 'customer',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp(),
  `reset_token` varchar(100) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `phone`, `password`, `role`, `status`, `created_at`, `reset_token`, `reset_expires`) VALUES
(1, 'Admin', 'darany91ahilen@gmail.com', '0742665529', '$2a$12$firzuNcs/mknw4s2vY2/deVWrUtsxmHIAY28ddQZj2l0vUtXJfYha', 'admin', 'active', '2026-05-12 13:44:51', '729566', '2026-05-14 06:08:24'),
(2, 'Irine', 'prashanjaliluxman2000@gmail.com', '0764279445', '$2y$10$eMDIlU05diSbUKkuPsW9s.59qa57lbUh7UDmmnkH7zxqXEpNGgvm6', 'customer', 'active', '2026-05-12 15:39:58', '499747', '2026-05-14 20:17:42'),
(3, 'Hamesh', 'hamashgopi@gmail.com', '0756767678', '$2y$10$dfLmRi.LyOfjEKvoIu0rNu2/1M0s9RMzQs/cYt4Ep//gA2.LETWYS', 'staff', 'active', '2026-05-12 15:55:03', NULL, NULL),
(4, 'Anjali', 'irineanjali@gmail.com', '0765656564', '$2y$10$OxMI8OuKg7Gqoj0kORvdtezugc2atzZysu10Twm0KcHTvlRdVcn/a', 'staff', 'inactive', '2026-05-12 15:57:12', NULL, NULL),
(5, 'Shathurshika', 'shathu@gmail.com', '0765433455', '$2y$10$eUXN0RwFYbh5zE4YrUs5Quv/6jZzsYtYQvAG3Q1lh9BNXMKpdS9P2', 'customer', 'active', '2026-05-13 10:14:29', NULL, NULL),
(6, 'Hameshwar', 'vengadeshsingam1@gmail.com', '0786543212', '$2y$10$l0XQiWnyI5x8sAnJ6DjGMutMnNKno1WpFsnnYHlj.4zIQS8RJGbli', 'customer', 'active', '2026-05-13 12:46:31', NULL, NULL),
(7, 'Sagar', 'sagar@gmail.com', '0654343212', '$2y$10$OBvaLBlyWSQikfVg5KpFMOHhEsPeQwI7T22DzhzHcI5I.BGbTDiZy', 'customer', 'active', '2026-05-13 13:28:37', NULL, NULL),
(8, 'Sathya', 'sathya@gmail.com', '0897654323', '$2y$10$0ih7L50Pp5Ql26jyysg/1OoI14X5zR5.1Bt0DUQhTWiU.tS8r7cTW', 'customer', 'active', '2026-05-14 09:19:08', NULL, NULL),
(9, 'Pravinth', 'pravin@gmail.com', '0786111111', '$2y$10$tUkHyx18gEAJNVTZVpJWg.ZTj9rVXH3K2i0RYteXNCGlUqqvam8ia', 'staff', 'active', '2026-05-14 09:26:15', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accommodations`
--
ALTER TABLE `accommodations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accommodation_transport`
--
ALTER TABLE `accommodation_transport`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `coordinated_by` (`coordinated_by`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `package_id` (`package_id`);

--
-- Indexes for table `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `destination_id` (`destination_id`) USING BTREE;

--
-- Indexes for table `package_accommodations`
--
ALTER TABLE `package_accommodations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `package_id` (`package_id`),
  ADD KEY `accommodation_id` (`accommodation_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `queries`
--
ALTER TABLE `queries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `travel_guides`
--
ALTER TABLE `travel_guides`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

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
-- AUTO_INCREMENT for table `accommodations`
--
ALTER TABLE `accommodations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `accommodation_transport`
--
ALTER TABLE `accommodation_transport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `package_accommodations`
--
ALTER TABLE `package_accommodations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `queries`
--
ALTER TABLE `queries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `travel_guides`
--
ALTER TABLE `travel_guides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accommodation_transport`
--
ALTER TABLE `accommodation_transport`
  ADD CONSTRAINT `accommodation_transport_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`),
  ADD CONSTRAINT `accommodation_transport_ibfk_2` FOREIGN KEY (`coordinated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`);

--
-- Constraints for table `packages`
--
ALTER TABLE `packages`
  ADD CONSTRAINT `packages_ibfk_1` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `package_accommodations`
--
ALTER TABLE `package_accommodations`
  ADD CONSTRAINT `package_accommodations_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`),
  ADD CONSTRAINT `package_accommodations_ibfk_2` FOREIGN KEY (`accommodation_id`) REFERENCES `accommodations` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`),
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `queries`
--
ALTER TABLE `queries`
  ADD CONSTRAINT `queries_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `travel_guides`
--
ALTER TABLE `travel_guides`
  ADD CONSTRAINT `travel_guides_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
