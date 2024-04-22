<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Calendar</title>
    <!-- Include Leaflet CSS and JavaScript -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- Custom CSS -->
    <style>
        #map {
            width: 600px;
            height: 400px;
            margin-left: 200px;
        }
    </style>
</head>
<body>
<?php 
    // Include database connection
    include "connect.php"; 
    
    if(isset($_POST['btnSubmit'])){
        // Lấy thông tin trường học từ form
        $name = $_POST['th_ten'];
        $diachi = $_POST['th_diachi'];
        $latitude = $_POST['th_kinhdo'];
        $longitude = $_POST['th_vido'];
        $img = $_FILES['hinhanh']['name']; // Lấy tên của file ảnh
        $image_tmp_name = $_FILES['hinhanh']['tmp_name'];
        
        // Thêm thông tin trường học vào cơ sở dữ liệu
        $sql = "INSERT INTO truonghoc (th_ten, th_diachi, th_kinhdo, th_vido, th_image)
                VALUES ('$name', '$diachi', '$latitude', '$longitude', '$img')";
        mysqli_query($conn, $sql);
        move_uploaded_file($image_tmp_name, 'image/th_image/'. $img);
        
        // Lấy danh sách nhà trọ từ cơ sở dữ liệu
        $sql_nhatro = "SELECT nt_id, nt_ten, nt_kinhdo, nt_vido 
                        FROM nha_tro";
        $result_nhatro = mysqli_query($conn, $sql_nhatro);
        
        // Tính và lưu khoảng cách từ trường học đến từng nhà trọ vào bảng khoangcach
        while($row_nhatro = mysqli_fetch_assoc($result_nhatro)) {
            $nt_id = $row_nhatro['nt_id'];
            $nt_ten = $row_nhatro['nt_ten'];
            $nt_latitude = $row_nhatro['nt_kinhdo'];
            $nt_longitude = $row_nhatro['nt_vido'];
            
            // Sử dụng haversine formula để tính khoảng cách
            $earth_radius = 6371; // Bán kính trái đất, đơn vị kilometer
            $delta_latitude = deg2rad($nt_latitude - $latitude);
            $delta_longitude = deg2rad($nt_longitude - $longitude);
            $a = sin($delta_latitude/2) * sin($delta_latitude/2) + cos(deg2rad($latitude)) * cos(deg2rad($nt_latitude)) * sin($delta_longitude/2) * sin($delta_longitude/2);
            $c = 2 * atan2(sqrt($a), sqrt(1-$a));
            $distance = $earth_radius * $c;
            
            // Lưu khoảng cách vào bảng khoangcach
            $sql_insert_distance = "INSERT INTO khoangcach (nt_id, th_ma, khoangcach) VALUES ('$nt_id', LAST_INSERT_ID(), ROUND('$distance', 2))";
            // $sql_insert_distance = "INSERT INTO khoangcach (nt_id, th_ma, khoangcach) VALUES ('$nt_id', LAST_INSERT_ID(), '$distance')";
            mysqli_query($conn, $sql_insert_distance);
        }
    }
?>
<div id="map"></div>

<form action="" method="post" enctype="multipart/form-data">
    <label for="tenTruong">Tên trường:</label>
    <input type="text" id="tenTruong" name="th_ten" required><br><br>
    
    <label for="diaChi">Địa chỉ:</label>
    <input type="text" id="diaChi" name="th_diachi" required><br><br>
    
    <label for="latitude">Latitude:</label>
    <input type="text" id="latitude" name="th_kinhdo" required><br><br>
    
    <label for="longitude">Longitude:</label>
    <input type="text" id="longitude" name="th_vido" required><br><br>
    
    <label for="icon">Icon đại diện:</label>
    <!-- Display the image here -->
    <span id="preview">
        <img src="" alt="Chọn hình ảnh" width="50px" height="50px">
    </span>
    <input type="file" id="icon" name="hinhanh" accept="image/*" onchange="previewImage(event)"><br><br>
    <input type="submit" value="Thêm mới trường" name="btnSubmit">
</form>

<script>
    var map = L.map('map').setView([10.030007, 105.770602], 13);
    var marker;

    L.tileLayer('http://{s}.google.com/vt?lyrs=s,h&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    }).addTo(map);

    map.on('click', function(e) {
        if (marker) {
            map.removeLayer(marker);
        }
        marker = L.marker(e.latlng).addTo(map);
        document.getElementById('latitude').value = e.latlng.lat.toFixed(6);
        document.getElementById('longitude').value = e.latlng.lng.toFixed(6);
    });

    // Function to preview image
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('preview');
            output.innerHTML = '<img src="' + reader.result + '" width="50px" height="50px">';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

</body>
</html>
