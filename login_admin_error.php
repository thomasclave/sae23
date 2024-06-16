<?php
	// Start the session
	session_start();
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
	   <meta charset="UTF-8" />
	   <title>Identification erron&eacute;e</title>
	   <link rel="stylesheet" type="text/css" href="./css/style.css" />
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

		<?php 
			$_SESSION = array(); // Reset of the session array
			session_destroy();   // Session destruction
			unset($_SESSION);    // Array destruction
		?>
		<section>
			<p>
				<br />
				<em><strong>Administration de la base : Acc&egrave;s limit&eacute; aux personnes autoris&eacute;es</strong></em>
				<br />
			</p>
			<br />
			<p>Mot de passe non saisi ou erron&eacute; !!!</p>
			<br />
			<hr />
		</section>
		<footer>
			<p><a href="index.php">Retour à l'accueil</a></p>
			<p><a href="admin.php">Retour à l'identification</a></p>
		</footer>
	</body>
</html>
