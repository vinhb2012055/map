<!DOCTYPE html>
<html>

<head>
    <title>Routing Example</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    <style>
        #map {
            height: 400px;
        }
    </style>
</head>

<body>
    <div id="map"></div>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
    <script>
        var map = L.map('map').setView([10.030007, 105.770602], 13);
        var layer = new L.tileLayer('http://{s}.google.com/vt?lyrs=s,h&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        });
        map.addLayer(layer);

        map.on('click', function (e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            var info = '<h2>Thông tin điểm đến</h2>';
            info += '<p><b>Vĩ độ:</b> ' + lat + '</p>';
            info += '<p><b>Kinh độ:</b> ' + lng + '</p>';
            info += '<button id="closeInfo">X</button>';
            displayDestinationInfo(info);

            document.getElementById("closeInfo").addEventListener("click", function () {
                document.getElementById("left").innerHTML = "";
                if (routingControl) {
                    map.removeControl(routingControl);
                }
            });

            map.locate({
                setView: true,
                maxZoom: 15,
                enableHighAccuracy: true
            }).on('locationfound', function (e) {
                routingControl = L.Routing.control({
                    waypoints: [
                        e.latlng,
                        L.latLng(lat, lng)
                    ],
                    routeWhileDragging: true
                }).addTo(map);
            });
        });

        function displayDestinationInfo(info) {
            document.getElementById("left").innerHTML = info;
        }
    </script>
    <div id="left"></div>
</body>

</html>
