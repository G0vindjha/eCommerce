<?php
require 'assets/thirdparty/PHPmailer/src/Exception.php';
require 'assets/thirdparty/PHPmailer/src/PHPMailer.php';
require 'assets/thirdparty/PHPmailer/src/SMTP.php';
//session starts
session_id("customerLoginSession");
session_start();
//Customer Login check
if (!isset($_SESSION['customer_id'])) {
    header("Location:index.php");
}
require_once './lib/Connection.php';
$shipOption = 1;
//Remove Product from cart by ajax call
if ($_POST['action'] == "deleteCartProduct") {
    $data = array(
        ":cart_id" => array(
            "value" => $_POST['value'],
            "type" => 'INT'
        ),
    );
    $conn = new Connection();
    $result = $conn->delete("Cart", "cart_id = :cart_id", $data, "no");
    echo $result;
    exit;
}
if($_POST['action'] == "coupon"){
    $totalPr = $_POST['total'];
    $couponValue = $_POST['couponValue'];
    $conn = new Connection();
    $data = array(
        ":coupon" => array(
            "value" => $couponValue,
            "type" => 'string'
        ),
    );
    $Result = $conn->select('coupons', '*', null, null, "coupon = :coupon", $data);
    $updateResult = $Result[0];
    if($updateResult != ''){
        echo $updateResult['discount'];
    }
    else{
        echo 'fail';
    }
    exit;
}
if ($_POST['action'] == "shipval") {
    $shipOption = $_POST['status'];
    echo 'success';
    exit;
}
//Add Address Ajax call
if ($_POST['action'] == "addAddress") {
    $customer_id = $_SESSION['customer_id'];
    $name = $_SESSION['userName'];
    $email = $_SESSION['userEmail'];
    $address = $_POST['value']['addAddressinput'];
    $conn = new Connection();
    $dataArr = array(
        "customer_id" => $customer_id,
        "name" => $name,
        "email" => $email,
        "address" => $address,
    );
    $AddressAdd = $conn->insert('Customer_Address', $dataArr);
    if (is_numeric($AddressAdd)) {
        echo "Success";
    } else {
        echo "false";
    }
    exit;
}
$title = "Proto";
require_once 'lib/siteConstant.php';
require_once 'lib/header_user.php';
require_once 'lib/navbar.php';
if (!isset($_SESSION['customer_id'])) {
    header("Location:index.php");
} else {
    //Address Dropdown
    $addressCondition = array(
        ":customer_id" => array(
            "value" => $_SESSION['customer_id'],
            "type" => 'INT'
        ),
    );

    $conn = new Connection();
    $address_result = $conn->select("Customer_Address", "address_id,address", null, null, "customer_id = :customer_id", $addressCondition);
    $addressData = '
                    <div class="col multiadd">
                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name = "addAddressSelet" id="addAddressSelet">';
    foreach ($address_result as $address_result_val) {
        $addressData .= '<option value = "' . $address_result_val['address_id'] . '">' . $address_result_val['address'] . '</option>';
    }
    $addressData .= '</select>
</div>';
    $data = array(
        ":customer_id" => array(
            "value" => $_SESSION['customer_id'],
            "type" => 'INT'
        ),
    );
    //db connection
    $conn = new Connection();
    $result = $conn->select("Cart", "Cart.cart_id,Cart.product_id,name,Cart.quantity,Cart.price,image,summary", "LEFT JOIN", array('Products' => array("product_id" => "product_id")), "customer_id = :customer_id", $data);
    $totalPrice = 0;
    $delieveryCharges = 0;
    $product_id = [];
    $quantity = [];
    $totalAmount = [];
    $cartResultCount = count($result);
    foreach ($result as $value) {
        //Dynamic cart menu
        $product_id[] = $value['product_id'];
        $quantity[] = $value['quantity'];
        $totalAmount[] = $value['price'] * $value['quantity'];
        $totalPrice += $value['price'] * $value['quantity'];
        $output .= ' <div class="row gy-3 mb-4">
        <div class="col-lg-6">
            <div class="me-lg-5">
                <div class="d-flex">
                    <img src="' . SITE_URL . 'eCommerce/assets/image/productUpload/' . $value["product_id"] . '/' . $value["image"] . '" class="border rounded me-3" style="width: 96px; height: 96px;">
                    <div class="">
                        <a href="#" class="nav-link">' . $value['name'] . '</a>
                        <p class="text-muted">' . $value['summary'] . '</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-6 d-flex flex-row flex-lg-column flex-xl-row text-nowrap">
            <div class="me-5">
                ' . $value['quantity'] . '
            </div>
            <div class="">
                <text class="h6 ms-5"> <i class="fa-solid fa-indian-rupee-sign"></i> ' . $value['price'] * $value['quantity'] . '</text> <br>
                <small class="text-muted text-nowrap ms-5"> <i class="fa-solid fa-indian-rupee-sign"></i> ' . $value['price'] . ' / per item </small>
            </div>
        </div>
        <div class="col-lg col-sm-6 d-flex justify-content-sm-center justify-content-md-start justify-content-lg-center justify-content-xl-end mb-2">
            <div class="float-md-end">
            <button type="button" id="' . $value['cart_id'] . '" class="deleteCartProduct btn btn-outline-danger">Remove</button>
            </div>
        </div>
        ' .
            $addressData . '
    </div>';
    }
    // onclick of order place button it will remove products from cart and add to the product page and also update the product quantity
    if (isset($_POST['orderPlace'])) {
        $conn = new Connection();
        $result = $conn->select("Cart");
        if (count($result) <= 0) {
            $orderPlaceOutput = '<div class="swal2-container1 swal2-container swal2-center"><div aria-labelledby="swal2-title" aria-describedby="swal2-html-container" class="swal2-popup swal2-modal swal2-icon-error swal2-show" tabindex="-1" role="dialog" aria-live="assertive" aria-modal="true" style="display: grid;">
            <ul class="swal2-progress-steps" style="display: none;"></ul>
            <div class="swal2-icon swal2-error swal2-icon-show" style="display: flex;"><span class="swal2-x-mark">
                    <span class="swal2-x-mark-line-left"></span>
                    <span class="swal2-x-mark-line-right"></span>
                </span>
            </div>
            <h2 class="swal2-title" id="swal2-title" style="display: block;">Add products to cart!!</h2>
        </div></div>';
        } else {
            $datadelete = array(
                ":customer_id" => array(
                    "value" => $_SESSION['customer_id'],
                    "type" => 'INT'
                ),
            );

            for ($i = 0; $i < count($product_id); $i++) {
                $dataArr = array(
                    "customer_id" => $_SESSION['customer_id'],
                    "product_id" => $product_id[$i],
                    "quantity" => $quantity[$i],
                    "order_date" => date("Y/m/d"),
                    "total_amount" => $totalAmount[$i],
                    "address_id" => $_POST['addAddressSelet'],
                    "order_status" => 0
                );
                $dataSelectQuantity = array(
                    ":product_id" => array(
                        "value" => $product_id[$i],
                        "type" => 'INT'
                    ),
                );
                $userData = array(
                    ":customer_id" => array(
                        "value" => $_SESSION['customer_id'],
                        "type" => 'INT'
                    ),
                );
                $userResult = $conn->select("Customers", "*", null, null, "customer_id=:customer_id", $userData);
                $username = $userResult[0]['name'];
                $useremail = $userResult[0]['email'];
                $useraddress = $userResult[0]['address'];

                //insert in order table
                $conn->insert("Orders", $dataArr);
                //delete from cart table
                $conn->delete("Cart", "customer_id = :customer_id", $datadelete, "no");
                //update the product table
                $result = $conn->select("Products", "*", null, null, "product_id=:product_id", $dataSelectQuantity);
                $productName = $result[0]["name"];
                $updatedQuantity = $result[0]['quantity'] - $quantity[$i];
                $category = $result[0]['category_id'];
                $dataArr = array(
                    "quantity" => $updatedQuantity,
                    "product_id" => $product_id[$i]
                );
                $result = $conn->update('Products', $dataArr, 'product_id = :product_id');

                $arr = array(
                    'username' => $username,
                    'useremail' => $useremail,
                    'productname' => $productName,
                    'orderamount' => $totalAmount[$i],
                    'address' => $useraddress,
                    'quantity' => $quantity[$i],
                    "orderDate" => date("Y/m/d"),
                );
                $conn->orderNotification('order', $arr);
            }
            echo "<script>
            window.location.href = '" . SITE_URL . "eCommerce/orderStatus.php?status=" . base64_encode('success') . "&category=" . base64_encode($category) . "';
            </script>";
        }
    }
}

