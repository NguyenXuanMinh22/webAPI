<?php
header("Content-Type: application/json");
include("db.php");

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    // ===== LẤY DANH MỤC =====
    case 'GET':
        $sql = "SELECT * FROM DanhMuc";
        $result = $conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
        break;

    // ===== THÊM DANH MỤC =====
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        $MaDM = $data['MaDM'];
        $TenDM = $data['TenDM'];

        $sql = "INSERT INTO DanhMuc (MaDM, TenDM) VALUES ('$MaDM', '$TenDM')";
        if ($conn->query($sql)) {
            echo json_encode(["status" => "success", "message" => "Thêm danh mục thành công"]);
        } else {
            echo json_encode(["status" => "error", "message" => $conn->error]);
        }
        break;

    // ===== CẬP NHẬT DANH MỤC =====
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        $MaDM = $data['MaDM'];
        $TenDM = $data['TenDM'];

        $sql = "UPDATE DanhMuc SET TenDM='$TenDM' WHERE MaDM='$MaDM'";
        if ($conn->query($sql)) {
            echo json_encode(["status" => "success", "message" => "Cập nhật danh mục thành công"]);
        } else {
            echo json_encode(["status" => "error", "message" => $conn->error]);
        }
        break;

    // ===== XÓA DANH MỤC =====
    case 'DELETE':
        parse_str(file_get_contents("php://input"), $_DELETE);
        $MaDM = $_DELETE['MaDM'];

        $sql = "DELETE FROM DanhMuc WHERE MaDM='$MaDM'";
        if ($conn->query($sql)) {
            echo json_encode(["status" => "success", "message" => "Xóa danh mục thành công"]);
        } else {
            echo json_encode(["status" => "error", "message" => $conn->error]);
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Phương thức không được hỗ trợ"]);
        break;
}
?>
