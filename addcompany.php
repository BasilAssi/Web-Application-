<?php
session_start();
require_once 'parts/_db.php';

$name=$_POST["name"];
$city=$_POST["city"];
$email=$_POST["email"];
$tel=$_POST["tel"];
$positions_count=$_POST["positions_count"];
$positions_details=$_POST["positions_details"];
$user_id=$_SESSION["userid"];
$personal_photo=$_POST["logo_path"];
                            
if (isset($_FILES['personal_photo']) and $_FILES['personal_photo']['name']!="") {
    if (move_uploaded_file($_FILES['personal_photo']['tmp_name'],"logos/".$_FILES['personal_photo']['name'])){
        $personal_photo="logos/".$_FILES['personal_photo']['name'];

    }
}


if (isset($_POST["add"])){
    $sql="insert into company (name,city_id,email,tel,positions_count,positions_details,logo_path,user_id) values 
        (:name,:city_id,:email,:tel,:positions_count,:positions_details,:logo_path,:user_id)";
}
else{
    $sql="update company set name=:name, city_id=:city_id,email=:email,tel=:tel,positions_count=:positions_count,positions_details=:positions_details,
            logo_path=:logo_path where user_id=:user_id";
}


$statement=$pdo->prepare($sql);
$statement->bindParam(":name",$name);
$statement->bindParam(":city_id",$city);
$statement->bindParam(":email",$email);
$statement->bindParam(":tel",$tel);
$statement->bindParam(":positions_count",$positions_count);
$statement->bindParam(":positions_details",$positions_details);
$statement->bindParam(":logo_path",$personal_photo);
$statement->bindParam(":user_id",$user_id);
$statement->execute();

$id = $pdo->lastInsertId();
$_SESSION["type_id"]=$id;

header("Location:companies.php");