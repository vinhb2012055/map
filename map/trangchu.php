<html>

<head>

<title>Event Calendar</title>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<link rel="stylesheet" href="style.css">
<link href="custom.geo.js"/>
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
    <div id="map"></div>
    <div id="right"></div>
    <script>
        //tạo map
        var mapOptions = {
            center: [10.030007,105.770602],
            zoom: 1000
        };
        
        var map = new L.map('map', mapOptions);
        var layer = new
        L.tileLayer('http://{s}.google.com/vt?lyrs=s,h&x={x}&y={y}&z={z}',{
    maxZoom: 20,
    subdomains:['mt0','mt1','mt2','mt3']
})

        map.addLayer(layer);
        L.control.locate().addTo(map);
        L.Control.geocoder().addTo(map);
        //tạo icon cho ping
        var greenIcon = L.icon({
        iconUrl: 'school.png',
        iconSize:[20, 30]
        });
        //tạo ping(marker)
 if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;

                // Tạo marker và đặt vị trí là vị trí hiện tại của người dùng
                var marker = new L.marker([latitude, longitude], {
                    icon: greenIcon,
                    title: "Vị trí hiện tại của bạn"
                }).addTo(map);

                marker.bindPopup('Vị trí hiện tại của bạn').openPopup();

            });
        } else {
            // Xử lý trường hợp trình duyệt không hỗ trợ geolocation
            alert('Trình duyệt của bạn không hỗ trợ xác định vị trí.');
        }
		map.on('click', function (e) {
			console.log(e)
			var newMarker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map);
			L.Routing.control({
				waypoints: [
					L.latLng(latitude, longitude),
					L.latLng(e.latlng.lat, e.latlng.lng)
				]
			}).on('routesfound', function (e) {
				var routes = e.routes;
				console.log(routes);

				e.routes[0].coordinates.forEach(function (coord, index) {
					setTimeout(function () {
						marker.setLatLng([coord.lat, coord.lng]);
					}, 100 * index)
				})

			}).addTo(map);
		});
    </script>
<?php

?>

</body>

</html>