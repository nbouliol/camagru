<?php
    require 'header.php';
if ($_SESSION['loggued_on_user']){
    if (!$_SESSION['loggued_on_user']){
        echo "<h2 class='error text-center'>You need to be logged to access this page ! :(</h2>
        <br><p class='text-center' ><a href='register.php'>Go to register page ?</a></p><br>
        <p class='text-center' >or</p><br>
        <p class='text-center mb5' ><a href='login.php'>Go to login page ?</a></p>";

        require 'footer.php';
        exit ();
    }

    if (!$_GET['id']){
        $folder = substr_replace ($_SERVER['REQUEST_URI'], '', strrpos($_SERVER['REQUEST_URI'],'/'));
        $goto = "http://".$_SERVER['HTTP_HOST'].$folder.'/gallery.php';
        echo "<script> window.location = '".$goto."'</script>";
        exit ;
    }else{
        $image = select("select * from pictures where pic_id = ".$_GET['id'])[0];
        $comments = select("select * from comments WHERE pic_id = ".$_GET['id']);
        $user = $image['user_pseudo'];
        $mail = select("select * from user inner join pictures on pictures.user_pseudo = user.login WHERE pic_id = ".$_GET['id'])[0]['mail'];
    }

    if ($_POST['comment']){
        insert("insert into comments VALUES (null, '".$_SESSION['loggued_on_user']."', ".$_GET['id'].", '".$_POST['comment']."')");
        $url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        if ($user != $_SESSION['loggued_on_user'])
            mail($mail, $_SESSION['loggued_on_user']." commented your picture !", "Come and check your commented picture :  $url");
        echo "<script> window.location = window.location </script>";
    }

?>

<div id="image" class="text-center">
    <img src="<?php echo $image['pic_path']; ?>">
    <p>Picture taken by <strong class="user"><?php  echo $user; ?></strong></p>
    <h3 id="like">Like it ? <span id="heart">♥</span></h3>
    <p><?php
        echo select("SELECT pic_id, count(*) as likes FROM `likes` where pic_id = ".$_GET['id'])[0]['likes'];
    ?> ♥</p>
    <h3>Speak about it ?</h3>
    <textarea rows="4" cols="50" name="comment" form="addComment" placeholder="You wanna talk about it ?"></textarea>
    <form method="post" id="addComment">
        <input type="submit">
    </form>
    <br>
    <?php
        foreach ($comments as $comment){
            echo "<div class='comment'>";
            $str = "<p>".$comment['com']." <i class='user'>by ".$comment['user_pseudo']."</i>";
            if ($comment['user_pseudo'] == $_SESSION['loggued_on_user']) {
                $str .= "<span class='delete' id='".$comment['com_id']."'> remove it ?</span>";
            }
            $str .= "</p>";
            echo $str;
            echo "</div>";
        }
    ?>
</div>
<script>
    img = document.getElementById('image');
    del = document.getElementsByClassName('delete');
    [].forEach.call(del, function (i) {
        i.addEventListener("click", function () {
            if (confirm("You want to remove the com' ?!") == true) {
                ajaxRequest('db.php', {'com_id': i.id});
                img.removeChild(i.parentNode.parentNode);
            }
        });
    });

    like = document.getElementById('like');
//    name  = document.querySelector('#name');
    like.addEventListener("click", function (name) {
        ajaxRequest('db.php', {'like':1 ,'pic_id':window.location.search.split('=')[1] ,'user':document.querySelector("#name").innerHTML})
    });
</script>

<?php

    }
    else{
        ?>

        <div id='in'>
            <h3>You have to be logged in to access website.</h3>
            <p>Go to <a href="login.php">login page</a> or <a href="register.php">register page</a></p>
        </div>

        <?php
    }
    require 'footer.php';
?>
