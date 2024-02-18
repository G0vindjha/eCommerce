<?php 
//session starts
session_id("customerLoginSession");
session_start();
require_once 'Connection.php';
//Forgot password
if($_POST['action'] == 'forgotPassword'){
    $conn = new Connection();
    $result = $conn->select("Customers");
   $check = [];
    foreach ($result as $value) {
        if(in_array($_POST['value']['email'],$value)){
            $check[] = 'true';
        }
        else{
            $check[] = 'false';
        }
    }
    if(in_array('true',$check)){
        echo 'success';
    }
    else{
        echo 'fail';
    }
    exit;
}
//check if session is set if yes then it will hide the login button and show users name accordian
if (isset($_SESSION['userEmail'])) {
    $script =  "<script>
    $('#nav').addClass('d-flex');
    $('#loginnav').hide();
    </script>";
  } else {
    $script = "<script>
    $('#nav').hide();
    $('#loginnav').addClass('d-flex');
    </script>";
  }
  //User logout by ajax call
  if ($_POST['action'] == 'userLogout') {
    session_unset();
    session_destroy();
    echo "logout";
    exit;
  }
//user Password reset
if ($_POST['action'] == 'userResetPassword') {
    $check = [];
    $conn = new Connection();
    $result = $conn->select("Customers","email,password");
    foreach ($result as $value) {
        if ($value['email'] == $_POST['value']['userEmail'] && $value['password'] == $_POST['value']['userCurrentPassword']) {
            $resetPasswordData = array(
                "email" => $value['email'],
                "password" => $_POST['value']['userNewPassword']
            );
            $check[] = true;
        } else {
            $check[] = false;
        }
    }
    if (in_array(true, $check)) {
        $result = $conn->update("Customers", $resetPasswordData, 'email = :email');
        echo 'success';
    } else {
        echo 'failed';
    }
    exit;
}
//User Login by ajax call
if ($_POST['action'] == 'customerLogin') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rememberMe = $_POST['rememberMe'];
    $data = array(
        ":email"=> array(
            "value"=>$email,
            "type"=>"string"
        ) 
    );
    $conn = new Connection();
    $valid = $conn->select("validate","*",null,null,"email=:email",$data);
    if($valid[0]['valid'] == '0'){
        echo "varify";
        exit;
    }
    else{
        $result = $conn->select('Customers', 'customer_id,name,email,password');
    foreach ($result as $row) {
      if ($row['email'] == $email && $row['password'] == $password) {
        $_SESSION['customer_id'] = $row['customer_id'];
        $_SESSION['userName'] = $row['name'];
        $_SESSION['userEmail'] = $row['email'];
        $_SESSION['userPass'] = $row['password'];
        if ($rememberMe == 1) {
          setcookie('userEmail', $email, time() + (86400 * 30), "/");
          setcookie('userPass', $password, time() + (86400 * 30), "/");
        }
        echo 'success';
        exit;
      }
    }
    echo "failed";
    exit;
    }
    
  }
  //Search products in home page
  if($_POST['action']== "homeSearch"){
    $search = $_POST['value'];
    if($search != null){
    echo '<h3 class="text-center">::: '.$_POST['value'].' :::</h3>';
    $conn = new Connection();
    $result = $conn->select('Products', ('product_id,Products.name,summary,Products.description,price,`quantity`,image,Categories.name as CategoryName'), 'LEFT JOIN', array('Categories' => array("category_id" => "category_id")), null, null, null, 'product_Id', 'ASC');   
    $new = array_filter($result, function ($value) use ($search) {
        $output = '';
        if (strpos(strtolower($value['name']), strtolower($search)) !== FALSE || strpos(strtolower($value['categoryName']), strtolower($search)) !== FALSE) {
            
            $output = '<div class="col-lg-3 col-md-6 col-sm-6 productCard">

            <div class="card my-2 shadow-0">
                <a href="'.SITE_URL.'eCommerce/productInfo.php?product_id='. base64_encode($value["product_id"]) . '" class="img-wrap">
                    <img src="'.SITE_URL.'eCommerce/assets/image/productUpload/'.$value["product_id"].'/'.$value["image"].'" class="card-img-top" style="aspect-ratio: 1 / 1">
                </a>
                <div class="card-body p-3">

                    <h5 class="card-title">'.$value["price"].'</h5>
                    <p class="card-text mb-0">'.$value["name"].'</p>
                    <p class="text-muted">
                        '.substr_replace($value["summary"], "...", 50).'
                    </p>
                </div>
                <a name="" id="" class="btn btn1 btn btn1-primary products" href="'.SITE_URL.'eCommerce/productInfo.php?product_id='. base64_encode($value["product_id"]) . '" role="button">View Product</a>
            </div>
        </div>';
        }
        echo $output;
    });
}
    exit;
}
//check if category is seleted
if(isset($_GET['category_id'])){
    $conn = new Connection();
    $data = array(
        ":category_id" => array(
            "value" => (int)(base64_decode($_GET['category_id'])),
            "type" => 'INT'
        ),
    );
    $result = $conn->select('Products', ('product_id,Products.name,summary,Products.description,price,`quantity`,image,Categories.name as CategoryName'), 'LEFT JOIN', array('Categories' => array("category_id" => "category_id")),"Products.category_id = :category_id",$data, null, 'product_Id', 'ASC'); 
    $outputheader ='<h3 class="text-center">::: '.$result[0]['CategoryName'].' :::</h3>';
    foreach ($result as $value) {
        $output .= '<div class="col-lg-3 col-md-6 col-sm-6 productCard">

            <div class="card my-2 shadow-0">
                <a href="'.SITE_URL.'eCommerce/productInfo.php?product_id='. base64_encode($value["product_id"]) . '" class="img-wrap">
                    <img src="'.SITE_URL.'eCommerce/assets/image/productUpload/'.$value["product_id"].'/'.$value["image"].'" class="card-img-top" style="aspect-ratio: 1 / 1">
                </a>
                <div class="card-body p-3">

                    <h5 class="card-title">'.$value["price"].'</h5>
                    <p class="card-text mb-0">'.$value["name"].'</p>
                    <p class="text-muted">
                        '.substr_replace($value["summary"], "...", 50).'
                    </p>
                </div>
                <a name="" id="" class="btn btn1 btn btn1-primary products" href="'.SITE_URL.'eCommerce/productInfo.php?product_id='. base64_encode($value["product_id"]) . '" role="button">View Product</a>
            </div>
        </div>';
    }
}
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
require_once 'siteConstant.php';
require_once 'header.php';
?>
<!-- User Login Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex justify-content-center py-4">
                    <div class="logo d-flex align-items-center w-auto justify-content-center">
                        <img class="mx-auto" src="<?php echo SITE_URL; ?>eCommerce/assets/image/Logo.png" id="logologin" alt="">
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <section class="section register d-flex flex-column align-items-center justify-content-center py-4">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="pt-4 pb-2">
                                            <h5 class="card-title text-center pb-0 fs-4">Login</h5>
                                        </div>
                                        <form class="row g-3 needs-validation" novalidate method="post">
                                            <div class="col-12">
                                                <label for="yourUsername" class="form-label">Email : </label>
                                                <div class="input-group has-validation">
                                                    <span class="input-group-text" id="inputGroupPrepend">@</span>
                                                    <input type="email" name="email" class="form-control" placeholder="Enter Your Email..." pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" id="email" value="<?php echo $_COOKIE['userEmail'];?>" required>
                                                    <div class="invalid-feedback">Please enter your username.</div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label for="yourPassword" class="form-label">Password</label>
                                                <input type="password" name="password" id='password' class="form-control" id="password" placeholder="Enter Your Password..." value="<?php echo $_COOKIE['userPass'];?>" required>
                                                <div class="invalid-feedback">Please enter your password!</div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rememberMe" id="rememberMe">
                                                    <label class="form-check-label" for="rememberMe">Remember me</label>
                                                </div>
                                            </div>
                                            <div class="col-12" id="alert"></div>
                                            <div class="col-12">
                                                <button class="btn-validation btn btn1 btn-primary w-100 mb-3 products" type="button" id="customerLogin">Login</button>
                                                <div class="d-flex justify-content-between">
                                                    <a href="<?php echo SITE_URL;?>eCommerce/userRagistration.php">Create Account</a>
                                                    <a id="userPasswordReset" data-bs-toggle="modal" href="#staticBackdrop">Forgot Password</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>
            </div>
        </div>
    </div>
