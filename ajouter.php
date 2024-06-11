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
	    <em><strong>Que voulez-vous ajouter ?</strong></em>
	    <br />
    </p>

    <main>
        <button onclick="location.href='./add_bat.php'">Batiment</button>
        <button onclick="location.href='./add_sal.php'">Salle</button>
        <button onclick="location.href='./add_cap.php'">Capteur</button>
    </main>

<!--Footer-->
<footer>
    Site réalisé dans le cadre de la SAE23<br>
    <a href="./mentions-legales.html">Mentions Légales</a><br>
</footer>

</body>
</html>
