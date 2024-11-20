<!DOCTYPE html> 

<?php
session_start();
if ( !isset($_SESSION['name']) ) header("Location: https://$_SERVER[SERVER_NAME]".dirname($_SERVER['SCRIPT_NAME']).'/../');
else {
	include '../menu.php';
	include '../../config.php';
	
	// 資料庫連線
	$pdo = new PDO('mysql:host=localhost:3307;dbname=daan;charset=utf8','daanLogin','780l0XNi4!Q6PCfZY');
	// 導師姓名
	$sql = "SELECT class$SEMESTER.id AS id, class$SEMESTER.Title AS title, teacher$SEMESTER.name AS mTeacher FROM class$SEMESTER LEFT JOIN teacher$SEMESTER ON class$SEMESTER.mentorId = teacher$SEMESTER.id WHERE class$SEMESTER.id = :classId;";
	$statement = $pdo->prepare($sql);
	$statement->bindParam(':classId', $_GET['classId'], PDO::PARAM_INT, 4);
	$statement->execute();
	if ($statement->rowCount() <> 1) header("Location https://$_SESSION[serverRoot]/error.php?errorCode=1");
	else $class = $statement->fetch(PDO::FETCH_ASSOC);
	
	// 科目及授課教師
	$sql = "SELECT ".
						"subject$SEMESTER.id AS id, ".
						"subject$SEMESTER.title AS title, ".
						"teacher$SEMESTER.id AS tid, ".
						"currArr$SEMESTER.id AS fileId, ".
						"teacher$SEMESTER.name AS teacher ".
				 "FROM currArr$SEMESTER ".
				 "LEFT JOIN class$SEMESTER ON LEFT(currArr$SEMESTER.id,4) = class$SEMESTER.id ".
				 "LEFT JOIN subject$SEMESTER ON MID(currArr$SEMESTER.id,5,4) = subject$SEMESTER.id ".
				 "LEFT JOIN teacher$SEMESTER ON RIGHT(currArr$SEMESTER.id,4) = teacher$SEMESTER.id ".
				 "WHERE class$SEMESTER.id = :classId ".
				 "ORDER BY MID(currArr$SEMESTER.id,5,4) ASC;";
	$statement = $pdo->prepare($sql);
	$statement->bindParam(':classId', $_GET['classId'], PDO::PARAM_INT, 4);
	$statement->execute();
	
	// 輸入Form用的資料
	// 課程名稱代碼
	$sql = "SELECT * FROM subject$SEMESTER WHERE 1;";
	$subjectQuery = $pdo->query($sql);
	$subjectQuery->execute();
	
	// 教師名稱代碼
	$sql = "SELECT * FROM teacher$SEMESTER WHERE 1;";
	$teacherQuery = $pdo->query($sql);
	$teacherQuery->execute();
		
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
			th,td { text-align:center; }
		</style>
    <script>
      $(document).ready(function() {
        $(".convert").change(function() {     	
        	for (i = 0; i < $(this).next().children("option").length; i++) {
        	  if ( $(this).next().children("option").eq(i).val() == $(this).val() ) {
        	    $(this).siblings("input").val( $(this).next().children("option").eq(i).attr("data-value") );
        	    break;
        	  }
        	} 
       	  if ( i == $(this).next().children("option").length ) {
        	  alert('無此名稱，請重新輸入！');
        	  $(this).focus();
        	}        	
        });
        
        $("button").click(function() {
        	if ( $("#sid").val() != 'No!' && $("#tid").val() != 'No!' ) $(this).parent().submit();
        	else if ( $("#sid").val()== 'No!' ) {
        		alert ('請輸入課程名稱');
        		$("#subject").focus();
        	} else {
        		alert ('請輸入教師姓名');
        		$("#teacher").focus();
        	}
        });
        
        $(".deleteCurrArrButton").click(function() {
        	$("#deleteCurrArrId").val( $(this).next().val() );
        	$("#deleteCurrArrForm").submit();
        });
      });
    </script>		
  </head>
  <body>
    <?php menu('tables'); ?>
    <div class="container-fluid">
      <div class="row my-5">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header text-center bg-info">
              <h4><?php echo $class['title'] . ' ' . substr($SEMESTER,0,3) . ' 學年度第 ' . substr($SEMESTER,-1) . ' 學期課程列表'?></h4>
            </div>
            <div class="card-body">
            	<form action="deleteCurrArr.php" method="post" id="deleteCurrArrForm">
            		<input type="hidden" id="deleteCurrArrId" name="deleteCurrArrId">
            	</form>
              <table class="table table-striped table-bordered table-hover">
                <thead class="thead-dark">
                  <tr>
                    <th width="75%">課程</th>
                    <th>授課教師</th>
                    <th>上傳？</th>
                    <th>操作</th>
                  </tr>                  
                </thead>
                <?php 
                while ($subject = $statement->fetch(PDO::FETCH_ASSOC)) { 
                ?>
                <tr>
                  <td class="text-left"><?php echo $subject['title']; ?></td>
                  <td><a href="listOfTeacher.php?tid=<?php echo $subject['tid']; ?>&cid=<?php echo $_GET['classId']; ?>"><?php echo $subject['teacher']; ?></a></td>
                  <td>
										<?php
										if (file_exists("../../files/$SEMESTER/$subject[fileId].pdf")) {
											?>
											<a href="../../files/<?php echo $SEMESTER; ?>/<?php echo $subject['fileId'].'.pdf'; ?>" target="_blank">檢視</a>
											<?php 
											} else {
											?>
											<div class="text-danger">尚未上傳！</div>
											<?php	
											}
											?>
                  </td>
                  <td>
                  	<?php 
                  	if (file_exists("../../files/$SEMESTER/$subject[fileId].pdf")) {
                  	?>
                  	已上傳！
                	  <?php } else { ?>
                    <a href="#" class="deleteCurrArrButton">
                      <img src="../../images/no.png" width="20">
                    </a>
                    <input type="hidden"  value="<?php echo "$_GET[classId]$subject[id]$subject[tid]"; ?>">
                	  <?php } ?>                    
                  </td>
                </tr>  
                <?php 
                } 
                ?>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-header bg-warning">
              <h4>新增課程</h4>
            </div>
            <div class="card-body">
              <form action="insertCurrArr.php" method="post" class="form">
                <input type="hidden" name="cid" value="<?php echo $_GET['classId'];?>">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">課程</span>
                  </div>
                  <input type="hidden" name="sid" id="sid" value="No!">
                  <input class="form-control convert" type="text" id="subject" placeholder="課程全名" list="subjects">
                  <datalist id="subjects">
                    <?php while ($subject = $subjectQuery->fetch(PDO::FETCH_ASSOC)) echo "<option value=\"$subject[title]\" data-value=\"$subject[id]\">";?>
                  </datalist>
                </div>
                <div class="input-group mt-2">
                  <div class="input-group-prepend">
                    <span class="input-group-text">教師</span>
                  </div>
                  <input type="hidden" name="tid" id="tid" value="No!">
                  <input class="form-control convert" type="text" id="teacher" placeholder="教師姓名" list="teachers">
                  <datalist id="teachers">
                    <?php while ($teacher = $teacherQuery->fetch(PDO::FETCH_ASSOC)) echo "<option value=\"$teacher[name]\" data-value=\"$teacher[id]\">";?>
                  </datalist>
                </div>
                <button type="button" class="btn btn-warning mt-2">送出</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
<?php
}
?>
	