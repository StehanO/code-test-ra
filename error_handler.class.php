<?php

Class ErrorHandler {

	/**
	 * Validate email address
	 * @param string $email_address 
	 * @param type &$processed_email 
	 * @return boolean
	 */
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

	/**
	 * Check if the email domain exists
	 * @param string $email_address 
	 * @return boolean
	 */
	public static function processEmailDomain(string $email_address) {
		if ($email_address != "") {
			list($user_name, $mail_domain) = explode("@", $email_address);
			$tld = explode('.', $mail_domain, 2)[1];
			//echo "Domain: " . $tld . PHP_EOL;
			if (checkdnsrr($mail_domain, 'A')) {
				return true;
			} else {
				return false;
			}
		}
	}

	/**
	 * Validate join date
	 * @param string $date 
	 * @param string $format 
	 * @param type &$processed_date 
	 * @return boolean
	 */
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

	/**
	 * Validate and format contact number using composer package
	 * @param string $contact_number 
	 * @param type &$processed_contact_number 
	 * @return boolean
	 */
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

	/**
	 * Validate and split name and surname. We assume that the first element is the firstname and ignore incorrect formats
	 * @param string $name 
	 * @param type &$name_container 
	 * @return boolean
	 */
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