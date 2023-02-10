<!DOCTYPE html>
<?php
// 處理輸入的學年期資料
session_start();
$_SESSION['semester'] = str_replace('\'','',$_POST['semester']);
$_SESSION['semester'] = str_replace('\"','',$_SESSION['semester']);

// 處理上傳檔案
if ( $_FILES['fileToUpload']['error'] == FALSE ) {
	// 檢查是否是 xlsx 檔
	$uploadedFileName = $_FILES['fileToUpload']['name'];
  $fileType = explode('.',$uploadedFileName);
  if ($fileType[1] == 'xlsx') {
    if (file_exists('./uploaded.xlsx')) unlink('./uploaded.xlsx');
		move_uploaded_file($_FILES['fileToUpload']['tmp_name'], './uploaded.xlsx');
		// 上傳檔案處理完成，下一步：讀寫，合成 SQL 指令，寫入資料庫表格
		header("Location: https://$_SERVER[SERVER_NAME]".dirname($_SERVER['SCRIPT_NAME']).'/writeRecordsIntoTables.php');
 	} 
 	else $errorMessage = '非 xlsx 檔！';
} 
else $errorMessage =  '代碼：' . $_FILES['fileToUpload']['error'];
?>
<!-- 錯誤訊息頁面 -->
<html lang="en">
  <head>
    <title>books@大安</title>
    <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
		<style>
			a:link, a:visited { color: white }
		</style>
  </head>
  <body>
		<?php //menu(null); ?>
		<div class="container-fluid">
			<div class="alert alert-danger mt-3" role="alert"><?php echo $errorMessage; ?></div>
			<div class="alert alert-info mt-3" role="alert"><?php echo '請重新操作。'; ?></div>
		</div>
	</body>
</html>