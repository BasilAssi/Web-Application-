<?php include "parts/_header.php" ?>
    <main>    <h2>Form input from page <?php echo basename($_SERVER["HTTP_REFERER"]); ?></h2>        <h3>GET
    Data</h3>    <?php if (count($_GET) == 0) {
    echo "<p><em>There are no GET variables</em></p>";
} else {
    foreach ($_GET as $key => $value) {
        echo "<strong>" . $key . " = </strong>" . $value . "<br/>\n";
        if (is_array($value)) {
            for ($i = 0; $i < count($value); $i++) {
                echo "--Index " . $i . " Selected value=" . $value[$i] . "<br/>";
            }
        }
    }
} ?>        <h3>POST Data</h3>    <?php if (count($_POST) == 0) {
    echo "<p><em>There are no POST variables</em></p>";
} else {
    foreach ($_POST as $key => $value) {
        echo "<strong>" . $key . " = </strong>" . $value . "<br/>\n";
        if (is_array($value)) {
            for ($i = 0; $i < count($value); $i++) {
                echo "--Index " . $i . " Selected value=" . $value[$i] . "<br/>";
            }
        }
    }
} ?></main>
    <aside><h2>Paga Parameters Testing</h2>
        <p> This page will get the parameters from GET or POST and display them... </p>
    </aside><?php include "parts/_footer.php" ?>