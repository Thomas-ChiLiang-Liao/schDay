<!DOCTYPE html> 
<?php
session_start();
if ( !isset($_SESSION['name']) ) header("Location: https://$_SERVER[SERVER_NAME]".dirname($_SERVER['SCRIPT_NAME']).'/../');
include '../menu.php';
include '../../config.php';

$pdo = new PDO('mysql:host=localhost:3307;dbname=daan;charset=utf8','daanLogin','780l0XNi4!Q6PCfZY');

// 查詢此教師的所有課程
$sql = 'SELECT '.
					"currArr$SEMESTER.id AS currArrId, ".
					"class$SEMESTER.title AS classTitle, ".
					"subject$SEMESTER.title AS subjectTitle, ".
					"teacher$SEMESTER.name AS teacher ".
			 "FROM currArr$SEMESTER ".
			 "LEFT JOIN class$SEMESTER ON LEFT(currArr$SEMESTER.id,4) = class$SEMESTER.id ".
			 "LEFT JOIN subject$SEMESTER ON MID(currArr$SEMESTER.id,5,4) = subject$SEMESTER.id ".
			 "LEFT JOIN teacher$SEMESTER ON RIGHT(currArr$SEMESTER.id,4) = teacher$SEMESTER.id ".
			 "WHERE teacher$SEMESTER.name = :name AND class$SEMESTER.id < 3900;";
$statement = $pdo->prepare($sql);
$statement->bindParam(':name',$_SESSION['name'],PDO::PARAM_STR, 45);
$statement->execute();
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
		<script>
			// 把課程都放到陣列之中
			var optionsArray = new Array();
			<?php 
			$doneFlag = true;
			while ($course = $statement->fetch(PDO::FETCH_ASSOC)) {
				$fileAlreadyExist = ( file_exists("../../files/$SEMESTER/$course[currArrId].pdf") ? true : false );
				if (!$fileAlreadyExist) $doneFlag = false;
			?>
			var op = new Array(
				<?php echo "\"$course[classTitle]【$course[subjectTitle]】\""; ?>,
				<?php echo "\"$course[currArrId]\""; ?>,
				// 第三個元素是 true 的話，代表已經上傳了！
				<?php echo ( $fileAlreadyExist ? 'true'  : 'false' ); ?>
			);
			optionsArray.push(op);
			<?php
			}
			?>
			
			function setCurrArrSelector() {
			  var p = document.getElementById("currArrSelector01");
			  var op_num = 0;
			  
			  for (var i = 0; i < optionsArray.length; i++) {
			    // 第三個元素是 true 的話，代表已經上傳了！跳過。
			    if (optionsArray[i][2]) continue;
			    op_num++;
			    var option = document.createElement("option");
			    option.text = optionsArray[i][0];
			    option.value = optionsArray[i][1];
			    p.add(option);
			  }
			}
		</script>
		<script src="/include/autoLogout.js"></script>
		<style>
		  a.nav-link.d-inline:link, a.nav-link.d-inline:visited { color: white }
		  td a:link, a:visited { color: blue }
		</style>
		<script>
			<!-- 讓選擇的檔案名稱會顯示在input內 -->
			$(document).ready(function(){
			  
				$(".custom-file-input").on("change", function() {
					var fileName = $(this).val().split("\\").pop();
					var fileType = fileName.split(".").pop().toLowerCase();
					if (fileType == 'pdf') $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
					else {
					  alert('僅能上傳 .pdf 的檔案，請重新選擇');
					  $(this).siblings(".custom-file-label").removeClass("selected");
					  $(this).val('');
					}
				});
				
			});
		</script>			
  </head>
  <body onload="setCurrArrSelector()">
		<?php menu('fileUpload_batch'); ?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-sm-10 offset-sm-1 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
					<div class="card mt-3">
						<div class="card-header bg-primary">
							<h3 class="text-center text-white"><?php echo $_SESSION['name'];?>老師您好<br>請進行 <?php echo substr($SEMESTER,0,3) . ' 學年度第 ' . substr($SEMESTER,-1);?> 學期課程進度表上傳作業：</h3>
						</div>
						<?php if ($doneFlag) {
						?>
						<div class="alert alert-success m-2">
							所有課程之教學進度表均上傳完畢，請由<a href="../fileUpload/">個人課表檢視及上傳</a>進行檢視或修正。
						</div>													
						<?php } else { 
						?>
						<div class="alert alert-warning m-2">
						  <ul>
						  	<li>已上傳成功的課程不會出現在<span style="color: black; font-weight: bold;">適用班級科目</span>選單中。</li>
						  	<li>如每個課程均需上傳不同之進度表，請至<a href="../fileUpload/">個人課表檢視及上傳</a>操作。</li>
						    <li>單筆檔案大小請勿超過 10M Bytes。</li>
						  </ul>
						</div>
						<div class="card-body">
							<form action="fileUploaded.php" enctype="multipart/form-data" method="post">
  							<div class="custom-file mb-2">
									<input type="file" class="custom-file-input" id="fileSelector01" name="fileToUpload">
									<label class="custom-file-label text-secondary" for="fileSelector01">請選擇上傳的檔案(*.pdf)</label>
								</div>
  							<div class="form-group">
								  <label for="currArrSelector01">適用班級科目(可同時選擇多個班級科目)</label>
								  <select class="form-control currArrSelector" id="currArrSelector01" name="currArrCodes[]" multiple>	
								  </select>
								</div>							    
								<button class="form-group btn btn-primary mt-2" id="fileUploadFormButton">上傳</button>
							</form>
						</div>						
						<?php }
						?>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>