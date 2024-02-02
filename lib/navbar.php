<!-- Hearder and navbar for user -->
<!-- Header -->
<div class="container-fluid bg-white" id="header">
    <div class="row gy-3 mt-3 my-auto ">
        <div class="col-lg-2 col-sm-4 col-4 d-flex justify-content-start">
            <a href="index.php" class="float-start">
                <img src="<?php echo SITE_URL;?>eCommerce/assets/image/Logo.png" class="w-100">
            </a>
        </div>
        <div class="order-lg-last col-lg-7 col-sm-8 col-8 my-auto">
            <div class="d-flex float-end">
                <a href="#" id="loginnav" class="btn btn1 text-white me-1 border rounded py-1 px-3 nav-link align-items-center" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="fas fa-user-alt m-1 me-md-2"></i>
                    <p class="d-none d-md-block mb-0">Sign in</p>
                </a>
                <div class="nav-item dropdown pe-3 gap-2" id="nav">
                    <span class="d-none d-md-block ps-2 my-auto">Welcome</span>
                    <a class="nav-link nav-profile d-flex align-items-center pe-0 my-auto" href="#" data-bs-toggle="dropdown">
                        <span class="dropdown-toggle ps-2"><?php echo $_SESSION['userName']; ?></span>
                    </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li>
                     <a class="dropdown-item d-flex align-items-center" href="<?php echo SITE_URL;?>eCommerce/customer_profile.php">
                        <i class="bi bi-person"></i>
                        <span>My Profile</span>
                     </a>
                     </li>
                        <li>
                        <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="<?php echo SITE_URL;?>eCommerce/orderList.php">
                            <i class="bi bi-bag-check"></i>
                                <span>My Orders</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <button type="button" class="dropdown-item d-flex align-items-center" id="userLogout"><i class="bi bi-box-arrow-right"> </i>Sign Out</button>
                        </li>
                    </ul>

            </div>
            <a href="<?php echo SITE_URL;?>eCommerce/cart.php" class="btn btn1 text-white border rounded py-1 px-3 nav-link d-flex align-items-center"> <i class="fas fa-shopping-cart m-1 me-md-2"></i>
                <p class="d-none d-md-block mb-0">My cart</p>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-12 col-12 my-auto p-3">
        <div class="input-group float-center">
            <button class="navbar-toggler collapsed btn1 rounded-start p-3 d-lg-none d-sm-block" type="button" data-bs-toggle="collapse" data-bs-target="#navbarLeftAlignExample" aria-controls="navbarLeftAlignExample" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <input type="Search" class="form-control" id="homeSearch" placeholder="Search..">
            <button type="button" class="btn btn1 shadow-0">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
</div>
</div>
<!-- Dynamic Navbar -->
<nav class="navbar navbar1 navbar-expand-lg navbar-dark  mt-2 d-lg-block collapse navbar-collapse" id="navbarLeftAlignExample">
    <div class="container justify-content-center justify-content-md-between">
        <div>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                       <a class="nav-link" href="<?php echo SITE_URL;?>eCommerce/index.php">Home</a>
                   </li>
                <?php 
                    $conn = new Connection();
                    $result = $conn->select("Categories");
                    foreach ($result as $value) {
                       echo '<li class="nav-item">
                       <a class="nav-link" href="'.SITE_URL.'eCommerce/index.php?category_id='.base64_encode($value["category_id"]).'">'.$value["name"].'</a>
                   </li>'; 
                    }
                ?>
            </ul>
        </div>
    </div>
</nav>