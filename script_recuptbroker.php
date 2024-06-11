#!/opt/lampp/bin/php

<?php

// Database connection
$databaseConnection = mysqli_connect("localhost", "fest", "pass23", "sae23");

// Check connection
if (!$databaseConnection) {
    die("Échec de la connexion : " . mysqli_connect_error());
}

// Infinite loop

while (true) {
    // Run the shell script and decode the JSON
    $jsonData = shell_exec('mosquitto_sub -h mqtt.iut-blagnac.fr -t AM107/by-room/+/data -C 1');
    $decodedData = json_decode($jsonData, true);

    //extract specific data from JSON object
    $measurements = $decodedData[0];
    $deviceInfo = $decodedData[1];

    // recover the room and the building
    $roomName = $deviceInfo['room'];
    $buildingId = $deviceInfo['Building'];

    // Check and insert building
    $checkBuildingQuery = "SELECT * FROM batiment WHERE ID_BAT = '$buildingId'";
    $buildingResult = mysqli_query($databaseConnection, $checkBuildingQuery);

    //Checking the existence of the building
    if (mysqli_num_rows($buildingResult) == 0) {
        //If the building does not exist, an INSERT SQL query is build to add the building with ID $buildingId
        $insertBuildingQuery = "INSERT INTO batiment (ID_BAT) VALUES ('$buildingId')";
        if (!mysqli_query($databaseConnection, $insertBuildingQuery)) {
            echo "Erreur lors de l'insertion du bâtiment : " . mysqli_error($databaseConnection);
        } else {
            echo "Insertion du bâtiment réussie.\n";
        }
    }

    // Check and insert room
    $checkRoomQuery = "SELECT * FROM salle WHERE NomSalle = '$roomName'";
    $roomResult = mysqli_query($databaseConnection, $checkRoomQuery);

    // Checking the existence of the room
    if (mysqli_num_rows($roomResult) == 0) {
        //If the room does not exist, an INSERT SQL query is build to add the room with the name $roomName and the associated building ID ($buildingId)
        $insertRoomQuery = "INSERT INTO salle (NomSalle, ID_BAT) VALUES ('$roomName', '$buildingId')";
        if (!mysqli_query($databaseConnection, $insertRoomQuery)) {
            echo "Erreur lors de l'insertion de la salle : " . mysqli_error($databaseConnection);
        } else {
            echo "Insertion de la salle réussie.\n";
        }
    }

    //look in the data table for all the sensor types and retrieves the value
    foreach ($measurements as $sensorType => $sensorValue) {
        // Ignore unwanted sensors
        if (in_array($sensorType, ['activity', 'infrared', 'tvoc', 'infrared_and_visible'])) {
            continue;
        }

        //Determine the sensor unit
        $unit = '';
        switch ($sensorType) {
            case 'temperature':
                $unit = '°C';
                break;
            case 'humidity':
                $unit = '%';
                break;
            case 'co2':
                $unit = 'ppm';
                break;
            case 'illumination':
                $unit = 'lux';
                break;
            case 'pressure':
                $unit = 'hPa';
                break;
            default:
                $unit = '';
        }

        // Construct the sensor name using the room name followed by the sensor type
        $sensorName = $roomName . '_' . $sensorType;
        // Check if the sensor already exists in the database
        $checkSensorQuery = "SELECT * FROM capteur WHERE NomCapt = '$sensorName'";
        $sensorResult = mysqli_query($databaseConnection, $checkSensorQuery);

        // If the sensor does not exist, insert it into the database
        if (mysqli_num_rows($sensorResult) == 0) {
            $insertSensorQuery = "INSERT INTO capteur (NomCapt, TypeCapt, Unite, NomSalle) VALUES ('$sensorName', '$sensorType', '$unit', '$roomName')";
            if (!mysqli_query($databaseConnection, $insertSensorQuery)) {
                echo "Erreur lors de l'insertion du capteur $sensorName : " . mysqli_error($databaseConnection);
            } else {
                echo "Insertion du capteur $sensorName réussie.\n";
            }
        }

        // Insert date and time into database
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i:s');
        $insertMeasurementQuery = "INSERT INTO mesure (Date, Horaire, Valeur, NomCapt) VALUES ('$currentDate', '$currentTime', '$sensorValue', '$sensorName')";

        if (!mysqli_query($databaseConnection, $insertMeasurementQuery)) {
            echo "Erreur lors de l'insertion de la mesure pour le capteur $sensorName : " . mysqli_error($databaseConnection);
        } else {
            echo "Insertion de la mesure pour le capteur $sensorName réussie.\n";
        }
    }
}
?>
