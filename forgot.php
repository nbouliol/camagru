<?php
    require 'header.php';
?>
<div id="forgot">
    <h2>You forgot your password ?</h2>
    <form  method="POST" >
        Login / mail: <input type="text" name="login" value="" />
        <input type="submit" name="submit" value="OK" />
    </form>
</div>

<?php
    if ($_POST['submit']) {
        $mail = $_POST['login'];
        $user = select("select * from user where mail = '$mail' or login = '$mail'")[0];
        if (!empty($user)) {
            $hmail = hash('whirlpool', $user['mail']);
            $folder = substr_replace($_SERVER['REQUEST_URI'], '', strrpos($_SERVER['REQUEST_URI'], '/'));
            $str = "http://" . $_SERVER['HTTP_HOST'] . $folder . "/newpass.php?p1=" . $user['login'] . "&p2=" . $hmail;
            $headers = 'From: webmaster@camagru.42.fr';
            $ret = mail($user['mail'], 'Camagru password reset', $str, $headers);
        } else
            echo "<h3 class='error mb5 text-center'>Incorrect mail or login !</h3>";
    }
    require 'footer.php';
?>

