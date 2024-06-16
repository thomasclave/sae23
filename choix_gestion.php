<?php
session_start();
if ($_SESSION["auth"] != TRUE) {
    header("Location:login_gest_error.php");
    exit();
}

$login = $_SESSION["login"];
$mdp = $_SESSION["mdp"];

include("mysql.php");

// Retrieving the buildings managed by the manager
$requete_batiments = "SELECT ID_Bat, NomBat FROM batiment WHERE LoginGest = '$login' AND MdpGest = '$mdp'";
$resultat_batiments = mysqli_query($id_bd, $requete_batiments)
    or die("Execution de la requete impossible : $requete_batiments");

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
        <h2>Gestion</h2>
    </header>

    <main>
        <h3>Consultation des mesures</h3>
        <form action="affichage_gestion.php" method="POST">
            <label for="batiment">Sélectionnez un bâtiment :</label>
            <select name="batiment" id="batiment" required>
                <?php
                while ($row = mysqli_fetch_assoc($resultat_batiments)) {
                    echo "<option value='" . $row['ID_Bat'] . "'>" . $row['NomBat'] . "</option>";
                }
                ?>
            </select>
            <br><br>

            <label for="salle">Sélectionnez une salle :</label>
            <select name="salle" id="salle" required>
                <?php
                // Reset the result pointer to retrieve the rooms associated with the selected building
                mysqli_data_seek($resultat_batiments, 0);

                while ($row = mysqli_fetch_assoc($resultat_batiments)) {
                    $batiment_id = $row['ID_Bat'];
                    $requete_salle = "SELECT NomSalle FROM salle WHERE ID_Bat = '$batiment_id'";
                    $resultat_salle = mysqli_query($id_bd, $requete_salle)
                        or die("Execution de la requete impossible : $requete_salle");

                    while ($salle = mysqli_fetch_assoc($resultat_salle)) {
                        echo "<option value='" . $salle['NomSalle'] . "'>" . $salle['NomSalle'] . "</option>";
                    }
                }
                ?>
            </select>
            <br><br>

            <label for="capteur">Sélectionnez un type de capteur :</label>
            <select name="capteur" id="capteur" required>
                <?php
                // Retrieving the sensor types associated with each room
                mysqli_data_seek($resultat_batiments, 0);

                while ($row = mysqli_fetch_assoc($resultat_batiments)) {
                    $batiment_id = $row['ID_Bat'];
                    $requete_capteur = "SELECT DISTINCT capteur.TypeCapt
                                        FROM salle
                                        INNER JOIN capteur ON salle.NomSalle = capteur.NomSalle
                                        WHERE salle.ID_Bat = '$batiment_id'";
                    $resultat_capteur = mysqli_query($id_bd, $requete_capteur)
                        or die("Execution de la requete impossible : $requete_capteur");

                    while ($capteur = mysqli_fetch_assoc($resultat_capteur)) {
                        echo "<option value='" . $capteur['TypeCapt'] . "'>" . $capteur['TypeCapt'] . "</option>";
                    }
                }
                ?>
            </select>
            <br><br>

            <input type="submit" value="Consulter">
        </form>
    </main>

    <!--Footer-->
    <footer>
        Site réalisé dans le cadre de la SAE23<br>
        <a href="./mentions-legales.html">Mentions Légales</a><br>
    </footer>

</body>

</html>

<?php
mysqli_close($id_bd);
?>
