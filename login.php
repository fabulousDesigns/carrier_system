<?php
// Initialize the session
session_start(); 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: track.php");
    exit;
} 
// Include config file
require_once "./config/config.php";
// Define variables and initialize with empty values
$telephone = "";
$telephone_err = $login_err = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if telephone is empty
    if(empty(trim($_POST["telephone"]))){
        $telephone_err = "Please enter phone number.";
    } else{
        $telephone = trim($_POST["telephone"]);
    }
    // Validate credentials
    if(empty($telephone_err)){
        // Prepare a select statement
        $sql = "SELECT id,first_name,telephone FROM shippers WHERE telephone = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_telephone);
            // Set parameters
            $param_telephone = $telephone;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                // Check if telephone exists, if yes then bind parameters and start a session
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $first_name, $telephone);
                    if(mysqli_stmt_fetch($stmt)){
                            session_start();
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["first_name"] =$first_name;
                            $_SESSION["telephone"] = $telephone;                            
                            // Redirect user to welcome page
                            header("location: track.php");
                       
                    }
                } else{
                    // telephone doesn't exist, display a generic error message
                    $login_err = "Invalid telephone number";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    // Close connection
    mysqli_close($conn);
}
?>
<?php
include_once('./config/header.php');
?>

<body>
    <div class="container">
        <div class="form__box">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="login-form">
                <?php 
                if(!empty($login_err)){
                    echo '<div class="alert danger-alert">'.$login_err .'<a class="close">&times;</a>'.'</div>';
                }        
                ?>
                <div class="form__heading">
                    <h4>LOGIN HERE</h4>
                </div>
                <div class="form__control">
                    <input type="tel" name="telephone" id="tel" placeholder="Your Phone Number" required
                        <?php echo (!empty($telephone_err)) ? 'is-invalid' : ''; ?> value="<?php echo $telephone; ?>">
                    <span class="invalid-feedback"><?php echo $telephone_err; ?></span>
                </div>
                <button type=" submit" name="submit" class="btn btn-primary lgn">LOGIN</button>
            </form>
        </div>
    </div>
    <script>
    $(".close").click(function() {
        $(this)
            .parent(".alert")
            .fadeOut();
    });
    </script>
</body>

</html>