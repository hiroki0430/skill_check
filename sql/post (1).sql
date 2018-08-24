-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2018 年 8 月 24 日 03:57
-- サーバのバージョン： 10.1.30-MariaDB
-- PHP Version: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Book`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `post`
--

CREATE TABLE `post` (
  `post_id` int(10) NOT NULL,
  `post_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `post_comment` varchar(255) CHARACTER SET utf8 NOT NULL,
  `post_pic` varchar(255) CHARACTER SET utf8 NOT NULL,
  `member_id` int(10) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `post`
--

INSERT INTO `post` (`post_id`, `post_name`, `post_comment`, `post_pic`, `member_id`, `created`, `modified`) VALUES
(2, 'test', 'test', '20180722101751IMG_3579.JPG', 1, '2018-07-21 19:42:53', '2018-07-26 08:35:42'),
(4, 'test2', 'test2', '20180721154650IMG_3586.JPG', 1, '2018-07-21 22:46:50', '2018-07-26 00:47:05'),
(5, '三国志', '関羽ぐらい髭のばしてみようかな。', '20180721161525三国志.jpg', 1, '2018-07-21 23:15:25', '2018-07-21 14:15:25'),
(6, 'LIFESHIFT', '私たちは１００年生きる事になる。その為、人生６０、７０年で考えていたような、古い価値観では生きていけない。自分なりに１００年楽しく生きていける方法を考える必要があると感じた本。', '20180722052314CertificateSigningRequest.jpg', 1, '2018-07-22 12:23:14', '2018-07-22 03:23:14'),
(7, '英語文法ノート', '文法を英語で学ぶのは２倍疲れる。', '20180722090545IMG_3542.JPG', 2, '2018-07-22 13:08:39', '2018-07-22 07:05:45'),
(8, 'キングダム', 'ヤングジャンプで連載中。', '20180722064855S5100035806661.jpg', 2, '2018-07-22 13:48:55', '2018-07-22 04:48:55'),
(9, '広辞苑', 'ぶ厚い。', '2018072211014641agTei2jwL._SX339_BO1,204,203,200_.jpg', 1, '2018-07-22 18:01:46', '2018-07-22 09:01:46'),
(10, 'なめらかなお金がめぐる社会', 'ルームメイトのおすすめ。', '20180726101746pelo.jpg', 1, '2018-07-26 17:17:46', '2018-07-26 08:17:46'),
(11, '日本再興戦略', '新しい価値観。', '20180726102006日本.jpg', 1, '2018-07-26 17:20:06', '2018-07-26 08:20:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
