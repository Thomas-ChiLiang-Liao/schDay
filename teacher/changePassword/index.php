<!DOCTYPE html> 

<?php
session_start();
if ( !isset($_SESSION['name']) ) header("Location: https://$_SERVER[SERVER_NAME]".dirname($_SERVER['SCRIPT_NAME']).'/../');
else { 
	include '../menu.php';
?>

<html lang="en">
  <head>
    <title>教學進度表上傳</title>
    <meta charset="utf-8">
    <link rel="icon" href="../../images/NA156516864930117.gif" type="image/x-icon">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/4.5.2/jquery.min.js"></script>
		<!-- JavaScript 自定函數 -->
		<script type="text/javascript" src="/include/js/myFunc.js"></script>
		<script type="text/javascript" src="/include/js/sha1.js"></script>
		<script type="text/javascript">
			function checkNewPassword(objAId, objBId) {
				if ( !(checkPasswordsConsistence(objAId, objBId)) || document.getElementById("oldPw").value == '' ) 
					document.getElementById("setNewPasswordButton").disabled = true;
				else
					document.getElementById("setNewPasswordButton").disabled = false;
			}
			
			function encryptPw(){
				document.getElementById('oldPw').value = SHA1(document.getElementById('oldPw').value);
				document.getElementById('newPw').value = SHA1(document.getElementById('newPw').value);
				document.getElementById('confirmPw').value = SHA1(document.getElementById('confirmPw').value);
				return true;
			}
		</script>
		<script src="/include/autoLogout.js"></script>
		<style>
			a:link, a:visited { color: white }
		</style>
  </head>
  <body onload="document.getElementById('setNewPasswordButton').disabled = true">
		<?php
		if ($_SESSION['firstLogin']) {
		?>
		<!-- 標題列 -->
  	<div class="container-fluid">
    	<div class="row d-none d-sm-block">
    		<div class="col-12 m-0 pt-3 pb-1 bg-primary">
					<h3 class="text-center text-white">大安高工教學進度表上傳介面</h3>
    		</div>
    	</div>
    </div>
 		<?php } else menu('changePassword'); ?>
		<div class="container-fluid">
			<div class="row mt-5">
				<div class="col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4">
					<div class="card">
						<div class="card-header <?php echo (isset($_GET['errorCode']) ? 'bg-danger' : 'bg-warning'); ?>">
							<h5 class="text-white"><?php echo (isset($_GET['errorCode']) ? '變更密碼失敗！請重新操作。' : ($_SESSION['firstLogin'] ? '首次登入，請變更密碼！' : '變更密碼作業')); ?></h5>
						</div>
						<div class="card-body">
							<form action="changePassword.php" method="post" onsubmit="encryptPw()">
								<div class="form-group">
    							<input type="password" class="form-control" placeholder="請輸入舊密碼" id="oldPw" name="oldPw">
    						</div> 
    						<div class="form-group">
    							<input type="password" class="form-control" placeholder="請輸入新密碼" id="newPw" name="newPw" onkeyup="checkNewPassword('newPw','confirmPw')">
    						</div>
    						<div class="form-group">
    							<input type="password" class="form-control" placeholder="確認新密碼" id="confirmPw" name="confirmPw" onkeyup="checkNewPassword('newPw','confirmPw')">
    						</div>
    						<button type ="submit" class="btn btn-secondary" id="setNewPasswordButton">送出</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<?php
} 
?>