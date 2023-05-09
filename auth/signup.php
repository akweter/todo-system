<?php
    session_start();
    error_reporting(E_WARNING || E_NOTICE || E_ERROR);
    include_once("../Database/connection.php");
    
    // Redirect user back to login if not logged in
    if (! empty($_COOKIE['user_logged'])) {
        header("location: ../");
    }
    
    // POST STUDENT DATA TO THE ADMIN DB
    if(isset($_POST['Signup'])){
        $username = htmlspecialchars($_POST['username']);
        $user_phone = htmlspecialchars($_POST['new_telephone']);
        $user_passwd = htmlspecialchars($_POST['pass1']);
        $hash_user_passwd = password_hash($user_passwd, PASSWORD_DEFAULT);
        $pass_confirm = $_POST['pass2'];
        
        if (($user_passwd) !== ($pass_confirm)) {
            $wrong_input = '
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Passwords do not match</strong>
                </div>';
                exit();
        }
            // Comaparing user info to the one in the database
            $Data = "SELECT * FROM `_users` WHERE telephone = '$user_phone' OR username = '$username' ";
            $Query = mysqli_query($conn, $Data) or die("Error fetching password");

            if(mysqli_num_rows($Query) > 0){
                $user_exists = '
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Number or Username exist!</strong></br><span>Please <a class"text-decoration-none" href="../">log in</a></span>
                    </div>';
            }
            else{
                mysqli_query($conn, "INSERT INTO `_users`(`users_id`, `telephone`, `username`, `password`, `level`) VALUES(0,'$user_phone', '$username', '$hash_user_passwd', 'user')");
                
                setcookie("username", $username, time() + (86400 * 24), "/project/todo/");
                setcookie("user_logged", 'true', time() + (86400 * 24), "/project/todo/");
                $user_added = '
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>You are added sucessfully</strong>
                        <a href="../" class="nav-link text-decoration-none text-primary">Visit Dashboard</a>
                    </div>';
            }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Class Attendance Records Software">
        <meta name="author" content="James Akweter">
        <meta name="generator" content="Angel Dev Team">
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <title>Sign Up</title>
        <link rel="stylesheet" href="../../../node_modules/bootstrap.min.css">
        <link rel="stylesheet" href="../styles/signup.css">
    </head>
    <body class="text-center">
        <main class="form-signin m-auto bg-light">
            <form method="post">
                <div class="modal-header"><h1 class="modal-title fs-3 mb-3">Sign Up</h1></div>
                <?php if(isset($wrong_input)){echo($wrong_input);} if(isset($user_exists)){echo($user_exists);} if(isset($user_added)){echo($user_added);}?>
                <div class="form-floating mb-2">
                    <input type="text" class="form-control" required name="username" placeholder="Username" title="Must contain alphabet and characters">
                    <label for="username">Username</label>
                </div>
                <div class="form-floating">
                    <input type="text" class="form-control" required id="phone_number" name="new_telephone" placeholder="Telephone Number">
                    <label for="phone_number">Telephone</label>
                </div>
                <span id="invalid_num" class="invalid_num">Numeric only and spaces no allowed</span>
                <div class="form-floating">
                    <input type="password" id="psw" id="psw password" name="pass1" required class="form-control" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at number, uppercase, lowercase and 8 or more characters">
                    <label for="password">Password</label>
                </div>
                <div class="form-floating mb-1">
                    <input required type="password" name="pass2" class="form-control rounded-3" id="pass2" title="Input same password" placeholder="Comfirm Password">
                    <label for="pass2">Confirm Password</label>
                </div>
                <div id="message">
                    <strong>Password must contain:</strong><br>
                    <span id="letter" class="invalid">Lowercase<span><br>
                    <span id="capital" class="invalid">Uppercase<span><br>
                    <span id="number" class="invalid"> Numbers<span><br>
                    <span id="length" class="invalid">8 characters Mininum<span>
                </div>  
                    <hr>
                    <div>
                        <button class="form-control mb-1 btn btn-lg rounded-3 btn-outline-primary" name="Signup" type="submit">Register</button><br/>
                        <div class='mt-1'>Already a member?</div>
                        <a href="login.php" class="btn btn-sm btn-outline-primary text-decoration-none mt-2">Log in</a>
                    <div>
                    <span class="text-muted">&copy; <?php echo date("Y");?> Todo Management System</span>
                </div>
            </form>
        </main>
        <script src="../scripts/login_validation.js"></script>
    </body>
</html>
