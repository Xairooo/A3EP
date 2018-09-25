
<?php
require('header.php');
if (($_GET['do'] =='reset') && !empty($_GET['do']) AND isset($_GET['id']) && !empty($_GET['id'])){
	$userid = $_GET['id'];
		$email = $_GET['email'];
				$userKey = $userClass->userEmailResetRequest($userid);
				$membername = $userClass->getUserUsername($userid);
//password reset admin cp
$mailer->passwordreset($email,$membername,$userKey);

header("location: members.php?do=edit&id=".$userid."");
}

?>