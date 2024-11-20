<!DOCTYPE html> 
<?php
// 先清除 $_SESSION
session_start();
session_unset();
session_destroy();

$errorMessage = Array (
	1 => '輸入參數錯誤！請依正常操方式進行。',
	2 => '新增資料至配課表失敗。可能是新增同課程、教師至同班級造成的錯誤！<br>請重新登入操作，如確定非前述原因，請連絡廖啟良。'
);
?>

<html lang="en">
  <head>
    <title>校園輔助系統-後台</title>
    <meta charset="utf-8">
    <link rel="icon" href="images/NA156516864930117.gif" type="image/x-icon">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/4.5.2/jquery.min.js"></script>
		<style>
			a:link, a:visited { color: white }
		</style>
  </head>
  <body>
		<!-- 標題列 -->
  	<div class="container-fluid">
    	<div class="row d-none d-sm-block">
    		<div class="col-12 m-0 pt-3 pb-1 bg-danger">
					<h3 class="text-center text-white">大安高工校園輔助系統--管理介面</h3>
    		</div>
    	</div>
    	<div class="row mt-5">
    		<div class="col-12 col-sm-8 offset-md-1 col-md-6 offset-md-3 col-lg-4 offset-lg-4 text-center">
    			<div class="alert alert-danger">
    				<?php echo $errorMessage[$_GET['errorCode']]; ?>
    			</div>
    		</div>
    	</div>
    </div>
	</body>
</html>