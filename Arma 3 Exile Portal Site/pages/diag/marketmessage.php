<?php if(!isset($include)){die("INVALID REQUEST");} ?>
<?php
$url = "?page=marketplace&p=1&claim";
$message = "<p>Hello,</p>
<p>You have recently bought: ".$ITEMNAME." from me.</p>
<p>Since you were not logged into the server at the time of purchase your item has been stored.&nbsp;</p>
<p>You must claim your item while logged in to receive it.&nbsp;</p>
<p>Click here: <a href='".$url."' target='_blank'>Claim Item</a> ,&nbsp;to receive your item</p>";
?>