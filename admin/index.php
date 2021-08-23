<?php
    session_start();
    // check if admin is already login
    if(isset($_SESSION['adminUsername'])){
        header('location: dashboard.php');
    }
    // Title of this page
    $title = "Login";
    // includes the required files
    require "../config.php";
    require "func.php";
    include "template/header.php";

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // get data from form
            $username     = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
            $password     = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
            // validate form
            $formError = array();
            if(empty($username)){
                $formError[] = "Username can't be empty";
            }
            if(empty($password)){
                $formError[] = "Password can't be empty";
            }
            foreach($formError as $error){
                echo "<div class='container'>";
                        echo "<div class='alert alert-danger'>" . $error . "</div>";
                    echo "</div>";
            }
            // select data from database
            $stmt = $con->prepare("SELECT Admin_id, UserName, Password FROM admins WHERE UserName = ?");
            $stmt->execute(array($username));
            $rows = $stmt->fetch();
            if($stmt->rowCount() === 1){
                if(password_verify($password, $rows['Password'])){
                    echo "<div class='container'>";
                        echo "<div class='alert alert-success'>Login Successfully</div>";
                    echo "</div>";
                    $_SESSION['adminUsername'] = $rows['UserName'];
                    $_SESSION["adminId"] = $rows['Admin_id'];
                    header('refresh: 2; dashboard.php');
                } else {
                    echo "<div class='container'>";
                        echo "<div class='alert alert-danger'>Your Password is wrong</div>";
                    echo "</div>";
                }
            } else {
                echo "<div class='container'>";
                    echo "<div class='alert alert-danger'>Your Username is wrong</div>";
                echo "</div>";
            }
        }
?>

    <section class="login">
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
            <h3 class="text-center">Admin Login</h3>
            <div class="mb-3">
                <label for="InputEmail1" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" id="InputEmail1" aria-describedby="emailHelp" required autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="InputPassword1" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="InputPassword1" required >
            </div>
            <button type="submit" name="btn" class="btn btn-primary">Login</button>
        </form>
    </section>

<?php 
    include "template/footer.php";
?>