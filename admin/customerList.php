<?php
//print_r("Working Soon");die();
//session started
session_id("adminLoginSession");
session_start();
//Check Admin login
if(!isset($_SESSION['username'])){
header("Location:index.php");
exit;
}
require_once '../lib/Connection.php';
//delete customer data by ajax call
if ($_POST['action'] == 'deletedata') {
    $customer_id = $_POST['value'];
    echo $customer_id;
    $conn = new Connection();
    $data = array(
        ":customer_id" => array(
            "value" => $customer_id,
            "type" => 'INT'
        ),
    );
    $conn->delete('Customers', "customer_id = :customer_id", $data);
    exit;
}
//Search customer data by ajax call
if ($_POST['action'] == 'searchData') {
    $search = $_POST['value'];
    $conn = new Connection();
    $result = $conn->select('Customers', ('customer_id,name,gender,email,address,`phone_number`,image'), null, null, null, null, null, 'customer_id', 'ASC');
    $srno = 0;
    $new = array_filter($result, function ($value) use ($search, &$srno) {
        $output = '';
        if (strpos(strtolower($value['name']), strtolower($search)) !== FALSE || strpos(strtolower($value['email']), strtolower($search)) !== FALSE) {
            $srno++;
            $imgpath = SITE_URL . 'eCommerce/assets/image/customerUpload/' . $value['customer_id'] . '/' . $value['image'];

            $action = "<div class='row d-flex flex-nowrap'>
        <div class='col'><a href='" . SITE_URL . "eCommerce/admin/addCustomer.php?customer_id="  . $value['customer_id'] . "' type='button' id='udp"  . $value['customer_id'] . "' class='udp btn btn-success upd'>UPDATE</a></div>
        <div class='col'><button type='button' id='del" . $value['customer_id'] . "' class='del btn btn-danger del'>DELETE</button></div>";

            $output .= "<tr>
                        <td class='text-center'>$srno.</td>
                        <td class='text-center'><img src='$imgpath' class='card-img-top w-25 ' alt='...'></td>
                        <td>" . $value['name'] . "</td>
                        <td>" . $value['gender'] . "</td>
                        <td>" . $value['email'] . "</td>
                        <td>" . $value['phone_number'] . "</td>
                        <td>" . $value['address'] . "</td>
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
   $result1 = $conn->select("Customers", "*");
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
  $result = $conn->select("Customers", ('customer_id,name,gender,email,address,`phone_number`,image'),null,null, null, null, null, "customer_Id", "ASC", $results_per_page, $page_first_result);
$title = "Customer List";
$breadcrump = '<div class="pagetitle mt-4">
<h1>Customers</h1>
<nav>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="'.SITE_URL.'eCommerce/admin/dashboard.php">Home</a></li>
    <li class="breadcrumb-item active">Customer List</li>
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
        //create dynamic table with db data
        $imgpath = SITE_URL . 'eCommerce/assets/image/customerUpload/' . $value['customer_id'] . '/' . $value['image'];
        $action = "<div class='row d-flex flex-nowrap'>
        <div class='col'><a href='" . SITE_URL . "eCommerce/admin/addCustomer.php?customer_id="  . $value['customer_id'] . "' type='button' id='udp"  . $value['customer_id'] . "' class='udp btn btn-success upd'>UPDATE</a></div>
        <div class='col'><button type='button' id='del" . $value['customer_id'] . "' class='del btn btn-danger del'>DELETE</button></div>";

        $output .= "<tr>
                        <td class='text-center'>$srno.</td>
                        <td class='text-center'><img src='$imgpath' class='card-img-top w-25' alt='...'></td>
                        <td>" . $value['name'] . "</td>
                        <td>" . $value['gender'] . "</td>
                        <td>" . $value['email'] . "</td>
                        <td>" . $value['phone_number'] . "</td>
                        <td>" . $value['address'] . "</td>
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
          <li class="page-item"><a class="page-link" href="customerList.php?page=' . $prevPage . '">Previous</a></li>'; 
    for ($page = 1; $page <= $number_of_page; $page++) {
        if($_GET['page'] == $page){
            $pagination .='
            <li class="page-item"><a class="page-link active" href = "customerList.php?page=' . $page . '">' . $page . '</a></li>
            ';
        }
        else{
            $pagination .='
            <li class="page-item"><a class="page-link" href = "customerList.php?page=' . $page . '">' . $page . '</a></li>
            ';
        }
         
    }
    $pagination .= '<li class="page-item"><a class="page-link" href="customerList.php?page=' . $nextPage . '">Next</a></li>
    </ul>
  </nav>';
  //pagination ends
}
?>
<div class="col-12 col-md-10 ">
    <div class="container-fluid">
        <main class='position-relative my-3'>
            <div class="row d-flex justify-content-between mb-3">
                <!-- search box -->
                <form class="d-flex col-lg-4 col-6" role="search">
                    <input class="form-control me-2" type="search" id="searchValue" placeholder="Search" aria-label="Search">
                </form>
                <div class="col-lg-4 col-6 d-flex justify-content-end">
                    <a class="btn btn-outline-success" href="<?php echo SITE_URL; ?>eCommerce/admin/addCustomer.php" role="button">Add Customer</a>
                </div>
                <!-- customer list tabel -->
                <div class="col-sm-12" style="overflow-x:auto;">
                <table class="col-sm-12 table table-striped table-bordered mt-3">
                    <thead>
                        <tr class="text-center">
                            <th>SR NO.</th>
                            <th>PROFILE PHOTO</th>
                            <th>NAME</th>
                            <th>GENDER</th>
                            <th>EMAIL</th>
                            <th>PHONE NUMBER</th>
                            <th>ADDRESS</th>
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