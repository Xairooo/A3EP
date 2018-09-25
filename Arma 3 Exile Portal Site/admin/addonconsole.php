<?php
require('header.php');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<?php
if(!$permClass->checkUserPerms("addon_console", $AccountID)){
echo '<div class="container"><h1><center>'.  $langs->word($dlang,'permission_denied') .'</center></h1><div class="alert alert-success" role="alert">'. $langs->word($dlang,'permission_desc') .'</div></div></div>';
die();
}
else{
//$k=0;
$r=0;
$result = "";
if(isset ($_POST['Submit']))
{
// return a response ===========================================================
// if there are any errors in our errors array, return a success boolean of false
if (empty($_POST['script'])) {
// if there are items in our errors array, return those errors
$error = $langs->words($dlang,'addon_console_errors', 4);
} else {
// if there are no errors process our form, then return a message
$script = $_POST['script'];
$protocol = $_POST['protocol'];
$ap = explode(':', $protocol);
$s = $ap[3];
$user = (explode(",",$settingClass->getSetting('addon_username')))[$s];
$pass = (explode(",",$settingClass->getSetting('addon_pass')))[$s];
$host= (explode(",",$settingClass->getSetting('addon_ip')))[$s];
$port= (explode(",",$settingClass->getSetting('addon_port')))[$s];
$adminuser = $userClass->getUserUsername($AccountID);
$query = http_build_query([
 'script' => $script
]);
    if (!$socket = @fsockopen($host, $port, $errno, $errstr, 3)) {
$result = "Offline";
			 $error = 'unable to connect to server.';
    } else {
    	$curl = curl_init('http://'.$host.'?user='.$user.'&pass='.$pass.'&'.$query);
curl_setopt($curl, CURLOPT_PORT, $port);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, $port);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
$result = curl_exec($curl);
        fclose($socket);
    }
		}
			$ins = "
				INSERT INTO ".$tblpre."rcon_log (
					user,
					script
				) VALUES (
					:username,
					:script
				)
			";
			$query_params = array(
				':username' => $adminuser,
				':script' =>  $script
			);

			try
			{
				$stmt = $db->prepare($ins);
				$resultins = $stmt->execute($query_params);
			}
			catch(PDOException $ex)
			{
				die("Failed to run query: " . $ex->getMessage());
			}



}
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      <?php echo  $langs->word($dlang,'addon_console') ;?> <?php	?>
      </h1>
			<p>
					<?php echo  $langs->word($dlang,'addon_console_note') ;?>
			</p>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php echo  $langs->word($dlang,'home') ;?></a></li>
        <li><?php echo  $langs->word($dlang,'server_addon') ;?> </li>
        <li class="active"><?php echo  $langs->word($dlang,'addon_console') ;?> </li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-body">
         <!-- form start -->
		<div class="content">
			<div class="box-body">
				<br>
				<div id="modal_main" class="box box-success">
					<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title"><?php echo  $langs->word($dlang,'addon_console_title') ;?></h4>
						<div class="input-group" style="width: 100%;">
					</div>
					<div class="modal-body">
						<form style="width: 100%;" method="POST" id="form" action="addonconsole.php">
							<div id="success_alert" class="alert alert-success fade in" style="display:none;">
								<button type="button" id="success_close" class="close">&times;</button>
								<h4 id="success_title"></h4>
								<p id="success_message"></p>
							</div>
							<?php if(isset($error)) { ?>
								<div id="error_alert" class="alert alert-danger fade in" style="display:none;">
								<button type="button" id="error_close" class="close">&times;</button>
								<h4 id="error_title"><?php echo  $langs->word($dlang,'error') ;?></h4>
								<p id="error_message"><?php echo $error;?></p>
							</div>
							<script>	$("#error_alert").show(400);</script>
							<?php };?>
							<span class="input-group-addon sr_label"><?php echo  $langs->word($dlang,'addon_config_ip') ;?></span>
							<div class="input-group" style="width: 100%;">
								<select id="protocol" name="protocol" class="form-control" style="width: 100%;">
								<?php for ($k = 0 ; $k < $keylimit; $k++){
								if (!(explode(",",$settingClass->getSetting('addon_ip')))[$k] ==""){?>
									<option><?php echo "http://" .(explode(",",$settingClass->getSetting('addon_ip')))[$k].":".(explode(",",$settingClass->getSetting('addon_port')))[$k].":".$k?></option>
								<?php }} ?>
								</select>
						</div>
							<br>
							<span class="input-group-addon sr_label"><?php echo  $langs->word($dlang,'addon_console_script') ;?></span>
							<div class="input-group" style="width: 100%;">
								<textarea id="code" class="form-control" name="script"style="resize: both;"></textarea>
							</div>

							<br><br><span class="input-group-addon sr_label"><?php echo  $langs->word($dlang,'addon_console_output') ;?></span>
							<div class="input-group" style="width: 100%;">
								<textarea id="output" class="form-control" style="resize: both; background: white;" readonly="true"><?php echo $result;?></textarea>
							</div>
					</div>
					<div class="modal-footer" style="margin-top: 0px;">
						<button type="submit" class="btn btn-primary" name="Submit"><?php echo  $langs->word($dlang,'addon_console_execute') ;?></button></form>
						<button type="button" class="btn btn-default" onClick="window.location.reload()"><?php echo  $langs->word($dlang,'addon_console_reload') ;?></button>
					</div>
					</div>
				</div>
			</div>
			<div id="modal_loading" class="modal-dialog"  style="display:none;">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Sending RCON Request...</h4>
					</div>
					<div class="modal-body">
						<div class="progress progress-striped active">
							<div class="progress-bar"  role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
								<span class="sr-only">50% Complete</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="push"></div>
		</div>
        </div>
      </div>
    </section>
  </div>
<?php
			 }
require('footer.php');?>