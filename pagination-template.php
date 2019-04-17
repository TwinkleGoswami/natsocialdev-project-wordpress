<?php
/**
 * Template Name: Member Display Template
 */
get_header();
?>
<h6>E-mail module</h6>
<?php

$to = 'heergoyani1789@gmail.com';
$subject = "Your Registarion is successfully and We send your Password";
$message = "<html><body><center><img src='http://natsocialdev.natrixsoftware.com/wp-content/uploads/2018/05/logo_white.png'alt='SHREE UTTAR GUJARAT PATIDAR SAMAJ'style='width:15%'></center><br/><h6 style='color: #c03;text-shadow: 1px 1px black;font-size: 18px;'>Welcome,You are successfully registered in SHREE UTTAR GUJARAT PATIDAR SAMAJ</h6><hr/><table><tr><td><p style='color: #c03;font-size: 14px;'>Your Password is&nbsp;:&nbsp;</td></p><td><p style='color: black;font-size: 14px;font-weight:bold;'>abc123</p></td></tr></table><hr/><p style='color:red;font-size:12px;'>Note&nbsp;:&nbsp;</p><span>You are register sucessfully in SHREE UTTAR GUJARAT PATIDAR SAMAJ,but your request is still pending.Once admin can approved you after you have member,and do login using above password.</span></body></html>";
$headers = array('Content-Type: text/html; charset=UTF-8');

//Here put your Validation and send mail
$sent = wp_mail($to, $subject, $message,$headers);
if(is_wp_error($sent)){
	print_r($sent);
}
else
{
	echo "sent";
}
?>
<?php
// get_footer();
?>
