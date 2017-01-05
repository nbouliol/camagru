<?php

	function check_dir($login){

		if (is_dir("users/".$login) == false){
			mkdir("users/".$login);
		}

	}

	session_start();
	require 'sql.php';
	header('Content-Type: application/json');
	$login = $_GET['p1'];
	$hash = $_GET['p2'];



	$select = select("SELECT * FROM user WHERE login = '$login'")[0];
	if ($login == $select['login']){
		if ($select['validated'] == 1)
		{
            header('Content-Type: text/html');
            ?>
                <div class="text-center">
                    <h3 style="color:red;">Your account is allready active !</h3>
                    <a href="index.php">Go take pictures ?</a>
                </div>
			<?php
			require 'footer.php';
			exit ;
		}
		$hmail = hash('whirlpool', $select['mail']);
		if ($hmail == $hash){
			$sql = "UPDATE user SET validated = 1 WHERE login = '$login'";
			insert($sql);
			check_dir($login);
//			$_SESSION['loggued_on_user'] = $select['pseudo'];
			$folder = substr_replace ($_SERVER['REQUEST_URI'], '', strrpos($_SERVER['REQUEST_URI'],'/'));
            $home = "http://".$_SERVER['HTTP_HOST'].$folder;
            header("Location: $home");
		}
	}

?>