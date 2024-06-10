#!/opt/lampp/bin/php
<?php

// Connexion à la base de données
$databaseConnection = mysqli_connect("localhost", "fest", "pass23", "sae23");

// Vérifier la connexion
if (!$databaseConnection) {
    die("Échec de la connexion : " . mysqli_connect_error());
}

// Boucle infinie pour attendre les données
while (true) {
    // Exécuter le script shell et décoder le JSON
    $jsonData = shell_exec('mosquitto_sub -h mqtt.iut-blagnac.fr -t AM107/by-room/+/data -C 1');
    $decodedData = json_decode($jsonData, true);

    // Vérifier le contenu de $decodedData
    print_r($decodedData);

    $measurements = $decodedData[0];
    $deviceInfo = $decodedData[1];

    // Informations de l'appareil
    $roomName = $deviceInfo['room'];
    $buildingId = $deviceInfo['Building'];

    // Vérifier et insérer le bâtiment
    $checkBuildingQuery = "SELECT * FROM batiment WHERE ID_BAT = '$buildingId'";
    $buildingResult = mysqli_query($databaseConnection, $checkBuildingQuery);

    if (mysqli_num_rows($buildingResult) == 0) {
        $insertBuildingQuery = "INSERT INTO batiment (ID_BAT) VALUES ('$buildingId')";
        if (!mysqli_query($databaseConnection, $insertBuildingQuery)) {
            echo "Erreur lors de l'insertion du bâtiment : " . mysqli_error($databaseConnection);
        } else {
            echo "Insertion du bâtiment réussie.\n";
        }
    }

    // Vérifier et insérer la salle
    $checkRoomQuery = "SELECT * FROM salle WHERE NomSalle = '$roomName'";
    $roomResult = mysqli_query($databaseConnection, $checkRoomQuery);

    if (mysqli_num_rows($roomResult) == 0) {
        $insertRoomQuery = "INSERT INTO salle (NomSalle, ID_BAT) VALUES ('$roomName', '$buildingId')";
        if (!mysqli_query($databaseConnection, $insertRoomQuery)) {
            echo "Erreur lors de l'insertion de la salle : " . mysqli_error($databaseConnection);
        } else {
            echo "Insertion de la salle réussie.\n";
        }
    }

    // Insérer les capteurs et les mesures
    foreach ($measurements as $sensorType => $sensorValue) {
        // Ignorer les capteurs indésirables
        if (in_array($sensorType, ['activity', 'infrared', 'tvoc', 'infrared_and_visible'])) {
            continue;
        }

        // Déterminer l'unité du capteur (exemple simplifié)
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

        // Construire le nom du capteur en utilisant le nom de la salle suivi du type de capteur
        $sensorName = $roomName . '_' . $sensorType;
        $checkSensorQuery = "SELECT * FROM capteur WHERE NomCapt = '$sensorName'";
        $sensorResult = mysqli_query($databaseConnection, $checkSensorQuery);

        if (mysqli_num_rows($sensorResult) == 0) {
            $insertSensorQuery = "INSERT INTO capteur (NomCapt, TypeCapt, Unite, NomSalle) VALUES ('$sensorName', '$sensorType', '$unit', '$roomName')";
            if (!mysqli_query($databaseConnection, $insertSensorQuery)) {
                echo "Erreur lors de l'insertion du capteur $sensorName : " . mysqli_error($databaseConnection);
            } else {
                echo "Insertion du capteur $sensorName réussie.\n";
            }
        }

        // Insérer la mesure
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

// La boucle continue indéfiniment, donc la connexion ne sera jamais fermée
?>
