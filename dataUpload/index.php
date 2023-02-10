<!DOCTYPE html> 

<html lang="en">
  <head>
    <title>學校日</title>
    <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<!-- 此檔會用的到 JavaScript Code -->
		<script>
			<!-- 讓選擇的檔案名稱會顯示在input內 -->
			$(document).ready(function(){
				$(".custom-file-input").on("change", function() {
					var fileName = $(this).val().split("\\").pop();
					$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
				})
			});
		</script>	
		<style>
			a:link, a:visited { color: white }
		</style>			
   </head>
  
  <body>
  	<div class="container-fluid">
    	<div class="row mt-5">
    		<div class="col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4">
    			<div class="card mx-xl-5">
    				<div class="card-header bg-primary">
    					<h5 class="text-white p-1">資料上傳作業</h5>
    				</div>
    				<div class="card-body">
							<form action="dealWithUploadedFile.php" method="post" enctype="multipart/form-data">
								<div class="form-group">
									<label for="semester">學年期</label>
									<input type="text" class="form-control" id="semester" name="semester" pattern="[0-9]{4}">
								</div>
								<div class="custom-file mt-3">
									<input type="file" class="custom-file-input" id="fileToUpload" name="fileToUpload">
									<label class="custom-file-label text-secondary" for="fileToUpload">請選擇上傳的檔案(.xlsx)</label>
									<button class="form-group btn btn-primary mt-3">上傳</button>	
								</div>				
							</form>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
	</body>
</html>