<?php
    require 'header.php';
if ($_SESSION['loggued_on_user']){
?>

<div id="gallery" class="text-center mtb5">
    <h2>Gallery of all users</h2>
    <form method="get">
        <select name="sort" onchange="this.form.submit();">
            <option value="date">Sort by date (default)</option>
            <option value="likes">Sort by likes</option>
            <option value="comments">Sort by comments</option>
        </select>
    </form>
    <div id="gallery_images">
    <?php

        $total = select("SELECT COUNT(*) AS total FROM pictures")[0]['total'];
        $messagesParPage = 20;
        $nombreDePages=ceil($total/$messagesParPage);
        if(isset($_GET['page'])) // Si la variable $_GET['page'] existe...
        {
            $pageActuelle=intval($_GET['page']);

            if($pageActuelle>$nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
            {
                $pageActuelle=$nombreDePages;
            }
        }
        else // Sinon
        {
            $pageActuelle=1; // La page actuelle est la n°1
        }
        $premiereEntree=($pageActuelle-1)*$messagesParPage;
//        $sql = "SELECT * FROM pictures ORDER BY pic_id DESC LIMIT $premiereEntree, $messagesParPage";
        console($sql);
//        $images = select($sql);
        if ($_GET['sort'] == 'dates' || empty($_GET['sort'])) {
            $images = select("select * from pictures order by pic_id desc LIMIT $premiereEntree, $messagesParPage");
        }
        elseif ($_GET['sort'] == 'comments'){
            $images = select("SELECT pictures.*, COUNT(comments.pic_id) as total_comments FROM pictures LEFT JOIN comments ON comments.pic_id = pictures.pic_id GROUP BY pictures.pic_id ORDER BY COUNT(comments.pic_id) DESC LIMIT $premiereEntree, $messagesParPage");
        }
        elseif ($_GET['sort'] == 'likes'){
            $images = select("SELECT pictures.*, COUNT(likes.pic_id) as total_comments FROM pictures LEFT JOIN likes ON likes.pic_id = pictures.pic_id GROUP BY pictures.pic_id ORDER BY COUNT(likes.pic_id) DESC LIMIT $premiereEntree, $messagesParPage");
        }

        foreach ($images as $image){
            echo "<a href='image.php?id=".$image['pic_id']."'><img class='img' src='" . $image['pic_path'] . "' alt='" . $image['pic_id'] . "'></a>";
        }
    echo '<p align="center">Page : ';
    for($i=1; $i<=$nombreDePages; $i++) //On fait notre boucle
    {
        //On va faire notre condition
        if($i==$pageActuelle) //Si il s'agit de la page actuelle...
        {
            echo ' [ '.$i.' ] ';
        }
        else //Sinon...
        {
            $str = $_GET['sort'] ? " <a href='gallery.php?page=$i&sort=".$_GET['sort']."'>$i</a> " : ' <a href="gallery.php?page='.$i.'">'.$i.'</a> ';
            echo $str;
        }
    }
    echo '</p>';
    ?>
    </div>
</div>

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
