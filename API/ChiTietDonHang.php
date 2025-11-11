<?php
header("Content-Type: application/json");
include("db.php");

$sql = "SELECT ctdh.SoDH, sp.TenSP, ctdh.SoLuong, ctdh.GiaBan, ctdh.ThanhTien
        FROM ChiTietDonHang ctdh
        LEFT JOIN SanPham sp ON ctdh.MaSP = sp.MaSP";
$result = $conn->query($sql);
$data = [];
while ($row = $result->fetch_assoc()) $data[] = $row;
echo json_encode($data);
?>
