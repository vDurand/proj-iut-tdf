<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 24/09/14
 * Time: 15:40
 */
$title = "Modification de Coureur";
include ('header.php');
//$pattern = "[AZERTYUIOPQSDFGHJKLMWXCVBNazertyuiopqsdfghjklmwxcvbnéèçàùôûî' -]{2,255}";
$pattern = "*{2,20}";

$num = getGetter('NumC');
$nom = formatNom(postGetter('nom'));
$prenom = formatPrenom(postGetter('prenom'));
$pays = postGetter('pays');
$annee_n = postGetter('annee_n');
$annee_tdf = postGetter('annee_tdf');

if($num != null && is_numeric($num) && $num <= getNCoureurMax($conn)){
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
            header("Location: viewCoureur.php?success=1");
        }
    }
    else{
        $req = "SELECT * FROM tdf_coureur WHERE N_COUREUR=$num";
        $cur = ExecuterRequete($conn, $req);
        $nbL = LireDonnees1($cur, $detail);

        $nom = $detail[0]['NOM'];
        $prenom = $detail[0]['PRENOM'];
        $pays = $detail[0]['CODE_TDF'];
        $annee_n = $detail[0]['ANNEE_NAISSANCE'];
        $annee_tdf = $detail[0]['ANNEE_TDF'];

        include("coureurForm.php");
    }
}
else{
?>
    <div class="ink-alert block error" role="alert">
        <button class="ink-dismiss"></button>
        <h4>Erreur</h4>
        <p>Numéro de coureur inconnu.</p>
    </div>
<?php
}
include ('footer.php');
?>