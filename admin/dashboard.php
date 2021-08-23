<?php 
    session_start();
    // Title of this page
    $title = "Dashboard";
    // includes the required files
    require "../config.php";
    require "func.php";
    include "template/header.php";
    include "template/navbar.php";
    // check if the admin login or not
    if(isset($_SESSION['adminUsername'])){ ?>
        <div class="container dash-info">
            <h2 class="ms-4">Dashboard</h2>
            <div class="row text-center">
                <div class="col-lg-4 mt-3">
                    <div class="stat">
                        <div class="icn">
                            <i class='bx bx-bar-chart-alt-2'></i>
                        </div>
                        <div class="inf">
                            Food Delivred
                            <p><?php echo countItem("Order_id", "orders") ?><p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-3">
                    <div class="stat">
                        <div class="icn">   
                            <i class='bx bx-money'></i>
                        </div>
                        <div class="inf">
                            Balance
                            <p>$<?php echo sumItem("Price", "orders") ?></p>
                        </div>
                    </div>  
                </div>
                <div class="col-lg-4 mt-3">
                    <div class="stat">
                        <div class="icn">
                            <i class='bx bx-message-square-detail'></i>
                        </div>
                        <div class="inf">
                            Reviews
                            <p>255</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                $stmt = $con->prepare("SELECT * FROM orders ORDER BY Order_id DESC LIMIT 5");
                $stmt->execute();
            ?>
            <h2 class="mt-5 ms-4">Last Orders</h2>
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
            <div class="admins">
                <div class="card">
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Total Admins</strong> <p> <?php echo countItem("Admin_id", "admins") ?> </p></li>
                            <li class="list-group-item">
                                <a href="account.php?action=add-admin" class="btn btn-primary float-end">Add New Admin</a>
                                <a href="account.php?action=admins" class="btn btn-primary float-end me-2">Show Admin List</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
<?php  
    // if doesn't the session exist      
    } else {
        header('location: index.php');
        exit();
    }
     
    include "template/footer.php";
?>