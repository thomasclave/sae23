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

        // Requête pour obtenir les noms des capteurs
        $query_captors = "
            SELECT DISTINCT NomCapt
            FROM capteur
        ";

        $result_captors = mysqli_query($id_bd, $query_captors);

        if ($result_captors && mysqli_num_rows($result_captors) > 0) {
            while ($captor = mysqli_fetch_assoc($result_captors)) {
                $captor_name = $captor['NomCapt'];
                
                // Requête pour obtenir la dernière mesure du capteur actuel
                $query_last_measure = "
                    SELECT c.NomCapt, c.TypeCapt, m.Date, m.Horaire, m.Valeur, c.Unite
                    FROM mesure m
                    INNER JOIN capteur c ON m.NomCapt = c.NomCapt
                    WHERE m.NomCapt = '$captor_name'
                    ORDER BY m.Date DESC, m.Horaire DESC
                    LIMIT 1
                ";

                $result_last_measure = mysqli_query($id_bd, $query_last_measure);

                if ($result_last_measure && mysqli_num_rows($result_last_measure) > 0) {
                    $row = mysqli_fetch_assoc($result_last_measure);
                    echo "<h3>Dernière mesure du capteur: " . $captor_name . "</h3>";
                    echo "<table>";
                    echo "<tr><th>Nom du Capteur</th><th>Type</th><th>Date</th><th>Heure</th><th>Valeur</th><th>Unité</th></tr>";
                    echo "<tr>";
                    echo "<td>" . $row['NomCapt'] . "</td>";
                    echo "<td>" . $row['TypeCapt'] . "</td>";
                    echo "<td>" . $row['Date'] . "</td>";
                    echo "<td>" . $row['Horaire'] . "</td>";
                    echo "<td>" . $row['Valeur'] . "</td>";
                    echo "<td>" . $row['Unite'] . "</td>";
                    echo "</tr>";
                    echo "</table>";
                } else {
                    echo "<h3>Capteur: " . $captor_name . "</h3>";
                    echo "Aucune donnée disponible.";
                }
            }
        } else {
            echo "Aucun capteur trouvé.";
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
