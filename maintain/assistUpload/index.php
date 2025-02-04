<!DOCTYPE html> 
<?php
if ( !isset( $_SERVER['HTTPS'] ) OR ( $_SERVER['HTTPS'] != 'on' ) ) header("Location: https://$_SERVER[SERVER_NAME]".dirname($_SERVER['SCRIPT_NAME']).'/../');
else { 
	session_start();
	//print_r ($_SESSION);
	if ( !isset($_SESSION['name']) ) header("Location: https://$_SERVER[SERVER_NAME]".dirname($_SERVER['SCRIPT_NAME']).'/../');
	include '../menu.php';
	include '../../config.php';

	$pdo = new PDO('mysql:host=localhost:3307;dbname=daan;charset=utf8','daanLogin','780l0XNi4!Q6PCfZY');
	
	$statement = $pdo->query('SELECT id, name FROM operator WHERE 1 ORDER BY name ASC;');
	$statement->execute();					
?>

<html lang="en">
  <head>
    <title>校園輔助系統-後台</title>
    <meta charset="utf-8">
    <link rel="icon" href="../../images/NA156516864930117.gif" type="image/x-icon">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/4.5.2/jquery.min.js"></script>
		<script src="/include/autoLogout.js"></script>
		<style>
			a.nav-link.d-inline:link, a.nav-link.d-inline:visited { color: white }
		</style>
    <script>
      $(document).ready(function() {
        $("button").click(function() {
        	for (i=0; i<$("#faculties option").length; i++) {
        		if ($("#faculties option").eq(i).val() == $("#facultyName").val()) {
        			$("#facultyId").val( $("#faculties option").eq(i).attr("data-value") );
        			break;
        		}
        	}
          $(this).parent().submit();
        })
      })
    </script>		
  </head>
  <body>
		<?php menu('assistUpload'); ?>
		<div class="container-fluid">
			<div class="row my-5">
				<div class="col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4">
				  <div class="card mx-xl-5">
     				<div class="card-header bg-warning">
      				<h5 class="text-white p-1">代為上傳介面，請選擇教師。</h5>
      			</div>
      			<div class="card-body">
    					<form action="fileUploadForm.php" method="post">
    					  <input type="hidden" name="facultyId" id="facultyId">
    						<div class="input-group">
    							<div class="input-group-prepend">
    								<span class="input-group-text">姓名</span>
    							</div>
    						  <input type="text" class="form-control" placeholder="請輸入教職員姓名" list="faculties" name="facultyName" id="facultyName">
    							<datalist id="faculties">
    							  <?php while ($record = $statement->fetch(PDO::FETCH_ASSOC)) echo "<option data-value='$record[id]' value='$record[name]'></option>"; ?>
    							</datalist>
    						</div>
    						<button type="button" class="btn btn-secondary mt-2">查詢</button>
    					</form>
      			</div>				  
				  </div>
    		</div>
			</div>
		</div>
	</body>
</html>
<?php } ?>