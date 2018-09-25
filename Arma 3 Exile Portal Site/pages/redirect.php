<?php if(!isset($include)){die("INVALID REQUEST");} ?>
<?php
$page = $_GET["page"];
$pid = $_GET["pid"];
$vara = $_GET["var1"];
$varb = $_GET["var2"];

header("location: /?page=".$pid."&".$vara."=".$varb);