<!DOCTYPE html>
<?php
session_start();
if ( !isset($_SESSION['name']) ) header("Location: https://$_SERVER[SERVER_NAME]".dirname($_SERVER['SCRIPT_NAME']).'/../');
include '../../config.php';
/*
print_r ($_POST);
echo '<br>';
print_r ($_FILES['fileToUpload']);
*/
if ( $_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK ) {
	foreach ($_POST['currArrCodes'] as $index => $value) {
		$targetFilePath = "../../files/$SEMESTER/$value.pdf";
		if ( file_exists( $targetFilePath )  ) unlink ( $targetFilePath );
		if ($index == 0) {
			//echo "Move temp file to $targetFilePath.<br>";
			$sourceFilePath = $targetFilePath;
			move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetFilePath);
		} else { 
			//echo "Copy $sourceFilePath into $targetFilePath.<br>"; 
			copy($sourceFilePath, $targetFilePath);	
		}	
	}
}
header("Location: https://$_SERVER[SERVER_NAME]".dirname($_SERVER['SCRIPT_NAME']));
?>