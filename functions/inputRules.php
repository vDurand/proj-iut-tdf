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

// http://godefroy.me/php-enlever-tous-les-accents-d-une-chaine-a192614
function removeAccents($txt){
    $txt = str_replace('œ', 'oe', $txt);
    $txt = str_replace('Œ', 'Oe', $txt);
    $txt = str_replace('æ', 'ae', $txt);
    $txt = str_replace('Æ', 'Ae', $txt);
    mb_regex_encoding('UTF-8');
    $txt = mb_ereg_replace('[ÀÁÂÃÄÅĀĂǍẠẢẤẦẨẪẬẮẰẲẴẶǺĄ]', 'A', $txt);
    $txt = mb_ereg_replace('[ãäåāăǎạảấầẩẫậắằẳẵặǻą]', 'a', $txt);
    $txt = mb_ereg_replace('[ÇĆĈĊČ]', 'C', $txt);
    $txt = mb_ereg_replace('[ćĉċč]', 'c', $txt);
    $txt = mb_ereg_replace('[ÐĎĐ]', 'D', $txt);
    $txt = mb_ereg_replace('[ďđ]', 'd', $txt);
    $txt = mb_ereg_replace('[ÈÉÊËĒĔĖĘĚẸẺẼẾỀỂỄỆ]', 'E', $txt);
    $txt = mb_ereg_replace('[ēĕėęěẹẻẽếềểễệ]', 'e', $txt);
    $txt = mb_ereg_replace('[ĜĞĠĢ]', 'G', $txt);
    $txt = mb_ereg_replace('[ĝğġģ]', 'g', $txt);
    $txt = mb_ereg_replace('[ĤĦ]', 'H', $txt);
    $txt = mb_ereg_replace('[ĥħ]', 'h', $txt);
    $txt = mb_ereg_replace('[ÌÍÎÏĨĪĬĮİǏỈỊ]', 'I', $txt);
    $txt = mb_ereg_replace('[ìíîïĩīĭįıǐỉị]', 'i', $txt);
    $txt = str_replace('Ĵ', 'J', $txt);
    $txt = str_replace('ĵ', 'j', $txt);
    $txt = str_replace('Ķ', 'K', $txt);
    $txt = str_replace('ķ', 'k', $txt);
    $txt = mb_ereg_replace('[ĹĻĽĿŁ]', 'L', $txt);
    $txt = mb_ereg_replace('[ĺļľŀł]', 'l', $txt);
    $txt = mb_ereg_replace('[ÑŃŅŇ]', 'N', $txt);
    $txt = mb_ereg_replace('[ñńņňŉ]', 'n', $txt);
    $txt = mb_ereg_replace('[ÒÓÔÕÖØŌŎŐƠǑǾỌỎỐỒỔỖỘỚỜỞỠỢ]', 'O', $txt);
    $txt = mb_ereg_replace('[òóõöøōŏőơǒǿọỏốồổỗộớờởỡợð]', 'o', $txt);
    $txt = mb_ereg_replace('[ŔŖŘ]', 'R', $txt);
    $txt = mb_ereg_replace('[ŕŗř]', 'r', $txt);
    $txt = mb_ereg_replace('[ŚŜŞŠ]', 'S', $txt);
    $txt = mb_ereg_replace('[śŝşš]', 's', $txt);
    $txt = mb_ereg_replace('[ŢŤŦ]', 'T', $txt);
    $txt = mb_ereg_replace('[ţťŧ]', 't', $txt);
    $txt = mb_ereg_replace('[ÙÚÛÜŨŪŬŮŰŲƯǓǕǗǙǛỤỦỨỪỬỮỰ]', 'U', $txt);
    $txt = mb_ereg_replace('[üũūŭůűųưǔǖǘǚǜụủứừửữự]', 'u', $txt);
    $txt = mb_ereg_replace('[ŴẀẂẄ]', 'W', $txt);
    $txt = mb_ereg_replace('[ŵẁẃẅ]', 'w', $txt);
    $txt = mb_ereg_replace('[ÝŶŸỲỸỶỴ]', 'Y', $txt);
    $txt = mb_ereg_replace('[ýÿŷỹỵỷỳ]', 'y', $txt);
    $txt = mb_ereg_replace('[ŹŻŽ]', 'Z', $txt);
    $txt = mb_ereg_replace('[źżž]', 'z', $txt);
    return $txt;
}

