<?php
//session start
session_id("adminLoginSession");
session_start();
//Admin logout
if ($_POST['action'] == 'adminLogout') {
  session_unset();
  session_destroy();
  echo "logout";
  exit;
}

?>
<!-- Header For Admin Which Contain  Login and Logout button -->
<header id="header" class="header fixed-top d-flex align-items-center z-9999" style="background-color:lightblue;">
  <div class="col-2 d-md-none fa-2xl">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
      <i class="fa-solid fa-bars"></i>
    </button>
  </div>
  <div class="col-2 d-none d-md-block">

    <div class="d-flex align-items-center justify-content-between">
      <a href="<?php echo SITE_URL; ?>eCommerce/admin/dashboard.php" class="logo d-flex align-items-center">
        <img src="<?php echo SITE_URL; ?>eCommerce/assets/image/companyIcon.png" alt="...">
        <span class="d-none d-md-block">Admin Pannel</span>
      </a>
    </div>
  </div>
  <div class="col-4 d-none d-md-block">
   <?php echo $breadcrump;?>
  </div>
  <div class="col">
    <img src="<?php echo SITE_URL; ?>eCommerce/assets/image/Logo.png" alt="..." width="200px">
  </div>
  <div class="col d-flex justify-content-end">
    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center fs-5 my-auto">
        <li class="nav-item dropdown pe-2 d-flex gap-2">
          <span class="d-none d-md-block ps-2">Welcome</span>
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <span class="dropdown-toggle ps-2"><?php echo $_SESSION['username'];?></span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li>
              <button type="button" class="dropdown-item d-flex align-items-center adminLogout"><i class="bi bi-box-arrow-right"> </i> Sign Out</button>
            </li>

          </ul>
        </li>

      </ul>
    </nav>
  </div>
