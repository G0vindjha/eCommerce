<?php
$title = "Proto";
require_once 'lib/siteConstant.php';
require_once 'lib/header_user.php';
require_once 'lib/navbar.php';
?>
<!-- carousel -->
<div id="carouselExampleInterval" class="carousel slide w-100 poisition-relative z-1" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="10000">
            <img src="https://images.pexels.com/photos/5650042/pexels-photo-5650042.jpeg?auto=compress&cs=tinysrgb&w=1600" class="d-block w-100" style="height:60vh" alt="...">
        </div>
        <div class="carousel-item" data-bs-interval="2000">
            <img src="https://images.pexels.com/photos/4011762/pexels-photo-4011762.jpeg?auto=compress&cs=tinysrgb&w=1600" class="d-block w-100" style="height:75vh" alt="...">
        </div>
        <div class="carousel-item">
            <img src="https://images.pexels.com/photos/4132534/pexels-photo-4132534.jpeg?auto=compress&cs=tinysrgb&w=1600" class="d-block w-100" style="height:75vh" alt="...">
        </div>
        <div class="carousel-item">
            <img src="https://images.pexels.com/photos/5632397/pexels-photo-5632397.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="d-block w-100" style="height:75vh" alt="...">
        </div>
        <div class="carousel-item">
            <img src="https://images.pexels.com/photos/440320/pexels-photo-440320.jpeg?auto=compress&cs=tinysrgb&w=1600" class="d-block w-100" style="height:75vh" alt="...">
        </div>
        
        <div class="carousel-item">
            <img src="https://images.pexels.com/photos/815494/pexels-photo-815494.jpeg?auto=compress&cs=tinysrgb&w=1600" class="d-block w-100" style="height:75vh" alt="...">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<!-- Dynamic Heading -->
<div class="container my-5">
    <header class="mb-4" id="catProduct">
        <?php echo $outputheader;?>
    </header>
    <!-- products -->
    <div class="row" id="productList">
        <?php echo $output; ?>
    </div>
    <header class="mb-4">
        <h3 class="text-center">::: New products :::</h3>
    </header>
    <div class="row" id="productList">
        <?php
        $conn = new Connection();
        $result = $conn->select("Products");
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
                <a name="" id="" class="btn btn1 btn btn1-primary" href="'.SITE_URL.'eCommerce/productInfo.php?product_id='. base64_encode($value["product_id"]) . '" role="button">View Product</a>
            </div>
        </div>';
        }
        ?>
    </div>
</div>

<?php
echo $script;
require_once 'lib/footer.php';
?>