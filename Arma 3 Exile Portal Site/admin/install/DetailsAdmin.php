<?php
;

if($_POST["status"]!="Details Admin")
{?>
  <script>
    window.location.replace("index.php");
  </script>
  <?php
}
else{
if($_POST["dbpost"]=="1")
{
	$values = array( 'admin_user' => $_POST['admin_user'],
  'admin_pass' => $_POST['admin_pass1'],
  'admin_email' => $_POST['admin_email']);

	$INFO = NULL;
				require ('../../extra/config.php');
				$INFO = array_merge( $INFO, $values );

				$toWrite = "<?php\n\n" . '$INFO = ' . var_export( $INFO, TRUE ) . ';';
$file = file_put_contents( '../../extra/config.php', $toWrite );


		?>
    <form name="myForm" id="1232" action="install.php" method="POST">
      <input name="status" value="Install" type="hidden" />
			<input name="installerstart" value="1" type="hidden" />
      <input type="submit" value="Submit" type="hidden" />
    </form>
    <script>
      document.getElementById("1232").submit();
       document.getElementById("1232").click();
    </script>
    <?php
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Admin</title>
	<link rel='stylesheet' href='css/reset.css' media='all'>
	<link rel='stylesheet' href='css/fonts.css' media='all'>
	<link rel='stylesheet' href='css/global.css' media='all'>
	<link rel='stylesheet' href='css/layout.css' media='all'>
	<link rel='stylesheet' href='css/messages.css' media='all'>
	<link rel='stylesheet' href='css/misc.css' media='all'>
	<link rel='stylesheet' href='css/forms.css' media='all'>
	<link rel='stylesheet' href='css/typography.css' media='all'>
	<link rel='stylesheet' href='css/buttons.css' media='all'>
	<link rel='stylesheet' href='css/installer.css' media='all'>

	<!-- FAVICON SECTION -->

	<link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
	<link rel="manifest" href="favicon/manifest.json">
	<link rel="mask-icon" href="favicon/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="theme-color" content="#ffffff">

	<!-- FAVICON SECTION END -->
		<script type="text/javascript">
			var a3_TIMEOUT = 30;
			var check = function() {
  if (document.getElementById('admin_pass1').value ==
    document.getElementById('admin_pass2').value) {
    	document.getElementById('message').style.color = 'green';
    document.getElementById('message').innerHTML = 'matching';
    }
   else {
    document.getElementById('message').style.color = 'red';
    document.getElementById('message').innerHTML = 'not matching';
  }
}
		</script>

		<script src="js/jquery.min.js"></script>
		<script src="js/multipleRedirect.js"></script>
	</head>
	<body class='App App_installer'>

		<div id='elInstaller_wrap'>
			<div id='Layout_header' class='Clearfix' role='banner'>
				<header>
					<a href='/' id='elSiteTitle'><span id='elLogo'><img src='img/logo.png' alt=''></span>Install A3 Exile Portal</a>

				</header>
			</div>
			<main id='elInstaller_body'>

					<div class='Pad AreaBackground_light'>
						<h1 class='Type_pageTitle'>
							Step: Admin
						</h1>
					</div>
					<div class='Columns Pad'>
						<div class='Column Column_wide Pad' id='elInstaller_stepsWrap'>
							<ul id='elInstaller_steps'>

									<li class='elInstaller_stepDone'>
										<i class='fa fa-check'></i>&nbsp;&nbsp;System Check
									</li>

									<li class='elInstaller_stepDone'>
										<i class='fa fa-check'></i>&nbsp;&nbsp;License
									</li>

									<li class='elInstaller_stepDone'>
										<i class='fa fa-check'></i>&nbsp;&nbsp;Server Details
									</li>
								<li class='elInstaller_stepDone'>
                <i class='fa fa-check'></i>&nbsp;&nbsp;Portal Settings
              </li>
									<li class='elInstaller_stepActive'>
										<i class='fa fa-circle'></i>&nbsp;&nbsp;Admin
									</li>

									<li class=''>
										<i class='fa fa-circle-o'></i>&nbsp;&nbsp;Install
									</li>

							</ul>
						</div>
						<div class='Column Column_fluid'>
							<div class='Pad'>

<form action="DetailsAdmin.php" method="post" enctype="multipart/form-data">

	<ul class='Form Form_horizontal'>

<li id="admin_admin_user" class='FieldRow'>
	<label class='FieldRow_label '>
		Display Name <span class='FieldRow_required'>required</span>
	</label>
	<div class='FieldRow_content'>


<input type="text" name="admin_user" value="" required class="input_text"/>
<br />

			<span class='Type_warning'></span>

	</div>
</li>
<li id="admin_admin_pass1" class='FieldRow'>
	<label class='FieldRow_label '>
		Password <span class='FieldRow_required'>required</span>
	</label>
	<div class='FieldRow_content'>


<input type="password" id="admin_pass1"	name="admin_pass1" value="" required maxlength="50" class="input_text" onkeyup='check();'/>
</div>
</li>
<li id="admin_admin_pass2" class='FieldRow'>
	<label class='FieldRow_label '>
		Confirm Password <span class='FieldRow_required'>required</span>
	</label>
	<div class='FieldRow_content'>
<input type="password" id="admin_pass2"	name="admin_pass2" value="" required maxlength="50" class="input_text" onkeyup='check();'/>
<br />
<span id="message" class='Type_warning'></span>
</div>
</li>
<li id="admin_admin_email" class='FieldRow'>
	<label class='FieldRow_label '>
		Email Address <span class='FieldRow_required'>required</span>
	</label>
	<div class='FieldRow_content'>


<input type="email" name="admin_email" value="" required class="input_text"/>



		<br />

			<span class='Type_warning'></span>

	</div>
</li>
		<li class='FieldRow'>
			<div class='FieldRow_content'>
					<input name="status" value="Details Admin" type="hidden"/>
											<input name="dbpost" value="1" type="hidden"/>
<button type="submit" class='Button Button_primary'>Continue</button>
			</div>
		</li>
	</ul>
</form>
							</div>
						</div>
					</div>

			</main>
		</div>
	</body>
</html>
<?php
}?>