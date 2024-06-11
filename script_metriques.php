<?php
// Connexion à la base de données
$databaseConnection = mysqli_connect("localhost", "fest", "pass23", "sae23");

// Vérifier la connexion
if (!$databaseConnection) {
    die("Échec de la connexion : " . mysqli_connect_error());
}

// Fonction pour obtenir la moyenne des valeurs pour un capteur spécifique
function getAverageValueBySensor($databaseConnection, $captname) {
    $averageValue = null;

    // Requête pour obtenir la moyenne des valeurs pour un capteur spécifique
    $query = "
        SELECT AVG(Valeur) AS AvgValue
        FROM mesure
        WHERE NomCapt = '$captname'
    ";

    $result = mysqli_query($databaseConnection, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            $averageValue = $row['AvgValue'];
        }
        mysqli_free_result($result);
    } else {
        echo "Erreur lors de la récupération de la moyenne : " . mysqli_error($databaseConnection);
    }

    return $averageValue;
}

// Nom du capteur pour lequel calculer la moyenne
$captname = 'E007_co2';  // Remplacez par le nom du capteur souhaité

// Récupérer la moyenne des valeurs pour le capteur spécifié
$averageValue = getAverageValueBySensor($databaseConnection, $captname);

// Afficher la moyenne des valeurs pour le capteur
if ($averageValue !== null) {
    echo "La valeur moyenne pour le capteur $captname est : $averageValue\n";
} else {
    echo "Aucune valeur trouvée pour le capteur $captname.\n";
}

// Fermer la connexion
mysqli_close($databaseConnection);
?>
