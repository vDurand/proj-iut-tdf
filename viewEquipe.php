<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 08/10/14
 * Time: 10:28
 */
$title = "Liste des Equipes";
include ('header.php');

if((basename($_SERVER['HTTP_REFERER']) == "addSponsor.php") && isset($_GET['success']) && $_GET['success'] == 1){
    ?>
    <div class="ink-alert basic success" role="alert">
        <button class="ink-dismiss">&times;</button>
        <p><b>Succès:</b> Le sponsor a été ajouté</p>
    </div>
<?php
}

$req = 'select cs.n_equipe, maxi, nom, vs.CODE_TDF, vs.NA_SPONSOR, n_sponsor, annee_sponsor from tdf_sponsor vs left join current_sponsor cs on cs.n_equipe=vs.n_equipe where vs.N_SPONSOR=cs.MAXI and cs.n_equipe not in
(select n_equipe from vt_equipe where annee_disparition>0) order by n_equipe desc';
$cur = ExecuterRequete($conn, $req);
$nbLigne = LireDonnees1($cur, $tab);
?>
<table class="ink-table">
    <tr>
    <td style="vertical-align: top;">
    <h1>Equipes actives</h1>
    <table class="ink-table alternating hover">
        <tr>
            <th>NUMERO</th>
            <th>NOM</th>
            <th>CODE</th>
            <th>PAYS</th>
            <th>ANNEE</th>
            <th> </th>
        </tr>
        <?php
        foreach($tab as $key => $val) {
            ?>
            <tr>
                <td><?php echo $val['N_EQUIPE']; ?></td>
                <td><?php echo $val['NOM']; ?></td>
                <td><?php echo $val['NA_SPONSOR']; ?></td>
                <td><?php echo $val['CODE_TDF']; ?></td>
                <td><?php echo $val['ANNEE_SPONSOR']; ?></td>
                <td>
                    <form action="addSponsor.php" method="get" id="edit"></form>
                    <button form="edit" class="ink-button green" name="NumE" type="submit" value="<?php echo $val['N_EQUIPE']; ?>"><span class="fa fa-plus"></span></button>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
    </td>
<?php
    $req = 'select cs.n_equipe, maxi, nom, vs.CODE_TDF, vs.NA_SPONSOR, n_sponsor, annee_sponsor from tdf_sponsor vs left join current_sponsor cs on cs.n_equipe=vs.n_equipe where vs.N_SPONSOR=cs.MAXI and cs.n_equipe in
    (select n_equipe from vt_equipe where annee_disparition>0) order by n_equipe desc';
    $cur = ExecuterRequete($conn, $req);
    $nbLigne = LireDonnees1($cur, $tab);
    ?>
    <td>
    <h1>Equipes inactives</h1>
    <table class="ink-table alternating hover">
        <tr>
            <th>NUMERO</th>
            <th>NOM</th>
            <th>CODE</th>
            <th>PAYS</th>
            <th>ANNEE</th>
            <th> </th>
        </tr>
        <?php
        foreach($tab as $key => $val) {
            ?>
            <tr>
                <td><?php echo $val['N_EQUIPE']; ?></td>
                <td><?php echo $val['NOM']; ?></td>
                <td><?php echo $val['NA_SPONSOR']; ?></td>
                <td><?php echo $val['CODE_TDF']; ?></td>
                <td><?php echo $val['ANNEE_SPONSOR']; ?></td>
                <td>
                    <form action="addSponsor.php" method="get" id="edit"></form>
                    <button disabled form="edit" class="ink-button green" name="NumE" type="submit" value="<?php echo $val['N_EQUIPE']; ?>"><span class="fa fa-plus"></span></button>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
    </td>
    </tr>
</table>
<?php
include('footer.php');