<html>

<head>

<title>Event Calendar</title>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@v0.79.0/dist/L.Control.Locate.min.css" />
<script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@v0.79.0/dist/L.Control.Locate.min.js" charset="utf-8"></script>
</head>

<body>
    <div id="left"></div>
    <div id="map"></div>
    <div id="right"></div>
    
    <script>
        //tạo map
        var mapOptions = {
            center: [10.030007,105.770602],
            zoom: 2000
        };
        
        var map = new L.map('map', mapOptions);
        var layer = new
        L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
        map.addLayer(layer);
        L.control.locate().addTo(map);

        //tạo icon cho ping
        var greenIcon = L.icon({
        iconUrl: 'school.png',
        iconSize:[38, 95]
        });
        //tạo ping(marker)
        var marker = new L.marker([10.030007,105.770602], {icon: greenIcon, title: "Đại Học Cần Thơ", alt: "CTU"});
        marker. addTo(map);
        marker.bindPopup('<b>Trường Đại Học Cần Thơ</b><br>thông tin trường đại học cần thơ vd:ảnh trường <div><img style ="Width:100%"src="https://lh5.googleusercontent.com/p/AF1QipNGc1cYKEs4SKRrGjrOTTNKALrSo5KKBQKsvIps=w427-h240-k-no" alt="image"/></div>').openPopup();

        // var customOptions ={

// 'maxWidth': '500',

// 'className' : 'custom'

// }
        var popup = L.popup();
        function onMapClick(e) {
            popup
            .setLatLng(e.latlng)
            .setContent("You clicked the map at " + e.latlng.toString())
            .openOn(map);
        }
        map.on('click', onMapClick);
    </script>
<?php

?>

</body>

</html>