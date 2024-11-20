<?php
session_start();
if ( !isset($_SESSION['name']) ) header("Location: https://$_SERVER[SERVER_NAME]".dirname($_SERVER['SCRIPT_NAME']).'/../');
include '../../config.php';

//print_r ($_POST);


$pdo = new PDO('mysql:host=localhost:3307;dbname=daan;charset=utf8','daanAdmin','tv86EW&6jxj0v6siA');

$sql = "DELETE FROM currArr$SEMESTER WHERE id = :id;";
$statement = $pdo->prepare($sql);
$key = $_POST['deleteCurrArrId'];
$statement->bindParam(':id', $key, PDO::PARAM_INT, 12);
$statement->execute();
header("Location: https://$_SESSION[serverRoot]/tables/listOfClass.php?classId=".substr($_POST['deleteCurrArrId'],0,4));

?>