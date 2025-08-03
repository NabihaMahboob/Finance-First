-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 03, 2025 at 05:19 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `users`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `service` varchar(100) NOT NULL,
  `comments` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `email`, `name`, `date`, `time`, `service`, `comments`, `created_at`, `status`) VALUES
(1, 'bobby@gmail.com', 'Bob Bobby', '2025-07-29', '14:25:00', 'budgeting_help', 'hi', '2025-07-30 06:25:49', 'cancelled'),
(2, 'bobby@gmail.com', 'Bob Bobby', '2025-08-01', '15:45:00', 'investment_planning', 'hi', '2025-07-30 19:42:47', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `budget`
--

CREATE TABLE `budget` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `type` enum('income','expense') NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `budget`
--

INSERT INTO `budget` (`id`, `email`, `type`, `category`, `amount`, `note`, `created_at`) VALUES
(1, '', 'income', 'Job', 10000.00, 'Monthly Salary', '2025-07-30 20:31:14'),
(2, '', 'expense', 'Food', 100.00, '', '2025-07-30 20:31:28'),
(3, '', 'expense', 'Food', 100.00, '', '2025-07-30 20:33:15'),
(4, '', 'expense', 'Food', 100.00, '', '2025-07-30 20:33:30');

-- --------------------------------------------------------

--
-- Table structure for table `budgets`
--

CREATE TABLE `budgets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `category` varchar(100) NOT NULL,
  `allocated_amount` decimal(10,2) NOT NULL,
  `spent_amount` decimal(10,2) DEFAULT 0.00,
  `notes` text DEFAULT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_requests`
--

CREATE TABLE `contact_requests` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_requests`
--

INSERT INTO `contact_requests` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'Jane Doe', 'jane.doe@gmail.com', 'asdse', '2025-07-30 04:23:47'),
(2, 'bill', 'bill@gmail.com', 'hello i need assistance.', '2025-07-30 04:27:21');

-- --------------------------------------------------------

--
-- Table structure for table `external_articles`
--

CREATE TABLE `external_articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `url` text DEFAULT NULL,
  `source` varchar(100) DEFAULT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `external_articles`
--

INSERT INTO `external_articles` (`id`, `title`, `url`, `source`, `added_on`) VALUES
(1, 'Investing for Beginners: How to Get Started', 'https://www.investopedia.com/articles/basics/06/invest1000.asp', 'Investopedia', '2025-07-30 05:40:32'),
(2, 'Why Portfolio Diversification Matters & How to do it', 'https://www.fool.com/investing/how-to-invest/portfolio-diversification/', 'The Motley Fool', '2025-07-30 05:40:32'),
(3, 'Where Should Investors Look Next Among Economic Mixed Messages?', 'https://www.morningstar.com/markets/where-should-investors-look-next-among-economic-mixed-messages-2', 'Morningstar', '2025-07-30 05:40:32'),
(4, 'Big Tech Earnings Strength Is Bright Light in Murky Stock Market', 'https://www.bloomberg.com/news/articles/2025-08-02/big-tech-earnings-strength-is-bright-light-in-murky-stock-market', 'Bloomberg', '2025-07-30 05:40:32'),
(5, 'U.S. Stock Market: Investor Pessimism Has Begun To Rise', 'https://www.forbes.com/sites/johntobey/2025/03/10/us-stock-market-investor-pessimism-has-begun/?ctpv=searchpage', 'Forbes Advisor', '2025-07-30 05:40:32');

-- --------------------------------------------------------

--
-- Table structure for table `forums`
--

CREATE TABLE `forums` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `likes` int(11) DEFAULT 0,
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `forums`
--

INSERT INTO `forums` (`post_id`, `user_id`, `first_name`, `title`, `description`, `created_at`, `updated_at`, `likes`, `is_deleted`) VALUES
(1, 7, '', 'Book About Stocks', 'An Absolute Must Read! One Up on Wall Street by Peter Lynch', '2025-07-30 15:27:49', '2025-07-30 15:27:49', 0, 0),
(4, 7, 'sam', 'Investment Platforms', 'I\'ve had great experiences with Wealthsimple!', '2025-07-30 15:34:18', '2025-07-30 15:34:18', 0, 0),
(6, 4, 'Bob', 'What bank do you prefer?', 'I am looking to switch to a new bank. What bank would you suggest. I travel a lot so something with good travel rewards is preferred.', '2025-07-30 17:21:22', '2025-07-30 17:21:22', 0, 0),
(9, 4, 'Bob', 'hello', 'test123', '2025-08-01 00:03:53', '2025-08-01 00:03:53', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `forum_likes`
--

CREATE TABLE `forum_likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `forum_id` int(11) NOT NULL,
  `liked_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price1` decimal(10,2) NOT NULL,
  `option1_name` varchar(100) DEFAULT NULL,
  `option1_value` varchar(100) DEFAULT NULL,
  `price2` decimal(10,2) DEFAULT NULL,
  `option2_name` varchar(100) DEFAULT NULL,
  `option2_value` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `image`, `description`, `price1`, `option1_name`, `option1_value`, `price2`, `option2_name`, `option2_value`) VALUES
(1, 'Credit Reports', 'creditReport', 'Description of Product', 20.00, 'time', 'One Month', 200.00, 'time', 'One Year'),
(2, 'Tax Filing Services', 'taxFiling', 'Description', 350.01, 'Filing Type', 'Express Filing', 200.00, 'Filing Type', 'Regular Filing'),
(3, 'Retirement Planning Guide', 'retirementPlanning', 'Description', 90.00, 'Number of Sessions', '3 session', 160.00, 'Number of Sessions', '6 Session'),
(5, 'Investing for Beginners: Investment Course', 'beginnerInvestmentCourse', 'Description of Product 1.', 90.00, 'Class Length', '3 Months', 120.00, 'Class Length', '6 Months'),
(6, 'Intermediate Investing: Investment Course', 'intermediateInvestmentCourse', 'Description of Product 1.', 90.00, 'Class Length', '3 Months', 120.00, 'Class Length', '6 Months'),
(7, 'Advanced Investing: Investment Course', 'advancedInvestmentCourse', 'Description of Product 1.', 90.00, 'Class Length', '3 Months', 120.00, 'Class Length', '6 Months'),
(8, 'Estate Planning', 'estatePlanning', 'Description of Product 1.', 10.00, 'Format', 'Digital', 15.00, 'Format', 'Printed'),
(9, 'Finance Card Deck', 'financeCards', 'Description of Product 1.', 10.00, 'Edition', 'Standard', 20.00, 'Edition', 'Deluxe'),
(10, 'Tax Prep Binder', 'home-intro1', 'Description of Product 1.', 10.00, 'Version', 'Basic', 18.00, 'Version', 'Pro'),
(11, 'Budgeting Cash Envelope', 'budgetEnvelope', 'Description of Product 1.', 10.00, 'Material', 'Paper', 15.00, 'Material', 'Plastic'),
(12, 'Invesment Guide by Steven Jones', 'book1', 'Description of Product 1.', 10.00, 'Cover Type', 'Softcover', 20.00, 'Cover Type', 'Hardcover'),
(13, 'Kids Money Education Pack', 'kidsMoneyEducation', 'Teach kids ages 6–12 the basics of money and saving.', 35.00, 'Age Range', '6–8 Years', 50.00, 'Age Range', '9–12 Years'),
(14, 'Financial Independence Planner', 'financePlanner', 'Tools and templates to track your journey to financial independence.', 30.00, 'Version', 'Standard', 45.00, 'Version', 'Deluxe'),
(15, 'Student Loan Repayment Guide', 'studentLoanGuide', 'Plan and accelerate your student loan payoff journey.', 20.00, 'Format', 'eBook', 30.00, 'Format', 'Video Series'),
(16, 'Side Hustle Starter Pack', 'sideHustlePack', 'Identify, launch, and grow your side income streams.', 50.00, 'Access Level', 'Self-paced', 75.00, 'Access Level', 'Mentored'),
(17, 'Crypto Investing Fundamentals', 'cryptoFundamentals', 'Understand cryptocurrency, blockchain, and how to invest safely.', 95.00, 'Level', 'Beginner', 125.00, 'Level', 'Intermediate'),
(18, 'Emergency Fund Builder', 'emergencyFundBuilder', 'A simple framework for building your emergency savings.', 20.00, 'Format', 'Digital Checklist', 30.00, 'Format', 'Workbook + Videos'),
(19, 'Insurance Simplified', 'insuranceSimplified', 'Understand life, auto, health, and home insurance in plain English.', 50.00, 'Format', 'eBook', 70.00, 'Format', 'Interactive Course'),
(20, 'Real Estate Investing 101', 'realEstate101', 'Learn how to invest in residential and commercial real estate.', 100.00, 'Course Format', 'Video Series', 140.00, 'Course Format', 'Video + Coaching'),
(21, 'Women & Wealth Mastery Program', 'womenWealthMastery', 'Empowerment-focused financial planning for women.', 95.00, 'Level', 'Standard Access', 130.00, 'Level', 'VIP Coaching');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `comment`, `rating`, `created_at`) VALUES
(1, 'Jennifer Smith', 'Amazing website with great services.', 5, '2025-07-30 04:12:07'),
(5, 'Philip Marks', 'Amazing website with great services.', 5, '2025-07-30 04:13:26'),
(6, 'Tom Ford', 'Helped me get rid of my debt.', 4, '2025-07-30 04:13:26');

-- --------------------------------------------------------

--
-- Table structure for table `userdata`
--

CREATE TABLE `userdata` (
  `id` int(11) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userdata`
--

INSERT INTO `userdata` (`id`, `first_name`, `last_name`, `email`, `password`, `role`) VALUES
(4, 'Bob', 'Bobby', 'bobby@gmail.com', '$2y$12$6bHU.v.zG2sbBCOupmJRdOFr1roy/LFsaIJSQV8SdBTJKbAAe2eAi', 'user'),
(6, 'La', 'Na', 'lana@gmail.com', '$2y$12$m2E6ImEwC0oas9IK4rEgreQ.gNZDMZTM5LgZdC6WvQAp1NOXhLKm2', 'user'),
(7, 'Sammy', 'sammy', 'sam@gmail.com', '$2y$12$skUzBvXUwRRWEKnXKbshWeF7AduAeGnrSuEZM8spFcyKEpluuCWhW', 'admin'),
(10, 'John', 'Doe', 'john@gmail.com', '$2y$12$QVbM1yV1YOedItepvgq.5e2hyTb0CBeSyy/83e6kEDR7uNInZzsae', 'admin'),
(12, 'Jane', 'Doe', 'jane@gmail.com', '$2y$12$yF3g.sVjQxxeStZ51c0MBu88KKcMivzZgHtqgh/R0g9nQchfKzyXa', 'admin'),
(13, 'Wendy', 'bob', 'wendy@gmail.com', '$2y$12$CDrTrLJbR4OB5XMSIHTqhOVb0QTJSTNhlu9GqThtmwPNJs/vi3nPC', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `budget`
--
ALTER TABLE `budget`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `budgets`
--
ALTER TABLE `budgets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `contact_requests`
--
ALTER TABLE `contact_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `external_articles`
--
ALTER TABLE `external_articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forums`
--
ALTER TABLE `forums`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `forum_likes`
--
ALTER TABLE `forum_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_like` (`user_id`,`forum_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userdata`
--
ALTER TABLE `userdata`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `budget`
--
ALTER TABLE `budget`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `budgets`
--
ALTER TABLE `budgets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_requests`
--
ALTER TABLE `contact_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `external_articles`
--
ALTER TABLE `external_articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `forums`
--
ALTER TABLE `forums`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `forum_likes`
--
ALTER TABLE `forum_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `userdata`
--
ALTER TABLE `userdata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `budgets`
--
ALTER TABLE `budgets`
  ADD CONSTRAINT `budgets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `userdata` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `forums`
--
ALTER TABLE `forums`
  ADD CONSTRAINT `forums_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `userdata` (`id`);

--
-- Constraints for table `forum_likes`
--
ALTER TABLE `forum_likes`
  ADD CONSTRAINT `forum_likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `userdata` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
