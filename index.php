<?php

session_start(); // Start the session

$showModel = false; // Initialize $showModel to false

// Check if $_SESSION['start'] is set and equal to 'start'
if (isset($_SESSION['start']) && $_SESSION['start'] === 'start') {
    $showModel = true; // If true, set $showModel to true
} else {
    $_SESSION["start"] = "start"; // Set $_SESSION["start"] to 'start' if it's not already set
}
$title = "Proto";
require_once 'lib/siteConstant.php';
require_once 'lib/header_user.php';
require_once 'lib/navbar.php';

$data = array(
    ":status" => array(
        "value" => '1',
        "type" => 'ENUM'
    ),
);
$conn = new Connection();
$result = $conn->select("theme",'*','','','status = :status',$data);
$color1 = $result[0]['color1'];
$color2 = $result[0]['color2'];
$color3 = $result[0]['color3'];
$color4 = $result[0]['color4'];
$img1 = $result[0]['img1'];
$img2 = $result[0]['img2'];
$img3 = $result[0]['img3'];
$img4 = $result[0]['img4'];
$img5 = $result[0]['img5'];
$img6 = $result[0]['img6'];
$about = $result[0]['about'];
$addCrausel = false;
if($img1 != '' || $img2 != '' || $img3 != '' || $img4 != '' || $img5 != '' || $img6 != '' ){
    $addCrausel = true;
}
$imgPath = SITE_URL . 'eCommerce/assets/image/themeUpload/' . $result[0]['id']. '/';
?>
<!-- carousel -->
<?php if($addCrausel) { ?>
<divs id="carouselExampleInterval" class="carousel slide w-100 poisition-relative z-1" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php if($img1) {?>
        <div class="carousel-item active" data-bs-interval="20000">
            <img src="<?php echo $imgPath.$img1; ?>" class="d-block w-100" style="height:60vh" alt="...">
        </div>
        <?php }
        if($img2){ ?>
        <div class="carousel-item" data-bs-interval="2000">
            <img src="<?php echo $imgPath.$img2; ?>" class="d-block w-100" style="height:75vh" alt="...">
        </div>
        <?php }
        if($img3){ ?>
        <div class="carousel-item">
            <img src="<?php echo $imgPath.$img3; ?>" class="d-block w-100" style="height:75vh" alt="...">
        </div>
        <?php }
        if($img4){ ?>
        <div class="carousel-item">
            <img src="<?php echo $imgPath.$img4; ?>" class="d-block w-100" style="height:75vh" alt="...">
        </div>
        <?php }
        if($img5){ ?>
        <div class="carousel-item">
            <img src="<?php echo $imgPath.$img5; ?>" class="d-block w-100" style="height:75vh" alt="...">
        </div>
        <?php }
        if($img6){ ?>
        <div class="carousel-item">
            <img src="<?php echo $imgPath.$img6; ?>" class="d-block w-100" style="height:75vh" alt="...">
        </div>
        <?php }?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</divs>
<?php } else {?>
    <div class="col-12">
        <img src="<?php echo  SITE_URL . 'eCommerce/assets/image/welcome.png'?>" style="width: -webkit-fill-available;" alt="">
    </div>
<?php }?>

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
                <a name=""  class="btn btn1 btn btn1-primary products" href="'.SITE_URL.'eCommerce/productInfo.php?product_id='. base64_encode($value["product_id"]) . '" role="button">View Product</a>
            </div>
        </div>';
        }
        ?>
    </div>
</div>
<?php  
if($showModel == ''){
?>
    <!-- Modal -->
    <div id="myModal11" class="modal11">
        <div class="modal11-content mb-3">
            <!-- PHP code to dynamically load images -->
            <div class="image11-container mb-3">
                <img class="class1 col" src="giphy.gif" alt="Image">
                <div class="modalContainer col mx-auto footerTheme p-5 rounded-x mb-3">
                    <!-- <img class="modalImage" src="pngwing.com.png" alt="Your Image"> -->
                    <div class="text-center"><?php echo $about;?></div>
                </div>
                <img class="class2 col" src="giphy.gif" alt="Image">
            </div>
        </div>
    </div>
<?php
 }
?>

    <!-- JavaScript to control modal -->
    <script>
        // Get the modal
        var modal = document.getElementById("myModal11");

        // Display the modal when the page loads
        window.onload = function () {
            modal.style.display = "block";
        };

        // Close the modal when clicked outside of it
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };
        $("#modalBtn").click(function (e) { 
            console.log('hello');
            
        });
    </script>
<style>
        /* CSS for modal */
        .modal11 {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
        }

        .modal11-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            overflow: hidden;
            /* Hide overflowing images */
            width: 90%;
            /* height: 100%; */
            /* height: -webkit-fill-available; */
        }
        .rounded-x{
            border-radius: 90px !important;
        }

        .image11-container img {
            /* width: calc(100% / 3); */
            position: absolute;
            top: 0;
            transition: all 0.3s ease;
        }

        .class1 {
            left: 0;
            height: -webkit-fill-available;
        }

        .class2 {
            right: 0;
            -webkit-transform: scaleX(-1);
            transform: scaleX(-1);
            height: -webkit-fill-available;
        }
        .modalContainer {
            position: relative;
            width: 400px; /* Adjust the width and height according to your image */
            height: 300px;
        }
        .modalImage {
            height: 60%;
            width: fit-content;
        }
        .modalText {
            position: absolute;
            top: 17%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 24px;
            width: max-content;
            text-align: center;
            font-family: Arial, sans-serif;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5); /* Optional: Add a text shadow for better readability */
        }
    </style>
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