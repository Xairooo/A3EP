<?php
#region Database Object Creation
function mysqli($host,$user,$pass,$dbname)
{
    try
    {
        $database = 'mysql:host='.$host.';dbname='.$dbname.';charset=utf8';

        $pdo = new PDO($database, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
    catch(PDOException $e)
    {
        echo 'PDO Error: ' . $e->getMessage();
        return false;
    }
}
#endregion

#region Filter Data
//Format post content and filter to ensure it's not malicious
function filterPostData()
{

    //Forbidden characters
    $forbidden = ['/%/', '/\'/', '/</', '/>/', '/`/'];
    $replace = ['&#37;', '&#39;', '&#60;', '&#62;', '&#96;'];


    foreach($_POST as $key => $data){

        $_POST[$key] = preg_replace($forbidden, $replace, $data);
    }
}
#endregion

#region Redirect
function Redirect($url)
{
    header("Location: " . $url);
    exit;
}
#endregion


?>