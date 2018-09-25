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
  if (!$_POST['DBIP'.$k] =="")
  {
  if (!isset($dbhost))
  {
  $dbhost =  $_POST['DBIP'.$k];
  }
  else {
     $dbhost =  $_POST['DBIP'.$k] . "," . $dbhost;
  }
  if (!
    isset($dbschema))
  {
	$dbschema = $_POST['DB_SCHEMA'.$k];
  }
  else{
    	$dbschema = $_POST['DB_SCHEMA'.$k] . "," . $dbschema;
  }
  if (!isset($dbuser))
  {
  $dbuser =  $_POST['DB_user'.$k];
  }
  else {
      $dbuser =  $_POST['DB_user'.$k] . "," . $dbuser;
  }
   if (!isset($dbpass))
  {
  $dbpass =  htmlspecialchars($_POST['DB_pass'.$k]);
  }
  else {
      $dbpass =  htmlspecialchars($_POST['DB_pass'.$k]) . "," . $dbpass;
  }
$dbhost = rtrim($dbhost,',');
$dbschema = rtrim($dbschema,',');
$dbuser = rtrim($dbuser,',');
$dbpass = rtrim($dbpass,',');


}
}
$dbhost = explode(",", $dbhost);
$dbhost = array_reverse($dbhost);
$dbhost = implode(",", $dbhost);
$dbschema = explode(",", $dbschema);
$dbschema = array_reverse($dbschema);
$dbschema = implode(",", $dbschema);
$dbuser = explode(",", $dbuser);
$dbuser = array_reverse($dbuser);
$dbuser = implode(",", $dbuser);
$dbpass = explode(",", $dbpass);
$dbpass = array_reverse($dbpass);
$dbpass = implode(",", $dbpass);
}
else
  {
for ($k = 0 ; $k < $keylimit; $k++){
  if (!$_POST['DBIP'.$k] =="")
  {
  if (!isset($dbhost))
  {
  $dbhost =  $_POST['DBIP'.$k];
  }
  else {
     $dbhost =  $_POST['DBIP'.$k] . "," . $dbhost;
  }
  if (!
    isset($dbschema))
  {
	$dbschema = $_POST['DB_SCHEMA'.$k];
  }
  else{
    	$dbschema = $_POST['DB_SCHEMA'.$k] . "," . $dbschema;
  }
  if (!isset($dbuser))
  {
  $dbuser =  $_POST['DB_user'.$k];
  }
  else {
      $dbuser =  $_POST['DB_user'.$k] . "," . $dbuser;
  }
   if (!isset($dbpass))
  {
  $dbpass =  htmlspecialchars($_POST['DB_pass'.$k]);
  }
  else {
      $dbpass =  htmlspecialchars($_POST['DB_pass'.$k]) . "," . $dbpass;
  }
$dbhost = rtrim($dbhost,',');
$dbschema = rtrim($dbschema,',');
$dbuser = rtrim($dbuser,',');
$dbpass = rtrim($dbpass,',');


}
}
$dbhost = explode(",", $dbhost);
$dbhost = array_reverse($dbhost);
$dbhost = implode(",", $dbhost);
$dbschema = explode(",", $dbschema);
$dbschema = array_reverse($dbschema);
$dbschema = implode(",", $dbschema);
$dbuser = explode(",", $dbuser);
$dbuser = array_reverse($dbuser);
$dbuser = implode(",", $dbuser);
$dbpass = explode(",", $dbpass);
$dbpass = array_reverse($dbpass);
$dbpass = implode(",", $dbpass);
}
		if($settingClass->getSetting("db_host") != $dbhost){
			$settingClass->updateServersetting("db_host", $dbhost);
		}
		if($settingClass->getSetting("db_schema") != $dbschema){
			$settingClass->updateServersetting("db_schema", $dbschema);
		}
			if($settingClass->getSetting("db_user") != $dbuser){
			$settingClass->updateServersetting("db_user", $dbuser);
		}
			if($settingClass->getSetting("db_pass") != $dbpass){
			$settingClass->updateServersetting("db_pass", $dbpass);
		}

			}
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      <?php echo  $langs->word($dlang,'db_config') ;?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php echo  $langs->word($dlang,'home') ;?></a></li>
        <li><?php echo  $langs->word($dlang,'db_main') ;?></li>
        <li class="active"><?php echo  $langs->word($dlang,'db_config') ;?></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
<?php for ($r = 0 ; $r < $keylimit; $r++){ ?>
        <div class="box-body">
         <!-- form start -->
            <form class="form-horizontal" method="POST" action="dbmanager.php">
              <div class="box-body">

                <div class="form-group">
                  <label class="col-sm-4 control-label"><?php echo  $langs->word($dlang,'db_host') ;?></label>
                  <div class="col-sm-5">
                  <input name="DBIP<?php echo $r; ?>" class="form-control"  data-mask value="<?php  if(isset(explode(",",$settingClass->getSetting('db_host'))[$r])){ echo explode(",",$settingClass->getSetting('db_host'))[$r];}?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label"><?php echo  $langs->word($dlang,'db_schema') ;?></label>
                  <div class="col-sm-5">
                  <input name="DB_SCHEMA<?php echo $r; ?>" class="form-control" value="<?php  if(isset(explode(",",$settingClass->getSetting('db_schema'))[$r])){ echo explode(",",$settingClass->getSetting('db_schema'))[$r];}?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label"><?php echo  $langs->word($dlang,'db_user') ;?></label>
                  <div class="col-sm-5">
                  <input name="DB_user<?php echo $r; ?>" class="form-control" value="<?php  if(isset(explode(",",$settingClass->getSetting('db_user'))[$r])){ echo explode(",",$settingClass->getSetting('db_user'))[$r];}?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label"><?php echo  $langs->word($dlang,'db_pass') ;?></label>
                  <div class="col-sm-5">
                  <input name="DB_pass<?php echo $r; ?>" type="password" class="form-control" value="<?php  if(isset(explode(",",$settingClass->getSetting('db_pass'))[$r])){ echo explode(",",$settingClass->getSetting('db_pass'))[$r];}?>">
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