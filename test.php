<?php 

$email = trim("stehanoli4@media24.co.za");

list($user_name, $mail_domain) = explode("@", $email);
$tld = explode('.', $mail_domain, 2)[1];

echo "Domain: " . $tld . PHP_EOL;

if(checkdnsrr($mail_domain,'A') && !in_array(gethostbyname($mail_domain), gethostbynamel('this_is_a_wrong_url_xx_xx_xx.' . $tld))) {  
	echo "Domain exists.";  
} else { 
	echo "Domain not exists.";  
}

?>