<?php include "parts/_header.php" ?>
<?php
$username="";
$password="";
if (isset($_POST['username']) && $_POST['username']!=""){

    $username=$_POST['username'];
    $password=$_POST['password'];
    $sql = 'SELECT id,username,display_name,user_type
		FROM user
        WHERE username = :username and password=SHA1(:password)';
    $statement=$pdo->prepare($sql);
    $statement->bindParam(':username', $username);
    $statement->bindParam(':password', $password);
    $statement->execute();
    $result=$statement->fetch(PDO::FETCH_ASSOC);
    if ($result){
        // Set Session variables
        $_SESSION["userid"]=$result["id"];
        $_SESSION["display_name"]=$result["display_name"];
        $_SESSION["user_type"]=$result["user_type"];

        if ($result["user_type"]=="student")
            $sql = "select id from student where user_id=:user_id";

        else
            $sql="select id from company where user_id=:user_id";

        $statement=$pdo->prepare($sql);
        $statement->bindParam(':user_id', $result["id"]);
        $statement->execute();
        $result_type=$statement->fetch(PDO::FETCH_ASSOC);
        if ($result_type){
            $_SESSION["type_id"]=$result_type["id"];
        }
        // reload page inorder to display logout and welcome message
        header("Location:index.php");
    }
    else{
        $_SESSION["msg"]="Incorrect username/password";
    }

}
if (!isset($_SESSION["userid"])){
?>
<main>
    <h2>Login</h2>
    <p>
    <?php 
       if (isset($_SESSION["msg"])) {
           echo $_SESSION["msg"];
           unset($_SESSION["msg"]);
       }
    ?>
    </p>
    <form action="index.php" method="post">
        Username <input type="text" name="username" value="<?php echo $username;?>"/>
        <br><br>
        Password <input type="password" name="password" value="<?php echo $password;?>"/>
        <br><br>
        <input type="submit" value="Login"/>
        <br><br>
    </form>
</main>
<?php }
else {
    update_last_hit($pdo,$_SESSION["userid"]);
    if ($_SESSION["user_type"]=="student"){
        $offer_sql="select students_applications.*,c.* from students_applications join company c 
                        on students_applications.company_id = c.id where student_id=:user_id";
                        
        $statement=$pdo->prepare($offer_sql);
        $statement->bindParam(':user_id', $_SESSION["type_id"]);
        $statement->execute();
        $offers=$statement->fetchAll(PDO::FETCH_ASSOC);
    }
    ?>
        <?php if ($_SESSION["user_type"]=="student"){

            if (!$offers){?>
        <h1>You have no student details</h1>
        <?php }
            else {
                echo "<h3>OFFERS</h3>
                <table>
                    <thead>
                        <tr><th>Company</th><th>Position Details</th><th>Application Status</th></tr>
                    </thead>";
                    // display offers for student
                    foreach ($offers as $offer){ ?>
                    <tr><td><?php echo $offer["name"] ?></td>
                        <td><?php echo $offer["positions_details"]?></td>
                        <td><?php echo $offer["application_status"] ?></td>
                    </tr>
                <?php
                } ?>
              </table>
            <?php }
        }?>
    </main>
<?php } ?>

<aside>
    <h2>Aside</h2>
    <p>
        The aside will have information related to the current page or ads.
    </p>
</aside>
<?php include "parts/_footer.php" ?>

