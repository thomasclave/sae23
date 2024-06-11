<?php
// Connexion à la base de données
$databaseConnection = mysqli_connect("localhost", "fest", "pass23", "sae23", null, "/opt/lampp/var/mysql/mysql.sock");

// Vérifier la connexion
if (!$databaseConnection) {
    die("Échec de la connexion : " . mysqli_connect_error());
}

// Fonction pour obtenir la moyenne des valeurs pour une salle spécifique
function getAverageValueByRoom($databaseConnection, $captname) {
    $averageValue = null;

    // Requête pour obtenir la moyenne des valeurs pour une salle spécifique
    $query = "
        SELECT Valeur, AVG(Valeur)
        FROM mesure
        WHERE NomCapt = '$captname'
    ";

    $result = mysqli_query($databaseConnection, $query);

    $averageValue = $result;

    return $averageValue;
}

// Nom de la salle pour laquelle calculer la moyenne
$captname= 'E007_co2';  // Remplacez par le nom de la salle souhaitée

// Récupérer la moyenne des valeurs pour la salle spécifiée
$averageValue = getAverageValueByRoom($databaseConnection, $captname);

// Afficher la moyenne des valeurs pour la salle
if ($averageValue !== null) {
    echo "La valeur moyenne pour le capteur $captname est : $averageValue\n";
} else {
    echo "Aucune valeur trouvée pour le capteur $captname.\n";
}

// Fermer la connexion
mysqli_close($databaseConnection);
?>
