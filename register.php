<?php
date_default_timezone_set("Asia/Manila");
// Page Title
$pageTitle = 'Register';

// Initialize the session
session_start();

if ((isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) && (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true)) {
    // Check if the user is already logged in and authenticated, if yes then redirect him to home page
    header('location: home.php');
    exit;
} elseif (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Check if the user is already logged in and not authenticated, if yes then redirect him to enter authentication code page
    header('location: enter_authentication_code.php');
    exit;
}

// Include database config file
require_once 'database.php';

// Define variables and initialize with empty values
$username = $password = $confirm_password = $email = '';
$username_err = $password_err = $confirm_password_err = $email_err = '';
$usertag = $usertag_err = '';

// Processing form data when form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Validate username
    if (empty(trim($_POST['username']))) {
        $username_err = 'Please enter a username.';
    } else {
        // Prepare a select statement
        $sql = 'SELECT id FROM users WHERE username = ?';

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, 's', $param_username);

            // Set parameters
            $param_username = trim($_POST['username']);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = 'User already exist.';
                } else {
                    $username = trim($_POST['username']);
                }
            } else {
                header('location: error.php');
                exit;
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Validate password
    if (empty(trim($_POST['password']))) {
        $password_err = 'Please enter a password.';
    } elseif (strlen(trim($_POST['password'])) < 8) {
        $password_err = 'Password must be 8 characters and above.';
    } else {
        $password = trim($_POST['password']);

        $containLowercase = preg_match('/[a-z]/', $password);
        $containUppercase = preg_match('/[A-Z]/', $password);
        $containDigit = preg_match('/\d/', $password);
        $containSpecialCharacter = preg_match('/[^a-zA-Z\d]/', $password);

        if (!$containLowercase) {
            $password_err = 'Password must contain lowercase.';
        } elseif (!$containUppercase) {
            $password_err = 'Password must contain uppercase.';
        } elseif (!$containDigit) {
            $password_err = 'Password must contain number.';
        } elseif (!$containSpecialCharacter) {
            $password_err = 'Password must contain special character.';
        }
    }

    // Validate confirm password
    if (empty(trim($_POST['confirm_password']))) {
        $confirm_password_err = 'Please confirm password.';
    } else {
        $confirm_password = trim($_POST['confirm_password']);

        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = 'Password did not match.';
        }
    }

    // Validate email
    if (empty(trim($_POST['email']))) {
        $email_err = 'Please enter email.';
    } else {
        $email = trim($_POST['email']);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = 'Invalid email format.';
        }
    }

    if (isset($_POST['usertag']) == 0) {
        $usertag_err = 'Please choose if admin or user.';
    } else {
        $usertag = trim($_POST['usertag']);
    }

    // Check input errors before inserting in database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err) && empty($usertag_err)) {

        // Prepare an insert statement
        $sql = 'INSERT INTO users (username, password, email, usertag) VALUES (?, ?, ?, ?)';

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, 'ssss', $param_username, $param_password, $param_email, $param_usertag);

            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_email = $email;
            $param_usertag = $usertag;
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                $stmt1 = $conn->prepare("INSERT INTO activity_log (activity, user_name) VALUES (?, ?)");
                $stmt1->bind_param("ss", $activity, $username);
                             
                // set parameters and execute
                $activity = "Signed Up";
                $username = $username;
                            
                $stmt1->execute();
                $stmt1->close();

                header('location: register.php?success=Congratulations! You may now sign in your account.');
            } else {
                header('location: error.php');
                exit;
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
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

    <!-- Sign in -->
    <div>
        <div style="width: 500px;padding-top:50px;">
            <div>
                <!-- Card title -->
                
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <h2>SIGN UP</h2>
                    <?php if (isset($_GET['success'])) { ?>
                    <p class="success"><?php echo $_GET['success']; ?></p>
                    <?php } ?>
                    <!-- Username -->
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="form-control <?php if (!empty($username_err)) {echo 'is-invalid';} ?> mt-3" value="<?php echo $username; ?>" placeholder="Username" style="display: block;border: 2px solid #808080;width: 95%;padding: 10px;margin: 10px auto;border-radius: 5px;">
                    <div class="invalid-feedback">
                        <?php echo $username_err; ?>
                    </div>
                    <!-- Password -->
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control <?php if (!empty($password_err)) {echo 'is-invalid';} ?> mt-3" placeholder="Password" style="display: block;border: 2px solid #808080;width: 95%;padding: 10px;margin: 10px auto;border-radius: 5px;">
                    <div class="invalid-feedback">
                        <?php echo $password_err; ?>
                    </div>
                    <!-- Confirm Password -->
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control <?php if (!empty($confirm_password_err)) {echo 'is-invalid';} ?> mt-3" placeholder="Confirm Password" style="display: block;border: 2px solid #808080;width: 95%;padding: 10px;margin: 10px auto;border-radius: 5px;">
                    <div class="invalid-feedback">
                        <?php echo $confirm_password_err; ?>
                    </div>
                    <!-- Email -->
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" class="form-control <?php if (!empty($email_err)) {echo 'is-invalid';} ?> mt-3" value="<?php echo $email; ?>" placeholder="Email" style="display: block;border: 2px solid #808080;width: 95%;padding: 10px;margin: 10px auto;border-radius: 5px;">
                    <div class="invalid-feedback">
                        <?php echo $email_err; ?>
                    </div>
                    <div class="radiobutton" style="display:inline-block;white-space:nowrap;">
                        <input type="radio" id="usertag" name="usertag" style="display:inline-block;" value="admin">
                        <label for="usertag">admin</label><br>
                        <input type="radio" id="usertag" name="usertag" style="display:inline-block;" value="user">
                        <label for="usertag">user</label>
                    </div>

                    <!-- Sign up button -->
                    <div class="mt-3">
                        <button type="submit">Sign Up</button><Br><Br>
                        <a href="index.php" class="ca"><Br>Already have account</a>
                    </div>
                    <br><br><Br>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>
</body>

</html>