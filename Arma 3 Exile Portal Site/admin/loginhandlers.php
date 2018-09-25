<?php

if (isset($_GET["fnc"]))
{
	require('strippedheader.php');
 if(isset($_GET['logoutall'])){

   $query = "
			DELETE FROM `".$tblpre."sessions` WHERE `sid` <> '$SID'
			";

			try
			{
				$stmt = $db->prepare($query);
				$result = $stmt->execute();
			}
			catch(PDOException $ex)
			{
				die("Failed to run query: " . $ex->getMessage());
			}
}
if (isset($_GET['disablelogin']))
 {
 		$loginsettings = $_GET['disablelogin'];
 			if($loginsettings=="true")
	{
		$loginsettings = "1";
	}
	else {
		$loginsettings = "0";
	}
		if($settingClass->getSetting('logindisabled') != $loginsettings){
			$settingClass->updateServersetting('logindisabled', $loginsettings);
		}
 }
 if(isset($_GET['update'])){

	if($_GET["steam"]=="true")
	{
		$resulta[] .= "steam";
	}
	if($_GET["internal"]=="true")
	{
		$resulta[] .= "intergrated";
	}


	echo $settingClass->updateServersetting("login_providers", implode(",",$resulta));
}
}
else{
require('header.php');
?>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
					<?php
	if(!$permClass->checkUserPerms("view_login_handlers", $AccountID)){
		echo '<div class="container"><h1><center>'.  $langs->word($dlang,'permission_denied') .'</center></h1><div class="alert alert-success" role="alert">'. $langs->word($dlang,'permission_desc') .'</div></div></div>';
		die();
	}
	else {?>
	<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
   <?php echo $langs->word($dlang,'login_handlers'); ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php echo $langs->word($dlang,'home'); ?></a></li>
        <li><?php echo $langs->word($dlang,'settings'); ?></li>
        <li class="active"><?php echo $langs->word($dlang,'login_handlers'); ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="box box-primary">
            <div class="box-header with-border">
<div class="box-tools pull-right">
	<button type="button" data-toggle="modal" data-target="#loginsettings" class="btn btn-success"><i class="fa fa-cog"></i> <?php echo $langs->word($dlang,'login_settings'); ?></button>

<button type="button"  data-toggle="modal" data-target="#logoutallusers" class="btn btn-success"><i class="fa fa-lock"></i> <?php echo $langs->word($dlang,'log_out_all_users'); ?></button>
</div><br>  </div>
	<?php
                 $query = "SELECT * FROM ".$tblpre."login_handlers;";
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

?>	<script>
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



<div class="alert alert-success" style="text-align:center;" id="success-alert">
    <button type="button" class="close" data-dismiss="alert">x</button>
	 <strong><?php echo $langs->word($dlang,'all_users_logged_out'); ?></strong>
</div>




                      	<script>
function toggleLogin()
{
var checkboxa = document.getElementById('logindisabled').checked;
$.ajax({
    type: "POST",
    url: "loginhandlers.php?fnc&disablelogin="+checkboxa,
    data: '',
    async: false,
    success: function(msg)
    {
        if(parseInt(msg)!=0)
        {

        }
    }
});
}</script>


	<div class="modal fade in" id="loginsettings" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
												<div class="modal-dialog  modal-lg" role="document">
													<div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="a3lkey"><?php echo $langs->word($dlang,'login_settings'); ?></h4>
      </div>

      <div class="modal-body">
   <div class="form-group">
									<label class="col-sm-3 control-label"><?php echo $langs->word($dlang,'login_disable');?></label>
									<div class="col-sm-5">
<form method="POST" action="">
										<input type="hidden" name="logindisabled" value="0" />
										<input type="checkbox"<?php if ($settingClass->getSetting('logindisabled') =='1'){ echo "checked";} else {}?> autocomplete="off" onchange="toggleLogin()" data-size="small" data-toggle="toggle" id="logindisabled" name="logindisabled" value="1" data-on="<?php echo $langs->word($dlang,'yes');?>" data-off="<?php echo $langs->word($dlang,'no');?>" data-onstyle="success" data-offstyle="danger">
									</div>
								</div>

      </div>
    	<div align="center" style="text-align:center" class="modal-footer">
        <button name="login_settings" data-dismiss="modal" class="btn btn-primary"><?php echo $langs->word($dlang,'save'); ?></button>
      </div>
    </div></form>
												</div>
											</div>

											<div class="modal modal-danger fade in" id="logoutallusers" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
												<div class="modal-dialog  modal-md" role="document">
													<div class="modal-content">
														<div class="modal-body">

															<div class="row">
																<div class="col-md-12">
																	<center> <i class="fa fa-exclamation-triangle fa-5x"></i></center>

																</div>
																<div class="col-lg-9">
																	<span class="lead"><?php echo $langs->word($dlang,'are_you_sure'); ?></span> <br>
																			</div>

															</div>
															<div class="modal-footer">

																  <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $langs->word($dlang,'close'); ?></button>
																  <button type="submit" id="logoutall" onclick="logoutall()" name="logoutall"  data-dismiss="modal" class="btn btn-primary"><?php echo $langs->word($dlang,'ok'); ?></button>
															</div>


														</div>
													</div>
												</div>
											</div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="products-list product-list-in-box">
                  <?php  foreach($rows as $row): ?>
                <li class="item">
                  <div class="product-info">
                    <span class="product-title"><?php echo $row['login_key'];?></span>
                      <div class="pull-right">
                      	<?php
                      		$query = "SELECT status FROM ".$tblpre."settings WHERE name=:status";
	$query_params = array(':status' => 'login_providers');
	try
	{
    	$stmt = $db->prepare($query);
		$result = $stmt->execute($query_params);
	}
	catch(PDOException $ex)
	{
		die("Failed to run query: " . $ex->getMessage());
	}
	$types = $stmt->fetch();
    $type = explode(',',$types["status"]);
    	$login_steam_state="false";
    	$login_internal_state="false";
	if(in_array("steam",$type))
	{
		$login_steam = 'checked="checked"';
		$login_steam_state="true";
	}
	if (in_array("intergrated",$type))
	{
		$login_internal = 'checked="checked"';
			$login_internal_state="true";
	}

                      	?>

                      	<script>
  $(document).ready (function(){
            $("#success-alert").hide();


 });
</script>
                      	<script>
function toggleCheckbox()
{
var checkboxa = document.getElementById('INTERNALLOGIN').checked;
var checkboxb = document.getElementById('STEAMLOGIN').checked;
$.ajax({
    type: "POST",
    url: "loginhandlers.php?fnc&update&steam="+checkboxb+"&internal="+checkboxa,
    data: '',
    async: false,
    success: function(msg)
    {
        if(parseInt(msg)!=0)
        {

        }
    }
});
}</script>
                    <?php if($row['login_key'] == 'Internal'){?><span style="cursor: not-allowed; margin-right:50px" class="label label-success"><?php echo $langs->word($dlang,'locked'); ?></span>
					<input type="checkbox" autocomplete="off" <?php echo $login_internal;?> data-size="small" data-toggle="toggle" onchange="toggleCheckbox(this)" id="INTERNALLOGIN" >
                    <?php }
                    elseif($row['login_key'] == 'Steam'){?><span style="cursor: not-allowed; margin-right:50px" class="label label-success"><?php echo $langs->word($dlang,'locked'); ?></span>
   					<input type="checkbox" autocomplete="off" <?php echo $login_steam;?> data-size="small" data-toggle="toggle" onchange="toggleCheckbox(this)"  id="STEAMLOGIN">
                    <?php }else {
                    if($row['login_enabled'] == '1')
                    {?>
                      <span style="margin-right:50px" class="label label-success"><?php echo $langs->word($dlang,'enabled'); ?></span><button data-toggle="tooltip" title="Edit" role="button" class="btn btn-default"><i data-toggle="modal" data-target="#edit<?php echo $row['login_key'];?>" class="fa fa-pencil"></i></button>
                    <?php }else {?>
                      <span style="margin-right:50px" class="label label-danger"><?php echo $langs->word($dlang,'disabled'); ?></span><button data-toggle="tooltip" title="Edit" role="button" class="btn btn-default"><i data-toggle="modal" data-target="#edit<?php echo $row['login_key'];?>" class="fa fa-pencil"></i></button>
                    <?php

                    }
                 } ;?>
</div>
<script>
function logoutall()
{

$.ajax({
    type: "POST",
    url: "loginhandlers.php?fnc&logoutall",
    data: '',
    async: false,
    success: function(msg)
    {
        if(parseInt(msg)!=0)
        {
			    $("#success-alert").show();
                $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
               $("#success-alert").slideUp(500);
               $("#success-alert").hide();
                })
        }
    }
});
}
</script>
                  </div>
                </li>
                <!-- /.item -->
	<?php endforeach;?>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>


        </section>

</div>

<?php
}

		require('footer.php');
}
?>
