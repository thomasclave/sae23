<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques des Capteurs</title>
</head>
<body>
    <h1>Statistiques des Capteurs</h1>

    <form method="post" action="">
        <label for="room">Sélectionnez la salle :</label>
        <input type="text" id="room" name="room" required>
        <br><br>
        
        <label for="sensorType">Sélectionnez le type de capteur :</label>
        <input type="text" id="sensorType" name="sensorType" required>
        <br><br>
        
        <input type="submit" name="submit" value="Voir les statistiques">
    </form>

    <?php
    if (isset($_POST['submit'])) {
        // Connexion à la base de données
        $databaseConnection = mysqli_connect("localhost", "fest", "pass23", "sae23");

        // Vérifier la connexion
        if (!$databaseConnection) {
            die("Échec de la connexion : " . mysqli_connect_error());
        }

        // Récupérer les valeurs du formulaire
        $room = $_POST['room'];
        $sensorType = $_POST['sensorType'];
        $sensorName = $room . '_' . $sensorType;

        // Requête pour obtenir la moyenne, le min et le max des valeurs pour un capteur spécifique
        $query = "
            SELECT AVG(Valeur) AS AvgValue, MIN(Valeur) AS MinValue, MAX(Valeur) AS MaxValue
            FROM mesure
            WHERE NomCapt = '$sensorName'
        ";

        $result = mysqli_query($databaseConnection, $query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            if ($row) {
                $avgValue = $row['AvgValue'];
                $minValue = $row['MinValue'];
                $maxValue = $row['MaxValue'];
                
                echo "<h2>Statistiques pour la salle '$room' et le capteur '$sensorType'</h2>";
                echo "<p>Valeur moyenne : $avgValue</p>";
                echo "<p>Valeur minimale : $minValue</p>";
                echo "<p>Valeur maximale : $maxValue</p>";
            } else {
                echo "<p>Aucune donnée trouvée pour le capteur '$sensorName'.</p>";
            }
        } else {
            echo "Erreur lors de la récupération des statistiques : " . mysqli_error($databaseConnection);
        }

        // Fermer la connexion
        mysqli_close($databaseConnection);
    }
    ?>
</body>
</html>
