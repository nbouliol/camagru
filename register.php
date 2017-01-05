<?php
require 'header.php';
$passError = 0;
$mailError = 0;
$userError = 0;
if (!empty($_POST)){
    if ($_POST['pass1'] !== $_POST['pass2']){
        $passError = 1;
    }
    else if (preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $_POST['pass1']) == 0){
//        echo "<script>console.log('".$_POST['pass1']."')</script>";
        $passError = 2;
    }
    else if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){
        $mailError = 1;
    }
    else {
        $users = select("select * from user");
        foreach ($users as $user){
            if ($_POST['pseudo'] == $user['login']){
                $userError = 1;
            }else if ($_POST['mail'] == $user['mail']){
                $mailError = 2;
            }
        }
        if ($userError == 0 && $mailError == 0){
            $hpass = hash('whirlpool', $_POST['pass1']);
            $sql = "INSERT INTO user (login, pass, mail, validated)
            VALUES ('".$_POST['pseudo']."', '$hpass','".$_POST['mail']."', '0')";
            insert($sql);

            $hmail = hash('whirlpool', $_POST['mail']);
            $folder = substr_replace ($_SERVER['REQUEST_URI'], '', strrpos($_SERVER['REQUEST_URI'],'/'));
            $str = "http://".$_SERVER['HTTP_HOST'].$folder."/validation.php?p1=".$_POST['pseudo']."&p2=".$hmail;
            $headers = 'From: webmaster@camagru.42.fr';
            $ret = mail($_POST['mail'], 'Camagru email validation', $str, $headers);


        }
    }
}

?>


<div id="signup">
    <h2>Register Form !</h2>
    <?php
    if (!$_POST['pseudo'] && !$_POST['mail'] && !$_POST['pass1'] && !$_POST['pass2']){
        echo "<strong class='error'>Please complete all fields.</strong>";
    }
    ?>
    <form method="post">
        User : <input type='text' name='pseudo'> <br/>
        <?php
        if ($userError == 1){
            echo "<strong class='error'>This username is allready taken.</strong><br/>";
            echo "<a href='login.php'>Go to login page ?</a><br/>";
            $userError = 0;
        }else if($mailError == 2){
            echo "<strong class='error'>This mail is allready taken.</strong><br/>";
            echo "<a href='login.php'>Go to login page ?</a><br/>";
            $mailError = 0;
        }
        ?>
        E-Mail : <input type='text' name='mail'> <br/>
        <?php
        if ($mailError == 1){
            echo "<strong class='error'>This is not a valid e-mail address.</strong><br/>";
            $mailError = 0;
        }
        ?>
        Password : <input type="password" name="pass1"> <br/>
        Password : <input type="password" name="pass2"> <br/>
        <?php
        if ($passError == 1){
            echo "<strong class='error'>Passwords do not match.</strong><br/>";
            $passError = 0;
        }else if ($passError == 2){
            echo "<strong class='error'>Password is too simple. Need 8 characters and 1 number</strong><br/>";
            $passError = 0;
        }
        ?>
        <input type="submit" name="submit" value="Submit">
    </form>
</div>

<?php
require 'footer.php';
?>