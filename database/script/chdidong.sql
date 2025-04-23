
CREATE TABLE chitiethoadon (
  idHD int NOT NULL,
  idSP int NOT NULL,
  SOLUONG int NOT NULL,
  GIABAN float NOT NULL
);

INSERT INTO chitiethoadon (idHD, idSP, SOLUONG, GIABAN) VALUES
(6, 4, 1, 0),
(7, 3, 1, 0),
(8, 3, 1, 0),
(8, 4, 1, 0),
(8, 6, 1, 0),
(8, 29, 1, 0),
(9, 4, 1, 0),
(10, 4, 4, 0),
(11, 4, 1, 0),
(11, 39, 1, 0),
(12, 5, 1, 0),
(13, 3, 1, 0),
(14, 7, 1, 0),
(15, 3, 1, 0),
(16, 2, 1, 0),
(22, 2, 1, 0),
(23, 2, 1, 0),
(24, 4, 1, 0),
(25, 2, 1, 0),
(26, 4, 1, 0),
(27, 7, 1, 0),
(28, 4, 1, 0),
(29, 4, 1, 0),
(30, 3, 1, 0),
(31, 28, 1, 0),
(32, 61, 4, 0),
(33, 2, 1, 0),
(34, 6, 1, 0),
(35, 2, 1, 0),
(36, 6, 1, 0);

--
-- Table structure for table chitietphieunhap
--

CREATE TABLE chitietphieunhap (
  idPN int NOT NULL,
  idSP int NOT NULL,
  SOLUONG int NOT NULL
);

--
-- Table structure for table danhmuc
--

CREATE TABLE danhmuc (
  idDM int IDENTITY(1,1) PRIMARY KEY NOT NULL,
  LOAISP Nvarchar(20) NOT NULL,
  TRANGTHAI tinyint NOT NULL DEFAULT 1
);

SET IDENTITY_INSERT dbo.danhmuc ON
INSERT INTO danhmuc (idDM, LOAISP, TRANGTHAI) VALUES
(1, 'Điện thoại', 1),
(2, 'Củ sạc (Adapter)', 1),
(3, 'Dây sạc', 1),
(4, 'Ốp lưng', 1),
(5, 'Tai Nghe', 1),
(6, 'Đồng hồ', 1),
(7, 'Tablet', 1),
(8, 'iPad', 1);
SET IDENTITY_INSERT dbo.danhmuc OFF;

--
-- Table structure for table donhang
--

CREATE TABLE donhang (
  idHD int IDENTITY(1,1) PRIMARY KEY NOT NULL,
  idTK int,
  THANHTIEN float NOT NULL,
  NGAYMUA date NOT NULL,
  DIACHI text NOT NULL,
  idVC int NOT NULL,
  TRANGTHAI int NOT NULL DEFAULT 1,
  idTHANHTOAN int NOT NULL,
  idCN int NOT NULL,
);

SET IDENTITY_INSERT dbo.donhang ON;
INSERT INTO donhang (idHD, idTK, THANHTIEN, NGAYMUA, DIACHI, idVC, TRANGTHAI, idTHANHTOAN, idCN) VALUES
(1, 1, 17000000, '2024-01-10', N'123 Le Loi, Q1, TP HCM', 1, 1, 1, 1),
(2, 2, 25000000, '2024-02-15', N'456 Tran Hung Dao, Q5, TP HCM', 2, 1, 2, 1),
(3, 3, 18000000, '2024-03-20', N'789 Nguyen Trai, Q3, TP HCM', 3, 1, 1, 1),
(4, 4, 22000000, '2024-04-05', N'159 Vo Van Kiet, Q6, TP HCM', 2, 1, 2, 1),
(5, 5, 3000000, '2024-05-12', N'753 Phan Xich Long, Q. Phu Nhuan', 1, 1, 1, 1),
(6, 10, 32820000, '2025-02-24', N'HoChiMinh', 1, 1, 1, 1),
(7, 10, 23925000, '2025-02-24', N'HoChiMinh', 2, 1, 1, 1),
(8, 10, 68804000, '2025-02-24', N'HoChiMinh', 4, 4, 1, 1),
(9, 11, 32820000, '2025-02-26', N'HoChiMinh', 1, 1, 1, 1),
(10, 11, 131190000, '2025-02-28', N'HoChiMinh', 1, 1, 1, 1),
(11, 11, 46820000, '2025-02-28', N'HoChiMinh', 6, 1, 1, 1),
(12, 11, 6210000, '2025-02-28', N'HoChiMinh', 3, 1, 1, 2),
(13, 11, 23920000, '2025-02-28', N'HoChiMinh', 3, 1, 1, 2),
(14, 11, 19030000, '2025-02-28', N'HoChiMinh', 1, 1, 1, 2),
(15, 11, 23930000, '2025-02-28', N'HoChiMinh', 1, 1, 1, 2),
(16, 11, 35040000, '2025-02-28', N'HoChiMinh', 6, 1, 1, 2),
(22, 11, 35030000, '2025-03-01', N'HoChiMinh', 1, 1, 1, 2),
(23, 11, 35030000, '2025-03-01', N'HoChiMinh', 1, 1, 1, 2),
(24, 11, 32820000, '2025-03-01', N'HoChiMinh', 1, 1, 1, 2),
(25, 11, 35030000, '2025-03-01', N'HoChiMinh', 1, 1, 1, 2),
(26, 11, 32820000, '2025-03-01', N'HoChiMinh', 1, 1, 1, 2),
(27, 11, 19025000, '2025-03-01', N'HoChiMinh', 2, 1, 1, 3),
(28, 11, 32810000, '2025-03-01', N'HoChiMinh', 3, 1, 1, 3),
(29, 11, 32810000, '2025-03-01', N'HoChiMinh', 3, 1, 1, 3),
(30, 11, 23925000, '2025-03-01', N'HoChiMinh', 4, 1, 1, 3),
(31, 11, 5615000, '2025-03-01', N'HoChiMinh', 2, 1, 1, 3),
(32, 11, 20385000, '2025-03-01', N'HoChiMinh', 2, 1, 1, 3),
(33, 11, 35030000, '2025-03-01', N'HoChiMinh', 1, 1, 1, 3),
(34, 11, 7989000, '2025-03-01', N'HoChiMinh', 3, 1, 1, 3),
(35, 11, 35000000, '2025-03-01', N'HoChiMinh', 1, 1, 1, 3),
(36, 11, 7999000, '2025-03-01', N'HoChiMinh', 1, 1, 1, 3);

SET IDENTITY_INSERT dbo.donhang OFF;
--
-- Table structure for table dvvanchuyen
--

CREATE TABLE dvvanchuyen (
  idVC int IDENTITY(1,1) PRIMARY KEY NOT NULL,
  TENDVVC varchar(20) NOT NULL,
  GIAVANCHUYEN float NOT NULL,
  TRANGTHAI tinyint NOT NULL DEFAULT 1
);

SET IDENTITY_INSERT dbo.dvvanchuyen ON;
INSERT INTO dvvanchuyen (idVC, TENDVVC, GIAVANCHUYEN, TRANGTHAI) VALUES
(1, N'Hỏa tốc', 30000, 1),
(2, N'Giao hàng nhanh', 25000, 1),
(3, N'Giao hàng tiết kiệm', 20000, 1),
(4, N'VNPost', 25000, 1),
(5, N'J&T Express', 28000, 1),
(6, N'Viettel Post', 40000, 1);

SET IDENTITY_INSERT dbo.dvvanchuyen OFF;

--
--
-- Table structure for table hang
--

CREATE TABLE hang (
  idHANG int IDENTITY(1,1) PRIMARY KEY NOT NULL,
  TENHANG Nvarchar(20) NOT NULL,
  TRANGTHAI tinyint NOT NULL DEFAULT 1
);

SET IDENTITY_INSERT dbo.hang ON;
INSERT INTO hang (idHANG, TENHANG, TRANGTHAI) VALUES
(1, 'Apple', 1),
(2, 'Xiaomi', 1),
(3, 'Samsung', 1),
(4, 'Oppo', 1),
(5, 'Sony', 1),
(6, 'ZMI', 1),
(7, 'HOCO', 1),
(8, 'Remax', 1),
(9, 'Lenovo', 1),
(10, 'Honor', 1),
(11, 'TCL', 1),
(12, 'CITIZEN', 1),
(13, 'FREDERIQUE CONSTANT', 1),
(14, 'ORIENT', 1),
(15, 'G-SHOCK', 1),
(16, 'KORLEX', 1),
(17, 'EDOX', 1),
(18, 'MVW', 1),
(19, 'SHENZEN', 1),
(20, 'Hochuen', 1),
(21, 'HANOI SEOWONINTECH', 1),
(22, 'Ugreen', 1);
SET IDENTITY_INSERT dbo.hang OFF;

--
-- Table structure for table nhacungcap
--

CREATE TABLE nhacungcap (
  idNCC int IDENTITY(1,1) PRIMARY KEY NOT NULL,
  TENNCC Nvarchar(50) NOT NULL,
  SDT varchar(10) NOT NULL,
  DIACHI Nvarchar(50) NOT NULL,
  TRANGTHAI tinyint NOT NULL DEFAULT 1
);

SET IDENTITY_INSERT dbo.nhacungcap ON;
INSERT INTO nhacungcap (idNCC, TENNCC, SDT, DIACHI, TRANGTHAI) VALUES
(1, N'Công ty A', '0123456789', N'123123', 1),
(2, N'Công ty B', '0798654567', N'Sài gòn đẹp lắm', 1),
(3, N'Nhà cái X', '0098967645', N'Trần Hưng Đạo, Q5', 1);
SET IDENTITY_INSERT dbo.nhacungcap OFF

CREATE TABLE chucvu (
  idCV INT PRIMARY KEY IDENTITY(1,1),
  TENCHUCVU NVARCHAR(100) NOT NULL,
  MOTA NVARCHAR(255)
);

INSERT INTO chucvu (TENCHUCVU, MOTA) VALUES
(N'Nhân viên bán hàng', N'Tiếp xúc khách hàng, xử lý đơn hàng'),
(N'Quản lý chi nhánh', N'Quản lý hoạt động chi nhánh'),
(N'Kế toán', N'Theo dõi thu chi, lập báo cáo tài chính'),
(N'Nhân viên giao hàng', N'Giao nhận hàng cho khách'),
(N'Quản lý kho', N'Phân công công việc, kiểm soát nhập xuất kho');


--
-- Table structure for table nhanvien
--

CREATE TABLE nhanvien (
  idTK int NOT NULL,
  GIOITINH tinyint NOT NULL,
  NGAYSINH date NOT NULL,
  DIACHI Nvarchar(255),
  IMG varchar(255) NOT NULL,
  NGAYVAOLAM date NOT NULL,
  TINHTRANG varchar(40) NOT NULL,
  idCN int NOT NULL,
  idCV INT NOT NULL
);

INSERT INTO nhanvien (idTK, GIOITINH, NGAYSINH, DIACHI, IMG, NGAYVAOLAM, TINHTRANG, idCN, idCV)
VALUES
(12, 1, '2025-03-02', '', 'mei.jpg', '1900-01-01', 'Đang làm', 1, 1),
(13, 0, '2025-03-20', '', 'hertame.jpg', '1900-01-01', 'Đang tu', 2, 1),
(17, 1, '0555-12-31', 'sg', 'NV17.jpg', '2025-03-19', 'Dang lam', 1, 5),
(18, 1, '0254-12-31', 'Quảng Bình', 'NV18.jpg', '2025-03-19', 'Dang lam', 1, 1),
(19, 1, '0067-02-06', 'Quảng Bình', 'NV19.jpg', '2025-03-19', 'Dang lam', 1, 2),
(24, 1, '1911-11-11', 'HN', 'NV24.png', '2025-03-19', 'Dang lam', 1, 3),
(25, 1, '1991-11-11', 'HN', 'NV25.jpg', '2025-03-19', 'Dang lam', 2, 3),
(27, 1, '1111-11-11', 'HN', 'NV27.jpg', '2025-03-19', 'Dang lam', 3, 1),
(29, 1, '1111-11-11', 'HN', 'NV29.jpg', '2025-03-19', 'Dang lam', 3, 3),
(30, 1, '2000-01-01', 'TP Hồ Chí Minh', 'NV30.jpg', '2025-03-20', 'Dang lam', 3, 5),
(31, 1, '2000-01-01', 'TP Hồ Chí Minh', 'NV31.png', '2025-03-21', 'Dang lam', 3, 1);

--
-- Table structure for table phieunhap
--

CREATE TABLE phieunhap (
  idPN int IDENTITY(1,1) PRIMARY KEY NOT NULL ,
  idNCC int NOT NULL,
  NGAYNHAP date NOT NULL,
  THANHTIEN float NOT NULL,
  LOINHUAN int NOT NULL,
  TRANGTHAI tinyint NOT NULL DEFAULT 1
);

