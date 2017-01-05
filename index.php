<?php
    require 'header.php';

    if ($_SESSION['loggued_on_user']){
?>

<div id="in" style="display:inline-block;">
    <video id="video"></video>

    
    <div class="text-center mtb5" id="choice_img">
        <h4>Choose some picture(s)</h4>
        <input type="checkbox" name="image" value="cloud"><img src="addImage/cloud.png">
        <input type="checkbox" name="image" value="sun"><img src="addImage/sun.png">
        <input type="checkbox" name="image" value="wave"><img src="addImage/wave.png">
    </div>


    <div class="text-center">
        <h4>Then hit the button to take a pic</h4>
        <button id="startbutton">Take a pic !</button>
    </div>


    <canvas style="display: none" id="canvas"></canvas>
    <!-- <img src="http://placekitten.com/g/320/261" id="photo" alt="photo"> -->
</div>

<div class="text-center" id="upDiv">
    <h4 class="delete">Or you may prefere to upload a picture ?</h4>
    <div id="upload" style="display:none">
        <form action="" method="post" enctype="multipart/form-data">
            <div id="uploadImg">
                <input type="checkbox" name="image2[]" value="cloud"><img src="addImage/cloud.png">
                <input type="checkbox" name="image2[]" value="sun"><img src="addImage/sun.png">
                <input type="checkbox" name="image2[]" value="wave"><img src="addImage/wave.png">
            </div>
            <p>Select image to upload:</p>
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload Image" name="submit">
        </form>
        <?php
//        print_r($_POST);
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
                if ($_POST['image2']) {
                    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                    $addimg = json_encode($_POST['image2']);
//                print_r($check);
                    if ($check['mime'] != 'image/png') {
                        echo "<h3 class='error'>Please select a png file.</h3>";
                    } else if ($check !== false) {
//                    echo "File is an image - " . $check["mime"] . ".";
                        $imagedata = file_get_contents($_FILES["fileToUpload"]["tmp_name"]);
                        $base64 = 'data:image/' . $imageFileType . ';base64,' . base64_encode($imagedata);
                        $jSquery = "<script>
                           ajaxRequest(\"treatment.php\", {'b64Img':'" . $base64 . "', 'pseudo':document.querySelector('#name').innerHTML, 'addImage': " . $addimg . "});
                        </script>";
                        echo $jSquery;
//                    echo "<img src='".$base64."'>";
                        $uploadOk = 1;
                    } else {
                        echo "<h3 class='error'>File is not an image.</h3>";
                        $uploadOk = 0;
                    }
                }
                else {
                    echo "<script>alert(\"You need to select at least one image !\")</script> ";
                }
            }
        ?>
    </div>
</div>
<div id="index_gallery" class="text-center mtb5">
    <h2 class="mb5">Personnal Gallery of Ugly faces !</h2>
    <h4>Click a picture to remove it !</h4>
    <?php
        $sql = "select * from pictures where user_pseudo = '".$_SESSION['loggued_on_user']."'";
        $pics = select($sql);
        if (!empty($pics)) {
            echo "<div id='images'>";
            foreach ($pics as $pic) {
                echo "<img class='img' src='" . $pic['pic_path'] . "' alt='" . $pic['pic_id'] . "'>";
            }
            echo "</div>";
        }

    ?>
</div>

<script type="text/javascript" src="javascript/webcam.js"></script>
        <script>
            img = document.getElementsByClassName('img');
            [].forEach.call(img, function (i) {
                i.addEventListener("click", function () {
                    if (confirm("Are you sure you want to delete this wonderfull pic ?!") == true) {
                        i.parentNode.removeChild(i);
                        ajaxRequest('db.php', {'pic_id': i.alt});
                    }
                });
            });
            var upload = document.querySelector("#upDiv h4");
            upload.addEventListener("click", function() {
                document.getElementById("upload").style.display = document.getElementById("upload").style.display == "initial" ? "none" : "initial";
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