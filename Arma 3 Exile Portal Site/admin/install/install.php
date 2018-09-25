<?php
require('../../extra/config.php');
?>
  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="utf-8">
    <title>Install</title>
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
    <script type="text/javascript">
      var a3_TIMEOUT = 30;
    </script>
    <script src="js/jquery.min.js"></script>
    <script src="js/multipleRedirect.js"></script>
  </head>

  <body class='App App_installer'>

    <div id='elInstaller_wrap'>
      <div id='Layout_header' class='Clearfix' role='banner'>
        <header>
          <a href='/' id='elSiteTitle'><span id='elLogo'><img src='img/logo.png' alt=''></span> Install A3 Exile Portal</a>

        </header>
      </div>
      <main id='elInstaller_body'>

        <div class='Pad AreaBackground_light'>
          <h1 class='Type_pageTitle'>
            Step: Install
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
              <li class='elInstaller_stepDone'>
                <i class='fa fa-check'></i>&nbsp;&nbsp;Admin
              </li>

              <li class='elInstaller_stepActive'>
                <i class='fa fa-circle'></i>&nbsp;&nbsp;Install
              </li>

            </ul>
          </div>
          <div class='Column Column_fluid'>
            <div class='Pad'>
							<script type="text/javascript">
							</script>
              <?php
