<?php if(!isset($include)){die("INVALID REQUEST");} ?>
<?php
if ($defaultConstants['COOKIE_PATH']== NULL)
{
  $path = "/";
} else
{
  $path = $defaultConstants['COOKIE_PATH'];
}
if(!isset($_COOKIE[$defaultConstants['COOKIE_PREFIX'].'lid'])) {
    setcookie($defaultConstants['COOKIE_PREFIX'].'lid', '0', time() + (10 * 365 * 24 * 60 * 60), $path);
}
$host= (explode(",",$settingClass->getSetting("addon_ip")))[$LINKID];
$port= (explode(",",$settingClass->getSetting("addon_port")))[$LINKID];
if(!$host=="")
{


    if (!$socket = @fsockopen($host, $port, $errno, $errstr, 3)) {
        echo '<div class="card text-white bg-danger mb-3">
            <div class="card-header" style="color:red">'.$langs->word($dlang,'addon_error_header').'</div>
            <div class="card-body">
                <h4 class="card-title" style="color:black">'.$langs->word($dlang,'addon_error_title').'</h4>
                <p class="card-text">'.$langs->word($dlang,'addon_error_msg').'</p>
            </div>
        </div>';
         fclose($socket);
    } else {

        fclose($socket);
    }
}
?>