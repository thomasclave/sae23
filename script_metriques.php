<?php
// Connexion à la base de données
$databaseConnection = mysqli_connect("localhost", "fest", "pass23", "sae23");

// Vérifier la connexion
if (!$databaseConnection) {
    die("Échec de la connexion : " . mysqli_connect_error());
}

// Paramètres
$salle = "E007"; // Remplacez par le nom de la salle souhaitée
$typeCapteur = "co2"; // Remplacez par le type de capteur souhaité

// Construction du nom du capteur
$sensorName = $salle . '_' . $typeCapteur;

// Requête SQL pour obtenir la valeur minimale, maximale et moyenne
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

// Exécution de la requête
$result = mysqli_query($databaseConnection, $query);

// Vérification du résultat
if ($result) {
    // Récupération du résultat
    $row = mysqli_fetch_assoc($result);

    // Affichage des résultats
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
    echo "Erreur lors de l'exécution de la requête : " . mysqli_error($databaseConnection);
}

// Fermeture de la connexion
mysqli_close($databaseConnection);
?>
