-- version 5.2.1
-- Host: 127.0.0.1
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `ipctask1`
--

-- --------------------------------------------------------

--
-- Table structure for table `athletes`
--

CREATE TABLE `athletes` (
  `id` int(10) UNSIGNED NOT NULL,
  `givenName` varchar(100) NOT NULL, #The database expects givenName but the one written here was giveName
  `familyName` varchar(100) NOT NULL,
  `dateOfBirth` date NOT NULL,
  `sport_id` int(10) UNSIGNED NOT NULL,
  `personalBestTime` char(8) NOT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



--
-- Table structure for table `sports`
--

CREATE TABLE `sports` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sports`
--

INSERT INTO `sports` (`id`, `name`) VALUES
(1, 'Athletics track'),
(3, 'Cycling'),
(2, 'Swimming'),
(4, 'Triathlon');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password_hash`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$REPLACE_WITH_YOUR_BCRYPT_HASH', 'admin', '2025-08-22 14:25:46', '2025-08-22 14:25:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `athletes`
--
ALTER TABLE `athletes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_athlete_sport` (`sport_id`),
  ADD KEY `fk_athlete_user` (`created_by`);

--
-- Indexes for table `sports`
--
ALTER TABLE `sports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `athletes`
--
ALTER TABLE `athletes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sports`
--
ALTER TABLE `sports`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `athletes`
--
ALTER TABLE `athletes`
  ADD CONSTRAINT `fk_athlete_sport` FOREIGN KEY (`sport_id`) REFERENCES `sports` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_athlete_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;