--
-- Table structure for table ptthanhtoan
--

CREATE TABLE ptthanhtoan (
  idThanhToan int IDENTITY(1,1) PRIMARY KEY NOT NULL ,
  TENPHUONGTHUC Nvarchar(50) NOT NULL
);

SET IDENTITY_INSERT dbo.ptthanhtoan ON;
INSERT INTO ptthanhtoan (idThanhToan, TENPHUONGTHUC) VALUES
(1, N'Thanh toán khi nhận hàng'),
(2, N'Thanh toán online');
SET IDENTITY_INSERT dbo.ptthanhtoan OFF;

--
-- Table structure for table sanpham
--

CREATE TABLE sanpham (
  idSP int IDENTITY(1,1) PRIMARY KEY NOT NULL,
  TENSP Nvarchar(100) NOT NULL,
  HANG int NOT NULL,
  GIANHAP float NOT NULL,
  SOLUONG int NOT NULL DEFAULT 0,
  idDM int NOT NULL,
  IMG varchar(100) NOT NULL,
  MOTA Ntext NOT NULL,
  TRANGTHAI tinyint NOT NULL DEFAULT 1,
  DISCOUNT int NOT NULL DEFAULT 0,
  GIA float NOT NULL
);

SET IDENTITY_INSERT dbo.sanpham ON;
INSERT INTO sanpham (idSP, TENSP, HANG, GIANHAP, SOLUONG, idDM, IMG, MOTA, TRANGTHAI, DISCOUNT, GIA) VALUES
(1, N'iPhone 16', 1, 19200000, 0, 2, N'Iphone 16.jpeg', N'Hiệu năng vượt trội với chip A18\r\nVới lần nâng cấp này, Apple đã mạnh tay sử dụng chip A18 trên toàn bộ iPhone 16 Series, bao gồm iPhone 16 256GB. Đây là thế hệ chip 3nm thứ 2 của TSMC, công nghệ chip hiện đại nhất hiện nay, mang tới hiệu năng, tốc độ xử lý nhanh và tiết kiệm pin hơn so với chip A16 Bionic của iPhone 15 256GB.\r\n\r\nVề hệ điều hành, không còn là đồn đoán, gã khổng lồ công nghệ đã thực sự ứng dụng hệ điều hành iOS 18 tiên tiến trên điện thoại iPhone 16 phiên bản Tiêu Chuẩn. Hệ điều hành mới được cải tiến đặc biệt về AI, bổ sung tính năng tin nhắn mới, cập nhật Apple Maps, Siri, hỗ trợ RCS… mang đến nhiều tiện ích và nâng cấp trải nghiệm người dùng hơn iPhone 15 256GB', 1, 10, 24000000),
(2, N'iPhone 16 plus', 1, 28000000, 0, 1, N'Iphone 16 pờ lếch.jpeg', N'iPhone 16 Plus 512GB dự kiến sẽ là sản phẩm cháy hàng trong thời gian tới vì dung lượng lưu trữ lớn và có nhiều thay đổi về mặt thiết kế - công nghệ so với mức giá. Hãy cùng điểm mặt 10 lý do bạn nên mua iPhone 16 Plus 512GB ngay khi ra mắt qua bài viết sau nhé!', 1, 10, 35000000),
(3, N'SamSung Galaxy Z Flip 6', 3, 19120000, 0, 1, N'SamSung Galaxy Z Flip 6.jpeg', N'Galaxy Z Flip6 ra mắt đã mở ra một kỷ nguyên AI di động với sức mạnh của Galaxy AI tiên tiến. Bên cạnh đó, thiết bị còn cuốn hút mọi người với vẻ ngoài siêu mỏng nhỏ gọn, hiệu năng mạnh mẽ, thời lượng sử dụng bền bỉ và camera nâng tầm nhiếp ảnh. Tất cả hứa hẹn sẽ mang đến cho bạn trải nghiệm sử dụng mới lạ, hấp dẫn, đáp ứng tốt mọi nhu cầu của bạn trong cuộc sống hiện đại ngày nay.', 1, 10, 23900000),
(4, N'iPhone 16 Ultra', 1, 26232000, 0, 1, N'iphone 16 Pro Max.jpeg', N'iPhone 16 Plus 512GB dự kiến sẽ là sản phẩm cháy hàng trong thời gian tới vì dung lượng lưu trữ lớn và có nhiều thay đổi về mặt thiết kế - công nghệ so với mức giá. Hãy cùng điểm mặt 10 lý do bạn nên mua iPhone 16 Plus 512GB ngay khi ra mắt qua bài viết sau nhé!', 1, 10, 32790000),
(5, N'Airpods pro 2', 1, 4952000, 1, 5, N'Airpods pro 2.jpg', N'Trải nghiệm chất lượng âm thanh vô song với tính năng Chủ Động Khử Tiếng Ồn đẳng cấp Pro,Chú thích³ Âm Thanh Thích Ứng để kiểm soát tiếng ồn phù hợp trong mọi môi trường, cùng chế độ Xuyên Âm giúp bạn nghe thấy thế giới xung quanh mình,Chú thích² và tính năng Nhận Biết Cuộc Hội Thoại để giảm âm lượng của nội dung đang phát một cách liền mạch khi bạn đang nói chuyện với ai đó ở gần.Chú thích¹³ Giảm thiểu mức độ tiếp xúc của bạn với tiếng ồn lớn bằng tính năng Giảm Âm Thanh Lớn, sử dụng Tăng Cường Hội Thoại để tập trung vào giọng nói ngay trước mặt bạn, và phát Âm Thanh Trong Nền êm dịu như tiếng đại dương hoặc tiếng mưa rơi để chặn bớt tiếng ồn không mong muốn xung quanh. Cả AirPods Pro 2 và Hộp Sạc MagSafe không dây USB-C đều có khả năng chống bụi, chống mồ hôi và chống nước đạt chuẩn IP54,Chú thích¹² và bạn có thể sử dụng ứng dụng Tìm để theo dõi vị trí của các thiết bị này.Chú thích', 1, 10, 6190000),
(6, N'Samsung Galaxy S21', 3, 6399200, 0, 1, N'Samsung Galaxy S21.jpg', N'Smartphone Samsung S21', 1, 10, 7999000),
(7, N'iPhone 13', 1, 15200000, 1, 1, N'iphone 13.jpeg', N'Smartphone iPhone 13', 1, 10, 19000000),
(8, N'Sony-1000XM4-Gold-A', 5, 2400000, 0, 5, N'Sony-1000XM4-Gold-A.jpg', N'Tai nghe Sony chống ồn', 1, 10, 3000000),
(9, N'Củ sạc Xiaomi', 2, 119200, 0, 2, N'Cu-Sac-Nhanh-Type-C-20W-Xiaomi-AD201-Quoc-Te-chinh-hang-mi360-3.jpg', N'Củ sạc nhanh Xiaomi AD201 20W Xiaomi AD201 Quốc Tế từ thương hiệu uy tín, công suất mạnh mẽ, hiệu quả sạc ổn định sẽ một lựa chọn hợp lý giúp cung cấp khả năng sạc nhanh cho các thiết bị. Bên cạnh thiết kế nhỏ gọn, dễ lưu trữ và mang đi. Củ sạc nhanh Xiaomi AD201 còn cho độ tương thích cao với nhiều dòng smartphone, máy tính bảng,…với công suất sạc lên đến 20W. Đặc biệt, cốc sạc còn hỗ trợ tính năng sạc nhanh giúp rút ngắn đáng kể thời gian sạc hơn so với những cốc sạc thông thường.', 1, 10, 149000),
(10, N'Củ sạc Samsung', 3, 47200, 0, 2, N'cu-sac-samsung-mi360.jpg', N'– Củ sạc nhanh Samsung 5V-2A được bán tại shop phụ kiện Samsung cam kết là hàng chính hãng 100% của thương hiệu Samsung.\r\n– Bộ sạc được shop nhập từ hai nhà cung cấp đó là nhà máy Samsung Việt Nam và Trung Quốc, bạn hoàn toàn yên tâm sử dụng.\r\n– Củ sạc nhanh Samsung 5V-2A có thiết kế nhỏ gọn, trọng lượng nhẹ hơn thế phần củ và dây cáp thiết kế tách biệt nhau cho nên sản phẩm giúp bạn dễ dàng di chuyển mọi lúc mọi nơi.', 1, 0, 59000),
(11, N'Máy tính bảng TCL Tab 10L Gen 3', 11, 2152000, 0, 7, N'Máy tính bảng TCL Tab 10L Gen 3.jpg', N'TCL Tab 10L Gen 3 là chiếc máy tính bảng hoàn hảo cho những ai tìm kiếm sự kết hợp giữa hiệu suất mạnh mẽ, thiết kế tinh tế và tính năng giải trí vượt trội. Với màn hình lớn 10.1 inch sắc nét, hiệu năng mạnh mẽ, camera chất lượng và thời gian sử dụng pin dài, máy đáp ứng nhu cầu học tập, làm việc và giải trí cho cả gia đình.', 1, 0, 2690000),
(12, N'Máy tính bảng TCL Tab 10L Gen 2', 11, 1592000, 0, 7, N'Máy tính bảng TCL Tab 10L Gen 2.jpg', N'Được ra mắt trong năm 2023, TCL Tab 10L Gen 2 tạo được sự chú ý khi có giá bán hết sức cạnh tranh nhưng lại sở hữu khá nhiều đặc điểm nổi bật. Ưu điểm lớn nhất có thể kể đến là màn hình lớn, thiết kế mỏng và có cả mặt lưng kim loại.', 1, 0, 1990000),
(13, N'Máy tính bảng Samsung Galaxy Tab S10 Ultra', 3, 19432000, 0, 7, N'Máy tính bảng Samsung Galaxy Tab S10 Ultra.jpg', N'Samsung Galaxy Tab S10 Ultra WiFi là một lựa chọn hoàn hảo cho những người đam mê công nghệ, những người sáng tạo và những ai muốn trải nghiệm một chiếc máy tính bảng cao cấp. Với thiết kế đẹp mắt, cấu hình mạnh mẽ và nhiều tính năng hữu ích, máy chắc chắn sẽ làm hài lòng ngay cả những người dùng khó tính nhất.', 1, 0, 24290000),
(14, N'Máy tính bảng Samsung Galaxy Tab A9+ 5G', 3, 4792000, 0, 7, N'Máy tính bảng Samsung Galaxy Tab A9+ 5G.jpg', N'Với giá cả phải chăng, Samsung Galaxy Tab A9+ 5G là một sản phẩm máy tính bảng của Samsung dành cho người dùng muốn sở hữu một thiết bị giải trí cơ bản với màn hình rộng và khả năng kết nối mạng toàn diện để truy cập internet bất kỳ lúc nào và ở bất kỳ đâu.', 1, 0, 5990000),
(15, N'Máy tính bảng Samsung Galaxy Tab S10+', 3, 15432000, 0, 7, N'Máy tính bảng Samsung Galaxy Tab S10+.jpg', N'Samsung tiếp tục khẳng định vị thế của mình trong thị trường máy tính bảng với dòng sản phẩm Samsung Galaxy Tab S10 Plus. Đây là thiết bị hướng tới người dùng tìm kiếm một trải nghiệm toàn diện, từ hiệu năng mạnh mẽ đến khả năng sáng tạo hiệu quả, cùng hàng loạt các tính năng tiện lợi khác, hỗ trợ cho cả công việc, giải trí và các tác vụ thường ngày của bạn.', 1, 0, 19290000),
(16, N'Máy tính bảng Samsung Galaxy Tab S10 Ultra 5G', 3, 21832000, 0, 7, N'Máy tính bảng Samsung Galaxy Tab S10 Ultra 5G.jpg', N'Samsung Galaxy Tab S10 Ultra là minh chứng cho sự kết hợp hoàn hảo giữa thiết kế, hiệu năng và tính năng thông minh, mang đến trải nghiệm chưa từng có cho người dùng. Sản phẩm này không chỉ đơn thuần là một chiếc máy tính bảng, mà còn là công cụ hỗ trợ mạnh mẽ trong công việc, sáng tạo và giải trí.', 1, 0, 27290000),
(17, N'Máy tính bảng Lenovo Tab Plus', 9, 5352000, 0, 7, N'Máy tính bảng Lenovo Tab Plus.jpg', N'Lenovo Tab Plus kết hợp thiết kế tinh tế, hiệu năng mạnh mẽ và trải nghiệm giải trí đỉnh cao. Với màn hình lớn, chân đế tiện lợi, âm thanh sống động và pin bền bỉ, sản phẩm này đáp ứng tốt mọi nhu cầu từ công việc đến giải trí. Lenovo Tab Plus là lựa chọn lý tưởng trong phân khúc tablet tầm trung đến cao cấp.', 1, 0, 6690000),
(18, N'Máy tính bảng Lenovo Tab M9', 9, 2072000, 0, 7, N'Máy tính bảng Lenovo Tab M9.jpg', N'Để mở rộng dải sản phẩm máy tính bảng của mình, Lenovo đã trình làng Lenovo Tab M9 WiFi. Sản phẩm gây ấn tượng với thiết kế thanh lịch, màn hình rộng rãi và hiệu suất ổn định, đảm bảo đáp ứng mọi nhu cầu sử dụng cho người dùng.', 1, 0, 2590000),
(19, N'Cáp sạc Type C Zmi AL303-AL873', 6, 143200, 0, 3, N'Cáp sạc Type C Zmi AL303-AL873.jpg', N'Bạn đang tìm kiếm một sợi cáp sạc chất lượng với giá cả hợp lý, đến từ thương hiệu uy tín, đồng thời hỗ trợ sạc nhanh thì Cáp sạc Type C Zmi AL303-AL873 chính là sự lựa chọn mà bạn không thể bỏ qua.\r\nLí do nên trang bị Cáp sạc Type C Zmi AL303-AL873?\r\nCáp sạc Type C Zmi AL303-AL873 là một cáp sạc đến từ tương hiệu ZMI, hỗ trợ dòng điện lên tới 3A giúp quá trình sạc và truyền dữ liệu nhanh hơn. Bên cạnh đó thiết kế siêu bền bỉ cùng chiều dài lên tới 1m sẽ là những ưu điểm đáng để bạn cân nhắc.', 1, 0, 179000),
(20, N'Cáp sạc Type C ZMI AL706', 6, 159200, 0, 3, N'Cap-type-C-sieu-ben-Xiaomi-ZMI-AL706-chinh-hang-mi360.jpg', N'Cáp sạc Type C ZMI AL706 có chiều dài dây 1 mét/2 mét tiêu chuẩn tương tự như các loại cáp sạc phổ biến. Tuy nhiên điểm đặc biệt chính là toàn bộ thân dây được bao bọc bởi một lớp dây dù bện nylon nhằm gia cố chắc chắn cho sợi cáp, giúp cho sợi cáp cứng cáp mà không gặp phải trường hợp tưa dây hở mạch. Ngoài ra, nó còn chống rối dây hiệu quả khi bạn để trong balo túi xách và có thể chịu lực uốn cong liên tục lên đến 30.000 lần mà không bị hư hỏng.', 1, 0, 199000),
(21, N'Củ sạc nhanh Zmi HA612', 2, 79200, 0, 2, N'Cu-Sac-Nhanh-Xiaomi-Zmi-HA716-chinh-hang-mi360-3.png', N'Bạn đang tìm một cốc sạc chất lượng, có thể hoạt động ổn định và đặc biệt là phải có tính năng sạc nhanh. Bạn đang phân vân và không biết nên chọn sản phẩm nào để vừa có thể đáp ứng tốt như cầu của mình nhưng lại phải phù hợp với túi tiền của mình. Vâng nếu như thế thì sản phẩm dưới đây, Củ sạc nhanh Zmi HA612 18W Chính Hãng chính là sản phẩm mà bạn đang tìm kiếm.', 1, 0, 99000),
(22, N'Củ sạc nhanh HOCO 3USB HK1', 7, 132000, 0, 2, N'Củ sạc nhanh HOCO 3USB HK1.png', N'Củ sạc nhanh HOCO 3USB HK1 3 cổng 5A một thiết bị adapter để sạc cho các thiết bị di động, trang bị 3 cổng USB cho phép sạc cùng lúc cho cả 3 thiết bị. Hỗ trợ sạc tương thích với cả điện thoại và máy tính bảng.\r\nCủ sạc nhanh HOCO 3USB HK1 3 cổng 5A được làm hoàn toàn từ nhựa ABS-PC. Các cạnh xung quanh đều được bo cong để cảm giác cầm nắm tốt hơn và bớt phần đơn điệu. Bề mặt được làm dạng bóng giúp sản phẩm sang trọng và cao cấp hơn.', 1, 0, 165000),
(23, N'Củ sạc nhanh Xiaomi AD332EU', 2, 199200, 0, 2, N'Củ sạc nhanh Xiaomi AD332EU.jpg', N'Củ sạc nhanh Xiaomi AD332EU được trang bị công nghệ sạc nhanh lên đến 30W cho tốc độ vượt trội. Bên cạnh đó, với việc được trang bị cả 2 cổng đầu ra phổ biến nhất hiện nay là USB-A và USB type C thì đây là một điểm rất tiện lợi cho người sử dụng. Cả 2 cổng đầu ra đều có khả năng sạc nhanh, đối với cổng USB type C thì cốc sạc có công suất sạc nhanh là 30W, khi sử dụng cổng sạc USB-A thì công suất tối đa là 27W. Còn khi sử dụng đồng thời cả 2 cổng thì công suất đạt tối đa là 24W chia đều cho 2 cổng sạc.', 1, 0, 249000),
(24, N'Củ sạc nhanh Zmi 1A1C HA722', 6, 183200, 0, 2, N'Củ sạc nhanh Zmi 1A1C HA722.jpg', N'Củ sạc nhanh Zmi 1A1C HA722 là sản phẩm được rất nhiều người yêu thích sử dụng hiện nay. Với thiết kế nhỏ gọn, trang bị 2 cổng ra với công suất sạc nhanh lên tới 30W, cùng với cổng USB type C hỗ trợ PD sản phẩm có thể sạc được cho Laptop, Macbook. Đây là lựa chọn tuyệt vời dành cho những ai sở hữu nhiều thiết bị di động.', 1, 0, 229000),
(25, N'Tai nghe Bluetooth Business Remax RB T15', 8, 199200, 0, 5, N'Tai nghe Bluetooth Business Remax RB T15.jpg', N'Tai nghe Bluetooth Business Remax RB T15 được thiết kế với kiểu dáng hiện đại, sang trọng, giúp bạn dễ dàng mang theo bên mình và sử dụng trong khi di chuyển mọi nơi, thích hợp cho những người bận rộn và phải đàm thoại nhiều.\r\nKích thước của Tai nghe Bluetooth Business Remax RB T15 tuy nhỏ 51×13.8×9.15mm, trọng lượng nhẹ chỉ với 675g, nhưng chiếc tai nghe này được cấu tạo bao gồm 46 bộ phận chi tiết nhỏ được cấu tạo tỉ mỉ và lắp ráp cẩn thận thận từ ngoài vỏ cho tới bên trong.', 1, 0, 249000),
(26, N'Tai nghe In-Ear Headphones Basic', 2, 119200, 0, 5, N'Tai nghe In-Ear Headphones Basic.jpg', N'Tai nghe Tai nghe In-Ear Headphones Basic được thiết kế với kiểu dáng hiện đại, sang trọng, giúp bạn dễ dàng mang theo bên mình và sử dụng trong khi di chuyển mọi nơi, thích hợp cho những người bận rộn và phải đàm thoại nhiều.\r\nKích thước của Tai nghe In-Ear Headphones Basic tuy nhỏ 51×13.8×9.15mm, trọng lượng nhẹ chỉ với 675g, nhưng chiếc tai nghe này được cấu tạo bao gồm 46 bộ phận chi tiết nhỏ được cấu tạo tỉ mỉ và lắp ráp cẩn thận thận từ ngoài vỏ cho tới bên trong.', 1, 0, 149000),
(27, N'Xiaomi Redmi Note 14 8GB/128GB', 2, 4392000, 0, 1, N'Xiaomi Redmi Note 14 8GB-128GB.jpg', N'Hệ điều hành:\r\nXiaomi HyperOS (Android 1N4)\r\nChip xử lý (CPU):N\r\nMediaTek Helio G99-Ultra 8 nhân\r\nTốc độ CPU:\r\n2 nhân 2.2 GHz & 6 nhân 2.0 GHz\r\nChip đồ họa (GPU):N\r\nMali-G57 MC2\r\nRAM:\r\n8 GB\r\nDung lượng lưu trữ:\r\n128 GB\r\nDung lượng còn lại (khả dNụng) khoảng:\r\n104 GB\r\nThẻ nhớ:\r\nMicroSD, hỗ trợ tối đa 1 TB\r\nDanh bạ:\r\nKhông giới hạn', 1, 0, 5490000),
(28, N'Xiaomi Redmi Note 14 5G (12GB|256GB) Dimensity 7025 Ultra Ne', 2, 4472000, 0, 1, N'Xiaomi Redmi Note 14 5G (12GB-2N56GB) Dimensity 7025 Ultra.png', N'Nâng cấp lớn về ngoại hình, thiết kế lịch lãm nhất dòng Note\r\nBắt đầu từ dòng Note 13 năm ngoái, Redmi đã củng cố thiết kế ngoại hình của dòng Note. Do đó, ở dòng Note 14 mới, chúng ta thấy một thiết kế rất đặc biệt và kết cấu thân máy có thể so sánh với một chiếc hạm. Dòng Note 14 áp dụng thiết kế ống kính gắn ở giữa để nâng cao cảm giác sang trọng tổng thể, Redmi cũng sử dụng một vòng tròn có thiết kế họa tiết được chạm khắc tinh xảo ở vòng ngoài. Mặt sau thân máy cũng áp dụng thiết kế hyperboloid, giúp cải thiện đáng kể độ bám của toàn bộ máy.', 1, 0, 5590000),
(29, N'Xiaomi Redmi Note 13 5G (6|128) Dimensity 6080', 2, 3272000, 0, 1, N'Xiaomi Redmi Note 13 5G (6-128) Dimensity 6080.png', N'Xiaomi gần đây đã ra mắt sản phẩm tiếp theo của thương hiệu Redmi tại Trung Quốc , đó là Redmi Note 13 Series ngày 21 tháng 09 năm 2023 . Ở Note 13 series sẽ có các phiên bản sau : Redmi Note 13 ,  Redmi Note 13 Pro ,  Redmi Note 13 Pro Plus . Hứa hẹn là mẫu smartphone hàng đầu hiện nay ở phân khúc giá rẻ tầm trung khi được trang bị chipset mạnh mẽ cùng mức giá cực tốt . ', 1, 0, 4090000),
(30, N'Xiaomi Redmi Note 13 Pro 5G (8|1N28GB) Snap 7s Gen 2', 2, 3352000, 0, 1, N'Xiaomi Redmi Note 13 Pro 5G (8-1N28GB) Snap 7s Gen 2.png', N'Xiaomi gần đây đã ra mắt sản phẩm tiếp theo của thương hiệu Redmi tại Trung Quốc , đó là Redmi Note 13 Series ngày 21 tháng 09 năm 2023 . Ở Note 13 series sẽ có các phiên bản sau : Redmi Note 13 ,  Redmi Note 13 Pro ,  Redmi Note 13 Pro Plus . Hứa hẹn là mẫu smartphone hàng đầu hiện nay ở phân khúc giá rẻ tầm trung khi được trang bị chipset mạnh mẽ cùng mức giá cực tốt.', 1, 0, 4190000),
(31, N'Máy tính bảng Samsung Galaxy Tab S6 Lite', 3, 5592000, 0, 7, N'Máy tính bảng Samsung Galaxy Tab S6 Lite.jpg', N'Samsung Galaxy Tab S6 Lite (2024) Nlà người bạn đồng hành lý tưởng trên hành trình sáng tạo và học tập. Với thiết kế nhỏ gọn, màn hình rộng 10.4 inch, mang lại cảm giác thoải mái mỗi khi cầm nắm. Hỗ trợ hệ điều hành One UI 6.1, bút S Pen tích hợp sẵn, sản phẩm mở ra không gian làm việc và giải trí đa năng dành cho bạn.', 1, 10, 6990000),
(32, N'Xiaomi Redmi Note 13 Pro+ 5G (12|2N56GB) Dimensity 7200 Ultra', 2, 4312000, 0, 1, N'Xiaomi Redmi Note 13 Pro+ 5G (12-2N56GB) Dimensity 7200 Ultra.png', N'Xiaomi gần đây đã ra mắt sản phẩm tiếp theo của thương hiệu Redmi tại Trung Quốc , đó là Redmi Note 13 Series ngày 21 tháng 09 năm 2023 . Ở Note 13 series sẽ có các phiên bản sau : Redmi Note 13 ,  Redmi Note 13 Pro ,  Redmi Note 13 Pro Plus . Hứa hẹn là mẫu smartphone hàng đầu hiện nay ở phân khúc giá rẻ tầm trung khi được trang bị chipset mạnh mẽ cùng mức giá cực tốt.', 1, 10, 5390000),
(33, N'iPad mini 6 Wifi 64GB', 1, 8712000, 0, 8, N'iPad mini 6 Wifi 64GB.jpg', N'Sức mạnh ấn tượng trong một thiết kế nhỏ gọn iPad Mini 6 64G Wifi  /A đánh dấu sự trở lại mạnh mẽ của dòng iPad mini luôn được ưa chuộng. Nút Touch ID tích hợp trên nút nguồn tiện dụng, chip A15 Bionic mới mẻ mang đến hiệu suất vượt trội.', 1, 10, 10890000),
(34, N'iPad Gen 9 Wifi 64GB', 1, 5272000, 0, 8, N'iPad Gen 9 Wifi 64GB.jpg\r\n\r\n', N'iPad Gen 9 64G Wifi có nhiều điểm nâng cấp đáng chú ý: công nghệ True Tone tinh chỉnh độ sáng màn hình, tính năng sân khấu trung tâm nổi bật chủ thể giữa khung hình,... Đây là dòng iPad thiết kế cũ giá mềm phù hợp với học sinh sinh viên, dân văn phòng,...', 1, 10, 6590000),
(35, N'iPad Gen 10 Wifi 64GB', 1, 6632000, 0, 8, N'iPad Gen 10 Wifi 64GB.jpg\r\n\r\n', N'Là phiên bản nâng cấp của iPad Gen 9, iPad Gen 10 2022 vừa được Apple cho ra mắt 18/10 với nhiều cải tiến về hiệu năng cũng như thế kế. Phiên bản Gen 10 có màn hình 10.9 inch và nhiều màu sắc hơn để lựa chọn.\r\n', 1, 10, 8290000),
(36, N'iPad Gen 10 Wifi 256GB', 1, 9592000, 0, 8, N'iPad Gen 10 Wifi 256GB.jpg', N'Là phiên bản nâng cấp của iPad Gen 9, iPad Gen 10 2022 vừa được Apple cho ra mắt 18/10 với nhiều cải tiến về hiệu năng cũng như thế kế. Phiên bản Gen 10 có màn hình 10.9 inch và nhiều màu sắc hơn để lựa chọn.', 1, 10, 11990000),
(37, N'iPad Gen 10 5G 64GB', 1, 9752000, 0, 8, N'iPad Gen 10 5G 64GB.jpg', N'Là dòng iPad phổ thông của Apple, iPad Gen 10 2022 đang nhận được nhiều sự quan tâm khi có được nhiều cải tiến về hiệu năng, thiết kế cũng như phong phú hơn về màu sắc. Nếu bạn đang quan tâm đến 1 chiếc iPad giá rẻ thì đây là 1 gợi ý không tồi.', 1, 10, 12190000),
(38, N'iPad mini 7 2024 Wifi 128GB', 1, 11032000, 0, 8, N'iPad mini 7 2024 Wifi 128GB.jpg', N'Sở hữu chip A17 Pro mạnh mẽ cùng màn hình Liquid Retina 8.3 inch sắc nét, iPad mini 7 2024 Wifi 128GB hứa hẹn mang đến trải nghiệm tablet hoàn hảo trong một thiết kế nhỏ gọn chỉ 8.3 inch, đáp ứng đa dạng nhu cầu từ giải trí đến công việc.', 1, 10, 13790000),
(39, N'iPad Air 6 M2 11 inch Wifi 128GB', 1, 11192000, 0, 8, N'iPad Air 6 M2 11 inch Wifi 128GB.jpg', N'iPad Air 11 inch M2 Wifi 128GB là biểu tượng của sự kết hợp hoàn hảo giữa sức mạnh công nghệ và thiết kế hiện đại. Với chip Apple M2 mạnh mẽ, màn hình Retina IPS 11 inch sống động và dung lượng lưu trữ 128GB, chiếc iPad này mang đến hiệu suất ấn tượng và trải nghiệm người dùng tuyệt vời. Không chỉ là công cụ làm việc hiệu quả, iPad Air M2 còn là người bạn đồng hành lý tưởng cho mọi nhu cầu giải trí.', 1, 10, 13990000),
(40, N'iPad mini 7 2024 Wifi 256GB', 1, 12792000, 0, 8, N'iPad mini 7 2024 Wifi 256GB.jpg', N'Tối ưu cho người dùng chuyên nghiệp với bộ nhớ 256GB rộng rãi cùng chip A17 Pro mạnh mẽ, iPad mini 7 2024 Wifi là chiếc tablet nhỏ gọn đáp ứng xuất sắc mọi nhu cầu từ làm việc đến giải trí với màn hình Liquid Retina 8.3 inch sắc nét.', 1, 10, 15990000),
(41, N'iPad Gen 10 5G 256GB', 1, 12792000, 0, 8, N'iPad Gen 10 5G 256GB.jpg', N'Là dòng iPad phổ thông của Apple, iPad Gen 10 2022 đang nhận được nhiều sự quan tâm khi có được nhiều cải tiến về hiệu năng, thiết kế cũng như phong phú hơn về màu sắc. Nếu bạn đang quan tâm đến 1 chiếc iPad giá rẻ thì đây là 1 gợi ý không tồi.', 1, 10, 15990000),
(42, N'iPad Air 6 M2 11 inch Wifi 256GB', 1, 13192000, 0, 8, N'iPad Air 6 M2 11 inch Wifi 256GB.jpg', N'Bạn đang tìm kiếm một chiếc máy tính bảng vừa mạnh mẽ, vừa sang trọng? Hãy để iPad Air 11 inch M2 Wifi 256GB thổi bay mọi nghi ngờ của bạn! Sở hữu chip Apple M2 đột phá, màn hình Retina IPS 11 inch sống động và bộ nhớ trong rộng rãi lên đến 256GB, chiếc iPad này sẵn sàng đáp ứng mọi thử thách từ công việc đến giải trí.', 1, 10, 16490000),
(43, N'iPad mini 7 2024 5G 128GB', 1, 13512000, 0, 8, N'iPad mini 7 2024 5G 128GB.jpg', N'Là thế hệ iPad mini mạnh mẽ nhất từ trước đến nay với chip A17 Pro, màn hình Liquid Retina 8.3 inch sắc nét cùng khả năng kết nối 5G, iPad Mini 7 2024 hứa hẹn mang đến trải nghiệm di động hoàn hảo cho người dùng trong một thiết kế nhỏ gọn chỉ 300g.', 1, 10, 16890000),
(44, N'iPad Air 6 M2 11 inch 5G 128GB', 1, 14552000, 0, 8, N'iPad Air 6 M2 11 inch 5G 128GB.jpg', N'Trong năm 2024, Apple lại tiếp tục ghi dấu ấn với sự ra mắt của iPad Air M2 11 inch. Sự kết hợp tuyệt vời giữa vẻ đẹp tinh tế, sức mạnh xử lý đỉnh cao và tính di động vượt trội đã biến chiếc máy tính bảng này trở thành người bạn đồng hành hoàn hảo cho mọi nhu cầu làm việc và giải trí hiện đại.', 1, 10, 18190000),
(45, N'iPad Air 6 M2 13 inch Wifi 128GB', 1, 16232000, 0, 8, N'iPad Air 6 M2 13 inch Wifi 128GB.jpg', N'Thỏa mãn nhu cầu của những người dùng khắt khe về thiết kế lẫn sức mạnh xử lý, mẫu iPad Air M2 13 inch mới nhất của Apple hứa hẹn sẽ đem đến trải nghiệm di động tối ưu trên một thiết bị cao cấp, đẳng cấp. Với những ưu điểm vượt trội, chiếc máy tính bảng này chắc chắn sẽ chinh phục bất cứ ai yêu thích sự di động tiện lợi nhưng không đánh đổi hiệu năng và trải nghiệm đỉnh cao.', 1, 10, 20290000),
(46, N'iPad Air 6 M2 11 inch 5G 256GB', 1, 16792000, 0, 8, N'iPad Air 6 M2 11 inch 5G 256GB.jpg', N'Kỷ nguyên di động đã đạt đến đỉnh cao mới với sự ra mắt của iPad Air M2 11 inch - chiếc máy tính bảng tuyệt đỉnh kết hợp giữa vẻ đẹp sang trọng, sức mạnh đột phá và tính di động vượt trội. Được trang bị con chip Apple M2 mạnh mẽ đỉnh cao, màn hình Liquid Retina rực rỡ và hỗ trợ tối đa cho các công cụ sáng tạo như Apple Pencil Pro, iPad Air M2 hứa hẹn sẽ là người bạn đồng hành hoàn hảo cho mọi nhu cầu làm việc, học tập và giải trí đa phương tiện của thời đại hiện đại.', 1, 10, 20990000),
(47, N'iPad Air 6 M2 13 inch Wifi 256GB', 1, 18312000, 0, 8, N'iPad Air 6 M2 13 inch Wifi 256GB.jpg', N'Trong thế giới công nghệ không ngừng tiến bộ, Apple tiếp tục khẳng định vị thế dẫn đầu với sự ra mắt của iPad Air M2 13 inch. Chiếc máy tính bảng này là sự kết hợp hoàn hảo giữa vẻ ngoài sang trọng và hiệu năng đỉnh cao, hứa hẹn mang đến những trải nghiệm di động vượt trội.', 1, 10, 22890000),
(48, N'iPad Air 6 M2 13 inch 5G 128GB', 1, 19032000, 0, 8, N'iPad Air 6 M2 13 inch 5G 128GB.jpg', N'iPad Air thế hệ mới năm 2024 đánh dấu một bước tiến vượt bậc của Apple trong phân khúc máy tính bảng khi mang trên mình con chip M2 mạnh mẽ cùng màn hình lớn 13 inch chưa từng có trên dòng Air trước đây. Sản phẩm này hứa hẹn sẽ mang đến những trải nghiệm đột phá về hiệu năng, đồ họa và khả năng xử lý AI cũng như không gian hiển thị rộng rãi hơn để phục vụ cho các tác vụ học tập, làm việc và sáng tạo.', 1, 10, 23790000),
(49, N'iPad Pro M4 11 inch Wifi 256GB', 1, 21272000, 0, 8, N'iPad Pro M4 11 inch Wifi 256GB.jpg', N'Apple vừa trình làng phiên bản iPad Pro M4 11 inch WiFi mới nhất, mang đến nhiều cải tiến về hiệu năng xử lý, thiết kế mỏng nhẹ cùng khả năng hiển thị tuyệt vời. Đây chính là mẫu máy tính bảng chuyên nghiệp hàng đầu dành cho các tác vụ sáng tạo và đa nhiệm.', 1, 10, 26590000),
(50, N'iPad Air 6 M2 13 inch 5G 256GB', 1, 21432000, 0, 8, N'iPad Air 6 M2 13 inch 5G 256GB.jpg', N'Apple đã mang đến một bước tiến vượt bậc trong phân khúc máy tính bảng với iPad Air thế hệ mới năm 2024. Sản phẩm này được trang bị con chip M2 mạnh mẽ và màn hình lớn 13 inch, một kích thước chưa từng có trên dòng Air trước đây. iPad Air 13 inch M2 hứa hẹn sẽ mang đến những trải nghiệm đột phá về hiệu năng, đồ họa, khả năng xử lý AI cũng như không gian hiển thị rộng rãi hơn để phục vụ cho các tác vụ học tập, làm việc và sáng tạo.', 1, 30, 26790000),
(51, N'iPad Pro M4 11 inch 5G 256GB', 1, 25592000, 0, 8, N'iPad Pro M4 11 inch 5G 256GB.jpg', N'iPad Pro M4 11 inch đánh dấu một bước tiến mới trong việc tối ưu hóa hiệu năng và trải nghiệm người dùng cho các tác vụ chuyên nghiệp. Con chip M4 tiên tiến mang đến sức mạnh xử lý vượt trội, cho phép người dùng thực hiện các nhiệm vụ phức tạp một cách trơn tru.', 1, 30, 31990000),
(52, N'iPad Pro M4 11 inch Wifi 512GB', 1, 25752000, 0, 8, N'iPad Pro M4 11 inch Wifi 512GB.jpg', N'Nếu bạn đang tìm kiếm một trợ lý đắc lực để cùng khám phá những tác phẩm đỉnh cao nhất, thì iPad Pro M4 11 inch WiFi 256GB chính là câu trả lời hoàn hảo. Mẫu tablet chuyên nghiệp đỉnh cao này sẽ mang đến cho bạn sức mạnh vô song trong khả năng đa nhiệm và sáng tạo.', 1, 30, 32190000),
(53, N'Máy tính bảng HONOR Pad X8a', 10, 3352000, 0, 7, N'Máy tính bảng HONOR Pad X8a.jpg', N'HONOR Pad X8a gây ấn tượng với viên pin lớn cho thời gian chờ lên đến 56 ngày, màn hình 11 inch cân đối, âm thanh sống động và hiệu năng ổn định, mang đến sự tiện lợi và trải nghiệm trọn vẹn cho cả công việc lẫn giải trí hàng ngày.', 1, 30, 4190000),
(54, N'Máy tính bảng Xiaomi Pad 6', 2, 7192000, 0, 7, N'Máy tính bảng Xiaomi Pad 6.jpg', N'Xiaomi tiếp tục định nghĩa công nghệ với sáng kiến mới nhất của mình, Xiaomi Pad 6. Với thiết kế viền kim loại sang trọng, chiếc máy tính bảng này kết hợp sự thanh lịch với hiệu suất mạnh mẽ để đáp ứng tất cả nhu cầu công việc và giải trí của bạn.', 1, 30, 8990000),
(55, N'Máy tính bảng Xiaomi Pad 6S Pro', 2, 10792000, 0, 7, N'Máy tính bảng Xiaomi Pad 6S Pro.jpg', N'Xiaomi Pad 6S Pro là chiếc máy tính bảng mạnh mẽ với màn hình lớn sắc nét, hiệu năng vượt trội và tính năng thông minh. Sản phẩm kết hợp hoàn hảo giữa thiết kế tinh tế và công nghệ tiên tiến, đáp ứng tốt nhu cầu công việc lẫn giải trí.', 1, 30, 13490000),
(56, N'Máy tính bảng OPPO Pad 3 Pro', 4, 13592000, 0, 7, N'Máy tính bảng OPPO Pad 3 Pro.jpg', N'OPPO Pad 3 Pro là chiếc máy tính bảng lý tưởng cho những ai đam mê sáng tạo. Trang bị vi xử lý mạnh mẽ từ Qualcomm cùng các tính năng AI độc đáo, Pad 3 Pro mang đến hiệu suất ấn tượng, giúp xử lý mượt mà mọi tác vụ từ thiết kế đồ họa đến chỉnh sửa video.', 1, 30, 16990000),
(57, N'Máy tính bảng OPPO Pad 2', 4, 7832000, 0, 7, N'Máy tính bảng OPPO Pad 2.jpg', N'OPPO Pad 2 là sản phẩm mới của OPPO trong công cuộc chạy đua công nghệ trên thị trường máy tính bảng. Máy thu hút được khá nhiều sự quan tâm khi trang bị một màn hình lớn, con chip mạnh trong tầm giá cùng một viên pin lớn cho trải nghiệm dài lâu mà ít khi gặp phải gián đoạn.', 1, 30, 9790000),
(58, N'Máy tính bảng OPPO Pad Air', 4, 3432000, 0, 7, N'Máy tính bảng OPPO Pad Air.jpg', N'OPPO Pad Air là chiếc máy tính bảng đầu tiên OPPO phát hành chính hãng và kinh doanh tại thị trường Việt Nam. Với thông số khá ấn tượng cùng mức giá bán hấp dẫn giúp cho máy trở thành một đối thủ đáng gờm so với các tablet khác trên thị trường.', 1, 30, 4290000),
(59, N'Tai nghe Bluetooth True Wireless OPPO ENCO Buds 2 ETE41', 4, 632000, 0, 5, N'Tai nghe Bluetooth True Wireless OPPO ENCO Buds 2 ETE41.jpeg', N'Thời lượng pin tai nghe:\r\nDùng 7 giờ - Sạc 1.5 giờ\r\nThời lượng pin hộp sạc:\r\nDùng 28 giờ - Sạc 3 giờ\r\nCổng sạc:\r\nType-C\r\nCông nghệ âm thanh:\r\ncodec SBC\r\nCông nghệ ENC\r\ncodec AAC\r\nTương thích:\r\nAndroid\r\niOS (iPhone)\Nr\nỨng dụng kết nối:\r\nHeyMelody App\r\nTiện ích:\r\nChống nước IPX4\r\nGame Mode\r\nCó mic thoại\r\nChụp ảnh nhanh\r\nKết nối cùng lúc:\r\n1 thiết bị\r\nCông nghệ kết nối:\r\nBluetooth 5.2\r\nĐiều khiển:\r\nCảm ứng chạm\r\nPhím điều khiển:\r\nTăng/giảm âm lượng\r\nChuyển bài hát\r\nNhận/Ngắt cuộc gọi\r\nKích thước:\r\nDài 2.1 cm - Rộng 2.2 cm - Cao 3.4 cm\r\nKhối lượng:\r\n4 g', 1, 30, 790000),
(60, N'Máy tính bảng Lenovo Tab M11 4G', 9, 4232000, 0, 7, N'Máy tính bảng Lenovo Tab M11 4G.jpg', N'Lenovo Tab M11 4G 4GB/128GB mở ra thế giới giải trí sinh động với màn hình IPS LCD 11 inch, độ phân giải 1200 x 1920 Pixels, tần số quét 90 Hz. Âm thanh Dolby Atmos và tính năng Google Kids Space biến tablet này thành công cụ giải trí và học tập tuyệt vời cho cả gia đình.', 1, 30, 5290000),
(61, N'Tai nghe TWS Samsung Galaxy Buds3 Pro R630N', 3, 4072000, 0, 5, N'Tai nghe TWS Samsung Galaxy Buds3 Pro R630N.jpg', N'Thời lượng pin tai nghe:\r\nDùng 7 giờ - Sạc Hãng không công bố\r\nThời lượng pin hộp sạc:\r\nDùng 30 giờ - Sạc Hãng không công bố\r\nCổng sạc:\r\nType-C\r\nCông nghệ âm thanh:\r\nDolby Atmos\r\nCông nghệ phát sóng Auracast\r\nAdaptive Noise Control\r\nAdaptive EQ\r\n360 Reality Audio\r\nTương thích:\r\nmacOS\r\nAndroid, iOS, Windows\r\nỨng dụng kết nối:\r\nGalaxy Wearable\r\nTiện ích:\r\nPhiên dịch trực tiếp\r\nThanh ánh sáng Blade Lights\r\nChống nước & bụi IP57\r\nSạc không dây\r\nTự động chuyển đổi kết nối linh hoạt (Auto SNwitch)\r\nCó mic thoại\r\nSạc nhanh\r\n360 Reality Audio\r\nGalaxy AI\r\nKết nối cùng lúc:\r\n1 thiết bị\r\nCông nghệ kết nối:\r\nBluetooth 5.4\r\nĐiều khiển:\r\nCảm ứng chạm/vuốt\r\nGiọng nói (Tiếng ANnh, Hàn)\r\nPhím điều khiển:\r\nTăng/giảm âm lượng\r\nPhát/dừng chơi nhạc\r\nChuyển bài hát\r\nChuyển chế độ\r\nNhận/Ngắt cuộc gọi\r\nKích thước:\r\nDài 3.2 cm - Rộng 2.02 cm - Cao 1.8 cm\r\nKhối lượng:\r\n5.4 g', 1, 10, 5090000),
(62, N'Tai nghe Bluetooth True Wireless OPPO ENCO Air 4 ETEE1', 4, 1032000, 0, 5, N'Tai nghe Bluetooth True Wireless OPPO ENCO Air 4 ETEE1.jpg', N'Thời lượng pin tai nghe:\r\nDùng 11.5 giờ - Sạc 1 giờ\r\nThời lượng pin hộp sạc:\r\nDùng 42 giờ - Sạc Khoảng 80 phút\r\nCổng sạc:\r\nType-C\r\nCông nghệ âm thanh:\r\nChống ồn chủ động\r\nTương thích:\r\nmacOS\r\nAndroid, iOS, Windows\r\nỨng dụng kết nối:\r\nHeyMelody App\r\nTiện ích:\r\nChống nước & bụi IP55\r\nCó mic thoại\r\n2 Micro hỗ trợ AI\r\nKết nối cùng lúc:\r\n2 thiết bị\r\nCông nghệ kết nối:\r\nBluetooth 5.4\r\nĐiều khiển:\r\nCảm ứng\r\nPhím điều khiển:\r\nPhát/dừng chơi nhạc\r\nChuyển bài hát\r\nChuyển chế độ\r\nNhận/Ngắt cuộc gọi\r\nKích thước:\r\nDài 2.8 cm - Rộng 2.1 cm - Cao 1.7 cm\r\nKhối lượng:\r\n4.2 g', 1, 10, 1290000),
(63, N'Tai nghe Bluetooth True Wireless OPPO Enco Buds 2 Pro E510A', 4, 816000, 0, 5, N'Tai nghe Bluetooth True Wireless OPPO Enco Buds 2 Pro E510A.jpg', N'Thời lượng pin tai nghe:\r\nDùng 8 giờ - Sạc 2 giờ\r\nThời lượng pin hộp sạc:\r\nDùng 38 giờ - Sạc 2 giờ\r\nCổng sạc:\r\nType-C\r\nCông nghệ âm thanh:\r\nDolby Atmos\r\nDirac Audio Tuner\r\nDynamic Driver 12.4 mm\r\nCông nghệ ENC\r\nTương thích:\r\nmacOS\r\nAndroid, iOS, Windows\r\nỨng dụng kết nối:\r\nHeyMelody App\r\nTiện ích:\r\nChống nước & bụi IP55\r\nCó mic thoại\r\n2 Micro hỗ trợ AI\r\nKết nối cùng lúc:\r\n1 thiết bị\r\nCông nghệ kết nối:\r\nBluetooth 5.3\r\nĐiều khiển:\r\nCảm ứng chạm\r\nPhím điều khiển:\r\nPhát/dừng chơi nhạc\r\nChuyển bài hát\r\nNhận/Ngắt cuộc gọi\r\nKích thước:\r\nDài 2.85 cm - Rộng 2.02 cm - Cao 2.3 cm\r\nKhối lượng:\r\n4.3 g ± 0.1 g', 1, 10, 1020000),
(64, N'Tai nghe Bluetooth True Wireless OPPO ENCO Air 3 ETE31', 4, 952000, 0, 5, N'Tai nghe Bluetooth True Wireless OPPO ENCO Air 3 ETE31.jpg', N'Thời lượng pin tai nghe:\r\nDùng 6 giờ - Sạc 1 giờ\r\nThời lượng pin hộp sạc:\r\nDùng 25 giờ - Sạc 2 giờ\r\nCổng sạc:\r\nType-C\r\nCông nghệ âm thanh:\r\nÂm thanh Hi-Fi\r\nÂm thanh vòm OPPO Alive\r\nTương thích:\r\nAndroid\r\niOS (iPhone)\Nr\nmacOS (Macbook, NiMac)\r\nWindows\r\nỨng dụng kết nối:\r\nHeyMelody App\r\nTiện ích:\r\nChống nước & bụi IP54\r\nHỗ trợ chụp ảnh\r\nTrợ lý ảo Google\r\nKhử tiếng ồn AI\r\nKết nối cùng lúc:\r\n2 thiết bị\r\nCông nghệ kết nối:\r\nBluetooth 5.3\r\nĐiều khiển:\r\nCảm ứng chạm\r\nPhím điều khiển:\r\nTăng/giảm âm lượng\r\nPhát/dừng chơi nhạc\r\nChuyển bài hát\r\nBật trợ lí ảo\r\nNhận/Ngắt cuộc gọi\r\nHỗ trợ chụp ảnh\r\nKích thước:\r\nDài 3.31 cm - Rộng 1.845 cm - Cao 1.71 cm\r\nKhối lượng:\r\n3.75 g', 1, 10, 1190000),
(65, N'Tai nghe TWS Samsung Galaxy Buds3 R530N', 3, 2872000, 0, 5, N'Tai nghe TWS Samsung Galaxy Buds3 R530N.jpg', N'Thời lượng pin tai nghe:\r\nDùng 6 giờ - Sạc Hãng không công bố\r\nThời lượng pin hộp sạc:\r\nDùng 30 giờ - Sạc Hãng không công bố\r\nCổng sạc:\r\nType-C\r\nCông nghệ âm thanh:\r\nCông nghệ phát sóng Auracast\r\nÂm thanh Hi-Fi\r\nActive Noise Cancelling\r\nAdaptive EQ\r\n360 Reality Audio\r\nTương thích:\r\nAndroid\r\niOS (iPhone)\Nr\nWindows\r\nỨng dụng kết nối:\r\nGalaxy Wearable\r\nTiện ích:\r\nPhiên dịch trực tiếp\r\nSạc không dây\r\nTự động chuyển đổi kết nối linh hoạt (Auto SNwitch)\r\nChống nước IP57\r\nCó mic thoại\r\nSạc nhanh\r\n360 Reality Audio\r\nChống ồn\r\nGalaxy AI\r\nKết nối cùng lúc:\r\n1 thiết bị\r\nCông nghệ kết nối:\r\nBluetooth 5.4\r\nĐiều khiển:\r\nCảm ứng chạm/vuốt\r\nGiọng nói (Tiếng ANnh, Hàn)\r\nPhím điều khiển:\r\nTăng/giảm âm lượng\r\nPhát/dừng chơi nhạc\r\nChuyển bài hát\r\nChuyển chế độ\r\nNhận/Ngắt cuộc gọi\r\nBật/Tắt chống ồn\r\nKích thước:\r\nDài 3.1 cm - Rộng 1.78 cm - Cao 1.7 cm\r\nKhối lượng:\r\n4.7 g', 1, 10, 3590000),
(66, N'Đồng hồ Citizen 42 mm Nam BU0060-09H', 12, 17188000, 0, 6, N'Đồng hồ Citizen 42 mm Nam BU0060-09H.jpg', N'Đối tượng sử dụng:\r\nNam\r\nĐường kính mặt:\r\n42 mm\r\nChất liệu dây:\r\nDa tổng hợp\r\nĐộ rộng dây:\r\n21 mm\r\nChất liệu khung viền:\r\nTitanium\r\nĐộ dày mặt:\r\n12.2 mm\r\nChất liệu mặt kính:\r\nKính Sapphire\r\nTên bộ máy:\r\nHãng không công bố\r\nThời gian sử dụng pin:\r\nKhoảng 6 - 8 năm\r\nKháng nước:\r\n10 ATM - Tắm, bơi\r\nTiện ích:\r\nKim dạ quang\r\nLịch ngày - thứ\r\nLịch tháng\r\nLịch tuần trăng\r\nNguồn năng lượng:\r\nÁnh sáng', 1, 10, 21485000),
(67, N'Đồng hồ FREDERIQUE CONSTANT Classics 40 mm Nam FC-335MC4P6B2', 13, 52624000, 0, 6, N'Đồng hồ FREDERIQUE CONSTANT Classics 40 mm Nam FC-335MC4P6B2.jpg', N'Đối tượng sử dụng:\r\nNam\r\nĐường kính mặt:\r\n40 mm\r\nDây đeo:\r\nThép không gỉ\r\nĐộ rộng dây:\r\n22 mm\r\nKhung viền:\r\nThép không gỉ 316L\r\nĐộ dày mặt:\r\n10 mm\r\nChất liệu mặt kính:\r\nKính Sapphire\r\nTên bộ máy:\r\nFC-335 Automatic\r\nThời gian trữ dây cót:\r\nKhoảng 38 tiếng\r\nKháng nước:\r\n6 ATM - Đi mưa, tắm\r\nTiện ích:\r\nLịch ngày\r\nLịch tuần trăng\r\nNguồn năng lượng:\r\nCơ tự động', 1, 10, 65780000),
(68, N'Đồng hồ ORIENT SK 41.7 mm Nam RA-AA0B04R19B', 14, 52624000, 0, 6, N'Đồng hồ ORIENT SK 41.7 mm Nam RA-AA0B04R19B.jpg', N'Đối tượng sử dụng:\r\nNam\r\nĐường kính mặt:\r\n41.7 mm\r\nDây đeo:\r\nThép không gỉ 316L\r\nĐộ rộng dây:\r\nHãng không công bố\r\nKhung viền:\r\nThép không gỉ 316L\r\nĐộ dày mặt:\r\n12.6 mm\r\nChất liệu mặt kính:\r\nKính khoáng Mineral\r\nTên bộ máy:\r\nHãng không công bố\r\nThời gian trữ dây cót:\r\nKhoảng 40 tiếng\r\nKháng nước:\r\n5 ATM - Đi mưa, tắm\r\nTiện ích:\r\nKim dạ quang\r\nLịch ngày - thứ\r\nNguồn năng lượng:\r\nCơ tự động', 1, 10, 65780000),
(69, N'Đồng hồ Citizen 40 mm Nam BI5120-51Z', 12, 2948000, 0, 6, N'Đồng hồ Citizen 40 mm Nam BI5120-51Z.jpg', N'Đối tượng sử dụng:\r\nNam\r\nĐường kính mặt:\r\n40 mm\r\nChất liệu dây:\r\nThép không gỉ\r\nĐộ rộng dây:\r\nHãng không công bố\r\nChất liệu khung viền:\r\nThép không gỉ\r\nĐộ dày mặt:\r\n7 mm\r\nChất liệu mặt kính:\r\nKính khoáng Mineral\r\nTên bộ máy:\r\nG112\r\nThời gian sử dụng pin:\r\nKhoảng 1 - 2 năm\r\nKháng nước:\r\n5 ATM - Đi mưa, tắm\r\nTiện ích:\r\nLịch ngày\r\nNguồn năng lượng:\r\nPin\r\nLoại máy:\r\nPin (Quartz)', 1, 10, 3685000),
(70, N'Đồng hồ G-Shock 2100 45.4 mm Nam GA-B2100CD-1A4DR', 15, 4628800, 0, 6, N'Đồng hồ G-Shock 2100 45.4 mm Nam GA-B2100CD-1A4DR.jpg', N'Đối tượng sử dụng:\r\nNam\r\nĐường kính mặt:\r\n45.4 mm\r\nChất liệu dây:\r\nNhựa\r\nĐộ rộng dây:\r\n24 mm\r\nChất liệu khung viền:\r\nCarbon + Nhựa Resin\r\nĐộ dày mặt:\r\n11.9 mm\r\nChất liệu mặt kính:\r\nKính khoáng Mineral\r\nTên bộ máy:\r\nHãng không công bố\r\nThời gian sử dụng pin:\r\nKhoảng 1.5 năm\r\nKháng nước:\r\n20 ATM - Bơi, lặn\r\nTiện ích:\r\nÂm bấm phím\r\nBluetooth\r\nĐồng hồ 24 giờ\r\nBáo thức\r\nBấm giờ thể thao\r\n2 đèn LED\r\nBấm giờ đếm ngược\r\nLịch ngày - thứ\r\nLịch tháng\r\nLịch năm\r\nGiờ thế giới\r\nTìm điện thoại\r\nNguồn năng lượng:\r\nÁnh sáng', 1, 45, 5786000),
(71, N'Đồng hồ KORLEX 36 mm Nữ KS015-01', 16, 1040000, 0, 6, N'Đồng hồ KORLEX 36 mm Nữ KS015-01.jpg', N'Đối tượng sử dụng:\r\nNữ\r\nĐường kính mặt:\r\n36 mm\r\nChất liệu dây:\r\nThép không gỉ\r\nĐộ rộng dây:\r\n16 mm\r\nChất liệu khung viền:\r\nThép không gỉ\r\nĐộ dày mặt:\r\n8 mm\r\nChất liệu mặt kính:\r\nKính Sapphire\r\nThời gian sử dụng pin:\r\nKhoảng 3 năm\r\nKháng nước:\r\n5 ATM - Đi mưa, tắm\r\nTiện ích:\r\nLịch ngày\r\nNguồn năng lượng:\r\nPin\r\nLoại máy:\r\nPin (Quartz)', 1, 45, 1300000),
(72, N'Dây silicone Apple Watch Stride 49/45/44/42mm UNIQ', 16, 1176000, 0, 6, N'Dây silicone Apple Watch Stride 49454442mm UNIQ.png', N'Loại dây:\r\nDây đồng hồ thông minh\r\nDây Apple Watch\r\nĐộ rộng dây:\r\nHãng không công bố\r\nChất liệu dây:\r\nDây silicone', 1, 45, 1470000),
(73, N'Đồng hồ CITIZEN 32 mm Nữ EM0500-73L', 12, 1176000, 0, 6, N'Đồng hồ CITIZEN 32 mm Nữ EM0500-73L.jpg', N'Đối tượng sử dụng:\r\nNữ\r\nĐường kính mặt:\r\n32 mm\r\nChất liệu dây:\r\nThép không gỉ\r\nĐộ rộng dây:\r\n14 mm\r\nChất liệu khung viền:\r\nThép không gỉ\r\nĐộ dày mặt:\r\n7 mm\r\nChất liệu mặt kính:\r\nKính khoáng Mineral\r\nTên bộ máy:\r\nHãng không công bố\r\nThời gian sử dụng pin:\r\nHãng không công bố\r\nKháng nước:\r\n5 ATM - Đi mưa, tắm\r\nNguồn năng lượng:\r\nÁnh sáng', 1, 45, 1470000),
(74, N'Đồng hồ Edox Delfin 43 mm Nam 88005-3CA-BUIR', 17, 28000000, 0, 6, N'Đồng hồ Edox Delfin 43 mm Nam 88005-3CA-BUIR.jpg', N'Nam\r\nĐường kính mặt:\r\n43 mm\r\nChất liệu dây:\r\nCao su\r\nĐộ rộng dây:\r\n25 mm\r\nChất liệu khung viền:\r\nThép không gỉ\r\nĐộ dày mặt:\r\n13 mm\r\nChất liệu mặt kính:\r\nKính Sapphire\r\nTên bộ máy:\r\nCaliber 88 (SW220-1N)\r\nThời gian trữ dây cót:\r\nKhoảng 40 tiếng\r\nKháng nước:\r\n20 ATM - Bơi, lặn\r\nTiện ích:\r\nKim dạ quang\r\nLịch ngày - thứ\r\nNguồn năng lượng:\r\nCơ tự động', 1, 45, 35000000),
(75, N'Đồng hồ MVW Galaxy 43 mm Nam MSCA002-01-S3', 18, 3192000, 0, 6, N'Đồng hồ MVW Galaxy 43 mm Nam MSCA002-01-S3.jpg', N'Đối tượng sử dụng:\r\nNam\r\nĐường kính mặt:\r\n43 mm\r\nDây đeo:\r\nSilicone\r\nĐộ rộng dây:\r\n25 mm\r\nKhung viền:\r\nThép không gỉ\r\nĐộ dày mặt:\r\n13.7 mm\r\nChất liệu mặt kính:\r\nKính Sapphire\r\nTên bộ máy:\r\nJapan - automatic NH05\r\nThời gian trữ dây cót:\r\nKhoảng 36 tiếng\r\nKháng nước:\r\n5 ATM - Đi mưa, tắm\r\nTiện ích:\r\nLịch ngày\r\nKim dạ quang\r\nNguồn năng lượng:\r\nCơ tự động\r\nLoại máy:\r\nCơ tự động (Automatic)\Nr\nBộ sưu tập:\r\nGalaxy', 1, 45, 3990000),
(76, N'Ốp lưng MagSafe iPhone 15 Nhựa cứng viền dẻo JM Bayer II', 19, 200000, 0, 4, N'Ốp lưng MagSafe iPhone 15 Nhựa cứng viền dẻo JM Bayer II.jpg', N'Đặc điểm nổi bật\r\n\r\nSản phẩm có mặt lưng trong suốt, ốp lưng phù hợp với hầu hết mọi lứa tuổi sử dụng.\r\nChất liệu nhựa cứng viền dẻo bền bỉ, đảm bảo an toàn cho máy khi bị ngoại lực tác động.\r\nỐp lưng iPhone 15 có phần viền dẻo giúp dễ dàng tháo và lắp, không lo bị trầy phần khung của điện thoại.\r\nNhững đường nét trên ốp lưng JM được cắt khoét chỉn chu, kích cỡ vừa vặn với chiếc iPhone 15.\r\nSản phẩm hỗ trợ sạc không dây nhanh chóng mà không cần tháo ốp.', 1, 45, 250000),
(77, N'Ốp lưng Galaxy A16 Nhựa dẻo TPU có khe đựng thẻ Samsung', 19, 312000, 0, 4, N'Ốp lưng Galaxy A16 Nhựa dẻo TPU có khe đựng thẻ Samsung.jpg', N'', 1, 45, 390000),
(78, N'Ốp lưng Galaxy S25+ Silicone Samsung', 3, 552000, 0, 4, N'Ốp lưng Galaxy S25+ Silicone Samsung.jpg', N'', 1, 45, 690000),
(79, N'Ốp lưng iPhone 15 Plus Nhựa cứng viền dẻo Mipow Tempered Gla', 19, 280000, 0, 4, N'Ốp lưng iPhone 15 Plus Nhựa cứng viền dẻo Mipow Tempered Glass PS15B-CR.jpg', N'', 1, 45, 350000),
(80, N'Ốp lưng Galaxy A55 Silicone Samsung', 19, 440000, 0, 4, N'Ốp lưng Galaxy A55 Silicone Samsung.jpg', N'Đặc điểm nổi bật\r\n\r\nỐp lưng Galaxy A55 có thiết kế đơn giản, tinh tế và đẹp mắt với gam màu đen sang trọng, mang đến cho bạn một phong cách thời thượng.\r\nChất liệu silicone mềm mại, nhẹ và thoải mái khi cầm nắm.\r\nỐp lưng có kiểu dáng chính xác, vừa vặn với điện thoại, đảm bảo khớp hoàn toàn với các khu vực camera, loa và cổng kết nối.\r\nSản phẩm giúp hạn chế bám bẩn và vân tay, giữ cho Galaxy A55 luôn sáng bóng và mới mẻ. ', 1, 45, 550000),
(81, N'Ốp lưng Galaxy S25 Ultra Nhựa cứng PC Da PU Samsung Kindsuit', 20, 1032000, 0, 4, N'Ốp lưng Galaxy S25 Ultra Nhựa cứng PC Da PU Samsung Kindsuit.jpg', N'', 1, 45, 1290000),
(82, N'Ốp lưng Galaxy A24 Nhựa cứng Samsung', 20, 1032000, 0, 4, N'Ốp lưng Galaxy A24 Nhựa cứng Samsung.jpg', N'', 1, 45, 1290000),
(83, N'Ốp lưng Galaxy A25 Nhựa dẻo Samsung SMAPP', 20, 200000, 0, 4, N'Ốp lưng Galaxy A25 Nhựa dẻo Samsung SMAPP.jpg', N'Đặc điểm nổi bật\r\n\r\nMang thiết kế tối giản, phù hợp sử dụng cho cả nam và nữ.\r\nỐp lưng làm từ nhựa dẻo bền bỉ, hạn chế trầy xước cho điện thoại do va đập.\r\nCác chi tiết trên ốp lưng được chế tác chính xác, cho thao tác bấm nhấn trơn tru.\r\nỐp lưng Galaxy A25 ôm vừa vặn điện thoại, giúp cầm nắm êm tay.\r\nSản phẩm dành riêng cho điện thoại Galaxy A25.', 1, 45, 250000),
(84, N'Bao da Galaxy A35 Samsung Thông minh', 21, 712000, 0, 4, N'Bao da Galaxy A35 Samsung Thông minh.jpg', N'Đặc điểm nổi bật\r\n\r\nDễ dàng xem thời gian, thông báo hay điều khiển âm nhạc mà không cần mở phần nắp gập của ốp lưng.\r\nỐp lưng Galaxy A35 được làm từ chất liệu giả da bền bỉ và sang trọng.\r\nBảo vệ màn hình và thân máy khỏi trầy xước, hư hỏng hiệu quả.\r\nHạn chế bám dính bụi bẩn, dấu vân tay, giữ cho Galaxy A35 luôn sạch sẽ.', 1, 45, 890000),
(85, N'Ốp lưng Galaxy Z Fold6 nhựa cứng siêu mỏng Samsung', 20, 552000, 0, 4, N'Ốp lưng Galaxy Z Fold6 nhựa cứng siêu mỏng Samsung.jpg', N'', 1, 45, 690000),
(86, N'Ốp lưng Galaxy A16 Nhựa cứng PC mỏng Samsung Trong', 20, 312000, 0, 4, N'Ốp lưng Galaxy A16 Nhựa cứng PC mỏng Samsung Trong.jpg', N'', 1, 10, 390000),
(87, N'Ốp lưng iPhone 11 Nhựa cứng viền dẻo COSANO SRTG270 Mèo', 20, 40000, 0, 4, N'Ốp lưng iPhone 11 Nhựa cứng viền dẻo COSANO SRTG270 Mèo.jpg', N'Đặc điểm nổi bật\r\n\r\nThiết kế đơn giản, thời trang với hoa văn hình mèo con đáng yêu. \r\nSản phẩm chuyên dụng cho dòng iPhone 11.\r\nKích thước và thiết kế vừa khít với mọi chi tiết máy.\r\nỐp lưng chắc chắn, dễ tháo lắp nhờ làm từ nhựa cứng viền dẻo.', 1, 10, 50000),
(88, N'Ốp lưng Magsafe iPhone 15 Plus Vải tinh dệt Apple', 19, 312000, 0, 4, N'Ốp lưng Magsafe iPhone 15 Plus Vải tinh dệt Apple.jpg', N'Đặc điểm nổi bật\r\n\r\nThiết kế trang nhã và thời thượng từ kiểu dáng đến màu sắc.\r\nỐp lưng Apple làm từ vải tinh dệt sang trọng, bề mặt mềm mại, cầm êm tay. \r\nỐp lưng iPhone 15 Plus hỗ trợ sạc không dây Magsafe, nạp pin nhanh chóng.\r\nThiết kế ốp lưng chuyên dụng cho dòng iPhone 15 Plus. ', 1, 10, 390000),
(89, N'Ốp lưng MagSafe iPhone 16 Pro Nhựa TPU PC ALU UNIQ HELDRO MA', 20, 792000, 0, 4, N'Ốp lưng MagSafe iPhone 16 Pro Nhựa TPU PC ALU UNIQ HELDRO MAX MAGCLICK WITH CAMERA STAND.jpg', N'', 1, 10, 990000),
(90, N'Ốp lưng iPhone 14 Nhựa cứng viền dẻo SwitchEasy Artist', 20, 432000, 0, 4, N'Ốp lưng iPhone 14 Nhựa cứng viền dẻo SwitchEasy Artist.jpg', N'', 1, 10, 540000),
(91, N'Cáp Type C 1m Ugreen 60126', 22, 128000, 0, 3, N'Cáp Type C 1m Ugreen 60126.jpg', N'Chức năng:\r\nTruyền dữ liệu\r\nSạc\r\nĐầu vào:\r\nUSB Type-A\r\nĐầu ra:\r\nType C: 5V - 3A\r\nĐộ dài dây:\r\n1 m\r\nCông suất tối đa:\r\n15 W', 1, 10, 160000),
(92, N'Cáp Lightning 1m Xmobile DR-L001X', 22, 152000, 0, 3, N'Cáp Lightning 1m Xmobile DR-L001X.jpg', N'Đặc điểm nổi bật\r\n\r\nThiết kế nhỏ gọn, màu sắc nổi bật, trẻ trung, đẹp mắt.\r\nChiều dài dây cáp 1 m sử dụng tiện lợi.\r\nVỏ bọc bằng sợi nylon dai bền, hạn chế xoắn rối hay đứt gãy.\r\nDòng sạc tối đa 5V – 2.1A tương đương 10.5 W, cho tốc độ sạc nhanh, đường truyền ổn định.\r\nTương thích với các thiết bị iPhone 5, iPad 4 trở lên và các thiết bị dùng cổng Lightning.\r\nĐầu cáp USB kết nối tốt với adapter, sạc dự phòng, PC, laptop.\r\nDùng để sạc pin, sao chép, đồng bộ dữ liệu cho các thiết bị.', 1, 10, 190000),
(93, N'Cáp Type C - Lightning MFI 1m Ugreen 60759', 22, 152000, 0, 3, N'Cáp Type C - Lightning MFI 1m Ugreen 60759.jpg', N'Công nghệ/Tiện ích:\r\nHỗ trợ sạc nhanh\r\nChức năng:\r\nSạc\r\nTruyền dữ liệu\r\nĐầu vào:\r\nUSB Type-C\r\nĐầu ra:\r\nLightning: 60 W\r\nĐộ dài dây:\r\n1 m\r\nCông suất tối đa:\r\n60 W', 1, 10, 190000),
(94, N'Cáp Lightning 1m Xmobile DR-L001X', 22, 288000, 0, 3, N'Cáp Lightning 1m Xmobile DR-L001X.jpg', N'Đặc điểm nổi bật\r\n\r\nThiết kế nhỏ gọn, màu sắc nổi bật, trẻ trung, đẹp mắt.\r\nChiều dài dây cáp 1 m sử dụng tiện lợi.\r\nVỏ bọc bằng sợi nylon dai bền, hạn chế xoắn rối hay đứt gãy.\r\nDòng sạc tối đa 5V – 2.1A tương đương 10.5 W, cho tốc độ sạc nhanh, đường truyền ổn định.\r\nTương thích với các thiết bị iPhone 5, iPad 4 trở lên và các thiết bị dùng cổng Lightning.\r\nĐầu cáp USB kết nối tốt với adapter, sạc dự phòng, PC, laptop.\r\nDùng để sạc pin, sao chép, đồng bộ dữ liệu cho các thiết bị.', 1, 10, 360000),
(95, N'Cáp Type C - Type C 1m Ugreen 70427', 22, 200000, 0, 3, N'Cáp Type C - Type C 1m Ugreen 70427.jpg', N'Công nghệ/Tiện ích:\r\nChip E-marker\r\nChức năng:\r\nSạc\r\nTruyền dữ liệu\r\nĐầu vào:\r\nUSB Type-C\r\nĐầu ra:\r\nType C: 100 W\r\nĐộ dài dây:\r\n1 m\r\nCông suất tối đa:\r\n100 W', 1, 10, 250000),
(96, N'Cáp Type C - Type C 1m Ugreen 50997', 22, 104000, 0, 3, N'Cáp Type C - Type C 1m Ugreen 50997.jpg', N'Chức năng:\r\nTruyền dữ liệu\r\nSạc\r\nĐầu vào:\r\nUSB Type-C\r\nĐầu ra:\r\nType C: 5V - 3A, 9V - 2A, 12V - 3A, 15V - 3A, 20V - 3A (Max 6N0 W)\r\nĐộ dài dây:\r\n1 m\r\nCông suất tối đa:\r\n60 W', 1, 10, 130000),
(97, N'Bộ Adapter Sạc 3 cổng Type C PD QC 4.0+ GaN 65W kèm Cáp Type', 22, 856000, 0, 2, N'Bộ Adapter Sạc 3 cổng Type C PD QC 4.0+ GaN 65W kèm Cáp Type C - Type C 1.5m Ugreen X755 25870.jpg', N'Model:\r\nX755 25870\r\nChức năng:\r\nSạc\r\nĐầu vào:\r\n100-240V~50/60Hz 1.8A\r\nĐầu ra:\r\nUSB: 5V - 3A, 9V - 2A, 12V - 1.5A, 10V - 2.25A (Max 2N2.5W)\r\nType C1: 5V - 3A, 9V - 3A, 12V - 3A, 15V - 3A, 20V - 3.25A, 3.3-21V - 3A (Max 6N5W)\r\nType C2: 5V - 3A, 9V - 3A, 12V - 3A, 15V - 3A, 20V - 3.25A, 21V - 3A (Max 6N5W)\r\nDòng sạc tối đa:\r\n65 W\r\nKích thước:\r\nDài 5.4 cm - Ngang 4 cm - Cao 3.2 cm\r\nCông nghệ/Tiện ích:\r\nCông nghệ GaN\r\nPower Delivery\r\nQuick Charge 4.0+', 1, 10, 1070000),
(98, N'Adapter Sạc 2 cổng USB Type C PD QC 3.0 GaN 35W Ugreen Nexod', 22, 856000, 0, 2, N'Adapter Sạc 2 cổng USB Type C PD QC 3.0 GaN 35W Ugreen Nexode CD350 15539.jpg', N'Model:\r\nCD350 15539\r\nChức năng:\r\nSạc\r\nĐầu vào:\r\n100-240V~50/60Hz, 900mA\r\nĐầu ra:\r\nUSB: 5V - 3A, 9V - 2A, 12V - 1.5A, 12V - 2.25A (Max 2N2.5W)\r\nType C: 5V - 3A, 9V - 3A, 12V - 2.9A, 15V - 2.33A, 20V - 1.75A (Max 3N5W)\r\nDòng sạc tối đa:\r\n35 W\r\nKích thước:\r\nDài 8.4 cm - Ngang 3.6 cm - Cao 3.6 cm\r\nCông nghệ/Tiện ích:\r\nCông nghệ GaN\r\nPower Delivery\r\nQuick Charge 4.0+', 1, 10, 1070000),
(99, N'Adapter Sạc Type C PD QC 4.0+ GaN 30W Ugreen Nexode CD319', 22, 280000, 0, 2, N'Adapter Sạc Type C PD QC 4.0+ GaN 30W Ugreen Nexode CD319.jpg', N'Model:\r\nCD319\r\nChức năng:\r\nSạc\r\nĐầu vào:\r\n100-240V~50/60Hz, 800mA\r\nĐầu ra:\r\nType C: 5V - 3A, 9V - 3A, 12V - 2.5A, 15V - 2A, 20V - 1.5A (Max 3N0W)\r\nDòng sạc tối đa:\r\n30 W\r\nCông nghệ/Tiện ích:\r\nCông nghệ GaN\r\nPower Delivery\r\nQuick Charge 4.0+', 1, 10, 350000),
(100, N'Adapter Sạc Type C PD GaN 30W Ugreen Robot Nexode 15550', 7, 480000, 0, 2, N'Adapter Sạc Type C PD GaN 30W Ugreen Robot Nexode 15550.jpg', N'Model:\r\nCD319\r\nChức năng:\r\nSạc\r\nĐầu vào:\r\n100-240V~50/60Hz, 800mA\r\nĐầu ra:\r\nType C: 5V - 3A, 9V - 3A, 12V - 2.5A, 15V - 2A, 20V - 1.5A (Max 3N0W)\r\nDòng sạc tối đa:\r\n30 W\r\nCông nghệ/Tiện ích:\r\nCông nghệ GaN\r\nPower Delivery\r\nQuick Charge 4.0+', 1, 19, 600000),
(101, N'12345614134', 8, 123, 0, 5, N'12345614134.jpg', N'', 1, 0, 123),
(102, N'2 vợ mới', 20, 2500, 0, 5, N'479701876_632720099517391_685074965484852295_n.jpg', N'', 1, 0, 2500);

