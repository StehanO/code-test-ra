<?php

Class ErrorHandler {

	public static function processEmail(string $email_address, &$processed_email) {
		// work around umlauts
		$contains_umlauts = false;
		if (preg_match('/&[a-zA-Z]uml;/', htmlentities($email_address, ENT_COMPAT, 'UTF-8'))) {
			$contains_umlauts = true;
			//save original email
			$email_address_orig = $email_address;
			// replace for validation
			$email_address = str_replace(['ä','ö','ü'], ['ae','oe','ue'], $email_address);
		}

		
		if (filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
			if (!$contains_umlauts) {
				$processed_email = $email_address;
			} else {
				$processed_email = $email_address_orig;
			}
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
				$date_obj = new DateTime($date);
				$processed_date = $date_obj->format($format);
				return true;
			} else {
				return false;
			}
		} catch (Exception $e) {			
			return false;
		}
	}

	public static function processContactDetails(string $contact_number, &$processed_contact_number) {
		if ($contact_number != "") {			
			$contact_number = preg_replace('/\s+/', '', ($contact_number));
			try  {
				$phoneNumberUtil = \libphonenumber\PhoneNumberUtil::getInstance();
				$phoneNumber = $phoneNumberUtil->parse($contact_number, "ZA", null, true);
				$contact_number = $phoneNumberUtil->format($phoneNumber, \libphonenumber\PhoneNumberFormat::E164);
				$processed_contact_number = $contact_number;
				return true;
			} catch (Exception $e) {
				return false;
			}
		} else {
			return false;
		}
	}

	public static function processName(string $name, &$name_container) {
		if ($name != "") {
			if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
				return false;
			} else {
				$name_container = explode(" ", $name);
				return true;
			}
		}
	}
}

?>