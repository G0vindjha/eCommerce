<?php
//session start
session_id("customerLoginSession");
session_start();
//customer login and product order status
if (!isset($_GET['status']) || !isset($_SESSION['customer_id'])) {
    header("Location:index.php");
}
$title = "Proto";
require_once 'lib/siteConstant.php';
require_once 'lib/header_user.php';
require_once 'lib/Connection.php';
require_once 'lib/navbar.php';
?>
<!-- Order success animation -->
<div class="orderStatus swal2-container swal2-container1">
    <div class="swal2-icon swal2-success swal2-icon-show" style="display: flex;" > 
            <div class="swal2-success-circular-line-left" style="background-color: rgb(255, 255, 255);"></div>
            <span class="swal2-success-line-tip"></span> <span class="swal2-success-line-long"></span>
            <div class="swal2-success-ring"></div>
            <div class="swal2-success-fix" style="background-color: rgb(255, 255, 255);"></div>
            <div class="swal2-success-circular-line-right" style="background-color: rgb(255, 255, 255);"></div>
        </div>
        <h2 class="swal2-title" id="swal2-title" style="display: block;">Order Placed</h2>
</div>
<!-- Related product sugession -->
<header class="my-4 ">
        <h3 class="text-center">::: Suggested Products :::</h3>
    </header>
<div class="row" id="productList">
        <?php
         $category_id = array(
            ":category_id" => array(
                "value" => base64_decode($_GET['category']),
                "type" => 'INT'
            ),
        );
        $conn = new Connection();
        $result = $conn->select("Products","*",null,null, "category_id=:category_id", $category_id,null,"product_id","DESC",8);
        foreach ($result as $value) {
            echo '<div class="col-lg-3 col-md-6 col-sm-6 productCard">

            <div class="card my-2 shadow-0">
                <a href="'.SITE_URL.'eCommerce/productInfo.php?product_id='. base64_encode($value["product_id"]) . '" class="img-wrap">
                    <img src="' . SITE_URL . 'eCommerce/assets/image/productUpload/' . $value["product_id"] . '/' . $value["image"] . '" class="card-img-top" style="aspect-ratio: 1 / 1">
                </a>
                <div class="card-body p-3">

                    <h5 class="card-title"><i class="fa-solid fa-indian-rupee-sign"></i> ' . $value["price"] . '</h5>
                    <p class="card-text mb-0">' . $value["name"] . '</p>
                    <p class="text-muted">
                        ' . substr_replace($value["summary"], "...", 50) . '
                    </p>
                </div>
                <a name="" id="" class="btn btn1 btn btn1-primary products" href="'.SITE_URL.'eCommerce/productInfo.php?product_id='. base64_encode($value["product_id"]) . '" role="button">View Product</a>
            </div>
        </div>';
        }
        ?>
    </div>
    <style>
     .products, .footerTheme {
        background-color: <?php echo $color1;?> !important;
        color: <?php echo $color2;?> !important;
    }
    .products:hover{
        background-color: <?php echo $color3;?> !important;
        color: <?php echo $color4;?> !important;

    }
    </style>
<?php
echo $script;
require_once 'lib/footer.php';
?>