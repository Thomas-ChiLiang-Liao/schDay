<!DOCTYPE html> 

<?php
if ( !isset( $_SERVER['HTTPS'] ) OR ( $_SERVER['HTTPS'] != 'on' ) ) header("Location: https://$_SERVER[SERVER_NAME]" . dirname( $_SERVER['SCRIPT_NAME'] . '/' ) );
else {
	// 查詢用者名，建立登入之下拉選單
	$pdo = new PDO('mysql:host=localhost:3307;dbname=daan;charset=utf8','daanLogin','780l0XNi4!Q6PCfZY');
	
	$statement = $pdo->query('SELECT id, name FROM operator WHERE subject IS NOT NULL ORDER BY name ASC;');
	$statement->execute();
?>

<html lang="en">
  <head>
    <title>教學進度表上傳</title>
    <meta charset="utf-8">
    <link rel="icon" href="../images/NA156516864930117.gif" type="image/x-icon">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/4.5.2/jquery.min.js"></script>
		<!--<script src="https://www.google.com/recaptcha/api.js" async defer></script>-->
    <!-- 本專案的 js -->
    <script type="text/javascript" src="/include/js/sha1.js"></script>	
    <script>
      $(document).ready(function() {
        $("button").click(function() {
					// 先將使用者輸入的密碼以 SHA1 加密
          $("#userPw").val( SHA1( $("#userPw").val() ) );
          //$("#operators option").length
        	//$("#operators option:eq(10)").attr("data-value")
        	for (i=0; i<$("#operators option").length; i++) {
        		if ($("#operators option").eq(i).val() == $("#userName").val()) {
        			$("#userId").val( $("#operators option").eq(i).attr("data-value") );
        			break;
        		}
        	}
          $(this).parent().submit();
        })
      })
    </script>
   </head>
  
  <body>
  	<div class="container-fluid">
    	<div class="row d-none d-sm-block">
    		<div class="col-12 m-0 pt-3 pb-1 bg-primary">
					<h3 class="text-center text-white">大安高工教學進度表(含班級經營計畫表及實習教學計畫表)上傳介面</h3>
    		</div>
    	</div>
     	<div class="row mt-5">
    		<div class="col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4">
    			<div class="card mx-xl-5">
    				<div class="card-header <?php echo ( isset ( $_GET['loginFailed'] ) ? 'bg-danger' : 'bg-primary' ) ?>">
    					<h5 class="text-white p-1"><?php echo ( isset( $_GET['loginFailed'] ) ? '帳密錯誤！請重新登入。' : '登入') ?></h5>
    				</div>
    				<div class="card-body">
    					<form action="login.php" method="post" id="loginForm">
    						<input type="hidden" id="userId" name="userId">
 								<div class="input-group">
 									<div class="input-group-prepend">
 										<span class="input-group-text">姓名</span>
 									</div>
 	 								<input type="text" class="form-control" placeholder="請輸入姓名" list="operators" name="userName" id="userName">
 									<datalist id="operators">
 										<?php while ($record = $statement->fetch(PDO::FETCH_ASSOC)) echo "<option data-value='$record[id]' value='$record[name]'></option>"; ?>
 									</datalist>
 								</div>
     						<div class="input-group mt-2">
     							<div class="input-group-prepend">
     								<span class="input-group-text">密碼</span>
     							</div>
    							<input type="password" class="form-control" placeholder="請輸入密碼" id="userPw" name="userPw">
    						</div> 								
    						<!--<div class="g-recaptcha mt-2" data-sitekey="6LdVj94UAAAAAIVoFG72BRn-xnxIE_bx3uemirm7"></div>-->
    						<button type="button" class="btn btn-secondary mt-2">登入</button>			
    					</form>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
	</body>
</html>
<?php } ?>