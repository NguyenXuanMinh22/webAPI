<?php
header("Content-Type: application/json; charset=UTF-8");
include("db.php");

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    // ===== LẤY DANH SÁCH NHÂN VIÊN =====
    case 'GET':
        $sql = "SELECT * FROM NhanVien";
        $result = $conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
        break;

    // ===== THÊM NHÂN VIÊN MỚI =====
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        $MaNV = $data['MaNV'];
        $TenNV = $data['TenNV'];
        $ChucVu = $data['ChucVu'];
        $Luong = $data['Luong'];
        $NgayVaoLam = $data['NgayVaoLam'];

        $sql = "INSERT INTO NhanVien (MaNV, TenNV, ChucVu, Luong, NgayVaoLam)
                VALUES ('$MaNV', '$TenNV', '$ChucVu', '$Luong', '$NgayVaoLam')";

        if ($conn->query($sql)) {
            echo json_encode(["status" => "success", "message" => "Thêm nhân viên thành công"]);
        } else {
            echo json_encode(["status" => "error", "message" => $conn->error]);
        }
        break;

    // ===== CẬP NHẬT NHÂN VIÊN =====
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        $MaNV = $data['MaNV'];
        $TenNV = $data['TenNV'];
        $ChucVu = $data['ChucVu'];
        $Luong = $data['Luong'];
        $NgayVaoLam = $data['NgayVaoLam'];

        $sql = "UPDATE NhanVien
                SET TenNV='$TenNV', ChucVu='$ChucVu', Luong='$Luong', NgayVaoLam='$NgayVaoLam'
                WHERE MaNV='$MaNV'";

        if ($conn->query($sql)) {
            echo json_encode(["status" => "success", "message" => "Cập nhật nhân viên thành công"]);
        } else {
            echo json_encode(["status" => "error", "message" => $conn->error]);
        }
        break;

    // ===== XÓA NHÂN VIÊN =====
    case 'DELETE':
        parse_str(file_get_contents("php://input"), $_DELETE);
        $MaNV = $_DELETE['MaNV'];

        $sql = "DELETE FROM NhanVien WHERE MaNV='$MaNV'";
        if ($conn->query($sql)) {
            echo json_encode(["status" => "success", "message" => "Xóa nhân viên thành công"]);
        } else {
            echo json_encode(["status" => "error", "message" => $conn->error]);
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Phương thức không được hỗ trợ"]);
        break;
}
?>
