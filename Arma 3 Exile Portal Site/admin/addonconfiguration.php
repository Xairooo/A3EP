<?php
require('header.php');
?>

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
		<?php
		if(!$permClass->checkUserPerms("addon_settings", $AccountID)){
		echo '<div class="container"><h1><center>'.  $langs->word($dlang,'permission_denied') .'</center></h1><div class="alert alert-success" role="alert">'. $langs->word($dlang,'permission_desc') .'</div></div></div>';
		die();
	}
	else {
if(isset($_POST['addonform'])){
if($keylimit > 1)
{
for ($k = 0 ; $k < $keylimit; $k++){
  if (!$_POST['AddonUsername'.$k] =="")
  {
  if (!isset($AddonUsername))
  {
  $AddonUsername =  $_POST['AddonUsername'.$k];
  }
  else {
     $AddonUsername =  $_POST['AddonUsername'.$k] . "," . $AddonUsername;
  }
  if (!
    isset($AddonPassword))
  {
	$AddonPassword = $_POST['AddonPassword'.$k];
  }
  else{
    	$AddonPassword = $_POST['AddonPassword'.$k] . "," . $AddonPassword;
  }
  if (!isset($AddonIp))
  {
$AddonIp = $_POST['AddonIp'.$k];
  }
  else{
      		$AddonIp = $_POST['AddonIp'.$k] . "," . $AddonIp;
  }
  if (!isset($AddonPort))
  {
  $AddonPort = $_POST['AddonPort'.$k];
  }
  else{

		$AddonPort = $_POST['AddonPort'.$k] . "," . $AddonPort;
  }
$AddonUsername = rtrim($AddonUsername,',');
$AddonPassword = rtrim($AddonPassword,',');
$AddonIp = rtrim($AddonIp,',');
$AddonPort = rtrim($AddonPort,',');


}
}
$AddonUsername = explode(",", $AddonUsername);
$AddonUsername = array_reverse($AddonUsername);
$AddonUsername = implode(",", $AddonUsername);
$AddonPassword = explode(",", $AddonPassword);
$AddonPassword = array_reverse($AddonPassword);
$AddonPassword = implode(",", $AddonPassword);
$AddonIp = explode(",", $AddonIp);
$AddonIp = array_reverse($AddonIp);
$AddonIp = implode(",", $AddonIp);
$AddonPort = explode(",", $AddonPort);
$AddonPort = array_reverse($AddonPort);
$AddonPort = implode(",", $AddonPort);
}
else
  {
    $k=0;
      $AddonUsername =  $_POST['AddonUsername'.$k];
  		$AddonPassword = $_POST['AddonPassword'.$k];
		$AddonIp = $_POST['AddonIp'.$k];
		$AddonPort = $_POST['AddonPort'.$k];
}
		if($settingClass->getSetting("addon_username") != $AddonUsername){
			$settingClass->updateServersetting("addon_username", $AddonUsername);
		}
		if($settingClass->getSetting("addon_pass") != $AddonPassword){
			$settingClass->updateServersetting("addon_pass", $AddonPassword);
		}
		if($settingClass->getSetting("addon_ip") != $AddonIp){
			$settingClass->updateServersetting("addon_ip", $AddonIp);
		}
		if($settingClass->getSetting("addon_port") != $AddonPort){
			$settingClass->updateServersetting("addon_port", $AddonPort);
		}

		updateKeyused($key,$u,count($max = explode(',',$settingClass->getSetting("addon_username"))));
			}
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      <?php echo  $langs->word($dlang,'addon_config') ;?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php echo  $langs->word($dlang,'home') ;?></a></li>
        <li><?php echo  $langs->word($dlang,'server_addon') ;?></li>
        <li class="active"><?php echo  $langs->word($dlang,'addon_config') ;?></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
<?php for ($r = 0 ; $r < $keylimit; $r++){ ?>
        <div class="box-body">
         <!-- form start -->
            <form class="form-horizontal" method="POST" action="addonconfiguration.php">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-4 control-label"><?php echo  $langs->word($dlang,'addon_config_username') ;?></label>
                  <div class="col-sm-5">
                 <input name="AddonUsername<?php echo $r; ?>" class="form-control" autocomplete="new-username" value="<?php  if(isset(explode(",",$settingClass->getSetting('addon_username'))[$r])){ echo explode(",",$settingClass->getSetting('addon_username'))[$r];}?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label"><?php echo  $langs->word($dlang,'addon_config_password') ;?></label>
                  <div class="col-sm-5">
                  <input name="AddonPassword<?php echo $r; ?>" type="password" autocomplete="new-password" class="form-control" value="<?php  if(isset(explode(",",$settingClass->getSetting('addon_pass'))[$r])){ echo explode(",",$settingClass->getSetting('addon_pass'))[$r];}?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label"><?php echo  $langs->word($dlang,'addon_config_ip') ;?></label>
                  <div class="col-sm-5">
                  <input name="AddonIp<?php echo $r; ?>" class="form-control"   data-mask value="<?php  if(isset(explode(",",$settingClass->getSetting('addon_ip'))[$r])){ echo explode(",",$settingClass->getSetting('addon_ip'))[$r];}?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label"><?php echo  $langs->word($dlang,'addon_config_port') ;?></label>
                  <div class="col-sm-5">
                  <input name="AddonPort<?php echo $r; ?>" class="form-control" value="<?php  if(isset(explode(",",$settingClass->getSetting('addon_port'))[$r])){ echo explode(",",$settingClass->getSetting('addon_port'))[$r];}?>">
                  </div>
                </div>
              </div>
<?php } ?>
              <!-- /.box-body -->
              <div align="center" class="box-footer">
                <button type="submit" name="addonform" class="btn btn-info "><?php echo  $langs->word($dlang,'submit') ;?></button>
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