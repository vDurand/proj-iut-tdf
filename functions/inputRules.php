<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 23/09/14
 * Time: 09:58
 */

// Rm accents - http://www.weirdog.com/blog/php/supprimer-les-accents-des-caracteres-accentues.html
function noAccents($str, $charset='utf-8')
{
    $str = htmlentities($str, ENT_NOQUOTES, $charset);

    $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
    $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
    $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères

    return $str;
}

// Retire les accents des premieres lettre de chaque mot
function firstNoAccent($a)
{
    $b = explode (" ", $a);
    $d=" ";
    $i=0;
    foreach($b as $key => $val){
        $d = $d.noAccents(mb_substr($val, 0, 1, 'UTF-8')).mb_substr($val, 1, mb_strlen($val), 'UTF-8');
        $d = $d." ";
    }
    $b = explode ("-", trim($d));
    $d=" ";
    $i=0;
    foreach($b as $key => $val){
        $d = $d.noAccents(mb_substr($val, 0, 1, 'UTF-8')).mb_substr($val, 1, mb_strlen($val), 'UTF-8');
        $d = $d."-";
    }
    return trim($d, "- ");
}

// formatage du nom
function formatNom($nom)
{
    return strtoupper(noAccents(trim($nom, " -")));
}

// formatage du prenom
function formatPrenom($prenom)
{
    return mb_convert_case(trim(firstNoAccent($prenom), " -"), MB_CASE_TITLE, "UTF-8");
}
//$tt = " -- - qios'sd uud- dsd-  - -";
//echo formatPrenom($tt)."<br>";
//echo formatNom($tt);
?>