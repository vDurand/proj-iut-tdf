<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 22/09/14
 * Time: 10:13
 */

/***************/
/* START - END */
/***************/
// Connection a la base
function OuvrirConnexion($session,$mdp,$instance1)
{
    $instance = 'oci:dbname='.$instance1;
    try
    {
        $conn = new PDO($instance,$session,$mdp);
        return $conn;
    }
    catch (PDOException $erreur)
    {
        echo $erreur->getMessage();
    }
}

// Fermeture de connexion
/*function FermerConnexion($conn)
{
  oci_close($conn);
}*/

/*********/
/* QUERY */
/*********/
// Preparation et execution de requete
function ExecuterRequete($conn,$cur)
{
    $stmt = $conn->exec($cur);
    return $stmt;
}

/***********/
/* LECTURE */
/***********/
//--
function LireDonnees1($conn,$sql)
{
    $i=0;
    foreach  ($conn->query($sql,PDO::FETCH_ASSOC) as $ligne)
        $tab[$i++] = $ligne;
    return $tab;
}
//---------------------------------------------------------------------------------------------
function LireDonnees2($conn,$sql)
{
    $i=0;
    $cur = $conn->query($sql);
    while ($ligne = $cur->fetch(PDO::FETCH_ASSOC))
        $tab[$i++] = $ligne;
    return $tab;
}
//---------------------------------------------------------------------------------------------
function LireDonnees3($conn,$sql)
{
    $cur = $conn->query($sql);
    $tab = $cur->fetchall(PDO::FETCH_ASSOC);
    return $tab;
}

/*************/
/* AFFICHAGE */
/*************/
// Affiche en tableau
function AfficherDonnee($tab)
{
    foreach($tab as $ligne)
    {
        foreach($ligne as $cle =>$valeur)
            echo $cle.":".$valeur."\t";
        echo "<br/>";
    }
}

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
            foreach ($tab as $key => $val) // lecture des enregistrements de chaque colonne
            {
                echo "<td>$val[$i]</td>\n";
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
 ?>