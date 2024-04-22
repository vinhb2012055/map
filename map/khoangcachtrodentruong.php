<?php

// Hàm để tính toán khoảng cách sử dụng công thức Haversine
function calculateDistance($origin, $destination) {
    $earth_radius = 6371; // Đường kính trái đất trong kilômét

    $lat_diff = deg2rad($destination['latitude'] - $origin['latitude']);
    $lon_diff = deg2rad($destination['longitude'] - $origin['longitude']);

    $a = sin($lat_diff / 2) * sin($lat_diff / 2) + cos(deg2rad($origin['latitude'])) * cos(deg2rad($destination['latitude'])) * sin($lon_diff / 2) * sin($lon_diff / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    $distance = $earth_radius * $c; // Khoảng cách theo đường chim bay

    return round($distance, 3); // Làm tròn đến 3 chữ số sau dấu phẩy
}

// Kết nối CSDL
include "connect.php"; 

// Truy vấn trường học từ CSDL
$sql_truonghoc = "SELECT th_ma, th_ten, th_kinhdo, th_vido FROM truonghoc";
$result_truonghoc = mysqli_query($conn, $sql_truonghoc);

// Truy vấn nhà trọ từ CSDL
$sql_nhatro = "SELECT nt_id, nt_ten, nt_kinhdo, nt_vido FROM nha_tro";
$result_nhatro = mysqli_query($conn, $sql_nhatro);

// Duyệt qua từng nhà trọ
while($row_nhatro = mysqli_fetch_assoc($result_nhatro)) {
    $nt_id = $row_nhatro['nt_id'];
    $nt_ten = $row_nhatro['nt_ten'];
    $nt_kinhdo = $row_nhatro['nt_kinhdo'];
    $nt_vido = $row_nhatro['nt_vido'];

    // Tọa độ của điểm xuất phát (nhà trọ)
    $origin = array('latitude' => $nt_kinhdo, 'longitude' => $nt_vido);

    // Duyệt qua từng trường học
    while($row_truonghoc = mysqli_fetch_assoc($result_truonghoc)) {
        $th_ma = $row_truonghoc['th_ma'];
        $th_ten = $row_truonghoc['th_ten'];
        $th_kinhdo = $row_truonghoc['th_kinhdo'];
        $th_vido = $row_truonghoc['th_vido'];

        // Tọa độ của điểm đích (trường học)
        $destination = array('latitude' => $th_kinhdo, 'longitude' => $th_vido);

        // Tính toán khoảng cách lái xe ngắn nhất
        $new_distance = calculateDistance($origin, $destination);

        // Lấy khoảng cách hiện có từ cơ sở dữ liệu
        $sql_get_distance = "SELECT khoangcach FROM khoangcach WHERE th_ma = '$th_ma' AND nt_id = '$nt_id'";
        $result_get_distance = mysqli_query($conn, $sql_get_distance);

        if(mysqli_num_rows($result_get_distance) > 0) {
            $row_distance = mysqli_fetch_assoc($result_get_distance);
            $current_distance = $row_distance['khoangcach'];

            // So sánh khoảng cách mới và khoảng cách hiện có
            if($new_distance != $current_distance) {
                // Nếu khoảng cách mới khác với khoảng cách hiện có, cập nhật bản ghi
                $sql_update = "UPDATE khoangcach SET khoangcach = '$new_distance' WHERE th_ma = '$th_ma' AND nt_id = '$nt_id'";
                mysqli_query($conn, $sql_update);
            }
        } else {
            // Nếu chưa tồn tại bản ghi, thêm mới vào bảng khoangcach
            $sql_insert = "INSERT INTO khoangcach (th_ma, nt_id, khoangcach) VALUES ('$th_ma', '$nt_id', '$new_distance')";
            mysqli_query($conn, $sql_insert);
        }
    }

    // Đặt con trỏ của kết quả trường học về vị trí ban đầu
    mysqli_data_seek($result_truonghoc, 0);
}

// Đóng kết nối CSDL
// mysqli_close($conn);

?>
