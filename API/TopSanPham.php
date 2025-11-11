<?php
header("Content-Type: application/json");
include("db.php");
$sql = "SELECT sp.MaSP, sp.TenSP, SUM(ct.SoLuong) AS TongBan
        FROM ChiTietDonHang ct
        JOIN SanPham sp ON ct.MaSP = sp.MaSP
        GROUP BY sp.MaSP, sp.TenSP
        ORDER BY TongBan DESC
        LIMIT 5";
$result = $conn->query($sql);
$data = [];
while ($row = $result->fetch_assoc()) $data[] = $row;
echo json_encode($data);
?>
