<?php
$alert_make = base64_decode($argv[1]);
$alert_model = base64_decode($argv[2]);
$alert_variant = base64_decode($argv[3]);
$alert_source_listing_id = $argv[4];
$alert_source_dealer_id = $argv[5];

/*$alert_make = 'Land Rover';
$alert_model = 'Land Rover Discovery';
$alert_variant = '4 3.0D SE';
//$alert_source_listing_id = 'DPLD20170218055313';

$alert_source_listing_id = $argv[1];
$alert_source_dealer_id = 3;*/

$con = mysqli_connect("localhost","roo1","chola","dms_dev");

//$con = mysqli_connect("localhost","roo1","chola","dmschema_148610393543");

// Check connection
if (mysqli_connect_errno())
{
  //echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
else
{
	$sql = "SELECT * FROM dealer_alert_history where alert_make='".$alert_make."' and alert_model='".$alert_model."' and alert_variant='".$alert_variant."' and alert_user_id<>".$alert_source_dealer_id;
	$result = $con->query($sql);

	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	    	$alert_id = $row["alertid"];
	    	$alert_subscriber_dealer_id = $row["alert_user_id"];
	        //$row["alert_user_id"]. " " . $row["alert_usermailid"]. " " . $row["alert_mobileno"]. "<br>";
	        mysqli_query($con,"INSERT INTO `dealer_alerts_received` ( `alert_id`, `alert_source_listing_id`, `alert_subscriber_dealer_id`, `alert_source_dealer_id`) 
			VALUES ( '$alert_id', '$alert_source_listing_id', '$alert_subscriber_dealer_id', '$alert_source_dealer_id')");
	    }
	}
}
mysqli_close($con);
?>