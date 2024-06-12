<?php
session_start();
if ($_SESSION["auth"] != TRUE) {
    header("Location:login_gest_error.php");
    exit();
}

include ("mysql.php");
$_SESSION["salle"]=$_REQUEST["salle"];  // Récupération du mot de passe
$NomSalle=$_SESSION["salle"];

$_SESSION["capteur"]=$_REQUEST["capteur"];  // Récupération du mot de passe
$TypeCapt=$_SESSION["capteur"];

$NomCapt=$NomSalle ."_". $TypeCapt;

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAE23</title>

    <!--CSS links-->
    <link rel="stylesheet" href="./css/style.css">

    <!--Policies links-->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700,400italic,700italic" rel="stylesheet"
        type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">

</head>

<body>
    <!--Navbar-->
    <nav class="navbar">
        <a class="nav-nom" href="./index.php">SAE23</a>
        <ul class="nav-links">
            <li><a href="./index.php">Accueil</a></li>
            <li><a href="./consultation.php">Consultation</a></li>
            <li><a href="./gestion_projet.html">Gestion de Projet</a></li>
            <li><a href="./admin.php">Administration</a></li>
            <li><a href="./gestion.php">Gestion</a></li>
        </ul>
    </nav>

    <!--Title-->
    <header>
        <h2>Consultation des mesures</h2>
    </header>

    <main>
        <?php
        include 'mysql.php'; // Connexion à la base de données
        
        echo "<br><br>";
        echo "<h3>Capteur : " . $NomCapt . "</h3>";

        // Requête pour obtenir les mesures du capteur spécifié
        $requete_mesures = "
            SELECT c.NomCapt, c.TypeCapt, m.Date, m.Horaire,  CONCAT(m.Valeur, ' ', c.Unite) AS Valeur_Unite
            FROM mesure m
            INNER JOIN capteur c ON m.NomCapt = c.NomCapt
            WHERE c.NomCapt = '$NomCapt'
        ";

        $resultat_mesures = mysqli_query($id_bd, $requete_mesures)
            or die("Execution de la requete impossible : $requete_mesures");

        if (mysqli_num_rows($resultat_mesures) > 0) {
            echo "<table>";
            echo "<tr><th>Nom du Capteur</th><th>Type</th><th>Date</th><th>Heure</th><th>Valeur</th></tr>";
            while ($row = mysqli_fetch_assoc($resultat_mesures)) {
                echo "<tr>";
                echo "<td>" . $row['NomCapt'] . "</td>";
                echo "<td>" . $row['TypeCapt'] . "</td>";
                echo "<td>" . $row['Date'] . "</td>";
                echo "<td>" . $row['Horaire'] . "</td>";
                echo "<td>" . $row['Valeur_Unite'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "<br><br>";

            // Requête pour obtenir l'unité du capteur
            $requete_unite = "SELECT Unite FROM capteur WHERE NomCapt = '$NomCapt'";
            $resultat_unite = mysqli_query($id_bd, $requete_unite);
            
            // Vérification du résultat
            if ($resultat_unite) {
                $row = mysqli_fetch_assoc($resultat_unite);
                $unit = $row['Unite'];
            } else {
                $unit = "Unité non trouvée";
            }

            // Calcul des métriques
            $query = "
                SELECT 
                    MAX(Valeur) AS ValeurMax,
                    MIN(Valeur) AS ValeurMin,
                    AVG(Valeur) AS ValueMoyenne
                FROM 
                    mesure
                WHERE 
                    NomCapt = '$NomCapt'
            ";

            // Exécution de la requête
            $result = mysqli_query($id_bd, $query);
            
            // Vérification du résultat
            if ($result) {
                $row = mysqli_fetch_assoc($result);

                // Affichage des résultats
                if ($row) {
                    $maxValue = $row['ValeurMax'];
                    $minValue = $row['ValeurMin'];
                    $avgValue = $row['ValueMoyenne'];

                    echo "<article class='cadre-contenu'>";
                    echo "<h3>Statistiques</h3>";
                    echo "<p>Valeur maximale : $maxValue $unit<br></p>";
                    echo "<p>Valeur minimale : $minValue $unit<br></p>";
                    echo "<p>Valeur moyenne : $avgValue $unit<br></p>";
                    echo "</article>";
                } else {
                    echo "Aucune valeur trouvée pour le capteur $NomCapt.";
                }
            } else {
                echo "Erreur lors de l'exécution de la requête : " . mysqli_error($id_bd);
            }
        } else {
            echo "<p>Aucune mesure trouvée pour ce capteur.</p>";
        }

        // Fermer la connexion à la base de données
        mysqli_close($id_bd);
        ?>
    </main>

    <!--Footer-->
    <footer>
        Site réalisé dans le cadre de la SAE23<br>
        <a href="./mentions-legales.html">Mentions Légales</a><br>
    </footer>

</body>

</html>
