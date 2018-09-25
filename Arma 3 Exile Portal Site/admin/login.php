<?php
ob_start();
require "../Functions/sphubcms.php";
$CMS = new SphubCMS;
$extraDir = "./extra/";
	$dirUp = "./";
require('../extra/common.php');
require("../extra/classes.php");
$settingClass = new settingClass;
$statClass = new statClass($settingClass);
$userClass = new userClass;
$permClass = new permissionClass;
require("../Functions/sessionhandler.php");
if ($AccountID == "")
{
	unset ($AccountID);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title><?php echo $settingClass->getServername(); ?> Admin</title>
  <!-- Bootstrap 3.3.7 -->
	<script src="../library/jquery/dist/jquery.min.js"></script>
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- Bootstrap 3.3.7 -->
		<link rel="stylesheet" href="../library/bootstrap/dist/css/bootstrap.min.css">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="../library/font-awesome/css/font-awesome.min.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="../library/admin-css/css/Admin.min.css">
		<link rel="stylesheet" href="../library/admin-css/css/skins/skin-black.min.css">
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<!-- jQuery 3 -->
		<script src="../library/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../library/datatables.net/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="../library/datatables.net/css/dataTables.bootstrap.min.css">
<script src="../library/datatables.net/js/jquery.dataTables.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script src="../library/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- Admin App -->
		<script src="../library/admin-css/js/admin.min.js"></script>
		<script src="../library/letteravatar.js"></script>
		<!-- Google Font -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	</head>
<?php
  	if(!empty($AccountID))
	{
			header("Location: index.php");
			exit();
	}
  if(!empty($_POST)) {

		if(ISSET($_POST['submit_login']))
		{
			$query = "
				SELECT
					*
				FROM `".$tblpre."users`
				WHERE
					`username` = :username";

			$query_params = array(
				':username' => (filter_var($_POST['username'] , FILTER_SANITIZE_FULL_SPECIAL_CHARS))
			);

			try
			{
				$stmt = $db->prepare($query);
				$result = $stmt->execute($query_params);
			}
			catch(PDOException $ex)
			{

				die("Failed to run query: " . $ex->getMessage());
			}

			$login_ok = false;

			$row = $stmt->fetch();
			if($row)
			{
				$check_password = hash('sha256', $_POST['password'] . $row['salt']);
				for($round = 0; $round < 65536; $round++)
				{
					$check_password = hash('sha256', $check_password . $row['salt']);
				}

				if($check_password === $row['password'])
				{
					$login_ok = true;
				}
				$adminlevel = "";
				$adminlevel = $row['admin'];
				$userid = $row['id'];
			}

			if($login_ok)
			{
if($adminlevel ==1)
{
						unset($row['salt']);
						unset($row['password']);
						 	$query = "UPDATE `".$tblpre."sessions`
							SET accountid = :userid
							WHERE sid = :sid
						";

						$query_params = array(
							':userid' => $userid,
							':sid' => $SID
						);

						try
						{
							$stmt = $db->prepare($query);
							$result = $stmt->execute($query_params);
						}
						catch(PDOException $ex)
						{

							die("Failed to run query: " . $ex->getMessage());
						}

						$query = "
							UPDATE ".$tblpre."users
								SET lastlogged = :date
							WHERE
								id = :username
						";

						$query_params = array(
							':date' => date('Y-m-y H:i:s'),
							':username' => $userid
						);

						try
						{
							$stmt = $db->prepare($query);
							$result = $stmt->execute($query_params);
						}
						catch(PDOException $ex)
						{

							die("Failed to run query: " . $ex->getMessage());
						}
if ($defaultConstants['COOKIE_PATH']== NULL)
{
  $path = "/";
} else
{
  $path = $defaultConstants['COOKIE_PATH'];
}
setcookie($defaultConstants['COOKIE_PREFIX'].'sessiontimer', $SID, time() + 60 * 30, $path);
						header("Location: index.php");
						exit;
}
else{
	header("location: login.php?e=1");
}
					}
			else
			{
				?><div class="container" style="width:450px;">
						<div class="alert alert-danger" style="text-align: center;">
							<div class="alert alert-danger">Login failed</div>
						</div>
					</div><?php
				$submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
			}
		}
  }
  ?>

  <?php
  if(isset($_GET["e"]))
  {
  					?>
  					<div class="container" style="width:450px;">
						<div class="alert alert-danger" style="text-align: center;">
							<div class="alert alert-danger">Login failed not a admin account</div>
						</div>
					</div>
					<?php
  }
  ?>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
   <b><?php echo $settingClass->getServername(); ?> </b> Admin
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form action="login.php" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="username" placeholder="Username">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">

        <div class="col-xs-4">
          <button type="submit" name="submit_login" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="../library/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../library/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
</body>
</html>
