-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-07-2014 a las 22:15:14
-- Versión del servidor: 5.5.32
-- Versión de PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `coders`
--
CREATE DATABASE IF NOT EXISTS `coders` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `coders`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codelibrary`
--

CREATE TABLE IF NOT EXISTS `codelibrary` (
  `CodeID` int(11) NOT NULL,
  `UserID` varchar(20) NOT NULL,
  `File` mediumblob NOT NULL,
  `Description` mediumtext,
  `Date` date DEFAULT NULL,
  `Time` time DEFAULT NULL,
  PRIMARY KEY (`CodeID`),
  KEY `CodeUserID_idx` (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `following`
--

CREATE TABLE IF NOT EXISTS `following` (
  `FollowID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` varchar(20) CHARACTER SET utf8 NOT NULL,
  `FollowerID` varchar(20) CHARACTER SET utf8 NOT NULL,
  `Valid` tinyint(1) NOT NULL,
  `Active` tinyint(1) NOT NULL,
  PRIMARY KEY (`FollowID`),
  KEY `UserID` (`UserID`,`FollowerID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `following`
--

INSERT INTO `following` (`FollowID`, `UserID`, `FollowerID`, `Valid`, `Active`) VALUES
(1, 'chr2014za04ch2303313', 'jos2014fe04f31875702', 1, 1),
(2, 'flo2014fl05ma2412103', 'jos2014fe04f31875702', 1, 1),
(3, 'chr2014za04ch2303313', 'flo2014fl05ma2412103', 1, 1),
(4, 'jos2014fe04f31875702', 'flo2014fl05ma2412103', 1, 1),
(5, 'pru2014104ma2431250', 'jos2014fe04f31875702', 0, 0),
(6, 'pru2014104ma2431250', 'jos2014fe04f31875702', 1, 1),
(7, 'jos2014fe04f31875702', 'ken2014gu05fe2936239', 1, 1),
(8, 'ken2014gu05fe2936239', 'jos2014fe04f31875702', 1, 1),
(9, 'jos2014fe04f31875702', 'jos2014fe04f31875702', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `GroupID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Public` tinyint(1) NOT NULL,
  `UserID` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`GroupID`),
  UNIQUE KEY `GroupID_UNIQUE` (`GroupID`),
  KEY `fk_group_users1_idx` (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `MessageID` varchar(255) NOT NULL,
  `UserID` varchar(20) NOT NULL,
  `UserFrom` varchar(15) NOT NULL,
  `Content` longtext NOT NULL,
  `File` mediumblob,
  `Date` date DEFAULT NULL,
  `Time` time DEFAULT NULL,
  PRIMARY KEY (`MessageID`),
  KEY `MessageUserID_idx` (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `PostID` varchar(255) NOT NULL,
  `UserID` varchar(20) NOT NULL,
  `Content` longtext NOT NULL,
  `Date` date DEFAULT NULL,
  `Time` time NOT NULL,
  `View` int(11) NOT NULL,
  PRIMARY KEY (`PostID`),
  KEY `UserID_idx` (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `post`
--

INSERT INTO `post` (`PostID`, `UserID`, `Content`, `Date`, `Time`, `View`) VALUES
('jos2014fe04f3187570220140527052106', 'jos2014fe04f31875702', 'Funci0na!', '2014-05-27', '05:21:06', 1),
('pru2014104ma243125020140527051905', 'pru2014104ma2431250', 'Ya funciona! :D', '2014-05-27', '05:19:05', 1),
('flo2014fl05ma241210320140527035203', 'flo2014fl05ma2412103', 'Testing! Flores', '2014-05-27', '03:52:03', 1),
('chr2014za04ch230331320140527035120', 'chr2014za04ch2303313', 'Testing Zayas', '2014-05-27', '03:51:20', 1),
('jos2014fe04f3187570220140527035006', 'jos2014fe04f31875702', 'Testing! SantamarÃ­a', '2014-05-27', '03:50:06', 1),
('pru2014104ma243125020140520091933', 'pru2014104ma2431250', 'Testing', '2014-05-20', '09:19:33', 1),
('ken2014gu05fe293623920140529082223', 'ken2014gu05fe2936239', 'LIVE THIS LIFE TO THE FULLEST!', '2014-05-29', '08:22:23', 1),
('flo2014fl05ma241210320140529022236', 'flo2014fl05ma2412103', 'askdjhfsdjkhfkjdhkfj', '2014-05-29', '02:22:36', 1),
('ken2014gu05fe293623920140529020812', 'ken2014gu05fe2936239', 'BIEEEEN!', '2014-05-29', '02:08:12', 1),
('ken2014gu05fe293623920140529020827', 'ken2014gu05fe2936239', 'BIEEEN!', '2014-05-29', '02:08:27', 1),
('ken2014gu05fe293623920140529020851', 'ken2014gu05fe2936239', 'BIEEEN!', '2014-05-29', '02:08:51', 1),
('ken2014gu05fe293623920140529021241', 'ken2014gu05fe2936239', 'escribi', '2014-05-29', '02:12:41', 1),
('ken2014gu05fe293623920140529021259', 'ken2014gu05fe2936239', 'escribi', '2014-05-29', '02:12:59', 1),
('ken2014gu05fe293623920140529021319', 'ken2014gu05fe2936239', '', '2014-05-29', '02:13:19', 1),
('jos2014fe04f3187570220140529021339', 'jos2014fe04f31875702', '123456', '2014-05-29', '02:13:39', 1),
('flo2014fl05ma241210320140529021358', 'flo2014fl05ma2412103', '136343543546', '2014-05-29', '02:13:58', 1),
('flo2014fl05ma241210320140529021411', 'flo2014fl05ma2412103', 'szfsadfwfs', '2014-05-29', '02:14:11', 1),
('flo2014fl05ma241210320140529021516', 'flo2014fl05ma2412103', 'aaaaaa', '2014-05-29', '02:15:16', 1),
('flo2014fl05ma241210320140529102452', 'flo2014fl05ma2412103', '000000000000', '2014-05-29', '10:24:52', 1),
('flo2014fl05ma241210320140529022535', 'flo2014fl05ma2412103', 'gffgfg', '2014-05-29', '14:25:35', 0),
('ken2014gu05fe293623920140529023026', 'ken2014gu05fe2936239', 'Amo Java y PHP', '2014-05-29', '14:30:26', 1),
('ken2014gu05fe293623920140529023517', 'ken2014gu05fe2936239', 'Me duele la POSI :/', '2014-05-29', '14:35:17', 1),
('jos2014fe04f3187570220140704113231', 'jos2014fe04f31875702', 'ddddddddd', '2014-07-04', '11:32:31', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postcomments`
--

CREATE TABLE IF NOT EXISTS `postcomments` (
  `CommentID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` varchar(20) NOT NULL,
  `Content` mediumtext NOT NULL,
  `View` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  `PostID` varchar(255) NOT NULL,
  PRIMARY KEY (`CommentID`),
  KEY `CommentPostID_idx` (`PostID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `postcomments`
--

INSERT INTO `postcomments` (`CommentID`, `UserID`, `Content`, `View`, `Date`, `Time`, `PostID`) VALUES
(1, 'jos2014fe04f31875702', 'rdhyfddfhdfhfdhdfhhfh', 1, '2014-07-04', '08:09:20', 'ken2014gu05fe293623920140529082223'),
(2, 'jos2014fe04f31875702', 'Kennette!!', 0, '2014-07-04', '13:26:45', 'ken2014gu05fe293623920140529023517'),
(3, 'jos2014fe04f31875702', 'Kenn!', 1, '2014-07-04', '13:26:56', 'ken2014gu05fe293623920140529023517');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postcomments_group`
--

CREATE TABLE IF NOT EXISTS `postcomments_group` (
  `CommentID` int(11) NOT NULL,
  `UserID` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `PostID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Content` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  `View` int(11) NOT NULL,
  `GroupID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`CommentID`),
  UNIQUE KEY `CommentID_UNIQUE` (`CommentID`),
  KEY `fk_postcomments_group_post_group1_idx` (`PostID`),
  KEY `fk_postcomments_group_user_group1_idx` (`UserID`),
  KEY `fk_postcomments_group_group1_idx` (`GroupID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post_group`
--

CREATE TABLE IF NOT EXISTS `post_group` (
  `PostID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `UserID` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `GroupID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  `View` int(11) NOT NULL,
  PRIMARY KEY (`PostID`),
  UNIQUE KEY `PostID_UNIQUE` (`PostID`),
  KEY `fk_post_group_user_group1_idx` (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `userinformation`
--

CREATE TABLE IF NOT EXISTS `userinformation` (
  `UserID` varchar(20) NOT NULL,
  `PrograLang` longtext NOT NULL,
  `Profession` mediumtext,
  `Skills` mediumtext,
  `Description` mediumtext,
  `ProfPic` mediumblob NOT NULL,
  `Goals` mediumtext,
  `Website` varchar(100) DEFAULT NULL,
  `Country` varchar(20) NOT NULL,
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `UserID_UNIQUE` (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `UserID` varchar(20) NOT NULL,
  `Name` varchar(15) NOT NULL,
  `LastName` varchar(15) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Pass` varchar(255) NOT NULL,
  `BirthDate` date NOT NULL,
  `Track` tinyint(1) NOT NULL,
  `Admin` tinyint(1) NOT NULL,
  `Block` tinyint(1) NOT NULL,
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `UserID_UNIQUE` (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`UserID`, `Name`, `LastName`, `Email`, `Pass`, `BirthDate`, `Track`, `Admin`, `Block`) VALUES
('jos2014fe04f31875702', 'Fernando', 'SantamarÃ­a', 'f3rnand.flores@gmail.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '2014-04-22', 0, 1, 0),
('chr2014za04ch2303313', 'Christian', 'Zayas', 'chris.zayas2010@gmail.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '2010-10-10', 0, 1, 0),
('jos2014fl05fl2413229', 'JosÃ©', 'Flores', 'floresjose@mail.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '1995-04-22', 0, 0, 0),
('flo2014fl05ma2412103', 'Flores', 'Flores', 'mail@mail2.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '1986-12-20', 0, 0, 0),
('ken2014gu05fe2936239', 'Kennette', 'Guevara', 'fernando_kgr@hotmail.es', 'e4ebaa750050dfd293757d7bba189c3ca848c991f3230bfbadba11d17a353409', '1996-06-05', 0, 0, 1),
('wal2014ce05wa2952499', 'Walter', 'Cerritos', 'walter_gonzalez@hotmail.es', '4ecfad5efbc93c7e62224d3bcf07ae7eb9faabf54ebd8e879b4a27ab629933c5', '1996-11-02', 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_group`
--

CREATE TABLE IF NOT EXISTS `user_group` (
  `User_groupID` int(11) NOT NULL,
  `UserID` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `GroupID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`User_groupID`),
  UNIQUE KEY `User_groupID_UNIQUE` (`User_groupID`),
  KEY `fk_user_group_users1_idx` (`UserID`),
  KEY `fk_user_group_group1_idx` (`GroupID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `workspace`
--

CREATE TABLE IF NOT EXISTS `workspace` (
  `WorkID` int(11) NOT NULL,
  `UserID` varchar(20) NOT NULL,
  `Title` varchar(20) NOT NULL,
  `Description` varchar(50) NOT NULL,
  `File` mediumblob NOT NULL,
  `View` int(11) NOT NULL,
  PRIMARY KEY (`WorkID`),
  KEY `WorkUSerID_idx` (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
