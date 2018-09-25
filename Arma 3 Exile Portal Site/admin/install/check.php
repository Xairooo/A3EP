<?php
if(isSet($_POST['key']))
{
  function curPageURL() {
            $pageURL = "http://".$_SERVER["SERVER_NAME"];
            return $pageURL;
        }
   $u = curPageURL();
  $key = $_POST['key'];
  $url = "https://a3exileportal.com/license/".$key;
 $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
    $data = curl_exec($curl);
    $datasearch = json_decode($data, true);

    if($datasearch['key'] === $key):

$toWrite = "<?php\n\n" . '$INFO = ' . var_export( array( 'lkey' => $key, 'ldomain' => $u ), TRUE ) . ';';

				$file = @\file_put_contents( '../../extra/config.php', $toWrite );
/*session created*/
     echo "valid key  ";
   else: $success = FALSE;
        echo  "The license key supplied is not valid. Please check the provided key and try again or contact technical support for more assistance.";
   endif;
    }


?>