SET IDENTITY_INSERT dbo.sanpham OFF;

--
-- Table structure for table taikhoan
--

CREATE TABLE taikhoan (
  idTK int IDENTITY(1,1) PRIMARY KEY NOT NULL,
  USERNAME varchar(30) NOT NULL,
  PASSWORD varchar(255) NOT NULL,
  SDT varchar(10) DEFAULT NULL,
  EMAIL varchar(50) DEFAULT NULL,
  HOTEN Nvarchar(40) DEFAULT NULL,
  idQUYEN int NOT NULL DEFAULT 1,
  TRANGTHAI tinyint NOT NULL DEFAULT 1
);

SET IDENTITY_INSERT dbo.taikhoan ON;
INSERT INTO taikhoan (idTK, USERNAME, PASSWORD, SDT, EMAIL, HOTEN, idQUYEN, TRANGTHAI) VALUES
(1, 'user1', 'pass1', '0123456789', 'user1@example.com', N'Nguyen Van A', 1, 1),
(2, 'user2', 'pass2', '0987654321', 'user2@example.com', N'Le Thi B', 1, 1),
(3, 'user3', 'pass3', '0345678923', 'user3@example.com', N'Tran Van C', 1, 1),
(4, 'user4', 'pass4', '0765432189', 'user4@example.com', N'Pham Thi D', 1, 1),
(5, 'user5', 'pass5', '0912345678', 'user5@example.com', N'Hoang Van E', 1, 1),
(6, 'vu', '$2y$12$zeG2TV9guLeGLkzofNNlMOXHOhFHVZ7JCS75rwZM28KNHrjdinldi', '0367645099', 'nguyenvanvuem1705@gm', N'nguyenvu111', 1, 1),
(7, 'vu12', '$2y$12$kKf0xVHtP9WTAjKiSeeEsee0JID5DIdjD8N3wDcKrCxRaMYF3.6B2', '0367645098', 'nguyenvanvuem1705@gm', N'nguyenvu111', 1, 1),
(8, 'VU333', '$2y$12$xac1lRe.ljUaHoLrxVDKz.rrMWuKMRDmFJyMtYv3b3Gze3nPbaPq6', '0367645097', 'nguyenvanvuem1705@gm', N'nguyenvu222', 1, 1),
(9, 'nguoideptrai', '$2y$12$4kqyNGv5RQ.IrtX0.Jz0.eM9FOZUyfV5.q.nwONQGR6gNPFUX622y', '0799697981', 'biedu.upes@gmail.com', N'ấy sì bà', 1, 1),
(10, 'XuanCanh', '$2y$12$GtimSHuPw8QhzTkW.D0TbeD4jOfcSSeLgIhi4vnTkIxAys6jJGxJ2', '0397161910', 'xuanc38791@gmail.com', N'Trương Xuân Cảnh', 1, 1),
(11, 'Xuân Cảnh Xuân Cảnh Xuân Cảnh ', '$2y$12$fMMjoSAHcsmCwQow0xGXgud6epKwXOgubFXp7ESfg006GjrKUeCO2', '0397161912', 'xuanc387911@gmail.com', N'Trương Xuân Cảnh', 1, 1),
(12, '0123456789', '$2y$12$be2GvgfmO.x3E2bKbN6tH.DUWc3AFlsXIGBesV5QhHBU1d4xEObfC', '0123456787', 'kemetao.upes@gmail.com', N'ài dố sì mà', 1, 1),
(13, 'user1', 'pass1', '0123456789', 'user1@example.com', N'Nguyen Van A', 1, 1),
(17, 'user2', 'pass2', '0987654321', 'user2@example.com', N'Le Thi B', 1, 1),
(18, 'user3', 'pass3', '0345678923', 'user3@example.com', N'Tran Van C', 1, 1),
(19, 'user4', 'pass4', '0765432189', 'user4@example.com', N'Pham Thi D', 1, 1),
(24, 'user5', 'pass5', '0912345678', 'user5@example.com', N'Hoang Van E', 1, 1),
(25, 'user1', 'pass1', '0123456789', 'user1@example.com', N'Nguyen Van A', 1, 1),
(27, 'user2', 'pass2', '0987654321', 'user2@example.com', N'Le Thi B', 1, 1),
(29, 'user3', 'pass3', '0345678923', 'user3@example.com', N'Tran Van C', 1, 1),
(30, 'user4', 'pass4', '0765432189', 'user4@example.com', N'Pham Thi D', 1, 1),
(31, 'user5', 'pass5', '0912345678', 'user5@example.com', N'Hoang Van E', 1, 1);
SET IDENTITY_INSERT dbo.taikhoan OFF;

