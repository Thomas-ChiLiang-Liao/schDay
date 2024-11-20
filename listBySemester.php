<!DOCTYPE html> 
<?php
//include 'config.php';
$pdo = new PDO('mysql:host=localhost:3307;dbname=daan;charset=utf8','daanLogin','780l0XNi4!Q6PCfZY');						
?>

<html lang="en">
  <head>
    <title>教學進度表下載</title>
    <meta charset="utf-8">
    <link rel="icon" href="images/NA156516864930117.gif" type="image/x-icon">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/4.5.2/jquery.min.js"></script>
		<style>
			a.nav-link.d-inline:link, a.nav-link.d-inline:visited { color: white }
		</style>
  </head>
  <body>
  	<!-- 標題列 -->
  	<div class="container-fluid">
    	<div class="row d-none d-sm-block">
    		<div class="col-12 m-0 pt-3 pb-1 bg-primary">
					<h3 class="text-center text-white"><?php echo substr($_GET['s'],0,3); ?> 學年度第 <?php echo substr($_GET['s'],3,1); ?> 學期教學進度一覽表</h3>
    		</div>
    	</div>
			<div class="row my-5 ml-1">
				<div class="col-12">
				<?php for ($grade=1; $grade<=3; $grade++) { ?>
					<h3><?php echo ( $grade == 1 ? "一" : ( $grade == 2 ? "二" : "三" ) ) . "年級"; ?></h3>
					<?php
					$sql = "SELECT class$_GET[s].id AS classId, class$_GET[s].title AS classTitle, teacher$_GET[s].name AS mentorTeacher FROM class$_GET[s] ".
								 "LEFT JOIN teacher$_GET[s] ON class$_GET[s].mentorId = teacher$_GET[s].id ".
								 "WHERE LEFT(class$_GET[s].id,1)=$grade AND MID(class$_GET[s].id,2,2) <= 16 ".
								 "ORDER BY class$_GET[s].id ASC;";
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