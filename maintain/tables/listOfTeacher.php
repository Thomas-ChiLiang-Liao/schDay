<!DOCTYPE html> 
<?php
session_start();
if ( !isset($_SESSION['name']) ) header("Location: https://$_SERVER[SERVER_NAME]".dirname($_SERVER['SCRIPT_NAME']).'/../');
include '../menu.php';
include '../../config.php';

$pdo = new PDO('mysql:host=localhost:3307;dbname=daan;charset=utf8','daanLogin','780l0XNi4!Q6PCfZY');

// 查詢此教師的姓名
$sql = "SELECT * FROM teacher$SEMESTER WHERE :id = id;";
$statement = $pdo->prepare($sql);
$statement->bindParam(':id', $_GET['tid'],PDO::PARAM_INT,4);
$statement->execute();
$teacher = $statement->fetch(PDO::FETCH_ASSOC);
$statement->closeCursor();


// 查詢此教師的所有課程
$sql = 'SELECT '.
					"currArr$SEMESTER.id AS currArrId, ".
					"class$SEMESTER.id AS classId, ".
					"class$SEMESTER.title AS classTitle, ".
					"subject$SEMESTER.title AS subjectTitle ".
			 "FROM currArr$SEMESTER ".
			 "LEFT JOIN class$SEMESTER ON LEFT(currArr$SEMESTER.id,4) = class$SEMESTER.id ".
			 "LEFT JOIN subject$SEMESTER ON MID(currArr$SEMESTER.id,5,4) = subject$SEMESTER.id ".
			 "LEFT JOIN teacher$SEMESTER ON RIGHT(currArr$SEMESTER.id,4) = teacher$SEMESTER.id ".
			 "WHERE teacher$SEMESTER.id = :id AND class$SEMESTER.id < 3900;";
$statement = $pdo->prepare($sql);
$statement->bindParam(':id',$_GET['tid'],PDO::PARAM_INT, 4);
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
		<!-- reCAPTCHA -->
		<script src="/include/autoLogout.js"></script>
		<style>
		  a.nav-link.d-inline:link, a.nav-link.d-inline:visited { color: white }
		  td a:link, a:visited { color: blue }
		</style>	
  </head>
  <body>
		<?php menu('fileUpload'); ?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-sm-10 offset-sm-1 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
					<div class="card mt-3">
						<div class="card-header bg-primary">
							<h3 class="text-center text-white"><?php echo $teacher['name'];?>老師 <?php echo substr($SEMESTER,0,3) . ' 學年度第 ' . substr($SEMESTER,-1);?> 學期授課課程如下：</h3>
						</div>
						<div class="card-body">
							<table class="table table-striped table-border table-hover">
								<thead>
									<tr>
										<th>班級</th><th>科目</th><th>上傳狀態</th>
									</tr>
								</thead>
								<tbody>								  
									<?php
									$i=0;
									while ($course = $statement->fetch(PDO::FETCH_ASSOC)) {
										$id_for = 'inputField' . sprintf("%03d",++$i);
									?>
									<tr>
										<td class="align-middle">
										  <a href="listOfClass.php?classId=<?php echo $course['classId']; ?>">
										    <?php echo $course['classTitle'];?>
									  	</a>
										</td>
										<td class="align-middle"><?php echo $course['subjectTitle'];?></td>
										<td class="align-middle">
										<?php
										if (file_exists("../../files/$SEMESTER/$course[currArrId].pdf")) {
											?>
											<a href="../../files/<?php echo $SEMESTER; ?>/<?php echo $course['currArrId'].'.pdf'; ?>" target="_blank">檢視</a>
											<?php 
											} else {
											?>
											<div class="text-danger">尚未上傳！</div>
											<?php	
											}
											?>
										</td>
									</tr>	
									<?php 
									} 
									?>				
								</tbody>
							</table>
							<div class="text-center"><a href="listOfClass.php?classId=<?php echo $_GET['cid']; ?>">返回上一頁</a></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>