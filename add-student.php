<?php include "parts/_header.php" ?>

<?php
update_last_hit($pdo, $_SESSION["userid"]);
$edit=false;  // set edit variable to display the form with student data or empty form 
$sql='SELECT * from city';
$statement=$pdo->prepare($sql);
$statement->execute();
$cities=$statement->fetchAll(PDO::FETCH_ASSOC);

if (isset($_SESSION["type_id"] )&& $_SESSION["type_id"]!=""){
    $edit=true;
    $id=$_SESSION["type_id"];
    $sql = 'SELECT student.*,city.name as city
		FROM student join city on student.city_id=city.id where student.id=:id';
        
    $statement=$pdo->prepare($sql);
    $statement->bindParam(":id",$id);
    $statement->execute();
    $student=$statement->fetch(PDO::FETCH_ASSOC);
}
?>
<main>
    <br><br>
    <h2><?php echo  $edit?"Add Student":"Edit Student"?></h2>

    <form action="./addstudent.php" method="post" enctype="multipart/form-data">
        <table class="addtable">
            <tr class="addtable">
                <td class="addtable">
                    Personal Photo
                </td>

                <td class="addtable">
                    <?php echo $edit?'<img class="photo" src="'.$student["photo_path"].'" alt="my photo">':'';?>
                    <input type="file" name="personal_photo" />
                    <input name="photo_path" hidden value="<?php echo $edit?$student["photo_path"]:'' ?>"/>
                </td>
            </tr>
            <tr class="addtable">
                <td class="addtable"> Name </td>
                <td class="addtable"><input type="text" name="name" value="<?php echo $edit?$student['name']:''?>"/>  </td>
            </tr>

            <tr class="addtable">
                <td class="addtable"> City </td>
                <td class="addtable">

                    <select name="city">
                        <option value="">Select City</option>
                        <<?php
                        foreach ($cities as $city){
                            if ($student["city_id"]==$city["id"])
                                $selected="selected";
                            else
                                $selected="";
                            echo '<option value="' .$city["id"].'" '.$selected.'>'. $city["name"].'</option>';
                        } ?>
                    </select>
                </td>

            </tr>
            <tr class="addtable">
                <td class="addtable"> Email</td>
                <td class="addtable"> <input type="email" name="email" value="<?php echo $edit?$student['email']:''?>"> </td>
            </tr>

            <tr class="addtable">
                <td class="addtable"> Tel </td>
                <td class="addtable"> <input type="tel" name="tel" pattern="[0-9]{10}" value="<?php echo $edit?$student['tel']:''?>"> </td>
                
            </tr>
            <tr class="addtable">
                <td class="addtable"> University </td>
                <td class="addtable"> <input type="text" name="university" value="<?php echo $edit?$student['university']:''?>"/> </td>
            </tr>
            <tr class="addtable">
                <td class="addtable"> Major </td>
                <td class="addtable"> <input type="text" name="major" value="<?php echo $edit?$student['major']:''?>"/></td>
            </tr>
            <tr class="addtable">
                <td class="addtable"> Projects </td >
                <td class="addtable"> <textarea name="projects" cols="30" rows="10"><?php echo $edit?$student['projects']:''?></textarea> </td>
            </tr>

            <tr class="addtable">
                <td class="addtable">  Interests</td>
                <td class="addtable"> <textarea name="interests" cols="30" rows="10"><?php echo $edit?$student['interests']:''?></textarea> </td>
            </tr >

        </table>        
        <br>
        <?php if ($edit) {?>
            <input type="submit" value="Update Student" name="update">
        <?php } else {?>
            <input type="submit" value="Add Student" name="add">
            <input type="reset" value="Clear">
        <?php }?>
    </form>
    <br><br>

    <a href="./students.php">Cancel and return to Students List</a>
    <br><br>
    
</main>
<aside>
    <h2>Help</h2>
    <p>
        Add your student details including projects and interests so that companies can select you...
    </p>
</aside>
<?php include "parts/_footer.php" ?>