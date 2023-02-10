<!DOCTYPE html> 
<?php
// 建立資料庫連線 & 選擇資料庫
//$pdo = new PDO('mysql:host=localhost:3307;dbname=daan;charset=utf8','daanAdmin','tv86EW&6jxj0v6siA');
$pdo = new PDO('mysql:host=localhost:3307;dbname=daan;charset=utf8','daanLogin','780l0XNi4!Q6PCfZY');

// SQL指令
$sql = 'SELECT * FROM operator WHERE  id= :id AND pw = :pw;';

$statement = $pdo->prepare($sql);
$statement->bindParam(':id',$_POST['userId'],PDO::PARAM_INT, 4);
$statement->bindParam(':pw',$_POST['userPw'],PDO::PARAM_STR, 40);

// 執行SQL指令
$statement->execute();

if ($statement->rowCount() == 1) {
	// 登入成功。讀取登入者的資料。
	$record = $statement->fetch(PDO::FETCH_ASSOC);
	
	// 寫入 $_SESSION 中，但密碼不保存。
	session_start();
	$_SESSION = $record;
	unset($_SESSION['pw']);
	unset($_SESSION['oriPw']);
	$_SESSION['firstLogin'] = ( $record['pw'] == $record['oriPw'] ? true : false);
	$_SESSION['serverRoot'] = $_SERVER['SERVER_NAME'] .dirname($_SERVER['SCRIPT_NAME']);
	
	if ($record['pw'] == $record['oriPw']) header("Location: https://$_SESSION[serverRoot]/changePassword");
	else header("Location: https://$_SESSION[serverRoot]/main");
} 
else 
// 登入失敗，重新登入。
header("Location: https://$_SERVER[SERVER_NAME]" . dirname($_SERVER[SCRIPT_NAME]) . '/index.php?loginFailed');
?>