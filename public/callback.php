<?php
//GET URL VALUES FROM FRESHSERVICE CALLBACK FUNCTION
$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$myPost = array();
foreach ($raw_post_array as $keyval) {
  $keyval = explode ('=', $keyval);
  if (count($keyval) == 2)
    $myPost[$keyval[0]] = urldecode($keyval[1]);
}
// read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
$req = 'cmd=_notify-validate';
if (function_exists('get_magic_quotes_gpc')) {
  $get_magic_quotes_exists = true;
}
foreach ($myPost as $key => $value) {
  if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
    $value = rawurlencode(stripslashes($value));
  } else {
    $value = rawurlencode($value);
  }
  $req .= "&$key=$value";
}
//REMOVE EXTRA CHARACTERS AND URLDECODE THEN REMOVE UNWANTED COMMENST

$removearray 	=  	rawurldecode($req);
$resultone	 	= 	str_replace('freshdesk_webhook','',$removearray);
$resulttwo 	 	= 	str_replace('cmd=_notify-validate','',$resultone);

$stripereturn 	= 	strip_tags($resulttwo);
$stripeone 		= 	str_replace('[','',$stripereturn);
$stripetwo 		= 	str_replace(']','',$stripeone);
$finalresult 	= 	parse_str($stripetwo,$data);
$ticketid 		=	(!empty($data['ticket_id']))?$data['ticket_id']:'';
$ticketsub 		=	(!empty($data['ticket_subject']))?$data['ticket_subject']:'';
$ticketdes 		=	(!empty($data['ticket_description']))?$data['ticket_description']:'';
$ticketurl 		=	(!empty($data['ticket_portal_url']))?$data['ticket_portal_url']:'';

$con = mysqli_connect("localhost","roo1","chola","dms_dev");

//$con = mysqli_connect("localhost","roo1","chola","dmschema_148610393543");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
else
{
	mysqli_query($con,"INSERT INTO `testtable` ( `ticketid`, `ticketsub`, `ticketdes`, `ticketurl`) 
	VALUES ( '$ticketid', '$ticketsub', '$ticketdes', '$ticketurl')");
	print 'success';
}



?>
 
