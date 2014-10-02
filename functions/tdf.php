<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 27/09/14
 * Time: 14:29
 */

function getNCoureurMax($conn)
{
    $req = 'select max(n_coureur) as max from tdf_coureur';
    $cur = ExecuterRequete($conn, $req);
    $nbLigne = LireDonnees1($cur, $tab);
    return $tab[0]['MAX'];
}

function hasParticipation($conn, $ncoureur)
{
    $req = "select N_DOSSARD from TDF_PARTICIPATION where N_COUREUR = $ncoureur";
    $cur = ExecuterRequete($conn, $req);
    $nbLigne = LireDonnees1($cur, $tab);
    if(empty($tab))
        return false;
    else
        return true;
}

function existingCoureur($conn, $coureur)
{
    $nom = $coureur['NOM'];
    $prenom = $coureur['PRENOM'];
    $pays = $coureur['PAYS'];
    if($coureur['A_NAI'] == null)
        $anneeN = " is null";
    else
        $anneeN = "='".$coureur['A_NAI']."'";
    if($coureur['A_TDF'] == null)
        $anneeT = " is null";
    else
        $anneeT = "='".$coureur['A_TDF']."'";
    $req = "select N_COUREUR from TDF_COUREUR where NOM like :nom and PRENOM like :prenom and CODE_TDF like :pays and ANNEE_NAISSANCE".$anneeN." and ANNEE_TDF".$anneeT;
    $cur = oci_parse($conn, $req);
    oci_bind_by_name($cur, ":nom", $nom);
    oci_bind_by_name($cur, ":prenom", $prenom);
    oci_bind_by_name($cur, ":pays", $pays);
    oci_execute($cur, OCI_DEFAULT);
    $nbLigne = LireDonnees1($cur, $tab);
    if(empty($tab))
        return false;
    else
        return true;
}

function addCoureur($conn, $coureur)
{
    $n_coureur = $coureur['N_C'];

    $dateNow = date('d/m/y', time());

    $req = "insert into tdf_coureur values($n_coureur, :nom, :prenom, null, :pays, null, :etu, to_date('$dateNow'))";
    $cur = oci_parse($conn, $req);
    oci_bind_by_name($cur, ":nom", $coureur['NOM']);
    oci_bind_by_name($cur, ":prenom", $coureur['PRENOM']);
    oci_bind_by_name($cur, ":pays", $coureur['PAYS']);
    oci_bind_by_name($cur, ":etu", formatNom($_SESSION['user']));
    oci_execute($cur, OCI_DEFAULT);

    if($coureur['A_NAI'] != null && $cur){
        $annee_n = $coureur['A_NAI'];
        $req = "UPDATE tdf_coureur SET ANNEE_NAISSANCE = $annee_n WHERE N_COUREUR = $n_coureur";
        $cur = ExecuterRequete($conn, $req);
    }
    if($coureur['A_TDF'] != null && $cur){
        $annee_tdf = $coureur['A_TDF'];
        $req = "UPDATE tdf_coureur SET ANNEE_TDF = $annee_tdf WHERE N_COUREUR = $n_coureur";
        $cur = ExecuterRequete($conn, $req);
    }
    $committed = oci_commit($conn);
    return $cur;
}

function addAnnee($conn, $annee, $j_repos)
{
    $dateNow = date('d/m/y', time());
    $req = "select * from TDF_ANNEE where ANNEE = :annee";
    $cur = oci_parse($conn, $req);
    oci_bind_by_name($cur, ":annee", $annee);
    oci_execute($cur, OCI_DEFAULT);
    $nbLigne = LireDonnees1($cur, $tab);
    if(empty($tab)) {
        $req = "insert into tdf_annee values(:annee, :repos, :etu, to_date('$dateNow'))";
        $cur = oci_parse($conn, $req);
        oci_bind_by_name($cur, ":annee", $annee);
        oci_bind_by_name($cur, ":repos", $j_repos);
        oci_bind_by_name($cur, ":etu", formatNom($_SESSION['user']));
        oci_execute($cur, OCI_DEFAULT);
    }
    else {
        $req = "UPDATE tdf_annee SET JOUR_REPOS = :repos WHERE ANNEE = :annee";
        $cur = oci_parse($conn, $req);
        oci_bind_by_name($cur, ":annee", $annee);
        oci_bind_by_name($cur, ":repos", $j_repos);
        oci_execute($cur, OCI_DEFAULT);
    }
    $committed = oci_commit($conn);
    return $cur;
}