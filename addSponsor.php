<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 06/10/14
 * Time: 09:13
 */
$title = "Ajout Sponsor";
include ('header.php');

$nequipe = getGetter("NumE");
$annee = postGetter("annee");
//$equipe = postGetter("equipe");
$nom = formatEpreuve(postGetter("nom"));
$code = formatEpreuve(postGetter("code"));
$pays = postGetter("pays");

if($annee != null){
    $n_sponsor = getNSponsorMax($conn, $nequipe)+1;
    $sponsor = array('NEQUIPE' => $nequipe, 'NSPONSOR' => $n_sponsor,'NOM' => $nom,'NASPONSOR' => $code,'PAYS' => $pays, 'ANNEE' => $annee);
    $cur = addSponsor($conn, $sponsor);
    if($cur){
        header("Location: viewEquipe.php?success=1");
    }
    else{
        echo "<h1>Erreur</h1>";
    }
}
else{
    $req = "select cs.n_equipe, maxi, nom, vs.CODE_TDF, vs.NA_SPONSOR, n_sponsor, annee_sponsor from tdf_sponsor vs left join current_sponsor cs on cs.n_equipe=vs.n_equipe where vs.N_SPONSOR=cs.MAXI and cs.n_equipe = $nequipe";
    $cur = ExecuterRequete($conn, $req);
    $nbL = LireDonnees1($cur, $detail);

    $nom = $detail[0]['NOM'];
    $code = $detail[0]['NA_SPONSOR'];
    $pays = $detail[0]['CODE_TDF'];
    $annee = $detail[0]['ANNEE_SPONSOR'];

    ?>

    <h1>Ajouter un sponsor</h1>
    <form method="post" action="" name="ajoutSponsor" class="ink-form">
        <fieldset class="all-33">
            <legend><?php echo $nom; ?></legend>
            <div class="control-group required">
                <label for="nom">Nom</label>
                <div class="control">
                    <input required value="<?php echo $nom; ?>" type="text" id="nom" name="nom" size="20">
                </div>
            </div>
            <div class="control-group required">
                <label for="code">Code</label>
                <div class="control">
                    <input required value="<?php echo $code; ?>" type="text" id="code" name="code" size="3">
                </div>
            </div>
            <div class="control-group">
                <label for="anneen">Année</label>
                <div class="control">
                    <input value="<?php echo $annee; ?>" required type="number" name="annee" id="anneen" min="<?php echo date("Y"); ?>">
                </div>
            </div>
            <div class="control-group required">
                <label for="pays">Pays</label>
                <div class="control">
                    <select required name="pays">
                        <option value=''></option>
                        <?php
                        $req = 'SELECT code_tdf, nom FROM tdf_pays ORDER BY nom';
                        $cur = ExecuterRequete($conn, $req);
                        $nbLigne = LireDonnees1($cur, $tab);
                        foreach($tab as $key => $val) {
                            if($val['CODE_TDF'] == $pays)
                                echo "<option selected value='".$val['CODE_TDF']."'>".$val['NOM']."</option>";
                            else
                                echo "<option value='".$val['CODE_TDF']."'>".$val['NOM']."</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <input class="ink-button green" name="submit" type="submit" value="Ajouter">
            <input class="ink-button" name="reset" type="reset" value="Vider les champs">
        </fieldset>
    </form>
<?php
}
include ('footer.php');
?>