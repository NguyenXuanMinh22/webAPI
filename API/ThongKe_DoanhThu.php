<?php
header("Content-Type: application/json");
include("db.php");

$sql = "SELECT DATE_FORMAT(NgayTao, '%Y-%m') AS Thang,
               SUM(ct.SoLuong * ct.GiaBan) AS DoanhThu
        FROM DonHang dh
        JOIN ChiTietDonHang ct ON dh.SoDH = ct.SoDH
        GROUP BY Thang
        ORDER BY Thang ASC";
$result = $conn->query($sql);
$data = [];
while ($row = $result->fetch_assoc()) $data[] = $row;
echo json_encode($data);
?>
