<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "qli_thuoc";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
  die(json_encode(["status" => "error", "message" => "Kết nối thất bại: " . $conn->connect_error]));
}
$conn->set_charset("utf8");
?>
