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
$sql = "SELECT * FROM nha_tro";
$result = $conn->query($sql);

// Kiểm tra và cập nhật dữ liệu cho mỗi bản ghi
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Lấy địa chỉ từ cơ sở dữ liệu
        $address = $row['nt_diachi'];

        // Gọi API Geocoding để lấy tọa độ từ địa chỉ
        $geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&key=AIzaSyCk9ivuc9MZ5wQ4SZIxwVJE6Eh0UhhVUpc');
        $geocode_data = json_decode($geocode);

        // Kiểm tra kết quả từ API và cập nhật dữ liệu trong cơ sở dữ liệu
        if ($geocode_data && $geocode_data->status == 'OK') {
            $latitude = $geocode_data->results[0]->geometry->location->lat;
            $longitude = $geocode_data->results[0]->geometry->location->lng;

            // Cập nhật dữ liệu mới trong cơ sở dữ liệu
            $update_query = "UPDATE nha_tro SET nt_kinhdo = $latitude, nt_vido = $longitude WHERE nt_id = " . $row['nt_id'];
            $conn->query($update_query);
        } else {
            echo "Không thể lấy tọa độ cho địa chỉ: " . $address;
        }
    }
} else {
    echo "Không có bản ghi nào trong bảng nha_tro";
}

$conn->close();
?>
