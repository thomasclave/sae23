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
            <li><a href="./gestion.php">Gestion</a></li>
            <li><a href="./admin.php">Administration</a></li>
        </ul>
    </nav>

    <!--Title-->
    <header>
        <h2>Accueil SAE23</h2>
    </header>

    <main>

        <h2>Objectifs du site</h2>
        <p>
            A travers ce site, l'objectif est de visualiser des données comme la température, le CO2, l'humidité, la
            luminosité et la pression. <br>
            A l'aide des pages d'administration, il est possible d'ajouter et de supprimer des salles et bâtiments.<br>
            La visualisation des dernières données est publique. Néanmoins, la visualisation de métriques et de plus
            larges valeurs nécessite une authentification par le gestionnaire du bon bâtiment. <br>
            <br><br>
        </p>

        <h2>Bâtiments gérés</h2>

        <?php
        include 'mysql.php'; // Connexion à la base de données
        
        // Requête pour obtenir les bâtiments gérés
        $query_buildings = "
        SELECT DISTINCT NomBat, ID_Bat
        FROM batiment
    ";

        $result_buildings = mysqli_query($id_bd, $query_buildings);

        if ($result_buildings && mysqli_num_rows($result_buildings) > 0) {
            echo "<table>";
            echo "<tr><th>Identifiant Bâtiment</th><th>Nom Bâtiment</th></tr>";
            while ($building = mysqli_fetch_assoc($result_buildings)) {
                echo "<tr><td>" . $building['ID_Bat'] . "</td><td>" . $building['NomBat'] . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Aucun bâtiment trouvé.</p>";
        }
        echo "<br><br>";
        ?>

        <h2>Salles gérées</h2>
        <?php
        // Requête pour obtenir les salles gérées
        $query_rooms = "
        SELECT NomSalle, NomBat
        FROM salle s
        INNER JOIN batiment b ON s.ID_Bat = b.ID_Bat
        ";

        $result_rooms = mysqli_query($id_bd, $query_rooms);

        if ($result_rooms && mysqli_num_rows($result_rooms) > 0) {
            echo "<table>";
            echo "<tr><th>Salle</th><th>Bâtiment</th></tr>";
            while ($room = mysqli_fetch_assoc($result_rooms)) {
                echo "<tr><td>" . $room['NomSalle'] . "</td><td>" . $room['NomBat'] . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Aucune salle trouvée.</p>";
        }
        echo "<br><br>";
        // Fermer la connexion à la base de données
        mysqli_close($id_bd);
        ?>

        <h2>Mentions Légales</h2>
        <p>
            Les mentions légales sont accessibles depuis ce lien : <a href="./mentions-legales.html">Mentions
                Légales</a><br>
            <br><br>
        </p>
    </main>


    <!--Footer-->
    <footer>
        Site réalisé dans le cadre de la SAE23<br>
        <a href="./mentions-legales.html">Mentions Légales</a><br>
    </footer>

</body>

</html>
