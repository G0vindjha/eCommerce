<?php
// session start
session_id("adminLoginSession");
session_start();
//Admin Logout by ajax call
if ($_POST['action'] == 'adminLogout') {
    session_unset();
    session_destroy();
    echo "logout";
    exit;
}
//Check admin login
if (!isset($_SESSION['username'])) {
    header("Location:index.php");
    exit;
}
$title = "Admin";
$breadcrump = '<div class="pagetitle mt-4">
<h1>Dashboard</h1>
<nav>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
    <li class="breadcrumb-item active">Dashboard</li>
  </ol>
</nav>
</div>';
require_once '../lib/Connection.php';
require_once '../lib/siteConstant.php';
require_once '../lib/header.php';
require_once '../lib/navbar_admin.php';
//db connection
$conn = new Connection();
$totalProducts = $conn->select("Products");
$totalCustomers = $conn->select("Customers");
$totalCategories = $conn->select("Categories");
$totalOrders = $conn->select("Orders");
//Recent Product div 
$Products = $conn->select("Products", "*", null, null, null, null, null, "product_id", "DESC", 4);
foreach ($Products as $Productsvalue) {
    $imgpath = SITE_URL . 'eCommerce/assets/image/productUpload/' . $Productsvalue['product_id'] . '/' . $Productsvalue['image'];
    $recentProducts .= '<div class="col-lg-3 col-md-6 col-sm-6 productCard">

    <div class="card my-2 shadow-0">
        <a href="#" class="img-wrap">
            <img src="' . $imgpath . '" class="card-img-top" style="aspect-ratio: 1 / 1">
        </a>
        <div class="card-body p-3">

            <h5 class="card-title"><i class="fa-solid fa-indian-rupee-sign"></i> ' . $Productsvalue["price"] . '</h5>
            <p class="card-text mb-0">' . $Productsvalue["name"] . '</p>
            <p class="text-muted">
                ' . substr_replace($Productsvalue["summary"], "...", 100) . '
            </p>
        </div>
    </div>
</div>';
}
//Recent customer div
$Customers = $conn->select("Customers", "*", null, null, null, null, null, "customer_id", "DESC", 4);
foreach ($Customers as $Customersvalue) {
    $customerImgpath = SITE_URL . 'eCommerce/assets/image/customerUpload/' . $Customersvalue['customer_id'] . '/' . $Customersvalue['image'];
    $recentCustomers .= '<div class="col-lg-3 col-md-6 col-sm-6 productCard">
    <div class="card my-2 shadow-0">
        <a href="#" class="img-wrap">
            <img src="' . $customerImgpath . '" class="card-img-top" style="aspect-ratio: 1 / 1">
        </a>
        <div class="card-body p-3">

            <h5 class="card-title">' . $Customersvalue["name"] . '</h5>
            <p class="card-text mb-0">' . $Customersvalue["gender"] . '</p>
            <p class="card-text mb-0">' . $Customersvalue["email"] . '</p>
            <p class="card-text mb-0">' . $Customersvalue["phone_number"] . '</p>
            <p class="text-muted">
                ' . $Customersvalue["address"] . '
            </p>
        </div>
    </div>
</div>';
}
//Recent category div
$Categories = $conn->select('Categories', ('Categories.category_id,Categories.name,Categories.description,SUM(quantity) as quantity '), 'LEFT JOIN', array('Products' => array("category_id" => "category_id")), null, null, "category_id", 'category_id', 'DESC', 4);;
foreach ($Categories as $Categoriesvalue) {
    if ($Categoriesvalue['quantity'] == null) {
        $quantity = ' <h6 class="text-danger">No Product Added in this category</h6>';
    } else {
        $quantity = ' <h3 class="text-success">' . $Categoriesvalue['quantity'] . '</h3>';
    }
    $recentCategories .= '   <div class="col-xl-3 col-sm-6 col-12 mb-4">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between px-md-1">
                <div>
                    ' . $quantity . '
                    <p class="mb-0">' . $Categoriesvalue['name'] . '</p>
                </div>
                <div class="align-self-center">
                    <i class="bi bi-tags-fill text-success fa-3x"></i>
                </div>
            </div>
            <div class="px-md-1">
                <div class="progress mt-3 mb-1 rounded" style="height: 7px">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
</div>';
}
//Recent order div
$result = $conn->select("Orders", "Orders.quantity,Orders.customer_id,Orders.order_date,Orders.total_amount,Products.name,Products.price,Products.image,Orders.product_id", "LEFT JOIN", array("Products" => array("product_id" => "product_id")), null, null, null, "order_id", "DESC", 4);
foreach ($result as $value) {
    $output .= '       
    <div class="card shadow-0 border mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-2">
                <img src="' . SITE_URL . 'eCommerce/assets/image/productUpload/' . $value["product_id"] . '/' . $value["image"] . '" class="img-fluid" alt="Phone">
            </div>
            <div class="col-md text-center d-flex justify-content-center align-items-center">
                <p class="text-muted mb-0">' . $value['name'] . '</p>
            </div>
            <div class="col-md text-center d-flex justify-content-center align-items-center">
            <p class="d-block d-md-none text-muted mb-0 small">Order Date:  </p>
                <p class="text-muted mb-0 small">' . date_format(date_create($value['order_date']), "d/m/Y") . '</p>
            </div>
            <div class="col-md text-center d-flex justify-content-center align-items-center">
            <p class="d-block d-md-none text-muted mb-0 small">Quantity :  </p>
                <p class="text-muted mb-0 small">' . $value['quantity'] . '</p>
            </div>
            <div class="col-md text-center d-flex justify-content-center align-items-center">
            <p class="d-block d-md-none text-muted mb-0 small">Price :  </p>
                <p class="text-muted mb-0 small"><i class="fa-solid fa-indian-rupee-sign"></i> ' . $value['price'] . '</p>
            </div>
            <div class="col-md text-center d-flex justify-content-center align-items-center">
            <p class="d-block d-md-none text-muted mb-0 small">Total Amount :  </p>
                <p class="text-muted mb-0 small"><i class="fa-solid fa-indian-rupee-sign"></i> ' . $value['total_amount'] . '</p>
            </div>
            <div class="col-md text-center d-flex justify-content-center align-items-center">
                <p class="d-block d-md-none text-muted mb-0 small">Customer Id :  </p>
                <p class="text-muted mb-0 small"> ' . $value['customer_id'] . '</p>
            </div>
        </div>
    </div>
  </div>';
}

