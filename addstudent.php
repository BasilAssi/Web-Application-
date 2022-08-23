<?php
session_start();
require_once 'parts/_db.php';

$name=$_POST["name"];
$city=$_POST["city"];
$email=$_POST["email"];
$tel=$_POST["tel"];
$university=$_POST["university"];
$major=$_POST["major"];
$projects=$_POST["projects"];
$interests=$_POST["interests"];
$user_id=$_SESSION["userid"];
$personal_photo=$_POST["photo_path"];
if (isset($_FILES['personal_photo']) and $_FILES['personal_photo']['name']!="") {
    if (move_uploaded_file($_FILES['personal_photo']['tmp_name'],"images/".$_FILES['personal_photo']['name'])){
        $personal_photo="images/".$_FILES['personal_photo']['name'];
    }
}
$add=false;
if (isset($_POST["add"])){
    $add=true;//adding student record
    $sql="insert into student (name,city_id,email,tel,university,major,projects,interests,photo_path,user_id) values 
        (:name,:city_id,:email,:tel,:university,:major,:projects,:interests,:photo_path,:user_id)";
}
else{ // updating student record
    $sql="update student set name=:name, city_id=:city_id,email=:email,tel=:tel,university=:university,major=:major,
            projects=:projects,interests=:interests,photo_path=:photo_path where user_id=:user_id";
}

$statement=$pdo->prepare($sql);
$statement->bindParam(":name",$name);
$statement->bindParam(":city_id",$city);
$statement->bindParam(":email",$email);
$statement->bindParam(":tel",$tel);
$statement->bindParam(":university",$university);
$statement->bindParam(":major",$major);
$statement->bindParam(":projects",$projects);
$statement->bindParam(":interests",$interests);
$statement->bindParam(":photo_path",$personal_photo);
$statement->bindParam(":user_id",$user_id);
$statement->execute();
if ($add){ // if student record added set the session variable
    $id = $pdo->lastInsertId(); // get last inserted id
    $_SESSION["type_id"]=$id;
}

header("Location:students.php");