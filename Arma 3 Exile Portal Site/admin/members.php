<?php require('header.php');?>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<?php
if(isset($_GET['do']))
{
if (($_GET['do'] =='approve') && !empty($_GET['do']) AND isset($_GET['id']) && !empty($_GET['id'])){
		if(!$permClass->checkUserPerms("validate_member", $AccountID)){
echo '
	<div class="container">
		<h1><center>'.  $langs->word($dlang,'permission_denied') .'</center></h1>
		<div class="alert alert-success" role="alert">'. $langs->word($dlang,'permission_desc') .'</div>
	</div>
</div>';
		require('footer.php');
			die();
	} else {
  $id = $_GET['id'];
$query = "
				UPDATE ".$tblpre."users
				SET
					verifypend = 0,
					verified = 1
			";
			$query_params = array(
				':id' => $id,
			);
			$query .= "
				WHERE
					id = :id
			";

			try
			{
				$stmt = $db->prepare($query);
				$result = $stmt->execute($query_params);
			}
			catch(PDOException $ex)
			{
				die("Failed to run query: " . $ex->getMessage());
			}
				header("location: members.php");
}
}
if (($_GET['do'] =='suspend') && !empty($_GET['do']) AND isset($_GET['id']) && !empty($_GET['id'])){
		if(!$permClass->checkUserPerms("suspend_member", $AccountID)){
	echo '
	<div class="container">
		<h1><center>'.  $langs->word($dlang,'permission_denied') .'</center></h1>
		<div class="alert alert-success" role="alert">'. $langs->word($dlang,'permission_desc') .'</div>
	</div>
</div>';require('footer.php');
			die();
	}
	else {
  $id = $_GET['id'];
$query = "
				UPDATE ".$tblpre."users
				SET
					suspended = 1
			";
			$query_params = array(
				':id' => $id,
			);
			$query .= "
				WHERE
					id = :id
			";

			try
			{
				$stmt = $db->prepare($query);
				$result = $stmt->execute($query_params);
			}
			catch(PDOException $ex)
			{
				die("Failed to run query: " . $ex->getMessage());
			}
			header("location: members.php");
}
}
if (($_GET['do'] =='unsuspend') && !empty($_GET['do']) AND isset($_GET['id']) && !empty($_GET['id'])){
		if(!$permClass->checkUserPerms("suspend_member", $AccountID)){
		echo '
	<div class="container">
		<h1><center>'.  $langs->word($dlang,'permission_denied') .'</center></h1>
		<div class="alert alert-success" role="alert">'. $langs->word($dlang,'permission_desc') .'</div>
	</div>
</div>';require('footer.php');
			die();
	}
	else {
  $id = $_GET['id'];
$query = "
				UPDATE ".$tblpre."users
				SET
					suspended = 0
			";
			$query_params = array(
				':id' => $id,
			);
			$query .= "
				WHERE
					id = :id
			";

			try
			{
				$stmt = $db->prepare($query);
				$result = $stmt->execute($query_params);
			}
			catch(PDOException $ex)
			{
				die("Failed to run query: " . $ex->getMessage());
			}
				header("location: members.php");
}
}
if (($_GET['do'] =='delete') && !empty($_GET['do']) AND isset($_GET['id']) && !empty($_GET['id'])){
	if(!$permClass->checkUserPerms("delete_member", $AccountID)){
	echo '
	<div class="container">
		<h1><center>'.  $langs->word($dlang,'permission_denied') .'</center></h1>
		<div class="alert alert-success" role="alert">'. $langs->word($dlang,'permission_desc') .'</div>
	</div>
</div>';	require('footer.php');
			die();
	}
	else {
  $id = $_GET['id'];
$query = "
				DELETE FROM ".$tblpre."users
			";
			$query_params = array(
				':id' => $id,
			);
			$query .= "
				WHERE
					id = :id
			";

			try
			{
				$stmt = $db->prepare($query);
				$result = $stmt->execute($query_params);
			}
			catch(PDOException $ex)
			{
				die("Failed to run query: " . $ex->getMessage());
			}
				header("location: members.php");
}
}
if (($_GET['do'] =='edit') && !empty($_GET['do']) AND isset($_GET['id']) && !empty($_GET['id'])){
	if(!$permClass->checkUserPerms("edit_member", $AccountID)){
	echo '
	<div class="container">
		<h1><center>'.  $langs->word($dlang,'permission_denied') .'</center></h1>
		<div class="alert alert-success" role="alert">'. $langs->word($dlang,'permission_desc') .'</div>
	</div>
</div>';
		require('footer.php');
			die();
	}
	else {
  $id = $_GET['id'];
$submitted_username = '';

        $query = "
         SELECT * FROM ".$tblpre."users INNER JOIN ".$tblpre."user_permissions ON ".$tblpre."users.id=".$tblpre."user_permissions.id
            WHERE
                ".$tblpre."users.id = :id
        ";

        $query_params = array(
            ':id' => $id
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

        $row = $stmt->fetch();
  ?>
<script>
	$(function() {
		$('[data-toggle="tooltip"]').tooltip()
	})
	$(function() {
		var options = {
			placement: function(context, source) {
				var position = $(source).position();

				if (position.left > 515) {
					return "left";
				}

				if (position.left < 515) {
					return "right";
				}

				if (position.top < 110) {
					return "bottom";
				}

				return "top";
			},
			html: true,
			content: function() {
				var id = $(this).attr('id')
				return $('#popover-content-' + id).html();
			}
		};
		$('[data-toggle="popover"]').popover(options)

	})
</script>

<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<br>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> <?php echo $langs->word($dlang,'home');?></a></li>
			<li><?php echo $langs->word($dlang,'members');?></li>
			<li class="active"><?php echo $langs->word($dlang,'editing');?>
				<?php echo $row['username'];?>
			</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content container-fluid">
		<div class="row">
			<div class="col-md-12">
				<!-- Widget: user widget style 1 -->
				<div class="box box-widget widget-user-2" style="height:200px">
					<!-- Add the bg color to the header using any of the bg-* classes -->
					<div class="widget-user-header">
						<div class="widget-user-image" style="width:100px">
							<?php	if ($userClass->getUserAvatar($AccountID) == NULL) {
						?><img width="100" height="100" style="border: 3px solid #d2d6de; width:100; border-radius: 50%" avatar="<?php echo $row['username'];?>">
								<?php
				    } else {
							?><img src="../<?php echo $row['avatar'];?>" class="img-circle" style="border: 3px solid #d2d6de; width:100px" height="100px" width="100px" alt="User Image">
									<?php
				    }	?>
						</div>
						<!-- /.widget-user-image -->
						<h1 class="widget-user-username" style="padding-left:35px;line-height: 1.2;font-weight: 300;font-size: 28px;">
							<?php echo $row['username'];?>
						</h1>
						<p class="widget-user-desc" style="padding-left:35px;line-height: 1.3;font-weight: 300;font-size: 18px;">
							<?php echo $row['email'];?>
						</p>
						<p class="widget-user-desc text-muted" style="padding-left:35px;font-size: 14px;"><?php echo $langs->word($dlang,'joined');?>
							<?php echo date('n/j/Y', strtotime($row['regdate']));?>
						</p>
						<hr>
						<div class="col-xs-12">
							<a tabindex="<?php echo $row['id'];?>" style="margin-right:-15px" id="<?php echo $row['id'];?>" class="btn btn-warning pull-left" data-html="true" role="button" data-toggle="popover" data-trigger="focus" data-container="body"><?php echo $langs->word($dlang,'account_actions');?></a>
							<button type="button" style="margin-right:5px" class="btn btn-default pull-right"><?php echo $langs->word($dlang,'delete');?></button>
							<button type="button" style="margin-right:5px" class="btn btn-default pull-right"><?php echo $langs->word($dlang,'view_profile');?></button>
						</div>
						<div id="popover-content-<?php echo $row['id'];?>" class="hide">

							<ul class="nav nav-stacked">
								<li>
									<?php if ($row['suspended'] =='0'){ ?>
									<a href=""><i class="fa fa-flag-o"></i> <?php echo $langs->word($dlang,'member_suspend');?></a>
									<?php
} else {?> <a href=""><i class="fa fa-flag"></i> <?php echo $langs->word($dlang,'member_unsuspend');?></a>
										<?php } ?>
								</li>

							</ul>
						</div>

					</div>

				</div>
				<!-- /.widget-user -->

			</div>
			<style>
				.Tabs_item {
					line-height: 38px;
					font-size: 14px;
					color: #fff;
					background: rgba(255, 255, 255, 0.1);
					margin-right: 2px;
				}

				.form-group.required .control-label:after {
					content: " *";
					color: red;
				}

				.toggle.ios,
				.toggle-on.ios,
				.toggle-off.ios {
					border-radius: 20px;
				}

				.toggle.ios .toggle-handle {
					border-radius: 20px;
				}
			</style>
		</div>

		<!-- Custom Tabs -->
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs" >
				<li class="Tabs_item active"><a href="#accinfo" data-toggle="tab"><?php echo $langs->word($dlang,'account_info');?></a></li>
				<li class="Tabs_item"><a href="#garagepermissions" data-toggle="tab"><?php echo $langs->word($dlang,'garage_p');?></a></li>
				<li class="Tabs_item"><a href="#inventorypermissions" data-toggle="tab"><?php echo $langs->word($dlang,'inventory_p');?></a></li>
				<li class="Tabs_item"><a href="#territorypermissions" data-toggle="tab"><?php echo $langs->word($dlang,'territory_p');?></a></li>
				<li class="Tabs_item"><a href="#blogpermissions" data-toggle="tab"><?php echo $langs->word($dlang,'blog_p');?></a></li>
				<li class="Tabs_item"><a href="#adminpermissions" data-toggle="tab"><?php echo $langs->word($dlang,'admin_p');?></a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="accinfo">
					<?php
		if(isset($_POST['accountinfoform']))
		{
			$user = $_POST['id'];
				$Username = $_POST['username'];
				$email = $_POST['email'];
				$profile = $_POST['private'];
		$p_offline =  $_POST['p_offline_access'];
		$pm_access = $_POST['pm_access'];
			$pm_send = $_POST['pm_send'];
			$donator = $_POST['donator'];
			$contact_access = $_POST['contact_access'];
		if($row['username'] != $Username){
			$userClass->updateUser($user, "username", $Username);
		}
			if($row['email'] != $email){
			$userClass->updateUser($user, "email", $email);
		}
		if($row['p_offline_access'] != $p_offline){
			$userClass->updateUserPerm($user, "p_offline_access", $p_offline);
		}
		if($row['donator'] != $donator){
			$userClass->updateUser($user, "donator", $donator);
		}
		if($row['private'] != $profile){
			$userClass->updateUser($user, "private", $profile);
		}
		if($row['contact_access'] != $contact_access){
			$userClass->updateUserPerm($user, "contact_access", $contact_access);
		}
			if($row['pm_access'] != $pm_access){
			$userClass->updateUserPerm($user, "pm_access", $pm_access);
			}
			if($row['pm_send'] != $pm_send){
			$userClass->updateUserPerm($user, "pm_send", $pm_send);
			}
	  header("location: members.php?do=edit&id=".$user."");
			}

	?>
						<!-- form start -->
						<form class="form-horizontal" method="POST" action="">
							<div class="box-body">
								<div class="form-group required">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'display_name');?></label>
									<div class="col-sm-4">
										<input type="hidden" name="id" value="<?php echo $row['id'];?>">
										<input name="username" class="form-control" value="<?php echo $row['username'];?>">

									</div>
								</div>
								<div class="form-group required">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'email');?></label>
									<div class="col-sm-4">

										<input name="email" class="form-control" value="<?php echo $row['email'];?>">

									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'password');?></label>

									<div class="col-sm-4">
									<a href="resetpassword.php?do=reset&id=<?php echo $row['id'] ;?>&email=<?php echo $row['email'];?>">Send password Reset</a>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'portal_offline_access');?></label>
									<div class="col-sm-4">
										<input type="hidden" name="p_offline_access" value="0" />
										<input type="checkbox" <?php if ($row[ 'p_offline_access']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="p_offline_access" name="p_offline_access" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success"
										data-offstyle="danger">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'access_pm_system');?></label>
									<div class="col-sm-4">
										<input type="hidden" name="pm_access" value="0" />
										<input type="checkbox" <?php if ($row[ 'pm_access']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="pm_access" name="pm_access" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success" data-offstyle="danger">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'send_pm');?></label>
									<div class="col-sm-4">
										<input type="hidden" name="pm_send" value="0" />
										<input type="checkbox" <?php if ($row[ 'pm_send']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="pm_send" name="pm_send" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success" data-offstyle="danger">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'use_contact');?></label>
									<div class="col-sm-4">
										<input type="hidden" name="contact_access" value="0" />
										<input type="checkbox" <?php if ($row[ 'contact_access']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="contact_access" name="contact_access" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success"
										data-offstyle="danger">
									</div>
								</div>
									<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'profile_privacy');?></label>
									<div class="col-sm-4">
										<input type="hidden" name="profile" value="0" />
										<input type="checkbox" <?php if ($row['private']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="profile" name="profile" value="1" data-on="Private" data-off="Public" data-onstyle="success" data-offstyle="danger">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'donator');?></label>
									<div class="col-sm-4">
										<input type="hidden" name="donator" value="0" />
										<input type="checkbox" <?php if ($row[ 'donator']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="donator" name="donator" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success" data-offstyle="danger">
									</div>
								</div>

							</div>
							<!-- /.box-body -->
							<div align="center" class="box-footer">
								<button type="submit" name="accountinfoform" class="btn btn-info "><?php echo $langs->word($dlang,'save');?></button>
							</div>
							<!-- /.box-footer -->
						</form>

				</div>
				<div class="tab-pane" id="garagepermissions">
					<!-- form start -->
					<?php
		if(isset($_POST['garagepermissionform']))
		{
			$user = $_POST['id'];
		$garage_access = $_POST['garage_access'];
			 $garage_lock_vehicle = $_POST['garage_lock_vehicle'];
			$garage_change_pin = $_POST['garage_change_pin'];
			$manage_garage = $_POST['manage_garage'];
		if($row['garage_access'] != $garage_access){
			$userClass->updateUserPerm($user, "garage_access", $garage_access);
		}
		if($row['garage_lock_vehicle'] != $garage_lock_vehicle){
			$userClass->updateUserPerm($user, "garage_lock_vehicle", $garage_lock_vehicle);
		}
	if($row['garage_change_pin'] != $garage_change_pin){
			$userClass->updateUserPerm($user, "garage_change_pin", $garage_change_pin);
		}
			if($row['manage_garage'] != $manage_garage){
			$userClass->updateUserPerm($user, "manage_garage", $manage_garage);
		}
	  header("location: members.php?do=edit&id=".$user."");

		}
	?>

						<form class="form-horizontal" method="POST" action="">
							<div class="box-header">
								<h2 style="font-size: 20px; font-weight: 500;">

								<?php echo $langs->word($dlang,'garage_p');?>
								</h2>
							</div>
							<div id="garage" class="box-body">

								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'can_access_garage');?></label>
									<div class="col-sm-4">
										<input type="hidden" name="id" value="<?php echo $row['id'];?>">
										<input type="hidden" name="garage_access" value="0" />
										<input type="checkbox" <?php if ($row[ 'garage_access']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="garage_access" name="garage_access" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success" data-offstyle="danger">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'can_lock_vehicle');?></label>
									<div class="col-sm-4">
										<input type="hidden" name="garage_lock_vehicle" value="0" />
										<input type="checkbox" <?php if ($row[ 'garage_lock_vehicle']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="garage_lock_vehicle" name="garage_lock_vehicle" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success"
										data-offstyle="danger">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'can_change_pin');?></label>
									<div class="col-sm-4">
										<input type="hidden" name="garage_change_pin" value="0" />
										<input type="checkbox" <?php if ($row[ 'garage_change_pin']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="garage_change_pin" name="garage_change_pin" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success"
										data-offstyle="danger">
									</div>
								</div>
								<input type="hidden" name="manage_garage" value="0" />
								<?php if ($row['admin']=='1' ){ ?>
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'manage_g_a_settings');?></label>
									<div class="col-sm-4">

										<input type="checkbox" <?php if ($row[ 'manage_garage']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="manage_garage" name="manage_garage" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success" data-offstyle="danger">
									</div>
								</div>
								<?php } else { } ?>
							</div>
							<!-- /.box-body -->
							<div align="center" class="box-footer">
								<button type="submit" name="garagepermissionform" class="btn btn-info "><?php echo $langs->word($dlang,'save');?></button>
							</div>
							<!-- /.box-footer -->
						</form>
				</div>
				<div class="tab-pane" id="inventorypermissions">
					<!-- form start -->
					<?php
					if(isset($_POST['inventorypermissionform']))
		{
			$user = $_POST['id'];
		$inventory_access = $_POST['inventory_access'];
						$manage_inventory = $_POST['manage_inventory'];
		if($row['inventory_access'] != $inventory_access){
			$userClass->updateUserPerm($user, "inventory_access", $inventory_access);
		}
		if($row['manage_inventory'] != $manage_inventory){
			$userClass->updateUserPerm($user, "manage_inventory", $manage_inventory);
		}
	  header("location: members.php?do=edit&id=".$user."");

		}
	?>
						<form class="form-horizontal" method="POST" action="">
							<input type="hidden" name="id" value="<?php echo $row['id'];?>">
							<div class="box-header">
								<h2 style="font-size: 20px; font-weight: 500;">
								<?php echo $langs->word($dlang,'inventory_p');?>
								</h2>
							</div>
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'can_access_inventory');?></label>
									<div class="col-sm-4">
										<input type="hidden" name="inventory_access" value="0" />
										<input type="checkbox" <?php if ($row[ 'inventory_access']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="inventory_access" name="inventory_access" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success" data-offstyle="danger">
									</div>
								</div>
								<input type="hidden" name="manage_inventory" value="0" />
								<?php if ($row['admin']=='1' ){ ?>
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'manage_i_a_settings');?></label>
									<div class="col-sm-4">

										<input type="checkbox" <?php if ($row[ 'manage_inventory']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="manage_inventory" name="manage_inventory" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success" data-offstyle="danger">
									</div>
								</div>
								<?php } else { } ?>
							</div>
							<!-- /.box-body -->
							<div align="center" class="box-footer">
								<button type="submit" name="inventorypermissionform" class="btn btn-info "><?php echo $langs->word($dlang,'save');?></button>
							</div>
							<!-- /.box-footer -->
						</form>
				</div>
				<div class="tab-pane" id="territorypermissions">
					<!-- form start -->
					<?php
					if(isset($_POST['territorypermissionform']))
		{
			$user = $_POST['id'];
		$territory_access = $_POST['territory_access'];
							$manage_territory = $_POST['manage_territory'];
		if($row['territory_access'] != $territory_access){
			$userClass->updateUserPerm($user, "territory_access", $territory_access);
		}
		if($row['manage_territory'] != $manage_territory){
			$userClass->updateUserPerm($user, "manage_territory", $manage_territory);
		}
	  header("location: members.php?do=edit&id=".$user."");

		}
	?>
						<form class="form-horizontal" method="POST" action="">
							<input type="hidden" name="id" value="<?php echo $row['id'];?>">
							<div class="box-header">
								<h2 style="font-size: 20px; font-weight: 500;">
								<?php echo $langs->word($dlang,'territory_p');?>
								</h2>
							</div>
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'can_access_t_c');?></label>
									<div class="col-sm-4">
										<input type="hidden" name="territory_access" value="0" />
										<input type="checkbox" <?php if ($row[ 'territory_access']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="territory_access" name="territory_access" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success" data-offstyle="danger">
									</div>
								</div>
								<input type="hidden" name="manage_territory" value="0" />
								<?php if ($row['admin']=='1' ){ ?>
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'manage_t_c_a_settings');?></label>
									<div class="col-sm-4">

										<input type="checkbox" <?php if ($row[ 'manage_territory']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="manage_territory" name="manage_territory" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success" data-offstyle="danger">
									</div>
								</div>
								<?php } else { } ?>
							</div>
							<!-- /.box-body -->
							<div align="center" class="box-footer">
								<button type="submit" name="territorypermissionform" class="btn btn-info "><?php echo $langs->word($dlang,'save');?></button>
							</div>
							<!-- /.box-footer -->
						</form>
				</div>
				<div class="tab-pane" id="blogpermissions">
					<?php
					if(isset($_POST['blogpermissionform']))
		{
			$user = $_POST['id'];
		$blog_access = $_POST['blog_access'];
		$manage_blog = $_POST['manage_blog'];
		$add_blog_post = $_POST['add_blog_post'];
	  $announcement_access = $_POST['announcement_access'];
		$manage_announcement = $_POST['manage_announcement'];
		$add_announcement = $_POST['add_announcement'];
		if($row['blog_access'] != $blog_access){
			$userClass->updateUserPerm($user, "blog_access", $blog_access);
		}
		if($row['manage_blog'] != $manage_blog){
			$userClass->updateUserPerm($user, "manage_blog", $manage_blog);
		}
						if($row['add_blog_post'] != $add_blog_post){
			$userClass->updateUserPerm($user, "add_blog_post", $add_blog_post);
		}
						if($row['announcement_access'] != $announcement_access){
			$userClass->updateUserPerm($user, "announcement_access", $announcement_access);
		}
						if($row['manage_announcement'] != $manage_announcement){
			$userClass->updateUserPerm($user, "manage_announcement", $manage_announcement);
		}
								if($row['add_announcement'] != $add_announcement){
			$userClass->updateUserPerm($user, "add_announcement", $add_announcement);
		}
	  header("location: members.php?do=edit&id=".$user."");

		}
	?>
						<form class="form-horizontal" method="POST" action="">
							<input type="hidden" name="id" value="<?php echo $row['id'];?>">
							<div class="box-header">
								<h2 style="font-size: 20px; font-weight: 500;">
								<?php echo $langs->word($dlang,'blog_p');?>
								</h2>
							</div>
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'can_access_blog');?></label>
									<div class="col-sm-4">

										<input type="hidden" name="blog_access" value="0" />
										<input type="hidden" name="manage_blog" value="0" />
										<input type="hidden" name="add_blog_post" value="0" />
										<input type="checkbox" <?php if ($row[ 'blog_access']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="blog_access" name="blog_access" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success" data-offstyle="danger">
									</div>
								</div>


								<?php if ($row['admin']=='1' ){ ?>
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'can_manage_blog');?></label>
									<div class="col-sm-4">

										<input type="checkbox" <?php if ($row[ 'manage_blog']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="manage_blog" name="manage_blog" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success" data-offstyle="danger">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'can_add_blog_post');?></label>
									<div class="col-sm-4">

										<input type="checkbox" <?php if ($row[ 'add_blog_post']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="add_blog_post" name="add_blog_post" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success" data-offstyle="danger">
									</div>
								</div>
								<?php } else { } ?>
							</div>
							<!-- /.box-body -->

							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'can_access_announcements');?></label>
									<div class="col-sm-4">
										<input type="hidden" name="announcement_access" value="0" />
										<input type="hidden" name="manage_announcement" value="0" />
										<input type="hidden" name="add_announcement" value="0" />
										<input type="checkbox" <?php if ($row[ 'announcement_access']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="announcement_access" name="announcement_access" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success"
										data-offstyle="danger">
									</div>
								</div>
								<?php if ($row['admin']=='1' ){ ?>
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'can_manage_announcements');?></label>
									<div class="col-sm-4">

										<input type="checkbox" <?php if ($row[ 'manage_announcement']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="manage_announcement" name="manage_announcement" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success"
										data-offstyle="danger">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'can_add_announcements');?></label>
									<div class="col-sm-4">

										<input type="checkbox" <?php if ($row[ 'add_announcement']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="add_announcement" name="add_announcement" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success" data-offstyle="danger">
									</div>
								</div>
								<?php } else { } ?>
							</div>
							<!-- /.box-body -->
							<div align="center" class="box-footer">
								<button type="submit" name="blogpermissionform" class="btn btn-info "><?php echo $langs->word($dlang,'save');?></button>
							</div>
							<!-- /.box-footer -->
						</form>
				</div>
				<div class="tab-pane" id="adminpermissions">
					<!-- form start -->
					<?php
					if(isset($_POST['adminsettingsform']))
		{
			$user = $_POST['id'];
						$admin = $_POST['admin'];
						$view_security_center = $_POST['view_security_center'];
						$view_enhancements = $_POST['view_enhancements'];
						$view_general_config = $_POST['view_general_config'];
						$create_member = "0";
						$view_lkey = $_POST['view_lkey'];
						$view_lhandlers = $_POST['view_login_handlers'];
						$edit_member = $_POST['edit_member'];
						$edit_admin = $_POST['edit_admin'];
						$delete_member = $_POST['delete_member'];
						$delete_admin = $_POST['delete_admin'];
						$suspend_member = $_POST['suspend_member'];
						$validate_member = $_POST['validate_member'];
						$registration_settings = $_POST['registration_settings'];
						$spam_settings = $_POST['spam_settings'];
						$addon_settings = $_POST['addon_settings'];
						$addon_console = $_POST['addon_console'];
						$mange_images = $_POST['mange_images'];
						$support = $_POST['support'];
						$submit_support = $_POST['submit_support'];
					if($row['admin'] != $admin){
			$userClass->updateUser($user, "admin", $admin);
		}
		if($row['view_security_center'] != $view_security_center){
			$userClass->updateUserPerm($user, "view_security_center", $view_security_center);
		}
	if($row['view_login_handlers'] != $view_lhandlers){
			$userClass->updateUserPerm($user, "view_login_handlers", $view_lhandlers);
		}
		if($row['view_enhancements'] != $view_enhancements){
			$userClass->updateUserPerm($user, "view_enhancements", $view_enhancements);
		}
		if($row['view_general_config'] != $view_general_config){
			$userClass->updateUserPerm($user, "view_general_config", $view_general_config);
		}
		if($row['view_lkey'] != $view_lkey){
			$userClass->updateUserPerm($user, "view_lkey", $view_lkey);
		}
		if($row['create_member'] != $create_member){
			$userClass->updateUserPerm($user, "create_member", $create_member);
		}
		if($row['edit_member'] != $edit_member){
			$userClass->updateUserPerm($user, "edit_member", $edit_member);
		}
		if($row['edit_admin'] != $edit_admin){
			$userClass->updateUserPerm($user, "edit_admin", $edit_admin);
		}
		if($row['delete_admin'] != $delete_admin){
			$userClass->updateUserPerm($user, "delete_admin", $delete_admin);
		}
		if($row['delete_member'] != $delete_member){
			$userClass->updateUserPerm($user, "delete_member", $delete_member);
		}
	  if($row['suspend_member'] != $suspend_member){
			$userClass->updateUserPerm($user, "suspend_member", $suspend_member);
		}
		if($row['validate_member'] != $validate_member){
			$userClass->updateUserPerm($user, "validate_member", $validate_member);
		}
		if($row['registration_settings'] != $registration_settings){
			$userClass->updateUserPerm($user, "registration_settings", $registration_settings);
		}
		if($row['spam_settings'] != $spam_settings){
			$userClass->updateUserPerm($user, "spam_settings", $spam_settings);
		}
		if($row['addon_settings'] != $addon_settings){
			$userClass->updateUserPerm($user, "addon_settings", $addon_settings);
		}
		if($row['addon_console'] != $addon_console){
			$userClass->updateUserPerm($user, "addon_console", $addon_console);
		}
		if($row['mange_images'] != $mange_images){
			$userClass->updateUserPerm($user, "manage_images", $mange_images);
		}
			if($row['support'] != $support){
			$userClass->updateUserPerm($user, "support", $support);
		}
			if($row['submit_support'] != $submit_support){
			$userClass->updateUserPerm($user, "submit_support", $submit_support);
		}

						header("location: members.php?do=edit&id=".$user."");

		}
	}
	?>
						<form class="form-horizontal" method="POST" action="">
							<input type="hidden" name="id" value="<?php echo $row['id'];?>">
							<div class="box-header">
								<h2 style="font-size: 20px; font-weight: 500;">
									<?php echo $langs->word($dlang,'admin_settings');?>
								</h2>
								<?php echo $langs->word($dlang,'admin_settings_desc');?>
							</div>
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'is_admin');?></label>
									<div class="col-sm-4">
										<input type="hidden" name="admin" value="0" />
										<input type="checkbox" <?php if ($row[ 'admin']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="admin" name="admin" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success" data-offstyle="danger">
									</div>
								</div>

							</div>
							<div class="box-header">
								<h2 style="font-size: 20px; font-weight: 500;">
									<?php echo $langs->word($dlang,'system_p');?>
								</h2>
							</div>
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'can_view_security');?></label>
									<div class="col-sm-4">
										<input type="hidden" name="view_security_center" value="0" />
										<input type="checkbox" <?php if ($row[ 'view_security_center']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="view_security_center" name="view_security_center" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>"
										data-onstyle="success" data-offstyle="danger">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'can_view_general_config');?></label>
									<div class="col-sm-4">
										<input type="hidden" name="view_general_config" value="0" />
										<input type="checkbox" <?php if ($row[ 'view_general_config']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="view_general_config" name="view_general_config" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>"
										data-onstyle="success" data-offstyle="danger">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'can_view_enhancements');?></label>
									<div class="col-sm-4">
										<input type="hidden" name="view_enhancements" value="0" />
										<input type="checkbox" <?php if ($row[ 'view_enhancements']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="view_enhancements" name="view_enhancements" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success"
										data-offstyle="danger">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'can_view_l_data');?></label>
									<div class="col-sm-4">
										<input type="hidden" name="view_lkey" value="0" />
										<input type="checkbox" <?php if ($row[ 'view_lkey']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="view_lkey" name="view_lkey" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success" data-offstyle="danger">
									</div>
								</div>
									<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'can_view_login_handlers');?></label>
									<div class="col-sm-4">
										<input type="hidden" name="view_login_handlers" value="0" />
										<input type="checkbox" <?php if ($row[ 'view_login_handlers']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="view_login_handlers" name="view_login_handlers" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>"
										data-onstyle="success" data-offstyle="danger">
									</div>
								</div>
									<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'can_view_support_tools');?></label>
									<div class="col-sm-4">
										<input type="hidden" name="support" value="0" />
										<input type="checkbox" <?php if ($row[ 'support']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="support" name="support" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>"
										data-onstyle="success" data-offstyle="danger">
									</div>
								</div>
									<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'submit_ticket');?></label>
									<div class="col-sm-4">
										<input type="hidden" name="submit_support" value="0" />
										<input type="checkbox" <?php if ($row[ 'submit_support']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="submit_support" name="submit_support" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>"
										data-onstyle="success" data-offstyle="danger">
									</div>
								</div>
							</div>
							<div class="box-header">
								<h2 style="font-size: 20px; font-weight: 500;">
								<?php echo $langs->word($dlang,'member_p');?>
								</h2>
							</div>
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'can_edit_members');?></label>
									<div class="col-sm-4">
										<input type="hidden" name="edit_member" value="0" />
										<input type="checkbox" <?php if ($row[ 'edit_member']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="edit_member" name="edit_member" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success"
										data-offstyle="danger">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'can_edit_admins');?></label>
									<div class="col-sm-4">
										<input type="hidden" name="edit_admin" value="0" />
										<input type="checkbox" <?php if ($row[ 'edit_admin']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="edit_admin" name="edit_admin" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success" data-offstyle="danger">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'can_delete_members');?></label>
									<div class="col-sm-4">
										<input type="hidden" name="delete_member" value="0" />
										<input type="checkbox" <?php if ($row[ 'delete_member']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="delete_member" name="delete_member" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success"
										data-offstyle="danger">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'can_delete_admins');?></label>
									<div class="col-sm-4">
										<input type="hidden" name="delete_admin" value="0" />
										<input type="checkbox" <?php if ($row[ 'delete_admin']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="delete_admin" name="delete_admin" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success"
										data-offstyle="danger">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'can_s_us_members');?></label>
									<div class="col-sm-4">
										<input type="hidden" name="suspend_member" value="0" />
										<input type="checkbox" <?php if ($row[ 'suspend_member']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="suspend_member" name="suspend_member" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success"
										data-offstyle="danger">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'manage_validations');?></label>
									<div class="col-sm-4">
										<input type="hidden" name="validate_member" value="0" />
										<input type="checkbox" <?php if ($row[ 'validate_member']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="validate_member" name="validate_member" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success"
										data-offstyle="danger">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'can_manage_reg_settings');?></label>
									<div class="col-sm-4">
										<input type="hidden" name="registration_settings" value="0" />
										<input type="checkbox" <?php if ($row[ 'registration_settings']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="registration_settings" name="registration_settings" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>"
										data-onstyle="success" data-offstyle="danger">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'can_manage_spam_settings');?></label>
									<div class="col-sm-4">
										<input type="hidden" name="spam_settings" value="0" />
										<input type="checkbox" <?php if ($row[ 'spam_settings']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="spam_settings" name="spam_settings" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success"
										data-offstyle="danger">
									</div>
								</div>
							</div>
							<!-- /.box-body -->
							<div class="box-header">
								<h2 style="font-size: 20px; font-weight: 500;">
								<?php echo $langs->word($dlang,'exile_server_settings');?>
								</h2>

							</div>
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'can_manage_addon_settings');?></label>
									<div class="col-sm-4">
										<input type="hidden" name="addon_settings" value="0" />
										<input type="checkbox" <?php if ($row[ 'addon_settings']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="addon_settings" name="addon_settings" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success"
										data-offstyle="danger">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'can_view_addon_console');?></label>
									<div class="col-sm-4">
										<input type="hidden" name="addon_console" value="0" />
										<input type="checkbox" <?php if ($row[ 'addon_console']=='1' ){echo 'checked';} else {};?> data-size="small" data-toggle="toggle" id="addon_console" name="addon_console" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success"
										data-offstyle="danger">
									</div>
								</div>

							</div>
							<div align="center" class="box-footer">
								<button type="submit" name="adminsettingsform" class="btn btn-info "><?php echo $langs->word($dlang,'save');?></button>
							</div>
							<!-- /.box-footer -->
						</form>
				</div>

			</div>
			<!-- /.tab-content -->
		</div>
		<!-- nav-tabs-custom -->
	</section>
</div>
<?php
} else {}
} else {
?>
	<script>
		$(document).ready(function() {
			$('#memberlist').DataTable({
				'paging': true,
				'lengthChange': true,
				'searching': true,
				'ordering': true,
				'info': true,
				'autoWidth': true
			})
		})
	</script>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
			<?php echo $langs->word($dlang,'manage_members');?>

			</h1>
			<ol class="breadcrumb">
				<li><a href="index.php"><i class="fa fa-dashboard"></i> <?php echo $langs->word($dlang,'home');?></a></li>
				<li><?php echo $langs->word($dlang,'members');?></li>
				<li class="active"><?php echo $langs->word($dlang,'manage_members');?></li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content container-fluid">

			<div class="row">
				<div class="col-xs-12">


					<div class="box">
						<div class="box-header">
							<h3 class="box-title"><?php echo $langs->word($dlang,'members');?></h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body scroll_body">
							<table id="memberlist" class="table table-striped table-condensed dataTable no-footer" style="overflow: scroll;">
								<thead>
									<tr>
										<th></th>
										<th><?php echo $langs->word($dlang,'display_name');?></th>
										<th><?php echo $langs->word($dlang,'email');?></th>
										<th><?php echo $langs->word($dlang,'joined');?></th>
										<th><?php echo $langs->word($dlang,'ip_address');?></th>
										<th style="width:130px"></th>
									</tr>
								</thead>
								<tbody>
									<?php
                 $query = "SELECT * FROM ".$tblpre."users;";
    try
    {
        $stmt = $db->prepare($query);
        $stmt->execute();
    }
    catch(PDOException $ex)
    {
        die("Failed to run query: " . $ex->getMessage());
    }

    $rows = $stmt->fetchAll();

?>
										<script>
											$(function() {
												$('[data-toggle="tooltip"]').tooltip()
											})
											$(function() {
												var options = {
													placement: function(context, source) {
														var position = $(source).position();

														if (position.left > 515) {
															return "left";
														}

														if (position.left < 515) {
															return "right";
														}

														if (position.top < 110) {
															return "bottom";
														}

														return "top";
													},
													html: true,
													content: function() {
														var id = $(this).attr('id')
														return $('#popover-content-' + id).html();
													}
												};
												$('[data-toggle="popover"]').popover(options)

											})
										</script>
										<?php  foreach($rows as $row): ?>
										<tr>
											<td>
												<?php	if ($userClass->getUserAvatar($row['id']) == NULL) {
						?><img width="34" height="34" class="img-circle" avatar="<?php echo $row['username'];?>">
													<?php
				    } else {
							?><img src="../<?php echo $row['avatar'];?>" class="img-circle" style="height:34px; width:34px" alt="User Image">
														<?php
				    }	?>
											</td>
											<td>
												<?php echo htmlentities($row['username'], ENT_QUOTES, 'UTF-8');?>
											</td>
											<td>
												<?php if($row['verified'] =='0'){ ?>
												<span class="text-red">
                       <i class="fa fa-warning"></i> <?php echo $row['email'];?>
                       </span><br><span><small><?php echo $langs->word($dlang,'user_no_email_respond');?></small></span>
												<?php } else {  echo $row['email']; } ?>


											</td>

											<td>
												<?php echo date('F j, Y', strtotime($row['regdate']));?>
											</td>
											<td>
	<?php echo $row['ipaddress'];?>
											</td>
											<div class="modal fade" id="delete<?php echo $row['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-body">

															<div class="row">
																<div class="col-md-3">
																	<center> <i class="fa fa-exclamation-triangle fa-5x"></i></center>
																</div>
																<div class="col-md-9">
																	<span class="lead"><?php echo $langs->words($dlang,'delete_warning',0);?> <?php echo $row['username']."'";?><?php echo $langs->words($dlang,'delete_warning',1);?></span> <br>
																	<span class="text-muted"><?php echo $langs->word($dlang,'delete_warning_con');?></span>
																</div>

															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																<a href="members.php?do=delete&id=<?php echo $row['id'];?>" type="button" class="btn btn-primary">OK</a>
															</div>
														</div>
													</div>
												</div>
											</div>
											<?php if ($row['verified'] =='0'){ ?>
											<td>
												<a href="members.php?do=approve&id=<?php echo $row['id'];?>" role="button" data-toggle="tooltip" title="Approve" class="btn btn-success"><i class="fa fa-check-circle fa-lg"></i></a>
												<button data-toggle="tooltip" title="Delete" role="button" class="btn btn-danger"><i data-toggle="modal" data-target="#delete<?php echo $row['id'];?>" class="fa fa-times-circle fa-lg"></i></button>
												<a tabindex="<?php echo $row['id'];?>" id="<?php echo $row['id'];?>" class="btn btn-default" data-html="true" role="button" data-toggle="popover" data-trigger="focus" data-container="body">
                        <i class="fa fa-angle-down fa-lg"></i></a>
											</td>
											<div id="popover-content-<?php echo $row['id'];?>" class="hide">

												<ul class="nav nav-stacked">
													<li><a href="members.php?do=resend&id=<?php echo $row['id'];?>"><i class="fa fa-envelope-o"></i> <?php echo $langs->word($dlang,'resend_email_validation');?></a></li>
													<li><a href="members.php?do=edit&id=<?php echo $row['id'];?>"><i class="fa fa-pencil"></i> <?php echo $langs->word($dlang,'edit');?></a></li>
													<li>
														<?php if ($row['suspended'] =='0'){ ?>
														<a href="members.php?do=suspend&id=<?php echo $row['id'];?>"><i class="fa fa-flag-o"></i> <?php echo $langs->word($dlang,'member_suspend');?></a>
														<?php
} else {?> <a href="members.php?do=unsuspend&id=<?php echo $row['id'];?>"><i class="fa fa-flag"></i> <?php echo $langs->word($dlang,'member_unsuspend');?></a>
															<?php } ?>
													</li>

												</ul>
											</div>

											<?php } else if ($row['admin'] =='1') { ?>
											<td>
												<a href="members.php?do=edit&id=<?php echo $row['id'];?>" role="button" data-toggle="tooltip" title="Edit" class="btn btn-default"><i class="fa fa-pencil fa-lg"></i></a>
											</td>
											<?php
} else {?>
												<td>
													<a href="members.php?do=edit&id=<?php echo $row['id'];?>" role="button" data-toggle="tooltip" title="Edit" class="btn btn-default"><i class="fa fa-pencil fa-lg"></i></a>
													<?php if ($row['suspended'] =='0'){ ?>
													<a href="members.php?do=suspend&id=<?php echo $row['id'];?>" role="button" data-toggle="tooltip" title="Suspend" class="btn btn-warning"><i class="fa fa-flag-o fa-lg"></i></a>
													<?php } else {?>
													<a href="members.php?do=unsuspend&id=<?php echo $row['id'];?>" role="button" data-toggle="tooltip" title="Unsuspend" class="btn btn-warning"><i class="fa fa-flag fa-lg fa-inverse"></i></a>
													<?php
                        } ?>
														<button data-toggle="tooltip" title="Delete" role="button" class="btn btn-danger"><i data-toggle="modal" data-target="#delete<?php echo $row['id'];?>" class="fa fa-times-circle fa-lg"></i></button>
												</td>
												<?php } ?>







										</tr>
										<?php endforeach;?>
								</tbody>
								<tfoot>
									<tr>
											<th></th>
										<th><?php echo $langs->word($dlang,'display_name');?></th>
										<th><?php echo $langs->word($dlang,'email');?></th>
										<th><?php echo $langs->word($dlang,'joined');?></th>
										<th><?php echo $langs->word($dlang,'ip_address');?></th>
										<th style="width:130px"></th>
									</tr>
								</tfoot>
							</table>
						</div>
						<!-- /.box-body -->
					</div>
					<!-- /.box -->
				</div>
				<!-- /.col -->
			</div>


		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
	<!--/Edit member page-->







	<?php } ?>


	<?php require('footer.php'); ?>