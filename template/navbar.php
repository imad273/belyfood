<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">BELYFOOD</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0" id="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link <?php if($title == "Belyfood"){ echo "active"; } else { echo "";} ?>" aria-current="page" href="index.php"><i class='bx bx-home'></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($title == "Menu"){ echo "active"; } else { echo "";} ?>" href="menu.php"><i class='bx bx-food-menu'></i> Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($title == "Reviews"){ echo "active"; } else { echo "";} ?>" href="reviews.php"><i class='bx bx-notepad'></i> Review</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?php if($title == "Contact"){ echo "active"; } else { echo "";} ?>" href="contact.php"><i class='bx bx-mail-send'></i> Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>