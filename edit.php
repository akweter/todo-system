
<?php
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
        $newTask = $_POST['EditVal'];
    
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
    <style>
        main{
            background: linear-gradient(skyblue, lightblue);
            padding: 0 0 20% 0;
            border-radius: 5% 15%;
        }
    </style>
    
    <title>Edit Details</title>
</head>
<body>
    
    <main class="container mt-5">
            <h2 class=" pt-3 text-center">Update Task</h2>
            <hr style="border-top:2px dotted #ccc;"/>
                <form action="" method="post">
                    <div class="form-group" style="display:flex;flex-direction:row;">
                        <textarea name="EditVal" class="form-control"><?= $task; ?></textarea>
                        <input type="hidden" name="id" value="<?= $_GET['task_id']; ?>" />
                        <button type="submit" name="Update" class="btn btn-warning" >Update</button>
                    </div>
                </form>
                </p>
            </div>
    </main>

</body>
</html>
