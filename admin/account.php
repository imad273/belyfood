<?php 
    session_start();
    // Title of this page
    $title = "Account";
    // includes the required files
    require "../config.php";
    require "func.php";
    include "template/header.php";
    include "template/navbar.php";

    // check if the admin login or not
    if(isset($_SESSION['adminUsername'])){
        // split page condition 
        $link = isset($_GET['action']) ? $_GET['action'] : "profile";

        if($link == "profile"){ // Profile and default page
            $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : 0;
            // check if account exist in database
            $stmt = $con->prepare("SELECT * FROM admins WHERE Admin_id = ?");
            $stmt->execute(array($id));
            $rows = $stmt->fetch();
            // Look if exist
            if($stmt->rowCount() > 0){ ?>
                <div class="container profile">
                    <div class="icn text-center">
                        <i class='bx bx-user'></i>
                    </div>
                    <div class="info">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="ms-4 mb-3">My Profile</h2>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <strong>Username </strong> 
                                        <p><?php echo $rows['UserName'] ?></p>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Full name</strong> 
                                        <p><?php echo $rows['FullName'] ?></p>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>registered date</strong> 
                                        <p><?php echo $rows['Date'] ?></p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <a href="logout.php" class="btn btn-danger float-end mt-3 mb-5">Logout</a>
                    <a href="account.php?action=edit&id=<?php echo $rows['Admin_id'] ?>" class="btn btn-success float-end edit-2">Edit Profile</a>
                </div>
<?php
            // if not exist
            } else {
                echo "<div class='container'>";
                    echo "<div class='alert alert-danger'>Error: id not exist</div>";
                    echo "<div class='alert alert-info m-1'>You will be redirected to dashboard in 4 second</div>";
                    header("refresh: 4; dashboard.php");
                echo "</div>";
            }
        } elseif($link == "admins") { // admin list page
            $stmt = $con->prepare("SELECT * FROM admins");
            $stmt->execute(); ?>
            <div class="container mt-3 admins">
                <h2 class="pt-3 ps-4">Admins List</h2>
                <div class="table-responsive">
                    <table class="table mt-2 mb-5">
                        <thead>
                            <tr>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">Full Name</th>
                                <th scope="col">Registered Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                while($rows = $stmt->fetch()){ 
                                    echo "<tr>";
                                        echo "<th scope='col'>" . $rows['UserName'] . "</th>";
                                        echo "<th scope='col'>" . $rows['Email'] . "</th>";
                                        echo "<th scope='col'>" . $rows['FullName'] . "</th>";
                                        echo "<th scope='col'>" . $rows['Date'] . "</th>";
                                    echo "<tr>";
                                } ?>
                        </tbody>
                    </table>
                </div>
                <a href="account.php?action=add-admin" class="btn btn-primary mt-3 float-end">Add New Admin</a>
            </div>
<?php        
        } elseif($link == "add-admin") { // add new admin page
            if(isset($_POST['submit'])){
                // check if comming from Post Request
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
                    $fullname = filter_var($_POST['fullname'], FILTER_SANITIZE_STRING);
                    $email    = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
                    $password = password_hash(filter_var($_POST['password'], FILTER_SANITIZE_STRING), PASSWORD_DEFAULT);
                    // Form validate
                    $formError = array();
                    if(empty($username)){
                        $formError[] = "You should be set a Username";
                    }
                    if(empty($fullname)){
                        $formError[] = "You should be set your full name";
                    }
                    if(empty($email)){
                        $formError[] = "You should be set your Email";
                    }
                    if(empty($password)){
                        $formError[] = "You should be set a Password";
                    }
                    // print the error
                    foreach($formError as $error){
                        echo "<div class='container'>";
                            echo "<div class='alert alert-danger m-1'>". $error ."</div>";
                        echo "</div>"; 
                    }
                    // if there are no error
                    if(empty($formError)){
                        $stmt = $con->prepare("INSERT INTO admins (Username, FullName, Email, Password, Date) VALUE (?, ?, ?, ?, now())");
                        $stmt->execute(array($username, $fullname, $email, $password));
                        echo "<div class='container'>";
                            echo "<div class='alert alert-success m-1'>Admin added Successefully</div>";
                            header('refresh: 2; account.php?action=add-admin');
                        echo "</div>";
                    }
                }
            }
            ?>
            
            <div class="container profile">
                    <div class="icn text-center">
                        <i class='bx bx-user'></i>
                    </div>
                    <form action="?action=add-admin" method="POST">
                        <div class="info">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="ms-4 mb-3">Add New Admin</h2>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"> 
                                            <input name="username" type="text" required class="form-control" placeholder="Username" autocomplete="OFF">
                                        </li>
                                        <li class="list-group-item"> 
                                            <input name="fullname" type="text" required class="form-control" placeholder="Full Name" autocomplete="OFF">
                                        </li>
                                        <li class="list-group-item"> 
                                            <input name="email" type="email" required class="form-control" placeholder="Email" autocomplete="OFF">
                                        </li>
                                        <li class="list-group-item"> 
                                            <input name="password" type="password" required class="form-control" placeholder="Password" autocomplete="OFF">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <button type="submit" name="submit" class="btn btn-success float-end mt-3">Add</button>
                        </div>
                    </form>
                </div>
<?php
        } elseif ($link == "edit"){ // edit account page 
            // check if account exist in database
            $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : 0;
            $stmt = $con->prepare("SELECT * FROM admins WHERE Admin_id = ?");
            $stmt->execute(array($id));
            $rows = $stmt->fetch();
            // Look if exist
            if($stmt->rowCount() > 0){ ?>
                <div class="container profile">
                    <div class="icn text-center">
                        <i class='bx bx-user'></i>
                    </div>
                    <form action="?action=update&id=<?php echo $rows['Admin_id'] ?>" method="POST">
                        <div class="info">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="ms-4 mb-3">Edit Pofile</h2>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"> 
                                            <input name="username" type="text" required class="form-control" placeholder="Username" value="<?php echo $rows['UserName'] ?>" autocomplete="OFF">
                                        </li>
                                        <li class="list-group-item"> 
                                            <input name="fullname" type="text" required class="form-control" placeholder="Full Name" value="<?php echo $rows['FullName'] ?>" autocomplete="OFF">
                                        </li>
                                        <li class="list-group-item"> 
                                            <input name="email" type="text" required class="form-control" placeholder="Email" value="<?php echo $rows['Email'] ?>" autocomplete="OFF">
                                        </li>
                                        <li class="list-group-item"> 
                                            <strong>Password</strong> <br>
                                            <a href="?action=password&id=<?php echo $rows['Admin_id'] ?>" class="btn btn-success edit">Edit Password</a> 
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <button type="submit" name="submit" class="btn btn-success float-end mt-3">Save</button>
                        </div>
                    </form>
                </div>
<?php
            // if not exist
            } else {
                echo "<div class='container'>";
                    echo "<div class='alert alert-danger'>Error: id not exist</div>";
                    echo "<div class='alert alert-info m-1'>You will be redirected to dashboard in 4 second</div>";
                    header("refresh: 4; dashboard.php");    
                echo "</div>";
            }

        } elseif($link == "update"){ // update account page 
            $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : 0;
            // check if admin account exist in database
            $stmt = $con->prepare("SELECT * FROM admins WHERE Admin_id = ?");
            $stmt->execute(array($id));
            // check if comming from Post Request
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
                $fullname = filter_var($_POST['fullname'], FILTER_SANITIZE_STRING);
                $email    = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
                // Form validate
                $formError = array();
                if(empty($username)){
                    $formError[] = "You should be set a Username";
                }
                if(empty($fullname)){
                    $formError[] = "You should be set your full name";
                }
                if(empty($email)){
                    $formError[] = "You should be set your email";
                } 
                // print the error
                foreach($formError as $error){
                    echo "<div class='container'>";
                        echo "<div class='alert alert-danger m-1'>". $error ."</div>";
                        header("refresh: 4; account.php?action=profile&id=". $_SESSION["adminId"] ."");
                    echo "</div>"; 
                }
                // if there are no error
                if(empty($formError)){
                    if($stmt->rowCount() > 0){
                        $inst = $con->prepare("UPDATE admins SET UserName = ?, FullName = ?, Email = ? WHERE Admin_id = '$id'");
                        $inst->execute(array($username, $fullname, $email));
                        echo "<div class='container'>";
                            echo "<div class='alert alert-success m-1'>Data Inserted Successefully</div>";
                            header("refresh: 2; account.php?action=edit&id=". $_SESSION["adminId"] ."");
                        echo "</div>"; 
                    // if not exist   
                    } else {
                        echo "<div class='container'>";
                            echo "<div class='alert alert-danger'>Error: id not exist</div>";
                            echo "<div class='alert alert-info m-1'>You will be redirected to dashboard in 4 second</div>";
                            header("refresh: 4; dashboard.php");    
                        echo "</div>";
                    }
                }
                
            } else {
                echo "<div class='container'>";
                    echo "<div class='alert alert-danger'>You can't browse this page directly</div>";
                    echo "<div class='alert alert-info m-1'>You will be redirected to dashboard in 4 second</div>";
                    header("refresh: 4; dashboard.php");    
                echo "</div>";
            }

        } elseif ($link == "password"){ 
            $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : 0;
            // check if account exist in database
            $stmt = $con->prepare("SELECT * FROM admins WHERE Admin_id = ?");
            $stmt->execute(array($id));
            $rows = $stmt->fetch();
            // Look if exist
            if($stmt->rowCount() > 0){   ?>
                <div class="container profile">
                    <div class="icn text-center">
                        <i class='bx bx-user'></i>
                    </div>
                    <form action="?action=editpass&id=<?php echo $rows["Admin_id"] ?>" method="POST">
                        <div class="info">
                            <div class="card">
                                <div class="card-body">
                                <h2 class="ms-4 mb-3">Edit Password</h2>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"> 
                                            <input name="oldpass" type="password" required class="form-control" placeholder="Your Current Password" autocomplete="OFF">
                                        </li>
                                        <li class="list-group-item"> 
                                            <input name="newpass" type="password" required class="form-control" placeholder="New Password" autocomplete="OFF">
                                        </li>
                                        <li class="list-group-item"> 
                                            <input name="cnfpass" type="password" required class="form-control" placeholder="Confirm Password" autocomplete="OFF"> 
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success mt-3 float-end">Save</button>
                        </div>
                    </form>
                </div>
<?php
            // if not exist
            } else {
                echo "<div class='container'>";
                    echo "<div class='alert alert-danger'>Error: id not exist</div>";
                    echo "<div class='alert alert-info m-1'>You will be redirected to dashboard in 4 second</div>";
                    header("refresh: 4; dashboard.php");    
                echo "</div>";
            }
        } elseif ($link == "editpass"){
            
            $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : 0;
            // check if admin account exist in database
            $stmt = $con->prepare("SELECT * FROM admins WHERE Admin_id = ?");
            $stmt->execute(array($id));
            $rows = $stmt->fetch();
            // check if comming from Post Request
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                $oldpass = filter_var($_POST['oldpass'], FILTER_SANITIZE_STRING);
                $newpass = filter_var($_POST['newpass'], FILTER_SANITIZE_STRING);
                $cnfpass = filter_var($_POST['cnfpass'], FILTER_SANITIZE_STRING);
                $password = password_hash($newpass, PASSWORD_DEFAULT);
                if($stmt->rowCount() > 0){
                    if(password_verify($oldpass, $rows['Password'])){
                        if(password_verify($cnfpass, password_hash($newpass, PASSWORD_DEFAULT))){
                            $stmt = $con->prepare("UPDATE admins SET Password = ? WHERE Admin_id = '$id'");
                            $stmt->execute(array($password));
                            echo "<div class='container'>";
                                echo "<div class='alert alert-success'>Password Changed seccessfully</div>";echo "<div class='alert alert-info m-1'>You will be redirected to Edit Password in 4 second</div>";
                                header("refresh: 3; account.php?action=password&id=". $rows['Admin_id'] ."");    
                            echo "</div>";
                            
                        } else {
                            echo "<div class='container'>";
                                echo "<div class='alert alert-danger'>Password Not Match</div>";
                                echo "<div class='alert alert-info m-1'>You will be redirected to Edit Password in 3 second</div>";
                                header("refresh: 3; account.php?action=password&id=". $rows['Admin_id'] ."");    
                            echo "</div>";
                        }
                    } else {
                        echo "<div class='container'>";
                            echo "<div class='alert alert-danger'>current pass is wrong</div>";
                            echo "<div class='alert alert-info m-1'>You will be redirected to Edit Password in 3 second</div>";
                            header("refresh: 3; account.php?action=password&id=". $rows['Admin_id'] ."");    
                        echo "</div>";
                    }
                } 
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