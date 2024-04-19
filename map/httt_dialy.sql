-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 19, 2024 lúc 12:51 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `httt_dialy`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chi_so_dien_nuoc`
--

CREATE TABLE `chi_so_dien_nuoc` (
  `ngay` date NOT NULL,
  `p_id` varchar(10) NOT NULL,
  `phieuthue_id` varchar(5) DEFAULT NULL,
  `csd_hientai` int(11) DEFAULT NULL,
  `nt_giadien` float DEFAULT NULL,
  `csn_hientai` int(11) DEFAULT NULL,
  `nt_gianuoc` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chi_tiet_tien_nghi`
--

CREATE TABLE `chi_tiet_tien_nghi` (
  `tn_ma` varchar(5) NOT NULL,
  `lp_id` varchar(5) NOT NULL,
  `cttn_soluong` int(11) DEFAULT NULL,
  `cttn_dongia` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chu_tro`
--

CREATE TABLE `chu_tro` (
  `ct_cccd` varchar(12) NOT NULL,
  `hoten` varchar(50) DEFAULT NULL,
  `ngaysinh` date DEFAULT NULL,
  `gioitinh` varchar(5) DEFAULT NULL,
  `sodienthoai` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoa_don`
--

CREATE TABLE `hoa_don` (
  `hd_ma` int(11) NOT NULL,
  `p_id` varchar(10) DEFAULT NULL,
  `httt_id` int(11) NOT NULL,
  `pbc_ma` varchar(5) NOT NULL,
  `ngaylap` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `huyen`
--

CREATE TABLE `huyen` (
  `h_id` int(11) NOT NULL,
  `tt_id` int(11) DEFAULT NULL,
  `h_ten` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khoangcach`
--

CREATE TABLE `khoangcach` (
  `nt_id` int(11) NOT NULL,
  `th_ma` int(11) NOT NULL,
  `khoangcach` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loai_phong`
--

CREATE TABLE `loai_phong` (
  `lp_id` varchar(5) NOT NULL,
  `nt_id` int(11) NOT NULL,
  `lp_ten` varchar(50) DEFAULT NULL,
  `lp_songuoitoida` int(11) DEFAULT NULL,
  `lp_dientich` float DEFAULT NULL,
  `lp_gia` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoi_thue`
--

CREATE TABLE `nguoi_thue` (
  `cccd` char(10) NOT NULL,
  `hoten` varchar(50) DEFAULT NULL,
  `ngaysinh` date DEFAULT NULL,
  `diachi` char(10) DEFAULT NULL,
  `sodienthoai` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nha_tro`
--

CREATE TABLE `nha_tro` (
  `nt_id` int(11) NOT NULL,
  `ct_cccd` varchar(12) NOT NULL,
  `x_id` int(11) NOT NULL,
  `nt_ten` varchar(50) DEFAULT NULL,
  `nt_diachi` varchar(200) DEFAULT NULL,
  `nt_soluongphong` int(11) DEFAULT NULL,
  `nt_kinhdo` decimal(10,6) DEFAULT NULL,
  `nt_vido` decimal(10,6) DEFAULT NULL,
  `nt_giadien` float DEFAULT NULL,
  `nt_gianuoc` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieu_bao`
--

CREATE TABLE `phieu_bao` (
  `p_id` varchar(10) DEFAULT NULL,
  `pbc_tongtien` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieu_bao_cuoc`
--

CREATE TABLE `phieu_bao_cuoc` (
  `pbc_ma` varchar(5) NOT NULL,
  `p_id` varchar(10) NOT NULL,
  `ngay` date NOT NULL,
  `pbc_tongtien` float DEFAULT NULL,
  `ngaylap` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieu_thue_phong`
--

CREATE TABLE `phieu_thue_phong` (
  `phieuthue_id` varchar(5) NOT NULL,
  `p_id` varchar(10) NOT NULL,
  `cccd` char(10) NOT NULL,
  `thoigianbatdau` date DEFAULT NULL,
  `thoigianketthuc` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phong`
--

CREATE TABLE `phong` (
  `p_id` varchar(10) NOT NULL,
  `lp_id` varchar(5) NOT NULL,
  `p_tinhtrang` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thang`
--

CREATE TABLE `thang` (
  `ngay` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thanh_toan`
--

CREATE TABLE `thanh_toan` (
  `httt_id` int(11) NOT NULL,
  `httt_ten` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tien_nghi`
--

CREATE TABLE `tien_nghi` (
  `tn_ma` varchar(5) NOT NULL,
  `tn_ten` varchar(50) DEFAULT NULL,
  `dongia` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tinh`
--

CREATE TABLE `tinh` (
  `tt_id` int(11) NOT NULL,
  `tt_ten` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `truonghoc`
--

CREATE TABLE `truonghoc` (
  `th_ma` int(11) NOT NULL,
  `x_id` int(11) NOT NULL,
  `th_ten` varchar(30) DEFAULT NULL,
  `th_diachi` varchar(200) DEFAULT NULL,
  `th_kinhdo` float DEFAULT NULL,
  `th_vido` float DEFAULT NULL,
  `th_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `truonghoc`
--

INSERT INTO `truonghoc` (`th_ma`, `x_id`, `th_ten`, `th_diachi`, `th_kinhdo`, `th_vido`, `th_image`) VALUES
(1, 1, 'Đại học cần thơ', 'Khu II Đại học Cần Thơ Đường 3/2', 10.0299, 105.771, 'dhct.jpg'),
(2, 1, 'Trường Đại học Nam Cần Thơ', '168 Nguyễn Văn Cừ Nối Dài, An Bình, Ninh Kiều, Cần Thơ, Việt Nam', 10.0075, 105.723, 'dhnct.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `xa`
--

CREATE TABLE `xa` (
  `x_id` int(11) NOT NULL,
  `h_id` int(11) DEFAULT NULL,
  `x_ten` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chi_so_dien_nuoc`
--
ALTER TABLE `chi_so_dien_nuoc`
  ADD PRIMARY KEY (`ngay`,`p_id`),
  ADD KEY `FK_Relationship_18` (`phieuthue_id`);

--
-- Chỉ mục cho bảng `chi_tiet_tien_nghi`
--
ALTER TABLE `chi_tiet_tien_nghi`
  ADD PRIMARY KEY (`tn_ma`,`lp_id`);

--
-- Chỉ mục cho bảng `chu_tro`
--
ALTER TABLE `chu_tro`
  ADD PRIMARY KEY (`ct_cccd`);

--
-- Chỉ mục cho bảng `hoa_don`
--
ALTER TABLE `hoa_don`
  ADD PRIMARY KEY (`hd_ma`),
  ADD KEY `FK_Relationship_5` (`p_id`);

--
-- Chỉ mục cho bảng `huyen`
--
ALTER TABLE `huyen`
  ADD PRIMARY KEY (`h_id`),
  ADD KEY `FK_Relationship_26` (`tt_id`);

--
-- Chỉ mục cho bảng `khoangcach`
--
ALTER TABLE `khoangcach`
  ADD PRIMARY KEY (`nt_id`,`th_ma`),
  ADD KEY `FK_Relationship_22` (`th_ma`);

--
-- Chỉ mục cho bảng `loai_phong`
--
ALTER TABLE `loai_phong`
  ADD PRIMARY KEY (`lp_id`);

--
-- Chỉ mục cho bảng `nguoi_thue`
--
ALTER TABLE `nguoi_thue`
  ADD PRIMARY KEY (`cccd`);

--
-- Chỉ mục cho bảng `nha_tro`
--
ALTER TABLE `nha_tro`
  ADD PRIMARY KEY (`nt_id`),
  ADD KEY `x_id` (`x_id`),
  ADD KEY `ct_cccd` (`ct_cccd`,`x_id`);

--
-- Chỉ mục cho bảng `phieu_bao_cuoc`
--
ALTER TABLE `phieu_bao_cuoc`
  ADD PRIMARY KEY (`pbc_ma`);

--
-- Chỉ mục cho bảng `phieu_thue_phong`
--
ALTER TABLE `phieu_thue_phong`
  ADD PRIMARY KEY (`phieuthue_id`);

--
-- Chỉ mục cho bảng `phong`
--
ALTER TABLE `phong`
  ADD PRIMARY KEY (`p_id`);

--
-- Chỉ mục cho bảng `thang`
--
ALTER TABLE `thang`
  ADD PRIMARY KEY (`ngay`);

--
-- Chỉ mục cho bảng `thanh_toan`
--
ALTER TABLE `thanh_toan`
  ADD PRIMARY KEY (`httt_id`);

--
-- Chỉ mục cho bảng `tien_nghi`
--
ALTER TABLE `tien_nghi`
  ADD PRIMARY KEY (`tn_ma`);

--
-- Chỉ mục cho bảng `tinh`
--
ALTER TABLE `tinh`
  ADD PRIMARY KEY (`tt_id`);

--
-- Chỉ mục cho bảng `truonghoc`
--
ALTER TABLE `truonghoc`
  ADD PRIMARY KEY (`th_ma`);

--
-- Chỉ mục cho bảng `xa`
--
ALTER TABLE `xa`
  ADD PRIMARY KEY (`x_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `truonghoc`
--
ALTER TABLE `truonghoc`
  MODIFY `th_ma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chi_so_dien_nuoc`
--
ALTER TABLE `chi_so_dien_nuoc`
  ADD CONSTRAINT `FK_Relationship_18` FOREIGN KEY (`phieuthue_id`) REFERENCES `phieu_thue_phong` (`phieuthue_id`);

--
-- Các ràng buộc cho bảng `hoa_don`
--
ALTER TABLE `hoa_don`
  ADD CONSTRAINT `FK_Relationship_5` FOREIGN KEY (`p_id`) REFERENCES `phong` (`p_id`);

--
-- Các ràng buộc cho bảng `huyen`
--
ALTER TABLE `huyen`
  ADD CONSTRAINT `FK_Relationship_26` FOREIGN KEY (`tt_id`) REFERENCES `tinh` (`tt_id`);

--
-- Các ràng buộc cho bảng `khoangcach`
--
ALTER TABLE `khoangcach`
  ADD CONSTRAINT `FK_Relationship_22` FOREIGN KEY (`th_ma`) REFERENCES `truonghoc` (`th_ma`),
  ADD CONSTRAINT `FK_Relationship_23` FOREIGN KEY (`nt_id`) REFERENCES `nha_tro` (`nt_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
