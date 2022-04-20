-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 23, 2022 at 10:22 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookify`
--
CREATE DATABASE IF NOT EXISTS `bookify` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bookify`;

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `accountId` int(6) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `accountType` varchar(50) NOT NULL,
  `joinDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `account`:
--

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`accountId`, `userName`, `password`, `accountType`, `joinDate`) VALUES
(0, 'siteAdminAccount', 'e9b92a63587565a360383906dda949f7e740988c', 'admin', '0000-00-00'),
(4, 'userAccount', '', 'user', '2022-03-01'),
(5, 'userAccount2', '', 'user', '2022-02-03'),
(6, 'userAccount3', '', 'user', '2022-02-01'),
(7, 'userAccount4', '', 'user', '2022-01-05'),
(8, 'userName', 'password', 'user', '2022-02-09'),
(9, 'userName2', 'pass', 'user', '2022-03-13'),
(14, 'userName4', 'pass', 'user', '2019-02-01'),
(17, 'userName6', 'pass', 'user', '2022-03-13'),
(19, 'userName4', 'pass', 'user', '2022-03-01'),
(20, 'brandNEwUserName', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', 'user', '2022-03-13'),
(21, '5userName5', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', 'user', '2022-03-17'),
(22, 'userName6', '300ac668c782c666a9de0f2ccb59cea082255b5d', 'user', '2022-03-19'),
(23, '3newUser20', '300ac668c782c666a9de0f2ccb59cea082255b5d', 'user', '2022-03-20');

--
-- Triggers `account`
--
DELIMITER $$
CREATE TRIGGER `addNewBillingAccount` AFTER INSERT ON `account` FOR EACH ROW INSERT INTO billing
VALUES (NULL, new.accountId, "Paypal", "2022-12-31")
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `addressId` int(6) NOT NULL,
  `street1` varchar(100) NOT NULL,
  `street2` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `province/state` varchar(2) NOT NULL,
  `postalCode` varchar(6) NOT NULL,
  `country` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `address`:
--

-- --------------------------------------------------------

--
-- Table structure for table `billing`
--

CREATE TABLE `billing` (
  `billingId` int(6) NOT NULL,
  `accountId` int(6) NOT NULL,
  `billingType` varchar(50) NOT NULL,
  `expiryDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `billing`:
--   `accountId`
--       `account` -> `accountId`
--

--
-- Dumping data for table `billing`
--

INSERT INTO `billing` (`billingId`, `accountId`, `billingType`, `expiryDate`) VALUES
(0, 4, 'PayPal', '2022-03-14'),
(3, 20, 'PayPal', '2022-03-13'),
(8, 5, 'Paypal', '2022-12-31'),
(9, 6, 'Paypal', '2022-12-31'),
(10, 7, 'Paypal', '2022-12-31'),
(11, 8, 'Paypal', '2022-12-31'),
(12, 9, 'Paypal', '2022-12-31'),
(13, 14, 'Paypal', '2022-12-31'),
(14, 17, 'Paypal', '2022-12-31'),
(15, 19, 'Paypal', '2022-12-31'),
(16, 21, 'Paypal', '2022-12-31'),
(17, 22, 'Paypal', '2022-12-31'),
(18, 23, 'Paypal', '2022-12-31');

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `bookId` int(6) NOT NULL,
  `authorFirst` varchar(100) NOT NULL,
  `authorLast` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `genre` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `releaseDate` date NOT NULL,
  `publisherId` int(6) NOT NULL,
  `apiId` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `book`:
