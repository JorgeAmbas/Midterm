<?php
date_default_timezone_set("Asia/Manila");
// Page Title

$pageTitle = 'Admin Page';

// Initialize the session
session_start();
include "database.php";
$username = '';
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false) {
	// Check if the user is not logged in, if yes then redirect him to login page
	header('location: index.php');
	exit;
} else if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] === false) {
	// Check if the user is not authenticated, if yes then redirect him to enter authentication code page
	header('location: enter_authentication_code.php');
	exit;
  }

  $username = "root";
  $password = "";
  $host = "localhost";
  $databasename = "link";
  $path = "C:/xampp/htdocs/LabAct5-Alucitain-BSIT3C/PHP/Database/".$databasename.".sql";
  $backup = '/xampp/mysql/bin/mysqldump -u '.$username.'--host-'.$host .' '.$databasename.' > '.$path.'';
if (isset($_REQUEST['mysqlbackup'])){

	if (isset($_POST['backup'])) {
		if (file_exists($path)) {

			echo "Backup Success";
			echo "<br>";
			exec($backup);
			echo($backup);

		}
		else {

			echo "Backup failed!";
			echo "<br>";
			echo "Backup of " . $databasename . " does not exist in " . $path;
		}

	}

	if (isset($_POST['download'])) {
		if (file_exists($path)) {

			header('Content-Description: File Transfer');
	        header('Content-Type: application/octet-stream');
	        header('Content-Disposition: attachment; filename="'.basename($path).'"');
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
}

if (isset($_POST['logout'])) {
	$sql = 'SELECT id, username, password FROM users WHERE username = ?';

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, 's', $param_username);

            // Set parameters
            $param_username = $username;
		 	$stmt1 = $conn->prepare("INSERT INTO activity_log (activity, user_name) VALUES (?, ?)");
         	$stmt1->bind_param("ss", $activity, $username);
         
        	// set parameters and execute
         	$activity = "Logged out";
         	$username = ($_SESSION["username"]);
        
         	$stmt1->execute();
         	$stmt1->close();
       
       		// Redirect to login page        
        	header("location: logout.php" );
    }
    mysqli_close($conn);	
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Title -->
	<title><?php echo $pageTitle; ?></title>

    <!-- Styles -->
    <link rel="stylesheet" href="css/bootstrap1.css">
    <link rel="stylesheet" href="css/min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous">   
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<style type="text/css">
    body{ font: 14px fantasy; 
    padding-top: 40px;
    padding-bottom: 40px;
    background: linear-gradient(90deg, rgba(251,239,223,1) 0%, rgba(255,221,146,1) 100%);
    height: 100%;
    background-position: absolute;
    background-repeat: no-repeat;
    background-size: cover;
    color: white;
}

    .wrapper{
        margin-left: 600px;
        margin-top: 170px;
    }
    .wrapper input{
       
        margin-left: -30px;
        
        width: 380px;

    }
    .wrapper label{
       
       margin-left: -30px;
       
   

   }
    .wrapper .btn{
        margin-left: 25px;
        width: 210px;
 
        
    }
    h1{
            
            font-size: 40px;
            font-weight: bold;
            margin-top: -40px;
            margin-left: 100px;
        }
   
  






</style>
</head>

<body>

	<!-- Welcome message -->
	<div style="height: 100%;padding-top:300px;">
		<div>
			<div>
				<div>
					<h2 style="color: black;" align="center">Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h2>
					<br><br>
					<div style="padding-right: 5px;">
						<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" style="height:300px;">
						<div style="padding-left: 14px;">
							<a href="forgot_password.php" class="btn btn-default"style="background-color: gray;text-align: center;color:white;float:left;width:452px;height:43px;">Reset Password</a><br>
						</div><br>
						
							<button type="submit" name="logout" id="logout" style="height:45px;">Log Out</button>
						<div class="radiobutton" style="display:inline-block;white-space:nowrap;">
	                        <input type="radio" id="backup" name="backup" style="display:inline-block;padding:0;margin:0;">
	                        <label for="backup" style="display:inline-block;padding:0;margin:0">Backup</label><br>
	                        <input type="radio" id="download" name="download" style="display:inline-block;padding:0;margin:0" value="download">
	                        <label for="download" style="display:inline-block;padding:0;margin:0">Download</label>
                    	</div>
                    	<button type="submit" name="mysqlbackup" id="mysqlbackup" style="height:45px;margin-left:15px;">MySQL Backup</button><p></p><Br><p></p>
                    	<button type="button" class="" style="float:left;margin-left:12px;width:95%;" name="view" onclick="window.location.href='../PHP/generatepdf.php'">View Users</button>

			        	</form>

					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Scripts -->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>
</body>

</html>