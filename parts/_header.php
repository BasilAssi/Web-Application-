<?php
session_start();
require_once 'parts/_db.php';

if (!isset($_SESSION["userid"]) && basename($_SERVER['PHP_SELF'])!="index.php" && basename($_SERVER['PHP_SELF'])!="logout.php"){
    header("location:index.php");
}


function update_last_hit($pdo,$userid){
    $sql="UPDATE USER set last_hit=CURRENT_TIMESTAMP where id=:id";
    $statement=$pdo->prepare($sql);
    $statement->bindParam(":id",$userid);
    $statement->execute();
}
?>
<!DocType html>
<html lang="en">
    <head>
        
    <style>
        <?php include "css/layout.css"; ?>
        <?php include "css/website.css"; ?>
    </style>

        <title>Student Training</title>
        
    </head>
    <body>
        <header>
            <div>
                <img src="images/training.png" alt="logo" />
                <h1>Student Training</h1>
            </div>
            <?php if (isset($_SESSION["userid"])){
                echo "<div class='welcome'>Welcome ". $_SESSION["display_name"]. " <a href='logout.php'> Logout</a></div>";
            } else { ?>

                <div class='welcome'><a href="index.php">Login</a></div>
            <?php } ?>
            <br>
            <br>
            <br>
            <nav>
                <a href="index.php">Home</a>
                <a href="students.php">Students List</a>
                <a href="companies.php">Companies List</a>
            </nav>
            <br>
            <br>
        </header>
