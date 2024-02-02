<?php
//session start 
session_id("adminLoginSession");
session_start();
require_once '../lib/Connection.php';
//Forgot password
if($_POST['action'] == 'forgotPassword'){
    $conn = new Connection();
    $result = $conn->select("admin");
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
//reset admin password by ajax call
if ($_POST['action'] == 'resetAdminPassword') {
    $check = [];
    $conn = new Connection();
    $result = $conn->select("admin");
    foreach ($result as $value) {
        if ($value['username'] == $_POST['value']['adminUsername'] && $value['password'] == $_POST['value']['adminCurrentPassword']) {
            $resetPasswordData = array(
                "username" => $value['username'],
                "password" => $_POST['value']['adminNewPassword']
            );
            $check[] = true;
        } else {
            $check[] = false;
        }
    }
    if (in_array(true, $check)) {
        $result = $conn->update("admin", $resetPasswordData, 'username = :username');
        echo 'success';
    } else {
        echo 'failed';
    }
    exit;
}
// Admin Login
if (isset($_POST['loginAdmin'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (key_exists('remember', $_POST)) {
        $rememberMe = 1;
    } else {
        $rememberMe = 0;
    }
    $conn = new Connection();
    $result = $conn->select('admin', 'username,password');
    foreach ($result as $row) {
        if ($row['username'] == $username && $row['password'] == $password) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['password'] = $row['password'];
            if ($rememberMe == 1) {
                setcookie('username', $username, time() + (86400 * 30), "/");
                setcookie('password', $password, time() + (86400 * 30), "/");
            }
            header("Location:dashboard.php");
        } else {
            $out = '<span class="text-danger">Invalid Username or Password</span>';
        }
    }
}
$title = "Admin Login";
require_once '../lib/siteConstant.php';
require_once '../lib/header.php';
?>
<main>
    <div class="container">
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                        <div class="d-flex justify-content-center py-4">
                            <div class="logo d-flex align-items-center w-auto">
                                <img src="<?php echo SITE_URL; ?>eCommerce/assets/image/Logo.png" alt="...">
                            </div>
                        </div>
                        <!-- Admin Login Form Start -->
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">Admin Login</h5>
                                </div>
                                <form class="row g-3 needs-validation" method="post" novalidate>
                                    <div class="col-12">
                                        <label for="yourUsername" class="form-label">username : </label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                                            <input type="text" name="username" class="form-control" placeholder="Enter Your Username..." id="username" value="<?php echo $_COOKIE['username']; ?>" required>
                                            <div class="invalid-feedback">Please enter your username.</div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Password</label>
                                        <input type="password" name="password" id='password' class="form-control" id="password" placeholder="Enter Your Password..." value="<?php echo $_COOKIE['password']; ?>" required>
                                        <div class="invalid-feedback">Please enter your password!</div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                                            <label class="form-check-label" for="rememberMe">Remember me</label>
                                        </div>
                                    </div>
                                    <div class="col-12" id="alert">
                                        <?php echo $out; ?>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn-validation btn btn-primary w-100 mb-3" type="submit" name="loginAdmin" id="adminLogin">Login</button>
                                    </div>
                                </form>
                                <!-- Admin Login Form End -->
                                <div class="d-flex justify-content-between">
                                    <a data-bs-toggle="modal" href="#changePassword">Change Password</a>
                                    <a data-bs-toggle="modal" href="#forgotPassword">Forgot Password</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
<!-- reset password modal -->
<div class="modal fade" id="changePassword" data-bs-keyboard="false" tabindex="-1" aria-labelledby="changePasswordLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex justify-content-center py-4">
                    <div class="logo d-flex align-items-center w-auto">
                        <img src="<?php echo SITE_URL; ?>eCommerce/assets/image/Logo.png" alt="...">
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" method="post" novalidate>
                    <h1 class="modal-title fs-5 text-center" id="changePasswordLabel">Reset Password</h1>
                    <div class="col-md-12">
                        <label for="validationCustomUsername" class="form-label">Username</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                            <input type="text" class="form-control" id="validationCustomUsername" aria-describedby="inputGroupPrepend" required>
                            <div class="invalid-feedback">
                                Please enter a username.
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="currentPassword" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="currentPassword" name="Currentpassword" required>
                        </div>
                        <div class="col-md-6">
                            <label for="newPassword" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">CANCLE</button>
                <button type="button" class="btn btn-success" id="resetPassword">RESET</button>
            </div>
        </div>
    </div>
</div>
<!-- Forgot Password -->
<div class="modal fade" id="forgotPassword" data-bs-keyboard="false" tabindex="-1" aria-labelledby="forgotPasswordLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex justify-content-center py-4">
                    <div class="logo d-flex align-items-center w-auto">
                        <img src="<?php echo SITE_URL; ?>eCommerce/assets/image/Logo.png" alt="...">
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" method="post" novalidate>
                    <h1 class="modal-title fs-5 text-center" id="forgotPasswordLabel">Forgot Password</h1>
                    <div class="col-md-12">
                        <label for="validationCustomEmail" class="form-label">Email : </label>
                        <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                            <input type="email" class="form-control" id="validationCustomEmail" name="email" aria-describedby="inputGroupPrepend" required>
                            <div class="invalid-feedback">
                                Please enter your email.
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">CANCLE</button>
                <button type="button" class="btn btn-success" id="forgotPassword">VERIFY</button>
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
                    window.location.href = '../varification.php?email='+adminEmail+'&status=forgetpassword';
                }
            }
        });
    })
</script>
<?php
require_once '../lib/footer.php';
?>