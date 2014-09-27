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
    $req = "select N_COUREUR from TDF_COUREUR where NOM like '$nom' and PRENOM like '$prenom' and CODE_TDF like '$pays' and ANNEE_NAISSANCE".$anneeN." and ANNEE_TDF".$anneeT;
    $cur = ExecuterRequete($conn, $req);
    $nbLigne = LireDonnees1($cur, $tab);
    if(empty($tab))
        return false;
    else
        return true;
}