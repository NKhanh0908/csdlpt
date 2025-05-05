-- Lấy tất cả đơn hàng
SELECT 
                    d.idHD, 
                    tk.USERNAME AS khachhang, 
                    d.NGAYMUA, 
                    d.THANHTIEN, 
                    t.STATUS, 
                    d.idCN
                FROM chdidong.dbo.donhang d
                JOIN chdidong.dbo.taikhoan tk    ON d.idTK     = tk.idTK
                JOIN chdidong.dbo.trangthaidonhang t ON d.TRANGTHAI = t.idSTATUS
                WHERE d.TRANGTHAI = 1
UNION ALL
SELECT 
                    d.idHD, 
                    tk.USERNAME AS khachhang, 
                    d.NGAYMUA, 
                    d.THANHTIEN, 
                    t.STATUS, 
                    d.idCN
                FROM LINKEDSV2.chdidong.dbo.donhang d
                JOIN LINKEDSV2.chdidong.dbo.taikhoan tk    ON d.idTK     = tk.idTK
                JOIN LINKEDSV2.chdidong.dbo.trangthaidonhang t ON d.TRANGTHAI = t.idSTATUS
                WHERE d.TRANGTHAI = 1
UNION ALL 
SELECT 
                    d.idHD, 
                    tk.USERNAME AS khachhang, 
                    d.NGAYMUA, 
                    d.THANHTIEN, 
                    t.STATUS, 
                    d.idCN
                FROM LINKEDSV3.chdidong.dbo.donhang d
                JOIN LINKEDSV3.chdidong.dbo.taikhoan tk    ON d.idTK     = tk.idTK
                JOIN LINKEDSV3.chdidong.dbo.trangthaidonhang t ON d.TRANGTHAI = t.idSTATUS
                WHERE d.TRANGTHAI = 1

-- Lấy tất cả nhân viên 
SELECT 
    tk.idTK, tk.HOTEN, tk.SDT, tk.EMAIL,
    nv.GIOITINH, nv.NGAYSINH, nv.DIACHI,
    nv.IMG, nv.NGAYVAOLAM, nv.TINHTRANG,
    tk.TRANGTHAI, cv.TENCHUCVU AS tenCV,
    nv.idCN, cn.ten AS TEN_CHI_NHANH
FROM chdidong.dbo.taikhoan tk
JOIN chdidong.dbo.nhanvien    nv ON tk.idTK = nv.idTK
JOIN chdidong.dbo.chucvu      cv ON nv.idCV = cv.idCV
JOIN chdidong.dbo.chinhanh    cn ON nv.idCN = cn.idCN

UNION ALL

SELECT 
    tk.idTK, tk.HOTEN, tk.SDT, tk.EMAIL,
    nv.GIOITINH, nv.NGAYSINH, nv.DIACHI,
    nv.IMG, nv.NGAYVAOLAM, nv.TINHTRANG,
    tk.TRANGTHAI, cv.TENCHUCVU AS tenCV,
    nv.idCN, cn.ten AS TEN_CHI_NHANH
FROM LINKEDSV2.chdidong.dbo.taikhoan tk
JOIN LINKEDSV2.chdidong.dbo.nhanvien nv ON tk.idTK = nv.idTK
JOIN LINKEDSV2.chdidong.dbo.chucvu   cv ON nv.idCV = cv.idCV
JOIN LINKEDSV2.chdidong.dbo.chinhanh cn ON nv.idCN = cn.idCN

UNION ALL

SELECT 
    tk.idTK, tk.HOTEN, tk.SDT, tk.EMAIL,
    nv.GIOITINH, nv.NGAYSINH, nv.DIACHI,
    nv.IMG, nv.NGAYVAOLAM, nv.TINHTRANG,
    tk.TRANGTHAI, cv.TENCHUCVU AS tenCV,
    nv.idCN, cn.ten AS TEN_CHI_NHANH
FROM LINKEDSV3.chdidong.dbo.taikhoan tk
JOIN LINKEDSV3.chdidong.dbo.nhanvien nv ON tk.idTK = nv.idTK
JOIN LINKEDSV3.chdidong.dbo.chucvu   cv ON nv.idCV = cv.idCV
JOIN LINKEDSV3.chdidong.dbo.chinhanh cn ON nv.idCN = cn.idCN;

-- Chuyển chi nhánh nhân viên
SELECT * FROM nhanvien WHERE idTK = ? -- Xác định nhân viên thuộc chi nhánh nào
-- Kết nối đến chi nhánh tương ứng và insert
INSERT INTO nhanvien (idTK, GIOITINH, NGAYSINH, DIACHI, IMG, NGAYVAOLAM, TINHTRANG, idCN, idCV)
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);
    
-- Xóa nhân viên tại chi nhánh cũ
DELETE FROM nhanvien WHERE idTK = ?

