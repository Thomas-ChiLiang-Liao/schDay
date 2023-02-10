<?php
function menu($func) {
?>
  	<!-- 標題列 -->
  	<div class="container-fluid">
    	<div class="row d-none d-sm-block">
    		<div class="col-12 m-0 pt-3 pb-1 bg-primary">
					<h3 class="text-center text-white">大安高工教學進度表(含班級經營計畫表及實習教學計畫表)上傳介面</h3>
    		</div>
    	</div>
    </div>
    <!-- Menu bar -->
		<nav class="navbar navbar-expand-sm bg-dark navbar-dark p-0 pl-3">
			<!--<a class="navbar-brand p-0" href="#">books@大安</a>-->
			<!-- 功能表壓縮鈕 -->
			<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
				<span class="navbar-toggler-icon"></span>
			</button>
			
			<!-- 功能表超連結 -->
			<div class="collapse navbar-collapse" id="collapsibleNavbar">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item<?php echo ( $func == 'changePassword' ? ' active' : '' ); ?>">
						<a class="nav-link" href="<?php echo "https://$_SESSION[serverRoot]/changePassword/";?>">
							修改密碼
						</a>
					</li>
					<li class="nav-item<?php echo ( $func == 'fileUpload_batch' ? ' active' : ''); ?>">
						<a class="nav-link" href="<?php echo "https://$_SESSION[serverRoot]/fileUpload_batch/";?>">
							教學進度表(含班級經營計畫表及實習教學計畫表)等上傳
						</a>
					</li>					
					<li class="nav-item<?php echo ( $func == 'fileUpload' ? ' active' : ''); ?>">
						<a class="nav-link" href="<?php echo "https://$_SESSION[serverRoot]/fileUpload/";?>">
							個人課表檢視及上傳
						</a>
					</li>
				</ul>		
				<p class="text-white my-2 operator">
					操作人員：<?php echo $_SESSION['name'];?>
					<a class="nav-link d-inline" href="<?php echo "https://$_SESSION[serverRoot]/logout.php"?>">登出</a>
				</p>
			</div>
		</nav>		
<?php
}
?>