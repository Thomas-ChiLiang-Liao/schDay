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
  </head>
  <body>
		<?php menu('tables'); ?>
		<div class="container-fluid">
			<div class="row my-5">
				<div class="col-12">
				<?php for ($grade=1; $grade<=3; $grade++) { ?>
					<h3><?php echo ( $grade == 1 ? "一" : ( $grade == 2 ? "二" : "三" ) ) . "年級"; ?></h3>
					<?php
					$sql = "SELECT class$SEMESTER.id AS classId, class$SEMESTER.title AS classTitle, teacher$SEMESTER.name AS mentorTeacher FROM class$SEMESTER ".
								 "LEFT JOIN teacher$SEMESTER ON class$SEMESTER.mentorId = teacher$SEMESTER.id ".
								 "WHERE LEFT(class$SEMESTER.id,1)=$grade AND MID(class$SEMESTER.id,2,2) <= 16 ".
								 "ORDER BY class$SEMESTER.id ASC;";
					$statement = $pdo->query($sql);						
					while ($record = $statement->fetch(PDO::FETCH_ASSOC)) {
					?>
					<a href="listOfClass.php?s=<?php echo $_GET['s'];?>&classId=<?php echo $record['classId'];?>" class="btn btn-<?php echo ( $grade == 1 ? 'info' : ( $grade == 2 ? 'success' : 'warning' ) ); ?> mb-1"><?php echo $record['classTitle'].'<br>'.$record['mentorTeacher'].'老師'; ?></a>
					<?php } ?>					
					<hr>
				<?php } ?>
				</div>			
			</div>
		</div>
	</body>
</html>
<?php } ?>