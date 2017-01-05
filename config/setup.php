<?php


require 'database.php';

$dbname = "Camagru";

try {
	$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "CREATE DATABASE $dbname";
	$conn->exec($sql);
	// sql to create table
	$sql = "CREATE TABLE $dbname.user (
		  uid int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  login char(50) NOT NULL,
		  pass text NOT NULL,
		  mail char(50) NOT NULL,
		  validated boolean DEFAULT '1' NOT NULL
		)";

	// use exec() because no results are returned
	$conn->exec($sql);
	echo "Table user created successfully".PHP_EOL;
	$sql = "CREATE TABLE $dbname.pictures (
			pic_id int not null AUTO_INCREMENT PRIMARY  KEY,
			user_pseudo char(50) NOT NULL,
			pic_path text not NULL 
			)";
	$conn->exec($sql);
	echo "Table pictures created successfully".PHP_EOL;

	$sql = "CREATE TABLE $dbname.comments (
			com_id int not null AUTO_INCREMENT PRIMARY  KEY,
			user_pseudo char(50) NOT NULL,
			pic_id int not NULL,
			com text not null
			)";
	$conn->exec($sql);
	echo "Table comments created successfully".PHP_EOL;

	$sql = "CREATE TABLE $dbname.likes (
			like_id int not null AUTO_INCREMENT PRIMARY  KEY,
			user_pseudo char(50) NOT NULL,
			pic_id int not NULL
			)";
	$conn->exec($sql);
	echo "Table likes created successfully".PHP_EOL;
}
catch(PDOException $e)
{
	echo $sql . "\n" . $e->getMessage();
}

?>
