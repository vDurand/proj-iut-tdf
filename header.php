<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 23/09/14
 * Time: 08:44
 */
require "functions/dbOCI.php";
require "functions/inputRules.php";
require "functions/getter.php";
require "functions/tdf.php";

session_start();
date_default_timezone_set('Europe/Paris');

if (!isset($_SESSION['user']) && basename($_SERVER["PHP_SELF"]) != "login.php") {
    header("Location: login.php");
}

$conn = OuvrirConnexion('system', 'root','xe');
if(!isset($title))
    $title = "Projet PHP";
?>
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <title><?php echo $title; ?></title>
            <meta name="description" content="">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

            <link rel="stylesheet" href="css/normalize.css">
            <link rel="stylesheet" href="css/main.css">
            <script src="js/vendor/modernizr-2.6.2.min.js"></script>
        </head>
        <body>
            <a href="index.php">Home</a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="preview.php">Preview</a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="addCoureur.php">Ajouter Coureur</a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="addAnnee.php">Ajouter Année</a>&nbsp;&nbsp;&nbsp;&nbsp;
<?php
if (isset($_SESSION["user"])) {
?>
            <form style="display: inline" action="login.php" method="post">
                <input name="logout" type="submit" value="Logout">
            </form>
            <?php
}
?>