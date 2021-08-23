<?php 
    session_start();
    // Title of this page
    $title = "Confirm order";
    // includes the required files
    require "config.php";
    require "func.php";
    include "template/header.php";
    include "template/navbar.php";

    $link = isset($_GET["action"]) ? $_GET["action"] : "confirm";

    if($link == "confirm"){ 
        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : 0;
        $stmt = $con->prepare("SELECT * FROM menu WHERE Dish_id = ?");
        $stmt->execute(array($id));
        $rows = $stmt->fetch();  ?>
        <div class="container mt-3">
            <div class="confirm">
                <h2 class="m-2">Confirm Order</h2>
                <form action="?action=bill" method="POST">
                    <div class="mb-3">
                        <input type="text" name="name" placeholder="Name" class="form-control" aria-describedby="emailHelp" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="address" placeholder="address" class="form-control" aria-describedby="emailHelp" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="phone" placeholder="Phone" class="form-control" aria-describedby="emailHelp" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <input type="number" name="qnt" placeholder="Quantity" class="form-control" aria-describedby="emailHelp" required autocomplete="off">
                    </div>
                    <button type="submit" name="btn" class="btn btn-primary">Buy</button>
                    <input type="hidden" value="<?php echo $rows['Price'] ?>" name="price" required>
                    <input type="hidden" value="<?php echo $rows['Name'] ?>" name="dish" required>
                </form>
            </div>
        </div>


<?php
    } elseif($link == "bill"){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $name    = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
            $phone   = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
            $price   = filter_var($_POST['price'], FILTER_SANITIZE_STRING);
            $qnt     = filter_var($_POST['qnt'], FILTER_SANITIZE_STRING);
            $dish    = filter_var($_POST['dish'], FILTER_SANITIZE_STRING);
        }
        // Total Price 
        $total = $price * $qnt;

        $stmt = $con->prepare("INSERT INTO orders (Dish_name, Price, client_name, Client_address, Client_phone, Quantity, Order_date) VALUE (?, ?, ?, ?, ?, ?, now())");
        $stmt->execute(array($dish, $total, $name, $address, $phone, $qnt));

        echo "<div class='container'>";
            echo "<div class='alert alert-success m-1'>The request was successfully completed</div>";
            echo "<div class='alert alert-info m-1'>We will contact you to confirm your order</div>";
            echo "<a href='menu.php' class='btn btn-primary float-end'>Back to menu</a>";
        echo "</div>";
    } else{
        header("location: menu.php");
    }
    include "template/footer.php";
?>