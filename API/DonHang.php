<?php
header("Content-Type: application/json");
include("db.php");

$sql = "SELECT dh.SoDH, dh.NgayTao, dh.GiamGia,
               SUM(ct.SoLuong * ct.GiaBan) AS TongTien,
               nv.TenNV AS NhanVienPhuTrach
        FROM DonHang dh
        LEFT JOIN ChiTietDonHang ct ON dh.SoDH = ct.SoDH
        LEFT JOIN NhanVien nv ON dh.MaNV = nv.MaNV
        GROUP BY dh.SoDH, dh.NgayTao, dh.GiamGia, nv.TenNV
        ORDER BY dh.NgayTao DESC";

$result = $conn->query($sql);
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>