if($_POST["status"]!="Install")
{
              ?>
              <script>
                window.location.replace("index.php");
              </script>
              <?php
}
else{


if($_POST["installerstart"]=='1'){

		if(in_array($_POST["step"],array("2","3","4")))
								{

								}
								else
								{
require ('../../extra/config.php');
require ('../../extra/common.php');
require ('install_sql.php');
//Create DB
foreach($createdb as $createdb1)
{
  try
	{
	  $stmtdb = $db->prepare($createdb1, array(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true));
    $stmtdb->execute();
	}
	catch(PDOException $ex)
	{
	   die($ex->getMessage());
	}
}
//Setup Lang
$langfile = '../language/English.xml';
$defaultfile = '../language/default/English.xml';
if(!file_exists($langfile)) {
	$oldContents = file_get_contents($defaultfile);
	$handle = fopen($langfile, 'w+') or die('Cannot open file:  '.$langfile .' - Check file permissions');
	$langinfo = '<language name="English" locale="en_US">';
	if (!is_writable($langfile))
	{
    	die("Cannot write to file - ". $langfile .". Check write permissions.");
	}
	fwrite($handle, $langinfo);
	fwrite($handle, $oldContents);
	fclose($handle);
	$query2 = "INSERT INTO ".$tblpre."lang (lang_short, lang_title,	lang_default) VALUES (:short, :title, :defaults)";
	$query_params2 = array(
		':short' => 'en_US',
		':title' => 'English',
		':defaults' => '1');
	try
	{
		$stmt2 = $db->prepare($query2);
		$result2 = $stmt2->execute($query_params2);
	}
	catch(PDOException $ex)
	{
		die("Failed to run query: " . $ex->getMessage());
	}
	$localeshort = 'en_US';
	$query = "SELECT module_key FROM ".$tblpre."modules";
    try
    {
        $stmt = $db->prepare($query);
        $stmt->execute();
    }
    catch(PDOException $ex)
    {
        die("Failed to run query2: " . $ex->getMessage());
    }
	$row = $stmt->fetchAll();
	$appKey = NULL;
	$xml = new XMLReader;
	$xml->open( $langfile );
	$xml->read();
	while ( $xml->read() and $xml->name == 'app')
		{
			$appKey = $xml->getAttribute('key');
			$xml->read();
			while ( $xml->read() and $xml->name == 'word' )
			{
				$query3 = "INSERT INTO ".$tblpre."lang_words (lang_id, word_module,	word_key, word_default) VALUES (:shorts, :modules, :keys, :default);";
				$query_params3 = array(
					':shorts' => $localeshort,
					':modules' => $appKey,
					':keys' => $xml->getAttribute('key'),
					':default' => $xml->readString());
				try
				{
					$stmt3 = $db->prepare($query3);
					$result3 = $stmt3->execute($query_params3);
				}
				catch(PDOException $ex)
				{
					die("Failed to run query3: " . $ex->getMessage());
				}
				$xml->next();
			}
			$xml->next();
		}
}
?>


                <div class="no_js_hide">
                  <div class="Redirect_progress">
                    <div class="ProgressBar ProgressBar_animated" id="1102">
<div class='ProgressBar_progress' style="" id="1103"></div>
                    </div>
                  </div>
                  <span class='Redirect_message'>Setting up database......</span>

</div>
<form name="myForm" id="1223" action="install.php" method="POST">
  <input name="status" value="Install" type="hidden"/>
	<input name="step" value="2" type="hidden"/>
	<input name="installerstart" value="1" type="hidden"/>
</form>

<script>
function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}
async function demo() {
  document.getElementById("1103").style = "width: 0%";
  await sleep(500);
  document.getElementById("1103").style = "width: 5%";
	 await sleep(600);
  document.getElementById("1103").style = "width: 15%";
	 await sleep(1500);
  document.getElementById("1103").style = "width: 25%";
	document.getElementById("1223").click();
	document.getElementById("1223").submit();

}
demo();
</script>
  <?php
  }

if($_POST["step"]=='2') {
require ('../../extra/common.php');
     $addsettings = "
     INSERT INTO `". $tblpre ."settings` VALUES
     (1,'servername','A3 Exile Portal'),
     (2,'incoming_email','". $INFO['admin_email'] ."'),
     (3,'outgoing_email','". $INFO['admin_email'] ."'),
     (4,'upgrade_notification','". $INFO['admin_email'] ."'),
     (5,'lkey','". $INFO['lkey'] ."'),
     (6,'recaptcha_key_public',''),
     (7,'recaptcha_key_private',''),
     (8,'logindisabled','0'),
     (9,'notify_on_reg','1'),
     (10,'signupdisabled','0'),
     (11,'steamapi',''),
     (12,'addon_username',''),
     (13,'addon_pass',''),
     (14,'addon_ip',''),
     (15,'addon_port',''),
     (16,'db_host',''),
     (17,'db_schema',''),
     (18,'db_user',''),
     (19,'db_pass',''),
     (20,'link_ids',''),
     (21,'user_copyright',''),
     (22,'portal_online','1'),
     (23,'offline_message',''),
     (24,'GoogleAna',''),
     (25,'custom_header','pages'),
     (26,'cpagename','CustomPages'),
     (27,'disqus_shortcode',''),
     (28,'lastsent',''),
     (29,'software_version','NULL');
     (30,'mail_delivery_method','php'),
     (31,'smtp_host',''),
     (32,'smtp_protocol',''),
     (33,'smtp_port',''),
     (34,'smtp_username',''),
     (35,'smtp_password',''),
     (36,'login_providers', 'steam,intergrated'),
     (37,  'mail_delivery_method',  'php),
     (38,  'smtp_host',''),
     (39, 'smtp_protocol', 'plain'),
     (40,  'smtp_port',''),
     (41,  'smtp_username'  ''),
     (42,  'smtp_password','');";
try
		{

			$stmtsettings = $db->prepare($addsettings, array(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true));
			$stmtsettings->execute();

		}
		catch(PDOException $ex)
		{
			die("Failed to run query: " . $ex->getMessage());
		}
		?>


                <div class="no_js_hide">
                  <div class="Redirect_progress">
                    <div class="ProgressBar ProgressBar_animated" id="1102">
<div class='ProgressBar_progress' style="" id="1103"></div>
                    </div>
                  </div>
                  <span class='Redirect_message'>Inserting Portal Settings......</span>

</div>
<form name="myForm" id="1223" action="install.php" method="POST">
  <input name="status" value="Install" type="hidden"/>
	<input name="step" value="3" type="hidden"/>
		<input name="installerstart" value="1" type="hidden"/>
</form>

<script>
function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}

async function demo() {
  document.getElementById("1103").style = "width: 25%";
  await sleep(500);
  document.getElementById("1103").style = "width: 30%";
	 await sleep(600);
  document.getElementById("1103").style = "width: 40%";
	 await sleep(1500);
  document.getElementById("1103").style = "width: 50%";

document.getElementById("1223").submit();
	document.getElementById("1223").click();
}

demo();
</script>
<?php	}
if($_POST["step"]=='3') {
  	require ('../../extra/common.php');
$query = "INSERT INTO `". $tblpre ."users` (
					username,
					password,
					salt,
					language,
					email,
					admin,
					verified,
					passwordKey
				) VALUES (
					:username,
					:password,
					:salt,
					:lang,
					:email,
					:admin,
					:verified,
					:passwordKey
				);
			INSERT INTO `". $tblpre ."user_permissions` VALUES (1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
			";


		$salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));

			$password = hash('sha256', $INFO['admin_pass'] . $salt);

			for($round = 0; $round < 65536; $round++)
			{
				$password = hash('sha256', $password . $salt);
			}
			$passwordKey = substr(rtrim(base64_encode(md5(microtime())),"="), 0,25);
			$query_params = array(
				':username' => (filter_var($INFO['admin_user'] , FILTER_SANITIZE_FULL_SPECIAL_CHARS)),
				':password' => $password,
				':salt' => $salt,
				':email' => (filter_var($INFO['admin_email'] , FILTER_SANITIZE_FULL_SPECIAL_CHARS)),
				':passwordKey' => $passwordKey,
				':lang' => 'en_US',
				':admin' => '1',
				':verified' => '1'
			);

			try
			{

				$stmt = $db->prepare($query, array(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true));
				$stmt->execute($query_params);
			}
			catch(PDOException $ex)
			{
				die("Failed to run query: " . $ex->getMessage());
			}


		if(in_array($_POST["step"],array("4")))
								{

								}
								else
								{

							?>
			<div class="no_js_hide">
                  <div class="Redirect_progress">
                    <div class="ProgressBar ProgressBar_animated" id="1102">
<div class='ProgressBar_progress' style="" id="1103"></div>
                    </div>
                  </div>
                  <span class='Redirect_message'>Setting up Admin Account......</span>

</div>
<form name="myForm" id="1223" action="install.php" method="POST">
  <input name="status" value="Install" type="hidden"/>
	<input name="step" value="4" type="hidden"/>	<input name="installerstart" value="1" type="hidden"/>
</form>

<script>
function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}

