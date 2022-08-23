<?php include "parts/_header.php" ?>
<?php
update_last_hit($pdo, $_SESSION["userid"]);
$edit=false;
$sql='SELECT * from city';
$statement=$pdo->prepare($sql);
$statement->execute();
$cities=$statement->fetchAll(PDO::FETCH_ASSOC);


if (isset($_SESSION["type_id"] )&& $_SESSION["type_id"]!=""){
    $edit=true;
    $id=$_SESSION["type_id"];
    $sql = 'SELECT company.*,city.name as city
		FROM company join city on company.city_id=city.id where company.id=:id';
    $statement=$pdo->prepare($sql);
    $statement->bindParam(":id",$id);
    $statement->execute();
    $company=$statement->fetch(PDO::FETCH_ASSOC);
}
?>
<main>
    <h2><?php echo  $edit?"Add Company":"Edit Company"?></h2>
    <?php
   
    ?>
    <form action="./addcompany.php" method="post" enctype="multipart/form-data">
        <table class="addtable">
            <tr class="addtable">
                <td class="addtable"> Logo </td>
                <td class="addtable">
                    <?php echo $edit?'<img class="photo" src="'.$company["logo_path"].'" alt="company photo">':'';?>
                    <input type="file" name="personal_photo" />
                    <input name="logo_path" hidden value="<?php echo $edit?$company["logo_path"]:'' ?>"/>
            </tr>

            <tr class="addtable">
                <td class="addtable">  Name  </td>
                <td class="addtable"><input type="text" name="name" value="<?php echo $edit?$company['name']:''?>"/> </td>
            </tr>

            <tr class="addtable">
                <td class="addtable"> City </td>

                <td class="addtable">
                    <select name="city">
                        <<?php
                        foreach ($cities as $city){
                            if (isset($company) && $company["city_id"]==$city["id"])
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
                <td class="addtable"> <input type="email" name="email" value="<?php echo $edit?$company['email']:''?>"> </td>
            </tr>
            <tr class="addtable">
                <td class="addtable">Tel </td>
                <td class="addtable"> <input type="tel" name="tel" pattern="[0-9]{10}" value="<?php echo $edit?$company['tel']:''?>"> </td>
                
            </tr>
            <tr class="addtable">
                <td class="addtable"> Positions Count </td>
                <td class="addtable"> <input type="number" id="quantity" name="positions_count" value="<?php echo $edit?$company['positions_count']:''?>" min="0" value="0"> </td>
            </tr>

            <tr class="addtable">
                <td class="addtable"> Positions Details</td >
                <td class="addtable"> <textarea name="positions_details" cols="30" rows="10"><?php echo $edit?$company['positions_details']:''?></textarea> </td>
            </tr>
        </table>        
        <br><br>

        <?php if ($edit) {?>
            <input type="submit" value="Update Company" name="update">
        <?php } else {?>
            <input type="submit" value="Add Company" name="add">
            <input type="reset" value="Clear">
        <?php }?>

    </form>
    <br> <br>
    <a href="./companies.php">Cancel and return to Companys List</a>
    <br> <br>
</main>

<aside>
    <h2>Help</h2>
    <p>
        Add company and positions details so that students can find you...
    </p>
</aside>
<?php include "parts/_footer.php" ?>

