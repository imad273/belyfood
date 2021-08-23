<?php 
    session_start();
    // Title of this page
    $title = "Datails";
    // includes the required files
    require "config.php";
    require "func.php";
    include "template/header.php";
    include "template/navbar.php";

    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : 0;
    // check if account exist in database
    $stmt = $con->prepare("SELECT * FROM menu WHERE Dish_id = ?");
    $stmt->execute(array($id));
    $rows = $stmt->fetch();
?>

    <div class="container p-4 mt-2 all-detail">
        <div class="detail">
            <div class="img">
                <img src="admin/images/<?php echo $rows['Image'] ?>">
            </div>
            <div class="inf ms-5">
                <strong><?php echo $rows['Name'] ?></strong>
                <p><?php echo $rows['Description'] ?></p>
            </div>
        </div>
        <div class="prc">
            Price
            <strong class="float-end">$<?php echo $rows['Price'] ?></strong>
        </div>
        <div class="order">
            <a href="Confirm_Order.php?id=<?php echo $rows['Dish_id'] ?>" class="btn btn-primary float-end mt-4">Order Now</a>
        </div>
    </div>

<?php
    include "template/footer.php";
?>