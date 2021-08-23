<nav class="navbar navbar-expand-lg navbar-light ">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php">BELYFOOD</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0" id="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link <?php if($title == "Dashboard"){ echo "active"; } else { echo "";} ?>" aria-current="page" href="dashboard.php"><i class='bx bxs-dashboard'></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($title == "Orders"){ echo "active"; } else { echo "";} ?>" href="orders.php"><i class='bx bxs-calendar'></i> Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($title == "Menu"){ echo "active"; } else { echo "";} ?>" href="menu.php"><i class='bx bx-food-menu'></i> Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($title == "Account"){ echo "active"; } else { echo "";} ?>" href="account.php?action=profile&id=<?php echo $_SESSION["adminId"] ?>"><i class='bx bx-user-circle'></i> Account</a>
                </li>
            </ul>
        </div>
    </div>
</nav>