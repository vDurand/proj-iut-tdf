<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 27/09/14
 * Time: 14:09
 */

function postGetter($name)
{
    if(isset($_POST[$name])&&!empty($_POST[$name]))
        return $_POST[$name];
    else
        return null;
}

function getGetter($name)
{
    if(isset($_GET[$name])&&!empty($_GET[$name]))
        return $_GET[$name];
    else
        return null;
}