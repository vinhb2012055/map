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

// Xử lý dữ liệu từ form tìm kiếm
if (isset($_POST['keyword'])) {
    $keyword = $_POST['keyword'];
    // Tạo câu truy vấn SQL dựa trên từ khóa tìm kiếm
    $sql = "SELECT * FROM truonghoc WHERE th_ten LIKE '%$keyword%' OR th_diachi LIKE '%$keyword%'";
} else {
    // Nếu không có từ khóa tìm kiếm, lấy tất cả dữ liệu từ cơ sở dữ liệu
    $sql = "SELECT * FROM truonghoc";
}

// Truy vấn dữ liệu từ bảng `truonghoc`
$result = $conn->query($sql);
$markers = [];

if ($result->num_rows > 0) {
    // Duyệt qua từng dòng dữ liệu và tạo mảng marker
    while ($row = $result->fetch_assoc()) {
        $marker = [
            'lat' => $row["th_kinhdo"],
            'lng' => $row["th_vido"],
            'title' => $row["th_ten"],
            'address' => $row["th_diachi"]
        ];
        array_push($markers, $marker);
    }
} else {
    // Nếu không tìm thấy marker nào thỏa điều kiện, trả về mảng rỗng
    $markers = [];
}

// Trả về dữ liệu dưới dạng JSON
echo json_encode($markers);

// Đóng kết nối
$conn->close();
?>