-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 12, 2011 at 10:52 PM
-- Server version: 5.1.37
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `librarycms`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE IF NOT EXISTS `authors` (
  `author_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `author_lastname` varchar(30) NOT NULL,
  `author_firstname` varchar(30) NOT NULL,
  `author_middlename` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`author_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `authors`
--


-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `book_id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `book_ISBN` int(13) NOT NULL,
  `genre_id` int(6) NOT NULL,
  `author_id` int(6) NOT NULL,
  `book_title` varchar(255) NOT NULL,
  `book_description` varchar(255) DEFAULT NULL,
  `book_format` enum('printed book','e-book','audio book','pdfs') DEFAULT NULL,
  `book_binding` enum('hardcover','paperback','large print','board book') DEFAULT NULL,
  `publish_date` date NOT NULL,
  `book_inventory` int(5) NOT NULL,
  `due_length` smallint(4) NOT NULL,
  PRIMARY KEY (`book_id`),
  KEY `genre_id` (`genre_id`,`author_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `books`
--


-- --------------------------------------------------------

--
-- Table structure for table `book_instance`
--

CREATE TABLE IF NOT EXISTS `book_instance` (
  `bookinstance_id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `book_id` int(11) NOT NULL,
  `book_inventory` smallint(6) NOT NULL,
  `conditions` enum('new','used','collectible') DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`bookinstance_id`),
  KEY `book_id` (`book_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `book_instance`
--


-- --------------------------------------------------------

--
-- Table structure for table `borrow_history`
--

CREATE TABLE IF NOT EXISTS `borrow_history` (
  `history_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bookinstance_id` smallint(6) NOT NULL,
  `member_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `return_date` date NOT NULL,
  PRIMARY KEY (`history_id`),
  KEY `bookinstance_id` (`bookinstance_id`,`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `borrow_history`
--


-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE IF NOT EXISTS `genres` (
  `genre_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `genre_name` varchar(50) NOT NULL,
  `genre_description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`genre_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`genre_id`, `genre_name`, `genre_description`) VALUES
(1, 'Arts & Crafts', 'Books on art history, dance, theatre, woodworking, and interior design.'),
(2, 'Business & Investing', 'books about small business, investment, entrepreneurship, self-help, personal finance, and career choices.'),
(3, 'Children''s Books', 'Literature for pre-school aged children through young adult readers in all formats from board books to picture books to novels.'),
(4, 'Computer and Internet', 'Strategy and game guides; software and programming guides; certification guides.'),
(5, 'Cooking, Food and Wine', 'Cooking books, baking books, grilling books, vegetarian cookbooks, and books about food and wine.'),
(6, 'Health, Mind and Body', ' Books about health, mind, and body. Self-help books and spiritual guildance.'),
(7, 'Home and Gardening', 'From animal care to antiques, horticulture to home improvement, discover the best new home and garden books.'),
(8, 'Novels (Fictions)', 'Fiction books, short story collections, poetry, and classic literature.'),
(9, 'Novels (Non-Fiction)', 'Books that are nonfiction, or true, are about real things, people, events, and places.');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
