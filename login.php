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
    } else {
        echo "<br>Bad !";
    }
}
?>
<form action="login.php" method="post">
    <table>
        <tr>
            <th>Pseudo : </th>
            <td><input required type="text" name="id"></td>
        </tr>
        <tr>
            <th>Password : </th>
            <td><input required type="password" name="pw"></td>
        </tr>
        <tr>
            <th><input name="submit" type="submit" value="Login"></th>
            <td><input name="reset" type="reset" value="Cancel"></td>
        </tr>
    </table>
</form>
<?php
include ('footer.php');
?>