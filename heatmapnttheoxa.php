<!DOCTYPE html>
<html>

<head>
    <title>Heatmap Example</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.heat/dist/leaflet-heat.js"></script>
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>
</head>

<body>
    <div>
        <select id="xIdSelect">
            <option value="">Chọn xã</option>
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

            // Truy vấn danh sách các xã từ bảng xa
            $sql = "SELECT * FROM xa";
            $result = $conn->query($sql);

            // Tạo các option cho select field từ kết quả truy vấn
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["x_id"] . "'>" . $row["x_ten"] . "</option>";
                }
            } else {
                echo "<option value=''>Không có dữ liệu</option>";
            }
            $conn->close();
            ?>
        </select>
        <button onclick="search()">Tìm kiếm</button>
    </div>

    <div id="map"></div>

    <script>
        var map;
        var heatmapLayer;

        // Khởi tạo bản đồ Leaflet
        function initMap() {
            map = L.map('map').setView([10.03, 105.77], 10); // Đặt tọa độ trung tâm và mức zoom mặc định

            // Thêm lớp bản đồ cơ sở OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Khởi tạo layer heatmap
            heatmapLayer = L.heatLayer([], {
                radius: 25,
                maxZoom: 18,
                blur: 15,
                max: 1, // Max intensity
                gradient: { 0.4: "blue", 0.1: "lime", 0.6: "red" } // Điều chỉnh gradient nếu cần
            }).addTo(map);
        }

        // Hàm tìm kiếm và vẽ heatmap cho x_id được chọn
        function search() {
            var selectedXId = document.getElementById("xIdSelect").value;
            if (!selectedXId) {
                alert("Vui lòng chọn xã trước khi tìm kiếm!");
                return;
            }

            // Fetch dữ liệu từ PHP script
            fetch('themheatnttheoxa.php?x_id=' + selectedXId)
                .then(response => response.json())
                .then(data => {
                    console.log('Fetched data:', data); // Debug: Kiểm tra dữ liệu

                    // Làm mới heatmapLayer trước khi vẽ lại heatmap mới
                    heatmapLayer.setLatLngs([]);

                    // Tạo mảng dữ liệu cho heatmap
                    var heatmapData = [];
                    data.forEach(entry => {
                        var lat = parseFloat(entry.lat);
                        var lng = parseFloat(entry.lng);
                        heatmapData.push([lat, lng]);
                    });

                    // Đặt dữ liệu mới cho heatmapLayer và vẽ lại heatmap
                    heatmapLayer.setLatLngs(heatmapData);
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        }

        // Khởi tạo bản đồ khi tải trang
        window.onload = function() {
            initMap();
        };
    </script>
</body>

</html>