?>
<!-- DashBoard -->
<div class="col-12 col-md-10 m-0 p-0">
    <div class="row d-flex justify-content-center p-0 m-0 mt-3">
        <div class="col-11 d-flex align-items-center border border-secondary shadow mb-5 bg-body rounded">
            <div class="col-6">
                <div class="illustration-text m-1">
                    <h4 class="illustration-text">Welcome Back, Admin!</h4>
                    <p class="mb-0">PROTO Dashboard</p>
                </div>
            </div>
            <div class="col-6 align-self-end text-end">
                <img src="<?php echo SITE_URL; ?>eCommerce/assets/image/customer-support.png" alt="Customer Support" class="img-fluid illustration-img">
            </div>
        </div>
    </div>
    <section>
<!-- Count Chart div for Customers,Product,Category& orders -->
        <div class="row">
            <div class="col-xl-3 col-sm-6 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                            <div>
                                <h3 class="text-info"><?php echo count($totalCustomers); ?></h3>
                                <p class="mb-0">Total Customers</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fa-solid fa-people-line text-info fa-3x"></i>
                            </div>
                        </div>
                        <div class="px-md-1">
                            <div class="progress mt-3 mb-1 rounded" style="height: 7px">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                            <div>
                                <h3 class="text-warning"><?php echo count($totalProducts); ?></h3>
                                <p class="mb-0">Total Products</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fa-solid fa-gift text-warning fa-3x"></i>
                            </div>
                        </div>
                        <div class="px-md-1">
                            <div class="progress mt-3 mb-1 rounded" style="height: 7px">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                            <div>
                                <h3 class="text-success"><?php echo count($totalCategories); ?></h3>
                                <p class="mb-0">Total Categories</p>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-tags-fill text-success fa-3x"></i>
                            </div>
                        </div>
                        <div class="px-md-1">
                            <div class="progress mt-3 mb-1 rounded" style="height: 7px">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                            <div>
                                <h3 class="text-danger"><?php echo count($totalOrders); ?></h3>
                                <p class="mb-0">Total Orders</p>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-bag-check text-danger fa-3x"></i>
                            </div>
                        </div>
                        <div class="px-md-1">
                            <div class="progress mt-3 mb-1 rounded" style="height: 7px">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="row" id="productList">
        <header class="mt-3">
            <h3 class="text-center">::: Recently Added products :::</h3>
        </header>
        <?php echo $recentProducts; ?>
    </div>
    <div class="row" id="productList">
        <header class="mt-3">
            <h3 class="text-center">::: Recently Joined Customers :::</h3>
        </header>
        <?php echo $recentCustomers; ?>
    </div>
    <div class="row" id="productList">
        <header class="mt-3">
            <h3 class="text-center">::: Recently Added Categories :::</h3>
        </header>
        <?php echo $recentCategories; ?>
    </div>
    <div class="row" id="productList">
        <header class="mt-3">
            <h3 class="text-center">::: Recent Orders :::</h3>
        </header>
        <section class="h-100 gradient-custom">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-lg-12 col-xl-12 p-0" style="border-radius: 10px;border:2px solid #118383;">
                        <div class="card d-none d-md-block" style="background-color: #118383;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md">
                                        <p class="text-light mb-0">Image</p>
                                    </div>
                                    <div class="col-md text-center d-flex justify-content-center align-items-center">
                                        <p class="text-light mb-0">Name</p>
                                    </div>
                                    <div class="col-md text-center d-flex justify-content-center align-items-center">
                                        <p class="text-light mb-0 small">Order Date</p>
                                    </div>
                                    <div class="col-md text-center d-flex justify-content-center align-items-center">
                                        <p class="text-light mb-0 small">Quantity</p>
                                    </div>
                                    <div class="col-md text-center d-flex justify-content-center align-items-center">
                                        <p class="text-light mb-0 small">Price</p>
                                    </div>
                                    <div class="col-md text-center d-flex justify-content-center align-items-center">
                                        <p class="text-light mb-0 small">Total Price</p>
                                    </div>
                                    <div class="col-md text-center d-flex justify-content-center align-items-center">
                                        <p class="text-light mb-0 small">Customer Id</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo $output; ?>
                    </div>
                </div>
            </div>
    </div>
    </section>
</div>
</div>
<?php
require_once '../lib/footer.php';
?>