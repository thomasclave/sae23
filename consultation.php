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
            <li><a href="./login_gest.php">Gestion</a></li>
            <li><a href="./login_admin.php">Administration</a></li>
        </ul>
    </nav>
     
    <!--Title-->
    <header>
        <h2>Consultation des données</h2>
    </header>

    <main>
        <?php
        include 'mysql.php'; // Connexion à la base de données

        // Requête pour obtenir les salles
        $query_rooms = "
            SELECT DISTINCT NomSalle
            FROM salle
        ";

        $result_rooms = mysqli_query($id_bd, $query_rooms);

        if ($result_rooms && mysqli_num_rows($result_rooms) > 0) {
            while ($room = mysqli_fetch_assoc($result_rooms)) {
                $room_name = $room['NomSalle'];
                
                echo "<br><br>";
                echo "<h3>Salle: " . $room_name . "</h3>";

                // Requête pour obtenir les capteurs de cette salle avec leur dernière mesure
                $query_sensors = "
                    SELECT c.NomCapt, c.TypeCapt, m.Date, m.Horaire, CONCAT(m.Valeur, ' ', c.Unite) AS Valeur_Unite
                    FROM mesure m
                    INNER JOIN capteur c ON m.NomCapt = c.NomCapt
                    WHERE c.NomSalle = '$room_name'
                        AND (m.Date, m.Horaire) IN (
                            SELECT MAX(Date), MAX(Horaire)
                            FROM mesure
                            WHERE NomCapt = c.NomCapt
                        )
                ";

                $result_sensors = mysqli_query($id_bd, $query_sensors);

                if ($result_sensors && mysqli_num_rows($result_sensors) > 0) {
                    echo "<table>";
                    echo "<tr><th>Nom du Capteur</th><th>Type</th><th>Date</th><th>Heure</th><th>Valeur</th></tr>";
                    while ($sensor = mysqli_fetch_assoc($result_sensors)) {
                        echo "<tr>";
                        echo "<td>" . $sensor['NomCapt'] . "</td>";
                        echo "<td>" . $sensor['TypeCapt'] . "</td>";
                        echo "<td>" . $sensor['Date'] . "</td>";
                        echo "<td>" . $sensor['Horaire'] . "</td>";
                        echo "<td>" . $sensor['Valeur_Unite'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>Aucun capteur trouvé dans cette salle.</p>";
                }
            }
        } else {
            echo "<p>Aucune salle trouvée.</p>";
        }
        
        // Fermer la connexion à la base de données
        mysqli_close($id_bd);
        ?>
    </main>

    <!--Footer-->
    <footer>
        Site réalisé dans le cadre de la SAE23<br>
        <a href="./mentions-legales.html">Mentions Légales</a><br>
    </footer>

</body>
</html>