// Retire les caracteres spéciaux
function removeWeirdChar($txt){
    mb_regex_encoding('UTF-8');
    $txt = mb_ereg_replace('[€&$%£#@§!.,:]', '', $txt);
    return $txt;
}

// Retire les nombres
function removeNumber($txt){
    mb_regex_encoding('UTF-8');
    $txt = mb_ereg_replace('[0-9]', '', $txt);
    return $txt;
}

// Retire les accents des premieres lettre de chaque mot
function firstNoAccent($a)
{
    $b = explode (" ", $a);
    $d=" ";
    $i=0;
    foreach($b as $key => $val){
        $d = $d.strtoupper(noAccents(mb_substr($val, 0, 1, 'UTF-8'))).mb_substr($val, 1, mb_strlen($val), 'UTF-8');
        $d = trim($d, " '-")." ";
    }
    $b = explode ("-", trim($d));
    $d=" ";
    $i=0;
    foreach($b as $key => $val){
        $d = $d.strtoupper(noAccents(mb_substr($val, 0, 1, 'UTF-8'))).mb_substr($val, 1, mb_strlen($val), 'UTF-8');
        $d = trim($d, "- '")."-";
    }
    $b = explode ("'", trim($d));
    $d=" ";
    $i=0;
    foreach($b as $key => $val){
        $d = $d.strtoupper(noAccents(mb_substr($val, 0, 1, 'UTF-8'))).mb_substr($val, 1, mb_strlen($val), 'UTF-8');
        $d = trim($d, "'- ")."'";
    }
    return trim($d, "'- ");
}

// http://php.net/manual/fr/function.str-shuffle.php
function unicode_shuffle($string, $chars, $format = 'UTF-8')
{
    for($i=0; $i<$chars; $i++)
        $rands[$i] = rand(0, mb_strlen($string, $format));

    $s = NULL;

    foreach($rands as $r)
        $s.= mb_substr($string, $r, 1, $format);

    return $s;
}
// http://stackoverflow.com/questions/4356289/php-random-string-generator
function generateRandomString($length = 10) {
    /*$characters = '\'- abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;*/
    return mb_substr(unicode_shuffle("'- abcdèefgh ijklmnéopqrs tuvwxyzABéCDèEFGHIJ KLMNOPQRèSTUV WXYZéèàù", 20), 0, $length, 'UTF-8');
}

// formatage du nom
function formatNom($nom)
{
    return mb_substr(strtoupper(noAccents(trim(firstNoAccent(removeAccents(removeWeirdChar(removeNumber($nom)))), " -"))), 0, 20, 'UTF-8');
}

// formatage du prenom
function formatPrenom($prenom)
{
    return mb_substr(trim(firstNoAccent(removeAccents(mb_convert_case(removeWeirdChar(removeNumber($prenom)), MB_CASE_TITLE, "UTF-8"))), " -"), 0, 20, 'UTF-8');
}

// formatage d'epreuve
function formatEpreuve($nom)
{
    return mb_substr(strtoupper(noAccents(trim(firstNoAccent(removeAccents(removeWeirdChar($nom))), " -"))), 0, 20, 'UTF-8');
}
/*$tab = array("Ébé-ébé","ébé-ébé","ébé-Ébé","éÉé-Ébé","'éÉ'é-É'bé'","'éæé-É'bé'", "'éæé-É'Ŭé'", "'é !é-É'Ŭé'", "éé''éé--uù  gg", "DE LA TR€UC", "DE LA TRUC", "ééééééééééééééééééééééééééééééééééééééééééééééé");
foreach($tab as $tab){
    echo $tab."=".formatPrenom($tab)."<br>";
    echo $tab."=".formatNom($tab)."<br><br>";
}*/
//$tt = " -- - qios'sd uud- dsd-  - -";
//echo formatPrenom($tt)."<br>";
//echo formatNom($tt);
//$tt = " -- - q666ios'sd uud- dsd-  - -";
//echo formatPrenom($tt)."<br>";
//echo formatNom($tt);
?>