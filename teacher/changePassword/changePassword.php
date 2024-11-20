<?php
session_start();
if ( !isset($_SESSION['name']) ) header("Location: https://$_SERVER[SERVER_NAME]".dirname($_SERVER['SCRIPT_NAME']).'/../');
foreach ($_SESSION AS $data) {
	$data = str_replace('"','',$data);
	$data = str_replace("'",'',$data);
}

$pdo = new PDO('mysql:host=localhost:3307;dbname=daan;charset=utf8','daanAdmin','tv86EW&6jxj0v6siA');
	
$statement = $pdo->prepare('UPDATE operator SET pw = :pw WHERE (id = :id AND pw = :oriPw);');
$statement->bindParam(':pw',$_POST['newPw'],PDO::PARAM_STR, 40);
$statement->bindParam(':id',$_SESSION['id'],PDO::PARAM_STR, 45);
$statement->bindParam(':oriPw',$_POST['oldPw'],PDO::PARAM_STR, 40);

$statement->execute();

if ($statement->rowCount() == 1) {
	$_SESSION['firstLogin'] = false;
	header("Location: https://$_SESSION[serverRoot]/main");
}
else header("Location: https://$_SERVER[SERVER_NAME]".dirname($_SERVER['SCRIPT_NAME']).'/index.php?errorCode=1');
?>