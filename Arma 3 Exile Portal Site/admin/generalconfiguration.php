<?php
require('header.php'); ?>
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
			<?php
	if(!$permClass->checkUserPerms("view_general_config", $AccountID)){
			echo '<div class="container"><h1><center>'.  $langs->word($dlang,'permission_denied') .'</center></h1><div class="alert alert-success" role="alert">'. $langs->word($dlang,'permission_desc') .'</div></div></div>';
		die();
	}
	else {?>
		<?php
				if(isset($_POST['generalform']))
		{

	$ServerName = $_POST['ServerName'];
	$online = $_POST['online'];
	$upgrade_note = $_POST['upgrade_notification'];
	$user_copyright = $_POST['user_copyright'];
		if($settingClass->getSetting("user_copyright") != $user_copyright){
			$settingClass->updateServersetting("user_copyright", $user_copyright);
		}
		if($settingClass->getSetting("servername") != $ServerName){
			$settingClass->updateServersetting("servername", $ServerName);
		}
	if($settingClass->getSetting("portal_online") != $online){
			$settingClass->updateServersetting("portal_online", $online);
		}
	if($settingClass->getSetting("upgrade_notification") != $upgrade_note){
			$settingClass->updateServersetting("upgrade_notification", $upgrade_note);
		}
	if($settingClass->getSetting("offline_message") != $offline_message){
			$settingClass->updateServersetting("offline_message", $offline_message);
		}
	 header("Location: generalconfiguration.php");
        exit;
	}

?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      <?php echo $langs->word($dlang,'general_config'); ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php echo $langs->word($dlang,'home'); ?></a></li>
        <li><?php echo $langs->word($dlang,'settings'); ?></li>
        <li class="active"><?php echo $langs->word($dlang,'general_config'); ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">

        <div class="box-body">
         <!-- form start -->
            <form class="form-horizontal" method="POST" action="generalconfiguration.php">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-4 control-label"><?php echo $langs->word($dlang,'site_name'); ?></label>
                  <div class="col-sm-5">
                 <input name="ServerName" class="form-control" value="<?php echo $settingClass->getSetting('servername'); ?>">
                  </div>
                </div>
               <script type="text/javaScript">

  $(function() {
    $('#online').change(function() {
     $("#offline_message").toggle();
    })
  })

</script>
									<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
 <div class="form-group">
	 <label class="col-sm-4 control-label"><?php echo $langs->word($dlang,'portal_online'); ?></label>
 <div class="col-sm-5">
	<input type="hidden" name="online" value="0" />
<input type="checkbox"<?php if ($settingClass->getSetting('portal_online') =='1'){echo 'checked';} else {};?>  data-toggle="toggle" id="online" name="online" value="1" data-on="Yes" data-off="No" data-onstyle="success" data-offstyle="danger">
	 </div></div>

	     <div class="form-group">
                  <label class="col-sm-4 control-label"><?php echo $langs->word($dlang,'user_copyright'); ?></label>
                  <div class="col-sm-5">
                 <input name="user_copyright" class="form-control" value="<?php echo $settingClass->getSetting('user_copyright'); ?>">
                 <p class="small"> <?php echo $langs->word($dlang,'user_copyright_desc'); ?></p>
                  </div>
                </div>
								 <div class="form-group">
                  <label class="col-sm-4 control-label"><?php echo $langs->word($dlang,'upgrade_notification'); ?></label>
                  <div class="col-sm-5">
                 <input name="upgrade_notification" class="form-control" value="<?php echo $settingClass->getSetting('upgrade_notification'); ?>">
                 <p class="small"> <?php echo $langs->word($dlang,'upgrade_not_desc'); ?></p>
                  </div>
                </div>
							</div>
              <!-- /.box-body -->
              <div align="center" class="box-footer">
                <button type="submit" name="generalform" class="btn btn-info "><?php echo $langs->word($dlang,'save'); ?></button>
              </div>
              <!-- /.box-footer -->
            </form>
        </div>

      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
			 }
require('footer.php');?>