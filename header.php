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
            <!-- load inks CSS -->
            <link rel="stylesheet" type="text/css" href="ink-3.1.0/css/ink-flex.min.css">
            <link rel="stylesheet" type="text/css" href="ink-3.1.0/css/font-awesome.min.css">

            <!-- load inks CSS for IE8 -->
            <!--[if lt IE 9 ]>
            <link rel="stylesheet" href="ink-3.1.0/css/ink-ie.min.css" type="text/css" media="screen" title="no title" charset="utf-8">
            <![endif]-->

            <!-- test browser flexbox support and load legacy grid if unsupported -->
            <script type="text/javascript" src="ink-3.1.0/js/modernizr.js"></script>
            <script type="text/javascript">
                Modernizr.load({
                    test: Modernizr.flexbox,
                    nope : 'ink-3.1.0/css/ink-legacy.min.css'
                });
            </script>

            <!-- load inks javascript files -->
            <script type="text/javascript" src="ink-3.1.0/js/holder.js"></script>
            <script type="text/javascript" src="ink-3.1.0/js/ink-all.min.js"></script>
            <script type="text/javascript" src="ink-3.1.0/js/autoload.js"></script>
            <script src="js/vendor/modernizr-2.6.2.min.js"></script>

            <style type="text/css">
                html, body {
                    height: 100%;
                    background: #FFFFFF;
                }
                .wrap {
                    min-height: 100%;
                    height: auto !important;
                    height: 100%;
                    margin: 0 auto -80px;
                    overflow: auto;
                }
                .push, footer {
                    height: 80px;
                    margin-top: 0;
                }
                footer {
                    background: #FFEEB7;
                    border: 0;
                }
                footer * {
                    line-height: inherit;
                }
                .top-menu {
                    background: #fabb00;
                }
            </style>

        </head>
        <body>
            <div class="wrap">
                <div class="top-menu">
                    <nav class="ink-navigation ink-grid">
                        <ul class="menu horizontal yellow">
                            <li <?php echo "class=\"actived\""; ?>>
                                <a href="index.php">
                                    <img src="img/homeBlck.png" height="28px">
                                </a>
                            </li>
                            <li <?php if (basename($_SERVER["PHP_SELF"]) == "viewCoureur.php") {echo "class=\"active\"";} ?>>
                                <a href="viewCoureur.php">
                                    Liste Coureurs
                                </a>
                            </li>
                            <li <?php if (basename($_SERVER["PHP_SELF"]) == "addCoureur.php") {echo "class=\"active\"";} ?>>
                                <a href="addCoureur.php">
                                    Ajout Coureur
                                </a>
                            </li>
                            <li <?php if (basename($_SERVER["PHP_SELF"]) == "addAnnee.php") {echo "class=\"active\"";} ?>>
                                <a href="addAnnee.php">
                                    Ajout Année
                                </a>
                            </li>
                            <li <?php if (basename($_SERVER["PHP_SELF"]) == "addEpreuve.php") {echo "class=\"active\"";} ?>>
                                <a href="addEpreuve.php">
                                    Ajout Epreuve
                                </a>
                            </li>
                            <li <?php if (basename($_SERVER["PHP_SELF"]) == "viewEquipe.php") {echo "class=\"active\"";} ?>>
                                <a href="viewEquipe.php">
                                    Liste Equipes
                                </a>
                            </li>
                            <li <?php if (basename($_SERVER["PHP_SELF"]) == "addEquipe.php") {echo "class=\"active\"";} ?>>
                                <a href="addEquipe.php">
                                    Ajout Equipes
                                </a>
                            </li>
                            <?php
                            if (isset($_SESSION["user"])) {
                                ?>
                            <li style="padding-top: 2px;">
                                <form action="login.php" method="post">
                                    <input class="ink-button red" name="logout" type="submit" value="Logout">
                                </form>
                            </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </nav>
                </div>
                <div class="ink-grid vertical-space">