<?php if(!isset($include)){die("INVALID REQUEST");} ?>
<?php

if(!empty($_POST)){
	if(isset($_POST['username']) && isset($_POST['resetKey']) && isset($_POST['password'])){
		$user = $_POST['username'];
		$resetKey = $_POST['resetKey'];
		$password = $_POST['password'];

		if($_GET['action'] == "submit"){
			if($userClass->checkUserAccountExistsByName($user)){
				$userid = $userClass->getUserUserid($user);
				if($userClass->checkUserRequestNewPass($userid)){
					if($userClass->checkUserPasswordReset($userid, $resetKey, $password)){
						?>
						 <div class="container">
<div style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-info" >
                    <div class="panel-heading">
                        <div class="panel-title"><?php echo $langs->word($dlang,'forgotChange_title');?></div>
                          </div><br/>
							<p class="t-cent">	<?php echo $langs->word($dlang,'forgotChange_success');?></p>

                    </div>
        </div>
</div>
<?php
					} else {
								?>
						 <div class="container">
<div style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-info" >
                    <div class="panel-heading">
                        <div class="panel-title"><?php echo $langs->word($dlang,'forgotChange_title');?></div>
                          </div><br/>
							<p class="t-cent">	<?php echo $langs->word($dlang,'forgotChange_error') ;?></p>

                    </div>
        </div>
</div>
<?php
					}
				} else {
									?>
						 <div class="container">
<div style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-info" >
                    <div class="panel-heading">
                        <div class="panel-title"><?php echo $langs->word($dlang,'forgotChange_title');?></div>
                          </div><br/>
							<p class="t-cent">	<?php echo $langs->word($dlang,'forgotChange_error');?></p>

                    </div>
        </div>
</div>
<?php
				}
			} else {
									?>
						 <div class="container">
<div style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-info" >
                    <div class="panel-heading">
                        <div class="panel-title"><?php echo $langs->word($dlang,'forgotChange_title');?></div>
                          </div><br/>
							<p class="t-cent">	<?php echo $langs->word($dlang,'forgotChange_error');?></p>

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
<div style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-info" >
                    <div class="panel-heading">
                        <div class="panel-title">Password Reset</div>
                          </div><br/>
							<p class="t-cent">	<?php echo $langs->word($dlang,'forgotChange_description');?></p>
  <div style="padding-top:15px" class="panel-body" >

 <form method="post" action="?page=forgotPasswordChange&action=submit" class="form-horizontal" role="form">
 <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                       <input type="text" name="username" class="form-control" placeholder="<?php echo $langs->word($dlang,'forgotChange_user');?>" required>   </div>
<div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                       <input type="password" name="password" class="form-control" placeholder="<?php echo $langs->word($dlang,'forgotChange_password');?>" required><br />
			 </div>
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></span>
                                       <input type="text" name="resetKey" class="form-control" placeholder="<?php echo $langs->word($dlang,'forgotChange_key') ;?>" value="<?php echo $_GET['key'];?>" required>  </div>


 <div style="margin-top:10px" class="form-group">
                                    <!-- Button -->

                                    <div class="col-sm-12 controls">
                                      <button id="btn-login" type="submit" name="submit_login" class="btn btn-success"><?php echo $langs->word($dlang,'submit');?></button>

																			<a style="color: white;" href="?page=forgotPassword"><?php echo $langs->word($dlang,'forgot_no_key');?></a>

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
