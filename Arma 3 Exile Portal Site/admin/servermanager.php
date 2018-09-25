<?php
  require('header.php');
?>
 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
		<?php
  		if(!$permClass->checkUserPerms("addon_settings", $AccountID)){
		    echo '<div class="container"><h1><center>'.  $langs->word($dlang,'permission_denied') .'</center></h1><div class="alert alert-success" role="alert">'. $langs->word($dlang,'permission_desc') .'</div></div></div>';
    		die();
      } else {
        if(isset($_POST['addonform'])){
          if($keylimit > 1) {
            for ($k = 0 ; $k < $keylimit; $k++){
              if (!$_POST['link_name'.$k] =="") {
                  if (!isset($LinkName)) {
                    $LinkName =  $_POST['link_name'.$k];
                  }
                  else {
                     $LinkName =  $_POST['link_name'.$k] . "," . $LinkName;
                  }
                  if (!isset($LinkDB)) {
                  	$LinkDB = $k;
                  }
                  else {
                  	$LinkDB = $k . "," . $LinkDB;
                  }
                  if (!isset($LinkAddon)) {
                    $LinkAddon = $k;
                  }
                  else{
                		$LinkAddon = $k . "," . $LinkAddon;
                  }
                  $LinkName = rtrim($LinkName,',');
                  $LinkDB = rtrim($LinkDB,',');
                  $LinkAddon = rtrim($LinkAddon,',');
                }
              }
              $LinkDB = explode(",",$LinkDB);
              $LinkAddon = explode(",",$LinkAddon);
              $LinkName = explode(",",$LinkName);
              for ($k = 0 ; $k < count($LinkDB); $k++) {
                if(isset($appen)) {
                  $appen .= ",".$LinkDB[$k]. ":" . $LinkAddon[$k].":".$LinkName[$k];
                }
                else {
                  $appen = $LinkDB[$k]. ":" . $LinkAddon[$k]. ":" . $LinkName[$k];
                }
              }
            $LinkDB = $appen;
            $LinkDB = explode(",", $LinkDB);
            $LinkDB = array_reverse($LinkDB);
            $LinkDB = implode(",", $LinkDB);
          }
          else {
            /*
              $LinkName =  $_POST['link_name'.$k];
            	$LinkDB = $_POST['link_host'.$k].":".$_POST['link_addon'.$k].":".$LinkName;
            	echo $LinkDB;
          	*/
  	        for ($k = 0 ; $k < $keylimit; $k++){
              if (!$_POST['link_name'.$k] =="") {
                if (!isset($LinkName)) {
                  $LinkName =  $_POST['link_name'.$k];
                } else {
                  $LinkName =  $_POST['link_name'.$k] . "," . $LinkName;
                }
                if (!isset($LinkDB)) {
	                $LinkDB = $k;
                } else{
                  $LinkDB = $k . "," . $LinkDB;
                }
                if (!isset($LinkAddon)) {
                  $LinkAddon = $k;
                } else{
      		        $LinkAddon = $k . "," . $LinkAddon;
                }
                $LinkName = rtrim($LinkName,',');
                $LinkDB = rtrim($LinkDB,',');
                $LinkAddon = rtrim($LinkAddon,',');
              }
            }
            $LinkDB = explode(",",$LinkDB);
            $LinkAddon = explode(",",$LinkAddon);
            $LinkName = explode(",",$LinkName);
            for ($k = 0 ; $k < count($LinkDB); $k++) {
              if(isset($appen)) {
                $appen .= ",".$LinkDB[$k]. ":" . $LinkAddon[$k].":".$LinkName[$k];
              } else {
                $appen = $LinkDB[$k]. ":" . $LinkAddon[$k]. ":" . $LinkName[$k];
              }
            }
            $LinkDB = $appen;
            $LinkDB = explode(",", $LinkDB);
            $LinkDB = array_reverse($LinkDB);
            $LinkDB = implode(",", $LinkDB);
          }
          if($settingClass->getSetting("link_ids") != $LinkDB){
			       $settingClass->updateServersetting("link_ids", $LinkDB);
		      }
        }
    ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> <?php echo  $langs->word($dlang,'serv_config') ;?> <small><?php echo  $langs->word($dlang,'serv_note') ;?></small> </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php echo  $langs->word($dlang,'home') ;?></a></li>
        <li><?php echo  $langs->word($dlang,'serv_main') ;?></li>
        <li class="active"><?php echo  $langs->word($dlang,'serv_config') ;?></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="row">
        <?php for ($r = 0 ; $r < $keylimit; $r++){ ?>
          <form class="form-horizontal" method="POST" action="servermanager.php">
            <!-- Left col -->
            <div class="col-md-4">
               <div class="box box">
                <div class="box-header"><?php echo "server: ".$r; ?></div>
                <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-3 control-label"><?php echo  $langs->words($dlang,'serv_name', 0) ;?></label>
                      <div class="col-sm-8">
                        <?php $titles = explode(":",(explode(",",$settingClass->getSetting('link_ids')))[$r]); $title = $titles["2"]; ?>
                        <input name="link_name<?php echo $r; ?>" class="form-control" value="<?php  if(isset($title)){ echo $title;}?>">
                        <p class="small"><?php echo  $langs->words($dlang,'serv_name', 1) ;?></p>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label"><?php echo  $langs->words($dlang,'serv_db_host', 0) ;?></label>
                      <div class="col-sm-8">
                        <?php $title = (explode(",",$settingClass->getSetting('db_schema')))[$r]."@".(explode(",",$settingClass->getSetting('db_host')))[$r]; ?>
  								      <fieldset disabled>
  								        <?php if ($title == "@") { ?>
                          <input name="link_host<?php echo $r; ?>" class="form-control" value="">

                          <?php } else {?>
                          <input  class="form-control" value="<?php  if(isset($title)){ echo $title;}?>">

                          <?php } ?>
                        </fieldset>
                      </div>
                    </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo  $langs->words($dlang,'serv_addon_host', 0) ;?></label>
                            <div class="col-sm-8">
                              <?php
          						          $title = (explode(",",$settingClass->getSetting('addon_username')))[$r]."@".(explode(",",$settingClass->getSetting('addon_ip')))[$r].":".(explode(",",$settingClass->getSetting('addon_port')))[$r];
          								    ?>
								              <fieldset disabled>
								    						<?php if ($title == "@:") { ?>
                                <input name="link_addon<?php echo $r; ?>" class="form-control" value="">

                                <?php } else { ?>
                                <input  class="form-control"  value="<?php  if(isset($title)){ echo $title;}?>">

                                <?php } ?>
                            </div>
                          </div>
        </div>
      </div>
        </div>
<?php } ?>
</div>
              <div align="center" class="box-footer">
                <button type="submit" name="addonform" class="btn btn-info "><?php echo  $langs->word($dlang,'submit') ;?></button>
              </div>
            </form>
        </div>
    </section>
  </div>
<?php
			 }
require('footer.php');?>