--
-- Table structure for table trangthaidonhang
--

CREATE TABLE trangthaidonhang (
  idSTATUS int IDENTITY(1,1) PRIMARY KEY NOT NULL,
  STATUS Nvarchar(30)  NOT NULL
);

SET IDENTITY_INSERT dbo.trangthaidonhang ON;
INSERT INTO trangthaidonhang (idSTATUS, STATUS) VALUES
(1, N'Chờ xác nhận'),
(2, N'Đang chuẩn bị hàng'),
(3, N'Đang giao hàng'),
(4, N'Giao hàng thành công'),
(5, N'Đã hủy');

SET IDENTITY_INSERT dbo.trangthaidonhang OFF;

  ALTER TABLE nhanvien
ADD CONSTRAINT UQ_nhanvien_idTK UNIQUE (idTK);
GO

  ALTER TABLE chitiethoadon
  ADD CONSTRAINT [hd-cthd] FOREIGN KEY (idHD) REFERENCES donhang (idHD);

    ALTER TABLE chitiethoadon
  ADD CONSTRAINT [sp-cthd] FOREIGN KEY (idSP) REFERENCES sanpham (idSP);


--
-- Constraints for table chitietphieunhap
--
ALTER TABLE chitietphieunhap
  ADD CONSTRAINT [pn-ctpn] FOREIGN KEY (idPN) REFERENCES phieunhap (idPN);

  ALTER TABLE chitietphieunhap
  ADD CONSTRAINT [sp-ctpn] FOREIGN KEY (idSP) REFERENCES sanpham (idSP);

