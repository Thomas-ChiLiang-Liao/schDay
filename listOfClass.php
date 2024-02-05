<!DOCTYPE html> 

<?php
//include 'config.php';

// 資料庫連線
$pdo = new PDO('mysql:host=localhost:3307;dbname=daan;charset=utf8','daanLogin','780l0XNi4!Q6PCfZY');
// 導師姓名
$sql = "SELECT class$_GET[s].id AS id, class$_GET[s].Title AS title, teacher$_GET[s].name AS mTeacher FROM class$_GET[s] LEFT JOIN teacher$_GET[s] ON class$_GET[s].mentorId = teacher$_GET[s].id WHERE class$_GET[s].id = :classId;";
$statement = $pdo->prepare($sql);
$statement->bindParam(':classId', $_GET['classId'], PDO::PARAM_INT, 4);
$statement->execute();
if ($statement->rowCount() <> 1) header("Location https://$_SESSION[serverRoot]/error.php?errorCode=1");
else $class = $statement->fetch(PDO::FETCH_ASSOC);

// 科目及授課教師
$sql = "SELECT ".
					"subject$_GET[s].id AS id, ".
					"subject$_GET[s].title AS title, ".
					"teacher$_GET[s].id AS tid, ".
					"teacher$_GET[s].name AS teacher ".
			 "FROM currArr$_GET[s] ".
			 "LEFT JOIN class$_GET[s] ON LEFT(currArr$_GET[s].id,4) = class$_GET[s].id ".
			 "LEFT JOIN subject$_GET[s] ON MID(currArr$_GET[s].id,5,4) = subject$_GET[s].id ".
			 "LEFT JOIN teacher$_GET[s] ON RIGHT(currArr$_GET[s].id,4) = teacher$_GET[s].id ".
			 "WHERE class$_GET[s].id = :classId ".
			 "ORDER BY MID(currArr$_GET[s].id,5,4) ASC;";
$statement = $pdo->prepare($sql);
$statement->bindParam(':classId', $_GET['classId'], PDO::PARAM_INT, 4);
$statement->execute();

// 輸入Form用的資料
// 課程名稱代碼
$sql = "SELECT * FROM subject$_GET[s] WHERE 1;";
$subjectQuery = $pdo->query($sql);
$subjectQuery->execute();

// 教師名稱代碼
$sql = "SELECT * FROM teacher$_GET[s] WHERE 1;";
$teacherQuery = $pdo->query($sql);
$teacherQuery->execute();
	
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
			th,td { text-align:center; }
		</style>
  </head>
  <body>
  	<!-- 標題列 -->
  	<div class="container-fluid">
    	<div class="row d-none d-sm-block">
    		<div class="col-12 m-0 pt-3 pb-1 bg-primary">
					<h3 class="text-center text-white"><?php echo substr($_GET['s'],0,3);?> 學年度第 <?php echo substr($_GET['s'],-1); ?> 學期教學進度一覽表</h3>
    		</div>
    	</div>
    </div>
    <div class="container-fluid">
      <div class="row mt-2 mb-5">
        <div class="col-12 col-sm-10 offset-sm-1 col-lg-6 offset-lg-3">
          <div class="card">
            <div class="card-header text-center bg-info">
              <h4><?php echo $class['title'] . ' ' . substr($_GET['s'],0,3) . ' 學年度第 ' . substr($_GET['s'],-1) . ' 學期課程列表'?></h4>
            </div>
            <div class="card-body">
            	<form action="deleteCurrArr.php" method="post" id="deleteCurrArrForm">
            		<input type="hidden" id="deleteCurrArrId" name="deleteCurrArrId">
            	</form>
              <table class="table table-striped table-bordered table-hover">
                <thead class="thead-dark">
                  <tr>
                    <th width="50%">課程</th>
                    <th>授課教師</th>
                    <th>教學進度表</th>
                  </tr>                  
                </thead>
                <?php 
                while ($subject = $statement->fetch(PDO::FETCH_ASSOC)) { 
                ?>
                <tr>
                  <td class="text-left"><?php echo $subject['title']; ?></td>
                  <td><?php echo $subject['teacher']; ?></td>
                  <td>
                    <?php 
                    $targetFile = "files/$_GET[s]/$_GET[classId]$subject[id]$subject[tid].pdf";
                    $path = "files/index.php?s=$_GET[s]&fileName=$_GET[classId]$subject[id]$subject[tid]&class=$class[title]&subject=$subject[title]&teacher=$subject[teacher]";
                    if ( file_exists($targetFile) ) { 
                    ?>
                    <a href="<?php echo $path; ?>" title="<?php echo $subject['title'].$subject['teacher'];?>" target="_blank">檢視</a>  
                    <?php } else { ?>
                    <div class="text-danger">未上傳！</div>
                    <?php } ?>
                  </td>
                </tr>  
                <?php 
                } 
                ?>
              </table>
              <div class="text-center">
                <a href="listBySemester.php?s=<?php echo $_GET['s'];?>" class="btn btn-primary">返回班級列表</a>
              </div>
              
              <!--
              <form action="index.php" method="post">
                <div class="text-center">
                  <button class="btn btn-primary" type="submit">返回班級列表</button>
                </div>
              </form>
              -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>