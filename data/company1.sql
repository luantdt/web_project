-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2022 at 10:18 PM
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
(2, 'Giám Đốc', 1, 'Nơi quản lý hết mọi thứ', 17);

-- --------------------------------------------------------

--
-- Table structure for table `employee_leave`
--

CREATE TABLE `employee_leave` (
  `id` int(11) DEFAULT NULL,
  `token` int(11) NOT NULL,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  `reason` char(100) DEFAULT NULL,
  `status` char(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_leave`
--

INSERT INTO `employee_leave` (`id`, `token`, `start`, `end`, `reason`, `status`) VALUES
(12, 1, '2020-09-03', '2020-09-05', 'COVID-19', 'Cancelled'),
(12, 3, '2020-09-10', '2020-09-12', 'May Lagnat', 'Cancelled'),
(12, 4, '2021-12-29', '2021-12-30', 'lazy', 'Approved'),
(15, 5, '2021-12-30', '2021-12-31', 'lazy', 'Approved');

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
  `submit_status` varchar(50) NOT NULL,
  `end_time` datetime NOT NULL,
  `department_id` int(11) NOT NULL,
  `user_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `name`, `user_id`, `status`, `description`, `summary`, `creation_time`, `submit_status`, `end_time`, `department_id`, `user_created`) VALUES
(1, 'Khảo sát 1', 16, 'completed', 'Khảo sát thị trường TP HCM, nhằm tăng phạm vi kinh doanh', 'Khảo sát thị trường TP HCM', '2022-01-13 03:37:09', '', '2022-01-27 01:50:42', 1, 15),
(2, 'Khảo sát 2', 16, 'in progress', 'Khảo sát thị trường Hà Nội, nhằm tăng phạm vi kinh doanh', 'Khảo sát thị trường Hà Nội', '2022-01-13 03:41:54', 'Đã giao', '2022-01-31 01:52:33', 1, 15),
(3, 'Khảo sát 3', 12, 'new', 'Khảo sát khu vực Đà Nẵng, nhằm tăng phạm vi kinh doanh', 'Khảo sát thị trường Hà Nội', '2022-01-12 21:07:16', 'Đã Giao', '2022-01-18 13:10:32', 1, 15);

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
(14, 1, '', 'ok', '2022-01-12 21:37:09', 17, 'completed');

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
  `gender` varchar(10) NOT NULL,
  `role` varchar(100) NOT NULL,
  `pic` text NOT NULL,
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullName`, `username`, `password`, `birthday`, `gender`, `role`, `pic`, `department_id`) VALUES
(12, 'alabatrap', 'dntrphu1311', '$2y$10$ms6c5hjMFzi0A.IvDbZn9.a4P7127qiUV7XFbGfbU7MnCPVWvQEq', '2011-01-11', 'Male', 'employee', '/public/avt/default.jpg', 1),
(15, 'Phu Trong duong nguyen', 'leader', '$2y$10$iSxGE4VAcZkE3T5LxDtOJeC0c/u5sG/qxUVEfcqGeULrTsy4.0vpW', '2011-11-22', 'Male', 'leader', '/public/avt/av15.jpg', 1),
(16, 'newmember', 'newmember', '$2y$10$z8AaaslZx1RiuXko7DnJ5eFO9IbGttACkNJB7ALZ6cB3X25jVN2wG', '2022-01-06', 'Male', 'employee', '/public/avt/av16.jpg', 1),
(17, 'Tran Vu Luan', 'admin', '$2y$10$WAZm2hZ2RJPR9SeFe9ICkuYf7zxNmZYOwnC0DcUnoyqdwNKbWzrfu', '2022-01-04', 'male', 'admin', '/public/avt/av17.jpg', 2),
(19, 'a', 'a', 'abc', '0000-00-00', '', '', '', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_leave`
--
ALTER TABLE `employee_leave`
  ADD PRIMARY KEY (`token`),
  ADD KEY `employee_leave_ibfk_1` (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employee_leave`
--
ALTER TABLE `employee_leave`
  MODIFY `token` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tuong_tac_task`
--
ALTER TABLE `tuong_tac_task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee_leave`
--
ALTER TABLE `employee_leave`
  ADD CONSTRAINT `employee_leave_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
