<?php
include 'database.php';



$path = "C:/xampp1/htdocs/LabAct5-Villanueva-BSIT3C/PHP/Database/link.sql";
$backup = exec('/xampp1/mysql/bin/mysqldump --user-' . $DB_USERNAME . ' --password-' . $DB_PASSWORD . ' --host-' . $DB_SERVER . ' ' . $DB_NAME . ' > ' . $path . '');

if (isset($_POST['backup'])) {
	if (file_exist($path)) {

		echo "Backup Success";
		echo "<br>";
	}
	else {

		echo "Backup failed!";
		echo "<br>";
		echo "Backup of " . $DB_NAME . " does not exist in " . $path;
	}

}

if (isset($_POST['download'])) {
	if (file_exist($path)) {

		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename-"'.basename($path). '"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($path));
		readfile($path);
		exit;
	}
	else {

		echo "File does not exist!";

	}
}
?>