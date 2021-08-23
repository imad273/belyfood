<?php 
    session_start();
    // Title of this page
    $title = "Orders";
    // includes the required files
    require "../config.php";
    require "func.php";
    include "template/header.php";
    include "template/navbar.php";
    if(isset($_SESSION['adminUsername'])){ 
        $stmt = $con->prepare("SELECT * FROM orders ORDER BY Order_id DESC");
        $stmt->execute();
        ?>
        <div class="container dash-info orders">
            <h2 class="ms-4">Orders List</h2>
            <div class="table-responsive">
                <table class="table mt-2 mb-5">
                    <thead>
                        <tr>
                            <th scope="col">Dish Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Client</th>
                            <th scope="col">Address</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody> <?php 
                    while($row = $stmt->fetch()){ ?>
                        <tr>
                            <th scope="row"><?php echo $row['Dish_name'] ?></th>
                            <td>$<?php echo $row['Price'] ?></td>
                            <td><?php echo $row['Client_name'] ?></td>
                            <td><?php echo $row['Client_address'] ?></td>
                            <td><?php echo $row['Client_phone'] ?></td>
                            <td><?php if($row['Quantity'] > 1){ echo "x" . $row['Quantity']; } else { echo $row['Quantity'];}?></td>
                            <td><?php echo $row['Order_date'] ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
<?php
    }
    include "template/footer.php";
?>