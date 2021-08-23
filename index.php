<?php 
    session_start();
    // Title of this page
    $title = "Belyfood";
    // includes the required files
    require "config.php";
    require "func.php";
    include "template/header.php";
    include "template/navbar.php";
?>

    <div class="container-fluid">
        <div class="home">
            <h1>We will deliver what <br> the chef has planned</h1>
            <a href="menu.php" class="btn btn-primary mt-3">Look At Menu</a>
        </div>
        <?php 
            // Fetching data 
            $stmt = $con->prepare("SELECT * FROM menu LIMIT 3");
            $stmt->execute();
            $rows = $stmt->fetchAll();
        ?>
        <div class="all-dishes">
            <h2 class="mt-5 text-center">dishes you might like</h2>
            <div class="dishes"> 
                <div class="container">
                    <div class="row"> <?php
                        foreach($rows as $row){ ?>
                            <div class="col-lg-4">
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
                                    <a href="view_dish?id=<?php echo $row['Dish_id'] ?>" class="btn btn-primary w-100">Details</a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
            $stmt = $con->prepare("SELECT * FROM reviews ORDER BY Review_id DESC LIMIT 1");
            $stmt->execute();
            $rows = $stmt->fetch();
        ?>
        <div class="reviews">
            <div class="container">
                <h1 class="title">Last Review</h1>
                <h2><?php echo $rows['Reviewer_name'] ?></h2>
                <i class='bx bx-star'></i><span><?php echo $rows['Rate'] ?>/10</span>
                <p><?php echo $rows['Description'] ?></p>
            </div>
        </div>
    </div>


<?php
    include "template/footer.php";
?>