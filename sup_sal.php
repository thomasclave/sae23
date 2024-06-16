<?php
    session_start(); 
    if ($_SESSION["auth"] != TRUE)
        header("Location:login_admin_error.php");

    $_SESSION["nom_salle"] = $_REQUEST["nom_salle"];
    $nom_salle = $_SESSION["nom_salle"];
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
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700,400italic,700italic" rel="stylesheet" type="text/css">
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
            <li><a href="./gestion.php">Gestion</a></li>
            <li><a href="./admin.php">Administration</a></li>
        </ul>
     </nav>
     
     <!--Title-->
     <header>
     <h2>Administration</h2>
     </header>

    <p>
        <br />
        <em><strong>Suppression d'une salle</strong></em>
        <br />
    </p>
    <section>
        <?php
            /* Access to the database */
            include ("mysql.php");
            $requete_verif = "SELECT * FROM `salle` WHERE `nomsalle`='$nom_salle'";
            $resultat_verif = mysqli_query($id_bd, $requete_verif);
            $salle_existe = mysqli_num_rows($resultat_verif);

            if ($salle_existe == 0) {
                echo '<p>';
                echo "<br /><strong>Erreur : La salle n'existe pas dans la base de données.</strong><br />";
                echo '</p>';
            }
            else {
                $requete = "DELETE FROM `salle` WHERE `nomsalle`='$nom_salle'";
                $resultat = mysqli_query($id_bd, $requete)
                    or die("Execution de la requête impossible : $requete");
                mysqli_close($id_bd);

                echo '<p>';
                echo "<br /><strong>La salle a été supprimée avec succès.</strong><br />";
                echo '</p>';
            }
        ?>
        <hr />
    </section>
    <footer>
        <p><a href="del_sal.php">Supprimer une autre salle</a></p>
        <p><a href="modification_bdd.php">Modifier la base de données</a></p>
        <p><a href="index.php">Retour à l'accueil</a></p>
    </footer>
</body>
</html>
