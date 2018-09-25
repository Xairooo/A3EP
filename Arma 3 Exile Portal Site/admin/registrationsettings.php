<?php
require('header.php');
?>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
	<?php
	if(!$permClass->checkUserPerms("registration_settings", $AccountID)){
		echo '<div class="container"><h1><center>'.  $langs->word($dlang,'permission_denied') .'</center></h1><div class="alert alert-success" role="alert">'. $langs->word($dlang,'permission_desc') .'</div></div></div>';
		die();
	}
	else {?>
  <section class="content-header">
    <h1>
     <?php echo $langs->word($dlang,'registration_settings'); ?>
    </h1>
    <ol class="breadcrumb">
      <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php echo $langs->word($dlang,'home'); ?></a></li>
      <li><?php echo $langs->word($dlang,'members'); ?></li>
      <li class="active"><?php echo $langs->word($dlang,'registration_settings'); ?></li>
    </ol>
  </section>
 <?php if (isset($_POST['registration_settings']))
 {
 		$signupdisabled = $_POST['signupdisabled'];
		if($settingClass->getSetting('signupdisabled') != $signupdisabled){
			$settingClass->updateServersetting('signupdisabled', $signupdisabled);
		}
 	$reg_notify = $_POST['notify_on_reg'];
		if($settingClass->getSetting('notify_on_reg') != $reg_notify){
			$settingClass->updateServersetting('notify_on_reg', $reg_notify);
		}
 } ?>
  <!-- Main content -->
 <section class="content">

      <!-- Default box -->
     <div class="box box-default">
                    <div class="box-header">
                        <h3 class="box-title">	<?php echo $langs->word($dlang,'account_info');?></h3>
                    </div><!-- /.box-header --><br>
                    <form class="form-horizontal" method="POST" action="">
<div class="box-body">
								<div class="form-group required">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'allow_new_registrations');?></label>
									<div class="col-sm-4">
									<input type="hidden" name="signupdisabled" value="1" />
										<input type="checkbox"<?php if ($settingClass->getSetting('signupdisabled') =='0'){echo "checked";} else {}?> data-size="small" data-toggle="toggle" id="signupdisabled" name="signupdisabled" value="0" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success" data-offstyle="danger">

									</div>
								</div>
								<div class="form-group required">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'notify_on_reg');?></label>
									<div class="col-sm-4">

									<input type="hidden" name="notify_on_reg" value="0" />
										<input type="checkbox"<?php if ($settingClass->getSetting('notify_on_reg') =='1'){ echo "checked";} else {}?> data-size="small" data-toggle="toggle" id="notify_on_reg" name="notify_on_reg" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success" data-offstyle="danger">
                                        <br><?php echo $langs->word($dlang,'notify_on_reg_desc');?></div>
								</div>




							</div>
							<!-- /.box-body -->
							<div align="center" class="box-footer">
								<button type="submit" name="registration_settings" class="btn btn-info "><?php echo $langs->word($dlang,'save');?></button>
							</div>
							<!-- /.box-footer -->
						</form>


                    <!-- /.box-body -->
                </div>
      <!-- /.box -->

    </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php
	}
require('footer.php');
?>