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

if($annee != null && $jour != null && $nEpreuve != null && $pDep != null && $vDep != null && $pArr != null && $vArr != null && $distance != null && $cat != null){

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
    <form method="post" action="" name="ajoutEpreuve">
        <table>
            <tr>
                <th>Année</th>
                <td>
                    <select required name="annee">
                        <?php
                        $req = 'SELECT ANNEE FROM tdf_annee ORDER BY annee DESC';
                        $cur = ExecuterRequete($conn, $req);
                        $nbLigne = LireDonnees1($cur, $tab);
                        foreach($tab as $key => $val) {
                            echo "<option value='".$val['ANNEE']."'>".$val['ANNEE']."</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Jour</th>
                <td><input required type="date" name="jour"></td>
            </tr>
            <tr>
                <th>Numéro Epreuve</th>
                <td><input required type="number" name="n_epreuve" max="21" min="0" value="0"></td>
            </tr>
            <tr>
                <th>Pays de Départ</th>
                <td>
                    <select required name="P_Dep">
                        <?php
                        $req = 'SELECT code_tdf, nom FROM tdf_pays ORDER BY nom';
                        $cur = ExecuterRequete($conn, $req);
                        $nbLigne = LireDonnees1($cur, $tab);
                        foreach($tab as $key => $val) {
                            echo "<option value='".$val['CODE_TDF']."'>".$val['NOM']."</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Ville de Départ</th>
                <td><input required type="text" size="30" name="V_Dep" pattern="<?php echo $pattern; ?>"></td>
            </tr>
            <tr>
                <th>Pays d'Arrivée</th>
                <td>
                    <select required name="P_Arr">
                        <?php
                        $req = 'SELECT code_tdf, nom FROM tdf_pays ORDER BY nom';
                        $cur = ExecuterRequete($conn, $req);
                        $nbLigne = LireDonnees1($cur, $tab);
                        foreach($tab as $key => $val) {
                            echo "<option value='".$val['CODE_TDF']."'>".$val['NOM']."</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Ville d'Arrivée</th>
                <td><input required type="text" size="30" name="V_Arr" pattern="<?php echo $pattern; ?>"></td>
            </tr>
            <tr>
                <th>Distance (km)</th>
                <td><input required type="number" name="distance" max="600" min="1" step="0.2"></td>
            </tr>
            <tr>
                <th>Moyenne (km/h)</th>
                <td><input type="number" name="moyenne" max="100" min="0" step="0.001"></td>
            </tr>
            <tr>
                <th>Catégorie</th>
                <td>
                    <select required name="cat">
                        <option value="PRO">Prologue</option>
                        <option value="ETA">Etape</option>
                        <option value="CME">Contre la Montre par Equipe</option>
                        <option value="CMI">Contre la Montre Individuel</option>
                    </select>
                </td>
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