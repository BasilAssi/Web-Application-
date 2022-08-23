<?php include "parts/_header.php" ?>
<?php
update_last_hit($pdo, $_SESSION["userid"]);
if (!isset($_GET["id"])) {
    echo "<p>No company found</p>";
} else {
$id = $_GET["id"];
$sql = 'SELECT company.*,city.name as city
		FROM company join city on company.city_id=city.id where company.id=:id';
$statement = $pdo->prepare($sql);
$statement->bindParam(":id", $id);
$statement->execute();
$company = $statement->fetch(PDO::FETCH_ASSOC);

if (!$company) {
    echo "<p>No company found</p>";
} else {

?>
<main>
    <h2><?php echo $company["name"]; ?></h2>

    <?php 

         ?>
    <img class="photo" src="<?php echo $company["logo_path"]; ?>" alt="company logo">
    <dl>
        <dt> City:</dt>
        <dd><?php echo $company["city"]; ?></dd>

        <dt>Email:</dt>
        <dd><?php echo $company["email"]; ?></dd>

        <dt> Tel:</dt>
        <dd><?php echo $company["tel"]; ?> </dd>

        <dt>Open Positions:</dt>
        <dd> <?php echo $company["positions_count"]; ?> </dd>

        <dt> Positions Details:</dt>
        <dd><?php echo $company["positions_details"]; ?></dd>
         </dl>

        <br><br>
        <br><br>
        <br><br>

    <a href="./companies.php"> Back to Companies List</a>  |
    <?php if ($company["user_id"] == $_SESSION["userid"]) echo '| <a href="add-company.php">Edit</a>'; ?>
        <br><br>
  </main>
<aside>
    <h2>Similar Companies</h2>
    <p>
        Another companies in same location looking for students...
    </p>
</aside>
<?php
    }
}
?>
<?php include "parts/_footer.php" ?>
