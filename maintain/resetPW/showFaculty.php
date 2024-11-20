<!DOCTYPE html> 

<?php
session_start();
if ( !isset($_SESSION['name']) ) header("Location: https://$_SERVER[SERVER_NAME]".dirname($_SERVER['SCRIPT_NAME']).'/../');
else {
	include '../menu.php';
	include '../../config.php';
	
  if ( isset($_SESSION['facultyId']) ) {
    $facultyId = $_SESSION['facultyId'];
    $function = 'show';
    unset($_SESSION['facultyId']);
  } else {
    $facultyId = $_POST['facultyId'];
    $function = 'set';
  }
	
	// 資料庫連線
	$pdo = new PDO('mysql:host=localhost:3307;dbname=daan;charset=utf8','daanLogin','780l0XNi4!Q6PCfZY');
	// 查詢職員資料
	$sql = "SELECT id, name, pw, oriPw FROM operator WHERE id = :id;";
	$statement = $pdo->prepare($sql);
	$statement->bindParam(':id', $facultyId, PDO::PARAM_INT, 4);
	$statement->execute();
	if ($statement->rowCount() <> 1) header("Location https://$_SESSION[serverRoot]/error.php?errorCode=1");
	else $faculty = $statement->fetch(PDO::FETCH_ASSOC);
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
  </head>
  <body>
    <?php menu('resetPW'); ?>
    <div class="container-fluid">
      <div class="row my-5">
        <div class="col-12">
          <table class="table table-bordered">
            <thead class="bg-primary text-white">
              <th>姓名</th>
              <th>密碼</th>
              <th>預設密碼</th>
            </thead>
            <tbody>
              <td><?php echo $faculty['name']; ?></td>
              <td><?php echo $faculty['pw']; ?></td>
              <td><?php echo $faculty['oriPw']; ?></td>
            </tbody>
          </table>
          <div class="text-center">
            <?php if ($function == 'set') { ?>
            <form action="resetPassword.php" method="post">
              <input type="hidden" name="facultyId" value="<?php echo $faculty['id']; ?>">
              <button type="submit" class="btn btn-danger">重置密碼為預設密碼</button>
           </form>           
           <?php } else { ?>
           <h4>已將密碼回復為預設密碼</h4> 
           <?php } ?> 
          </div>
        </div>
      </div>
    </div>
  </body>
<?php
}
?>
	