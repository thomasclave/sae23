<?php
	// Démarrage de la session
	session_start();
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
            <li><a href="./admin.php">Administration</a></li>
            <li><a href="./gestion.php">Gestion</a></li>
        </ul>
     </nav>
     
     <!--Title-->
     <header>
     <h2>Gestion</h2>
     </header>

     <p>
		<br/>
		<em><strong>Gestion des bâtiments : Acc&egrave;s limit&eacute; aux personnes autoris&eacute;es</strong></em>
		<br/>
	</p>

<section>

    <form action="login_gest.php" method="post" class="form">
        <fieldset>
            <legend>Identifiez vous en tant que gestionnaire</legend>
            <label for="login">Login:</label>
            <input type="text" id="login" name="login"><br><br>
            <label for="password">Mot de passe:</label>
            <input type="password" id="mdp" name="mdp"><br><br>
        </fieldset>
        <input type="submit" value="Se connecter">

</section>

<!--Footer-->
<footer>
    Site réalisé dans le cadre de la SAE23<br>
    <a href="./mentions-legales.html">Mentions Légales</a><br>
</footer>

</body>
</html>
