<?php
	session_start(); 
	if ($_SESSION["auth"]!=TRUE)
		header("Location:login_admin_error.php");
    $_SESSION["id_bat"]=$_REQUEST["id_bat"];
    $id_bat=$_SESSION["id_bat"];
	$_SESSION["nom_bat"]=$_REQUEST["nom_bat"];
	$nom_bat=$_SESSION["nom_bat"];
    $_SESSION["login_gest"]=$_REQUEST["login_gest"];
	$login_gest=$_SESSION["login_gest"];
    $_SESSION["mdp_gest"]=$_REQUEST["mdp_gest"];
	$mdp_gest=$_SESSION["mdp_gest"];
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
	    <em><strong>Ajout d'un nouveau batiment</strong></em>
	    <br />
    </p>
		<section>
			<?php
                /* Access to the database */
		        include ("mysql.php");
                $requete_verif = "SELECT * FROM `Batiment` WHERE `id_bat`='$id_bat'";
                $resultat_verif = mysqli_query($id_bd, $requete_verif);
                $batiment_existe = mysqli_num_rows($resultat_verif);

                if ($batiment_existe > 0) {
                    echo '<p>';
                    echo "<br /><strong>Erreur : Le batiment existe déjà dans la base de données.</strong><br />";
                    echo '</p>';
                }
                else {
                    $requete = "INSERT INTO `Batiment` (`id_bat`, `nombat`, `logingest`, `mdpgest`)
                    VALUES('$id_bat','$nom_bat','$login_gest','$mdp_gest')";
                    $resultat = mysqli_query($id_bd, $requete);
                        #or die("Execution de la requete impossible : $requete");
                    mysqli_close($id_bd);

                    echo '<p>';
                    echo "<ul>
                            <li> Identifiant du batiment ajouté : $id_bat</li>
                            <li> Nom du batiment ajouté : $nom_bat </li>
                            <li> Login du gestionnaire : $login_gest</li>
                            <li> Mot de passe du gestionnaire : $mdp_gest</li>
                          </ul>
                        </p>";
                }
			?>
			<hr />
		</section>
		<footer>
			<p><a href="add_bat.php">Ajoutez un autre batiment</a></p>
			<p><a href="modification_bdd.php">Modifier la base de donnees</a></p>
			<p><a href="index.php">Retour à l'accueil</a></p>
		</footer>
	</body>
</html>