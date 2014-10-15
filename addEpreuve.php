<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 02/10/14
 * Time: 12:20
 */
$title = "Ajout Epreuve";
include ('header.php');

//$pattern = "[AZERTYUIOPQSDFGHJKLMWXCVBNazertyuiopqsdfghjklmwxcvbnéèçàùôûî' -]{2,20}";
$pattern = "[0-9a-zA-Z'- ]{2,20}";

$annee = postGetter("annee");
$jour = postGetter("jour");
$nEpreuve = postGetter("n_epreuve");
$pDep = postGetter("P_Dep");
$vDep = formatEpreuve(postGetter("V_Dep"));
$pArr = postGetter("P_Arr");
$vArr = formatEpreuve(postGetter("V_Arr"));
$distance = postGetter("distance");
$moyenne = postGetter("moyenne");
$cat = postGetter("cat");

if($nEpreuve == null){
    $nEpreuve = 0;
}

if($annee != null && $jour != null && $pDep != null && $vDep != null && $pArr != null && $vArr != null && $distance != null && $cat != null){

    $epreuve = array('ANNEE' => $annee, 'JOUR' => $jour, 'NEPREUVE' => $nEpreuve, 'PDEP' => $pDep, 'VDEP' => $vDep, 'PARR' => $pArr, 'VARR' => $vArr, 'DIST' => $distance, 'MOY' => $moyenne, 'CAT' => $cat);
    if(!existingEpreuve($conn, $epreuve)){
        $cur = addEpreuve($conn, $epreuve);
        if($cur){
            ?>
            <h1>Epreuve ajoute avec succes</h1>
            <table>
                <tr>
                    <th>Année</th>
                    <td><?php echo $annee; ?></td>
                </tr>
                <tr>
                    <th>Jour</th>
                    <td><?php echo $jour; ?></td>
                </tr>
                <tr>
                    <th>Numéro Epreuve</th>
                    <td><?php echo $nEpreuve; ?></td>
                </tr>
                <tr>
                    <th>Pays Départ</th>
                    <td><?php echo $pDep; ?></td>
                </tr>
                <tr>
                    <th>Ville Départ</th>
                    <td><?php echo $vDep; ?></td>
                </tr>
                <tr>
                    <th>Pays Arrivé</th>
                    <td><?php echo $pArr; ?></td>
                </tr>
            </table>
        <?php
        }
    }
    else{
        echo "<h1>Epreuve déjà présent dans la base</h1>";
    }
}
else{
    ?>

    <h1>Ajouter une Epreuve</h1>
    <form method="post" action="" name="ajoutEpreuve" class="ink-form">
        <div class="column-group gutters">
            <div class="control-group required all-33">
                <label for="annee">Année</label>
                <div class="control">
                    <select id="annee" required name="annee">
                        <?php
                        $req = 'SELECT ANNEE FROM tdf_annee ORDER BY annee DESC';
                        $cur = ExecuterRequete($conn, $req);
                        $nbLigne = LireDonnees1($cur, $tab);
                        foreach($tab as $key => $val) {
                            if($val['ANNEE'] == $annee)
                                echo "<option selected value='".$val['ANNEE']."'>".$val['ANNEE']."</option>";
                            else
                                echo "<option value='".$val['ANNEE']."'>".$val['ANNEE']."</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="control-group required all-33">
                <label for="jour">Jour</label>
                <div class="control">
                    <input id="jour" value="<?php echo $jour; ?>" required type="date" name="jour">
                </div>
            </div>
        </div>
        <div class="column-group gutters">
            <div class="control-group required all-66">
                <label for="nepreuve">Numéro Epreuve</label>
                <div class="control">
                    <input required id="nepreuve" type="number" name="n_epreuve" max="21" min="0" value="<?php echo $nEpreuve; ?>">
                </div>
            </div>
        </div>
        <div class="column-group gutters">
            <div class="control-group required all-33">
                <label for="paysd">Pays de Départ</label>
                <div class="control">
                    <select required id="paysd" name="P_Dep">
                        <?php
                        $req = 'SELECT code_tdf, nom FROM tdf_pays ORDER BY nom';
                        $cur = ExecuterRequete($conn, $req);
                        $nbLigne = LireDonnees1($cur, $tab);
                        foreach($tab as $key => $val) {
                            if($val['CODE_TDF'] == $pDep)
                                echo "<option selected value='".$val['CODE_TDF']."'>".$val['NOM']."</option>";
                            else
                                echo "<option value='".$val['CODE_TDF']."'>".$val['NOM']."</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="control-group required all-33">
                <label for="nepreuve">Ville de Départ</label>
                <div class="control">
                    <input required type="text" size="30" name="V_Dep" pattern="<?php echo $pattern; ?>" value="<?php echo $vDep; ?>">
                </div>
            </div>
        </div>
        <div class="column-group gutters">
            <div class="control-group required all-33">
                <label for="nepreuve">Pays d'Arrivée</label>
                <div class="control">
                    <select required name="P_Arr">
                        <?php
                        $req = 'SELECT code_tdf, nom FROM tdf_pays ORDER BY nom';
                        $cur = ExecuterRequete($conn, $req);
                        $nbLigne = LireDonnees1($cur, $tab);
                        foreach($tab as $key => $val) {
                            if($val['CODE_TDF'] == $pArr)
                                echo "<option selected value='".$val['CODE_TDF']."'>".$val['NOM']."</option>";
                            else
                                echo "<option value='".$val['CODE_TDF']."'>".$val['NOM']."</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="control-group required all-33">
                <label for="nepreuve">Ville d'Arrivée</label>
                <div class="control">
                    <input required type="text" size="30" name="V_Arr" pattern="<?php echo $pattern; ?>" value="<?php echo $vArr; ?>">
                </div>
            </div>
        </div>
        <div class="column-group gutters">
            <div class="control-group required all-33">
                <label for="nepreuve">Distance (km)</label>
                <div class="control">
                    <input required type="number" name="distance" max="600" min="1" step="0.2" value="<?php echo $distance; ?>">
                </div>
            </div>
            <div class="control-group all-33">
                <label for="nepreuve">Moyenne (km/h)</label>
                <div class="control">
                    <input type="number" name="moyenne" max="100" min="0" step="0.001" value="<?php echo $moyenne; ?>">
                </div>
            </div>
        </div>
        <div class="column-group gutters">
            <div class="control-group required all-66">
                <label for="nepreuve">Catégorie</label>
                <div class="control">
                    <select required name="cat">
                        <option <?php if($cat == "PRO") echo "selected"; ?> value="PRO">Prologue</option>
                        <option <?php if($cat == "ETA") echo "selected"; ?> value="ETA">Etape</option>
                        <option <?php if($cat == "CME") echo "selected"; ?> value="CME">Contre la Montre par Equipe</option>
                        <option <?php if($cat == "CMI") echo "selected"; ?> value="CMI">Contre la Montre Individuel</option>
                    </select>
                </div>
            </div>
        </div>
        <input class="ink-button green" name="submit" type="submit" value="Ajouter">
        <input class="ink-button" name="reset" type="reset" value="Vider les champs">
    </form>
<?php
}
include ('footer.php');
?>