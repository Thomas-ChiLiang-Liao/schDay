<?php
session_start();
if ( !isset($_SESSION['name']) ) header("Location: https://$_SERVER[SERVER_NAME]".dirname($_SERVER['SCRIPT_NAME']).'/../');
include '../../config.php';

$pdo = new PDO('mysql:host=localhost:3307;dbname=daan;charset=utf8','daanAdmin','tv86EW&6jxj0v6siA');

$sql = "INSERT INTO currArr$SEMESTER (id) VALUES (:id);";
$statement = $pdo->prepare($sql);
$key = $_POST['cid'].$_POST['sid'].$_POST['tid'];
$statement->bindParam(':id', $key, PDO::PARAM_INT, 12);
$statement->execute();
if ( $statement->rowCount() == 1) header("Location: https://$_SESSION[serverRoot]/tables/listOfClass.php?classId=$_POST[cid]");
else header("Location: https://$_SESSION[serverRoot]/error.php?errorCode=2");
?>