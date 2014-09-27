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