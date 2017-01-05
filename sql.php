<?php

function select($sql){
    require 'config/database.php';
    try
    {
        $db = new PDO($DB_DSN.";dbname=Camagru", $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (Exceptions $e)
    {
        echo $sql . "\n" . $e->getMessage();
    }

    //echo $sql.PHP_EOL;
    $sth = $db->prepare($sql);
    $sth->execute();

    $arr = $sth->fetchAll(PDO::FETCH_ASSOC);

    return $arr;
}

function insert($sql){
    require 'config/database.php';
    try
    {
        $db = new PDO($DB_DSN.";dbname=Camagru", $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (Exceptions $e)
    {
        echo $sql . "\n" . $e->getMessage();
    }

    $db->exec($sql);
}

function html_tab($array){
    echo '<table cellpadding="10">' ;
    foreach ($array as $k => $v) {
            echo '<tr><td>'.$k.'</td><td>' . $v . '</td></tr>' ;
    }
    echo '</table>' ;
}

function console($req){
    $req = addslashes($req);
    echo "<script>console.log('$req')</script>";
}

?>