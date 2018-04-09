<?php

Class ErrorHandler {

	public static function processEmail(string $email_address, &$processed_email) {
		if(filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
			$processed_email = $email_address;
			return true;
		} else {
			return false;
		}
	}

	public static function processEmailDomain(string $email_address) {
		if ($email_address != "") {
			list($user_name, $mail_domain) = explode("@", $email_address);
			$tld = explode('.', $mail_domain, 2)[1];
			//echo "Domain: " . $tld . PHP_EOL;
			if (checkdnsrr($mail_domain, 'A') && !in_array(gethostbyname($mail_domain), gethostbynamel('this_is_a_wrong_url_xx_xx_xx.' . $tld))) {
				return true;
			} else {
				return false;
			}
		}
	}

	public static function processDate(string $date, string $format, &$processed_date) {
		try {
			if ($date != "") {
				$date = str_replace('/', '-', $date);
				$d = new DateTime($date);
				$processed_date = $d->format($format);				
				return true;
			} else {
				return false;
			}
		} catch (Exception $e) {			
			return false;
		}
	}

	public static function processContactDetails() {
		return false;
	}

	public static function processName(string $name, &$details) {
		if ($name != "") {
			if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
				return false;
			} else {
				$details = explode(" ", $name);
				return true;
			}
		}
	}
}

?>