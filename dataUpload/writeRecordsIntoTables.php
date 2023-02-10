<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
session_start();

// 建立資料庫連線
$pdo = new PDO('mysql:host=localhost:3307;dbname=daan;charset=utf8','daanAdmin','tv86EW&6jxj0v6siA');

// 檔案上傳成功，以 PhpSpreadsheet 讀檔
$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
$reader->setReadDataOnly(TRUE);
$spreadsheet = $reader->load("./uploaded.xlsx");


// 處理 worksheet.class
$worksheet = $spreadsheet->getSheetByName('class');
$row = 2;
$numRows = 0;
while ($row <= $worksheet->getHighestRow()) {
  $classId = $worksheet->getCell('A'.$row)->getValue();
  $classTitle = $worksheet->getCell('B'.$row)->getValue();
  $mentorId = ( $worksheet->getCell('C'.$row) == '' ? 'NULL' : $worksheet->getCell('C'.$row)->getValue() );
  $sql = "INSERT INTO class$_SESSION[semester] ".
            '(id, title, mentorId) '.
            "VALUES ($classId, '$classTitle', $mentorId);";
  //echo $sql . '<br>';
  $statement = $pdo->prepare($sql);
  if ( $statement->execute() )
	 	if ( $statement->rowCount() == 1 ) $numRows++;
	 	else echo $sql . '<br>';
	else echo $sql . '<br>';
  $row++;
}
echo '寫入 class 資料表計 ' . $numRows . ' 筆紀錄。<br>';

// 處理 worksheet.teacher
$worksheet = $spreadsheet->getSheetByName('teacher');
$row = 2;
$numRows = 0;
while ($row <= $worksheet->getHighestRow()) {
	$id = $worksheet->getCell('A'.$row)->getValue();
	$name = $worksheet->getCell('B'.$row)->getValue();
	$sql = "INSERT INTO teacher$_SESSION[semester] ".
						'(id, name) '.
						"VALUES ($id, '$name');";
	// echo sql . '<br>';
	$statement = $pdo->prepare($sql);
	if ( $statement-> execute() )
		if ( $statement->rowCount() == 1 ) $numRows++;
		else echo $sql . '<br>';
	else echo $sql . '<br>';
	$row++;
}
echo '寫入 teacher 資料表計 ' . $numRows . ' 筆紀錄。<br>';

// 處理 worksheet.subject
$worksheet = $spreadsheet->getSheetByName('subject');
$row = 2;
$numRows = 0;
while ($row <= $worksheet->getHighestRow()) {
	$id = $worksheet->getCell('A'.$row)->getValue();
	$title = $worksheet->getCell('B'.$row)->getValue();
	$sql = "INSERT INTO subject$_SESSION[semester] ".
						'(id, title) '.
						"VALUES ($id, '$title');";
	// echo sql . '<br>';
	$statement = $pdo->prepare($sql);
	if ( $statement-> execute() )
		if ( $statement->rowCount() == 1 ) $numRows++;
		else echo $sql . '<br>';
	else echo $sql . '<br>';
	$row++;
}
echo '寫入 subject 資料表計 ' . $numRows . ' 筆紀錄。<br>';

// 處理 worksheet.curArr
$worksheet = $spreadsheet->getSheetByName('currArr');
$numRows = 0;
for ($row = 2; $row <= $worksheet->getHighestRow(); $row++) {
  if ( $worksheet->getCell('C'.$row)->getValue() == '' ) continue;
	$id = $worksheet->getCell('A'.$row)->getValue() . 
	      $worksheet->getCell('B'.$row)->getValue() . 
	      $worksheet->getCell('C'.$row)->getValue();
	$sql = "INSERT INTO currArr$_SESSION[semester] ".
						'(id) '.
						"VALUES ($id);";
	// echo sql . '<br>';
	$statement = $pdo->prepare($sql);
	if ( $statement-> execute() )
		if ( $statement->rowCount() == 1 ) $numRows++;
		else echo $sql . ' 寫入失敗！<br>';
	else echo $sql . ' 寫入錯誤！<br>';
}
echo '寫入 curArr 資料表計 ' . $numRows . ' 筆紀錄。<br>';

?>     