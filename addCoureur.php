<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 22/09/14
 * Time: 10:09
 */
$title = "Ajout Coureur";
include ('header.php');

$pattern = "[AZERTYUIOPQSDFGHJKLMWXCVBNazertyuiopqsdfghjklmwxcvbnéèçàùôûî' -]{2,255}";

$nom = formatNom(postGetter("nom"));
$prenom = formatPrenom(postGetter("prenom"));
$pays = postGetter("pays");
$annee_n = postGetter("annee_n");
$annee_tdf = postGetter("annee_tdf");

if($nom != null && $prenom != null && $pays != null){

    $n_coureur = getNCoureurMax($conn)+1;

    date_default_timezone_set('Europe/Paris');
    $dateNow = date('d/m/y', time());

    $req = "insert into tdf_coureur values($n_coureur, :nom, :prenom, null, '$pays', null, 'ETU', to_date('$dateNow'))";
    $cur = oci_parse($conn, $req);
    oci_bind_by_name($cur, ":nom", $nom);
    oci_bind_by_name($cur, ":prenom", $prenom);
    oci_execute($cur, OCI_DEFAULT);

    if($annee_n != null && $cur){
        $req = "UPDATE tdf_coureur SET ANNEE_NAISSANCE = $annee_n WHERE N_COUREUR = $n_coureur";
        $cur = ExecuterRequete($conn, $req);
    }
    if($annee_tdf != null && $cur){
        $req = "UPDATE tdf_coureur SET ANNEE_TDF = $annee_tdf WHERE N_COUREUR = $n_coureur";
        $cur = ExecuterRequete($conn, $req);
    }
    $committed = oci_commit($conn);
    if($cur){
?>
            <h1>Coureur ajoute avec succes</h1>
            <table>
                <tr>
                    <th>Numero du Coureur</th>
                    <td><?php echo $n_coureur; ?></td>
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
?>

            <h1>Ajouter un coureur</h1>
            <form method="post" action="" name="ajoutCoureur">
                <table>
                    <tr>
                        <th>Nom du Coureur</th>
                        <td><input autofocus required type="text" name="nom" pattern="<?php echo $pattern; ?>"></td>
                    </tr>
                    <tr>
                        <th>Prenom du Coureur</th>
                        <td><input required type="text" name="prenom" pattern="<?php echo $pattern; ?>"></td>
                    </tr>
                    <tr>
                        <th>Annee naissance</th>
                        <td><input type="number" name="annee_n" max="<?php echo date("Y"); ?>" min="1900"></td>
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
                                    echo "<option value='".$val['CODE_TDF']."'>".$val['NOM']."</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Annee tour de France</th>
                        <td><input type="number" name="annee_tdf" pattern="^[0-1]{4}" min="<?php echo date("Y"); ?>"></td>
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