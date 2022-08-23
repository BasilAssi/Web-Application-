<?php include "parts/_header.php" ?>

<main>
    
    <?php
    update_last_hit($pdo,$_SESSION["userid"]);
    // get cities to populate city dropdown
    $sql='SELECT * from city';
    $statement=$pdo->prepare($sql);
    $statement->execute();
    $cities=$statement->fetchAll(PDO::FETCH_ASSOC);

    $where[]="1=1";
    $param=array();
    // if search button is clicked set the where clause to search for student
    if (isset($_GET["submit"] )){
        if (isset($_GET['search'])) {
            $where[] = "major like :search";
            $param[":search"]='%'.$_GET['search'].'%';
        }
        if (isset($_GET['select_city']) && $_GET['select_city']!='') {
            $where[]="city_id=:city_id";
            $param[":city_id"]=intval($_GET['select_city']);
        }

    }
    $where_stmt=implode(" and ",$where);

    
    $sql = 'SELECT student.*,city.name as city
		FROM student join city on student.city_id=city.id where '.$where_stmt;

    $statement=$pdo->prepare($sql);

    foreach ($param as $key=>&$p){
       $statement->bindParam($key,$p);
    }

    $statement->execute();
    $students=$statement->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <section>
            
    <h2>Students List</h2>
            <div>
                <form method="get" action="students.php">
                  <label for="search">Student Study Major</label>
                  <input type="text" id="search" name="search">

                  <label for="Citys">City</label>
                  <select name="select_city" id="Citys">
                      <option value="">Select City</option>
                      <?php
                      foreach ($cities as $city){
                        echo '<option value="' .$city["id"].'">'. $city["name"].'</option>';
                     } ?>
                  </select>

                  <button type="submit" name="submit" value="search">Search</button>
                  
                </form>
            </div>
            <table >
              <thead>
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>City</th>
                    <th>University</th>
                    <th>Major</th>
                  </tr>
              </thead>
              <tbody>
              <?php foreach ($students as $student){ ?>
                  <tr>
                      <td>
                        <img src="<?php echo $student["photo_path"];?>" alt="student">
                      </td>
                      <td>
                        <a href="student.php?id=<?php echo $student['id'];?>"><?php echo $student["name"];?></a>
                      </td>
                      <td><?php echo $student["city"];?></td>
                      <td><?php echo $student["university"];?></td>
                      <td><?php echo $student["major"];?></td>
                  </tr>
              <?php } ?>
              </tbody>
                
            </table>
            <br>
              
            <?php if ($_SESSION["user_type"]=="student" && !isset($_SESSION["type_id"])){
                echo '<a href="add-student.php">Add Student</a>';
            }?>
            
            <br>
        </section>
</main>
<aside>
    <h2>Distinguished Students</h2>
    <p>
        Student Ali Ahmad from Birzeit is very special and he is looking for training in Computer Science...
    </p>
</aside>
<?php include "parts/_footer.php" ?>

