<?php
//session start
session_id("adminLoginSession");
session_start();
//Check whether the admin is login or not if login then able to view this page
if (!isset($_SESSION['username'])) {
    header("Location:index.php");
    exit;
}
require_once '../lib/Connection.php';
require_once '../lib/siteConstant.php';
//Check if product_id is set if yes then able to fetch data from db for prefilled form 
if (isset($_GET['product_id'])) {
    $operation = "Product Data Modification";
    $title = "Update Product data";
    $buttonName = "Update Product";
    $conn = new Connection();
    $data = array(
        ":product_id" => array(
            "value" => $_GET['product_id'],
            "type" => 'INT'
        ),
    );
    $result = $conn->select('Products', ('product_id,Products.name,summary,Products.category_id,Products.description,price,`quantity`,image,Categories.name as CategoryName'), 'LEFT JOIN', array('Categories' => array("category_id" => "category_id")),"product_id = :product_id", $data);
    $updateResult = $result[0];
    $imgpath = SITE_URL . 'eCommerce/assets/image/productUpload/' . $_GET['product_id'] . '/' . $result[0]['image'];
    $imgfield = "<img src='$imgpath' class='img-fluid rounded-start w-50' id='productpreimage'  alt='...' width='130px'>";
} else {
    $title = "Add Product";
    $operation = "Add New Product";
    $buttonName = "Add Product";
}
//Check if product_id is set if yes then able to update
if (isset($_POST['productSubmit']) && isset($_GET['product_id'])) {
    $data = array(
        ":product_id" => array(
            "value" => $_GET['product_id'],
            "type" => 'INT'
        ),
    );
    $name = $_POST['productName'];
    $summary = $_POST['productSummary'];
    $price = $_POST['productPrice'];
    $description = $_POST['productDiscription'];
    $category_id = $_POST['category'];
    $quantity = $_POST['Productquentity'];
    $pp = $_POST['imageFilled'];
    if ($name == null || $summary == null || $price == null || $description == null || $category_id == null || $quantity == null ||  is_numeric($price) == false ||  is_numeric($quantity) == false) {
        $validate = "<div><small class='text-danger'>Enter data Properly !!</small></div>";
    } else {
        if ($_FILES['productImage']['size'] > 0) {
            $fileName = $_FILES['productImage']['name'];
            $fileSize = $_FILES['productImage']['size'];
            $tempName = $_FILES['productImage']['tmp_name'];
            $fileType = $_FILES['productImage']['type'];
            $fileExtension = end(explode('/', $fileType));
            $newFileName = time() . $fileName;
            $productImage = $newFileName;
            $upload = "productUpload/$newFileName";
            if ($fileExtension == "jpeg" || $fileExtension == "png"|| $fileExtension == "webp") {
                if ($fileSize >= 0 && $fileSize <= 5000000) {
                    $dataArr = array(
                        "image" => $productImage,
                        "name" => $name,
                        "summary" => $summary,
                        "price" =>  $price,
                        "description" => $description,
                        "category_id" => $category_id,
                        "quantity" => $quantity,
                        "product_id"=> $_GET['product_id']
                    );
                    $conn = new Connection();
                    $result = $conn->update('Products', $dataArr, 'product_id = :product_id', $data);
                    if ($result == true) {
                        $uploadDirectory = 'C:/xampp/htdocs/eCommerce/assets/image/productUpload/' . $_GET['product_id'] . '/';
                        if (file_exists($uploadDirectory)) {
                            $previousImagePath = $uploadDirectory . $pp;
                            unlink($previousImagePath);
                        }
                        $imagePath = $uploadDirectory . $productImage;
                        move_uploaded_file($_FILES['productImage']['tmp_name'], $imagePath);
                        $pop = "<script>
                        Swal.fire(
                            'Product Details Changed Successfully!!',
                            '',
                            'success'
                          )
                          var delay = 2000;
                          setTimeout(function () {
                            window.location.href = 'productList.php';
                          }, delay);
                          </script>";
                    } else {
                        echo " File Not uploaded!!";
                    }
                } else {
                    $pop = "<script>
                        Swal.fire(
                            'Image File is Larger Then 1 MB!!',
                            '',
                            'error'
                          )
                          var delay = 2000;
                          setTimeout(function () {
                            window.location.href = 'addProduct.php';
                          }, delay);
                          </script>";
                }
            } else {
                $pop = "<script>
                Swal.fire(
                    'Image formate must be in png or jpeg!!',
                    '',
                    'error'
                  )
                  var delay = 2000;
                  setTimeout(function () {
                    window.location.href = 'addProduct.php';
                  }, delay);
                  </script>";
            }
        } else {
            $dataArr = array(
                "name" => $name,
                "summary" => $summary,
                "price" =>  $price,
                "description" => $description,
                "category_id" => $category_id,
                "quantity" => $quantity,
                "product_id"=> $_GET['product_id']
            );
            $conn = new Connection();
            $result = $conn->update('Products', $dataArr, 'product_id = :product_id');
            $pop = "<script>
                        Swal.fire(
                            'Product Details Changed Successfully!!',
                            '',
                            'success'
                          )
                          var delay = 2000;
                          setTimeout(function () {
                            window.location.href = 'productList.php';
                          }, delay);
                          </script>";
        }
    }
}
//Insert Product
if (isset($_POST['productSubmit']) && !isset($_GET['product_id'])) {
    $name = $_POST['productName'];
    $summary = $_POST['productSummary'];
    $price = $_POST['productPrice'];
    $description = $_POST['productDiscription'];
    $category_id = $_POST['category'];
    $quantity = $_POST['Productquentity'];
    if ($name == null || $summary == null || $price == null || $description == null || $category_id == null || $quantity == null ||  is_numeric($price) == false ||  is_numeric($quantity) == false) {
        $validate = "<div><small class='text-danger'>Enter data Properly !!</small></div>";
    } else {
        if (isset($_FILES['productImage'])) {
            $fileName = $_FILES['productImage']['name'];
            $fileSize = $_FILES['productImage']['size'];
            $tempName = $_FILES['productImage']['tmp_name'];
            $fileType = $_FILES['productImage']['type'];
            $fileExtension = end(explode('/', $fileType));
            $newFileName = time() . $fileName;
            $productImage = $newFileName;
            $upload = "productUpload/$newFileName";
            if ($fileExtension == "jpeg" || $fileExtension == "png"|| $fileExtension == "webp") {
                if ($fileSize >= 0 && $fileSize <= 5000000) {
                    $dataArr = array(
                        "image" => $productImage,
                        "name" => $name,
                        "summary" => $summary,
                        "price" =>  $price,
                        "description" => $description,
                        "category_id" => $category_id,
                        "quantity" => $quantity,
                    );
                    $conn = new Connection();
                    $result = $conn->insert('Products', $dataArr);

                    if ($result == 'error') {
                        echo " File Not uploaded!!";
                    } else {
                        $uploadDirectory = 'C:/xampp/htdocs/eCommerce/assets/image/productUpload/' . $result . '/';
                        if (!file_exists($uploadDirectory)) {
                            mkdir($uploadDirectory, 0777, true);
                        }
                        $imagePath = $uploadDirectory . $productImage;
                        move_uploaded_file($_FILES['productImage']['tmp_name'], $imagePath);
                        $pop = "<script>
                        Swal.fire(
                            'Product Added Successfully!!',
                            '',
                            'success'
                          )
                          var delay = 2000;
                          setTimeout(function () {
                            window.location.href = 'productList.php';
                          }, delay);
                          </script>";
                    }
                } else {
                    $pop = "<script>
                        Swal.fire(
                            'Image File is Larger Then 1 MB!!',
                            '',
                            'error'
                          )
                          var delay = 2000;
                          setTimeout(function () {
                            window.location.href = 'addProduct.php';
                          }, delay);
                          </script>";
                }
            } else {
                $pop = "<script>
                Swal.fire(
                    'Image formate must be in png or jpeg!!',
                    '',
                    'error'
                  )
                  var delay = 2000;
                  setTimeout(function () {
                    window.location.href = 'addProduct.php';
                  }, delay);
                  </script>";
            }
        }
    }
}
$breadcrump = '<div class="pagetitle mt-4">
<h1>Products</h1>
<nav>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="'.SITE_URL.'eCommerce/admin/dashboard.php">Home</a></li>
    <li class="breadcrumb-item active">Add Product</li>
  </ol>