</div>

<!-- reset password modal -->
<div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex justify-content-center py-4">
                    <div class="logo d-flex align-items-center w-auto">
                        <img src="<?php echo SITE_URL; ?>eCommerce/assets/image/Logo.png" id="logoforgot" alt="...">
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" method="post" novalidate>
                    <h1 class="modal-title fs-5 text-center" id="staticBackdropLabel">Reset Password</h1>
                    <div class="col-md-12">
                        <label for="validationCustomemail" class="form-label">Email</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                            <input type="email" name="email" class="form-control" id="validationCustomEmail" aria-describedby="inputGroupPrepend" required>
                            <div class="invalid-feedback">
                                Please enter a email.
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">CANCLE</button>
                <button type="button" class="btn btn-success " id="forgotPassword">VERIFY</button>
            </div>
        </div>
    </div>
</div>
<script>
    //Forgot Password
    $("#forgotPassword").click(function() {
        var adminEmail = $("#validationCustomEmail").val();
        $.ajax({
            type: "post",
            data: {
                "action":"forgotPassword",
                "value":{
                    "email":adminEmail,
                }
            },
            success: function (response) {
                if(response == 'success'){
                    window.location.href = 'varification.php?email='+btoa(adminEmail)+'&status=user';
                }
            }
        });
    })
</script>

