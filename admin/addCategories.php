<?php
//session start
session_id("adminLoginSession");
session_start();
//Check whether the admin is login or not if login then able to view this page
if(!isset($_SESSION['username'])){
header("Location:index.php");
exit;
}
require_once '../lib/Connection.php';
//Check if category is set if yes then able to fetch data from db for prefilled form 
if (isset($_GET['category_id'])) {
    $operation = "Data Modification";
    $title = "Update Category information";
    $buttonName = "Update Category information";
    $conn = new Connection();
    $data = array(
        ":category_id" => array(
            "value" => $_GET['category_id'],
            "type" => 'INT'
        ),
    );
    $Result = $conn->select('Categories', ('category_id,name,description'), null, null, "category_id = :category_id", $data);
    $updateResult = $Result[0];
} else {
    $title = "Add Category";
    $buttonName = "Add Category";
    $operation = "Registration";
}

//Check if category is set if yes then able to update
if (isset($_POST['categorySubmit']) && isset($_GET['category_id'])) {
    $name = $_POST['categoryName'];
    $description = $_POST['categoryDescription'];
    $dataArr = array(
        "name" => $name,
        "description" => $description,
        "category_id" => $_GET['category_id']
    );
    $conn = new Connection();
    $result = $conn->update("Categories", $dataArr, 'category_id = :category_id');
    if ($result == true) {
        $pop = "<script>
                        Swal.fire(
                            'Category Upadated Successfully!!',
                            '',
                            'success'
                          )
                          var delay = 2000;
                          setTimeout(function () {
                            window.location.href = 'categories.php';
                          }, delay);
                          </script>";
    } else {

        $pop = "<script>
                        Swal.fire(
                            'failed to Update!!',
                            '',
                            'error'
                          )
                          var delay = 2000;
                          setTimeout(function () {
                            window.location.href = 'addCategories.php';
                          }, delay);
                          </script>";
    }
}
//Insert new category
if (isset($_POST['categorySubmit']) && !isset($_GET['category_id'])) {
    $name = $_POST['categoryName'];
    $description = $_POST['categoryDescription'];
    $dataArr = array(
        "name" => $name,
        "description" => $description
    );
    $conn = new Connection();
    $result = $conn->insert("Categories", $dataArr);
    if ($result == "error") {
        $pop = "<script>
                        Swal.fire(
                            'failed!!',
                            '',
                            'error'
                          )
                          var delay = 2000;
                          setTimeout(function () {
                            window.location.href = 'addCategories.php';
                          }, delay);
                          </script>";
    } else {
        $pop = "<script>
                        Swal.fire(
                            'New Category added Successfully!!',
                            '',
                            'success'
                          )
                          var delay = 2000;
                          setTimeout(function () {
                            window.location.href = 'categories.php';
                          }, delay);
                          </script>";
    }
}
$breadcrump = '<div class="pagetitle mt-4">
<h1>Categories</h1>
<nav>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="'.SITE_URL.'eCommerce/admin/dashboard.php">Home</a></li>
    <li class="breadcrumb-item active">Add Category</li>
  </ol>
</nav>
</div>';
require_once '../lib/siteConstant.php';
require_once '../lib/header.php';
require_once '../lib/navbar_admin.php';
//give popup message
echo $pop;
?>
<div class="col-12 col-md-10 mb-3">
    <div class="container-fluid mt-3 border border-primary border-3 p-3 rounded">
        <div class="d-flex justify-content-center mb-3"><span class="fs-2 text-primary">Category<?php echo $operation; ?></span></div>
        <form class="row g-3 needs-validation" id="validater" novalidate method="post">
            <div class="row justify-content-center align-items-center g-2">
                <div class="col">
                    <label for="categoryName" class="form-label">Category Name : </label>
                    <input type="text" class="form-control" id="categoryName" name="categoryName" placeholder="Enter Category Name..." value="<?php echo $updateResult['name'] ?>" required>
                    <small id="validName" class="text-danger"></small>
                </div>
            </div>

            <div class="mb-3">
                <label for="categoryDescription" class="form-label">Category description : </label>
                <textarea class="form-control" id="categoryDescription" placeholder="Enter description..." name="categoryDescription" required><?php echo $updateResult['description'] ?></textarea>
                <small id="validDescription" class="text-danger"></small>
            </div>
            <div class="d-flex gap-2 col-12">
                <button class="btn-validation btn btn-success p-2 col-5 mx-auto" id='categorySubmit' type="submit" name="categorySubmit"><?php echo $buttonName;?></button>
                <button class="btn btn-danger p-2 col-5 mx-auto" type="reset">Reset</button>
                <?php echo "<br>" . $valid; ?>
            </div>
        </form>
    </div>
</div>
<?php
require_once '../lib/footer.php';
?>