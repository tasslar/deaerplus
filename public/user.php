<?php

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,"http://52.221.57.201/dev/public/ninja/public/users");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
            "first_name=sreeni&last_name=vasan&email=sreenivasan@gmail.com&is_admin=1");




  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


$server_output = curl_exec ($ch);

curl_close ($ch);

if ($server_output == "OK")
 { 
 	echo "Sucess";
 } 
 else
  {  
     echo "Fail";
  }

?>