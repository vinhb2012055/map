<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map Display</title>
    <!-- Include Leaflet CSS and JavaScript -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <!-- Custom CSS -->
    <style>
        #map {
            min-height: 1000px;
        }
    </style>
</head>

<body>
    <h1>Danh sách địa điểm</h1>
    <div id="map"></div>

    <!-- Custom JavaScript -->
    <script>
        var map = L.map('map').setView([10.030007, 105.770602], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        // Custom icon
        var customIcon = L.icon({
            iconUrl: 'school.png',
            iconSize: [32, 32], // kích thước icon
            iconAnchor: [16, 32], // điểm neo của icon
            popupAnchor: [0, -32] // điểm neo của popup hiển thị khi click vào icon
        });

        // Fetch data from PHP script to get markers
        fetch('markers.php')
            .then(response => response.json())
            .then(markersData => { // Sửa từ data thành markersData
                markersData.forEach(marker => { // Sửa từ data thành markersData
                    L.marker([marker.th_vido, marker.th_kinhdo],{icon: customIcon}).addTo(map)
                        .bindPopup('<b>' + marker.th_ten + '</b><br>' + marker.th_diachi);
                });
            });
    </script>

    <?php
    // Kết nối đến cơ sở dữ liệu
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "httt_dialy";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
    }

    // Truy vấn dữ liệu từ bảng `truonghoc`
    $sql = "SELECT * FROM truonghoc";
    $result = $conn->query($sql);

    $markers = [];

    if ($result->num_rows > 0) {
        // Duyệt qua từng hàng dữ liệu
        while ($row = $result->fetch_assoc()) {
            $markers[] = [
                'th_ten' => $row['th_ten'],
                'th_diachi' => $row['th_diachi'],
                'th_kinhdo' => $row['th_kinhdo'],
                'th_vido' => $row['th_vido']
            ];
        }
    } else {
        echo "0 kết quả";
    }

    $conn->close();

    // Trả về dữ liệu dưới dạng JSON
    echo "<script>var markersData = " . json_encode($markers) . ";</script>";
    ?>
</body>

</html>
