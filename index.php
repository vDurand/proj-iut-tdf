<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 27/09/14
 * Time: 16:59
 */

$title = "Index TDF";
include ('header.php');

?>
<div id="home">
    <h1>Projet de PHP - 2A IUT Caen DUT Info</h1>
    <h3>Welcome <?php echo $_SESSION['user']; ?></h3>
    <li><a href="addCoureur.php">Ajout de coureur</a></li>
    <li><a href="preview.php">Liste des coureurs</a></li>
</div>
<?php
include ('footer.php');
?>