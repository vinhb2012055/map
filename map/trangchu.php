<!DOCTYPE html>
<html>

<head>
    <title>Event Calendar</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <link rel="stylesheet" href="style.css">
    <link href="locat.geo.js" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@v0.79.0/dist/L.Control.Locate.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@v0.79.0/dist/L.Control.Locate.min.js" charset="utf-8"></script>
    <script src="custom.geo.js" charset="utf-8"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>

</head>

<body>
    <div id="left"></div>
    <div id="map" style="margin-left: 200px;"></div>
    <script>
        // Create map
        var mapOptions = {
            center: [10.030007, 105.770602],
            zoom: 25
        };

        var map = new L.map('map', mapOptions);
        var layer = new L.tileLayer('http://{s}.google.com/vt?lyrs=s,h&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        });

        map.addLayer(layer);
        L.control.locate().addTo(map);
        L.Control.geocoder().addTo(map);

        // Create icon for ping
        var greenIcon = L.icon({
            iconUrl: 'school.png',
            iconSize: [20, 30]
        });

        // Function to display destination info in the left panel
        function displayDestinationInfo(info) {
            document.getElementById("left").innerHTML = info;
        }


        // Tạo biến để lưu trữ control đường đi
        var routingControl;

        // Hàm thêm thông tin và sự kiện cho marker
function addMarkerInfo(marker, lat, lng, title, address, website, imageSrc) {
    marker.on('click', function(e) {
        var info = '<h2>Thông tin điểm đến</h2>';
        info += '<p><b>Tiêu đề:</b> ' + title + '</p>';
        info += '<p><b>Địa chỉ:</b> ' + address + '</p>';
        info += '<p><b>Website:</b> <a href="' + website + '">' + website + '</a></p>';
        info += '<div><img style="width:100%" src="' + imageSrc + '" alt="' + title + '"></div>';
        info += '<button id="closeInfo">Đóng</button>'; // Thêm nút đóng vào phần thông tin
        info += '<button id="findRoute">Tìm đường đi</button>'; // Thêm nút tìm đường đi
        displayDestinationInfo(info); // Hiển thị thông tin trong khung bên trái

        // Sự kiện click cho nút đóng thông tin
        document.getElementById("closeInfo").addEventListener("click", function() {
            document.getElementById("left").innerHTML = ""; // Xóa nội dung khung bên trái khi nút đóng được nhấp
            if (routingControl) {
                map.removeControl(routingControl); // Gỡ bỏ control đường đi nếu tồn tại
            }
        });

        // Sự kiện click cho nút tìm đường đi
        document.getElementById("findRoute").addEventListener("click", function() {
            // Lấy vị trí hiện tại của người dùng
            map.locate({
                setView: true,
                maxZoom: 15
            });

            // Khi đã có vị trí, hiển thị đường đi
            map.once('locationfound', function(e) {
                routingControl = L.Routing.control({
                    waypoints: [
                        e.latlng, // Vị trí của người dùng
                        marker.getLatLng() // Vị trí của marker
                    ],
                    routeWhileDragging: true
                }).addTo(map);
            });
        });
    });
}

// Tạo marker cho tọa độ trường Đại học Cần Thơ và thêm thông tin
var ctuMarker = L.marker([10.029949014241762, 105.77061746343495], {icon: greenIcon}).addTo(map);
addMarkerInfo(ctuMarker, 10.029949014241762, 105.77061746343495, "Trường Đại Học Cần Thơ", "Khu II, Đ. 3 Tháng 2, Xuân Khánh, Ninh Kiều, Cần Thơ", "https://www.ctu.edu.vn/", "ĐHCT.jpg");

// Tạo marker cho tọa độ Cầu Hưng Lợi và thêm thông tin
var hungLoiMarker = L.marker([10.033465755809788, 105.75464370216395], {icon: greenIcon}).addTo(map);
addMarkerInfo(hungLoiMarker, 10.033465755809788, 105.75464370216395, "Đại Học Y Dược Cần Thơ", "Số 179 Đ. Nguyễn Văn Cừ, Phường An Khánh, Ninh Kiều, Cần Thơ", "http://www.ctump.edu.vn", "y_duoc.jpg");



        // Sự kiện click cho bản đồ để tìm đường đi từ vị trí click
        map.on('click', function(e) {
            var lat = e.latlng.lat; // Lấy vĩ độ từ sự kiện click
            var lng = e.latlng.lng; // Lấy kinh độ từ sự kiện click

            // Tạo thông tin chi tiết
            var info = '<h2>Thông tin điểm đến</h2>';
            info += '<p><b>Vĩ độ:</b> ' + lat + '</p>';
            info += '<p><b>Kinh độ:</b> ' + lng + '</p>';
            info += '<button id="findRoute">Tìm đường đi</button>'; // Thêm nút tìm đường đi
            info += '<button id="closeInfo">Đóng</button>'; // Thêm nút đóng

            // Hiển thị thông tin trong khung bên trái
            displayDestinationInfo(info);

            // Sự kiện click cho nút tìm đường đi
            document.getElementById("findRoute").addEventListener("click", function() {
                // Lấy vị trí hiện tại của người dùng
                map.locate({
                    setView: true,
                    maxZoom: 15
                });

                // Khi đã có vị trí, hiển thị đường đi
                map.once('locationfound', function(e) { // Sử dụng 'once' thay vì 'on' để chỉ kích hoạt một lần duy nhất
                    routingControl = L.Routing.control({
                        waypoints: [
                            e.latlng, // Vị trí của người dùng
                            L.latLng(lat, lng) // Vị trí đã click trên bản đồ
                        ],
                        routeWhileDragging: true
                    }).addTo(map);
                });
            });

            // Sự kiện click cho nút đóng thông tin
            document.getElementById("closeInfo").addEventListener("click", function() {
                document.getElementById("left").innerHTML = ""; // Xóa nội dung khung bên trái khi nút đóng được nhấp
                if (routingControl) {
                    map.removeControl(routingControl); // Gỡ bỏ control đường đi nếu tồn tại
                }
            });

            // Lấy vị trí hiện tại của người dùng
            map.locate({
                setView: true,
                maxZoom: 25
            });
        });
        
    </script>

</body>

</html