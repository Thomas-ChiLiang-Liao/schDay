<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $_GET['class'].' '.$_GET['subject'].' '.$_GET['teacher']; ?></title>
</head>
<body>
  <iframe src="./<?php echo $_GET['s'].'/'.$_GET['fileName'].'.pdf'; ?>" width="100%" height="1000" frameborder="0"></frame>
</body>
</html>