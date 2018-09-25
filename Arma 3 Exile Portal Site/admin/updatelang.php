<?php

$include="1";
ob_start();
;
$extraDir = "./extra/";
	$dirUp = "./";
require('../extra/common.php');
require("../extra/classes.php");
$settingClass = new settingClass;
$statClass = new statClass($settingClass);
$userClass = new userClass;
$langs = new langs;
$permClass = new permissionClass;
include("../Functions/validation.php");
require("../Functions/sessionhandler.php");
include("../Functions/languageselect.php");
if ($AccountID == "")
{
	unset ($AccountID);
}

$langt='English';
$lang_id = 'en_US';




$xml = new XMLWriter;
$xml->openMemory();
$xml->startDocument('1.0');
$xml->setIndent(true);
$xml->startElement('language');
 $xml->writeAttribute('name',$langt);
 $xml->writeAttribute('locale',$lang_id);
 $query = "SELECT * FROM ".$tblpre."modules";
    try
    {
        $stmt = $db->prepare($query);
        $stmt->execute();
    }
    catch(PDOException $ex)
    {
        die("Failed to run query: " . $ex->getMessage());
    }

    $row = $stmt->fetchAll();

 foreach ($row as $app )
 {
 $xml->startElement('app');
 $xml->writeAttribute('key', $app['module_key']);


 $query2 = "SELECT * FROM ".$tblpre."lang_words WHERE `word_module`='".$app['module_key']."'";
    try
    {
        $stmt2 = $db->prepare($query2);
        $stmt2->execute();
    }
    catch(PDOException $ex)
    {
        die("Failed to run query: " . $ex->getMessage());
    }

    $row2 = $stmt2->fetchAll();

			/* Add words */
			foreach ( $row2 as $word )
			{
$xml->startElement('word');
 $xml->writeAttribute('key', $word['word_key']);
 /* Write value */
				if ( preg_match( '/<|>|&/', $word['word_default'] ) )
				{
					$xml->writeCData( str_replace( ']]>', ']]]]><![CDATA[>', $word['word_default'] ) );
				}
				else
				{
				$xml->text($word['word_default']);
				}

$xml->endElement(); // word
}
$xml->endElement(); // app
}
$xml->endElement(); // lang
$xml->endDocument();
header('Content-type: text/xml; charset=UTF-8');
echo $xml->outputMemory(true);
?>
