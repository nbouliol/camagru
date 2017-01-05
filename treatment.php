<?php

require 'sql.php';

$data = $_POST['b64Img'];
$login = $_POST['pseudo'];
$addImage = $_POST['addImage'];


$addImage = (json_decode($addImage, true) != null) ? json_decode($addImage, true) : explode(',', $addImage);


function saveImage($base64img, $login, $addArray){

    $arr = array(
        'sun' => array ('mb' => -20, 'mr' => 50),
        'cloud' => array ('mb' => 50, 'mr' => -100),
        'wave' => array ('mb' => -180, 'mr' => 60)
        );


    define('UPLOAD_DIR', "users/$login/");
    $base64img = str_replace('data:image/png;base64,', '', $base64img);
    $base64img = str_replace(' ', '+', $base64img);
    $data = base64_decode($base64img);
    $im = imagecreatefromstring($data);


    $NouvelleImage = imagecreatetruecolor(320 , 240);
    imagesavealpha($NouvelleImage, true);

    $trans_colour = imagecolorallocatealpha($NouvelleImage, 0, 0, 0, 127);
    imagefill($NouvelleImage, 0, 0, $trans_colour);
    imagecopyresampled($NouvelleImage , $im  , 0,0, 0,0, 320, 240, imagesx($im),imagesy($im));
    $im = $NouvelleImage;

    foreach ($addArray as $add){

        $add = trim($add);
        $stamp = imagecreatefrompng('addImage/'.$add.'.png');

        $marge_right = $arr[$add]['mr'];
        $marge_bottom = $arr[$add]['mb'];
        $sx = imagesx($stamp);
        $sy = imagesy($stamp);

        if ($add == 'wave')
            imagecopyresized($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($im), 80, imagesx($stamp), imagesy($stamp)); // Ok
        else
            imagecopyresized($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, 80, 80, imagesx($stamp), imagesy($stamp)); // Ok
    }
    $file = UPLOAD_DIR . $login . uniqid() . '.png';

    $imgCreated = imagepng($im, $file);

    if ($imgCreated === true) {
        $sql = "insert into pictures VALUES (null, '$login', '$file')";
        insert($sql);
    }
    imagedestroy($im);
}

saveImage($data, $login, $addImage);

?>