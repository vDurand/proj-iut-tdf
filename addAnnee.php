<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 30/09/14
 * Time: 15:35
 */
$title = "Ajout Année";
include ('header.php');

$annee = postGetter("annee");
$j_repos = postGetter("repos");

if($annee != null && $j_repos != null){

    $cur = addAnnee($conn, $annee, $j_repos);
    if($cur){
        ?>
        <h1>Année ajoute avec succes</h1>
        <table>
            <tr>
                <th>Année</th>
                <td><?php echo $annee; ?></td>
            </tr>
            <tr>
                <th>Jour de Repos</th>
                <td><?php echo $j_repos; ?></td>
            </tr>
        </table>
    <?php
    }
    else{
        echo "<h1>Erreur</h1>";
    }
}
else{
    ?>

    <h1>Ajouter une année</h1>
    <form method="post" action="" name="ajoutAnnee">
        <table>
            <tr>
                <th>Année</th>
                <td><input autofocus required type="number" name="annee" pattern="^[0-1]{4}" min="<?php echo date("Y"); ?>" value="<?php echo date("Y"); ?>"></td>
            </tr>
            <tr>
                <th>Jours de Repos</th>
                <td><input required type="number" name="repos" max="365" min="0" value="0"></td>
            </tr>
            <tr>
                <th><input name="submit" type="submit" value="Ajouter"></th>
                <td><input name="reset" type="reset" value="Vider les champs"></td>
            </tr>
        </table>
    </form>
<?php
}
include ('footer.php');
?>