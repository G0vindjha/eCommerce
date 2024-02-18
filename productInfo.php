<?php
//session start
session_id("customerLoginSession");
session_start();
$title = "Proto";
require_once 'lib/Connection.php';
//User login status
if (!isset($_GET['product_id'])) {
    header("Location:index.php");
} else {
    $conn = new Connection();
    $data = array(
        ":product_id" => array(
            "value" => base64_decode($_GET['product_id']),
            "type" => 'INT'
        ),
    );
    /* store product information */
    $result = $conn->select('Products', ('product_id,Products.name,summary,Products.description,price,`quantity`,image,Categories.name as CategoryName'), 'LEFT JOIN', array('Categories' => array("category_id" => "category_id")), "product_id = :product_id", $data, null, 'product_Id', 'ASC');
    $productImg =  '<img style="max-width: 100%; margin: auto;" class=" rounded-4 fit" src="' . SITE_URL . 'eCommerce/assets/image/productUpload/' . $result[0]["product_id"] . '/' . $result[0]["image"] . '">';
    $productName = $result[0]['name'];
    $productCategory = $result[0]['category'];
    $productPrice = $result[0]['price'];
    $productSummary = $result[0]['summary'];
    $productDescription = $result[0]['description'];
    $productQuantity = $result[0]['quantity'];
    if($productQuantity == 0){
        $productMsg = '<span class="text-danger ms-2">Out of stock</span>';
    }
    else{
        $productMsg = '<span class="text-success ms-2">In stock</span>';
    }
    //Add to cart
    if (isset($_POST['addToCart'])) {
        if(isset($_SESSION['customer_id'])){
            if($result[0]['quantity'] <= 0){
                $errorMsg =  "<small class='text-danger'>This item is out of stock!!</small>";
            }
            else{
                if($_POST['productQuantity'] <= 0){
                
                    $errorMsg =  "<small class='text-danger'>Add item in Cart!!</small>";
                }
                else{
                    $dataArr = array(
                        "customer_id"=>$_SESSION['customer_id'],
                        "product_id"=>$result[0]['product_id'],
                        "quantity"=>(int)($_POST['productQuantity']),
                        "price"=>$productPrice
                    );
                    $conn = new Connection();
                    $conn->insert("Cart ",$dataArr);
                    header("location:cart.php");
                }
            }
            
        }
        else{
            $errorMsg =  "<small class='text-danger'>Login first!!</small>";
        }

    }
}
require_once 'lib/siteConstant.php';
require_once 'lib/header_user.php';
require_once 'lib/navbar.php';  
?>
<!-- Product card-->
<div class="container">
    <div class="row gx-5 mt-3">
        <div class="col-lg-6">
            <div class="border rounded-4 mb-3 d-flex justify-content-center">
                <?php echo $productImg; ?>
            </div>
        </div>
        <main class="col-lg-6" id="productcardview">
            <div class="ps-lg-3">
                <h4 class="title text-dark">
                    <?php echo $productName; ?>
                </h4>
                <div class="d-flex flex-row my-3">
                    <div class="text-warning mb-1 me-2">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <span class="ms-1">
                            4.5
                        </span>
                    </div>
                </div>
                <div class="mb-3">
                    <span class="text-muted"><i class="fas fa-shopping-basket fa-sm mx-1"></i><?php echo $productQuantity; ?> Left</span>
                    <?php echo $productMsg;?>
                </div>
                <div class="mb-3">
                    <span class="h5"><i class="fa-solid fa-indian-rupee-sign"></i><?php echo $productPrice; ?></span>
                    <span class="text-muted">/per box</span>
                </div>
                <p>
                    <?php echo $productSummary; ?>
                </p>
                <hr>

                <form method="post">
                <div class="row mb-4">
                    <div class="col-md-4 col-4 mb-3">
                        <label class="mb-2 d-block">Quantity</label>
                        <div class="input-group mb-3" style="width: 170px;">
                            <button class="btn btn-white border border-secondary px-3" id="productMinus" type="button" id="button-addon1">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="hidden" id="exsistingQuantity" value="<?php echo $productQuantity; ?>">
                            <input type="text" class="form-control text-center border border-secondary" id="productQuantity" name="productQuantity" placeholder="1" value="0" aria-describedby="button-addon1" readonly="readonly">
                            <button class="btn btn-white border border-secondary px-3" id="productPlus" type="button" id="button-addon2">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <button type="submit" id="addToCart" name="addToCart" class="products btn btn-primary shadow-0"><i class="me-1 fa fa-shopping-basket"></i> Add to cart</button>
                <?php echo "<br>".$errorMsg;?>    
                </form>
                <hr>
                <div>
                    <h3>About This Product</h3>
                    <p>
                        <?php echo $productDescription; ?>
                    </p>
                </div>
            </div>
        </main>
    </div>
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