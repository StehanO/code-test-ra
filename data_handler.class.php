<?php

Class DataHandler {

	private $file_data_records = array();
	public $valid_data_records = array();

	public $final_array = array();
	public $array_of_headings = array();

	public function __construct(array $dataFromFile) {
		$this->file_data_records = $dataFromFile;
	}

	public function init() {		
		$this->buildReliableSource();
		$this->setHeadings();
		$this->validate();
	}

	private function buildReliableSource() {		
		if ($this->file_data_records != null) {
			for ($i=0; $i < count($this->file_data_records); $i++) {				
				if ($this->file_data_records[$i][1] != "") { // check that the first element is not empty - as per example file
					$this->valid_data_records[$i] = [
						"name" => $this->file_data_records[$i][0], //Column A - Name						
						"contact_number" => $this->file_data_records[$i][2], //Column C - Contanct Number
						"email" => $this->file_data_records[$i][3], //Column D - Email
						"join_date" => $this->file_data_records[$i][6] //Column G - Join Date
					];
				}
			}
		}
	}

	private function validate() {
		if ($this->valid_data_records != null) {
			//build obj
			array_shift($this->valid_data_records);
			foreach ($this->valid_data_records as $record) {
				$final_obj = array();
				$error = array();				
				# name
				if (ErrorHandler::processName($record["name"], $name_array_return)) {
					$final_obj["name"] = array_shift($name_array_return);
					$final_obj["surname"] = implode(" ", $name_array_return);
				} else {
					$final_obj["name"] = $record["name"];
					$error["name"] = "Incorrect Name/Surname Supplied";
				}
				# contact
				if (ErrorHandler::processContactDetails($record["contact_number"], $contact_number)) {
					$final_obj["contact_number"] = $contact_number;
				} else {
					$final_obj["contact_number"] = $record["contact_number"];
					$error["contact_number"] = "Incorrect Contact Number Supplied";
				}
				
				# email
				if (ErrorHandler::processEmail($record["email"], $email_return)) {
					$final_obj["email"] = $email_return;
				} else {
					$final_obj["email"] = $record["email"];
					$error["email"] = "Incorrect Email Supplied";
				}
				# join date
				if (ErrorHandler::processDate($record["join_date"], "Y-m-d", $date_return)) {
					$final_obj["joined_date"] = $date_return;
				} else {
					$final_obj["joined_date"] = $record["join_date"];
					$error["join_date"] = "Incorrect Joined Date Supplied";
				}

				$final_obj["error"] = $error;

				$this->final_array[] = $final_obj;
			}
		}
	}

	public function getFinal() {
		return $this->final_array;
	}

	public function getReport() {		
		if ($this->valid_data_records != null) {
			return $this->valid_data_records;
		}
	}

	public function setHeadings() {
		if ($this->valid_data_records != null) {
			$this->array_of_headings = [];
			$this->array_of_headings["name"] = "Name";
			$this->array_of_headings["surname"] = "Surname";
			$this->array_of_headings["contact_number"] = "Contact Number";
			$this->array_of_headings["email"] = "Email";
			$this->array_of_headings["join_date"] = "Date Joined";
			$this->array_of_headings["error"] = "Errors";
		}
	}

	public function getHeadings() {
		if ($this->array_of_headings != null) {
			return $this->array_of_headings;
		}
	}

	private function populateError() {
		return false;
	}

	private function setNameSurname() {
		$array = [];
		$cname = array_shift($array);
		$string = implode(',', $array);
	}

	private function setContactNumber() {
		$array = [];
		$cname = array_shift($array);
		$string = implode(',', $array);
	}

	private function setEmailNumber() {
		$array = [];
		$cname = array_shift($array);
		$string = implode(',', $array);
	}

	private function setJoinDate() {
		$array = [];
		$cname = array_shift($array);
		$string = implode(',', $array);
	}
}

?>