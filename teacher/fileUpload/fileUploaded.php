<!DOCTYPE html>
<?php
session_start();
if ( !isset($_SESSION['name']) ) header("Location: https://$_SERVER[SERVER_NAME]".dirname($_SERVER['SCRIPT_NAME']).'/../');
include '../../config.php';

$_SESSION['uploadErrorMessage'] = '';
for ($i = 0; $i < count($_FILES['fileToUpload']['name']); $i++) {
	if ( $_FILES['fileToUpload']['error'][$i] === UPLOAD_ERR_OK ) {
		$targetFilePath = "../../files/$SEMESTER/".$_POST['currArrId'][$i].'.pdf';
		if ( file_exists( $targetFilePath )  ) unlink ( $targetFilePath );
		move_uploaded_file($_FILES['fileToUpload']['tmp_name'][$i], $targetFilePath);
	} else {
    $_SESSION['uploadErrorMessage'] .= (strlen($_SESSION['uploadErrorMessage']) == 0 ? '' : '<br>' ) . 
    '檔案 <span class="font-weight-bold">' . $_FILES['fileToUpload']['name'][$i] . '</span> 上傳錯誤，' . 
    ($_FILES['fileToUpload']['error'][$i] == 1 ? '檔案大小超過 10M Bytes。' : '代碼：' . $_FILES['fileToUpload']['error'][$i] );
	}
}
header("Location: https://$_SERVER[SERVER_NAME]".dirname($_SERVER['SCRIPT_NAME']));
?>