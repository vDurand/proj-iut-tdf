<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 22/09/14
 * Time: 10:09
 */
$title = "Ajout Coureur";
include ('header.php');

$temp1 = generateRandomString();
$temp2 = generateRandomString();

//$pattern = "[AZERTYUIOPQSDFGHJKLMWXCVBNazertyuiopqsdfghjklmwxcvbnéèçàùôûî' -]{2,20}";
$pattern = "*{2,20}";

$nom = formatNom(postGetter("nom"));
$prenom = formatPrenom(postGetter("prenom"));
$pays = postGetter("pays");
$annee_n = postGetter("annee_n");
$annee_tdf = postGetter("annee_tdf");

if($nom != null && $prenom != null && $pays != null){

    $n_coureur = getNCoureurMax($conn)+1;
    $coureur = array('NOM' => $nom, 'PRENOM' => $prenom, 'PAYS' => $pays, 'A_NAI' => $annee_n, 'A_TDF' => $annee_tdf, 'N_C' => $n_coureur);
    if(!existingCoureur($conn, $coureur)){
        $cur = addCoureur($conn, $coureur);
        if($cur){
            header("Location: viewCoureur.php?success=1");
        }
    }
    else{
?>
        <div class="ink-alert basic error" role="alert">
            <button class="ink-dismiss">&times;</button>
            <p><b>Erreur:</b> Le coureur est déjà présent dans la base</p>
        </div>
<?php
        include("coureurForm.php");
    }
}
else{
    include("coureurForm.php");
}
include ('footer.php');
?>