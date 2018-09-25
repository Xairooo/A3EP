<?php if(!isset($includelogin)){die("INVALID REQUEST");} ?>
<?php
	if(!empty($_POST)) {
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
							ipaddress,
							steamid
						) VALUES (
							:username,
							:password,
							:salt,
							:lang,
							:email,
							:passwordKey,
							:ipaddress,
							:steamid
						)
					";
					$salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));

					$lang =$settingClass->getdefaultlang();
					$password = hash('sha256', random_int(100, 999) . $salt);
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
						':ipaddress' => $IP,
						':steamid' => $_POST['steamid64']
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
					$query2 = "INSERT INTO ".$tblpre."user_permissions () VALUES ()";
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
					$mailer->validate($uemail,$dname);

					if ($settingClass->getSetting('notify_on_reg') == '1'){
						$uemail = $_POST['email'];
						$dname = $_POST['username'];
						$ausername = $userClass->getUserUsername('1');
						$aemail = $settingClass->getSetting('incoming_email');
						$mailer->newmembernotify($ausername,$aemail,$dname,$uemail,$IP);
					}
$query = "SELECT id FROM ".$tblpre."users WHERE steamid=:steamID";
$query_params = array(":steamID"=> $_POST['steamid64']);
 try {
       $stmt   = $db->prepare($query);
        $result = $stmt->execute($query_params);
        }
        catch (PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }
        $companyname = $stmt->fetch();
         $userid = $companyname['id'];
         $results = $stmt->rowcount();
			if($results > 0){
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
						$queryl = "
							UPDATE ".$tblpre."users
								SET lastlogged = :date
							WHERE
								id = :username
						";

						$query_paramsl = array(
							':date' => date('Y-m-y H:i:s'),
							':username' => $userid
						);

						try
						{
							$stmtl = $db->prepare($queryl);
							$resultl = $stmtl->execute($query_paramsl);
						}
						catch(PDOException $ex)
						{

							die("Failed to run query: " . $ex->getMessage());
						}


						header("Location: ?page=index");
						exit;
			}
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
                </div>
                <div padding-top="30px" class="login_form">
                	<section class="login-wrapper">
                   		<div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                		<form id="loginform" method="post" action="?page=login" class="form-horizontal" style="padding:15px" role="form">
							<input type="hidden" name="action" value="login" >
								<div style="margin-top:10px" class="form-group">
                            <!-- Button -->
                            	<div align="center" class="col-sm-12 controls">

									<?php require ('steamlogintwo.php'); ?>

                                  	<a href='<?php echo $auth->GetLoginURL(); ?>'><img src='https://steamcommunity-a.akamaihd.net/public/images/signinthroughsteam/sits_01.png'></a>

                            	</div>
                                <div align="center" class="form-group">
                                	<div class="col-md-12 control">
                                   		<div style="border-top: 1px solid#888; padding-top:15px; font-size:125%" >
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
                        <form id="signupform" action="?page=login&signup=<?php echo $_GET["signup"]; ?>" method="post" class="form-horizontal" role="form">
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
                                        <?php
	                                        $key = $settingClass->getSteamapi();
											$sapi ="http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".$key."&steamids=".$_GET["signup"];
											$json = file_get_contents($sapi);
											$parsed = json_decode($json);
                                            foreach($parsed->response->players as $player):
                                                $name = $player->personaname;
                                            endforeach;
                                         ?>
                                        <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php echo $name ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-9">
									<div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i><?php echo $langs->word($dlang,'steamid');?></span>
                                        <input type="text" class="form-control" name="steamid64" placeholder="" value="<?php echo $_GET["signup"]; ?> ">
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
<?php  } if($_GET["signup"] != "") { ?>
<script>$('#loginbox').hide(); $('#signupbox').show();</script>
<?php } ?>
