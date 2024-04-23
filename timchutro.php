<!DOCTYPE html>
<html>
<head>
    <title>Event Calendar</title>
    <!-- Include Leaflet CSS and JavaScript -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Include Leaflet Routing Machine -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css">
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>

    <!-- Include Leaflet Locate Control -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@v0.79.0/dist/L.Control.Locate.min.css">
    <script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@v0.79.0/dist/L.Control.Locate.min.js"></script>

    <!-- Custom CSS -->
    <style>
        #map {
            margin-left: 200px;
            width: 600px;
            height: 400px;
        }
    </style>
</head>
<body>
    <div id="left">
        <form id="searchForm">
            <input type="text" name="keyword" id="keyword" placeholder="Nhập từ khóa tìm kiếm">
            <button type="submit">Tìm kiếm</button>
        </form>
    </div>
    <div id="map"></div>
    <script>
        var map = L.map('map').setView([10.030007, 105.770602], 13);
        L.tileLayer('http://{s}.google.com/vt?lyrs=s,h&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        }).addTo(map);
        L.control.locate().addTo(map);

        var markers = [];

        function addMarkerToMap(lat, lng, title, address) {
            var marker = L.marker([lat, lng]).addTo(map);
            marker.bindPopup("<b>" + title + "</b><br>" + address).openPopup();
            markers.push(marker);
        }

        function clearMarkers() {
            for (var i = 0; i < markers.length; i++) {
                map.removeLayer(markers[i]);
            }
            markers = [];
        }

        document.getElementById('searchForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var keyword = document.getElementById('keyword').value;
            fetchMarkers(keyword);
        });

        function fetchMarkers(keyword) {
            clearMarkers();
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == XMLHttpRequest.DONE) {
                    if (xhr.status == 200) {
                        var data = JSON.parse(xhr.responseText);
                        data.forEach(function(markerData) {
                            addMarkerToMap(markerData.lat, markerData.lng, markerData.title, markerData.address);
                        });
                    } else {
                        console.error('Error fetching markers:', xhr.statusText);
                    }
                }
            };
            xhr.open('POST', 'get_markers.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('keyword=' + encodeURIComponent(keyword));
        }
    </script>
</body>
</html>
