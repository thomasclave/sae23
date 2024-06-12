<?php
session_start();
$_SESSION["auth"] = FALSE;

if (!isset($_REQUEST["login"]) || !isset($_REQUEST["mdp"])) {
    header("Location:login_gest_error.php");
    exit();
}

$_SESSION["login"] = $_REQUEST["login"];  // Récupération du login
$login = $_SESSION["login"];
$_SESSION["mdp"] = $_REQUEST["mdp"];  // Récupération du mot de passe
$mdp = $_SESSION["mdp"];

// Vérifier la connexion
if (empty($mdp) || empty($login)) {
    header("Location:login_gest_error.php");
    exit();
} else {
    // Accès à la base
    include("mysql.php");

    $requete = "SELECT * FROM batiment WHERE LoginGest = '$login' AND MdpGest = '$mdp'";
    $resultat = mysqli_query($id_bd, $requete) or die("Execution de la requete impossible : $requete");

    if (mysqli_num_rows($resultat) > 0) {
        $_SESSION["auth"] = TRUE;
        mysqli_close($id_bd);
        echo "<script type='text/javascript'>document.location.replace('choix_gestion.php');</script>";
    } else {
        $_SESSION = array(); // Réinitialisation du tableau de session
        session_destroy();   // Destruction de la session
        unset($_SESSION);    // Destruction du tableau de session
        mysqli_close($id_bd);
        echo "<script type='text/javascript'>document.location.replace('login_gest_error.php');</script>";
    }
}
?>
