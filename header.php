<?php
    session_start();
    require 'sql.php';

?>
<!DOCTYPE html>
<html>
<head>
    <title>Cama_gru</title>
    <script src="javascript/ajax.js"></script>
    <link rel="stylesheet" href="style/style.css">
</head>
<body><div id="header">
    <a href="index.php"><h2>Camagr_U</h2></a>
    <?php if (empty($_SESSION['loggued_on_user'])){ ?>
<!--        <a href="login.php">Sign in</a>-->
<!--        <a href="register.php">Sign up</a>-->
    <?php }
    else {
        echo '<!--Welcome <span id="name">'.$_SESSION['loggued_on_user'].'</span>'; ?>
<!--        <a href="change.php">Change password</a>-->
<!--        <a href="gallery.php">Gallery</a>-->
<!--        <a href="logout.php">Logout</a>-->
    <?php	} ?>
</div>

<?php
    require 'menu.php';
?>