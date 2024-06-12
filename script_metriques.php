<?php
include 'mysql.php';

// Settings
$salle = "E007"; // Replace with the name of the desired room
$typeCapteur = "co2"; // Replace with desired sensor type

// Construction of sensor name
$sensorName = $salle . '_' . $typeCapteur;

// SQL query to get minimum, maximum and average value
$query = "
    SELECT 
        MAX(Valeur) AS ValeurMax,
        MIN(Valeur) AS ValeurMin,
        AVG(Valeur) AS ValueMoyenne
    FROM 
        mesure
    WHERE 
        NomCapt = '$sensorName'
";

// Executing the query
$result = mysqli_query($id_bd, $query);

// Checking the result
if ($result) {
    // Retrieving the result
    $row = mysqli_fetch_assoc($result);

    // Displaying results
    if ($row) {
        $maxValue = $row['ValeurMax'];
        $minValue = $row['ValeurMin'];
        $avgValue = $row['ValueMoyenne'];

        echo "Pour le capteur de type $typeCapteur dans la salle $salle :<br>";
        echo "Valeur maximale : $maxValue<br>";
        echo "Valeur minimale : $minValue<br>";
        echo "Valeur moyenne : $avgValue<br>";
    } else {
        echo "Aucune valeur trouvée pour le capteur $sensorName.";
    }
} else {
    echo "Erreur lors de l'exécution de la requête : " . mysqli_error($id_bd);
}

// Closing the connection
mysqli_close($id_bd);
?>
