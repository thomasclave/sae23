<?php
session_start();
$_SESSION["auth"] = FALSE;

if (!isset($_REQUEST["login"]) || !isset($_REQUEST["mdp"])) {
    header("Location:login_gest_error.php");
    exit();
}

$_SESSION["login"] = $_REQUEST["login"];  // Login recovery
$login = $_SESSION["login"];
$_SESSION["mdp"] = $_REQUEST["mdp"];  // Get the password
$mdp = $_SESSION["mdp"];

// check if the login and password are empty
if (empty($mdp) || empty($login)) {
    header("Location:login_gest_error.php");
    exit();
} else {
    // access to the database
    include("mysql.php");

    $requete = "SELECT * FROM batiment WHERE LoginGest = '$login' AND MdpGest = '$mdp'";
    $resultat = mysqli_query($id_bd, $requete) or die("Execution de la requete impossible : $requete");

    if (mysqli_num_rows($resultat) > 0) {
        $_SESSION["auth"] = TRUE;
        mysqli_close($id_bd);
        echo "<script type='text/javascript'>document.location.replace('choix_gestion.php');</script>";
    } else {
        $_SESSION = array(); // Reset of the session array
		session_destroy();   // Session destruction
		unset($_SESSION);    // Array destruction
        mysqli_close($id_bd);
        echo "<script type='text/javascript'>document.location.replace('login_gest_error.php');</script>";
    }
}
?>
