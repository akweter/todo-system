<?php
// openai tokenKey | say-hi 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
    session_start();
    error_reporting(E_WARNING || E_NOTICE || E_ERROR);
    include_once('./Database/connection.php');

    // Redirect user to log in if not done so
    $user_logg = $_COOKIE['user_logged'];
    if (empty($user_logg)){
        header("location: auth/login.php");
    }
    
    // Add new task
    if(isset($_POST['add']) && (! empty($_POST['task']))){
        $task = htmlspecialchars($_POST['task']);
        $Data = $conn->query("INSERT INTO `task1` (`task_id`, `task`, `status`, `deleted`)  VALUES(0, '$task', '', 'not') ");
        header('location:./');
    }

    // Done task
    if(! empty($_GET['editId'])){
        $Newtask = $_GET['editId'];
        $conn->query("UPDATE `task1` SET `status` = 'Done'  WHERE `task_id` = $Newtask") or die(mysqli_errno($conn));
        header('location:./');
    } 

    // Deleted task
    if (isset($_GET['del_id'])) {
        $del_id = $_GET['del_id'];
        $conn->query("UPDATE `task1` SET `deleted`='yes' WHERE task_id = '$del_id' ") or die(mysqli_errno($conn));
        header("location:./");
    }

    // Redo task 
    if(! empty($_GET['activate'])){
        $active = $_GET['activate'];
        $conn->query("UPDATE `task1` SET `status`='', `deleted`='not' WHERE task_id = '$active'  ");
        header('location:./');
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="apple-touch-icon" sizes="180x180" href="https://clickup.com/blog/wp-content/uploads/2022/12/technical-debt.png">
        <link rel="stylesheet" href="./node_modules/bootstrap.min.css">
        <title>Todo | Track Your Activies</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
        <style>
            .fa-danger{ color: red;}
            .fa-repeat{ color: #01EDC6;}
            .fa-check{ color: #F8CE54;}
            .done{ color: #040695; font-weight: bold;}
            .footer{ background: linear-gradient(#E8D498, #98E8E4);}
        </style>
    </head>
    <body class="bg-info">        
        <main>
            <div class='row mt-4'>
                <div class="col-sm-2"></div>
                <div class="col-sm-8 container bg-light mb-2" style="border-radius:50px 20px;">
                    <h2 class="text-primary text-center">Todo Management
                        <a href="auth/logout.php?logout" class="text-decoration-none btn btn-sm btn-outline-danger m-2" style="float:right">Log Out</a>
                    </h2>
                    <hr style="border-top:2px dotted #ccc;"/>
                    <form action="" method="post" class='flex d-flex' style='gap: 20px; justify-content: center;'>
                        <label class="text-warning fs-3" for="taskLabel">Whats next?</label>
                        <input class="form-control w-50" type="text" name="task" class="" required id="taskLabel">
                        <button type="submit" name="add" class="btn btn-outline-primary" >Add <div class="fa fa-plus"></div></button>
                    </form>
                    </p>
                    <table class="table table-hover">
                        <thead>
                            <tr class="table-success">
                                <th>#</th>
                                <th>Routines</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>D/R</th>
                                <th>Del</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
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
                                    <td class='done'><?=$task_status?></td>
                            <?php
                            if ($task_status != 'Done') { ?>
                                <td><a href='./edit.php?task_id=<?=$Val['task_id']?>'  class='text-info'><i class='fa fa-pencil-square-o fa-lg ' aria-hidden='true'></i></a></td>
                                <td><a href='./?editId=<?=$Val['task_id']?>'><i class='fa fa-check fa-lg' aria-hidden='true'></i></a></td>
                                <td> <a href='./?del_id=<?=$Val['task_id']?>'><i class='fa fa-trash-o fa-danger fa-lg'></i></a></td>
                            <?php }
                            elseif ($task_status == 'Done') { ?>
                                <td></td>
                                <td><a href='./?activate=<?=$Val['task_id']?>'><i class='fa fa-repeat fa-lg' aria-hidden='true'></i></a></td>
                                <td> <a href='./?del_id=<?=$Val['task_id']?>'><i class='fa fa-trash-o fa-danger fa-lg'></i></a></td>
                            <?php } ?>
                            </tr>
                            <?php }
                        ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-2"></div>
            </div>
        </main>
        
        <footer class="footer p-2 fixed-bottom">
            <div class="row">
                <div class="flex d-flex"  style='gap: 20px; justify-content: center;'>
                    <a href="https://github.com/john-BAPTIS?tab=repositories" target="_blank"><img style="border-radius: 50%;" width="50px" height="50px" src="https://avatars.githubusercontent.com/u/71665600?v=4" alt="Logo"></a>
                    <p>Copyright  © <?php echo date("Y");?> (Angel Development Team). <strong>Powered by: <a style="text-decoration:none" href="mailto:jamesakweter@gmail.com">Akweter</a></strong></p>
                </div>
            </div>
        </footer>
        <script>
            function Dating() {
                var D = new Date();
                const Months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                var month = Months[D.getMonth()];
                var day = D.getDay();
                var hours = D.getHours();
                var minutes = D.getMinutes();
                var ampm = hours >= 12 ? 'pm' : 'am';
                hours = hours % 12;
                hours = hours ? hours : 12;
                minutes = minutes < 10 ? '0'+minutes : minutes;
                var striTime = day+' '+month+', '+hours+':'+minutes+' '+ampm;
                return striTime;
            }
        </script>
    </body>
</html>
