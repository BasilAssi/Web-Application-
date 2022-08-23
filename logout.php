<?php
include "parts/_header.php";
if (isset($_SESSION["userid"])) {
    unset($_SESSION["userid"]);
    unset($_SESSION["display_name"]);
    unset($_SESSION["user_type"]);
    unset($_SESSION["type_id"]);
    header("Location:logout.php");
}
?>
<main>
    <h2>Logout</h2>
    <p>
    Logout completed!!
    </p>

</main>
<?php include "parts/_footer.php" ?>

