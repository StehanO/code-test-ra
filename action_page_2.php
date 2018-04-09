<?php

require 'simplexlsx.class.php';
require 'file_handler.class.php';
require 'data_handler.class.php';

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Code Test</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="css/style.css">
	<link rel="shortcut icon" href="img/logo.png"/>
	<link rel="stylesheet" href="css/menu.css"/>
	<link rel="stylesheet" href="css/main.css"/>
	<link rel="stylesheet" href="css/bgimg.css"/>
	<link rel="stylesheet" href="css/font.css"/>
	<link rel="stylesheet" href="css/font-awesome.min.css"/>

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>	
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
	<div class="login-form-container" id="login-form" style="max-width: 1000px; margin-left: -500px; margin-bottom: 250px; font-size: 12px">
		<div class="login-form-content">
			<?
			$processed_data = $data_obj->getReport();			
			$headings = $data_obj->getHeadings();

			if ($processed_data != null) {	
				?>
				<table class="table">
					<?
					if ($headings != null) {
						?>
						<thead style="font-size: 11px; text-align: left;">
							<th>#</th>
							<th><?= ucwords($headings["name"]) ?></th>							
							<th><?= ucwords($headings["surname"]) ?></th>
							<th><?= ucwords($headings["contact_number"]) ?></th>
							<th><?= ucwords($headings["email"]) ?></th>
							<th><?= ucwords($headings["join_date"]) ?></th>
							<th><?= ucwords($headings["error"]) ?></th>
						</thead>
						<?
					}
					?>
					<tbody>
						<?						
						$cnt = 0;
						foreach($data_obj->getFinal() as $processed_data) {							
							$cnt++;
							?>
							<tr style="font-size: 11px">
								<td><?= $cnt . "." ?></td>
								<td><?= @$processed_data["name"] != "" ? $processed_data["name"] : "" ?></td>
								<td><?= @$processed_data["surname"] != "" ? $processed_data["surname"] : "" ?></td>
								<td><?= @$processed_data["contact_number"] != "" ? $processed_data["contact_number"] : "" ?></td>
								<td><?= @$processed_data["email"] != "" ? $processed_data["email"] : "" ?></td>
								<td><?= @$processed_data["joined_date"] != "" ? $processed_data["joined_date"] : "" ?></td>
								<td>
									<?
									if ($processed_data["error"] != "") {
										$error_data = "";
										foreach ($processed_data["error"] as $key => $value) {
											$error_data .= $value . "</br>";
										}
									}
									if ($error_data != "") {
										?>
										<a tabindex="0" role="button" data-toggle="popover" data-trigger="focus" title="Errors Found" data-content="<?= $error_data ?>">
											<i class="fa fa-exclamation-circle" style="color: #ffc107"></i>
										</a>
										<?
									} else {
										?>
										<i class="fa fa-check-circle" style="color: #28a745"></i>
										<?
									}
									?>
								</td>
							</tr>
							<?							
						}
						?>
					</tbody>
				</table>
				<?
			}			
			?>
		</div>
	</div>
	<script type="text/javascript">
		$(function () {
			$('[data-toggle="popover"]').popover({html:true});
		})
	</script>
</body>
</html>