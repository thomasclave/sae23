<?php 
	session_start(); 
	if ($_SESSION["auth"]!=TRUE)
		header("Location:login_admin_error.php");
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
	    <em><strong>Ajout d'une nouvelle salle</strong></em>
	    <br />
    </p>

<section>
        <form action="ajout_sal.php" method="post" enctype="multipart/form-data" class="form">
				<fieldset>
					<legend>Information sur la salle</legend>
					<label for="nom_salle">Nom de la salle:</label>
					<input type="text" name="nom_salle" id ="nom_salle" required/>
					<label for="type_salle">Type de la salle (CM, TD, TP):</label>
					<input type="text" name="type_salle" id ="type_salle" />
					<label for="capacite">Capacite :</label>
					<input type="text" name="capacite" id ="capacite" />
                    <label for="id_bat">Batiment :</label>
					<input type="text" name="id_bat" id ="id_bat" required/>
				</fieldset>
				<p>
					<input type="submit" value="Validez" />
                </p>
			</form>
</section>

<!--Footer-->
<footer>
    Site réalisé dans le cadre de la SAE23<br>
    <a href="./mentions-legales.html">Mentions Légales</a><br>
</footer>

</body>
</html>