//Address Dropdown
$addressCondition = array(
    ":customer_id" => array(
        "value" => $_SESSION['customer_id'],
        "type" => 'INT'
    ),
);

$conn = new Connection();
$address_result = $conn->select("Customer_Address", "address_id,address", null, null, "customer_id = :customer_id", $addressCondition);
$addressData = '<div class="row singleadd">
                    <div class="col">
                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name = "addAddressSelet" id="addAddressSelet">';
foreach ($address_result as $address_result_val) {
    $addressData .= '<option value = "' . $address_result_val['address_id'] . '">' . $address_result_val['address'] . '</option>';
}
$addressData .= '</select>
</div>
    <div class="col">
        <!-- Button trigger modal -->
        <button type="button" class="btn products" data-bs-toggle="modal" data-bs-target="#addAddressModal" style="background-color: #118383; color:white;">
            Add Address
        </button>
    </div>
</div>';
// $totalCharge = array_sum($totalAmount);
if ($totalPrice > 0 && $totalPrice <= 400) {
    $delieveryCharges = 30;
} else {
    $delieveryCharges = 0;
}
?>
<div class="container-fluid">
    <form method="post">
        <div class="row">
            <div class="col-lg-9">
                <div class="card border shadow-0">
                    <?php
                    if ($cartResultCount > 0) {
                        ?>
                        <div class='multiship'>
                            <label for="multiship">Allow Multiple Shipment : </label>
                            <div class="form-switch ms-2">
                                <input class="form-check-input" id="multiship" type="checkbox" checked>
                            </div>
                            <div class="multiadd">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn products" data-bs-toggle="modal"
                                    data-bs-target="#addAddressModal" style="background-color: #118383; color:white;">
                                    Add Address
                                </button>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="m-4">
                        <h4 class="card-title mb-4">Your shopping cart</h4>
                        <?php echo $output;
                        echo $orderPlaceOutput;
                        if ($cartResultCount > 0) {
                            echo $addressData;
                        }
                        ?>
                    </div>

                </div>
            </div>
            <?php if ($cartResultCount > 0) {?>
            <div class="col-lg-3">
                <div class="card shadow-0 border">
                    <div class="col mt-3">
                        <div class="input-group mb-3">
      <input type="text" class="form-control" id="couponVal" placeholder="Coupon Apply" aria-label="Coupon Apply" aria-describedby="coupon">
      <button class="btn btn-outline-success products" type="button" id="coupon">Apply</button>
    </div>
                    </div>
                    <div class="mb-3 d-flex justify-content-between mt-2">
                        <label for="" class="form-label h5">Shipping type : </label>
                        <select class="form-select form-select w-50" name="shipval" id="shipval">
                            <option value="1" selected>EKart</option>
                            <option value="2">Local Courior</option>
                            <option value="3">Local Pickup</option>
                        </select>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="mb-2">Total price:</p>
                            <p class="mb-2"><i class="fa-solid fa-indian-rupee-sign"></i>
                                <span>
                                    <?php echo $totalPrice ?>
                                </span>
                            </p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="mb-2">TAX:</p>
                            <p class="mb-2"><i class="fa-solid fa-indian-rupee-sign"></i>
                                <?php echo ceil(($totalPrice * 5) / 100) ?>
                            </p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="mb-2">Delivery charges:</p>
                            <p class="mb-2"><i class="fa-solid fa-indian-rupee-sign"></i><span id="deliveryCharges">
                                    <?php echo $delieveryCharges ?>
                                </span></p>
                        </div>
                        <?php
                        if ($delieveryCharges == 0) {
                            ?>
                            <div class="d-flex justify-content-between" id="shipdef">
                                <span class="text-success">Free Delivery (COD)</span>
                            </div>
                        <?php } ?>
                        <div class="d-none" id="shipLocal">
                            <div class="d-flex justify-content-between">
                                <span class="text-success">Local Pickup</span>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <p class="mb-2">Total price:</p>
                            <p class="mb-2 fw-bold"><i class="fa-solid fa-indian-rupee-sign"></i>
                                <span class="totalShow">
                                    <?php
                                    if ($delieveryCharges > 0) {
                                        echo $totalPrice + ceil(($totalPrice * 5) / 100) + 30;
                                        $totalPrice = $totalPrice + 30;
                                    }
                                    else{
                                        echo $totalPrice + ceil(($totalPrice * 5) / 100);
                                    }
                                    ?>
                                </span>
                            </p>
                        </div>
                        <div class="mt-3">

                            <div class="col">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn products products btn btn-success w-100 shadow-0 mb-2"
                                    data-bs-toggle="modal" data-bs-target="#addAddressModal1"
                                    style="background-color: #118383; color:white;">
                                    Payment
                                </button>
                            </div>
                            <?php }?>
    </form>
    <?php 
    ?>
    <a href="<?php echo SITE_URL; ?>eCommerce/index.php" class="btn btn-outline-secondary w-100 border mt-2"> Back to
        shop </a>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- Modal -->
<div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addAddressModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="street_Address" class="form-label">Street Address : </label>
                    <textarea class="form-control" id="street_Address" placeholder="Enter Address..."
                        name="street_Address" required><?php echo $updateResult['address'] ?></textarea>
                    <div id="validaddress" class="invalid-feedback">
                        Enter Address
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="" class="addAddress btn btn-success">Add</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addAddressModal1" tabindex="-1" aria-labelledby="addAddressModal1Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addAddressModal1Label">Payment</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card box2 shadow-sm">
                    <div class="d-flex align-items-center justify-content-between p-md-5 p-4"> <span
                            class="h5 fw-bold m-0">Payment
                            methods</span>
                    </div>
                    <!-- <ul class="nav nav-tabs mb-3 px-md-4 px-2">
            <li class="nav-item"> <a class="nav-link px-2 active" aria-current="page" href="#">Credit Card</a> </li>
            <li class="nav-item"> <a class="nav-link px-2" href="#">Mobile Payment</a> </li>
        </ul> -->
                    <div class="btn-group mb-5" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="btnradio" id="btnradio1" value="1"
                            autocomplete="off" checked>
                        <label class="btn btn-outline-primary" for="btnradio1">Credit/Debit Card</label>
                        <input type="radio" class="btn-check" name="btnradio" id="btnradio2" value="2"
                            autocomplete="off"> <label class="btn btn-outline-primary" for="btnradio2">UPI</label>
                        <input type="radio" class="btn-check" name="btnradio" id="btnradio3" value="3"
                            autocomplete="off"> <label class="btn btn-outline-primary" for="btnradio3">COD</label>
                    </div>
                    <form action="">
                        <div id="credit" class="row d-none">
                            <div class="col-12">
                                <div class="alert alert-danger" role="alert">
                                    Currently we are not providing this service please choose Cash on Delivery Thank you
                                    <strong>Team Proto</strong>!
                                </div>
                                <div class="d-flex flex-column px-md-5 px-4 mb-4"> <span>Credit Card</span>
                                    <div class="inputWithIcon"> <input class="form-control" type="text" value="">
                                        <span class=""> <img
                                                src="https://www.freepnglogos.com/uploads/mastercard-png/mastercard-logo-logok-15.png"
                                                alt=""></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex flex-column ps-md-5 px-md-0 px-4 mb-4"> <span>Expiration<span
                                            class="ps-1">Date</span></span>
                                    <div class="inputWithIcon"> <input type="text" class="form-control" value=""> <span
                                            class="fas fa-calendar-alt"></span> </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex flex-column pe-md-5 px-md-0 px-4 mb-4"> <span>Code CVV</span>
                                    <div class="inputWithIcon"> <input type="password" class="form-control" value="">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex flex-column px-md-5 px-4 mb-4"> <span>Name</span>
                                    <div class="inputWithIcon"> <input class="form-control text-uppercase" type="text"
                                            value=""> <span class="far fa-user"></span> </div>
                                </div>
                            </div>
                            <div class="col-12 px-md-5 px-4 mt-3">
                                <div class="btn btn-dark w-100 disable">Pay <i
                                        class="fa-solid fa-indian-rupee-sign"></i>
                                    <span class="totalShow">
                                        <?php echo $totalPrice + ceil(($totalPrice * 5) / 100) ?>
                                    </span>

                                </div>
                            </div>
                        </div>
                    </form>
                    <div id='upi' class='d-none'>
                        <div class="alert alert-danger" role="alert">
                            Currently we are not providing this service please choose Cash on Delivery Thank you
                            <strong>Team Proto</strong>!
                        </div>
                        <div class="card">
                            <div class="card-header">
                                UPI Payment
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="form-group">
                                        <label for="upiApp">Select UPI App:</label>
                                        <select class="form-select" id="upiApp">
                                            <option selected>Select Upi App</option>
                                            <option value="googlepay">Google Pay</option>
                                            <option value="phonepe">PhonePe</option>
                                            <option value="paytm">Paytm</option>
                                        </select>
                                    </div>
                                    <div class="col-12 px-md-5 px-4 mt-3">
                                        <div class="btn btn-dark w-100 disable">Pay <i
                                                class="fa-solid fa-indian-rupee-sign"></i>
                                            <span class='totalShow'>
                                                <?php echo $totalPrice + ceil(($totalPrice * 5) / 100) ?>
                                            </span>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="d-none" id='cod'>
                        <div class="col-12 px-md-5 px-4 mt-3">
                            <form method="post">
                                <button type="submit" name="orderPlace"
                                    class="products btn btn-success w-100 shadow-0 mb-2">Place Order</button>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
            <style>
                /* @import url('https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap'); */





                .card.box1 {
                    width: 350px;
                    height: 500px;
                    background-color:
                        <?php echo $color1;
                        ?>
                    ;
                    color:
                        <?php echo $color2;
                        ?>
                    ;
                    border-radius: 0
                }

                .card.box2 {
                    width: 450px;
                    height: 580px;
                    background-color:
                        <?php echo $color2;
                        ?>
                    ;
                    border-radius: 0
                }

                .text {
                    font-size: 13px
                }

                /* .form-control {
                    border: none;
                    border-bottom: 1px solid #ddd;
                    box-shadow: none;
                    height: 20px;
                    font-weight: 600;
                    font-size: 14px;
                    padding: 15px 0px;
                    letter-spacing: 1.5px;
                    border-radius: 0
                } */

                .inputWithIcon {
                    position: relative
                }

                img {
                    width: 50px;
                    height: 20px;
                    object-fit: cover
                }

                .inputWithIcon span {
                    position: absolute;
                    right: 0px;
                    bottom: 9px;
                    color:
                        <?php echo $color2;
                        ?>
                    ;
                    cursor: pointer;
                    transition: 0.3s;
                    font-size: 14px
                }

                .form-control:focus {
                    box-shadow: none;
                    border-bottom: 1px solid #ddd
                }

                .btn-outline-primary {
                    border: 1px solid #ddd
                }

                .btn-outline-primary:hover {
                    background-color:
                        <?php echo $color4;
                        ?>
                    ;
                    border: 1px solid #ddd
                }

                .btn-check:active+.btn-outline-primary,
                .btn-check:checked+.btn-outline-primary,
                .btn-outline-primary.active,
                .btn-outline-primary.dropdown-toggle.show,
                .btn-outline-primary:active {
                    color:
                        <?php echo $color2;
                        ?>
                    ;
                    background-color:
                        <?php echo $color1;
                        ?>
                    ;
                    box-shadow: none;
                    border: 1px solid #ddd
                }

                .btn-group>.btn-group:not(:last-child)>.btn,
                .btn-group>.btn:not(:last-child):not(.dropdown-toggle),
                .btn-group>.btn-group:not(:first-child)>.btn,
                .btn-group>.btn:nth-child(n+3),
                .btn-group>:not(.btn-check)+.btn {
                    border-radius: 50px;
                    margin-right: 20px
                }

                form {
                    font-size: 14px
                }

                form .btn.btn-primary {
                    width: 100%;
                    height: 45px;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                    background-color:
                        <?php echo $color1;
                        ?>
                    ;
                    color:
                        <?php echo $color2;
                        ?>
                    ;
                    border: 1px solid #ddd
                }

                form .btn.btn-primary:hover {
                    background-color:
                        <?php echo $color2;
                        ?>
                    ;
                    color:
                        <?php echo $color1;
                        ?>
                    ;
                }

                @media (max-width:750px) {
                    .container {
                        padding: 10px;
                        width: 100%
                    }

                    .text-green {
                        font-size: 14px
                    }

                    .card.box1,
                    .card.box2 {
                        width: 100%
                    }

                    .nav.nav-tabs .nav-item .nav-link {
                        font-size: 12px
                    }
                }

                .products,
                .footerTheme {
                    background-color:
                        <?php echo $color1; ?>
                        !important;
                    color:
                        <?php echo $color2; ?>
                        !important;
                }

                .products:hover {
                    background-color:
                        <?php echo $color3; ?>
                        !important;
                    color:
                        <?php echo $color4; ?>
                        !important;

                }
            </style>
            <script>
                $("input[type='radio']").click(function () {
                    var selectedApp = $("input[type='radio']:checked").val();
                    if (selectedApp == 1) {
                        $("#credit").removeClass("d-none");
                        $("#upi").addClass("d-none");
                        $("#cod").addClass("d-none");

                    }
                    if (selectedApp == 2) {
                        $("#credit").addClass("d-none");
                        $("#upi").removeClass("d-none");
                        $("#cod").addClass("d-none");

                    }
                    if (selectedApp == 3) {
                        $("#cod").removeClass("d-none");
                        $("#credit").addClass("d-none");
                        $("#upi").addClass("d-none");
                    }
                }).trigger('click');
            </script>
        </div>
    </div>
</div>
<style>
    .products,
    .footerTheme {
        background-color:
            <?php echo $color1; ?>
            !important;
        color:
            <?php echo $color2; ?>
            !important;
    }

    .products:hover {
        background-color:
            <?php echo $color3; ?>
            !important;
        color:
            <?php echo $color4; ?>
            !important;

    }

    .multiship {
        font-size: x-large;
        display: flex;
        justify-content: end;
    }
</style>
<script>
        var totalpr = "<?php echo $totalPrice + ceil(($totalPrice * 5) / 100) ?>";

    $("#multiship").change(function () {
        if ($(this).is(":checked")) {
            $(".singleadd").addClass("d-none");
            $(".multiadd").removeClass("d-none");
        } else {
            $(".singleadd").removeClass("d-none");
            $(".multiadd").addClass("d-none");
        }
    }).trigger('click');
    $("#coupon").click(function(){
        var coupon = $("#couponVal").val();
        if(coupon != ''){

        $.ajax({
            type: "post",
            data: {
                'action': 'coupon',
                'couponValue': coupon,
                'total': totalpr,
            },
            success: function (response) {
                console.log(response);
                if (response > 0) {
                    var dis = Math.ceil(totalpr - (totalpr * response / 100));
                    var totaldis = totalpr - dis; 
                    Swal.fire(
                        'You have shaved '+totaldis+' !!',
                        '',
                        'success'
                    )
            $(".totalShow").text(dis); 
            totalpr = dis; 
                }
                else{
                    Swal.fire({
            icon: 'error',
            title: 'Incorrect Coupon!!',
            text: 'Please enter correct Coupon Code!!!',
          })
                }
            }
        });
    }
    else{
        Swal.fire({
            icon: 'error',
            title: 'Empty Coupon!!',
            text: 'Please enter Coupon Code Properly!!!',
          })
    }
    });
    
    $("#shipval").change(function () {
        var shipVal = $(this).val();
        var selectedopt = $("#shipval option:selected").text();
        console.log(shipVal);
        if (shipVal == 3) {
            var showvalFinal = totalpr - 30;
            totalpr = totalpr - 30;
            $("#shipdef").addClass("d-none");
            $("#shipLocal").removeClass("d-none");
            $("#deliveryCharges").text("0");
            $(".totalShow").text(showvalFinal);
        }
        Swal.fire(
            'You have selected <strong>' + selectedopt + '</strong>!!!',
            '',
            'success'
        )
    }).trigger();
    
</script>
<?php
echo $script;
require_once 'lib/footer.php';
?>