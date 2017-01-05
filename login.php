<?php

require 'header.php';

function auth($login, $passwd)
{
    $hashed = hash('whirlpool', $passwd);

    $users = select("SELECT * FROM user");

    foreach ($users as $user){
        if ($user['login'] == $login && $user['pass'] == $hashed && $user['validated'] == 1)
            return true;
    }
    return FALSE;
}


function check_dir($login){

    if (is_dir($login) == false){
        mkdir("users/".$login);
    }

}
$folder = substr_replace ($_SERVER['REQUEST_URI'], '', strrpos($_SERVER['REQUEST_URI'],'/'));
$home = "http://".$_SERVER['HTTP_HOST'].$folder;
if ($_POST['login'] && $_POST['passwd'])
{
    if (auth($_POST['login'], $_POST['passwd'])){
        $_SESSION['loggued_on_user'] = $_POST[login];
//        check_dir($_POST['login']);
//        echo "<script>var loc =  window.location.origin; window.location = loc + '/cama/index.php';</script>";
        echo "<script>window.location = '$home';</script>";
        exit ;
    }
    else{
        echo "<strong>Wrong login/password</strong>";
        $_SESSION['loggued_on_user'] = "";
    }
}

if (empty($_SESSION['loggued_on_user'])){
    ?>

    <div id="login">
        <h2>Connection :</h2>
        <form  method="POST" >
            Login: <input type="text" name="login" value="" />
            <br />
            Password: <input type="password" name="passwd" value="" />
            <input type="submit" name="submit" value="OK" />
        </form>
        <br/>
        Forgot your password ? <a href="forgot.php">--></a>
    </div>
<?php }
    require 'footer.php';
?>
