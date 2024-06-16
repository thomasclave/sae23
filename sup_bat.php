<?php
	session_start(); 
	if ($_SESSION["auth"] != TRUE)
		header("Location:login_admin_error.php");
    $_SESSION["id_bat"] = $_REQUEST["id_bat"];
    $id_bat = $_SESSION["id_bat"];
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
	    <em><strong>Suppression d'un bâtiment</strong></em>
	    <br />
    </p>
		<section>
			<?php
                /* Access to the database */
		        include ("mysql.php");
                $requete_verif = "SELECT * FROM `Batiment` WHERE `id_bat`='$id_bat'";
                $resultat_verif = mysqli_query($id_bd, $requete_verif);
                $batiment_existe = mysqli_num_rows($resultat_verif);

                if ($batiment_existe == 0) {
                    echo '<p>';
                    echo "<br /><strong>Erreur : Le bâtiment n'existe pas dans la base de données.</strong><br />";
                    echo '</p>';
                }
                else {
                    $requete = "DELETE FROM `Batiment` WHERE `id_bat`='$id_bat'";
                    $resultat = mysqli_query($id_bd, $requete);
                    mysqli_close($id_bd);

                    echo '<p>';
                    echo "<strong>Le bâtiment avec l'identifiant $id_bat a été supprimé avec succès.</strong>";
                    echo '</p>';
                }
			?>
			<hr />
		</section>
		<footer>
			<p><a href="del_bat.php">Supprimer un autre bâtiment</a></p>
			<p><a href="modification_bdd.php">Modifier la base de données</a></p>
			<p><a href="index.php">Retour à l'accueil</a></p>
		</footer>
	</body>
</html>