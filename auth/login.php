<?php
    session_start();
    error_reporting(E_WARNING || E_NOTICE || E_ERROR);
    include_once("../Database/connection.php");
    
    // Redirect user back to login if not logged in
    if (! empty($_COOKIE['user_logged'])) {
        header("location: ../");
    }

    if(isset($_POST['signin'])){
        $user_passd = htmlspecialchars($_POST['passd']);
        $user_phone = htmlspecialchars($_POST['new_telephone']);

        // Fetch all users from the database SELECT * FROM `_users` WHERE
        $Fetch = mysqli_query($conn, "SELECT * FROM _users WHERE telephone = '$user_phone' ") or die("Fatal Server Error");
        
        if (is_numeric($Fetch)) {
            $not_registed = "
            <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Seems you're not registerd</strong> <a class='text-decoration-none' href='signup.php'>Sign Up</a>
            </div>";
            exit();
        }
        else{
            while($query = mysqli_fetch_array($Fetch)){
                $db_user_pass = $query['password'];
            }

            // VERIFY HASH PASSWORD IN THE DATABASE
            if (password_verify($user_passd, $db_user_pass)) {

                // Fetch username and save it to cookies
                $fetch_username = mysqli_query($conn, "SELECT * FROM `_users` WHERE $user_phone='new_telephone' ");
                while($seacr = mysqli_fetch_array($Fetch)){
                    $db_username = $seacr['username'];
                }
                setcookie("username", $db_username, time() + (86400 * 24), "/project/todo/");
                setcookie("user_logged", 'true', time() + (86400 * 24), "/project/todo/");
                header('location: ../');
            }
            else {
                $message = ' 
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Wrong Password</strong>
                </div>';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Todo Management System">
        <meta name="author" content="James Akweter">
        <meta name="generator" content="Angel Dev Team">
        <link rel="apple-touch-icon" sizes="180x180" href="https://clickup.com/blog/wp-content/uploads/2022/12/technical-debt.png">
        <title>Login</title>
        <link rel="stylesheet" href="../../../node_modules/bootstrap.min.css">
        <link rel="stylesheet" href="../styles/login.css">
    </head>
    <body class="text-center">
        <main class="container mt-5">
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-8 form-signin m-auto bg-light w-50">
                    <form method="post">
                        <img style="border-radius: 30%" class="mb-2" src="https://clickup.com/blog/wp-content/uploads/2022/12/technical-debt.png" alt="" width="50" height="50">
                        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
                        <?php if (isset($not_registed)) { echo($not_registed); } ?>
                        <?php if (isset($message)) { echo($message); } ?>
                        <?php if (isset($login_success)) {echo($login_success); } ?>

                        <div class="form-floating">
                            <input type="text" class="form-control" required id="phone_number" name="new_telephone" placeholder="Telephone Number">
                            <label for="floatingInput">Telephone</label>
                        </div>

                        <span id="invalid_num" class="invalid_num">Numeric only and spaces no allowed</span>

                        <div class="form-floating">
                            <input id="psw" type="password"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at number, uppercase, lowercase and 8 or more characters" required class="form-control" name="passd" id="password" placeholder="Password">
                            <label for="password">Password</label>
                        </div>

                        <div id="message">
                            <strong>Password must contain:</strong><br>
                            <span id="letter" class="invalid">Lowercase<span><br>
                            <span id="capital" class="invalid">Uppercase<span><br>
                            <span id="number" class="invalid"> Numbers<span><br>
                            <span id="length" class="invalid">8 characters Mininum<span>
                        </div>

                        <div>
                            <a class="text-decoration-none" href="#">Forget Password</a>
                        </div>        
                        <div class="checkbox mb-3">
                            <label><input type="checkbox" value="remember-me"> Remember me</label>
                        </div>

                        <button class="w-100 btn btn-lg btn-primary" name="signin" type="submit">Sign in</button><br/>
                        <div class='mt-3'>Don't have a account?</div>
                        <a href="signup.php" class="btn btn-sm btn-outline-primary text-decoration-none mt-2">Sign up</a>
                        <p class="mt-2 mb-3 text-muted">&copy; <?php echo date("Y");?> Todo Management System</p>
                    </form>
                </div>
                <div class="col-sm-2"></div>
            </div>
        </main>
        
        <script src="../../../node_modules/bootstrap.min.js"></script>
        <script src="../scripts/login_validation.js"></script>
    </body>
</html>

