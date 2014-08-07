
-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 07-08-2014 a las 13:20:00
-- Versión del servidor: 5.1.69
-- Versión de PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `u124391149_coder`
--

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=24 ;

--
-- Volcado de datos para la tabla `following`
--

INSERT INTO `following` (`FollowID`, `UserID`, `FollowerID`, `Valid`, `Active`) VALUES
(1, 'chr2014za04ch2303313', 'jos2014fe04f31875702', 1, 1),
(2, 'flo2014fl05ma2412103', 'jos2014fe04f31875702', 1, 1),
(3, 'chr2014za04ch2303313', 'flo2014fl05ma2412103', 1, 1),
(4, 'jos2014fe04f31875702', 'flo2014fl05ma2412103', 1, 1),
(7, 'jos2014fe04f31875702', 'jos2014fe04f31875702', 1, 1),
(8, 'chr2014za04ch2303313', 'chr2014za04ch2303313', 1, 1),
(9, 'flo2014fl05ma2412103', 'flo2014fl05ma2412103', 1, 1),
(11, 'ken2014gu05fe2936239', 'jos2014fe04f31875702', 1, 1),
(13, 'ken2014gu05fe2936239', 'chr2014za04ch2303313', 1, 1),
(14, 'chr2014za04ch2303313', 'ken2014gu05fe2936239', 1, 1),
(15, 'jos2014fe04f31875702', 'ken2014gu05fe2936239', 1, 1),
(16, 'ken2014gu05fe2936239', 'ken2014gu05fe2936239', 1, 1),
(17, 'a2014a07a@0290762', 'a2014a07a@0290762', 1, 1),
(18, 'as2014sd07sd0718731', 'as2014sd07sd0718731', 1, 1),
(19, 'chr2014za04ch2303313', 'wal2014ce05wa2952499', 1, 1),
(23, 'jos2014fe04f31875702', 'chr2014za04ch2303313', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `GroupID` varchar(15) CHARACTER SET utf8 NOT NULL,
  `Name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Content` varchar(25) CHARACTER SET utf8 NOT NULL,
  `UserID` varchar(20) CHARACTER SET utf8 NOT NULL,
  `Date` date NOT NULL,
  `Color` varchar(6) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`GroupID`),
  UNIQUE KEY `GroupID_UNIQUE` (`GroupID`),
  KEY `fk_group_users1_idx` (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `groups`
--

INSERT INTO `groups` (`GroupID`, `Name`, `Content`, `UserID`, `Date`, `Color`) VALUES
('757020498221963', 'HTML', 'HTML', 'jos2014fe04f31875702', '2014-08-02', '9B59B6'),
('757020030337405', 'Coders', 'HTML', 'jos2014fe04f31875702', '2014-07-15', 'E67E22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `MessageID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` varchar(20) NOT NULL,
  `UserFrom` varchar(20) NOT NULL,
  `Content` longtext NOT NULL,
  `File` mediumblob,
  `Date` date DEFAULT NULL,
  `Time` time DEFAULT NULL,
  `View` int(1) NOT NULL,
  PRIMARY KEY (`MessageID`),
  KEY `MessageUserID_idx` (`UserID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Volcado de datos para la tabla `messages`
--

INSERT INTO `messages` (`MessageID`, `UserID`, `UserFrom`, `Content`, `File`, `Date`, `Time`, `View`) VALUES
(1, 'chr2014za04ch2303313', 'jos2014fe04f31875702', 'Prueba de mensaje', NULL, '2014-07-21', '20:04:33', 0),
(2, 'jos2014fe04f31875702', 'chr2014za04ch2303313', 'Respuesta mensaje', NULL, '2014-07-21', '20:16:00', 1),
(3, 'ken2014gu05fe2936239', 'chr2014za04ch2303313', 'HOLA KENN', NULL, '2014-07-21', '20:30:45', 1),
(4, 'chr2014za04ch2303313', 'jos2014fe04f31875702', 'Ya funciona!', NULL, '2014-07-21', '21:00:00', 1),
(5, 'jos2014fe04f31875702', 'chr2014za04ch2303313', 'JAJAJAJA SI :D', NULL, '2014-07-21', '21:05:12', 1),
(6, 'jos2014fe04f31875702', 'ken2014gu05fe2936239', 'HOLA FER HOLA FER HOLA FER HOLA FER HOLA FER HOLA FER HOLA FER HOLA FER HOLA FER HOLA FER HOLA FER HOLA FER HOLA FER HOLA FER HOLA FER HOLA FER HOLA FER HOLA FER HOLA FER HOLA FER HOLA FER HOLA FER HOLA FER HOLA FER HOLA FER HOLA FER HOLA FER ', NULL, '2014-07-22', '14:22:34', 1),
(7, 'chr2014za04ch2303313', 'jos2014fe04f31875702', 'Ultimo mensaje enviado', NULL, '2014-07-22', '19:54:33', 0),
(8, 'chr2014za04ch2303313', 'jos2014fe04f31875702', '[object HTMLDivElement]', 0x6e756c6c, '2014-07-24', '21:36:41', 0),
(9, 'chr2014za04ch2303313', 'jos2014fe04f31875702', '[object HTMLDivElement]', 0x6e756c6c, '2014-07-24', '21:37:41', 0),
(10, 'chr2014za04ch2303313', 'jos2014fe04f31875702', 'sssss', 0x6e756c6c, '2014-07-24', '21:38:38', 0),
(11, 'chr2014za04ch2303313', 'jos2014fe04f31875702', 'sssss', 0x6e756c6c, '2014-07-24', '21:38:58', 0),
(12, 'chr2014za04ch2303313', 'jos2014fe04f31875702', 'wwwwwwwwww', 0x6e756c6c, '2014-07-24', '21:39:08', 0),
(13, 'chr2014za04ch2303313', 'jos2014fe04f31875702', 'qqqqqqqq', 0x6e756c6c, '2014-07-24', '21:40:57', 0),
(14, 'chr2014za04ch2303313', 'jos2014fe04f31875702', 'QWERTY', 0x6e756c6c, '2014-07-24', '21:57:10', 0),
(15, 'chr2014za04ch2303313', 'jos2014fe04f31875702', 'lkjhkjn', 0x6e756c6c, '2014-07-24', '21:59:08', 0),
(16, 'chr2014za04ch2303313', 'jos2014fe04f31875702', 'kljlk', 0x6e756c6c, '2014-07-24', '21:59:51', 0),
(17, 'chr2014za04ch2303313', 'jos2014fe04f31875702', 'HOLA', 0x6e756c6c, '2014-07-24', '22:00:31', 0),
(18, 'jos2014fe04f31875702', 'chr2014za04ch2303313', 'Que hay!!!', 0x6e756c6c, '2014-07-24', '22:02:38', 1),
(19, 'jos2014fe04f31875702', 'chr2014za04ch2303313', 'de nuevo?', 0x6e756c6c, '2014-07-24', '22:10:37', 1),
(20, 'jos2014fe04f31875702', 'chr2014za04ch2303313', 'qwert', 0x6e756c6c, '2014-07-24', '22:14:48', 1),
(21, 'jos2014fe04f31875702', 'chr2014za04ch2303313', 'scroll', 0x6e756c6c, '2014-07-24', '22:15:41', 1),
(22, 'chr2014za04ch2303313', 'jos2014fe04f31875702', 'ASSAA', '', '2014-07-29', '16:58:21', 0),
(23, 'chr2014za04ch2303313', 'jos2014fe04f31875702', 'AQWE', '', '2014-07-29', '18:25:52', 0),
(24, 'flo2014fl05ma2412103', 'jos2014fe04f31875702', 'Testing!', '', '2014-07-31', '06:43:09', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `NotifID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` varchar(20) CHARACTER SET utf8 NOT NULL,
  `View` int(1) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  `User` varchar(20) CHARACTER SET utf8 NOT NULL,
  `Type` int(1) NOT NULL,
  `Ref` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`NotifID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=52 ;

--
-- Volcado de datos para la tabla `notifications`
--

INSERT INTO `notifications` (`NotifID`, `UserID`, `View`, `Date`, `Time`, `User`, `Type`, `Ref`) VALUES
(14, 'wal2014ce05wa2952499', 0, '2014-08-05', '12:22:31', 'jos2014fe04f31875702', 2, '757020030337405'),
(15, 'chr2014za04ch2303313', 0, '2014-08-05', '12:22:31', 'jos2014fe04f31875702', 2, '757020030337405'),
(16, 'ken2014gu05fe2936239', 1, '2014-08-05', '12:22:31', 'jos2014fe04f31875702', 2, '757020030337405'),
(17, 'flo2014fl05ma2412103', 0, '2014-08-05', '12:22:31', 'jos2014fe04f31875702', 2, '757020030337405'),
(18, 'ken2014gu05fe2936239', 1, '2014-08-05', '12:23:09', 'jos2014fe04f31875702', 1, 'ken2014gu05fe293623920140529023517'),
(19, 'wal2014ce05wa2952499', 0, '2014-08-05', '12:26:17', 'chr2014za04ch2303313', 2, '757020030337405'),
(20, 'ken2014gu05fe2936239', 1, '2014-08-05', '12:26:17', 'chr2014za04ch2303313', 2, '757020030337405'),
(21, 'jos2014fe04f31875702', 1, '2014-08-05', '12:26:17', 'chr2014za04ch2303313', 2, '757020030337405'),
(22, 'flo2014fl05ma2412103', 0, '2014-08-05', '12:26:17', 'chr2014za04ch2303313', 2, '757020030337405'),
(23, 'chr2014za04ch2303313', 0, '2014-08-05', '12:34:51', 'jos2014fe04f31875702', 3, '21'),
(35, 'flo2014fl05ma2412103', 0, '2014-08-05', '12:41:55', 'jos2014fe04f31875702', 4, '757020030337405'),
(34, 'ken2014gu05fe2936239', 0, '2014-08-05', '12:41:55', 'jos2014fe04f31875702', 4, '757020030337405'),
(33, 'chr2014za04ch2303313', 0, '2014-08-05', '12:41:55', 'jos2014fe04f31875702', 4, '757020030337405'),
(32, 'wal2014ce05wa2952499', 0, '2014-08-05', '12:41:55', 'jos2014fe04f31875702', 4, '757020030337405'),
(37, 'jos2014fe04f31875702', 1, '2014-08-05', '12:53:48', 'chr2014za04ch2303313', 5, '757020030337405-4'),
(38, 'jos2014fe04f31875702', 1, '2014-08-05', '14:10:22', 'chr2014za04ch2303313', 1, 'jos2014fe04f3187570220140629040214'),
(39, 'jos2014fe04f31875702', 1, '2014-08-05', '14:11:01', 'chr2014za04ch2303313', 3, '20'),
(40, 'wal2014ce05wa2952499', 0, '2014-08-05', '14:11:28', 'chr2014za04ch2303313', 4, '757020030337405'),
(41, 'ken2014gu05fe2936239', 0, '2014-08-05', '14:11:28', 'chr2014za04ch2303313', 4, '757020030337405'),
(42, 'jos2014fe04f31875702', 1, '2014-08-05', '14:11:28', 'chr2014za04ch2303313', 4, '757020030337405'),
(43, 'flo2014fl05ma2412103', 0, '2014-08-05', '14:11:28', 'chr2014za04ch2303313', 4, '757020030337405'),
(47, 'jos2014fe04f31875702', 1, '2014-08-05', '14:19:55', 'chr2014za04ch2303313', 6, 'chr2014za04ch2303313'),
(48, 'ken2014gu05fe2936239', 0, '2014-08-05', '17:37:14', 'jos2014fe04f31875702', 1, 'ken2014gu05fe293623920140529023517'),
(49, 'jos2014fe04f31875702', 1, '2014-08-05', '19:32:16', 'ken2014gu05fe2936239', 1, 'jos2014fe04f3187570220140629040214'),
(50, 'jos2014fe04f31875702', 1, '2014-08-05', '19:39:18', 'ken2014gu05fe2936239', 1, 'jos2014fe04f3187570220140629040214'),
(51, 'jos2014fe04f31875702', 1, '2014-08-06', '10:08:51', 'chr2014za04ch2303313', 1, 'jos2014fe04f3187570220140629040214');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `PostID` varchar(34) NOT NULL,
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
('ken2014gu05fe293623920140529082223', 'ken2014gu05fe2936239', 'LIVE THIS LIFE TO THE FULLEST!', '2014-05-29', '08:22:23', 1),
('jos2014fe04f3187570220140527035006', 'jos2014fe04f31875702', 'Testing! SantamarÃ­a', '2014-05-27', '03:50:06', 1),
('pru2014104ma243125020140520091933', 'pru2014104ma2431250', 'Testing', '2014-05-20', '09:19:33', 1),
('jos2014fe04f3187570220140605050407', 'jos2014fe04f31875702', 'Prueba 2', '2014-06-05', '17:04:07', 1),
('jos2014pã06pe067672120140605050519', 'jos2014pã06pe0676721', 'Prueba', '2014-06-05', '17:05:19', 1),
('jos2014fe04f3187570220140629020213', 'jos2014fe04f31875702', 'Prueba comentarios :D', '2014-06-29', '14:02:13', 1),
('jos2014fe04f3187570220140705024127', 'jos2014fe04f31875702', 'QWERTY', '2014-07-05', '14:41:27', 0),
('jos2014pã06pe067672120140605091038', 'jos2014pã06pe0676721', 'Prueba', '2014-06-05', '21:10:38', 1),
('ken2014gu05fe293623920140529020812', 'ken2014gu05fe2936239', 'BIEEEEN!', '2014-05-29', '02:08:12', 1),
('ken2014gu05fe293623920140529020827', 'ken2014gu05fe2936239', 'BIEEEN!', '2014-05-29', '02:08:27', 1),
('ken2014gu05fe293623920140529020851', 'ken2014gu05fe2936239', 'BIEEEN!', '2014-05-29', '02:08:51', 1),
('jos2014fe04f3187570220140629040214', 'jos2014fe04f31875702', 'Comentarios Video :D', '2014-06-29', '16:02:14', 1),
('jos2014fe04f3187570220140629034619', 'jos2014fe04f31875702', 'Prueba\r\n', '2014-06-29', '15:46:19', 0),
('ken2014gu05fe293623920140529023026', 'ken2014gu05fe2936239', 'Amo Java y PHP', '2014-05-29', '14:30:26', 1),
('ken2014gu05fe293623920140529023517', 'ken2014gu05fe2936239', 'me duele la kennette', '2014-05-29', '14:35:17', 1),
('jos2014fe04f3187570220140701051714', 'jos2014fe04f31875702', 'AAA', '2014-07-01', '17:17:14', 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=59 ;

--
-- Volcado de datos para la tabla `postcomments`
--

INSERT INTO `postcomments` (`CommentID`, `UserID`, `Content`, `View`, `Date`, `Time`, `PostID`) VALUES
(4, 'jos2014fe04f31875702', 'Verdad que si?', 1, '2014-06-29', '14:03:37', 'jos2014fe04f3187570220140629020213'),
(3, 'chr2014za04ch2303313', 'Genial!!!', 0, '2014-06-29', '14:00:15', 'jos2014fe04f3187570220140629020213'),
(5, 'jos2014fe04f31875702', 'CODERS', 1, '2014-06-28', '20:30:23', 'jos2014fe04f3187570220140629020213'),
(6, 'chr2014za04ch2303313', 'QuÃ© usas?', 1, '2014-06-28', '17:03:34', 'jos2014fe04f3187570220140629020213'),
(48, 'jos2014fe04f31875702', 'a', 0, '2014-07-05', '14:42:14', 'jos2014fe04f3187570220140701051714'),
(46, 'ken2014gu05fe2936239', 'AAA', 1, '2014-07-01', '17:29:04', 'jos2014fe04f3187570220140629020213'),
(47, 'jos2014fe04f31875702', 'AAA', 0, '2014-07-05', '14:41:57', 'jos2014fe04f3187570220140705024127'),
(21, 'chr2014za04ch2303313', 'Prueba 3 JAJAJA', 1, '2014-06-29', '16:02:54', 'jos2014fe04f3187570220140629040214'),
(44, 'jos2014fe04f31875702', 'quÃ© pasa?', 1, '2014-07-01', '16:28:54', 'jos2014fe04f3187570220140701042842'),
(20, 'jos2014fe04f31875702', 'Prueba 2', 1, '2014-06-29', '16:02:34', 'jos2014fe04f3187570220140629040214'),
(19, 'jos2014fe04f31875702', 'Prueba 1', 1, '2014-06-29', '16:02:26', 'jos2014fe04f3187570220140629040214'),
(49, 'jos2014fe04f31875702', 'ASD', 0, '2014-07-06', '10:47:03', 'jos2014fe04f3187570220140705024127'),
(43, 'chr2014za04ch2303313', 'JAJAJAAJA', 1, '2014-07-01', '15:14:08', 'ken2014gu05fe293623920140529023517'),
(26, 'jos2014fe04f31875702', 'Ahora si se puede web', 1, '2014-06-29', '18:55:14', 'jos2014fe04f3187570220140629020213'),
(35, 'jos2014fe04f31875702', 'y quÃ© es eso?', 1, '2014-06-29', '22:20:04', 'ken2014gu05fe293623920140529023517'),
(45, 'jos2014fe04f31875702', 'HOLA\n', 1, '2014-07-01', '17:26:14', 'ken2014gu05fe293623920140529023517'),
(50, 'jos2014fe04f31875702', 'sddf', 0, '2014-07-06', '17:38:37', 'jos2014fe04f3187570220140701051714'),
(51, 'jos2014fe04f31875702', 'En serio :o', 1, '2014-08-05', '11:46:34', 'ken2014gu05fe293623920140529023517'),
(52, 'jos2014fe04f31875702', 'O:', 1, '2014-08-05', '12:23:09', 'ken2014gu05fe293623920140529023517'),
(53, 'jos2014fe04f31875702', 'Web!', 1, '2014-08-05', '12:23:57', 'jos2014fe04f3187570220140629020213'),
(54, 'chr2014za04ch2303313', 'Se puede?', 1, '2014-08-05', '14:10:22', 'jos2014fe04f3187570220140629040214'),
(55, 'jos2014fe04f31875702', 'Kenn!', 1, '2014-08-05', '17:37:14', 'ken2014gu05fe293623920140529023517'),
(56, 'ken2014gu05fe2936239', 'Siiii :D', 1, '2014-08-05', '19:32:16', 'jos2014fe04f3187570220140629040214'),
(57, 'ken2014gu05fe2936239', 'Desde Perfil!', 1, '2014-08-05', '19:39:18', 'jos2014fe04f3187570220140629040214'),
(58, 'chr2014za04ch2303313', 'Prueba Web', 1, '2014-08-06', '10:08:51', 'jos2014fe04f3187570220140629040214');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postcomments_group`
--

CREATE TABLE IF NOT EXISTS `postcomments_group` (
  `CommentID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` varchar(20) CHARACTER SET utf8 NOT NULL,
  `PostID` int(11) NOT NULL,
  `Content` mediumtext CHARACTER SET utf8 NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  `View` int(11) NOT NULL,
  PRIMARY KEY (`CommentID`),
  UNIQUE KEY `CommentID_UNIQUE` (`CommentID`),
  KEY `fk_postcomments_group_post_group1_idx` (`PostID`),
  KEY `fk_postcomments_group_user_group1_idx` (`UserID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=39 ;

--
-- Volcado de datos para la tabla `postcomments_group`
--

INSERT INTO `postcomments_group` (`CommentID`, `UserID`, `PostID`, `Content`, `Date`, `Time`, `View`) VALUES
(38, 'chr2014za04ch2303313', 20, 'C?', '2014-08-05', '14:11:01', 1),
(36, 'jos2014fe04f31875702', 14, 'Comentario', '2014-07-06', '17:56:48', 1),
(37, 'jos2014fe04f31875702', 21, 'C?', '2014-08-05', '12:34:51', 1),
(35, 'chr2014za04ch2303313', 13, 'sfklfs', '2014-07-06', '13:46:11', 1),
(34, 'jos2014fe04f31875702', 13, 'aSSw', '2014-07-06', '13:46:05', 1),
(33, 'jos2014fe04f31875702', 11, 'HOLA', '2014-07-06', '13:42:11', 1),
(32, 'chr2014za04ch2303313', 11, 'HOLA', '2014-07-06', '13:42:03', 1),
(31, 'jos2014fe04f31875702', 11, 'JAJAJAJAJA', '2014-07-06', '13:38:33', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post_group`
--

CREATE TABLE IF NOT EXISTS `post_group` (
  `PostID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` varchar(20) CHARACTER SET utf8 NOT NULL,
  `GroupID` varchar(15) CHARACTER SET utf8 NOT NULL,
  `Content` longtext CHARACTER SET utf8 NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  `View` int(11) NOT NULL,
  PRIMARY KEY (`PostID`),
  UNIQUE KEY `PostID_UNIQUE` (`PostID`),
  KEY `fk_post_group_user_group1_idx` (`UserID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

--
-- Volcado de datos para la tabla `post_group`
--

INSERT INTO `post_group` (`PostID`, `UserID`, `GroupID`, `Content`, `Date`, `Time`, `View`) VALUES
(11, 'jos2014fe04f31875702', '757020410437129', 'ASD', '2014-07-05', '18:57:41', 1),
(10, 'jos2014fe04f31875702', '757020410437129', 'AAA', '2014-07-05', '17:21:14', 0),
(12, 'jos2014fe04f31875702', '757020867047360', 'AZS', '2014-07-05', '22:08:40', 1),
(13, 'chr2014za04ch2303313', '757020410437129', 'HI', '2014-07-06', '13:45:50', 1),
(14, 'jos2014fe04f31875702', '757021316815538', 'Primer Post', '2014-07-06', '17:56:32', 1),
(15, 'chr2014za04ch2303313', '757020030337405', 'Hola coders', '2014-07-29', '21:23:57', 0),
(21, 'chr2014za04ch2303313', '757020030337405', 'C', '2014-08-05', '12:26:17', 1),
(20, 'jos2014fe04f31875702', '757020030337405', 'B', '2014-08-05', '12:22:31', 1),
(19, 'jos2014fe04f31875702', '757020030337405', 'A', '2014-08-05', '12:02:50', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `userinformation`
--

CREATE TABLE IF NOT EXISTS `userinformation` (
  `UserID` varchar(20) NOT NULL,
  `RegistryDate` date DEFAULT NULL,
  `PrograLang` mediumtext,
  `Profession` varchar(255) DEFAULT NULL,
  `Skills` mediumtext,
  `Description` varchar(255) DEFAULT NULL,
  `Goals` mediumtext,
  `Website` varchar(255) DEFAULT NULL,
  `Country` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `UserID_UNIQUE` (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `userinformation`
--

INSERT INTO `userinformation` (`UserID`, `RegistryDate`, `PrograLang`, `Profession`, `Skills`, `Description`, `Goals`, `Website`, `Country`) VALUES
('jos2014fe04f31875702', '2014-04-22', 'HTML|CSS|Javascript|VB.Net', 'Estudiante', 'Prueba de skills', 'Music - Code - Videogames', 'Nuevos Proyectos', 'fersantamaria.com', 'El Salvador'),
('ken2014gu05fe2936239', '2014-08-01', '', NULL, NULL, NULL, NULL, NULL, ''),
('chr2014za04ch2303313', '2014-06-03', '', NULL, NULL, NULL, NULL, NULL, ''),
('flo2014fl05ma2412103', '2014-06-06', '', NULL, NULL, NULL, NULL, NULL, ''),
('jos2014fl05fl2413229', '2014-08-01', '', NULL, NULL, NULL, NULL, NULL, ''),
('wal2014ce05wa2952499', '2014-07-03', '', NULL, NULL, NULL, NULL, NULL, '');

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
('jos2014fe04f31875702', 'Fernando', 'SantamarÃ­a', 'f3rnand.flores@gmail.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '1996-04-22', 0, 1, 0),
('chr2014za04ch2303313', 'Christian', 'Zayas', 'chris.zayas2010@gmail.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '2014-10-07', 0, 1, 0),
('ken2014gu05fe2936239', 'Kennette', 'Guevara', 'fernando_kgr@hotmail.es', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '1996-06-05', 0, 0, 0),
('flo2014fl05ma2412103', 'Flores', 'Flores', 'mail@mail2.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '1986-12-20', 0, 0, 0),
('jos2014fl05fl2413229', 'JosÃ©', 'Flores', 'floresjose@mail.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '1995-04-22', 0, 0, 0),
('wal2014ce05wa2952499', 'Walter', 'Cerritos', 'walter_gonzalez@hotmail.es', '4ecfad5efbc93c7e62224d3bcf07ae7eb9faabf54ebd8e879b4a27ab629933c5', '1996-11-02', 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_group`
--

CREATE TABLE IF NOT EXISTS `user_group` (
  `User_groupID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` varchar(20) CHARACTER SET utf8 NOT NULL,
  `GroupID` varchar(15) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`User_groupID`),
  UNIQUE KEY `User_groupID_UNIQUE` (`User_groupID`),
  KEY `fk_user_group_users1_idx` (`UserID`),
  KEY `fk_user_group_group1_idx` (`GroupID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=71 ;

--
-- Volcado de datos para la tabla `user_group`
--

INSERT INTO `user_group` (`User_groupID`, `UserID`, `GroupID`) VALUES
(65, 'jos2014fe04f31875702', '757020498221963'),
(63, 'wal2014ce05wa2952499', '757020030337405'),
(68, 'chr2014za04ch2303313', '757020030337405'),
(70, 'ken2014gu05fe2936239', '757020030337405'),
(64, 'jos2014fe04f31875702', '757020030337405'),
(67, 'flo2014fl05ma2412103', '757020030337405');

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
