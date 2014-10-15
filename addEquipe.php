<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 08/10/14
 * Time: 12:36
 */
$title = "Ajout Equipe";
include ('header.php');
$pattern = "[a-zA-Z]{3}";
$temp1 = generateRandomString();

$annee = postGetter("annee");
$nom = formatEpreuve(postGetter("nom"));
$code = formatEpreuve(postGetter("code"));
$pays = postGetter("pays");

if($annee != null){
    $n_equipe = getNEquipeMax($conn)+1;
    $equipe = array('ANNEE' => $annee, 'NEQUIPE' => $n_equipe);
    $n_sponsor = 1;
    $sponsor = array('NEQUIPE' => $n_equipe, 'NSPONSOR' => $n_sponsor,'NOM' => $nom,'NASPONSOR' => $code,'PAYS' => $pays, 'ANNEE' => $annee);

    $cur = addEquipe($conn, $equipe);
    if($cur){
        $cur = addSponsor($conn, $sponsor);
        if($cur){
        ?>
        <h1>Aquipe ajoute avec succes</h1>
        <table>
            <tr>
                <th>Année</th>
                <td><?php echo $annee; ?></td>
            </tr>
            <tr>
                <th>Nom</th>
                <td><?php echo $nom; ?></td>
            </tr>
            <tr>
                <th>Code</th>
                <td><?php echo $code; ?></td>
            </tr>
            <tr>
                <th>Pays</th>
                <td><?php echo $pays; ?></td>
            </tr>
        </table>
    <?php
        }
    }
    else{
        echo "<h1>Erreur</h1>";
    }
}
else{
    ?>

    <h1>Ajouter une Equipe</h1>
    <form method="post" action="" name="ajoutEquipe" class="ink-form">
        <fieldset class="all-33">
            <div class="control-group required">
                <label for="nom">Année Création</label>
                <div class="control">
                    <input autofocus required type="number" name="annee" pattern="^[0-1]{4}" min="<?php echo date("Y"); ?>" value="<?php echo date("Y"); ?>">
                </div>
            </div>
            <div class="control-group required">
                <label for="nom">Nom</label>
                <div class="control">
                    <input required type="text" name="nom" size="20">
                </div>
            </div>
            <div class="control-group required">
                <label for="nom">Code</label>
                <div class="control">
                    <input required type="text" name="code" pattern="<?php echo $pattern; ?>">
                </div>
            </div>
            <div class="control-group required">
                <label for="nom">Pays</label>
                <div class="control">
                    <select required name="pays">
                        <option value=''></option>
                        <?php
                        $req = 'SELECT code_tdf, nom FROM tdf_pays ORDER BY nom';
                        $cur = ExecuterRequete($conn, $req);
                        $nbLigne = LireDonnees1($cur, $tab);
                        foreach($tab as $key => $val) {
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