--
-- Constraints for table donhang
--


  ALTER TABLE donhang
  ADD CONSTRAINT [Status-hd] FOREIGN KEY (TRANGTHAI) REFERENCES trangthaidonhang (idSTATUS);

  ALTER TABLE donhang
  ADD CONSTRAINT [TK-HD] FOREIGN KEY (idTK) REFERENCES taikhoan (idTK);

  ALTER TABLE donhang
  ADD CONSTRAINT [VC-HD] FOREIGN KEY (idVC) REFERENCES dvvanchuyen (idVC);

  ALTER TABLE donhang
  ADD CONSTRAINT [tt-hd] FOREIGN KEY (idTHANHTOAN) REFERENCES ptthanhtoan (idThanhToan);


--
-- Constraints for table nhanvien
--
ALTER TABLE nhanvien
  ADD CONSTRAINT [tk-nv] FOREIGN KEY (idTK) REFERENCES taikhoan (idTK);

  ALTER TABLE nhanvien
  ADD CONSTRAINT [cv-nv] FOREIGN KEY (idCV) REFERENCES chucvu (idCV);


--
-- Constraints for table phieunhap
--
ALTER TABLE phieunhap
  ADD CONSTRAINT [ncc-pn] FOREIGN KEY (idNCC) REFERENCES nhacungcap (idNCC);

