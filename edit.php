<?php
    session_start();
    error_reporting(E_WARNING || E_NOTICE || E_ERROR);
    include_once('./Database/connection.php');

    // Redirect user to log in if not done so.
    if (empty($_COOKIE['user_logged'])) {
        header("location: auth/login.php");
    }

    //Fetch id data from user action
    require_once('./Database/connection.php');

    //Get task id into the form
    if (isset($_GET['task_id'])) {
        $NewV = $_GET['task_id'];
        $Data = $conn->query("SELECT * FROM `task1` WHERE task_id=$NewV");
        while ($Val = $Data->fetch_array()) {
            $task = $Val['task'];
        } 
    }

    if(isset($_POST['Update']) && ($_POST['EditVal'] != "")){
        $id = $_POST['id'];
        $newTask = htmlspecialchars($_POST['EditVal']);
        $conn->query("UPDATE `task1` SET `task`='$newTask' WHERE $id=task_id") or die(mysqli_errno($conn));
        //redirect back home
        header("location:./index.php");
    }
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./node_modules/bootstrap.min.css">    
    <title>Edit Details</title>
    <style>
        body{
            margin-top: 15%;
            background: gray;
        }
        .modal-content{ border-radius: 20px}
    </style>
</head>
<body>
    <div class="modal-dialog">
        <div class="modal-content bg-info">
            <form action="" method="post">
                <div class="text-center modal-header">
                    <h1 class="modal-title fs-2 text-white">Update Task</h1>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <textarea name="EditVal" rows="2" cols="12" class="form-control"><?= $task; ?></textarea>
                        <input type="hidden" name="id" value="<?= $_GET['task_id']; ?>" />
                    </div>
                </div>
                <div class="modal-footer" style="justify-content: center;">
                    <a href='./' class="btn btn-danger btn-lg">Cancel</a>
                    <button type="submit" name="Update" class="btn btn-warning btn-lg">Save changes</button>
                </div>
            </form>
        </div>
    </div>

        <footer class="footer bg-info text-white p-3 fixed-bottom">
            <div class="row">
                <div class="flex d-flex"  style='gap: 20px; justify-content: center;'>
                    <a href="https://github.com/john-BAPTIS?tab=repositories" target="_blank"><img style="border-radius: 50%;" width="50px" height="50px" src="https://avatars.githubusercontent.com/u/71665600?v=4" alt="Logo"></a>
                    <p>Copyright  © 2023 (Angel Development Team). <strong>Powered by: <a style="text-decoration:none" href="mailto:jamesakweter@gmail.com">Akweter</a></strong></p>
                </div>
            </div>
        </footer>

</body>
</html>
