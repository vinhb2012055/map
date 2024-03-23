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
        
//         var geocoder = L.Control.geocoder({
//   defaultMarkGeocode: false
// })
//   .on('markgeocode', function(e) {
//     var bbox = e.geocode.bbox;
//     var poly = L.polygon([
//       bbox.getSouthEast(),
//       bbox.getNorthEast(),
//       bbox.getNorthWest(),
//       bbox.getSouthWest()
//     ]).addTo(map);
//     map.fitBounds(poly.getBounds());
//   })
//   .addTo(map);

        //tạo icon cho ping
        var greenIcon = L.icon({
        iconUrl: 'school.png',
        iconSize:[20, 30]
        });
        //tạo ping(marker)
        var marker = new L.marker([10.030007,105.770602], {icon: greenIcon, title: "Đại Học Cần Thơ", alt: "CTU"});
        marker. addTo(map);
        marker.bindPopup('<b>Trường Đại Học Cần Thơ</b><br>thông tin trường đại học cần thơ vd:ảnh trường <div><img style ="Width:100%"src="https://lh5.googleusercontent.com/p/AF1QipNGc1cYKEs4SKRrGjrOTTNKALrSo5KKBQKsvIps=w427-h240-k-no" alt="image"/></div>').openPopup();
        var popup = L.popup();
        
		map.on('click', function (e) {
            navigator.geolocation.getCurrentPosition(function(position) {
        var startWaypoint = L.latLng(position.coords.latitude, position.coords.longitude);
			console.log(e)
			var newMarker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map);
			L.Routing.control({
				waypoints: [
					startWaypoint,
					e.latlng
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
		});
    </script>
<?php

?>

</body>

</html>