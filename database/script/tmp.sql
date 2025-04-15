INSERT INTO `cua_hang` (`ma`, `dia_chi`, `manvquan_ly`, `ten_cua_hang`) VALUES
(1, '123 Trần Hưng Đạo, Q1, TP.HCM', NULL, 'Chi nhánh Trung tâm'),
(2, '456 Lê Lợi, Q3, TP.HCM', NULL, 'Chi nhánh Q3'),
(3, '456 Lê Lợi, Q3, TP.HCM', NULL, 'Chi nhánh Q3');;

INSERT INTO `nhan_vien` (`ma`, `chuc_vu`, `dia_chi`, `email`, `gioi_tinh`, `ho_ten`, `luong_theo_gio`, `ngay_sinh`, `so_dien_thoai`, `ti_le_hoa_hong`, `cua_hang_ma`) VALUES
(101, 'Quản lý', 'TP.HCM', 'quanly@cuahang.com', 'Nam', 'Nguyễn Văn A', 50000, '1990-01-01', '0912345678', 0.1, 1),
(102, 'Nhân viên bán hàng', 'TP.HCM', 'nvb1@cuahang.com', 'Nữ', 'Trần Thị B', 30000, '1995-05-05', '0912123456', 0.05, 1),
(103, 'Thủ kho', 'TP.HCM', 'thukho@cuahang.com', 'Nam', 'Lê Văn C', 35000, '1992-03-15', '0933345678', 0.03, 2);

INSERT INTO `bang_luong` (`ma`, `khau_tru`, `luong_co_ban`, `nam_tinhluong`, `quy_tinh_luong`, `thang_tinh_luong`, `thuc_nhan`, `tong_gio_lam`, `tong_hoa_hong`, `nhan_vien_ma`) VALUES
(201, 100000, 5000000, 2025, 1, 3, 4900000, 160, 500000, 101),
(202, 80000, 4000000, 2025, 1, 3, 3920000, 150, 300000, 102),
(203, 70000, 4200000, 2025, 1, 3, 4130000, 155, 280000, 103);

INSERT INTO `cham_cong` (`ma`, `thoi_gian_ra`, `thoi_gian_vao`, `tong_gio_lam`, `trang_thai`, `bang_luong_ma`, `nhan_vien_ma`) VALUES
(301, '2025-03-01 17:00:00', '2025-03-01 08:00:00', 8, 'Hoàn tất', 201, 101),
(302, '2025-03-01 17:30:00', '2025-03-01 08:15:00', 8, 'Hoàn tất', 202, 102),
(303, '2025-03-01 17:10:00', '2025-03-01 08:00:00', 8, 'Hoàn tất', 203, 103);


-- 2. Thêm dữ liệu vào bảng kho
INSERT INTO `kho` (`ma`, `dia_chi`, `ten_kho`, `cua_hang_ma`) VALUES
(1, 'KCN Tân Bình, TP.HCM', 'Kho Nam', 1),
(2, 'KCN Bắc Thăng Long, Hà Nội', 'Kho Bắc', 2),
(3, 'KCN Hòa Khánh, Đà Nẵng', 'Kho Trung', 3);

-- 3. Thêm dữ liệu vào bảng loai_san_pham
INSERT INTO `loai_san_pham` (`ma`, `ten_loai`) VALUES
(1, 'Áo thun'),
(2, 'Quần jean'),
(3, 'Áo sơ mi'),
(4, 'Váy đầm'),
(5, 'Áo khoác');

-- 4. Thêm dữ liệu vào bảng size
INSERT INTO `size` (`ma`, `ten_size`) VALUES
(1, 'S'),
(2, 'M'),
(3, 'L'),
(4, 'XL'),
(5, 'XXL');

