<!DOCTYPE html>

<?php 
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

session_start();
if ( !isset($_SESSION['name']) ) header("Location: https://$_SERVER[SERVER_NAME]".dirname($_SERVER['SCRIPT_NAME']).'/../');
include '../menu.php';
include "../../config.php";

// 資料庫連線
$pdo = new PDO('mysql:host=localhost:3307;dbname=daan;charset=utf8','daanLogin','780l0XNi4!Q6PCfZY');
// 查詢所有教師的課程
$sql = "SELECT ".
  "class$SEMESTER.title AS classTitle, ".
  "subject$SEMESTER.title AS subjectTitle, ".
  "teacher$SEMESTER.name AS teacher, ".
  "currArr$SEMESTER.id AS currArrId ".
"FROM currArr$SEMESTER ".
"LEFT JOIN class$SEMESTER ON LEFT(currArr$SEMESTER.id,4) = class$SEMESTER.id ".
"LEFT JOIN subject$SEMESTER ON MID(currArr$SEMESTER.id,5,4) = subject$SEMESTER.id ".
"LEFT JOIN teacher$SEMESTER ON RIGHT(currArr$SEMESTER.id,4) = teacher$SEMESTER.id ".
"WHERE class$SEMESTER.id < 3200 ".
"ORDER BY teacher$SEMESTER.id ASC, subject$SEMESTER.id ASC, class$SEMESTER.id ASC;";

$statement = $pdo->prepare($sql);
$statement->execute();

?>
<html lang="en">
  <head>
    <title>校園輔助系統-後台</title>
    <meta charset="utf-8">
    <link rel="icon" href="../../images/NA156516864930117.gif" type="image/x-icon">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
		<script src="/include/autoLogout.js"></script>
		<style>
		  a.nav-link.d-inline:link, a.nav-link.d-inline:visited { color: white }
		  td a:link, a:visited { color: blue }
		</style>		
  </head>
  <body>
   	<?php menu('listCreater'); ?>
	  <div class="container-fluid">
	    <div class="row mt-1">
	    	<table class="table table-bordered table-striped table-hover mx-3">
	    		<thead class="bg-secondary text-white">
	    			<tr>
	    				<th width="6%">教師</th>
	    				<th width="47%">任教科目</th>
	    				<th>待上傳科目</th>
	    			</tr>
	    			<?php
	    			$spreadsheet = new Spreadsheet();
	    			$sheet = $spreadsheet->getActiveSheet();
	    			// 列標題
	    			$sheet->setCellValue('A1','教師');
	    			$sheet->setCellValue('B1','任教科目');
	    			$sheet->setCellValue('C1','待上傳科目');
	    			?>
	    		</thead>
	    		<tbody>
	    			<?php 
	    			$columnA = null;
	    			$j = 1;
	    			while ($record = $statement->fetch(PDO::FETCH_ASSOC)) {
	    				if ($record['teacher'] != $columnA AND $columnA != null) {
							$j++;
							$sheet->setCellValue('A'.$j, $columnA);
							$sheet->setCellValue('B'.$j, $columnB);
							$sheet->setCellValue('C'.$j, $columnC);
	    			?>
	    			<tr>
	    				<td><?php echo $columnA; ?></td>
	    				<td><?php echo $columnB; ?></td>
	    				<td><?php echo $columnC; ?></td>
	    			</tr>	
	    			<?php
	    					// 寫入儲存格
	    					
	    					$columnA = $record['teacher'];
	    					$columnB = "【$record[classTitle] $record[subjectTitle]】";
	    					if ( !file_exists("../../files/$SEMESTER/$record[currArrId].pdf") ) $columnC = "【$record[classTitle] $record[subjectTitle]】";
	    					else $columnC = null;
	    				} else {
	    					if ($columnA == null) $columnA = $record['teacher'];
	    					$columnB .= ( $columnB != null ? '、' : '') . "【$record[classTitle] $record[subjectTitle]】";
	    					if (!file_exists("../../files/$SEMESTER/$record[currArrId].pdf")) $columnC .= ( $columnC != null ? '、' : '') . "【$record[classTitle] $record[subjectTitle]】";
	    			?>
	    			<?php
	    				}
	    			}
	    			// 最後一人的資料寫入儲存格。
	    			$j++;
	    			$sheet->setCellValue('A'.$j, $columnA);
						$sheet->setCellValue('B'.$j, $columnB);
						$sheet->setCellValue('C'.$j, $columnC);
	    			// 準備下載檔案
	    			$fileName = 'list.xlsx';
	    			if ( file_exists($fileName) ) unlink($fileName);
	    			$writer = new Xlsx($spreadsheet);
	    			$writer->save($fileName);
	    			?>
	    			<tr>
    					<td><?php echo $columnA; ?></td>
	    				<td><?php echo $columnB; ?></td>
	    				<td><?php echo $columnC; ?></td>	    				
	    			</tr>
	    		</tbody>
	    	</table>
	    </div>	
	    <!-- 按鈕 -->
			<div class="row mb-5">
				<div class="col-sm-8 offset-sm-2 col-md-6 offset-md-2 col-lg-4 offset-lg-4 text-center">
					<form action="downloadXlsxFile.php" method="post">
						<button type="submit" class="btn btn-danger">下載Xlsx檔</button>
					</form>
				</div>
			</div>    	    	  	
	  </div>

	</body>
</html>