<?php
header("Content-Type: application/json");
include("db.php");

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    // ===== LẤY DỮ LIỆU =====
    case 'GET':
        $sql = "SELECT sp.MaSP, sp.TenSP, sp.Gia, sp.SoLuongTon,
                       dm.TenDM, th.TenTH, dvt.TenDVT
                FROM SanPham sp
                LEFT JOIN DanhMuc dm ON sp.MaDM = dm.MaDM
                LEFT JOIN ThuongHieu th ON sp.MaTH = th.MaTH
                LEFT JOIN DonViTinh dvt ON sp.MaDVT = dvt.MaDVT";
        $result = $conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
        break;

    // ===== THÊM MỚI =====
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            echo json_encode(["status" => "error", "message" => "Dữ liệu JSON không hợp lệ"]);
            exit;
        }
        $MaSP = $data['MaSP'];
        $TenSP = $data['TenSP'];
        $Gia = $data['Gia'];
        $SoLuongTon = $data['SoLuongTon'];
        $MaDM = $data['MaDM'];
        $MaTH = $data['MaTH'];
        $MaDVT = $data['MaDVT'];

        $sql = "INSERT INTO SanPham (MaSP, TenSP, Gia, SoLuongTon, MaDM, MaTH, MaDVT)
                VALUES ('$MaSP', '$TenSP', '$Gia', '$SoLuongTon', '$MaDM', '$MaTH', '$MaDVT')";

        if ($conn->query($sql)) {
            echo json_encode(["status" => "success", "message" => "Thêm sản phẩm thành công"]);
        } else {
            echo json_encode(["status" => "error", "message" => $conn->error]);
        }
        break;

    // ===== CẬP NHẬT (PUT) =====
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            echo json_encode(["status" => "error", "message" => "Dữ liệu JSON không hợp lệ"]);
            exit;
        }
        $MaSP = $data['MaSP'];
        $TenSP = $data['TenSP'];
        $Gia = $data['Gia'];
        $SoLuongTon = $data['SoLuongTon'];
        $MaDM = $data['MaDM'];
        $MaTH = $data['MaTH'];
        $MaDVT = $data['MaDVT'];

        $sql = "UPDATE SanPham 
                SET TenSP='$TenSP', Gia='$Gia', SoLuongTon='$SoLuongTon', 
                    MaDM='$MaDM', MaTH='$MaTH', MaDVT='$MaDVT'
                WHERE MaSP='$MaSP'";

        if ($conn->query($sql)) {
            echo json_encode(["status" => "success", "message" => "Cập nhật sản phẩm thành công"]);
        } else {
            echo json_encode(["status" => "error", "message" => $conn->error]);
        }
        break;

    // ===== XÓA (DELETE) =====
    case 'DELETE':
        parse_str(file_get_contents("php://input"), $_DELETE);
        $MaSP = $_DELETE['MaSP'] ?? '';

        if (!$MaSP) {
            echo json_encode(["status" => "error", "message" => "Thiếu mã sản phẩm"]);
            exit;
        }

        $sql = "DELETE FROM SanPham WHERE MaSP='$MaSP'";
        if ($conn->query($sql)) {
            echo json_encode(["status" => "success", "message" => "Xóa sản phẩm thành công"]);
        } else {
            echo json_encode(["status" => "error", "message" => $conn->error]);
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Phương thức không được hỗ trợ"]);
        break;
}
?>