-- 5. Thêm dữ liệu vào bảng san_pham (để tránh lỗi với khóa ngoại ton_kho_ma, tạm thời để NULL)
INSERT INTO `san_pham` (`ma`, `gioi_tinh`, `hinh_san_pham`, `mo_ta`, `ngay_tao`, `ten_san_pham`, `trang_thai`, `loai_san_pham_ma`, `size_ma`, `ton_kho_ma`) VALUES
(1, 'Nam', 'ao_thun_nam_01.jpg', 'Áo thun nam cotton 100% thoáng mát', '2023-06-15 10:00:00', 'Áo thun nam basic', 'Đang bán', 1, 2, NULL),
(2, 'Nữ', 'vay_nu_01.jpg', 'Váy công sở thanh lịch', '2023-06-20 09:30:00', 'Váy công sở nữ', 'Đang bán', 4, 1, NULL),
(3, 'Nam', 'quan_jean_nam_01.jpg', 'Quần jean nam form slim fit', '2023-07-01 14:20:00', 'Quần jean nam basic', 'Đang bán', 2, 3, NULL),
(4, 'Nữ', 'ao_khoac_nu_01.jpg', 'Áo khoác nữ mùa đông ấm áp', '2023-07-10 11:45:00', 'Áo khoác nữ mùa đông', 'Đang bán', 5, 2, NULL),
(5, 'Nam', 'ao_so_mi_nam_01.jpg', 'Áo sơ mi nam dài tay công sở', '2023-07-15 08:30:00', 'Áo sơ mi nam công sở', 'Đang bán', 3, 4, NULL);

-- Thêm dữ liệu vào bảng image
INSERT INTO `image` (`id`, `url`, `san_pham_ma`) VALUES
-- Hình ảnh cho sản phẩm 1 (Áo thun nam basic)
(1001, '/images/products/ao_thun_nam_basic_1.jpg', 1),
(1002, '/images/products/ao_thun_nam_basic_2.jpg', 1),
(1003, '/images/products/ao_thun_nam_basic_3.jpg', 1),
(1004, '/images/products/ao_thun_nam_basic_4.jpg', 1),
(1005, '/images/products/vay_cong_so_nu_1.jpg', 2),
(1006, '/images/products/vay_cong_so_nu_2.jpg', 2),
(1007, '/images/products/vay_cong_so_nu_3.jpg', 2),
(1008, '/images/products/quan_jean_nam_basic_1.jpg', 3),
(1009, '/images/products/quan_jean_nam_basic_2.jpg', 3),
(1010, '/images/products/quan_jean_nam_basic_3.jpg', 3),
(1011, '/images/products/quan_jean_nam_basic_4.jpg', 3),
(1012, '/images/products/quan_jean_nam_basic_5.jpg', 3),
(1013, '/images/products/ao_khoac_nu_mua_dong_1.jpg', 4),
(1014, '/images/products/ao_khoac_nu_mua_dong_2.jpg', 4),
(1015, '/images/products/ao_khoac_nu_mua_dong_3.jpg', 4),
(1016, '/images/products/ao_so_mi_nam_cong_so_1.jpg', 5),
(1017, '/images/products/ao_so_mi_nam_cong_so_2.jpg', 5),
(1018, '/images/products/ao_so_mi_nam_cong_so_3.jpg', 5),
(1019, '/images/products/ao_so_mi_nam_cong_so_4.jpg', 5);

-- 6. Thêm dữ liệu vào bảng ton_kho
INSERT INTO `ton_kho` (`ma`, `so_luong`, `kho_ma`, `san_pham_ma`) VALUES
(1, 100, 1, 1),
(2, 50, 1, 2),
(3, 75, 2, 3),
(4, 30, 2, 4),
(5, 60, 3, 5),
(6, 45, 3, 1),
(7, 80, 1, 3);

-- 7. Cập nhật lại bảng san_pham để thêm khóa ngoại ton_kho_ma
UPDATE `san_pham` SET `ton_kho_ma` = 1 WHERE `ma` = 1;
UPDATE `san_pham` SET `ton_kho_ma` = 2 WHERE `ma` = 2;
UPDATE `san_pham` SET `ton_kho_ma` = 3 WHERE `ma` = 3;
UPDATE `san_pham` SET `ton_kho_ma` = 4 WHERE `ma` = 4;
UPDATE `san_pham` SET `ton_kho_ma` = 5 WHERE `ma` = 5;

-- 1. Thêm dữ liệu vào bảng don_hang
INSERT INTO `don_hang` (`ma`, `gia_giam`, `phuong_thuc`, `thoi_gian_ban`, `tong_gia_tri`, `trang_thai`, `cua_hang_ma`, `nhan_vien_ma`, `san_pham_ma`) VALUES
(401, 50000, 'Tiền mặt', '2025-03-05 14:30:00', 450000, 'Hoàn thành', 1, 102, 1),
(402, 0, 'Chuyển khoản', '2025-03-06 10:15:00', 750000, 'Hoàn thành', 1, 102, 2),
(403, 100000, 'Thẻ tín dụng', '2025-03-07 16:45:00', 900000, 'Hoàn thành', 2, 103, 3),
(404, 75000, 'Tiền mặt', '2025-03-08 09:20:00', 625000, 'Đang giao', 1, 102, 4),
(405, 0, 'Chuyển khoản', '2025-03-09 11:30:00', 850000, 'Đang xử lý', 2, 103, 5);