async function demo() {
  document.getElementById("1103").style = "width: 50%";
  await sleep(500);
  document.getElementById("1103").style = "width: 55%";
	 await sleep(600);
  document.getElementById("1103").style = "width: 60%";
	 await sleep(1500);
  document.getElementById("1103").style = "width: 75%";
	document.getElementById("1223").click();
document.getElementById("1223").submit();
}

demo();
</script>
                <?php	}
  }
  if($_POST["step"]=='4') {
    require ('../../extra/common.php');

?>
											 			<div class="no_js_hide">
                  <div class="Redirect_progress">
                    <div class="ProgressBar ProgressBar_animated" id="1102">
<div class='ProgressBar_progress' style="" id="1103"></div>
                    </div>
                  </div>
                  <span class='Redirect_message'>Finishing up......</span>

</div>
<form name="myForm" id="1134" action="success.php" method="POST">
  <input name="status" value="success" type="hidden"/>
</form>
     <script>
function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}

async function demo() {
  document.getElementById("1103").style = "width: 80%";
  await sleep(500)
  document.getElementById("1103").style = "width: 90%";
	 await sleep(600);
  document.getElementById("1103").style = "width: 95%";
	 await sleep(1500);
  document.getElementById("1103").style = "width: 100%";
document.getElementById("1134").click();
document.getElementById("1134").submit();
}

demo();
</script><?php

                       //redirect to success.php


                     }
  }

}
?>

            </div>
          </div>
        </div>

      </main>
    </div>
  </body>

  </html>
