<?php
if (isset($_GET['logout'])) {
    setcookie("user_logged", "", time() - 3600, "/project/todo/");
    setcookie("username", "", time() - 3600, "/project/todo/");
    header("location: login.php");
}
?>