<?php
if(isset($_GET['do'])){
if (($_GET['do'] =='download') && !empty($_GET['do']) AND isset($_GET['lang']) && !empty($_GET['lang'])){
$file = 'language/'.$_GET['lang'].'.xml';

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}
header("location: lang.php");
}
} else {
    echo "no file designated";
}
?>