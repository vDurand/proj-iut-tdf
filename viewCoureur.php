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
        ?>
        <div class="ink-alert basic success" role="alert">
            <button class="ink-dismiss">&times;</button>
            <p><b>Succès:</b> Le coureur a été supprimé</p>
        </div>
        <?php
    }
}
if((basename($_SERVER['HTTP_REFERER']) == "addCoureur.php") && isset($_GET['success']) && $_GET['success'] == 1){
    ?>
    <div class="ink-alert basic success" role="alert">
        <button class="ink-dismiss">&times;</button>
        <p><b>Succès:</b> Le coureur a été ajouté</p>
    </div>
<?php
}
if(preg_match('/^editCoureur.php/' ,basename($_SERVER['HTTP_REFERER'])) && isset($_GET['success']) && $_GET['success'] == 1){
    ?>
    <div class="ink-alert basic success" role="alert">
        <button class="ink-dismiss">&times;</button>
        <p><b>Succès:</b> Le coureur a été modifié</p>
    </div>
<?php
}

echo "<h1>Coureurs</h1>";
$req = 'SELECT co.N_COUREUR, co.NOM as NOM, co.PRENOM, ANNEE_NAISSANCE, pa.NOM as PAYS, co.ANNEE_TDF, co.COMPTE_ORACLE, co.DATE_INSERT FROM tdf_coureur co join tdf_pays pa on co.code_tdf=pa.code_tdf order by n_coureur desc';
$cur = ExecuterRequete($conn, $req);
$nbLigne = LireDonnees1($cur, $tab);
?>
<table class="ink-table alternating hover">
    <tr>
        <th>NUMERO</th>
        <th>NOM</th>
        <th>PRENOM</th>
        <th>NAISSANCE</th>
        <th>PAYS</th>
        <th>ANNEE TDF</th>
        <th>COMPTE ORACLE</th>
        <th>DATE INSERT</th>
        <th> </th>
    </tr>
<?php
foreach($tab as $key => $val) {
?>
    <tr>
        <td><?php echo $val['N_COUREUR']; ?></td>
        <td><?php echo $val['NOM']; ?></td>
        <td><?php echo $val['PRENOM']; ?></td>
        <td><?php echo $val['ANNEE_NAISSANCE']; ?></td>
        <td><?php echo $val['PAYS']; ?></td>
        <td><?php echo $val['ANNEE_TDF']; ?></td>
        <td><?php echo $val['COMPTE_ORACLE']; ?></td>
        <td><?php echo $val['DATE_INSERT']; ?></td>
        <td>
            <div class="button-group">
                <form action="editCoureur.php" method="get" id="edit"></form>
                <form id="supr" onsubmit="return confirm('Etes vous sûr de vouloir supprimer ce coureur?');" action="viewCoureur.php" method="post">
                    <input name="NumC" type="hidden" value="<?php echo $val['N_COUREUR']; ?>">
                </form>
                <button form="edit" class="ink-button green" name="NumC" type="submit" value="<?php echo $val['N_COUREUR']; ?>"><span class="fa fa-pencil"></span></button>
    <?php if(!hasParticipation($conn, $val['N_COUREUR'])){?>
                <button form="supr" name="delete" type="submit" value="X" class="ink-button red"><span class="fa fa-trash-o"></span></button>
    <?php } else { ?>
                <button form="supr" class="ink-button red" disabled=""><span class="fa fa-trash-o"></span></button>
    <?php } ?>

            </div>
        </td>
    </tr>
<?php
}
?>
</table>
<?php
include('footer.php');