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
    <div id="map"></div>
    <script>
        // Initialize Leaflet map
        var map = L.map('map').setView([10.03, 105.77], 13);

        // Add OpenStreetMap base layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Function to fetch data from themheat.php and draw heatmap
        function fetchDataAndDrawHeatmap() {
            // Fetch data from PHP script
            fetch('themheatnt.php') // Assuming 'themheat.php' is the correct URL for your PHP script
                .then(response => response.json())
                .then(data => {
                    console.log('Fetched data:', data); // Debugging: Check fetched data

                    // Create an array to hold heatmap data
                    var heatmapData = [];

                    // Process data
                    data.forEach(entry => {
                        var lat = parseFloat(entry.lat);
                        var lng = parseFloat(entry.lng);
                        heatmapData.push([lat, lng]);
                    });

                    // Create the heatmap layer using Leaflet Heatmap plugin
                    L.heatLayer(heatmapData, {
                        radius: 25,
                        maxZoom: 18,
                        blur: 15,
                        max: 1, // Max intensity
                        gradient: { 0.4: "blue", 0.1: "lime", 0.6: "red" } // Adjust gradient as needed
                    }).addTo(map);
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        }

        // Call the function to fetch data and draw heatmap
        fetchDataAndDrawHeatmap();

    </script>
</body>

</html>
