<?php

Class Record {

	public $name = "";
	public $surname = "";
	public $contact_number = "";
	public $email = "";
	public $join_date = "";

	public $error = [];

	public function __construct() {
	}

	/**
	 * Init calls relavant functions to load and validate the details;
	 * @return type
	 */
	public function setName(string $name) {
		$this->name = $name;
	}

	public function setSurname(string $surname) {
		$this->surname = $surname;
	}

	public function setContactNumber(string $contact_number) {
		$this->contact_number = $contact_number;
	}

	public function setEmail(string $email) {
		$this->email = $email;
	}

	public function setJoinDate(string $joined_date) {
		$this->joined_date = $joined_date;
	}

	public function setErrors(array $errors) {
		$this->errors = $errors;
	}
}

?>