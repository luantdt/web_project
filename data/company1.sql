-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2022 at 04:44 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `company1`
--
CREATE DATABASE IF NOT EXISTS `company1` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `company1`;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount_people` int(11) NOT NULL,
  `description` mediumtext NOT NULL,
  `leader_id` int(11) NOT NULL COMMENT 'id của user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `name`, `amount_people`, `description`, `leader_id`) VALUES
(1, 'Nhân Sự', 15, 'Phòng Quản lý nhân sự', 12),
(2, 'Giám Đốc', 1, 'Nơi quản lý hết mọi thứ', 17),
(4, 'IT', 50, 'Phòng công nghệ thông tin', 23);

-- --------------------------------------------------------

--
-- Table structure for table `nghi_phep`
--

CREATE TABLE `nghi_phep` (
  `id` int(11) NOT NULL,
  `user_created` int(11) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `reason` varchar(5000) NOT NULL,
  `status` varchar(50) NOT NULL,
  `feelback` varchar(5000) NOT NULL,
  `responder` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nghi_phep`
--

INSERT INTO `nghi_phep` (`id`, `user_created`, `start`, `end`, `reason`, `status`, `feelback`, `responder`) VALUES
(2, 16, '2022-01-13', '2022-01-18', 'Bệnh covid', 'đồng ý', 'Ok... được phép nghỉ', 'leader'),
(3, 16, '2022-01-13', '2022-01-18', 'bênh', 'từ chối', 'Hông bé ơi', 'leader'),
(4, 16, '2022-01-13', '2022-01-20', 'bệnh', '', '', ''),
(5, 16, '2022-01-13', '2022-01-19', 'bệnh', 'từ chối', 'Không được. Nghỉ quá nhiều rồi', 'admin'),
(6, 15, '2022-01-13', '2022-01-25', 'bệnh', '', '', ''),
(7, 15, '2022-01-20', '2022-01-31', 'bệnh sếp ơi', 'đồng ý', 'ok nha em', 'admin'),
(8, 20, '2022-01-14', '2022-01-19', 'Có việc ở gia đình', '', '', ''),
(9, 15, '2022-01-14', '2022-01-22', 'Sếp cho xin phép nghỉ một ngày. Chở vợ đi đẻ', '', '', ''),
(10, 24, '2022-01-19', '2022-01-29', 'Nhà có việc', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `description` mediumtext NOT NULL,
  `summary` varchar(1000) NOT NULL,
  `creation_time` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `end_time` datetime NOT NULL,
  `department_id` int(11) NOT NULL,
  `user_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `name`, `user_id`, `status`, `description`, `summary`, `creation_time`, `end_time`, `department_id`, `user_created`) VALUES
(1, 'Khảo sát 1', 16, 'completed', 'Khảo sát thị trường TP HCM, nhằm tăng phạm vi kinh doanh', 'Khảo sát thị trường TP HCM', '2022-01-13 03:37:09', '2022-01-27 01:50:42', 1, 15),
(2, 'Khảo sát 2', 16, 'completed', 'Khảo sát thị trường Hà Nội, nhằm tăng phạm vi kinh doanh', 'Khảo sát thị trường Hà Nội', '2022-01-14 02:46:30', '2022-01-21 16:22:00', 1, 15),
(3, 'Khảo sát 3', 12, 'canceled', 'Khảo sát khu vực Đà Nẵng, nhằm tăng phạm vi kinh doanh', 'Khảo sát thị trường Hà Nội', '2022-01-14 21:14:47', '2014-01-22 16:15:00', 1, 15),
(9, 'Khảo sát 4', 16, 'canceled', 'Tìm hiểu dân số, phong tục, tập  quán và thời gian thích hợp để mở rộng kinh doang', 'Khảo sát thị trường An giang', '2022-01-13 16:43:26', '2021-10-18 12:59:00', 1, 15),
(10, 'Khảo sát 5', 16, 'reject', 'Khảo sát thị trường Cần Thơ......', 'Khảo sát thị trường Cần Thơ', '2022-01-14 03:12:56', '2022-01-28 03:12:00', 1, 15),
(11, 'Khảo sát 6', 16, 'waiting', 'test 1', 'test 1', '2022-01-14 03:19:33', '2022-01-30 03:17:00', 1, 15),
(12, 'Khảo sát 7', 16, 'in progress', 'test 2', 'test 2', '2022-01-14 03:19:48', '2022-01-29 03:18:00', 1, 15),
(13, 'Khảo sát 8', 20, 'completed', 'khảo sát 8', 'khảo sát 8', '2022-01-15 17:05:55', '2022-01-27 12:58:00', 1, 15),
(14, 'Công việc mới', 24, 'waiting', 'Công việc bắt đầu cho ngày mới', 'Công việc bắt đầu cho ngày mới', '2022-01-15 17:11:19', '2022-01-31 16:53:00', 4, 23);

-- --------------------------------------------------------

--
-- Table structure for table `tuong_tac_task`
--

CREATE TABLE `tuong_tac_task` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `file` varchar(3000) NOT NULL,
  `comment` text NOT NULL,
  `time` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tuong_tac_task`
--

INSERT INTO `tuong_tac_task` (`id`, `task_id`, `file`, `comment`, `time`, `user_id`, `status`) VALUES
(9, 1, '/public/task//public/task/5k.png', 'Em gửi báo cáo anh ơi...', '2022-01-12 21:29:24', 16, 'rejected'),
(10, 1, '/public/task/51900815_TranVuLuan_Tuan1.png', 'hông bé ơi', '2022-01-12 21:32:09', 15, 'rejected'),
(11, 1, '/public/task//public/task/ask.png', 'ok chưa anh', '2022-01-12 21:33:12', 16, 'rejected'),
(12, 1, '/public/task/an-toan-mang.jpg', 'no... làm theo mẫu', '2022-01-12 21:35:17', 17, 'rejected'),
(13, 1, '/public/task//public/task/bhyt2.png', 'finish', '2022-01-12 21:36:24', 16, 'completed'),
(14, 1, '', 'ok', '2022-01-12 21:37:09', 17, 'completed'),
(16, 2, '/public/task//public/task/bluetooth.jpg', '', '2022-01-13 18:34:06', 16, 'completed'),
(17, 2, '', 'aa', '2022-01-13 20:46:30', 15, 'completed'),
(18, 10, '/public/task/broadcasting-dark.png', 'gửi', '2022-01-13 20:47:28', 16, 'reject'),
(19, 10, '/public/task/dienmayxanh-amp.jpg', 'từ chối', '2022-01-13 21:12:23', 15, 'reject'),
(20, 11, '/public/task/dienmayxanh-amp.jpg', 'okok', '2022-01-13 21:19:33', 16, 'waiting'),
(21, 12, '/public/task/promise_hau.png', 'okok', '2022-01-13 21:19:48', 16, 'waiting'),
(30, 14, '/public/task/dienmayxanh-amp.jpg', '', '2022-01-15 11:11:19', 24, 'waiting');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullName` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `birthday` date NOT NULL,
  `gender` varchar(10) CHARACTER SET utf8 NOT NULL,
  `role` varchar(100) NOT NULL,
  `pic` text NOT NULL,
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullName`, `username`, `password`, `birthday`, `gender`, `role`, `pic`, `department_id`) VALUES
(12, 'alabatrap', 'dntrphu1311', '$2y$10$Yn0AjZbyx7QHE9ucUUiiZu9os43quabOB18pC79NNpXPARz754BRu', '2011-01-11', 'Nam', 'employee', '/public/avt/default.jpg', 1),
(15, 'Phu Trong duong nguyen', 'leader', '$2y$10$iSxGE4VAcZkE3T5LxDtOJeC0c/u5sG/qxUVEfcqGeULrTsy4.0vpW', '2011-11-22', 'Nam', 'leader', '/public/avt/av15.png', 1),
(16, 'newmember', 'newmember', '$2y$10$z8AaaslZx1RiuXko7DnJ5eFO9IbGttACkNJB7ALZ6cB3X25jVN2wG', '2022-01-06', 'Nam', 'employee', '/public/avt/av16.jpg', 1),
(17, 'Tran Vu Luan', 'admin', '$2y$10$w3HOgKGZfPCZep3MOSCMa.WlkjZ9ZKLqit74fz0LOjJ6FbhZhKy82', '2022-01-04', 'Nam', 'admin', '/public/avt/av17.jpg', 2),
(20, 'Steve Cook', 'employee', '$2y$10$z8AaaslZx1RiuXko7DnJ5eFO9IbGttACkNJB7ALZ6cB3X25jVN2wG', '2022-01-20', 'Nam', 'employee', '/public/avt/default.jpg', 1),
(23, 'Visual Studio Code', 'code', '$2y$10$z8AaaslZx1RiuXko7DnJ5eFO9IbGttACkNJB7ALZ6cB3X25jVN2wG', '2022-01-15', 'Nam', 'leader', '/public/avt/default.jpg', 4),
(24, 'Celine Dion', 'dion', '$2y$10$z8AaaslZx1RiuXko7DnJ5eFO9IbGttACkNJB7ALZ6cB3X25jVN2wG', '2022-01-01', 'Nữ', 'employee', '/public/avt/default.jpg', 4),
(27, 'Tran Vu Luan', 'luan', '$2y$10$o2Kup0nNXWKAzRWW7V5AleuWsolUWSVsOwEkTKZXYrzNqpVGArQuK', '2016-01-14', 'Nam', 'employee', '/public/avt/default.jpg', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nghi_phep`
--
ALTER TABLE `nghi_phep`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_created_leave` (`user_created`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_task_department` (`department_id`),
  ADD KEY `fk_user_created` (`user_created`);

--
-- Indexes for table `tuong_tac_task`
--
ALTER TABLE `tuong_tac_task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_task_id` (`task_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `fk_ten` (`department_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `nghi_phep`
--
ALTER TABLE `nghi_phep`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tuong_tac_task`
--
ALTER TABLE `tuong_tac_task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nghi_phep`
--
ALTER TABLE `nghi_phep`
  ADD CONSTRAINT `fk_user_created_leave` FOREIGN KEY (`user_created`) REFERENCES `users` (`id`);

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `fk_task_department` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`),
  ADD CONSTRAINT `fk_user_created` FOREIGN KEY (`user_created`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tuong_tac_task`
--
ALTER TABLE `tuong_tac_task`
  ADD CONSTRAINT `fk_task_id` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`),
  ADD CONSTRAINT `tuong_tac_task_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_ten` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
