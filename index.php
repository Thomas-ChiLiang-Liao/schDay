<!DOCTYPE html> 
<?php
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
  	<div class="container-fluid">
  		<div class="row">
  			<div class="col-12 m-0 pt-3 pb-1 bg-primary">
  				<h3 class="text-center text-white">大安高工 教學計畫表&實習進度表 檢視/下載</h4>
  			</div>
  		</div>
			<div class="row">
				<div class="col-sm-10 offset-sm-1">
					<div class="text-center">
						<ul class="list-group list-group-flush">
							<!--<li class="list-group-item"><a class="btn btn-primary" href="listBySemester.php?s=1131">113學年度第1學期</a></li>-->
              <li class="list-group-item"><a class="btn btn-primary" href="listBySemester.php?s=1131">113學年度第1學期</a></li>
              <li class="list-group-item"><a class="btn btn-primary" href="listBySemester.php?s=1122">112學年度第2學期</a></li>
              <li class="list-group-item"><a class="btn btn-primary" href="listBySemester.php?s=1121">112學年度第1學期</a></li>
              <li class="list-group-item"><a class="btn btn-primary" href="listBySemester.php?s=1112">111學年度第2學期</a></li>
              <li class="list-group-item"><a class="btn btn-primary" href="listBySemester.php?s=1111">111學年度第1學期</a></li>
              <li class="list-group-item"><a class="btn btn-primary" href="listBySemester.php?s=1102">110學年度第2學期</a></li>
              <li class="list-group-item"><a class="btn btn-primary" href="listBySemester.php?s=1101">110學年度第1學期</a></li>
              <li class="list-group-item"><a class="btn btn-primary" href="listBySemester.php?s=1092">109學年度第2學期</a></li>
							<li class="list-group-item"><a class="btn btn-secondary" href="http://ta.taivs.tp.edu.tw/mainteacher/default.asp">109學年度第1學期及之前</a></li>
						</ul>
					</div>
				</div>
			</div>  		
  	</div>
	</body>
</html>