</nav>
</div>';
require_once '../lib/header.php';
require_once '../lib/navbar_admin.php';
echo $pop;
?>
<div class="col-12 col-md-10 mb-3 mt-3">
    <!-- product form -->
    <div class="container-fluid mt-3 border border-primary border-3 p-3 rounded">
        <form class="row g-3 needs-validation" id="validater" novalidate method="post" enctype="multipart/form-data">
            <div class="d-flex justify-content-center mb-3"><span class="fs-2 text-primary"><?php echo $operation; ?></span></div>
            <div class="card mb-3 p-3">
                <div class="row g-0">
                    <div class="col-md-4">
                        <div class="d-flex justify-content-center mb-3">
                            <!-- prefilled product image -->
                            <?php
                            if (isset($_GET['product_id'])) {
                                echo $imgfield;
                            } else {
                                echo ' <img src="' . SITE_URL . 'eCommerce/assets/image/gift.png" id="productpreimage" alt="..." class="img-fluid rounded-start w-50" alt="...">';
                            }
                            ?>
                        </div>

                        <div class="col">
                            <label for="productImage" class="form-label">Upload Profile Photo : </label>
                            <?php
                            $required = "required";
                            if (isset($_GET['product_id'])) {
                                $required = "";
                            }
                            ?>
                            <input type="file" class="form-control" aria-label="file example" id="productImage" name="productImage" <?php echo $required; ?>>
                            <input type="hidden" class="form-control" aria-label="file example" id="imageFilled" name="imageFilled" value="<?php echo $updateResult['image'] ?>">
                            <div class="invalid-feedback">Upload Profile photo...</div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <div class="col">
                                <label for="productName" class="form-label">Product Name : </label>
                                <input type="text" class="form-control" id="productName" name="productName" placeholder="Enter Product Name..." value="<?php echo $updateResult['name'] ?>" required>
                                <div id="validname" class="invalid-feedback">Enter Name...</div>
                            </div>
                            <div class="col">
                                <label for="productSummary" class="form-label">Summary : </label>
                                <input type="text" class="form-control" id="productSummary" name="productSummary" placeholder="Enter Product Summary..." value="<?php echo $updateResult['summary'] ?>" required>
                                <div id="validSummary" class="invalid-feedback">Enter Summary...</div>
                            </div>
                            <div class="col m-auto p-auto">
                                <label for="productPrice" class="form-label">Price : </label>
                                <input type="number" class="form-control" id="productPrice" name="productPrice" placeholder="Enter product Price..." value="<?php echo $updateResult['price'] ?>" required>
                                <div class="invalid-feedback">Enter Price...</div>
                                <div id='validproductPrice'></div>
                            </div>
                            <div class="mb-3">
                                <label for="productDiscription" class="form-label">Discription : </label>
                                <textarea class="form-control" id="productDiscription" placeholder="Enter Product Discription..." name="productDiscription" required><?php echo $updateResult['description'] ?></textarea>
                                <div id="validproductDiscription" class="invalid-feedback">
                                    Enter Product Discription...
                                </div>
                            </div>
                            <div class="col">
                                <label for="category" class="form-label">Category : </label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="" selected disabled>-select-</option>
                                    <!-- fetch category and append to the dropdown -->
                                    <?php
                                    $conn = new Connection();
                                    $result1 = $conn->select("Categories", "*");
                                    foreach ($result1 as $key => $value) {
                                        if (isset($_GET['product_id']) && $updateResult['category_id'] == $value['category_id']) {
                                            echo "<option value='" . $value['category_id'] . "' selected>" . $value['name'] . "</option>";
                                        } else {
                                            echo "<option value='" . $value['category_id'] . "'>" . $value['name'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a valid category.
                                </div>
                            </div>
                            <div class="col m-auto p-auto">
                                <label for="Productquentity" class="form-label">Quentity: </label>
                                <input type="number" class="form-control" id="Productquentity" name="Productquentity" placeholder="Enter Quentity..." value="<?php echo $updateResult['quantity'] ?>" required>
                                <div class="invalid-feedback">Enter Quentity...</div>
                                <div id='validProductquentity'></div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2 col-12">
                        <button class="btn-validation btn btn-success p-2 col-5 mx-auto" id='productSubmit' type="submit" name="productSubmit"><?php echo $buttonName;?></button>
                        <button class="btn btn-danger p-2 col-5 mx-auto" type="reset">Reset</button>
                        <?php echo "<br>" . $validate; ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
<?php
require_once '../lib/footer.php';
?>