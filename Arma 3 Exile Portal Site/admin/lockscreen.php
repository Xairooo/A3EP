<?php
require "../Functions/sphubcms.php";
$CMS = new SphubCMS;
eval($CMS->funcDecrypt("==QfK0wOpQUS05WdvN2YBRCKgQXZz5WdJoQD7pQDpIiIg0TPgQUS05WdvN2YBRCKgYWaK0wOyVGbpFWbgcXZuBSPgIXZslWYtRiCNsTKiAHaw5CbpFWbl9CbpFWbF9ycu9Wa0Nmb1Z0Lu4iIoUGZ1x2YulmCNsTKiAHaw5CdjVGblNXZnFWdn5WYs9ycu9Wa0Nmb1Z0Lu4iIoUGZ1x2YulmCNsTKiAHaw5iclxGZuFGau9WazNXZz9ycu9Wa0Nmb1Z0Lu4iIoUmcpVXclJnCNsTKiAHaw5ibvlGdhRWasFmdvMnbvlGdj5WdG9iLuICKlRWdsNmbppQD9pQD7kiIpETOzASRE90QgI1TSJVRoAyTG5USgUkUP1EIS9kRgQlUPBFUVNFIUNUQU50TDBSRTFURMBFIsQURJZUSE9UTgI1TgQkTBByLgQURMxUVOBiTFVkQgMVQIBCTMFEVT5USigSZpRGIgACIK0wOi4jci9CPiAyboNWZgACIgACIgoQD7ISRV5USU50TDBCVP5kTBNEIsI1TSJVRiAyboNWZgACIgoQD7kSKnQnblNHdzFGbngyZulGd0V2U0V2Z+0yczFGbDdmbpRHdlNHJskiIslWYtV2Xn5WavdGd19mIocmbpRHdlNFdldmPtM3chx2Qn5Wa0RXZzRCLpcSeltGbngyZulGd0V2U0V2Z+0yczFGbDdmbpRHdlNHJsISM5MjIo42bpRXYs9Wa25TLn5Wa0J3bwVmUy9mcyVGJgACIgoQD7BSKpUGbpZGZsZHJoMHdzlGel9VZslmZhgCImlmCNszJwhGcu42bpRXYklGbhZ3Lz52bpR3YuVnRv4iLnASPgUGbpZGZsZHJK0wOn5Wa0J3bwVmUy9mcyVGI3Vmbg0DIn5Wa0J3bwVmUy9mcyVGJK0wOzNXYsNkbvl2czlWbyVGcgcXZuBSPgM3chx2QtJXZwRiCNszcn5WYsBydl5GI9Aycn5WYsRiCNszczFGbDJXZzVHI3Vmbg0DIzNXYsNkclNXdkoQD7kyczFGbDdmbpRHdlNHJoM3chx2Q0FGdzBydl5GI9AyczFGbDRXY0NHJK0wOzNXYsN0ZulGd0V2cgcXZuBSPgM3chx2Qn5Wa0RXZzRiCNsTKiAHaw5yclN3chx2YvEmc0hXZv4iLigSZylWdxVmcK0wOpcCcoBnLu9Wbt92YvEmc0hXZv4iLngSZylWdxVmcK0wOi8iLiASPgAXVylGZkoQD7IyLhJHd4V2LuICI9AicpRUYyRHelRiCNsTKoQnchR3cfJ2bK0wOiEjI9UGZ1x2YulGJ"));

if ($AccountID == "")
{
	unset ($AccountID);
}
if(isset($_GET['action']))
{
if($_GET['action'] =="login")
{

header("Location: logout.php");
exit;
}
}
if(ISSET($_POST['submit_lock']))
		{
			$query = "
				SELECT
					*
				FROM `".$tblpre."users`
				WHERE
					`username` = :username AND `admin` = 1 ";

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
				$check_password = hash('sha256', (filter_var($_POST['password'] , FILTER_SANITIZE_FULL_SPECIAL_CHARS)) . $row['salt']);
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
if($adminlevel == "1")
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
}
			else
			{
				?><div class="container" style="width:450px;">
						<div class="alert alert-danger" style="text-align: center;">
						<?php echo $langs->word($dlang,'login_failed'); ?>
						</div>
					</div><?php
				$submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
			}
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
  <body class="hold-transition lockscreen">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
  <div class="lockscreen-logo">
    <a href="index.php"><b>A3 Exile Portal</b>Admin</a>
  </div>
  <!-- User name -->
  <div class="lockscreen-name"> <?php echo $userClass->getUserUsername($AccountID);?></div>

  <!-- START LOCK SCREEN ITEM -->
  <div class="lockscreen-item">
    <!-- lockscreen image -->
    <div class="lockscreen-image">
    		<?php
				    if ($userClass->getUserAvatar($AccountID) == NULL) {
						?><img avatar="<?php echo $userClass->getUserUsername($AccountID);?>"><?php
				    } else {
				    	 ?><img src="<?php echo $INFO['base_url'];?>/<?php echo $userClass->getUserAvatar($AccountID);?>" alt="User Image"><?php
				    }	?>


    </div>
    <!-- /.lockscreen-image -->

    <!-- lockscreen credentials (contains the form) -->
    <form action="lockscreen.php" method="post" class="lockscreen-credentials">
      <div class="input-group">
        <input type="hidden" name="username" value="<?php echo $userClass->getUserUsername($AccountID);?>">
        <input type="password" name=password class="form-control" placeholder="password">

        <div class="input-group-btn">
          <button type="submit" name="submit_lock" class="btn"><i class="fa fa-arrow-right text-muted"></i></button>
        </div>
      </div>
    </form>
    <!-- /.lockscreen credentials -->

  </div>
  <!-- /.lockscreen-item -->
  <div class="help-block text-center">
    Enter your password to retrieve your session
  </div>
  <div class="text-center">
    <a href="lockscreen.php?action=login">Or sign in as a different user</a>
  </div>
</div>
<!-- /.center -->

</body>
</html>
