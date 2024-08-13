<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA9i10Vq3dbgL7t8abfMpgScb_zhj0MvRc"></script>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        #map {
            height: 100%;
        }
    </style>

</head>

<body>
    <div id="map"></div>

    <script>
        const startLocation = { lat: 23.8103, lng: 90.4125 };
        const endLocation = { lat: 23.8841, lng: 90.3973 };

        // Additional waypoints
        const waypoints = [
            {
                location: { lat: 23.8172, lng: 90.3683 },
                stopover: true
            },
            {
                location: { lat: 23.7480, lng: 90.3840 },
                stopover: true
            },
            {
                location: { lat: 23.7961, lng: 90.3844 },
                stopover: true
            }
        ];

        // Define the bounds for Bangladesh
        var bangladeshBounds = {
            north: 26.6383,
            south: 20.7388,
            east: 92.6736,
            west: 88.0088
        };
        // Initialize the map
        const map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: 23.6850, lng: 90.3563 }, // Center of Bangladesh
            // restriction: {
            //     latLngBounds: bangladeshBounds,
            //     strictBounds: true,
            // },
            zoom: 7 // Adjusted zoom to fit the entire route
        });

        const directionsService = new google.maps.DirectionsService();
        const directionsRenderer = new google.maps.DirectionsRenderer({
            map: map
        });

        directionsService.route({
            origin: startLocation,
            destination: endLocation,
            waypoints: waypoints, // Adding waypoints
            travelMode: google.maps.TravelMode.DRIVING
        }, function (response, status) {
            if (status === google.maps.DirectionsStatus.OK) {
                directionsRenderer.setDirections(response);

                // Get the steps for animation
                const steps = response.routes[0].overview_path;

                // Create the marker
                const marker = new google.maps.Marker({
                    map: map,
                    position: {
                        lat: steps[0].lat(),
                        lng: steps[0].lng()
                    },
                    label: '🚘',
                    zIndex: 1,
                });

                // Move the marker along the route
                let i = 0;
                const interval = setInterval(function () {
                    i++;
                    if (i === steps.length) {
                        clearInterval(interval);
                        return;
                    }

                    marker.setPosition({
                        lat: steps[i].lat(),
                        lng: steps[i].lng()
                    });

                }, 100);


            } else {
                console.error('Directions request failed due to ' + status);
            }
        });
    </script>
</body>

</html>