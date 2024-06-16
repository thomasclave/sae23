<?php
	session_start(); 
	if ($_SESSION["auth"]!=TRUE)
		header("Location:login_admin_error.php");
    $_SESSION["nom_capt"]=$_REQUEST["nom_capt"];
    $nom_capt=$_SESSION["nom_capt"];
	$_SESSION["type_capt"]=$_REQUEST["type_capt"];
	$type_capt=$_SESSION["type_capt"];
    $_SESSION["unite"]=$_REQUEST["unite"];
	$unite=$_SESSION["unite"];
    $_SESSION["nom_salle"]=$_REQUEST["nom_salle"];
	$nom_salle=$_SESSION["nom_salle"];
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
	    <em><strong>Ajout d'un nouveau capteur</strong></em>
	    <br />
    </p>
		<section>
			<?php
                /* Access to the database */
		        include ("mysql.php");
                $requete_verif = "SELECT * FROM `capteur` WHERE `nomcapt`='$nom_capt'";
                $resultat_verif = mysqli_query($id_bd, $requete_verif);
                $capteur_existe = mysqli_num_rows($resultat_verif);

                if ($capteur_existe > 0) {
                    echo '<p>';
                    echo "<br /><strong>Erreur : Le capteur existe déjà dans la base de données.</strong><br />";
                    echo '</p>';
                }
                else {
                    $requete = "INSERT INTO `capteur` (`nomcapt`, `typecapt`, `unite`, `nomsalle`)
                    VALUES('$nom_capt','$type_capt','$unite','$nom_salle')";
                    $resultat = mysqli_query($id_bd, $requete)
                        or die("Execution de la requete impossible : $requete");
                    mysqli_close($id_bd);

                    echo '<p>';
                    echo "<ul>
                            <li> Nom du capteur ajouté : $nom_capt</li>
                            <li> Type du capteur ajouté : $type_capt </li>
                            <li> Unite du capteur ajouté : $unite</li>
                            <li> Salle : $nom_salle</li>
                          </ul>
                        </p>";
                }
			?>
			<hr />
		</section>
		<footer>
			<p><a href="add_cap.php">Ajoutez un autre capteur</a></p>
			<p><a href="modification_bdd.php">Modifier la base de donnees</a></p>
			<p><a href="index.php">Retour à l'accueil</a></p>
		</footer>
	</body>
</html>