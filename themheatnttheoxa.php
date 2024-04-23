<?php
// Kiểm tra xem x_id đã được chọn chưa
if (isset($_GET['x_id'])) {
    // Lấy x_id được chọn từ yêu cầu GET
    $selectedXId = $_GET['x_id'];

    // Kết nối đến cơ sở dữ liệu
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "httt_dialy";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Truy vấn dữ liệu từ bảng `nha_tro` và `xa` để lấy tên xã thay vì x_id
    $sql = "SELECT nt.nt_kinhdo AS lat, nt.nt_vido AS lng, xa.x_ten AS ten_xa 
            FROM nha_tro nt
            INNER JOIN xa ON nt.x_id = xa.x_id
            WHERE nt.x_id = '$selectedXId'";
    $result = $conn->query($sql);

    // Tạo mảng chứa dữ liệu tọa độ và tên xã
    $data = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Thêm dữ liệu vào mảng
            $data[] = $row;
        }
    } else {
        // Trả về dữ liệu trống nếu không có dữ liệu nào
        $data = [];
    }

    // Trả về dữ liệu dưới dạng JSON
    header('Content-Type: application/json');
    echo json_encode($data);
    
    $conn->close();
} else {
    // Trả về thông báo lỗi nếu x_id chưa được chọn
    echo "X_id is not selected.";
}
?>
