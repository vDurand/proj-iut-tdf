<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 24/09/14
 * Time: 15:40
 */
$title = "Modification de Coureur";
include ('header.php');
$pattern = "[AZERTYUIOPQSDFGHJKLMWXCVBNazertyuiopqsdfghjklmwxcvbnéèçàùôûî' -]{2,255}";

$num = getGetter('NumC');
$nom = formatNom(postGetter('nom'));
$prenom = formatPrenom(postGetter('prenom'));
$pays = postGetter('pays');
$annee_n = postGetter('annee_n');
$annee_tdf = postGetter('annee_tdf');

if($num != null && is_numeric($num)){
    if($nom != null && $prenom != null && $pays != null){

        echo "<h1>Coureur Modifié</h1>";

        $req = "UPDATE tdf_coureur SET NOM = :nom, PRENOM = :prenom, CODE_TDF = '$pays' WHERE N_COUREUR = $num";
        $cur = oci_parse($conn, $req);
        oci_bind_by_name($cur, ":nom", $nom);
        oci_bind_by_name($cur, ":prenom", $prenom);
        oci_execute($cur, OCI_DEFAULT);

        if($annee_n != null && $cur){
            $req = "UPDATE tdf_coureur SET ANNEE_NAISSANCE = $annee_n WHERE N_COUREUR = $num";
            $cur = ExecuterRequete($conn, $req);
        }
        if($annee_tdf != null && $cur){
            $req = "UPDATE tdf_coureur SET ANNEE_TDF = $annee_tdf WHERE N_COUREUR = $num";
            $cur = ExecuterRequete($conn, $req);
        }
        $committed = oci_commit($conn);
        if($cur){
            ?>
            <table>
                <tr>
                    <th>Numero du Coureur</th>
                    <td><?php echo $num; ?></td>
                </tr>
                <tr>
                    <th>Nom du Coureur</th>
                    <td><?php echo $nom; ?></td>
                </tr>
                <tr>
                    <th>Prenom du Coureur</th>
                    <td><?php echo $prenom; ?></td>
                </tr>
                <tr>
                    <th>Annee naissance</th>
                    <td><?php echo $annee_n; ?></td>
                </tr>
                <tr>
                    <th>Pays</th>
                    <td><?php echo $pays; ?></td>
                </tr>
                <tr>
                    <th>Annee tour de France</th>
                    <td><?php echo $annee_tdf; ?></td>
                </tr>
            </table>
        <?php
        }
    }
    else{
        $req = "SELECT * FROM tdf_coureur WHERE N_COUREUR=$num";
        $cur = ExecuterRequete($conn, $req);
        $nbL = LireDonnees1($cur, $detail);
//echo "<pre>";
//print_r($val);
//echo "</pre>";
        ?>
        <h1>Modifier un coureur</h1>
        <form method="post" action="" name="ajoutCoureur">
            <table>
                <tr>
                    <th>Nom du Coureur</th>
                    <td><input required type="text" name="nom" pattern="<?php echo $pattern; ?>" value="<?php echo $detail[0]['NOM']; ?>"></td>
                </tr>
                <tr>
                    <th>Prenom du Coureur</th>
                    <td><input required type="text" name="prenom" pattern="<?php echo $pattern; ?>" value="<?php echo $detail[0]['PRENOM']; ?>"></td>
                </tr>
                <tr>
                    <th>Annee naissance</th>
                    <td><input type="number" name="annee_n" max="<?php echo date("Y"); ?>" min="1900" value="<?php if(!empty($detail[0]['ANNEE_NAISSANCE'])) echo $detail[0]['ANNEE_NAISSANCE']; ?>"></td>
                </tr>
                <tr>
                    <th>Pays</th>
                    <td>
                        <select required name="pays">
                            <option value=''></option>
                            <?php
                            $req = 'SELECT code_tdf, nom FROM tdf_pays ORDER BY nom';
                            $cur = ExecuterRequete($conn, $req);
                            $nbLigne = LireDonnees1($cur, $tab);
                            foreach($tab as $key => $val) {
                                if($val['CODE_TDF']==$detail[0]['CODE_TDF'])
                                    echo "<option selected value='".$val['CODE_TDF']."'>".$val['NOM']."</option>";
                                else
                                    echo "<option value='".$val['CODE_TDF']."'>".$val['NOM']."</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Annee tour de France</th>
                    <td><input type="number" name="annee_tdf" pattern="^[0-1]{4}" min="<?php echo date("Y"); ?>" value="<?php if(!empty($detail[0]['ANNEE_TDF'])) echo $detail[0]['ANNEE_TDF']; ?>"></td>
                </tr>
                <tr>
                    <th><input name="submit" type="submit" value="Modifier"></th>
                    <td><input name="reset" type="reset" value="Annuler"></td>
                </tr>
            </table>
        </form>
    <?php
    }
}
else
    echo "Numéro de coureur inconnu";
include ('footer.php');
?>