<!DOCTYPE html>
<?php
session_start();
if ( !isset($_SESSION['name']) ) header("Location: https://$_SERVER[SERVER_NAME]".dirname($_SERVER['SCRIPT_NAME']).'/../');
include '../../config.php';

$_SESSION['uploadErrorMessage'] = '';
unlink ( "../../files/$SEMESTER/".$_POST['deleteFileName'].'.pdf' );
header("Location: https://$_SERVER[SERVER_NAME]".dirname($_SERVER['SCRIPT_NAME']));
?>