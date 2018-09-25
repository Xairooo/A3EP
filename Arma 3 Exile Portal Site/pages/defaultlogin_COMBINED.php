<?php if(!isset($includelogin)){die("INVALID REQUEST");} ?>
<?php
	if(isset($_GET['do']))
	{
		if (($_GET['do'] =='confirm') && !empty($_GET['do']) AND isset($_GET['id']) && !empty($_GET['id'])){
			$id = $_GET['id'];
			$queryv = "UPDATE ".$tblpre."users SET verifypend = 0, verified = 1  WHERE username = :id";
				$query_paramsv = array(
					':id' => $id,
				);
	        try
	        {
	            $stmtv = $db->prepare($queryv);
	            $resultv = $stmtv->execute($query_paramsv);
	        }
	        catch(PDOException $ex)
	        {
	            die("Failed to run query: " . $ex->getMessage());
	        }
		}
	}
	if(!empty($AccountID))
	{
			header("Location: ?page=main");
			exit();
	}
	$query = "
        SELECT
            status
        FROM ".$tblpre."settings
		WHERE name=:status
    ";
    $query_params = array(
		':status' => 'logindisabled'
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

    $row2 = $stmt->fetch();
	$submitted_username = '';

	if(!empty($_POST)) {
		if(ISSET($_POST['submit_login'])){
			$query = "
				SELECT
					id,
					username,
					password,
					salt,
					email,
					admin,
					suspended
				FROM ".$tblpre."users
				WHERE
					username = :username
			";

			$query_params = array(
				':username' => (filter_var($_POST['username'] , FILTER_SANITIZE_FULL_SPECIAL_CHARS))
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

			$login_ok = false;

			$row = $stmt->fetch();
			if($row)
			{
				$check_password = hash('sha256', (filter_var($_POST['password'] , FILTER_SANITIZE_FULL_SPECIAL_CHARS)) . $row['salt']);
				for($round = 0; $round < 65536; $round++)
				{
					$check_password = hash('sha256', $check_password . $row['salt']);
				}

				if($check_password === $row['password'])
				{
					$login_ok = true;
				}
				$adminlevel = "";
				$adminlevel = $row['admin'];
				$userid = $row['id'];
			}

			if($login_ok)
			{
				if($row['suspended'] == 1)
				{
					header("Location: ?page=usersuspended");
					exit;
				}
				else
				{
					unset($row['salt']);
					unset($row['password']);

					 //NEWSESSIONHANDLER
					$query = "UPDATE `".$tblpre."sessions`
						SET accountid = :userid
						WHERE sid = :sid
					";

					$query_params = array(
						':userid' => $userid,
						':sid' => $SID
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

					$query = "
						UPDATE ".$tblpre."users
							SET lastlogged = :date
						WHERE
							id = :username
					";

					$query_params = array(
						':date' => date('Y-m-y H:i:s'),
						':username' => $userid
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
					if ($defaultConstants['COOKIE_PATH']== NULL)
					{
					  $path = "/";
					} else
					{
					  $path = $defaultConstants['COOKIE_PATH'];
					}
					setcookie('a3ep_sessiontimer', $SID, time() + 60 * 30, $path);
					header("Location: ?page=index");
					exit;
				}
			}
			else
			{
				?><div class="container" style="width:450px;">
						<div class="alert alert-danger" style="text-align: center;">
							<div class="alert alert-danger"><?php echo $langs->word($dlang,'login_failed'); ?></div>
						</div>
					</div><?php
				$submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
			}
		}
		if(ISSET($_POST['submit_registration'])) {
			$publickey = $settingClass->getRecaptchaKey("public"); // Get this from google.com/recaptcha
			$privatekey = $settingClass->getRecaptchaKey("private"); // Get this from google.com/recaptcha

			if(!empty($_POST)) {
				$response = $_POST["g-recaptcha-response"];
				$url = 'https://www.google.com/recaptcha/api/siteverify';
				$data = array(
					'secret' => $privatekey,
					'response' => $_POST["g-recaptcha-response"]
				);
				$options = array(
					'http' => array (
						'method' => 'POST',
						'content' => http_build_query($data)
					)
				);
				$context  = stream_context_create($options);
				$verify = file_get_contents($url, false, $context);
				$captcha_success=json_decode($verify);
				if ($captcha_success->success==false)  { ?>
					<div class="container" style="width:450px;">
						<div class="alert alert-danger" style="text-align: center;">
						  <a class="alert-link"><?php echo $langs->word($dlang,'register_error_captcha'); ?></a>
						</div>
					</div>
				<?php
				} else {
					if(empty($_POST['username']))
					{
						die($lang['register_error_enter_user']);
					}
					if(empty($_POST['password']))
					{
						die($lang['register_error_enter_pass']);
					}
					if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
					{
						die($lang['register_error_enter_email']);
					}
					$query = "
						SELECT
							1
						FROM ".$tblpre."users
						WHERE
							username = :username
					";
					$query_params = array(
						':username' => $_POST['username']
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
					if($row)
					{
						die($langs->word($dlang,'register_error_user'));
					}
					$query = "
						SELECT
							1
						FROM ".$tblpre."users
						WHERE
							email = :email
					";

					$query_params = array(
						':email' => $_POST['email']
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

					if($row)
					{
						die($langs->word($dlang,'register_error_email'));
					}
					$query = "
						INSERT INTO ".$tblpre."users (
							username,
							password,
							salt,
							language,
							email,
							passwordKey,
							ipaddress
						) VALUES (
							:username,
							:password,
							:salt,
							:lang,
							:email,
							:passwordKey,
							:ipaddress
						)
					";
					$salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));

					$lang =$settingClass->getdefaultlang();
					$password = hash('sha256', $_POST['password'] . $salt);
					for($round = 0; $round < 65536; $round++)
					{
						$password = hash('sha256', $password . $salt);
					}
					$passwordKey = substr(rtrim(base64_encode(md5(microtime())),"="), 0,25);
					$query_params = array(
						':username' => $_POST['username'],
						':password' => $password,
						':salt' => $salt,
						':email' => $_POST['email'],
						':passwordKey' => $passwordKey,
						':lang' => $lang,
						':ipaddress' => $IP
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

					$query2 = "
							INSERT INTO ".$tblpre."user_permissions (

							) VALUES (

							)
					";
					try
					{
						$stmt2 = $db->prepare($query2);
						$result2 = $stmt2->execute();
					}
					catch(PDOException $ex)
					{
						die("Failed to run query: " . $ex->getMessage());
					}

					$uemail = $_POST['email'];
					$dname = $_POST['username'];
					$ausername = $userClass->getUserUsername('1');
					//validation email
					$mailer->validate($uemail,$dname);

					if ($settingClass->getSetting('notify_on_reg') == '1'){
						$uemail = $_POST['email'];
						$dname = $_POST['username'];
						$ausername = $userClass->getUserUsername('1');
						$aemail = $settingClass->getSetting('incoming_email');
						//notify admin of new reg if enabled
						$mailer->newmembernotify($ausername,$aemail,$dname,$uemail,$IP);
					}
					header("Location: ?page=login");
				}
			}
		}
	} else {
		$publickey = $settingClass->getRecaptchaKey("public"); // Get this from google.com/recaptcha
		$privatekey = $settingClass->getRecaptchaKey("private"); // Get this from google.com/recaptcha
	?>

    <div class="container">
		<div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
			<?php if ($row2['status'] == 1) { ?>

			</div><?php } else { ?>
        	<div class="panel panel-info" >
                <div class="panel-heading">
                    <div class="panel-title"><?php echo $langs->word($dlang,'login_title');?></div>
                    <div style="float:right; font-size: 80%; position: relative; top:-10px">
                    	<a href="?page=forgotPassword"><?php echo $langs->word($dlang,'login_forgot_password');?></a>
                    </div>
                </div>
                <div padding-top="30px" class="login_form">
                	<section class="login-wrapper">
                   		<div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                		<form id="loginform" method="post" action="?page=login" class="form-horizontal" style="padding:15px" role="form">
                    		<div style="margin-bottom: 25px" class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                <input id="login-username" type="text" class="form-control" name="username" value="" placeholder="<?php echo $langs->word($dlang,'login_form_username');?>" autocapitalize="off" autocorrect="off"/>
                            </div>
                    		<div style="margin-bottom: 40px" class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                <input id="login-password" type="password" class="form-control" name="password" placeholder="<?php echo $langs->word($dlang,'login_form_password');?>" />
                            </div>
							<input type="hidden" name="action" value="login" >
								<div style="margin-top:10px" class="form-group">
                            <!-- Button -->
                            	<div align="center" class="col-sm-12 controls">
                                  	<button id="btn-login" type="submit" name="submit_login" class="btn btn-success"><?php echo $langs->word($dlang,'login');?></button>

									<?php require ('steamlogin.php'); ?>

                                  	<a href='<?php echo $auth->GetLoginURL(); ?>'><img src='https://steamcommunity-a.akamaihd.net/public/images/signinthroughsteam/sits_01.png'></a>

                            	</div>
                                <div align="center" class="form-group">
                                	<div class="col-md-12 control">
                                   		<div style="border-top: 1px solid#888; padding-top:15px; font-size:125%" >
											<span class="white"><?php echo $langs->word($dlang,'no_account');?></span>
											<a id="btn-signup" href="?page=login&signup" class="btn btn-signups">  <?php echo $langs->word($dlang,'sign_up');?> </a>
                                    	</div>
                                	</div>
                            	</div>
                        	</div>
                   		</form>
                    </section>
                </div>
            </div> <?php } ?>
        </div>
        <div id="signupbox" style="display:none; margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
    	   <?php
		        $query = "
		            SELECT
		                status
		            FROM ".$tblpre."settings
					WHERE name=:status
		        ";
		        $query_params = array(
					':status' => 'signupdisabled'
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
		        if($row['status'] == 1)
		        {
			?>
			<div class="container" style="width:450px;">
				<div class="alert alert-danger" style="text-align: center;">
				  	<a class="alert-link"><?php echo $langs->word($dlang,'signup_disabled');?></a>
				</div>
			</div>
			<?php } else {?>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title"><?php echo $langs->word($dlang,'register_title');?></div>
                    </div>
                    <div class="panel-body" >
                        <form id="signupform" action="?page=login" method="post" class="form-horizontal" role="form">
                            <script src='https://www.google.com/recaptcha/api.js'></script>
                            <div class="form-group">
                                <div class="col-md-9">
		                            <div style="margin-bottom: 25px" class="input-group">
                                    	<span class="input-group-addon"><i class="fa fa-envelope" aria-hidden="true"></i><?php echo $langs->word($dlang,'register_form_email');?></span>
                                    	<input type="text" class="form-control" id="email" name="email" placeholder="E-mail Address"></br>
										<span width="400" align="left"><div id="statuse"></div></span>
                                	</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-9">
									<div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i><?php echo$langs->word($dlang,'register_form_username');?></span>
                                        <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-9">
									<div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i><?php echo $langs->word($dlang,'register_form_password');?></span>
                                        <input type="password" class="form-control" name="password" placeholder="Password">
										<input type="hidden" name="ipaddress" value="<?php echo $IP;?>">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="action" value="register" >
                            <div align="center" class="form-group">
                            	<div class="g-recaptcha" data-theme="dark" data-sitekey='<?php echo $publickey; ?>'></div></br>
                            </div>
                            <div class="form-group">
                                <!-- Button -->
                                <div class="col-md-offset-3 col-md-9">
                                   <button id="btn-login" type="submit" name="submit_registration" class="btn btn-success"><?php echo $langs->word($dlang,'register_form_button');?> </button>
                                </div>
                            </div>
                            <div style="border-top: 1px solid #999; padding-top:20px"  class="form-group">
                                <div class="col-sm-12 controls">
                               		<div align="center" style="font-size: 100%; position: relative; top:10px">
										<a id="btn-signup" href="?page=login" class="btn btn-signups"><?php echo $langs->word($dlang,'register_form_to_login');?></a>
									</div>
                                </div>
                            </div>
                        </form>
                     </div>
                </div>
    		<?php } ?>
         </div>
    </div>
<?php  } if(ISSET($_GET["signup"])) { ?>
<script>$('#loginbox').hide(); $('#signupbox').show();</script>
<?php } ?>
