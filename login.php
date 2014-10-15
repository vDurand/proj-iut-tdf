<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 27/09/14
 * Time: 12:36
 */

$title = "Login";
include ('header.php');

if(isset($_POST['logout'])){
    session_destroy();
    header("Location: login.php");
}

$id = postGetter("id");
$pw = postGetter("pw");

if ($id != null && $pw != null) {
    if ($id == "tdf" && $pw == "php") {
        $_SESSION["user"] = "tdf";
        header("Location: ./");
    }
    else if ($id == "vdurand" && $pw == "toto") {
        $_SESSION["user"] = "vdurand";
        header("Location: ./");
    }
    else if ($id == "jlb" && $pw == "titi") {
        $_SESSION["user"] = "jlb";
        header("Location: ./");
    }
    else {
?>
        <div class="ink-alert basic error" role="alert">
            <button class="ink-dismiss">&times;</button>
            <p><b>Erreur:</b> Login/Password incorrect</p>
        </div>
<?php
    }
}
?>
<form action="login.php" method="post" class="ink-form">
    <div class="column-group gutters">
    <div class="control-group required all-33">
        <label for="id">Pseudo</label>
        <div class="control">
            <input id="id" required type="text" name="id">
        </div>
    </div>
    <div class="control-group required all-33">
        <label for="pw">Password</label>
        <div class="control">
            <input id="pw" required type="password" name="pw">
        </div>
    </div>
    </div>
    <div>
    <input class="ink-button green" name="submit" type="submit" value="Login">
    <input class="ink-button red" name="reset" type="reset" value="Cancel">
    </div>

</form>
<?php
include ('footer.php');
?>