--

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`bookId`, `authorFirst`, `authorLast`, `title`, `genre`, `description`, `releaseDate`, `publisherId`, `apiId`) VALUES
(1, 'Lewis', 'Carroll', 'Alice in Wonderland', 'childrens', 'Alice falls down a hole, chasing a rabbit. ', '2022-02-21', 2, ''),
(2, 'Hunter', 'McHugh', 'A Complete History of Goosebumps', 'childrens', 'A deep dive into the goosebumps books', '2022-02-21', 1, ''),
(3, 'Monique', 'Bull', 'Born to Dance', 'Comedy|Musical', 'elementum ligula vehicula consequat morbi a ipsum integer a nibh in quis justo maecenas rhoncus', '1997-11-02', 1, ''),
(4, 'Dene', 'Starsmeare', 'Neon Flesh (Carne de neón)', 'Comedy|Drama', 'suscipit a feugiat et eros vestibulum ac est lacinia nisi venenatis tristique fusce congue diam id ornare imperdiet sapien urna pretium', '2013-03-27', 2, ''),
(5, 'Jecho', 'Rudgard', 'American, The', 'Drama|Thriller', 'a ipsum integer a nibh in quis justo maecenas rhoncus aliquam lacus morbi quis tortor id nulla ultrices aliquet maecenas leo odio condimentum id', '1998-01-12', 3, ''),
(6, 'Davida', 'Killshaw', 'Heart and Souls', 'Comedy|Fantasy', 'etiam vel augue vestibulum rutrum rutrum neque aenean auctor gravida sem praesent id', '1909-01-19', 4, ''),
(7, 'Winna', 'Postance', 'Marc Pease Experience, The', 'Comedy|Drama|Musical', 'proin leo odio porttitor id consequat in consequat ut nulla sed accumsan', '1955-07-25', 5, ''),
(8, 'Benny', 'Gowans', 'Ugly', 'Mystery|Thriller', 'sit amet sem fusce consequat nulla nisl nunc nisl duis bibendum', '2009-01-02', 6, ''),
(9, 'Kriste', 'Petrolli', 'Send Me No Flowers', 'Comedy|Romance', 'libero nam dui proin leo odio porttitor id consequat in consequat ut nulla sed accumsan felis', '1982-10-08', 7, ''),
(10, 'Danica', 'Tansill', 'Open Water 2: Adrift', 'Drama|Thriller', 'et commodo vulputate justo in blandit ultrices enim lorem ipsum dolor sit amet consectetuer adipiscing', '2002-10-17', 8, ''),
(11, 'Edwin', 'Pennell', 'Mating Game, The', 'Comedy|Romance', 'nec condimentum neque sapien placerat ante nulla justo aliquam quis turpis eget elit', '1980-01-06', 9, ''),
(12, 'Dougy', 'Slaney', 'Teenage', 'Documentary', 'felis ut at dolor quis odio consequat varius integer ac leo pellentesque ultrices mattis odio donec vitae nisi nam ultrices libero', '1906-12-06', 10, 'zyTCAlFPjgYC');

-- --------------------------------------------------------

--
-- Table structure for table `card`
--

