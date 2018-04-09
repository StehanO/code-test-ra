<?php

class FileHandler {

	private $file_name = "";

	public function __construct(string $file_name) {
		$this->file_name = $file_name;
	}

	public function getFileName() {
		return $this->file_name;
	}
}
?>