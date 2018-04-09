<?php


use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

require 'vendor/autoload.php';
require 'file_handler.php';

define(__UPLOAD_PATH__, 'assets/');

function moveFile(&$target_file) {
	$target_dir = __UPLOAD_PATH__;
	$target_file = $target_dir . basename($_FILES["userfile"]["name"]);
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

	if (move_uploaded_file($_FILES["userfile"]["tmp_name"], $target_file)) {
		return true;
	}
}

function write($spreadsheet) {
	echo "writing";
	
	$writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
	$writer->setDelimiter(',');
	$writer->setEnclosure('');
	$writer->setLineEnding("\r\n");
	$writer->setSheetIndex(0);

	$writer->save(__UPLOAD_PATH__ . "reworked.csv");
}

function simpleRead($target_file) {
	echo "reading";
	$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
	$reader->setReadDataOnly(true);
	$spreadsheet = $reader->load($target_file);

 	return $spreadsheet;
}

if (moveFile($target_file)) {
	echo $target_file;
	$spreadsheet = simpleRead($target_file);
	write($spreadsheet);	
}

die();

/*var_dump($_FILES);*/

$file_handler = new FileHandler($_FILES['userfile']['name']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Code Test</title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="shortcut icon" href="img/logo.png"/>
	<link rel="stylesheet" href="css/menu.css"/>
	<link rel="stylesheet" href="css/main.css"/>
	<link rel="stylesheet" href="css/bgimg.css"/>
	<link rel="stylesheet" href="css/font.css"/>
	<link rel="stylesheet" href="css/font-awesome.min.css"/>
	<script type="text/javascript" src="js/jquery-1.12.4.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<!-- <script src="script.js"></script> -->
</head>
<body>
	<div class="menu">
		<a href="#" class="bars" id="bars">
			<i class="fa fa-bars"></i>
		</a>
		<ul id="menu-list">
			<li>
				<a href="/">Home</a>
			</li>
		</ul>
	</div>
	<div class="background"></div>
	<div class="backdrop"></div>
	<div class="login-form-container" id="login-form">
		<div class="login-form-content">
			<div class="login-form-header">
				<div class="logo">
					<img src="img/logo.png"/>
				</div>
				<h3><?= $file_handler->getFileName() ?></h3>
			</div>
			<div>
				<?= file_get_contents($_FILES["userfile"]["tmp_name"]) ?>
			</div>            
		</div>
	</div>
</body>
</html>