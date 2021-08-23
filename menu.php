<?php
    session_start();
    // Title of this page
    $title = "Menu";
    // includes the required files
    require "config.php";
    require "func.php";
    include "template/header.php";
    include "template/navbar.php";

    // Fetching data 
    $stmt = $con->prepare("SELECT * FROM menu");
    $stmt->execute();
    $rows = $stmt->fetchAll();
?>
    <div class="container">
        <div class="dishes mt-5">
            <div class="row"> <?php
                foreach($rows as $row){ ?>
                    <div class="col-lg-4 mt-3">
                        <div class="stat">
                            <div class="img">
                                <img src="admin/images/<?php echo $row['Image'] ?>" alt="">
                            </div>
                            <div class="inf">
                                <strong><?php echo $row['Name'] ?></strong>
                                <p><?php echo $row['Description'] ?></p>
                            </div>
                        </div>
                        <div class="prc">
                            Price
                            <strong class="float-end">$<?php echo $row['Price'] ?></strong>
                        </div>
                        <div class="edit">
                            <a href="view_dish.php?id=<?php echo $row['Dish_id'] ?>" class="btn btn-primary w-100">Details</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

<?php
    include "template/footer.php";
?>