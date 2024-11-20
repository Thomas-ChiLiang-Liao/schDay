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
		<!-- reCAPTCHA -->
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
				
				$("#fileUploadFormButton").click(function() {
				  $("#fileUploadForm").submit();
				});
				
				$(".fileDeleteFormButton").click(function() {
					$("#deleteFileName").val( $(this).val() );
				  $("#fileDeleteForm").submit();
				});
				
			});
		</script>			
  </head>
  <body>
		<?php menu('fileUpload'); ?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-sm-10 offset-sm-1 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
					<div class="card mt-3">
						<div class="card-header bg-primary">
							<h3 class="text-center text-white"><?php echo $_SESSION['name'];?>老師您好，您 <?php echo substr($SEMESTER,0,3) . ' 學年度第 ' . substr($SEMESTER,-1);?> 學期授課課程如下：</h3>
						</div>
						<div class="alert alert-warning m-2">
						  <ul>
						    <li>若有多個課程適用同一個檔案，請至<a href="../fileUpload_batch/">教學進度表上傳</a>功能。</li>
						    <li>本功能同時具備上傳、刪除及檢視上傳結果之功能。</li>
						    <li>單筆檔案大小請勿超過 10M Bytes。</li>
						  </ul>
						</div>
						<div class="card-body">
						  <form action="fileUploaded.php" method="post" enctype="multipart/form-data" id="fileUploadForm"></form>
						  <form action="deleteFile.php" method="post" id="fileDeleteForm">
						  	<input type="hidden" name="deleteFileName" id="deleteFileName">
						  </form>
							<table class="table table-striped table-border table-hover">
								<thead>
									<tr>
										<th>班級</th><th>科目</th><th>操作區</th>
									</tr>
								</thead>
								<tbody>								  
									<?php
									$i=0;
									while ($course = $statement->fetch(PDO::FETCH_ASSOC)) {
										$id_for = 'inputField' . sprintf("%03d",++$i);
									?>
									<tr>
										<td class="align-middle"><?php echo $course['classTitle'];?></td>
										<td class="align-middle"><?php echo $course['subjectTitle'];?></td>
										<td class="align-middle inputGroups">
										<?php
										if (file_exists("../../files/$SEMESTER/$course[currArrId].pdf")) {
                                            $path = "https:../../files/index.php?s=$SEMESTER&fileName=$course[currArrId]&class=$course[classTitle]&subject=$course[subjectTitle]&teacher=$_SESSION[name]";
											?>
											<a href="<?php echo $path; ?>" target="_blank">檢視</a>
											
											<button class="ml-5 btn btn-danger fileDeleteFormButton" value="<?php echo $course['currArrId'];?>">刪除</button>
											<?php 
											} else {
											?>
											<div class="custom-file">
												<input type="file" class="custom-file-input" id="<?php echo $id_for;?>" name="fileToUpload[]" form="fileUploadForm">
  											<input type="hidden" name="currArrId[]" value="<?php echo $course['currArrId'];?>" form="fileUploadForm">
	  										<label class="custom-file-label text-secondary" for="<?php echo $id_for;?>">請選擇上傳的檔案(*.pdf)</label>
											</div>
											<?php	
											}
											?>
										</td>
									</tr>	
									<?php 
									} 
									?>
									<tr>
										<td colspan="3" class="text-right"><button class="form-group btn btn-primary mr-3" id="fileUploadFormButton">上傳</button></td>
									</tr>						
								</tbody>
							</table>
							<!--
							<?php if(strlen($_SESSION['uploadErrorMessage']) != 0 ) { ?>
							  <p class="alert alert-danger" role="alert">
                  上傳錯誤！<br>
                  <?php echo $_SESSION['uploadErrorMessage']; ?>
							  </p>
							<?php } ?>
							-->
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>