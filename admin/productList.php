<?php
//print_r("Working Soon");die();
//session start
session_id("adminLoginSession");
session_start();
//admin login check
if (!isset($_SESSION['username'])) {
    header("Location:index.php");
    exit;
}
require_once '../lib/Connection.php';
//delete product by ajax call
if ($_POST['action'] == 'productDelete') {
    $product_id = $_POST['value'];
    $conn = new Connection();
    $data = array(
        ":product_id" => array(
            "value" => $product_id,
            "type" => 'INT'
        ),
    );
    $conn->delete('Products', "product_id = :product_id", $data);
    exit;
}
//search product by ajax call
if ($_POST['action'] == 'searchData') {
    $search = $_POST['value'];
    $conn = new Connection();
    $result = $conn->select('Products', ('product_id,Products.name,summary,Products.description,price,`quantity`,image,Categories.name as CategoryName'), 'LEFT JOIN', array('Categories' => array("category_id" => "category_id")), null, null, null, 'product_Id', 'ASC');
    $srno = 0;
    $new = array_filter($result, function ($value) use ($search, &$srno) {
        $output = '';
        if (strpos(strtolower($value['name']), strtolower($search)) !== FALSE || strpos(strtolower($value['CategoryName']), strtolower($search)) !== FALSE) {
            $srno++;
            $imgpath = SITE_URL . 'eCommerce/assets/image/productUpload/' . $value['product_id'] . '/' . $value['image'];
            $action = "<div class='row d-flex flex-nowrap'>
        <div class='col'><a href='" . SITE_URL . "eCommerce/admin/addProduct.php?product_id="  . $value['product_id'] . "' type='button' id='udp"  . $value['product_id'] . "' class='udp btn btn-success upd'>UPDATE</a></div>
        <div class='col'><button type='button' id='del" . $value['product_id'] . "' class='productDel btn btn-danger'>DELETE</button></div>";

            $output .= "<tr>
                        <td class='text-center'>$srno.</td>
                        <td class='text-center'><img src='$imgpath' class='card-img-top w-100' alt='...'></td>
                        <td>" . $value['name'] . "</td>
                        <td>" . $value['summary'] . "</td>
                        <td>" . $value['price'] . "</td>
                        <td>" . $value['quantity'] . "</td>
                        <td>" . $value['CategoryName'] . "</td>
                        <td>" . $value['description'] . "</td>
                        <td>$action</td>
                    </tr>";
        }
        echo $output;
    });
    exit;
}
//pagination limit
   $results_per_page = 5;
   //db connection
   $conn = new Connection();
   //fetch all the data for count
   $result1 = $conn->select("Products", "*");
   $number_of_result = count($result1);
   $number_of_page = ceil($number_of_result / $results_per_page);
   
  //determine which page number visitor is currently on  
  if (!isset($_GET['page']) || $_GET['page'] <= 0) {
      $page = 1;
  } else {
      $page = $_GET['page'];
  }
  $page_first_result = ($page - 1) * $results_per_page;
  //fetch all the data
$result = $conn->select("Products", ('product_id,Products.name,summary,Products.description,price,`quantity`,image,Categories.name as CategoryName'), 'LEFT JOIN', array('Categories' => array("category_id" => "category_id")), null, null, null, "product_Id", "ASC", $results_per_page, $page_first_result);
$title = "Product List";
$breadcrump = '<div class="pagetitle mt-4">
<h1>Products</h1>
<nav>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="'.SITE_URL.'eCommerce/admin/dashboard.php">Home</a></li>
    <li class="breadcrumb-item active">Product List</li>
  </ol>
</nav>
</div>';
require_once '../lib/siteConstant.php';
require_once '../lib/header.php';
require_once '../lib/navbar_admin.php';
if (count($result) == 0) {
    $output =  "<span class='display-6 text-danger'>Record Not Found!!</span>";
} else {
  
   
    $output = '';
    $srno = 1;
    foreach ($result as $value) {
        //dynamic table for product
        $imgpath = SITE_URL . 'eCommerce/assets/image/productUpload/' . $value['product_id'] . '/' . $value['image'];
        $action = "<div class='row d-flex flex-nowrap'>
        <div class='col'><a href='" . SITE_URL . "eCommerce/admin/addProduct.php?product_id="  . $value['product_id'] . "' type='button' id='udp"  . $value['product_id'] . "' class='udp btn btn-success upd'>UPDATE</a></div>
        <div class='col'><button type='button' id='del" . $value['product_id'] . "' class='productDel btn btn-danger'>DELETE</button></div>";

        $output .= "<tr>
                        <td class='text-center'>$srno.</td>
                        <td class='text-center'><img src='$imgpath' class='card-img-top w-100' alt='...'></td>
                        <td>" . $value['name'] . "</td>
                        <td>" . $value['summary'] . "</td>
                        <td>" . $value['price'] . "</td>
                        <td>" . $value['quantity'] . "</td>
                        <td>" . $value['CategoryName'] . "</td>
                        <td>" . $value['description'] . "</td>
                        <td>$action</td>
                    </tr>";
        $srno++;
    }
    //pagination condition
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
          <li class="page-item"><a class="page-link" href="productList.php?page=' . $prevPage . '">Previous</a></li>'; 
    for ($page = 1; $page <= $number_of_page; $page++) {
        if($_GET['page'] == $page){
            $pagination .='
            <li class="page-item"><a class="page-link active" href = "productList.php?page=' . $page . '">' . $page . '</a></li>
            ';
        }
        else{
            $pagination .='
            <li class="page-item"><a class="page-link" href = "productList.php?page=' . $page . '">' . $page . '</a></li>
            ';
        }
         
    }
    $pagination .= '<li class="page-item"><a class="page-link" href="productList.php?page=' . $nextPage . '">Next</a></li>
    </ul>
  </nav>';
}
//pagination ends
?>
<div class="col-12 col-md-10">

    <main class='position-relative my-3'>
        <div class="row d-flex justify-content-between mb-3">
            <form class="d-flex col-lg-4 col-6" role="search">
                <!-- search Box -->
                <input class="form-control me-2" type="search" id="searchValue" placeholder="Search" aria-label="Search">
            </form>
            <div class="col-lg-4 col-6 d-flex justify-content-end">
                <a class="btn btn-outline-success" href="<?php echo SITE_URL; ?>eCommerce/admin/addProduct.php" role="button">Add Products</a>
            </div>
            <!-- Product tabel -->
            <div style="overflow-x:auto;">
                <table class="table table-striped table-bordered mt-3">
                    <thead>
                        <tr class="text-center">
                            <th>SR NO.</th>
                            <th>PRODUCT IMAGE</th>
                            <th>NAME</th>
                            <th>SUMMARY</th>
                            <th>PRICE</th>
                            <th>QUANTITY</th>
                            <th>CAREGORY</th>
                            <th>DESCRIPTION</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php echo $output; ?>
                    </tbody>
                </table>
            </div>
    </main>
    <!-- Pagination -->
    <?php echo $pagination;?>
</div>
</div>
<?php

require_once '../lib/footer.php';
?>