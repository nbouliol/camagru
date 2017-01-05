<?php
    $login = $_GET['p1'];
    $hmail = $_GET['p2'];
    require 'header.php';

    $user = select("select * from user where login = '$login'")[0];
    if (hash('whirlpool', $user['mail']) != $hmail)
        echo "<h3 class='error text-center mb5'>Error : wrong params</h3>";
    else{
?>
        <form  class="text-center mb5" method="POST" >
            New password: <input class="text-center" type="password" name="pass" value="" placeholder="Blabla"/>
            <br />
            Again (same password): <input class="text-center" type="password" name="pass2" value="" placeholder="Blabla"/>
            <input type="submit" name="submit" value="OK" />
        </form>
<?php
    }
    if ($_POST['submit']){
        if ($_POST['pass'] != $_POST['pass2'])
            echo "<h3 class='error text-center mb5'>Passwords do not match.</h3>";
        else if (preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $_POST['pass']) == 0){
            echo "<h3 class='error text-center mb5'>Password is too simple.</h3>";
        }
        else {
            $pass = hash('whirlpool', $_POST['pass']);
            insert("update user set pass = '$pass' where login = '$login'");
?>
            <div class="mb5 text-center">
                <h3>Your password has been changed ! :)</h3>
                <a href="login.php">Go to login page.</a>
            </div>
<?php
        }
    }
    require 'footer.php';
?>