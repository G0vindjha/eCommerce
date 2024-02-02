<?php
//session start
session_id("adminLoginSession");
session_start();
//Admin login check
if (!isset($_SESSION['username'])) {
    header("Location:index.php");
    exit;
}
$title = "Order List";
$breadcrump = '<div class="pagetitle mt-4">
<h1>Orders</h1>
<nav>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
    <li class="breadcrumb-item active">Order List</li>
  </ol>
</nav>
</div>';
require_once '../lib/Connection.php';
require_once '../lib/siteConstant.php';
require_once '../lib/header.php';
require_once '../lib/navbar_admin.php';
//pagination limit
$results_per_page = 5;
//db connection
$conn = new Connection();
//fetvh all the data from the order table to count
$result1 = $conn->select("Orders", "*");
//count number of rows affected
$number_of_result = count($result1);
$number_of_page = ceil($number_of_result / $results_per_page);

//determine which page number visitor is currently on  
if (!isset($_GET['page']) || $_GET['page'] <= 0) {
    $page = 1;
} else {
    $page = $_GET['page'];
}
$page_first_result = ($page - 1) * $results_per_page;
//fetch all the order data
$result = $conn->select("Orders", "Orders.quantity,Orders.customer_id,Orders.order_date,Orders.total_amount,Products.name,Products.price,Products.image,Orders.product_id", 'LEFT JOIN', array("Products" => array("product_id" => "product_id")), null, null, null, "order_id", "DESC", $results_per_page, $page_first_result);
foreach ($result as $value) {
    //creating dynamic table for the order from db
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
//pagination conditions
if($_GET['page'] > 1){
    $prevPage = $_GET['page']-1;
}
else{
    $prevPage = 1; 
}
if($_GET['page'] >= $number_of_page){
    $nextPage = $_GET['page'];
}
else{
    $nextPage = $_GET['page']+1;
}
//pagination starts
$pagination = '<nav aria-label="Page navigation example" class="d-flex justify-content-center">
    <ul class="pagination">
      <li class="page-item"><a class="page-link" href="orderlist.php?page=' . $prevPage . '">Previous</a></li>'; 
for ($page = 1; $page <= $number_of_page; $page++) {
    if($_GET['page'] == $page){
        $pagination .='
        <li class="page-item"><a class="page-link active" href = "orderlist.php?page=' . $page . '">' . $page . '</a></li>
        ';
    }
    else{
        $pagination .='
        <li class="page-item"><a class="page-link" href = "orderlist.php?page=' . $page . '">' . $page . '</a></li>
        ';
    }
     
}
$pagination .= '<li class="page-item"><a class="page-link" href="orderlist.php?page=' . $nextPage . '">Next</a></li>
</ul>
</nav>';
//pagination ends
?>
<div class="col-12 col-md-10 m-0 p-0">
    <section class="h-100 gradient-custom">
        <div class="container-fluid py-5 h-100">
            <!-- Search box -->
            <form class="d-flex col-4" role="search">
                <input class="form-control me-2" type="search" id="searchOrder" placeholder="Search" aria-label="Search">
            </form>
            <!-- order list -->
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
<!-- pagination -->
<?php echo $pagination;?>
</div>
<?php
require_once '../lib/footer.php';
?>