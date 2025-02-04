<?php
function menu($func) {
?>
  	<!-- 標題列 -->
  	<div class="container-fluid">
    	<div class="row d-none d-sm-block">
    		<div class="col-12 m-0 pt-3 pb-1 bg-warning">
					<h3 class="text-center">大安高工校園輔助系統--管理介面</h3>
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
					
					<?php if ( strpos('廖啟良盧柏毓', $_SESSION['name'] ) !== false ) { ?>
					<li class="nav-item<?php echo ( $func == 'tables' ? ' active' : ''); ?>">
						<a class="nav-link" href="<?php echo "https://$_SESSION[serverRoot]/tables/";?>">
							課表維護
						</a>
					</li>
				  <?php } ?>

					<?php if ( strpos('廖啟良盧柏毓', $_SESSION['name'] ) !== false ) { ?>
					<li class="nav-item<?php echo ( $func == 'assistUpload' ? ' active' : ''); ?>">
						<a class="nav-link" href="<?php echo "https://$_SESSION[serverRoot]/assistUpload/";?>">
							協助上傳
						</a>
					</li>
				  <?php } ?>
				  
					<?php if ( strpos('廖啟良盧柏毓張佩琪陳德貴鄧宇超蕭為康黃建中', $_SESSION['name'] ) !== false ) { ?>
					<li class="nav-item<?php echo ( $func == 'listCreater' ? ' active' : ''); ?>">
						<a class="nav-link" href="<?php echo "https://$_SESSION[serverRoot]/listCreater/";?>">
							上傳統計表
						</a>
					</li>
				  <?php } ?>
				  				  
				  <?php if ( strpos('廖啟良莊政道林冠宇', $_SESSION['name'] ) !== false ) { ?>
				  <li class="nav-item<?php echo ( $func == 'resetPW' ? ' active' : ''); ?>">
				    <a class="nav-link" href="<?php echo "https://$_SESSION[serverRoot]/resetPW/";?>">
				      教職員密碼重置
				    </a>
				  </li>
				  <?php } ?>
				  
				</ul>		
				<p class="text-white my-2">
					操作人員：<?php echo $_SESSION['name'];?>
					<a class="nav-link d-inline" href="https://photo.taivs.tp.edu.tw/schDay/maintain/logout.php">登出</a>
				</p>
			</div>
		</nav>		
<?php
}
?>