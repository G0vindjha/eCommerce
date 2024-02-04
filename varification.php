<?php
session_start();
require_once 'lib/Connection.php';
//otp varification
if ($_POST['action'] == 'verifyotp' && !isset($_GET['status'])) {
  if ($_SESSION['proto_otp'] == $_POST['value']['otp']) {
    $data = array(
      "email" => base64_decode($_GET['email']),
      "valid" => '1'
    );
    $conn = new Connection();
    $conn->update("validate", $data, "email = :email");
    echo 'success';
    session_unset();
    session_destroy();
  } else {
    echo 'fail';
  }
  exit;
}
if ($_POST['action'] == 'verifyotp' && isset($_GET['status'])) {
  if ($_SESSION['proto_otp'] == $_POST['value']['otp']) {
    echo "forgotPasswordValidationSuccess";
  }
  exit;
}
if($_POST['action'] == 'forgotAdminPassword'){
  if($_GET["status"] == 'user'){
    $data = array(
      "email" => base64_decode($_GET['email']),
      "password" => $_POST['value']['password']
    );
    $conn = new Connection();
    $conn->update("Customers", $data, "email = :email");
    echo 'successuser';
  }
  else{
    $data = array(
      "email" => base64_decode($_GET['email']),
      "password" => $_POST['value']['password']
    );
    $conn = new Connection();
    $conn->update("admin", $data, "email = :email");
    echo 'successadmin';
  }
  session_unset();
  session_destroy();
  exit;
}

$title = "Proto";
require_once 'lib/siteConstant.php';

//Email Varification
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// require 'PHPMailer/src/Exception.php';
// require 'PHPMailer/src/PHPMailer.php';
// require 'PHPMailer/src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'assets/thirdparty/PHPmailer/src/Exception.php';
require 'assets/thirdparty/PHPmailer/src/PHPMailer.php';
require 'assets/thirdparty/PHPmailer/src/SMTP.php';

$mail = new PHPMailer(true);
try {

  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->SMTPAuth = true;
  $mail->Username = ''; //your email
  $mail->Password = ''; //your Password
  $mail->SMTPSecure = 'ssl';
  $mail->Port = '465';
  $mail->setFrom(''); //your email
  $mail->addAddress(base64_decode($_GET['email']));
  $mail->isHTML(true);
  $otp = rand(1000, 9999);
  $mail->Subject = 'One time Password for Proto registration';
  $mail->Body    = ' </table><table role="presentation"
    style="width: 100%; border-collapse: collapse; border: 0px; border-spacing: 0px; font-family: Arial, Helvetica, sans-serif; background-color: rgb(239, 239, 239);">
    <tbody>
      <tr>
        <td align="center" style="padding: 1rem 2rem; vertical-align: top; width: 100%;">
          <table role="presentation"
            style="max-width: 600px; border-collapse: collapse; border: 0px; border-spacing: 0px; text-align: left;">
            <tbody>
              <tr>
                <td style="padding: 40px 0px 0px;">
                  <div style="text-align: left;">
                    <div class="text-center" style="padding-bottom: 20px;"><h3 class="text-center" style="color:#118383">PROTO</h3></div>
                  </div>
                  <div style="padding: 20px; background-color: rgb(255, 255, 255);">
                    <div style="color: rgb(33, 22, 90); text-align: center;">
                      <h1 style="margin: 1rem 0">Verification code</h1>
                      <p style="padding-bottom: 16px">Please use the verification code below to sign in.</p>
                      <p style="padding-bottom: 16px"><strong style="font-size: 130%;background-color:#118383;padding:10px; border-radius:5px;">' . $otp . '</strong></p>
                      <p style="padding-bottom: 16px">If you didn’t request this, you can ignore this email.</p>
                      <p style="padding-bottom: 16px">Thanks,<br>The Proto team</p>
                    </div>
                  </div>
                  <div style="padding-top: 20px; color: rgb(153, 153, 153); text-align: center;">
                    <p style="padding-bottom: 16px">Thank you for Joining ♥ </p>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>';
  $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
  $mail->send();
  $_SESSION['proto_otp'] = $otp;
} catch (Exception $e) {
  echo $e;
}
require_once 'lib/header_user.php';
require_once 'lib/navbar.php';
?>
<div class="card my-3 d-flex mx-auto w-25">
  <div class="card-body">
    <h5 class="card-title text-center"><img src="./assets/image/Logo.png" alt="" class="w-50"></h5>
    <form method="post" id="otpValidation" class="mt-5">
      <div class="mb-3">
        <label for="" class="form-label">Enter OTP : </label>
        <input type="number" class="form-control" name="otp" id="otp" aria-describedby="helpId" placeholder="Enter OTP">
        <small id="helpId" class="form-text text-success">Check Mail</small>
      </div>
      <button type="button" class="btn btn-success col-12" id="verifyotp">Verify</button>
    </form>
    <div id="changePassForm" class="d-none">
      <form method="post">
        <div class="mb-3">
          <label for="newPassword" class="form-label">New Password</label>
          <input type="password" class="form-control" id="newPassword" aria-describedby="newPasswordarea">
          <div id="newPasswordarea" class="form-text">Try to use unique password from previously used passwords.</div>
        </div>
        <div class="mb-3">
          <label for="confirmPassword" class="form-label">Confirm Password</label>
          <input type="password" class="form-control" id="confirmPassword">
        </div>
        <button type="button" id="ChangePassword" class="btn btn-success col-12">Change Password</button>
        <div class="forgotPasswordValidate"></div>
      </form>
    </div>
   </div>
</div>
<Script>
  $("#ChangePassword").click(function () {
    var newPassword = $("#newPassword").val();
    var confirmPassword = $("#confirmPassword").val();
    console.log("hello");
    if(confirmPassword == newPassword){
      var delay = 2000;
      $.ajax({
        type: "post",
        data: {
          "action": "forgotAdminPassword",
          "value": {
            "password": newPassword
          }
        },
        success: function (response) {
          if (response == "successadmin") {
            Swal.fire(
              'Password Reset Successfully!!!',
              '',
              'success'
            );
            setTimeout(function () {
              window.location.href = 'admin/index.php';
            }, delay);
            }
          else if(response == "successuser"){
            Swal.fire(
              'Password Reset Successfully!!!',
              '',
              'success'
            );
            setTimeout(function () {
              window.location.href = 'index.php';
            }, delay);
          }
           else {
              Swal.fire({
              icon: 'error',
              title: 'Password Reset Failed',
              text: 'Please enter correct username and Password!!!',
            })
          }
        }
      })
    }
    else{
      $("#forgotPasswordValidate").html("<small class='text-danger'>Password not matched!!!</small>");
    }
  })
</Script>
<?php
echo $script;
require_once 'lib/footer.php';
?>