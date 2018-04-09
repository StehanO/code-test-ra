<?php 
define(__UPLOAD_PATH__, 'assets/');

function moveFile(&$target_file) {
	$target_dir = __UPLOAD_PATH__;
	$target_file = $target_dir . basename($_FILES["userfile"]["name"]);
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

	if (move_uploaded_file($_FILES["userfile"]["tmp_name"], $target_file)) {
		return true;
	}
}

if (moveFile($target_file)) {
	if ($xlsx = SimpleXLSX::parse($target_file)) {		
		$array_of_records = $xlsx->rows();
		if ($array_of_records != null) {			
			$data_obj = new DataHandler($array_of_records);
			if ($data_obj != null) {
				$data_obj->init();
			}
		}
	} else {
		echo SimpleXLSX::parse_error();
	}
}