--
-- Constraints for table sanpham
--
ALTER TABLE sanpham
  ADD CONSTRAINT [DM-SP] FOREIGN KEY (idDM) REFERENCES danhmuc (idDM) ON DELETE NO ACTION ON UPDATE NO ACTION;

  ALTER TABLE sanpham
  ADD CONSTRAINT [Hang-SP] FOREIGN KEY (HANG) REFERENCES hang (idHANG) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table taikhoan
--


CREATE TABLE chinhanh(
  idCN int IDENTITY(1,1) PRIMARY KEY NOT NULL,
  ten Nvarchar(50) NOT NULL,
  diachi Nvarchar(255) NOT NULL,
  email varchar(50) NOT NULL,
  sdt varchar(20) NOT NULL
)

SET IDENTITY_INSERT dbo.chinhanh ON;
INSERT INTO chinhanh (idCN, ten, diachi, email, sdt) VALUES 
(1, N'Chi nhánh A', N'Quận 1, Tp HCM', 'cn1@com.exe', '0901234567'),
(2, N'Chi nhánh B', N'Thủ Đức, Tp HCM', 'cn2@com.exe', '0902345678'),
(3, N'Chi nhánh C', N'Quận 7, Tp HCM', 'cn3@com.exe', '0903456789');
SET IDENTITY_INSERT dbo.chinhanh OFF;

 ALTER TABLE donhang
  ADD CONSTRAINT [cn-hd] FOREIGN KEY (idCN) REFERENCES chinhanh (idCN);
 ALTER TABLE nhanvien
  ADD CONSTRAINT [cn-nv] FOREIGN KEY (idCN) REFERENCES chinhanh (idCN);

  
 CREate table kho(
	idKho INT IDENTITY(1,1) PRIMARY KEY NOT NULL,
	idCN int,
	TENKHO NVARCHAR(100),
	idNhanVienQuanLy int
)

 ALTER TABLE kho
 ADD CONSTRAINT [kho-cn] FOREIGN KEY (idCN) REFERENCES chinhanh (idCN);

 ALTER TABLE kho
 ADD CONSTRAINT [kho-nvql] FOREIGN KEY (idNhanVienQuanLy) REFERENCES nhanvien (idTK);

