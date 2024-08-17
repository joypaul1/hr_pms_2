<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Location View</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA9i10Vq3dbgL7t8abfMpgScb_zhj0MvRc"></script>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            font-size: 10px;
            font-weight: 500;
        }

        #map {
            height: 100%;
        }

        .message {
            text-align: center;
            font-size: 24px;
            margin-top: 20px;
        }

        .table>tbody>tr>td {
            padding: 0 !important;
        }
    </style>

</head>
<?php
session_start();
require_once('../../../inc/connoracle.php');
$basePath = $_SESSION['basePath'];
$rmlID = trim($_GET['rml_id']);
$date = date('d/m/Y', strtotime($_GET['date']));
$infoQuery = "SELECT RML_ID,EMP_NAME,MOBILE_NO,DESIGNATION,DEPT_NAME,BRANCH_NAME FROM RML_HR_APPS_USER WHERE LOWER(RML_ID) = LOWER('$rmlID')";
$strSQL2 = oci_parse($objConnect, $infoQuery);
@oci_execute($strSQL2);
$infoData = @oci_fetch_assoc($strSQL2);

?>

<body>
    <main class="mt-1">
        <div class="row justify-content-between">
            <div class="col-4">
                <table class="table table-secondary table-bordered table-responsive">

                    <tr class="text-center">
                        <td colspan="3"><?php echo $infoData['EMP_NAME']; ?> (<span
                                class="text-success"><?php echo $infoData['RML_ID']; ?></span>)</td>
                    </tr>
                    <tr class="text-center">
                        <td><?php echo $infoData['MOBILE_NO']; ?></td>
                        <td><?php echo $infoData['DEPT_NAME']; ?></td>
                        <td><?php echo $infoData['BRANCH_NAME']; ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-5">
                <marquee style="font-size:16px">Welcome to Rangs Tracking!
                    Our tool for effective team oversight and streamlined
                    management.</marquee>
            </div>
            <div class="col-2">
                <img class="card-img-top" src="https://upload.wikimedia.org/wikipedia/commons/b/b6/Rangs-Group-Logo.png"
                    alt="Card image cap" style="height: 30px;">
                    <span>Date : <?php echo $date ?></span> |
                    <span>Powered By : RML IT & ERP </span>
            </div>


    </main>
    <table>

    </table>
    <?php

    $query = "SELECT A.RML_ID, A.LOC_LAT, A.LOC_LANG
                FROM RML_HR_APPS_USER_LOCATION A
                WHERE LOWER(A.RML_ID) = LOWER('$rmlID')
                AND TRUNC(A.ENTRY_TIME) = TO_DATE('$date', 'DD/MM/YYYY')";

    $strSQL = oci_parse($objConnect, $query);
    @oci_execute($strSQL);

    $locations = [];
    while ($row = @oci_fetch_assoc($strSQL)) {
        $locations[] = [
            'lat' => (float) $row['LOC_LAT'],
            'lng' => (float) $row['LOC_LANG']
        ];
    }
    if (empty($locations)) {
        echo "<div class='message'>Location Data Not Found for $rmlID on $date</div>";
    } else {
        // Output the locations in JSON format for use in JavaScript
        $locations_json = json_encode($locations);
        ?>



        <div id="map"></div>

        <script>
            // Get the PHP data as a JavaScript object
            const locations = <?php echo $locations_json; ?>;

            // Set startLocation and endLocation
            const startLocation = locations[0];
            const endLocation = locations[locations.length - 1];

            // Set waypoints (excluding the first and last locations)
            const waypoints = locations.slice(1, -1).map(location => {
                return {
                    location: location,
                    stopover: true
                };
            });

            // Define the bounds for Bangladesh
            var bangladeshBounds = {
                north: 26.6383,
                south: 20.7388,
                east: 92.6736,
                west: 88.0088
            };

            // Initialize the map
            const map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: 23.6850,
                    lng: 90.3563
                }, // Center of Bangladesh
                zoom: 7 // Adjusted zoom to fit the entire route
            });

            const directionsService = new google.maps.DirectionsService();
            const directionsRenderer = new google.maps.DirectionsRenderer({
                map: map
            });

            directionsService.route({
                origin: startLocation,
                destination: endLocation,
                waypoints: waypoints,
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
                        label: '👱',
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
        <?php
    }
    ?>
</body>

</html>