<?php
header("Content-Type: application/json");
include("db.php");

$keyword = $_GET['keyword'] ?? '';
$sql = "SELECT * FROM SanPham WHERE TenSP LIKE '%$keyword%'";
$result = $conn->query($sql);
$data = [];
while ($row = $result->fetch_assoc()) $data[] = $row;
echo json_encode($data);
?>
