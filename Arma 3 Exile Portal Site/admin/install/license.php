<?php
if($_POST["test"]=="1")
{?>
<form name="myForm" id="1232" action="ServerDetails.php" method="POST">
  <input name="status" value="Server Details" type="hidden"/>
	<input type="submit" value="Submit" type="hidden" />
</form>
<script>
	document.getElementById("1232").submit();
	document.getElementById("1232").click();
</script>
<?php
}else{
if($_POST["status"]!="license")
{?>
<script>
			window.location.replace("index.php");
</script>
<?php
}
else{
?>






<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>A3EP License</title>
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
	</script>

	<script src="js/jquery.min.js"></script>
	<script src="js/multipleRedirect.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {

			$("#key").change(function() {

				var usr = $("#key").val();

				if (usr.length >= 23) {
					$("#status").html('Checking key.......');
          document.getElementById("1025").action = "license.php";
          document.getElementById("1023").innerHTML = "<input id='continue' type='submit' name='submit' class='Button Button_primary' value='Continue' />";
          document.getElementById('1026').style.display='none';
          $(this).html(document.getElementById("1024").checked);
				} else {
					$("#status").html('<font color="red">The key should have <strong>24</strong> characters.</font>');

				}

			});

		});
	</script>

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
					Step: License
				</h1>
			</div>
			<div class='Columns Pad'>
				<div class='Column Column_wide Pad' id='elInstaller_stepsWrap'>
					<ul id='elInstaller_steps'>

						<li class='elInstaller_stepDone'>
							<i class='fa fa-check'></i>&nbsp;&nbsp;System Check
						</li>

						<li class='elInstaller_stepActive'>
							<i class='fa fa-circle'></i>&nbsp;&nbsp;License
						</li>

						<li class=''>
							<i class='fa fa-circle-o'></i>&nbsp;&nbsp;Server Details
						</li>
	<li class=''>
                <i class='fa fa-circle-o'></i>&nbsp;&nbsp;Portal Settings
              </li>
						<li class=''>
							<i class='fa fa-circle-o'></i>&nbsp;&nbsp;Admin
						</li>

						<li class=''>
							<i class='fa fa-circle-o'></i>&nbsp;&nbsp;Install
						</li>

					</ul>
				</div>
				<div class='Column Column_fluid'>
					<div class='Pad'>

						<?php $success = TRUE; ?>


						<ul class='Form Form_horizontal'>

							<li id="license_lkey" class='FieldRow'>
								<label class='FieldRow_label '>
		License Key <span class='FieldRow_required'>required</span>
	</label>
								<div class='FieldRow_content'>

									<form>
										<input id="key" size="24" type="text" name="key">
								<a class="Button Button_primary" href="https://a3exileportal.com/buy" id="1026">Buy a key</a>

										<br />
										<span id='status' class='Type_warning'></span>
									</form>
								</div>
							</li>

							<form id="1025" action="" method="POST">

							<li id="eula" class='FieldRow'>
								<label class='FieldRow_label '>
		License Agreement <span class='FieldRow_required'>required</span>
	</label>


								<div class='FieldRow_content'>
									<textarea disabled style='width: 100%; height: 250px'><?php echo file_get_contents("licenseagreement.txt"); ?></textarea><br>

									<input id="1024" type="hidden" name="eula" value="0" />
									<label>
	<input
		type='checkbox'
		name='eula_checkbox'
		value='1'
				 required
/>
											<input name="test" value="1" type="hidden"/>
	I have read and agree to the license agreement
</label>



									<br />

									<span class='Type_warning'></span>

								</div>
							</li>
							<li class='FieldRow'>
								<div class='FieldRow_content' id="1023">

								</div>
							</li>

							</form>

						</ul>

					</div>
				</div>
			</div>

		</main>
	</div>
</body>

</html>
<?php }}?>