</header>
<!-- Sidebar for admin -->
<div class="row m-0 pt-5">
  <div class="col-12 col-md-2">
    <aside id="sidebar" class="collapse d-md-block fixed-top  bg-white z-9999 mt-5" style="width:min-content; margin-top: 60px !important;">
      <ul class="sidebar-nav" id="sidebar-nav" style="width: max-content;margin: revert;">
        <li class="nav-item">
          <a class="nav-link " href="<?php echo SITE_URL; ?>eCommerce/admin/dashboard.php">
            <span class="material-symbols-outlined">
              grid_view
            </span>
            <span>Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <span>
            <div class="accordion accordion-flush nav-link p-0" id="CustomerAccordion">
              <div class="accordion-item px-3">
                <h2 class="accordion-header" id="CustomerAccordionFlush">
                  <button class="nav-link px-0 accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#CustomerAccordionCollapse" aria-expanded="false" aria-controls="CustomerAccordionCollapse">
                    <i class="fa-solid fa-people-line"></i><span>Customer</span>
                  </button>
                </h2>
                <div id="CustomerAccordionCollapse" class="accordion-collapse collapse" aria-labelledby="CustomerAccordionFlush" data-bs-parent="#CustomerAccordion">
                  <div class="accordion-body">
                    <ul class="p-0" style="width: max-content;">
                      <li class="nav-item"><a class="nav-link collapsed f-flex gap-1" href="<?php echo SITE_URL; ?>eCommerce/admin/customerList.php">List Customer</a></li>
                      <li class="nav-item"><a class="nav-link collapsed f-flex gap-1" href="<?php echo SITE_URL; ?>eCommerce/admin/addCustomer.php">Add New Customer</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </span>
        </li>
        <li class="nav-item">
          <span>
            <div class="accordion accordion-flush nav-link p-0" id="productAccordion">
              <div class="accordion-item px-3">
                <h2 class="accordion-header" id="productAccordionFlush">
                  <button class="nav-link px-0 accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ProductAccordionCollapse" aria-expanded="false" aria-controls="ProductAccordionCollapse">
                    <i class="fa-solid fa-gift"></i><span>Product</span>
                  </button>
                </h2>
                <div id="ProductAccordionCollapse" class="accordion-collapse collapse" aria-labelledby="productAccordionFlush" data-bs-parent="#productAccordion">
                  <div class="accordion-body">
                    <ul class="p-0" style="width: max-content;">
                      <li class="nav-item"><a class="nav-link collapsed f-flex gap-1" href="<?php echo SITE_URL; ?>eCommerce/admin/productList.php">List Product</a></li>
                      <li class="nav-item"><a class="nav-link collapsed f-flex gap-1" href="<?php echo SITE_URL; ?>eCommerce/admin/addProduct.php">Add New Product</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </span>
        </li>
        <li class="nav-item">
          <span>
            <div class="accordion accordion-flush nav-link p-0" id="CategoryAccordion">
              <div class="accordion-item px-3">
                <h2 class="accordion-header" id="CategoryAccordionFlush">
                  <button class="nav-link px-0 accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#CategoryAccordionCollapse" aria-expanded="false" aria-controls="CategoryAccordionCollapse">
                    <i class="bi bi-tags-fill"></i><span>Category</span>
                  </button>
                </h2>
                <div id="CategoryAccordionCollapse" class="accordion-collapse collapse" aria-labelledby="CategoryAccordionFlush" data-bs-parent="#CategoryAccordion">
                  <div class="accordion-body">
                    <ul class="p-0" style="width: max-content;">
                      <li class="nav-item"><a class="nav-link collapsed f-flex gap-1" href="<?php echo SITE_URL; ?>eCommerce/admin/categories.php">List Categories</a></li>
                      <li class="nav-item"><a class="nav-link collapsed f-flex gap-1" href="<?php echo SITE_URL; ?>eCommerce/admin/addCategories.php">Add New Category</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </span>
        </li>
        <li class="nav-item">
          <a class="nav-link collapsed f-flex gap-1" href="<?php echo SITE_URL;?>eCommerce/admin/orderlist.php">
          <i class="bi bi-clipboard-check-fill"></i>
            <span>Order List</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link collapsed f-flex gap-1" href="<?php echo SITE_URL;?>eCommerce/admin/faq.php">
            <i class="fa-brands fa-font-awesome"></i>
            <span>FAQ</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link collapsed f-flex gap-1" href="<?php echo SITE_URL;?>eCommerce/admin/theme.php">
          <i class="fab fa-affiliatetheme"></i>
            <!-- <i class="fa-brands fa-font-awesome"></i> -->
            <span>Theme</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link collapsed f-flex gap-1" href="<?php echo SITE_URL;?>eCommerce/admin/coupon.php">
          <i class="fa-solid fa-percent"></i>
            <!-- <i class="fa-brands fa-font-awesome"></i> -->
            <span>Coupons</span>
          </a>
        </li>
        <li class="nav-item">
          <span>
            <div class="accordion accordion-flush nav-link p-0" id="CategoryAccordion">
              <div class="accordion-item px-3">
                <h2 class="accordion-header" id="SettingsAccordionFlush">
                  <button class="nav-link px-0 accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#SettingsAccordionCollapse" aria-expanded="false" aria-controls="SettingsAccordionCollapse">
                  <i class="bi bi-gear-fill"></i><span>Settings</span>
                  </button>
                </h2>
                <div id="SettingsAccordionCollapse" class="accordion-collapse collapse" aria-labelledby="SettingsAccordionFlush" data-bs-parent="#SettingsAccordion">
                  <div class="accordion-body">
                    <ul class="p-0" style="width: max-content;">
                      <li class="nav-item"><a class="nav-link collapsed f-flex gap-1" data-bs-toggle="modal" href="#staticBackdrop">Change Password</a></li>
                      <li class="nav-item"><button type="button" class="dropdown-item d-flex align-items-center nav-link gap-1 adminLogout" >Logout</button></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </span>
        </li>
      </ul>
    </aside>
  </div>




  <!-- reset password modal -->
<div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex justify-content-center py-4">
                    <div class="logo d-flex align-items-center w-auto">
                        <img src="<?php echo SITE_URL; ?>eCommerce/assets/image/Logo.png" alt="...">
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" method="post" novalidate>
                    <h1 class="modal-title fs-5 text-center" id="staticBackdropLabel">Reset Password</h1>
                    <div class="col-md-12">
                        <label for="validationCustomUsername" class="form-label">Username</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                            <input type="text" class="form-control" id="validationCustomUsername" aria-describedby="inputGroupPrepend" required>
                            <div class="invalid-feedback">
                                Please enter a username.
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="currentPassword" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="currentPassword" name="Currentpassword" required>
                        </div>
                        <div class="col-md-6">
                            <label for="newPassword" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">CANCLE</button>
                <button type="button" class="btn btn-success" id="resetPassword">RESET</button>
            </div>
        </div>
    </div>
</div>
    