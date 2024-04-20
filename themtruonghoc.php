<!DOCTYPE html>
<html lang="en">
<head>
<title>Event Calendar</title>
    <!-- Include Leaflet CSS and JavaScript -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- Include Leaflet plugins -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <!-- Include Leaflet Routing Machine -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>

    <!-- Include Leaflet Locate Control -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@v0.79.0/dist/L.Control.Locate.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@v0.79.0/dist/L.Control.Locate.min.js"
        charset="utf-8"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">

    <!-- Custom JavaScript -->
    <script src="custom.geo.js" charset="utf-8"></script>
</head>
<body>
<?php include "connect.php"; ?>

<div id="map" style="width: 600px; height: 400px; margin-left: 200px"></div>

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

<?php 
    if(isset($_POST['btnSubmit'])){
        $name = $_POST['th_ten'];
        $diachi = $_POST['th_diachi'];
        $latitude = $_POST['th_kinhdo'];
        $longitude = $_POST['th_vido'];
        $img = $_FILES['hinhanh']['name']; // Lấy tên của file ảnh
        $image_tmp_name = $_FILES['hinhanh']['tmp_name'];
        // Thực hiện câu lệnh SQL
        $sql = "INSERT INTO truonghoc (x_id, th_ten, th_diachi, th_kinhdo, th_vido, th_image)
                VALUES (1, '$name', '$diachi', '$latitude', '$longitude', '$img')";
        mysqli_query($conn, $sql);
        move_uploaded_file($image_tmp_name,'image/th_image/'. $img);
    }
?>

</body>
</html>