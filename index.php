<?php
    include_once('./Database/connection.php');
    include_once('./Database/connection.php');

    if(isset($_POST['add']) && (! empty($_POST['task']))){
            $task = $_POST['task'];
            $Data = $conn->query("INSERT INTO `task1` (`task_id`, `task`, `status`, `deleted`)  VALUES('', '$task', '', 'not') ");

            //redirect back home
            header('location:./index.php');
        }

    // Update task
    if(! empty($_GET['editId'])){
        $Newtask = $_GET['editId'];
        $conn->query("UPDATE `task1` SET `status` = 'Done'  WHERE `task_id` = $Newtask") or die(mysqli_errno($conn));
        header('location:./index.php');
    } 

    // Deleted task
    if (isset($_GET['del_id'])) {
        $del_id = $_GET['del_id'];
        
        $Data = $conn->query("SELECT * FROM `task1` WHERE task_id=$del_id");
        while ($Val = $Data->fetch_array()) {
            $Task = $Val['task'];
            $Status = $Val['status'];
        }
        $conn->query("UPDATE `task1` SET `task`='$Task',`status`='$Status',`deleted`='yes' WHERE task_id = '$del_id' ") or die(mysqli_errno($conn));

        //redirect back home
        header("location:./index.php");
    }

    // Activate task 
    if(! empty($_GET['activate'])){
        $active = $_GET['activate'];

        $Data = $conn->query("SELECT * FROM `task1` WHERE task_id=$active");
        while ($Val = $Data->fetch_array()) {
            $TaskV = $Val['task'];
            $t_id = $Val['task_id'];
        }
        $conn->query("UPDATE `task1` SET `task`='$TaskV',`status`='',`deleted`='not' WHERE task_id = '$t_id'  ");
        header('location:./index.php');
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./node_modules/bootstrap.min.css">
    <title>Todo | Track Your Activies</title>
</head>
<body class="bg-info">

    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <a class="navbar-brand" href="https://github.com/john-BAPTIS?tab=repositories"></a>
            </div>
        </nav>
    </header>

    <main style="border-radius:50px 20px" class="container bg-light">
            <h1 class="text-primary text-center">Be On Top Of Affairs</h1>
            <hr style="border-top:2px dotted #ccc;"/>
                <form action="" method="post" style="display:flex;flex-direction:row;gap:4%;">
                            <label class="text-secondary" for="taskLabel"><strong>Whats next?</strong></label>
                            <input class="form-control w-50" type="text" name="task" class="" required id="taskLabel">
                            <button type="submit" name="add" class="btn btn-primary btn-lg" ><div class="fa fa-plus">Add</div></button>
                </form>
                </p>
                <table class="table table-hover">
                    <thead>
                        <tr class="table-dark">
                            <th>#</th>
                            <th>Task</th>
                            <th>Status</th>
                            <th>Update</th>
                            <th>Completed?</th>
                            <th>Erase</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                                    //require database access.
                                    require './Database/connection.php';

                                    //Fetch data from the database.
                                    $Data = $conn->query('SELECT * FROM `task1` WHERE deleted = "not" ORDER BY `task_id` DESC ');
                                    $count = 1;

                                    while ($Val = $Data->fetch_array()) {
                                        $task = $Val['task'];
                                        $task_id = $Val['task_id'];
                                        $task_status = $Val['status'];
                                        ?>
                                        <tr>
                                            <td><?=$count++?></td>
                                            <td><?=$task?></td>
                                            <td><?=$task_status?></td>
                                            <?php
                                                if ($task_status != 'Done') {
                                                    echo ("
                                                        <td><a href='./edit.php?task_id=$Val[task_id]'  class='btn btn-success'>Edit</a></td>
                                                        <td><a href='./?editId=$Val[task_id]' class='btn btn-warning'>Yes</a></td>
                                                        <td> <a href='./?del_id=$Val[task_id]' class='btn btn-danger'>Del</a></td>");
                                                    }
                                                    elseif ($task_status == 'Done') {
                                                        echo ("
                                                            <td></td>
                                                            <td><a href='./?activate=$Val[task_id]' class='btn btn-info'>Redo</a></td>
                                                            <td> <a onclick='return confirm('Are you sure?')' href='./?del_id=$Val[task_id]' class='btn btn-danger'>Del</a></td>");
                                                    }
                                        echo "</tr>";
                                    }

                                    

                            ?>
                    </tbody>
                </table>
            </div>
    </main>


    <footer class="bg-warning p-3">
            <div class="row">
                <div class="flex d-flex">
                    <a href="https://github.com/john-BAPTIS?tab=repositories" target="_blank"><img style="border-radius: 50%;" width="50px" height="50px" src="https://avatars.githubusercontent.com/u/71665600?v=4" alt="Logo"></a>
                    <p>Copyright  © 2023 (Angel Development Team). <strong>Powered by: <a style="text-decoration:none" href="mailto:jamesakweter@gmail.com">Akweter</a></strong></p>
                </div>
            </div>
        </footer>
</body>
</html>
