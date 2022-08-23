<?php
session_start();
require_once 'parts/_db.php';

if (isset($_GET["student_id"]) && $_GET["student_id"]!="" && $_SESSION["user_type"]=="company") {
    echo "adding";
    $student_id=$_GET["student_id"];
    $company_id=$_SESSION["type_id"];
    $sql="select * from student where id=:student_id";
    $statement=$pdo->prepare($sql);
    $statement->bindParam(":student_id",$student_id);
    $statement->execute();
    $check=$statement->fetch(PDO::FETCH_ASSOC);

    if ($check){    // student found in student table
        echo "checked";
        $apply_date=date('Y-m-d');
        $company_id=$_SESSION["type_id"];
        $requested_by_user_id=$_SESSION["userid"];
        $sql="INSERT into students_applications (student_id,company_id,requested_by_user_id,apply_date) values (:student_id,:company_id,:user_id,:apply_date)";
        $statement=$pdo->prepare($sql);
        $statement->bindParam(":student_id",$student_id);
        $statement->bindParam(":company_id",$company_id);
        $statement->bindParam(":user_id",$requested_by_user_id);
        $statement->bindParam(":apply_date",$apply_date);
        $statement->execute();

    }
}

header("Location:student.php?id=".$_GET["student_id"]);