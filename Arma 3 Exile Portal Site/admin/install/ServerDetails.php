<?php
		ob_start();
 ;
 function siteURL()
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['HTTP_HOST'].'';
    return $protocol.$domainName;
}
if($_POST["status"]!="Server Details")
{?>
<script>
			window.location.replace("index.php");
</script>
<?php
}
else{

if($_POST["dbpost"]=="1")
{

$values = array( 'sql_host' => $_POST['host'],
  'sql_user' => $_POST['sql_user'],
  'sql_pass' => $_POST['sql_pass'],
  'sql_database' => $_POST['sql_database'],
  'sql_port' => $_POST['sql_port'],
  'sql_tbl_prefix' => $_POST['sql_table_pre'],
  'base_url' => $_POST['base_url'],);

	$INFO = NULL;
				require ('../../extra/config.php');
				$INFO = array_merge( $INFO, $values );

				$toWrite = "<?php\n\n" . '$INFO = ' . var_export( $INFO, TRUE ) . ';';
$file = file_put_contents( '../../extra/config.php', $toWrite );
?>
   <form name="myForm" id="1232" action="DetailsAdmin.php" method="POST">
      <input name="status" value="Details Admin" type="hidden" />
      <input type="submit" value="Submit" type="hidden" />
    </form>
    <script>
      document.getElementById("1232").submit();
      document.getElementById("1232").click();
    </script>
<?php


}
?>
  <html>
  <head>
    <meta charset="utf-8">
    <title>Server Details</title>
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
            Step: Server Details
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

              <li class='elInstaller_stepActive'>
                <i class='fa fa-circle'></i>&nbsp;&nbsp;Server Details
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


              <form action="ServerDetails.php" method="post" enctype="multipart/form-data">
                <ul class='Form Form_horizontal'>

                  <li id="serverdetails_header_mysql_server">
                    <h2 class='FieldRow_section'>MySQL Server Details</h2>
                  </li>
                  <li id="serverdetails_sql_host" class='FieldRow'>
       <label class='FieldRow_label '>
		Host <span class='FieldRow_required'>required</span></label>
                    <div class='FieldRow_content'>
<input type="text" name="host" value="localhost" required class="input_text" />



                      <br>
                      <span class='FieldRow_desc'>
	If you are not sure, leave at the default value.
</span>

                      <br />

                      <span class='Type_warning'></span>

                    </div>
                  </li>
                  <li id="serverdetails_sql_port" class='FieldRow'>
                    <label class='FieldRow_label '>
		SQL Port
	</label>
                    <div class='FieldRow_content'>


                      <input type="text" name="sql_port" value="<?php echo ini_get('mysqli.default_port') ;?>" required class="input_text" />



                      <br>
                      <span class='FieldRow_desc'>If you are not sure, leave at the default value.
</span>

                      <br />

                      <span class='Type_warning'></span>

                    </div>
                  </li>
                  <li id="serverdetails_sql_user" class='FieldRow'>
                    <label class='FieldRow_label '>
		Username <span class='FieldRow_required'>required</span>
	</label>
                    <div class='FieldRow_content'>


                      <input type="text" name="sql_user" value="" required class="input_text" />



                      <br>
                      <span class='FieldRow_desc'>
	If you are not sure what your MySQL Server username and password is, contact your hosting provider for assistance.
</span>

                      <br />

                      <span class='Type_warning'></span>

                    </div>
                  </li>
                  <li id="serverdetails_sql_pass" class='FieldRow'>
                    <label class='FieldRow_label '>
		Password
	</label>
                    <div class='FieldRow_content'>


                      <input type="password" name="sql_pass" value="" class="input_text" />




                      <br />

                      <span class='Type_warning'></span>

                    </div>
                  </li>
                  <li id="serverdetails_sql_database" class='FieldRow'>
                    <label class='FieldRow_label '>
		Database Name <span class='FieldRow_required'>required</span>
	</label>
                    <div class='FieldRow_content'>


                      <input type="text" name="sql_database" value="" required class="input_text" />



                      <br>
                      <span class='FieldRow_desc'>
	If the database does not exist we will try to create it. If your MySQL user does not have permission and you're not sure how to create a database, contact your hosting provider for assistance.
</span>

                      <br />

                      <span class='Type_warning'></span>

                    </div>
                  </li>
                  <li id="serverdetails_sql_table_pre" class='FieldRow'>
                    <label class='FieldRow_label '>
		Table Prefix
	</label>
                    <div class='FieldRow_content'>


                      <input type="text" name="sql_table_pre" value="" class="input_text" />



                      <br>
                      <span class='FieldRow_desc'>If you wish to have a prefix on your tables you can eneter it now otherwisse keep it blank
</span>

                      <br />

                      <span class='Type_warning'></span>

                    </div>
                  </li>
                  </li>
                   <li id="serverdetails_header_mysql_server">
                    <h2 class='FieldRow_section'>Web Server Details</h2>
                  </li>
                  <li id="serverdetails_install_url" class='FieldRow'>
       <label class='FieldRow_label '>
		Host <span class='FieldRow_required'>required</span></label>
                    <div class='FieldRow_content'>
<input type="text" name="base_url" value="<?php echo siteURL() . mb_substr( $_SERVER['SCRIPT_NAME'], 0, -mb_strlen( 'admin/install/ServerDetails.php' ) );?>" required class="input_text" />



                      <br>
                      <span class='FieldRow_desc'>
	used for links within the portal
</span>

                      <br />

                      <span class='Type_warning'></span>

                    </div>
                  </li>

                  <li class='FieldRow'>
                    <div class='FieldRow_content'>
											<input name="status" value="Server Details" type="hidden"/>
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



}
?>
