<?php include "parts/_header.php" ?>
<?php
update_last_hit($pdo, $_SESSION["userid"]);
if (!isset($_GET["id"])) {
    echo "<p>No student found</p>";
} else {
    $id = $_GET["id"];
    $sql = 'SELECT student.*,city.name as city
		FROM student join city on student.city_id=city.id where student.id=:id';
    $statement = $pdo->prepare($sql);
    $statement->bindParam(":id", $id);
    $statement->execute();
    $student = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        echo "<p>No student found</p>";
    } else {
        $offers = array();
        $student_offers = array();
        if ($_SESSION["user_type"] == "company") {
            $sql = "select * from students_applications where student_id=:student_id and company_id=:company_id";
            $statement = $pdo->prepare($sql);
            $statement->bindParam(":student_id", $student["id"]);
            $statement->bindParam(":company_id", $_SESSION["type_id"]);
            $statement->execute();
            $offers = $statement->fetch(PDO::FETCH_ASSOC);
        } else {
            if ($student["user_id"] == $_SESSION["userid"]) {
                $offer_sql = "select students_applications.*,c.name from students_applications join company c 
                        on students_applications.company_id = c.id where student_id=:user_id order by apply_date";
                $statement = $pdo->prepare($offer_sql);
                $statement->bindParam(':user_id', $_SESSION["type_id"]);
                $statement->execute();
                $student_offers = $statement->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        ?>
        <main>
            <h2><?php echo $student["name"]; ?></h2>

            <img class="photo" src="<?php echo $student["photo_path"]; ?>" alt="my photo">
            <dl>
                <dt>City:</dt>
                <dd> <?php echo $student["city"]; ?> </dd>

                <dt> Email:</dt>
                <dd> <?php echo $student["email"]; ?> </dd>

                <dt> Tel:</dt>
                <dd><?php echo $student["tel"]; ?></dd>

                <dt> University:</dt>
                <dd><?php echo $student["university"]; ?></dd>

                <dt> Major:</dt>
                <dd><?php echo $student["major"]; ?></dd>

                <dt> Projects:</dt>
                <dd> <?php echo $student["projects"]; ?></dd>
                <dt> Interests:</dt>
                <dd> <?php echo $student["interests"]; ?></dd>

            </dl>
            <a href="students.php">Back to Students List</a>
            <?php if ($student["user_id"] == $_SESSION["userid"]) echo '| <a href="add-student.php">Edit</a>'; ?>
            <?php if ($_SESSION["user_type"] == "company" && !$offers) echo '| <a href="addoffer.php?student_id=' . $student["id"] . '">Offer a Training</a>'; ?>
            <?php if ($_SESSION["user_type"] == "company" && $offers) echo '|' . $offers["application_status"]; ?>
            <br>
            <br>
        </main>
        <aside>
            <?php if ($student_offers) {
                echo "<h3>COMPANY OFFERS</h3>
                <table>
                    <thead>
                        <tr><th>Company</th><th>Offer Date</th><th>Application Status</th><th>Action</th></tr>
                    </thead>";
                foreach ($student_offers as $offer) { ?>
                    <tr>
                        <td><?php echo $offer["name"] ?></td>
                        <td><?php echo $offer["apply_date"] ?></td>
                        <td><?php echo $offer["application_status"] ?></td>
                        <td><?php if ($offer["application_status"]=="sent"){ ?>
                            <a href="processoffer.php?action=approved&offer_id=<?php echo $offer["id"];?>">Approve</a> |
                                <a href="processoffer.php?action=rejected&offer_id=<?php echo $offer["id"];?>">Reject</a>
                        <?php
                            }
                        ?>
                        </td>
                    </tr>
                    <?php
                } ?>
                </table>
            <?php } else { ?>
                <h2>Similar Students</h2>
                <p>
                    A student or 2 students with same major
                </p>
            <?php } ?>
        </aside>
        <?php
    }
} ?>
<?php include "parts/_footer.php" ?>

