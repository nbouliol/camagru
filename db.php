<?php

require 'sql.php';


function removeFromDb ($id) {
    insert("DELETE FROM pictures WHERE pic_id = $id");
}

function delComment ($id){
    insert("delete from comments where com_id = $id");
}

function like ($id, $user){
    $like = select("select * from likes where pic_id = $id and user_pseudo = '$user'");
    if (empty($like))
        insert("insert into likes VALUES (null, '$user', $id)");
    else
        insert("delete from likes WHERE pic_id = $id and user_pseudo = '$user'");
}

//    print_r($_POST);

    if ($_POST['com_id'])
        delComment($_POST['com_id']);
    elseif ($_POST['like'])
        like($_POST['pic_id'], $_POST['user']);
    else
        removeFromDb($_POST['pic_id']);
?>