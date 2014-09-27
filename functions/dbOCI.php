<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 22/09/14
 * Time: 10:12
 */

/***************/
/* START - END */
/***************/
// Connection a la base
function OuvrirConnexion($session,$mdp,$instance)
{
    $conn = oci_connect($session, $mdp,$instance, "AL32UTF8");
    //echo "<br>identifiant : $conn<br>";
    if (!$conn)
    {
        $e = oci_error();
        print htmlentities($e['message']);
        exit;
    }
    return $conn;
}

// Fermeture de connexion
function FermerConnexion($conn)
{
    oci_close($conn);
}

/*********/
/* QUERY */
/*********/
// Preparation et execution de requete
function ExecuterRequete($conn,$req)
{
    $cur = oci_parse($conn, $req);
    //echo "<br>identifiant de curseur : $cur<br>";
    if (!$cur)
    {
        $e = oci_error($conn);
        print htmlentities($e['message']);
        exit;
    }
    $res = oci_execute($cur, OCI_DEFAULT);
    //echo "<br>résultat de la requête: $res<br>";
    if (!$res)
    {
        $e = oci_error($conn);
        echo htmlentities($e['message']);
        exit;
    }
    return $cur;
}

// Prepare une requete
function PreparerRequete($conn,$req)
{
    $cur = oci_parse($conn, $req);

    if (!$cur)
    {
        $e = oci_error($conn);
        print htmlentities($e['message']);
        exit;
    }
    return $cur;
}

// Execute une requete deja preparee
function ExecuterRequetePreparee($cur)
{
    $r = oci_execute($cur, OCI_DEFAULT);
    //echo "<br>résultat de la requête: $r<br />";
    if (!$r)
    {
        $e = oci_error($r);
        echo htmlentities($e['message']);
        exit;
    }
    return $r;
}

/***********/
/* LECTURE */
/***********/
// Lecture integrale
function LireDonnees1($cur,&$tab)
{
    $nbLignes = oci_fetch_all($cur, $tab,0,-1,OCI_FETCHSTATEMENT_BY_ROW); //OCI_FETCHSTATEMENT_BY_ROW, OCI_ASSOC, OCI_NUM
    return $nbLignes;
}

// Lecture des trois premieres colonnes
function LireDonnees2($cur,&$tab)
{
    $nbLignes = 0;
    $i=0;
    while ($row = oci_fetch_array ($cur, OCI_BOTH  ))
    {
        $tab[$nbLignes][$i]  = $row[0];
        $tab[$nbLignes][$i+1]  = $row[1];
        $tab[$nbLignes][$i+2]  = $row[2];
        $nbLignes++;
    }
    return $nbLignes;
}

/*************/
/* AFFICHAGE */
/*************/
// Affiche en tableau
function AfficherDonnee1($tab,$nbLignes)
{
    if ($nbLignes > 0)
    {
        echo "<table border=\"1\">\n";
        echo "<tr>\n";
        foreach ($tab as $key => $val)  // lecture des noms de colonnes
        {
            echo "<th>$key</th>\n";
        }
        echo "</tr>\n";
        for ($i = 0; $i < $nbLignes; $i++) // balayage de toutes les lignes
        {
            echo "<tr>\n";
            foreach ($tab as $data) // lecture des enregistrements de chaque colonne
            {
                echo "<td>$data[$i]</td>\n";
            }
            echo "</tr>\n";
        }
        echo "</table>\n";
    }
    else
    {
        echo "Pas de ligne<br />\n";
    }
    echo "$nbLignes Lignes lues<br />\n";
}

// Affiche en ligne
function AfficherDonnee2($tab)
{
    foreach($tab as $ligne)
    {
        foreach($ligne as $valeur)
            echo $valeur." ";
        echo "<br/>";
    }
}
 ?>