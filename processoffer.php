<?php
session_start();
require_once 'parts/_db.php';

if (isset($_GET["action"]) && ($_GET["action"]=="approved" || $_GET["action"]=="rejected") && isset($_GET["offer_id"]) && $_SESSION["user_type"]=="student") {
    echo "adding";
    $offer_id=$_GET["offer_id"];
    $student_id=$_SESSION["type_id"];
    $action=$_GET["action"];

    $sql="select * from students_applications where id=:offer_id and student_id=:student_id";
    
    $statement=$pdo->prepare($sql);
    $statement->bindParam(":offer_id",$offer_id);
    $statement->bindParam(":student_id",$student_id);
    $statement->execute();
    $check=$statement->fetch(PDO::FETCH_ASSOC);

    if ($check){    // offer for the logged in student found
        echo "checked";

        $sql="UPDATE students_applications set application_status=:status where id=:offer_id";
        $statement=$pdo->prepare($sql);
        $statement->bindParam(":status",$action);
        $statement->bindParam(":offer_id",$offer_id);
        $statement->execute();

    }
}

header("Location:student.php?id=".$student_id);