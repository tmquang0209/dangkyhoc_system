-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th10 14, 2023 lúc 10:07 PM
-- Phiên bản máy phục vụ: 10.3.39-MariaDB-cll-lve
-- Phiên bản PHP: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `tmquangt_dkh`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `classroom`
--

CREATE TABLE `classroom` (
  `classroom_code` varchar(6) NOT NULL,
  `major_code` varchar(2) DEFAULT NULL,
  `class_name` varchar(10) NOT NULL,
  `consultant` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `enroll`
--

CREATE TABLE `enroll` (
  `id` int(11) NOT NULL,
  `student_code` varchar(6) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `group`
--

CREATE TABLE `group` (
  `id_group` int(11) NOT NULL,
  `group_name` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `major`
--

CREATE TABLE `major` (
  `major_code` varchar(2) NOT NULL,
  `major_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `major_teacher`
--

CREATE TABLE `major_teacher` (
  `major_code` varchar(2) NOT NULL,
  `teacher_code` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `semester_id` int(11) DEFAULT NULL,
  `subject_code` varchar(10) NOT NULL,
  `class_name` varchar(100) NOT NULL,
  `day` int(11) NOT NULL,
  `shift` varchar(5) NOT NULL,
  `classroom` varchar(20) NOT NULL,
  `teacher_code` varchar(6) DEFAULT NULL,
  `num_student` smallint(6) DEFAULT 10
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `semester`
--

CREATE TABLE `semester` (
  `semester_id` int(11) NOT NULL,
  `semester_name` varchar(30) NOT NULL,
  `id_group` int(11) DEFAULT NULL,
  `year` varchar(10) NOT NULL,
  `cash` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `semester_register`
--

CREATE TABLE `semester_register` (
  `semester_id` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `staff`
--

CREATE TABLE `staff` (
  `staff_code` varchar(6) NOT NULL,
  `staff_name` varchar(150) NOT NULL,
  `password` text NOT NULL,
  `email` varchar(150) NOT NULL,
  `birthday` date DEFAULT NULL,
  `phone_number` varchar(10) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `student`
--

CREATE TABLE `student` (
  `student_code` varchar(6) NOT NULL,
  `student_name` varchar(150) NOT NULL,
  `password` text NOT NULL,
  `email` varchar(150) NOT NULL,
  `birthday` date DEFAULT NULL,
  `phone_number` varchar(10) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `classroom_code` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `subject`
--

CREATE TABLE `subject` (
  `subject_code` varchar(8) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `credits` int(11) NOT NULL,
  `coef` double NOT NULL,
  `major_code` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `teacher`
--

CREATE TABLE `teacher` (
  `teacher_code` varchar(6) NOT NULL,
  `teacher_name` varchar(150) NOT NULL,
  `password` text NOT NULL,
  `email` varchar(150) NOT NULL,
  `birthday` date DEFAULT NULL,
  `phone_number` varchar(10) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tuition`
--

CREATE TABLE `tuition` (
  `tuition_id` int(11) NOT NULL,
  `student_code` varchar(6) DEFAULT NULL,
  `semester_id` int(11) NOT NULL,
  `status` varchar(40) DEFAULT 'CHUA_THU_TAM_LUU',
  `date_create` datetime NOT NULL DEFAULT current_timestamp(),
  `date_payment` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tuition_detail`
--

CREATE TABLE `tuition_detail` (
  `tuition_id` int(11) NOT NULL,
  `subject_code` varchar(8) NOT NULL,
  `credits` int(11) NOT NULL,
  `coef` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `classroom`
--
ALTER TABLE `classroom`
  ADD PRIMARY KEY (`classroom_code`),
  ADD KEY `major_code` (`major_code`),
  ADD KEY `consultant` (`consultant`);

--
-- Chỉ mục cho bảng `enroll`
--
ALTER TABLE `enroll`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_code` (`student_code`),
  ADD KEY `schedule_id` (`schedule_id`);

--
-- Chỉ mục cho bảng `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`id_group`);

--
-- Chỉ mục cho bảng `major`
--
ALTER TABLE `major`
  ADD PRIMARY KEY (`major_code`);

--
-- Chỉ mục cho bảng `major_teacher`
--
ALTER TABLE `major_teacher`
  ADD PRIMARY KEY (`major_code`,`teacher_code`),
  ADD KEY `teacher_code` (`teacher_code`);

--
-- Chỉ mục cho bảng `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `semester_id` (`semester_id`),
  ADD KEY `subject_code` (`subject_code`),
  ADD KEY `schedule_ibfk_3` (`teacher_code`);

--
-- Chỉ mục cho bảng `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`semester_id`),
  ADD KEY `id_group` (`id_group`);

--
-- Chỉ mục cho bảng `semester_register`
--
ALTER TABLE `semester_register`
  ADD KEY `semester_id` (`semester_id`);

--
-- Chỉ mục cho bảng `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_code`);

--
-- Chỉ mục cho bảng `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_code`),
  ADD KEY `class_room_code` (`classroom_code`);

--
-- Chỉ mục cho bảng `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_code`),
  ADD KEY `major_code` (`major_code`);

--
-- Chỉ mục cho bảng `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacher_code`);

--
-- Chỉ mục cho bảng `tuition`
--
ALTER TABLE `tuition`
  ADD PRIMARY KEY (`tuition_id`),
  ADD KEY `student_code` (`student_code`),
  ADD KEY `semester_id` (`semester_id`);

--
-- Chỉ mục cho bảng `tuition_detail`
--
ALTER TABLE `tuition_detail`
  ADD KEY `subject_code` (`subject_code`),
  ADD KEY `tuition_id` (`tuition_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `enroll`
--
ALTER TABLE `enroll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `group`
--
ALTER TABLE `group`
  MODIFY `id_group` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `semester`
--
ALTER TABLE `semester`
  MODIFY `semester_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tuition`
--
ALTER TABLE `tuition`
  MODIFY `tuition_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `classroom`
--
ALTER TABLE `classroom`
  ADD CONSTRAINT `classroom_ibfk_1` FOREIGN KEY (`major_code`) REFERENCES `major` (`major_code`),
  ADD CONSTRAINT `classroom_ibfk_2` FOREIGN KEY (`consultant`) REFERENCES `teacher` (`teacher_code`);

--
-- Các ràng buộc cho bảng `enroll`
--
ALTER TABLE `enroll`
  ADD CONSTRAINT `enroll_ibfk_1` FOREIGN KEY (`student_code`) REFERENCES `student` (`student_code`),
  ADD CONSTRAINT `enroll_ibfk_2` FOREIGN KEY (`schedule_id`) REFERENCES `schedule` (`id`);

--
-- Các ràng buộc cho bảng `major_teacher`
--
ALTER TABLE `major_teacher`
  ADD CONSTRAINT `major_teacher_ibfk_1` FOREIGN KEY (`major_code`) REFERENCES `major` (`major_code`),
  ADD CONSTRAINT `major_teacher_ibfk_2` FOREIGN KEY (`teacher_code`) REFERENCES `teacher` (`teacher_code`);

--
-- Các ràng buộc cho bảng `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`semester_id`) REFERENCES `semester` (`semester_id`),
  ADD CONSTRAINT `schedule_ibfk_2` FOREIGN KEY (`subject_code`) REFERENCES `subject` (`subject_code`),
  ADD CONSTRAINT `schedule_ibfk_3` FOREIGN KEY (`teacher_code`) REFERENCES `teacher` (`teacher_code`);

--
-- Các ràng buộc cho bảng `semester`
--
ALTER TABLE `semester`
  ADD CONSTRAINT `semester_ibfk_1` FOREIGN KEY (`id_group`) REFERENCES `group` (`id_group`);

--
-- Các ràng buộc cho bảng `semester_register`
--
ALTER TABLE `semester_register`
  ADD CONSTRAINT `semester_register_ibfk_1` FOREIGN KEY (`semester_id`) REFERENCES `semester` (`semester_id`);

--
-- Các ràng buộc cho bảng `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`classroom_code`) REFERENCES `classroom` (`classroom_code`);

--
-- Các ràng buộc cho bảng `subject`
--
ALTER TABLE `subject`
  ADD CONSTRAINT `subject_ibfk_1` FOREIGN KEY (`major_code`) REFERENCES `major` (`major_code`);

--
-- Các ràng buộc cho bảng `tuition`
--
ALTER TABLE `tuition`
  ADD CONSTRAINT `tuition_student_ibfk_1` FOREIGN KEY (`student_code`) REFERENCES `student` (`student_code`),
  ADD CONSTRAINT `tuition_student_ibfk_2` FOREIGN KEY (`semester_id`) REFERENCES `semester` (`semester_id`);

--
-- Các ràng buộc cho bảng `tuition_detail`
--
ALTER TABLE `tuition_detail`
  ADD CONSTRAINT `tuition_ibfk_2` FOREIGN KEY (`subject_code`) REFERENCES `subject` (`subject_code`),
  ADD CONSTRAINT `tuition_ibfk_3` FOREIGN KEY (`tuition_id`) REFERENCES `tuition` (`tuition_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
