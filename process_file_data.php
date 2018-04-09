<?php 
define(__UPLOAD_PATH__, 'assets/');
$FError = "";

/**
 * Check if a valid file is uploaded and moves it to assets to use
 * @param type &$target_file name of the file
 * @return bool
 */
function moveFile(&$target_file) {
	if ($_FILES["userfile"]["name"] != "")	{
		$target_dir = __UPLOAD_PATH__;
		$target_file = $target_dir . basename($_FILES["userfile"]["name"]);
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

		if (move_uploaded_file($_FILES["userfile"]["tmp_name"], $target_file)) {
			return true;
		}
	} else {
		header("location: /");
	}
}

if (moveFile($target_file)) {
	if ($xlsx = SimpleXLSX::parse($target_file)) {		
		$array_of_records = $xlsx->rows();
		if (count($array_of_records) > 0) {
			if (class_exists("DataHandler")) {
				//create new datahandler object if the class exists and the is data in the xlsx loader
				$data_obj = new DataHandler($array_of_records);
				if ($data_obj != null) {					
					$data_obj->init();
				}
			} else {
				header("location: /");	
			}
		} else {
			$FError = "Incorrect File Uploaded. Please select a valid data file. (.xlsx)";	
		}
	} else {
		$FError = "Incorrect File Uploaded. Please select a valid data file. (.xlsx)";
		unlink($target_file);
	}
}