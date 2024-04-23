<?php
// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "httt_dialy";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Truy vấn dữ liệu từ bảng `nha_tro`
$sql = "SELECT * FROM `nha_tro`";
$result = $conn->query($sql);

// Tạo mảng chứa các điểm tọa độ
$points = [];

if ($result->num_rows > 0) {
    // Duyệt qua từng dòng dữ liệu
    while($row = $result->fetch_assoc()) {
        $point=[
        // Lấy thông tin từ cột trong dòng hiện tại
        'lat' =>$row["nt_kinhdo"],
        'lng' =>$row["nt_vido"]
        ];
        // Thêm tọa độ vào mảng
        array_push($points, $point);
    }
} else {
    echo "0 results";
}
$conn->close();

// Trả về dữ liệu dưới dạng JSON
header('Content-Type: application/json');
$gradient = array(
    0.4 => "red" // Màu đỏ
);
echo json_encode($points);
?>
