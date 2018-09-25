
<?php if(!isset($include)){die("INVALID REQUEST");} ?><?php

if(!empty($_POST)){
	if(isset($_POST['username']) && isset($_POST['email'])){
		$user = $_POST['username'];
		$email = $_POST['email'];

		if($_GET['action'] == "submit"){
			// Form just submitted
			if($userClass->checkUserAccountExists($user, $email)){
				// Account exists, send email
				// The message
				$userid = $userClass->getUserUserid($user);
				$userKey = $userClass->userEmailResetRequest($userid);
//validation email
$mailer->passwordreset($email,$user,$userKey);
?>

	<div class="container">
		<div style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="panel-title"><?php echo $langs->word($dlang,'forgotten_password');?></div>
				</div>
				<div style="padding-top:30px" class="panel-body">
					<div style="margin-bottom: 25px; color: #BF2700" class="input-group">
						<?php echo $langs->word($dlang,'forgot_account_send');?>
					</div>
					<div style="margin-top:10px">
						<!-- Button -->
						<div class="col-sm-12 controls">
							<button id="btn-login" class="btn btn-success"><a href="?page=forgotPasswordChange" style="color: white"><?php echo $langs->word($dlang,'have_reset_key');?></a></button>
						</div>
					</div>
				</div>
			</div>
		</div>
</div>
	</div>
	<?php
			} else {
			?>
<div class="container">
		<div style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="panel-title"><?php echo $langs->word($dlang,'forgotten_password');?></div>
				</div>
				<div style="padding-top:30px" class="panel-body">
					<div style="margin-bottom: 25px; color: #BF2700">
						<?php echo $langs->word($dlang,'forgot_account_send');?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
			}
		}
	}
} else {
	?>
		<div class="container">

			<div id="forgotpassword" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
				<div class="panel panel-info">
					<div class="panel-heading">
						<div class="panel-title"><?php echo $langs->word($dlang,'forgotten_password');?></div>
					</div>

					<div style="padding-top:30px" class="panel-body">


						<form id="forgotform" method="post" action="?page=forgotPassword&action=submit" class="form-horizontal" role="form">

							<div style="margin-bottom: 25px" class="input-group">
								<span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
								<input type="text" name="username" class="form-control" placeholder="<?php echo $langs->word($dlang,'forgot_user');?>" required> </div>

							<div style="margin-bottom: 25px" class="input-group">
								<span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
								<input type="email" name="email" class="form-control" placeholder="<?php echo $langs->word($dlang,'forgot_email');?>" required> </div>


							<div style="margin-top:10px" class="form-group">
								<!-- Button -->

								<div class="col-sm-12 controls">
									<button id="btn-login" type="submit" name="submit_login" class="btn btn-success"><?php echo $langs->word($dlang,'submit');?></button>

								</div>
							</div>

						</form>



					</div>
				</div>
			</div>
		</div>
		<?php
}
?>