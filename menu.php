<ul id=menu>
    <?php if (empty($_SESSION['loggued_on_user'])){ ?>
        <li><a href="login.php">Sign in</a></li>
        <li><a href="register.php">Sign up</a></li>
    <?php }
    else {
        echo 'Welcome <span id="name">'.$_SESSION['loggued_on_user'].'</span>'; ?>
        <!--        <a href="change.php">Change password</a>-->
        <li><a href="gallery.php">Gallery</a></li>
        <li><a href="logout.php">Logout</a></li>
    <?php	} ?>
</ul>