-- 2. Thêm dữ liệu vào bảng chi_tiet_don_hang
INSERT INTO `chi_tiet_don_hang` (`ma`, `don_gia`, `so_luong`, `don_hang_ma`, `san_pham_ma`) VALUES
(501, 250000, 2, 401, 1),
(502, 750000, 1, 402, 2),
(503, 350000, 3, 403, 3),
(504, 700000, 1, 404, 4),
(505, 850000, 1, 405, 5),
(506, 250000, 1, 401, 3),
(507, 350000, 1, 403, 1),
(508, 250000, 1, 404, 1);

-- 1. Thêm dữ liệu vào bảng nha_cung_cap
INSERT INTO `nha_cung_cap` (`ma`, `so_dien_thoai`, `ten_nha_cung_cap`) VALUES
(601, '0987654321', 'Công ty May mặc Phương Nam'),
(602, '0912345678', 'Xưởng dệt Bắc Giang'),
(603, '0933222111', 'Nhà máy quần áo Hưng Thịnh'),
(604, '0944555666', 'Công ty TNHH thời trang Việt Á'),
(605, '0977888999', 'Xưởng may Miền Trung');

-- 2. Thêm dữ liệu vào bảng phieu_nhap_kho
INSERT INTO `phieu_nhap_kho` (`ma`, `thoi_gian_nhap`, `tong_gia_nhap`, `nha_cung_cap_ma`, `nhan_vien_ma`) VALUES
(701, '2025-02-15 09:00:00', 12500000, 601, 103),
(702, '2025-02-20 14:30:00', 8750000, 602, 103),
(703, '2025-02-28 10:15:00', 15000000, 603, 101),
(704, '2025-03-05 08:45:00', 9300000, 604, 103),
(705, '2025-03-10 13:20:00', 11250000, 601, 103);

-- 3. Thêm dữ liệu vào bảng chi_tiet_phieu_nhap
INSERT INTO `chi_tiet_phieu_nhap` (`ma`, `gia_ban`, `gia_nhap`, `so_luong`, `phieu_nhap_kho_ma`, `san_pham_ma`) VALUES
(801, 250000, 150000, 30, 701, 1),
(802, 750000, 450000, 10, 701, 2),
(803, 350000, 200000, 25, 702, 3),
(804, 700000, 400000, 15, 702, 4),
(805, 850000, 500000, 30, 703, 5),
(806, 250000, 150000, 20, 703, 1),
(807, 350000, 200000, 15, 704, 3),
(808, 700000, 420000, 12, 704, 4),
(809, 850000, 500000, 15, 705, 5),
(810, 750000, 450000, 10, 705, 2);

-- 1. Thêm dữ liệu vào bảng role
INSERT INTO `role` (`ma`, `chuc_vu`) VALUES
(901, 'ADMIN'),
(902, 'MANAGER'),
(903, 'STAFF'),
(904, 'WAREHOUSE'),
(905, 'CASHIER');

-- 2. Thêm dữ liệu vào bảng tai_khoan
-- Lưu ý: Mật khẩu được lưu ở đây chỉ là mật khẩu mẫu, trong thực tế nên mã hóa mật khẩu
INSERT INTO `tai_khoan` (`ma`, `mat_khau`, `quyen`, `ten_dang_nhap`, `thoi_gian_tao`, `trang_thai`, `nhan_vien_ma`, `role_ma`) VALUES
(1001, '$2a$10$xyzABC123DefGHI456JKL', 'ADMIN', 'admin', '2024-12-15 08:00:00', 1, 101, 901),
(1002, '$2a$10$abcDEF789GhiJKL123MNO', 'STAFF', 'nhanvien1', '2024-12-15 09:30:00', 1, 102, 903),
(1003, '$2a$10$pqrSTU456VwxYZ789ABC', 'WAREHOUSE', 'thukho1', '2024-12-15 10:45:00', 1, 103, 904);