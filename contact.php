<?php
    session_start();
    // Title of this page
    $title = "Contact";
    // includes the required files
    require "config.php";
    require "func.php";
    include "template/header.php";
    include "template/navbar.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $from    = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
        $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
        $message = filter_var($_POST['msg'], FILTER_SANITIZE_STRING);
        $headers = "from: " . $from . "\r\n";

        $mail = mail("username@mail.com", $subject, $message, $headers);

        if($mail){
            echo "<div class='container'>";
                echo "<div class='alert alert-success m-1'>Message send success Successefully</div>";
            echo "</div>";
        }
    }
?>
    <div class="container">
        <div class="contact mt-5">
            <h2 class="text-center">Send Message</h2>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="mb-3">
                    <input type="text" name="FullName" placeholder="Name" class="form-control" aria-describedby="emailHelp" required autocomplete="off">
                </div>
                <div class="mb-3">
                    <input type="text" name="email" placeholder="Your email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <input type="text" name="subject" placeholder="Sebject" class="form-control" required>
                </div>
                <div class="mb-3">
                    <textarea name="msg" placeholder="Message" style="resize: none;" class="form-control" rows="4" required></textarea>
                </div>
                <button type="submit" name="btn" class="btn btn-primary">Send</button>
            </form>
        </div>
    </div>

<?php
    include "template/footer.php";
?>