<!DOCTYPE html>
<html>

<head>
    <title>Event Calendar</title>
    <!-- Include Leaflet CSS and JavaScript -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

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
    <div id="left">
        <!-- Search form -->
        <form id="searchForm" method="post" action="">
            <input type="text" id="searchInput" name="key" placeholder="Nhập từ khóa...">
            <button type="submit" name="submit">Tìm kiếm</button> <!-- Đã thêm name="submit" -->
        </form>
    </div>
    <div id="map" style="margin-left: 200px;"></div>
    <script>
        // Create map
        var mapOptions = {
            center: [10.030007, 105.770602],
            zoom: 13
        };

        var map = new L.map('map', mapOptions);
        // var layer = new L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        //     maxZoom: 20
        // });
        var layer = new L.tileLayer('http://{s}.google.com/vt?lyrs=s,h&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        });
        var greenIcon = L.icon({
            iconUrl: 'school.png',
            iconSize: [20, 30]
        });

        var ntIcon = L.icon({
            iconUrl: 'nhatro.png',
            iconSize: [25, 30]
        });

        map.addLayer(layer);

        // Adding different map layers
        var baseMaps = {
            "Đường": layer,
            "Địa hình": L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
                maxZoom: 17,
                attribution: '© OpenTopoMap contributors'
            }),
            "Bản đồ chuẩn": L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors'
            }),
            "Bản đồ chu kỳ": L.tileLayer('https://{s}.tile.thunderforest.com/cycle/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: '&copy; <a href="https://www.opencyclemap.org/">OpenCycleMap</a>, &copy; <a href="https://www.thunderforest.com/">Thunderforest</a>'
            }),
            "Bản đồ giao thông": L.tileLayer('https://{s}.tile.thunderforest.com/transport/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="https://www.opencyclemap.org/">OpenCycleMap</a>, &copy; <a href="https://www.thunderforest.com/">Thunderforest</a>'
            })
        };

        // Adding layer control
        L.control.layers(baseMaps).addTo(map);

        L.control.locate().addTo(map);
        L.Control.geocoder().addTo(map);

        // Function to display destination info in the left panel
        function displayDestinationInfo(info) {
            document.getElementById("left").innerHTML = info;
        }

        // Variable to store routing control
        var routingControl;

        // Function to handle map click event
        map.on('click', function (e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            var info = '<h2>Thông tin điểm đến</h2>';
            info += '<p><b>Kinh độ:</b> ' + lat + '</p>';
            info += '<p><b>Vĩ độ:</b> ' + lng + '</p>';
            info += '<button id="findRoute">Tìm đường đi</button>';
            info += '<button id="closeInfo">Đóng</button>';

            displayDestinationInfo(info);

            document.getElementById("findRoute").addEventListener("click", function () {
                map.locate({
                    setView: true,
                    maxZoom: 15
                });

                map.once('locationfound', function (e) {
                    // Clear any existing routing control
                    if (routingControl) {
                        map.removeControl(routingControl);
                    }

                    routingControl = L.Routing.control({
                        waypoints: [
                            e.latlng, // User's location
                            L.latLng(lat, lng) // Clicked location on map
                        ],
                        routeWhileDragging: true
                    }).addTo(map);
                });
            });

            document.getElementById("closeInfo").addEventListener("click", function () {
                document.getElementById("left").innerHTML = "";
                if (routingControl) {
                    map.removeControl(routingControl);
                }
            });

            map.locate({
                setView: true,
                maxZoom: 15
            });
        });

        // PHP code starts here
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "httt_dialy";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        $sql = "SELECT * FROM nha_tro";

        // Truy vấn dữ liệu từ bảng `nha_tro`
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['key']) && isset($_POST['submit'])) {
                // Lấy giá trị từ form
                $key = $_POST['key'];
                // Xây dựng câu lệnh SQL với điều kiện tìm kiếm
                $sql = "SELECT * FROM nha_tro WHERE nt_ten LIKE '%$key%'";
            }
        } 

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // Duyệt qua từng dòng dữ liệu
            while($row = $result->fetch_assoc()) {
                // Lấy thông tin từ cột trong dòng hiện tại
                $nt_id = $row["nt_id"];
                $nt_ten = $row["nt_ten"];
                $nt_diachi = $row["nt_diachi"];
                $nt_kinhdo = $row["nt_kinhdo"];
                $nt_vido = $row["nt_vido"];
                $nt_image = $row["nt_image"];
                ?>
                var marker<?php echo $nt_id ?> = L.marker([<?php echo $nt_kinhdo ?>, <?php echo $nt_vido ?>], {icon: ntIcon}).addTo(map);
                addMarkerInfo(marker<?php echo $nt_id ?>, <?php echo $nt_kinhdo ?>, <?php echo $nt_vido ?>, "<?php echo $nt_ten ?>", "<?php echo $nt_diachi ?>", "", "<?php echo $nt_image ?>");
                var marker<?php echo $nt_id ?> = L.marker([<?php echo $nt_kinhdo ?>, <?php echo $nt_vido ?>], {icon: ntIcon}).addTo(map);
                addMarkerInfo(marker<?php echo $nt_id ?>, <?php echo $nt_kinhdo ?>, <?php echo $nt_vido ?>, "<?php echo $nt_ten ?>", "<?php echo $nt_diachi ?>", "", "<?php echo $nt_image ?>");
                // Tạo marker và thêm vào bản đồ
                <?php
            }
        } else {


            
            ?>
            setTimeout(function(){
                alert("Không tìm thấy kết quả!");
            }, 1500);
            <?php
        }
        ?>
        // Function to add marker information and events
        function addMarkerInfo(marker, lat, lng, title, address, website, imageSrc) {
            marker.on('click', function (e) {
                var info = '<h2>Thông tin điểm đến</h2>';
                info += '<p><b>Tiêu đề:</b> ' + title + '</p>';
                info += '<p><b>Địa chỉ:</b> ' + address + '</p>';
                // info += '<p><b>Website:</b> <a href="' + website + '">' + website + '</a></p>';
                info += '<div><img style="width:100%" src="' + imageSrc + '" alt="' + title + '"></div>';
                info += '<button id="closeInfo">Đóng</button>'; // Add close button
                info += '<button id="findRoute">Tìm đường đi</button>'; // Add route button
                displayDestinationInfo(info);

                // Event listener for closing info window
                document.getElementById("closeInfo").addEventListener("click", function () {
                    document.getElementById("left").innerHTML = "";
                    if (routingControl) {
                        map.removeControl(routingControl);
                    }
                });

                // Event listener for finding route
                document.getElementById("findRoute").addEventListener("click", function () {
                    map.locate({
                        setView: true,
                        maxZoom: 15
                    });

                    map.once('locationfound', function (e) {
                        // Clear any existing routing control
                        if (routingControl) {
                            map.removeControl(routingControl);
                        }

                        routingControl = L.Routing.control({
                            waypoints: [
                                e.latlng, // User's location
                                marker.getLatLng() // Marker's location
                            ],
                            routeWhileDragging: true
                        }).addTo(map);
                    });
                });
            });
        }
    </script>

</body>

</html>
