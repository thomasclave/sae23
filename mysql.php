<?php
/* connection script to the database */

  $id_bd = mysqli_connect("localhost","fest","pass23","sae23")
    or die("Connexion au serveur et/ou à la base de données impossible");

  /* Set the encoding to utf8 */
  mysqli_query($id_bd, "SET NAMES 'utf8'");

?>
