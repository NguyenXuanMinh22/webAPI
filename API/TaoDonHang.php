<?php
header("Content-Type: application/json");
include("db.php");

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
  echo json_encode(["status"=>"error","message"=>"Dữ liệu JSON không hợp lệ"]);
  exit;
}

// Nếu không truyền SoDH, tự sinh mã mới: DH + timestamp
$SoDH = $data['SoDH'] ?? 'DH' . time();
$MaNV = $data['MaNV'] ?? null;
$NgayTao = $data['NgayTao'] ?? date('Y-m-d H:i:s');
$GiamGia = $data['GiamGia'] ?? 0;
$ChiTiet = $data['ChiTiet'] ?? [];

$conn->begin_transaction();

try {
  // 1️⃣ Thêm đơn hàng
  $sql1 = "INSERT INTO DonHang(SoDH, MaNV, NgayTao, GiamGia) 
           VALUES ('$SoDH', " . ($MaNV ? "'$MaNV'" : "NULL") . ", '$NgayTao', '$GiamGia')";
  $conn->query($sql1);

  // 2️⃣ Thêm chi tiết đơn hàng
  $TongTien = 0;
  foreach ($ChiTiet as $sp) {
    if (!isset($sp['MaSP'], $sp['SoLuong'], $sp['GiaBan'])) continue;
    $MaSP = $sp['MaSP'];
    $SoLuong = (int)$sp['SoLuong'];
    $GiaBan = (float)$sp['GiaBan'];
    $conn->query("INSERT INTO ChiTietDonHang(SoDH, MaSP, SoLuong, GiaBan)
                  VALUES ('$SoDH', '$MaSP', '$SoLuong', '$GiaBan')");
    $TongTien += $SoLuong * $GiaBan;
  }

  // 3️⃣ Cập nhật tổng tiền sau khi thêm chi tiết
  $TongTien = $TongTien - $GiamGia;
  $conn->query("UPDATE DonHang SET TongTien = '$TongTien' WHERE SoDH = '$SoDH'");

  $conn->commit();
  echo json_encode(["status"=>"success","message"=>"Tạo đơn hàng thành công","SoDH"=>$SoDH]);
} catch (Exception $e) {
  $conn->rollback();
  echo json_encode(["status"=>"error","message"=>$e->getMessage()]);
}
?>
