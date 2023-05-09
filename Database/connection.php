<?php
    $conn = new mysqli('127.0.0.1', 'root', '', 'todo_management_system');

    if(! $conn ){
        die("Connection to the database failed");
    }
?>
