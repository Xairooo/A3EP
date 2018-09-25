<?php
include ('./extra/config.php');
$siteurl = $INFO['base_url'];
$portalname = $settingClass->getServerName();
use PHPMailer\PHPMailer\PHPMailer;
require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';
$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
if ($settingClass->getSetting('mail_delivery_method') =='smtp')
{
    $mail->IsSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure =  $settingClass->getSetting('smtp_protocol');
    $mail->Host = $settingClass->getSetting('smtp_host');
    $mail->Port = $settingClass->getSetting('smtp_port');
    $mail->Username =  $settingClass->getSetting('smtp_username');
    $mail->Password =  $settingClass->getSetting('smtp_password');
}

$mail->SetFrom( $settingClass->getSetting('outgoing_email'),  $settingClass->getSetting('servername'));
$mail->addReplyTo( $settingClass->getSetting('incoming_email'),  $settingClass->getSetting('servername'));
class mailer {
    function Email($email,$body,$subject)
    {
        global $mail;
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AddAddress($email);
        $mail->Send();
    }
    function validate($email,$member)
    {
        global $mail;
        global $siteurl;
        global $portalname;
        $message = file_get_contents(__DIR__ . '/templates/validate_email.html');
        $message = str_replace('{url}', $siteurl, $message);
        $message = str_replace('{member}',$member , $message);
        $message = str_replace('{portalname}',$portalname , $message);
        $mail->Subject = 'You must validate your account to continue';
        $mail->MsgHTML($message);
        $mail->IsHTML(true);
        $mail->CharSet="utf-8";
        $mail->AddAddress($email);
        $mail->Send();
    }
    function newmembernotify($admin,$adminemail,$membername,$memberemail,$memberip)
    {
        global $mail;
        global $siteurl;
        global $portalname;
        $message = file_get_contents(__DIR__ . '/templates/notify_new_member.html');
        $message = str_replace('{url}', $siteurl, $message);
        $message = str_replace('{admin}',$admin, $message);
        $message = str_replace('{portalname}',$portalname , $message);
        $message = str_replace('{newusername}',$membername , $message);
        $message = str_replace('{newuseremail}',$memberemail , $message);
        $message = str_replace('{newuserip}',$memberip , $message);
        $mail->Subject = 'A new user has registered at '.$portalname;
        $mail->MsgHTML($message);
        $mail->IsHTML(true);
        $mail->CharSet="utf-8";
        $mail->AddAddress($adminemail);
        $mail->Send();
    }
     function passwordreset($email,$member,$userkey)
    {
        global $mail;
        global $siteurl;
        global $portalname;
        $message = file_get_contents(__DIR__ . '/templates/password_reset.html');
        $message = str_replace('{url}', $siteurl, $message);
        $message = str_replace('{member}',$member , $message);
        $message = str_replace('{userkey}',$userkey , $message);
        $message = str_replace('{portalname}',$portalname , $message);
        $mail->Subject = 'Action required to reset your password';
        $mail->MsgHTML($message);
        $mail->IsHTML(true);
        $mail->CharSet="utf-8";
        $mail->AddAddress($email);
        $mail->Send();
    }

}

} catch (Exception $e) {
   $mail->ErrorInfo; //create function to log email errors to db
}

?>