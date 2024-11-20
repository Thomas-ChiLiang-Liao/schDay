<?php
session_start();
if ( !isset($_SESSION['name']) ) header("Location: https://$_SERVER[SERVER_NAME]".dirname($_SERVER['SCRIPT_NAME']).'/../');
else {
	
	// 資料庫連線
	$pdo = new PDO('mysql:host=localhost:3307;dbname=daan;charset=utf8','daanAdmin','tv86EW&6jxj0v6siA');
	// 查詢職員資料
	$sql = "UPDATE operator SET pw = oriPw WHERE id = :id;";
	$statement = $pdo->prepare($sql);
	$statement->bindParam(':id', $_POST['facultyId'], PDO::PARAM_INT, 4);
	$statement->execute();
	$_SESSION['facultyId'] = $_POST['facultyId'];
	header("Location: showFaculty.php");
}
?>