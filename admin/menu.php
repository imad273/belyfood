<?php
    session_start();
    // Title of this page
    $title = "Menu";
    // includes the required files
    require "../config.php";
    require "func.php";
    include "template/header.php";
    include "template/navbar.php";

    // check if the admin login or not
    if(isset($_SESSION['adminUsername'])){
        // split page condition 
        $link = isset($_GET['action']) ? $_GET['action'] : "menu";

        if($link == "menu"){ // Menu list # default page
            // Fetching data 
            $stmt = $con->prepare("SELECT * FROM menu");
            $stmt->execute();
            $rows = $stmt->fetchAll(); ?>
            <div class="container menu mb-4">
                <div class="mt-3">
                    <div class="card">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>All Dishes</strong> <p><?php echo countItem("Dish_id", "menu") ?></p></li>
                                <li class="list-group-item">
                                    <a href="menu.php?action=add" class="btn btn-primary float-end">Add New Dish</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <h2 class="ms-4 mt-4 mb-3">Food Menu</h2>
                <div class="dishes">
                    <div class="row"> <?php
                        foreach($rows as $row){ ?>
                            <div class="col-lg-4 mt-3">
                                <div class="stat">
                                    <div class="img">
                                        <img src="images/<?php echo $row['Image'] ?>" alt="">
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
                                    <a href="?action=delete&id=<?php echo $row['Dish_id'] ?>" class="btn btn-danger w-100 confirm">Delete</a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
<?php
        } elseif ($link == "add"){ ?>
            <div class="container profile">
                <form action="?action=insert" method="POST" enctype="multipart/form-data">
                    <div class="info">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="ms-4 mb-3">Add New Dish</h2>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"> 
                                        <input name="name" type="text" required class="form-control" placeholder="Name" autocomplete="OFF">
                                    </li>
                                    <li class="list-group-item"> 
                                        Choose an image<span style="color: var(--main);">*</span>
                                        <input name="img" type="file" required class="form-control">
                                    </li>
                                    <li class="list-group-item"> 
                                        <textarea name="desc" required rows="3" class="form-control" placeholder="Description" autocomplete="OFF" style="resize: none;"></textarea>
                                    </li>
                                    <li class="list-group-item"> 
                                        <input name="price" type="text" required class="form-control" placeholder="Price $" autocomplete="OFF">
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <button type="submit" name="submit" class="btn btn-success float-end mt-3">Add</button>
                    </div>
                </form>
            </div>
<?php
        } elseif($link == "insert") {
            // check if comming from Post Request
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $name       = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
                $desc       = filter_var($_POST['desc'], FILTER_SANITIZE_STRING);
                $price      = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
                // image
                $imageinfo = $_FILES['img'];
                $imageName = $_FILES['img']['name'];
                $imageTmp = $_FILES['img']['tmp_name'];
                // Form validate
                $formError = array();
                if(empty($name)){
                    $formError[] = "You should be set a Name";
                }
                if(empty($desc)){
                    $formError[] = "You should be set a Description";
                }
                if(empty($price)){
                    $formError[] = "You should be set a Price";
                }
                if(empty($imageinfo)){
                    $formError[] = "You should be Upload image";
                }
                // print the error
                foreach($formError as $error){
                    echo "<div class='container'>";
                        echo "<div class='alert alert-danger m-1'>". $error ."</div>";
                        header("refresh: 4; account.php?action=profile&id=". $_SESSION["adminId"] ."");
                    echo "</div>"; 
                }
                if(empty($formError)){
                    // image 
                    $image = rand(0, 100000000) . "_" . $imageName;
                    move_uploaded_file($imageTmp, "images\\" . $image);

                    $stmt = $con->prepare("INSERT INTO menu (Name, Description, Image, Price) VALUE (?, ?, ?, ?)");
                    $stmt->execute(array($name, $desc, $image, $price));

                    echo "<div class='container'>";
                        echo "<div class='alert alert-success m-1'>Dish added Successefully</div>";
                        header("refresh: 3; menu.php");
                    echo "</div>"; 
                }
            }
        } elseif ($link == "delete"){
            $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : 0;
            // check if admin account exist in database
            $stmt = $con->prepare("SELECT * FROM menu WHERE Dish_id = ?");
            $stmt->execute(array($id));
            // Look if exist
            if($stmt->rowCount() > 0){
                $stmt = $con->prepare("DELETE FROM menu WHERE Dish_id = ?");
                $stmt->execute(array($id));
                echo "<div class='container'>";
                    echo "<div class='alert alert-success m-1'>Delete Successefully</div>";
                    header("refresh: 3; menu.php");
                echo "</div>";
            // if not exist 
            } else {
                echo "<div class='container'>";
                    echo "<div class='alert alert-danger'>Error: id not exist</div>";
                    echo "<div class='alert alert-info m-1'>You will be redirected to dashboard in 4 second</div>";
                    header("refresh: 4; dashboard.php");    
                echo "</div>";
            }
        } else {
            header("location: dashboard.php");
        }
    // if doesn't the session exist      
    } else {
        header('location: index.php');
        exit();
    }
    include "template/footer.php";
?>