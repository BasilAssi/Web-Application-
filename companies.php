<?php include "parts/_header.php" ?>
<main>
    
    <?php

    $sql = 'SELECT * from city';
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $cities = $statement->fetchAll(PDO::FETCH_ASSOC);

    $where[] = "1=1";
    $param = array();
    if (isset($_GET["submit"])) {
        if (isset($_GET['search'])) {
            $where[] = "company.name like :search";
            $param[":search"] = '%' . $_GET['search'] . '%';
        }
        if (isset($_GET['select_city']) && $_GET['select_city'] != '') {
            $where[] = "city_id=:city_id";
            $param[":city_id"] = intval($_GET['select_city']);
        }

    }
    $where_stmt = implode(" and ", $where);


    $sql = 'SELECT company.*,city.name as city
		FROM company join city on company.city_id=city.id where ' . $where_stmt;

    $statement = $pdo->prepare($sql);

    foreach ($param as $key => &$p) {
        $statement->bindParam($key, $p);
    }

    $statement->execute();
    $companies = $statement->fetchAll(PDO::FETCH_ASSOC);


    ?>
    <section>
            <br>
            <h2>Companies List</h2>
            <div>
                
                <form>
                  <label for="search">Company Name</label>
                  <input type="search" id="search" name="search">

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
                    <th>Logo</th>  <th>Name</th>   <th>City</th>    <th>Open Positions</th><th>Positions Details</th>
                  </tr>
              </thead>
              <tbody>
              <?php foreach ($companies as $company){ ?>
                  <tr>
                      <td>
                          <img src="<?php echo $company["logo_path"];?>" alt="company">
                      </td>
                      <td>
                          <a href="company.php?id=<?php echo $company['id'];?>"><?php echo $company["name"];?></a>
                      </td>
                      <td><?php echo $company["city"];?></td>
                      <td><?php echo $company["positions_count"];?></td>
                      <td><?php echo $company["positions_details"];?></td>
                  </tr>
              <?php } ?>
              </tbody>
                
            </table>
            <br>
        <?php if (!isset($_SESSION["type_id"])){
            echo '<a href="add-company.php">Add Company</a>';
        }?>
        </section>
</main>

<aside>
    <h2>Highlighted Company</h2>
    <p>
        This will contain a random special company details...
    </p>
</aside>
<?php include "parts/_footer.php" ?>

