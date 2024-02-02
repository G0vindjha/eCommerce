<?php
//print_r("Working Soon");die();
//session start
session_id("adminLoginSession");
session_start();
//check admin login
if(!isset($_SESSION['username'])){
header("Location:index.php");
exit;
}
require_once '../lib/Connection.php';
//delete category by ajax call
if ($_POST['action'] == 'categoryDel') {
    $quantity = $_POST['value']['quantity'];
    $category_id = $_POST['value']['id'];
    if($quantity <= 0){
        $data = array(
            ":category_id" => array(
                "value" => $category_id,
                "type" => 'INT'
            ),
        );
        $conn = new Connection();
        $result = $conn->delete('Categories', "category_id = :category_id", $data,"no");
        echo $result;
    }
    else{
        echo "failed";
    }
    
    exit;
}
//search category by ajax call
if ($_POST['action'] == 'searchData') {
    $search = $_POST['value'];
    $conn = new Connection();
    $result = $conn->select('Categories', ('Categories.category_id,Categories.name,Categories.description,SUM(quantity) as quantity '),'LEFT JOIN', array('Products' => array("category_id" => "category_id")),null, null, "category_id", 'category_id', 'ASC');
    $srno = 0;
    $new = array_filter($result, function ($value) use ($search, &$srno) {
        $output = '';
        if (strpos(strtolower($value['name']), strtolower($search)) !== FALSE) {
            $srno++;
            $action = "<div class='row d-flex flex-nowrap'>
        <div class='col'><a href='" . SITE_URL . "eCommerce/admin/addCategories.php?category_id="  . $value['category_id'] . "' type='button' id='udp"  . $value['category_id'] . "' class='udp btn btn-success upd'>UPDATE</a></div>
        <div class='col'><button type='button' id='del" . $value['category_id'] . "' class='categoryDel btn btn-danger'>DELETE</button></div>";

            $output .= "<tr>
                        <td class='text-center'>$srno.</td>
                        <td>" . $value['name'] . "</td>
                        <td>" . $value['description'] . "</td>
                        <td>" . $value['quantity'] . "</td>
                        <td>$action</td>
                    </tr>";
            $srno++;
        }
        echo $output;
    });
    exit;
}
// pagination limit
$results_per_page = 5;
//db connection
   $conn = new Connection();
   //fetch sll the data fort count
   $result1 = $conn->select("Categories", "*");
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
$result = $conn->select("Categories", ('Categories.category_id,Categories.name,Categories.description,SUM(quantity) as quantity'),'LEFT JOIN', array('Products' => array("category_id" => "category_id")), null, null, 'category_id', 'category_id', 'ASC', $results_per_page, $page_first_result);
$title = "Category List";
$breadcrump = '<div class="pagetitle mt-4">
<h1>Categories</h1>
<nav>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="'.SITE_URL.'eCommerce/admin/dashboard.php">Home</a></li>
    <li class="breadcrumb-item active">Category List</li>
  </ol>
</nav>
</div>';
require_once '../lib/siteConstant.php';
require_once '../lib/header.php';
require_once '../lib/navbar_admin.php';
if (count($result) == 0) {
    $output =  "<span class='display-6 text-danger'>Record Not Found!!</span>";
} else {
    //create table of category
    $output = '';
    $srno = 1;
    foreach ($result as $value) {
        
        if($value['quantity'] == null){
            $quantity = 0;
        }
        else{
            $quantity = $value['quantity'];
        }
        $action = "<div class='row d-flex flex-nowrap'>
        <div class='col'><a href='" . SITE_URL . "eCommerce/admin/addCategories.php?category_id="  . $value['category_id'] . "' type='button' id='udp"  . $value['category_id'] . "' class='udp btn btn-success upd'>UPDATE</a></div>
        <div class='col'><button type='button' id='del" . $value['category_id'] . "' data-quantity='" . $quantity . "' class='categoryDel btn btn-danger'>DELETE</button></div>";
       
        $output .= "<tr>
                        <td class='text-center'>$srno.</td>
                        <td>" . $value['name'] . "</td>
                        <td>" . $value['description'] . "</td>
                        <td>" . $quantity . "</td>
                        <td>$action</td>
                    </tr>";
        $srno++;
    }
    //Pagination conditions
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
    //Pagination starts
    $pagination = '<nav aria-label="Page navigation example" class="d-flex justify-content-center">
        <ul class="pagination">
          <li class="page-item"><a class="page-link" href="categories.php?page=' . $prevPage . '">Previous</a></li>'; 
    for ($page = 1; $page <= $number_of_page; $page++) {
        if($_GET['page'] == $page){
            $pagination .='
            <li class="page-item"><a class="page-link active" href = "categories.php?page=' . $page . '">' . $page . '</a></li>
            ';
        }
        else{
            $pagination .='
            <li class="page-item"><a class="page-link" href = "categories.php?page=' . $page . '">' . $page . '</a></li>
            ';
        }
         
    }
    $pagination .= '<li class="page-item"><a class="page-link" href="categories.php?page=' . $nextPage . '">Next</a></li>
    </ul>
  </nav>';
  //Pagination ends
}
?>
<div class="col-12 col-md-10">
    <div class="container-fluid">
        <main class='position-relative my-3'>
            <div class="row d-flex justify-content-between mb-3">
                <!-- search box -->
                <form class="d-flex col-4" role="search">
                    <input class="form-control me-2" type="search" id="searchValue" placeholder="Search" aria-label="Search">
                </form>
                <div class="col-4 d-flex justify-content-end">
                    <a class="btn btn-outline-success" href="<?php echo SITE_URL; ?>eCommerce/admin/addCategories.php" role="button">Add New Category</a>
                </div>
                <!-- Category table -->
              <div style="overflow-x:auto;">
              <table class="table table-striped table-bordered mt-3">
                    <thead>
                        <tr class="text-center">
                            <th>SR NO.</th>
                            <th>NAME</th>
                            <th>DESCRIPTION</th>
                            <th>QUANTITY</th>
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