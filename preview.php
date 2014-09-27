<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 23/09/14
 * Time: 08:36
 */
$title = "Liste des Coureurs";
include ('header.php');
if(isset($_POST['delete'])){
    $NumC = postGetter("NumC");
    if($NumC != null){
        $req = "DELETE FROM tdf_coureur WHERE N_COUREUR = $NumC";
        $cur = ExecuterRequete($conn, $req);
        $committed = oci_commit($conn);
    }
}

echo "<h1>Coureurs</h1>";
$req = 'SELECT * FROM tdf_coureur order by n_coureur desc';
$cur = ExecuterRequete($conn, $req);
$nbLigne = LireDonnees1($cur, $tab);
?>
<table style="text-align: center;">
    <tr>
        <td>N_C</td>
        <td>NOM</td>
        <td>PRENOM</td>
        <td>ANNEE_N</td>
        <td>CODE_TDF</td>
        <td>ANNEE_TDF</td>
        <td>COMPTE_ORACLE</td>
        <td>DATE_INSERT</td>
        <td> </td>
    </tr>
<?php
foreach($tab as $key => $val) {
?>
    <tr>
        <td>
            <form action="editCoureur.php" method="get">
            <input name="NumC" type="submit" value="<?php echo $val['N_COUREUR']; ?>">
            </form>
        </td>
        <td><?php echo $val['NOM']; ?></td>
        <td><?php echo $val['PRENOM']; ?></td>
        <td><?php echo $val['ANNEE_NAISSANCE']; ?></td>
        <td><?php echo $val['CODE_TDF']; ?></td>
        <td><?php echo $val['ANNEE_TDF']; ?></td>
        <td><?php echo $val['COMPTE_ORACLE']; ?></td>
        <td><?php echo $val['DATE_INSERT']; ?></td>
        <td><?php if(!hasParticipation($conn, $val['N_COUREUR'])){?>
            <form onsubmit="return confirm('Etes vous sûr de vouloir supprimer ce coureur?');" action="preview.php" method="post">
                <input name="NumC" type="hidden" value="<?php echo $val['N_COUREUR']; ?>">
                <input name="delete" type="submit" value="X">
            </form>
            <?php } ?>
        </td>
    </tr>
<?php
}
?>
</table>
<?php
include('footer.php');