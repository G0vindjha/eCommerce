<?php
//session start
session_id("customerLoginSession");
session_start();
//check customer login 
if(!isset($_SESSION['customer_id'])){
    header("Location:index.php");
}
$title = "Proto";
require_once 'lib/siteConstant.php';
require_once 'lib/Connection.php';
require_once 'lib/header_user.php';
require_once 'lib/navbar.php';
$data = array(
    ":customer_id" => array(
        "value" => $_SESSION['customer_id'],
        "type" => 'INT'
    ),
);
//limit for pagination
$results_per_page = 5;
//db connection
$conn = new Connection();
//fetch all the data from order table for count
$result1 = $conn->select("Orders", "*",null,null,"customer_id = :customer_id", $data);
//count number of rows
$number_of_result = count($result1); 
$number_of_page = ceil($number_of_result / $results_per_page);

//determine which page number visitor is currently on  
if (!isset($_GET['page']) || (int)(base64_decode($_GET['page'])) <= 0) {
    $page = 1;
} else {
    $page = (int)(base64_decode($_GET['page']));
}
$page_first_result = ($page - 1) * $results_per_page;
//fetch all the order data
$result = $conn->select("Orders", "Orders.quantity,Orders.order_date,Orders.total_amount,Products.name,Products.price,Products.image,Orders.product_id", 'LEFT JOIN', array("Products" => array("product_id" => "product_id")),"customer_id = :customer_id", $data, null, "order_id", "DESC", $results_per_page, $page_first_result);
foreach ($result as $value) {
    /* Dynamic order product list */
    $output .= '
           
    <div class="card shadow-0 border mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-2">
                <img src="' . SITE_URL . 'eCommerce/assets/image/productUpload/' . $value["product_id"] . '/' . $value["image"] . '" class="img-fluid" alt="Phone">
            </div>
            <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                <p class="text-muted mb-0">' . $value['name'] . '</p>
            </div>
            <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                <p class="text-muted mb-0 small">' . date_format(date_create($value['order_date']) ,"d/m/Y"). '</p>
            </div>
            <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                <p class="text-muted mb-0 small">' . $value['quantity'] . '</p>
            </div>
            <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                <p class="text-muted mb-0 small"><i class="fa-solid fa-indian-rupee-sign"></i> ' . $value['price'] . '</p>
            </div>
            <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                <p class="text-muted mb-0 small"><i class="fa-solid fa-indian-rupee-sign"></i> ' . $value['total_amount'] . '</p>
            </div>
        </div>
        <hr class="mb-4" style="background-color: #118383; opacity: 1;">
        <div class="row d-flex align-items-center">
            <div class="col-md-2">
                <p class="text-muted mb-0 small">Track Order</p>
            </div>
            <div class="col-md-10">
                <div class="progress" style="height: 6px; border-radius: 16px;">
                    <div class="progress-bar" role="progressbar" style="width: 65%; border-radius: 16px; background-color: #118383;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="d-flex justify-content-around mb-1">
                    <p class="text-muted mt-1 mb-0 small ms-xl-5">Out for delivary</p>
                    <p class="text-muted mt-1 mb-0 small ms-xl-5">Delivered</p>
                </div>
            </div>
        </div>
    </div>
</div>';
}
//conditions for pagination
if((int)(base64_decode($_GET['page'])) > 1){
    $prevPage = (int)(base64_decode($_GET['page']))-1;
}
else{
    $prevPage = 1; 
}
if((int)(base64_decode($_GET['page'])) >= $number_of_page){
    $nextPage = (int)(base64_decode($_GET['page']));
}
else{
    $nextPage = (int)(base64_decode($_GET['page']))+1;
}
//pagination start
$pagination = '<nav aria-label="Page navigation example" class="d-flex justify-content-center">
    <ul class="pagination">
      <li class="page-item"><a class="page-link" href="orderList.php?page=' . base64_encode($prevPage) . '">Previous</a></li>'; 
for ($page = 1; $page <= $number_of_page; $page++) {
    //active link
    if((int)(base64_decode($_GET['page'])) == $page){
        $pagination .='
        <li class="page-item"><a class="page-link active" href = "orderList.php?page=' . base64_encode($page) . '">' . $page . '</a></li>
        ';
    }
    else{
        $pagination .='
        <li class="page-item"><a class="page-link" href = "orderList.php?page=' . base64_encode($page) . '">' . $page . '</a></li>
        ';
    }
     
}
$pagination .= '<li class="page-item"><a class="page-link" href="orderList.php?page=' . base64_encode($nextPage) . '">Next</a></li>
</ul>
</nav>';
//pagination ends
?>
<section class="h-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-12">
                <!-- Product list card -->
                <div class="card" style="border-radius: 10px;border:2px solid #118383;">
                    <div class="card-header px-4 py-5 " style="background-color: #118383;">
                        <h5 class="text-light mb-0">Thanks for your Order,<?php echo '<a class="text-light" href="'.SITE_URL.'eCommerce/customer_profile.php">'.$_SESSION['userName'].'</a>' ?> !!!</h5>
                    </div>
                    <div class="card shadow-0 border mb-4 d-none d-md-block">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <p class="text-muted mb-0">Image</p>
                                </div>
                                <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                    <p class="text-muted mb-0">Name</p>
                                </div>
                                <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                    <p class="text-muted mb-0 small">Order Date</p>
                                </div>
                                <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                    <p class="text-muted mb-0 small">Quantity</p>
                                </div>
                                <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                    <p class="text-muted mb-0 small">Price</p>
                                </div>
                                <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                    <p class="text-muted mb-0 small">Total Price</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo $output; ?>
                </div>
            </div>
        </div>
    </div>
<?php echo $pagination;?>
</section>
<?php
echo $script;
require_once 'lib/footer.php';
?>