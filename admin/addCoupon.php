<?php
$title = "add Theme";
require_once '../lib/siteConstant.php';
require_once '../lib/Connection.php';
require_once '../lib/header.php';
require_once '../lib/navbar_admin.php';


if (isset($_POST['submit']) && !isset($_GET['id'])) {

    $coupon = $_POST['coupon'];
    $discount = $_POST['discount'];

    if (isset($_POST['submit'])) {
        $conn = new Connection();
        $dataArr = array(
            "coupon" => $coupon,
            "discount" => $discount
        );

        $result = $conn->insert('coupons', $dataArr);
        $pop = "<script>
                    Swal.fire(
                        'Coupon Added Successfully!!',
                        '',
                        'success'
                      )
                      var delay = 2000;
                      setTimeout(function () {
                        window.location.href = 'coupon.php';
                      }, delay);
                      </script>";
        echo $pop;
    }
}
if (isset($_POST['submit']) && isset($_GET['id'])) {
    $coupon = $_POST['coupon'];
    $discount = $_POST['discount'];


    $conn = new Connection();
    $data = array(
        ":id" => array(
            "value" => $_GET['id'],
            "type" => 'INT'
        ),
    );
    $Result = $conn->select('coupons', '*', null, null, "id = :id", $data);
    $updateResult = $Result[0];


    $dataArr = array(
        "coupon" => $coupon,
        "discount" => $discount,
        'id' => $_GET['id']
    );

    $result = $conn->update('coupons', $dataArr, 'id = :id');
    $pop = "<script>
                      Swal.fire(
                          'Coupon Updated Successfully!!',
                          '',
                          'success'
                        )
                        var delay = 2000;
                        setTimeout(function () {
                          window.location.href = 'coupon.php';
                        }, delay);
                        </script>";
    echo $pop;
}

if (isset($_GET['id'])) {
    $conn = new Connection();
    $data = array(
        ":id" => array(
            "value" => $_GET['id'],
            "type" => 'INT'
        ),
    );
    $Result = $conn->select('coupons', '*', null, null, "id = :id", $data);
    $updateResult = $Result[0];
}
?>
<div class="container mt-3">
    <div class="col-12 d-flex justify-content-end mb-3">
        <a class="btn btn-outline-success" href="<?php echo SITE_URL; ?>eCommerce/admin/coupon.php"
            role="button">Back</a>
    </div>
    <div class="row justify-content-end">
        <div class="col-md-10">
            <div class="card custom-card">
                <div class="card-header custom-card-header bg-primary text-light text-center">
                    <h3 class="mb-0">Coupon</h3>
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <div class="d-flex gap-3">
                            <div class="form-group mb-3 col">
                                <label for="textInput">Coupon : </label>
                                <input type="text" class="form-control custom-form-control"
                                    value="<?php if ($_GET['id'])
                                        echo $updateResult['coupon']; ?>" id="textInput"
                                    name="coupon" placeholder="Enter Coupon" required />
                            </div>

                            <div class="form-group mb-3 col">
                                <label for="textInput">Discount : </label>
                                <div class="input-group mb-3">
                                <input type="number" value="<?php if ($_GET['id'])
                                        echo $updateResult['discount']; ?>" id="textInput"
                                        name="discount" placeholder="Enter Discount" class="form-control" aria-label="Amount (to the nearest dollar)">
                                <span class="input-group-text">%</span>
                            </div>
                                <!-- <input type="number" class="form-control custom-form-control"
                                    /> -->
                                    <!-- <input type="number"  value="<?php if ($_GET['id'])
                                        echo $updateResult['discount']; ?>" id="textInput"
                                    name="discount" placeholder="Enter Discount" required class="form-control" aria-label="Amount (to the nearest dollar)">
                                <span class="input-group-text">%</span> -->
                            </div>
                            <!-- <div class="input-group mb-3">
                                <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                <span class="input-group-text">%</span>
                            </div> -->
                        </div>
                        <div class="form-group">
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" name="reset" class="btn btn-warning">reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <main class="main_full">
    <div class="container">
        <div class="panel">
            <div class="button_outer">
                <div class="btn_upload">
                    <input type="file" id="upload_file" name="">
                    Upload Image
                </div>
                <div class="processing_bar"></div>
                <div class="success_box"></div>
            </div>
        </div>
        <div class="error_msg"></div>
        <div class="uploaded_file_view" id="uploaded_view">
            <span class="file_remove">X</span>
        </div>
    </div>
</main> -->

<style>
    .custom-card {
        border: none;
        border-radius: 15px;
    }

    .custom-card-header {
        border-radius: 15px 15px 0 0;
    }

    .custom-form-control {
        border-radius: 8px;
    }

    .image-preview {
        max-width: 100px;
        max-height: 100px;
        margin-bottom: 5px;
    }

    .form-control-color {
        min-width: -webkit-fill-available;
    }

    /* * {margin: 0; padding: 0; box-sizing: border-box;}
body {background: #f6f6f6; color: #444; font-family: 'Roboto', sans-serif; font-size: 16px; line-height: 1;}
.container {max-width: 1100px; padding: 0 20px; margin:0 auto;}
.panel {margin: 100px auto 40px; max-width: 500px; text-align: center;}
.button_outer {background: #83ccd3; border-radius:30px; text-align: center; height: 50px; width: 200px; display: inline-block; transition: .2s; position: relative; overflow: hidden;}
.btn_upload {padding: 17px 30px 12px; color: #fff; text-align: center; position: relative; display: inline-block; overflow: hidden; z-index: 3; white-space: nowrap;}
.btn_upload input {position: absolute; width: 100%; left: 0; top: 0; width: 100%; height: 105%; cursor: pointer; opacity: 0;}
.file_uploading {width: 100%; height: 10px; margin-top: 20px; background: #ccc;}
.file_uploading .btn_upload {display: none;}
.processing_bar {position: absolute; left: 0; top: 0; width: 0; height: 100%; border-radius: 30px; background:#83ccd3; transition: 3s;}
.file_uploading .processing_bar {width: 100%;}
.success_box {display: none; width: 50px; height: 50px; position: relative;}
.success_box:before {content: ''; display: block; width: 9px; height: 18px; border-bottom: 6px solid #fff; border-right: 6px solid #fff; -webkit-transform:rotate(45deg); -moz-transform:rotate(45deg); -ms-transform:rotate(45deg); transform:rotate(45deg); position: absolute; left: 17px; top: 10px;}
.file_uploaded .success_box {display: inline-block;}
.file_uploaded {margin-top: 0; width: 50px; background:#83ccd3; height: 50px;}
.uploaded_file_view {max-width: 300px; margin: 40px auto; text-align: center; position: relative; transition: .2s; opacity: 0; border: 2px solid #ddd; padding: 15px;}
.file_remove{width: 30px; height: 30px; border-radius: 50%; display: block; position: absolute; background: #aaa; line-height: 30px; color: #fff; font-size: 12px; cursor: pointer; right: -15px; top: -15px;}
.file_remove:hover {background: #222; transition: .2s;}
.uploaded_file_view img {max-width: 100%;}
.uploaded_file_view.show {opacity: 1;}
.error_msg {text-align: center; color: #f00} */
</style>

<?php
require_once '../lib/footer.php';
?>