CREATE TABLE `card` (
  `cardId` int(6) NOT NULL,
  `cardNumber` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `card`:
--

-- --------------------------------------------------------

--
-- Table structure for table `collection`
--

CREATE TABLE `collection` (
  `collectionId` int(6) NOT NULL,
  `collectionName` varchar(50) DEFAULT NULL,
  `accountId` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `collection`:
--   `accountId`
--       `account` -> `accountId`
--

--
-- Dumping data for table `collection`
--

INSERT INTO `collection` (`collectionId`, `collectionName`, `accountId`) VALUES
(9, 'A New Collection', 20),
(72, 'Collection2', 20),
(127, 'Carrot', 0);

-- --------------------------------------------------------

--
-- Table structure for table `collection_item`
--

CREATE TABLE `collection_item` (
  `collectionItemId` int(6) NOT NULL,
  `collectionId` int(6) NOT NULL,
  `bookId` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `collection_item`:
--   `collectionId`
--       `collection` -> `collectionId`
--

--
-- Dumping data for table `collection_item`
--

INSERT INTO `collection_item` (`collectionItemId`, `collectionId`, `bookId`) VALUES
(37, 9, 'euRRPgAACAAJ'),
(41, 72, 'euRRPgAACAAJ'),
(42, 9, 'sYAXMQAACAAJ'),
(43, 72, 'WhkqSgAACAAJ'),
(44, 72, 'I7ICc40cO9UC'),
(46, 9, 'WhkqSgAACAAJ'),
(50, 127, 'sYAXMQAACAAJ');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customerId` int(6) NOT NULL,
  `addressId` int(6) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `accountId` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `customer`:
--   `accountId`
--       `account` -> `accountId`
--

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customerId`, `addressId`, `email`, `phone`, `firstName`, `lastName`, `accountId`) VALUES
(1, 1, 'shearst0@4shared.com', '4531242024', 'Shalom', 'Hearst', 4),
(2, 2, 'chughson1@abc.net.au', '5556602887', 'Corey', 'Hughson', 5),
(3, 3, 'mdedomenicis2@eventbrite.com', '6183562983', 'Moise', 'De Domenicis', 6),
(4, 4, 'jghiron3@washington.edu', '9196791748', 'Juline', 'Ghiron', 7),
(5, 5, 'speddar4@furl.net', '5394576954', 'Sawyer', 'Peddar', 8),
(6, 6, 'rdobie5@umn.edu', '4504111905', 'Roxanna', 'Dobie', 9),
(7, 7, 'dimrie6@marriott.com', '7934685638', 'De', 'Imrie', 14),
(8, 8, 'etreend7@free.fr', '6245289689', 'Elnora', 'Treend', 17),
(9, 9, 'wmcduffy8@freewebs.com', '5344400756', 'Wini', 'McDuffy', 19),
(10, 10, 'hfreezer9@friendfeed.com', '1594508144', 'Halsey', 'Freezer', 20);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `employeeId` int(6) NOT NULL,
  `employeePhone` varchar(10) NOT NULL,
  `employeeFirstName` varchar(100) NOT NULL,
  `employeeLastName` varchar(100) NOT NULL,
  `employeeEmail` varchar(50) NOT NULL,
  `employeeRole` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `employee`:
--

-- --------------------------------------------------------

--
-- Table structure for table `external_users`
--

CREATE TABLE `external_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `custUser` varchar(20) DEFAULT NULL,
  `custPass` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `external_users`:
--

--
-- Dumping data for table `external_users`
--

INSERT INTO `external_users` (`id`, `custUser`, `custPass`) VALUES
(1, 'siteAdminAccount', 'e9b92a63587565a360383906dda949f7e740988c');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `inventoryId` int(6) NOT NULL,
  `bookId` int(6) NOT NULL,
  `availableQuantity` int(3) NOT NULL,
  `totalQuantity` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `inventory`:
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `mostpopularbooks`
-- (See below for the actual view)
--
CREATE TABLE `mostpopularbooks` (
`Title` varchar(100)
,`Author First` varchar(100)
,`Author Last` varchar(100)
,`Volume` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `mostpopularbooks2`
-- (See below for the actual view)
--
CREATE TABLE `mostpopularbooks2` (
`bookId` varchar(12)
,`count` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `overaccounts`
-- (See below for the actual view)
--
CREATE TABLE `overaccounts` (
`Customer Name` varchar(100)
,`Customer Email` varchar(50)
,`Card Expiry Date` date
);

-- --------------------------------------------------------

--
-- Table structure for table `paypal`
--

CREATE TABLE `paypal` (
  `paypalId` int(6) NOT NULL,
  `cardNumber` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `paypal`:
--

-- --------------------------------------------------------

--
-- Table structure for table `publisher`
--

CREATE TABLE `publisher` (
  `publisherId` int(6) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `companyName` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `publisher`:
--

--
-- Dumping data for table `publisher`
--

INSERT INTO `publisher` (`publisherId`, `phone`, `companyName`, `address`) VALUES
(1, '9023541232', 'PublisherHouse', '123 Fake Street'),
(2, '9025551211', 'Another Publisher', '111 Cherry Valley Rd.');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `ratingId` int(255) NOT NULL,
  `bookId` int(6) NOT NULL,
  `rating` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `rating`:
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `weeklysubscribers`
-- (See below for the actual view)
--
CREATE TABLE `weeklysubscribers` (
`Week` int(2)
,`Weekly Subscribers` bigint(21)
);

-- --------------------------------------------------------

--
-- Structure for view `mostpopularbooks`
--
DROP TABLE IF EXISTS `mostpopularbooks`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `mostpopularbooks`  AS SELECT `book`.`title` AS `Title`, `book`.`authorFirst` AS `Author First`, `book`.`authorLast` AS `Author Last`, count(0) AS `Volume` FROM (`collection_item` join `book` on(`book`.`bookId` = `collection_item`.`bookId`)) GROUP BY `book`.`title` ORDER BY count(0) DESC LIMIT 0, 10 ;

-- --------------------------------------------------------

--
-- Structure for view `mostpopularbooks2`
--
DROP TABLE IF EXISTS `mostpopularbooks2`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `mostpopularbooks2`  AS SELECT `collection_item`.`bookId` AS `bookId`, count(0) AS `count` FROM `collection_item` GROUP BY `collection_item`.`bookId` ORDER BY count(0) DESC LIMIT 0, 5 ;

-- --------------------------------------------------------

--
-- Structure for view `overaccounts`
--
DROP TABLE IF EXISTS `overaccounts`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `overaccounts`  AS SELECT `customer`.`firstName` AS `Customer Name`, `customer`.`email` AS `Customer Email`, `billing`.`expiryDate` AS `Card Expiry Date` FROM (`billing` join `customer` on(`customer`.`accountId` = `billing`.`accountId`)) WHERE `billing`.`expiryDate` = curdate() ;

-- --------------------------------------------------------

--
-- Structure for view `weeklysubscribers`
--
DROP TABLE IF EXISTS `weeklysubscribers`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `weeklysubscribers`  AS SELECT week(`account`.`joinDate`) AS `Week`, count(distinct `account`.`accountId`) AS `Weekly Subscribers` FROM `account` WHERE `account`.`joinDate` > current_timestamp() - interval 1 year AND `account`.`accountType` = 'user' GROUP BY week(`account`.`joinDate`) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`accountId`),
  ADD UNIQUE KEY `accountId` (`accountId`);

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`addressId`),
  ADD UNIQUE KEY `addressId` (`addressId`);

--
-- Indexes for table `billing`
--
ALTER TABLE `billing`
  ADD PRIMARY KEY (`billingId`),
  ADD UNIQUE KEY `billingId` (`billingId`),
  ADD KEY `AccountId` (`accountId`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`bookId`),
  ADD UNIQUE KEY `bookId` (`bookId`);

--
-- Indexes for table `card`
--
ALTER TABLE `card`
  ADD PRIMARY KEY (`cardId`),
  ADD UNIQUE KEY `cardId` (`cardId`);

--
-- Indexes for table `collection`
--
ALTER TABLE `collection`
  ADD PRIMARY KEY (`collectionId`),
  ADD UNIQUE KEY `collectionId` (`collectionId`),
  ADD KEY `accountId` (`accountId`);

--
-- Indexes for table `collection_item`
--
ALTER TABLE `collection_item`
  ADD PRIMARY KEY (`collectionItemId`),
  ADD UNIQUE KEY `collectionItemId` (`collectionItemId`),
  ADD KEY `CollectionConstraint` (`collectionId`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customerId`),
  ADD UNIQUE KEY `customerId` (`customerId`),
  ADD KEY `accountId` (`accountId`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`employeeId`),
  ADD UNIQUE KEY `employeeId` (`employeeId`);

--
-- Indexes for table `external_users`
--
ALTER TABLE `external_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`inventoryId`),
  ADD UNIQUE KEY `inventoryId` (`inventoryId`);

--
-- Indexes for table `paypal`
--
ALTER TABLE `paypal`
  ADD PRIMARY KEY (`paypalId`),
  ADD UNIQUE KEY `paypalId` (`paypalId`);

--
-- Indexes for table `publisher`
--
ALTER TABLE `publisher`
  ADD PRIMARY KEY (`publisherId`),
  ADD UNIQUE KEY `publisherId` (`publisherId`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`ratingId`),
  ADD UNIQUE KEY `ratingId` (`ratingId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `accountId` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `addressId` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `billing`
--
ALTER TABLE `billing`
  MODIFY `billingId` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `bookId` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `card`
--
ALTER TABLE `card`
  MODIFY `cardId` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `collection`
--
ALTER TABLE `collection`
  MODIFY `collectionId` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `collection_item`
--
ALTER TABLE `collection_item`
  MODIFY `collectionItemId` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customerId` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `employeeId` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `external_users`
--
ALTER TABLE `external_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inventoryId` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paypal`
--
ALTER TABLE `paypal`
  MODIFY `paypalId` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `publisher`
--
ALTER TABLE `publisher`
  MODIFY `publisherId` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `ratingId` int(255) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `billing`
--
ALTER TABLE `billing`
  ADD CONSTRAINT `AccountId` FOREIGN KEY (`accountId`) REFERENCES `account` (`accountId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `collection`
--
ALTER TABLE `collection`
  ADD CONSTRAINT `AccountContraint` FOREIGN KEY (`accountId`) REFERENCES `account` (`accountId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `collection_item`
--
ALTER TABLE `collection_item`
  ADD CONSTRAINT `CollectionConstraint` FOREIGN KEY (`collectionId`) REFERENCES `collection` (`collectionId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `AccountContraint2` FOREIGN KEY (`accountId`) REFERENCES `account` (`accountId`) ON DELETE CASCADE ON UPDATE CASCADE;


--
-- Metadata
--
USE `phpmyadmin`;

--
-- Metadata for table account
--

--
-- Metadata for table address
--

--
-- Metadata for table billing
--

--
-- Metadata for table book
--

--
-- Metadata for table card
--

--
-- Metadata for table collection
--

--
-- Metadata for table collection_item
--

--
-- Dumping data for table `pma__table_uiprefs`
--

INSERT INTO `pma__table_uiprefs` (`username`, `db_name`, `table_name`, `prefs`, `last_update`) VALUES
('root', 'bookify', 'collection_item', '{\"sorted_col\":\"`collectionItemId` ASC\"}', '2022-03-23 12:54:28');

--
-- Metadata for table customer
--

--
-- Metadata for table employee
--

--
-- Metadata for table external_users
--

--
-- Metadata for table inventory
--

--
-- Metadata for table mostpopularbooks
--

--
-- Metadata for table mostpopularbooks2
--

--
-- Metadata for table overaccounts
--

--
-- Metadata for table paypal
--

--
-- Metadata for table publisher
--

--
-- Metadata for table rating
--

--
-- Metadata for table weeklysubscribers
--

--
-- Metadata for database bookify
--

--
-- Dumping data for table `pma__bookmark`
--

INSERT INTO `pma__bookmark` (`dbase`, `user`, `label`, `query`) VALUES
('bookify', '', 'Weekly New Subscriber Count', 'SELECT WEEK(joinDate) as \"Week\", \r\nCOUNT(DISTINCT accountId) AS \"Weekly Subscribers\"\r\nFROM account\r\nWHERE joinDate > NOW() - INTERVAL 1 YEAR AND accountType=\"user\"\r\nGROUP BY WEEK(joinDate);'),
('bookify', '', 'MostPopularBooks', 'SELECT \r\nbook.title,\r\nbook.authorFirst,\r\nbook.authorLast,\r\ncount(*)\r\nFROM collection_item\r\nJOIN book ON book.bookId = collection_item.bookId\r\nGROUP BY book.title\r\nORDER BY count(*) DESC\r\nLIMIT 5;'),
('bookify', '', 'MostPopularBook(1)', 'SELECT \r\nmostpopularbooks.Title\r\nFROM mostpopularbooks\r\nWHERE Volume = (SELECT MAX(Volume) FROM mostpopularbooks)\r\nLIMIT 1;'),
('bookify', '', 'OverdueAccounts', 'SELECT\r\ncustomer.firstName,\r\ncustomer.email,\r\nbilling.expiryDate\r\nFROM billing\r\nJOIN customer ON customer.accountId = billing.accountId\r\nWHERE billing.expiryDate =CURRENT_DATE();'),
('bookify', '', 'Weekly New Subscriber Count Cumulative', 'SELECT\r\nt.week,\r\nt.weeklySubs,\r\n@running_total:=@running_total + t.weeklySubs AS cSum\r\nFROM (\r\nSELECT WEEK(joinDate) as week, \r\nCOUNT(DISTINCT accountId) AS weeklySubs\r\nFROM account\r\nWHERE joinDate > NOW() - INTERVAL 1 YEAR AND accountType=\"user\"\r\nGROUP BY WEEK(joinDate)) t\r\nJOIN (SELECT @running_total:=0) r\r\nORDER BY t.week;');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
