<?php
    session_start();
    // Title of this page
    $title = "Reviews";
    // includes the required files
    require "config.php";
    require "func.php";
    include "template/header.php";
    include "template/navbar.php";

    if(isset($_POST['btn'])){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $name    = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $review  = filter_var($_POST['review'], FILTER_SANITIZE_STRING);
            $rate    = filter_var($_POST['rate'], FILTER_SANITIZE_NUMBER_INT);

            $stmt = $con->prepare("INSERT INTO reviews (Reviewer_name, Description, Rate) VALUE (?, ?, ?)");
            $stmt->execute(array($name, $review, $rate));

            echo "<div class='container'>";
                echo "<div class='alert alert-success m-1'>Review added Successefully</div>";
                header('refresh: 2; reviews.php');
            echo "</div>";
        }
    }
?>

    <div class="container mt-3">
        <div class="add-rev">
            <h2 class="mb-3">Add Review</h2>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="mb-3">
                    <input type="text" name="name" placeholder="Name" class="form-control" autocomplete="OFF" required>
                </div>
                <div class="mb-3">
                    <textarea name="review" placeholder="Reveiw" rows="3" class="form-control" style="resize: none;" autocomplete="OFF" required></textarea>
                </div>
                Rate /10*
                <div class="mt-2 mb-3">
                    <input type="number" name="rate" max="10" min="0" placeholder="Sebject" autocomplete="OFF" class="form-control" required>
                </div>
                <button type="submit" name="btn" class="btn btn-primary">Add</button>
            </form>
        </div>
        <?php
            $stmt = $con->prepare("SELECT * FROM reviews ORDER BY Review_id DESC");
            $stmt->execute();
        ?>
        <div class="rev">
            <h2 class="m-4">Reviews</h2>
            <?php while($rows = $stmt->fetch()){ ?>
                <div class="hero">
                    <h3><?php echo $rows['Reviewer_name'] ?></h3>
                    <i class='bx bx-star'></i><span><?php echo $rows['Rate'] ?>/10</span>
                    <p><?php echo $rows['Description'] ?></p>
                </div>
            <?php } ?>
        </div>
    </div>

<?php
    include "template/footer.php";
?>