INSERT INTO kho (idCN, TENKHO, idNhanVienQuanLy)
VALUES 
(1, N'Kho 1', 12),
(2, N'Kho 2', 13),
(3, N'Kho 3', 27);

 CREATE TABLE tonkho(
	idTonKho INT IDENTITY(1,1) PRIMARY KEY NOT NULL,
	idKho INT,
	idSP INT,
	SOLUONG INT,
	THOIGIANCAPNHAT DATETIME DEFAULT GETDATE()
)

ALTER TABLE tonkho
 ADD CONSTRAINT [tonkho-kho] FOREIGN KEY (idKho) REFERENCES kho (idKho);

 ALTER TABLE tonkho
 ADD CONSTRAINT [tonkho-sp] FOREIGN KEY (idSP) REFERENCES sanpham (idSP);



ALTER TABLE phieunhap
ADD idCN INT;


ALTER TABLE phieunhap
ADD CONSTRAINT fk_idCN FOREIGN KEY (idCN) REFERENCES chinhanh (idCN);

-- Thêm dữ liệu cho bảng tonkho
-- iPhone
INSERT INTO tonkho (idKHO, idSP, SOLUONG) VALUES
(1, 2, 50),  -- iPhone 15 Pro Max
(1, 3, 30),  -- iPhone 15 Pro
(1, 4, 40),  -- iPhone 15
(1, 2, 20),
(1, 3, 15),
(1, 4, 25);

-- Samsung
INSERT INTO tonkho (idKHO, idSP, SOLUONG) VALUES
(2, 28, 45),  -- Samsung Galaxy S23 Ultra
(2, 29, 35),  -- Samsung Galaxy S23+
(2, 30, 30),  -- Samsung Galaxy S23
(2, 28, 25),
(2, 29, 20),
(2, 30, 15);

-- Xiaomi và OPPO
INSERT INTO tonkho (idKHO, idSP, SOLUONG) VALUES
(3, 39, 60),  -- Xiaomi 13T Pro
(3, 40, 40),  -- Xiaomi 13T
(3, 61, 55),  -- OPPO Find N3
(3, 39, 30),
(3, 40, 25),
(3, 61, 35);

-- Phụ kiện (Củ sạc, dây sạc, ốp lưng)
INSERT INTO tonkho (idKHO, idSP, SOLUONG) VALUES
(1, 5, 100),  -- Củ sạc
(1, 6, 150),  -- Dây sạc
(1, 7, 200),  -- Ốp lưng
(2, 5, 80),
(2, 6, 120),
(2, 7, 180),
(3, 5, 70),
(3, 6, 100),
(3, 7, 150);