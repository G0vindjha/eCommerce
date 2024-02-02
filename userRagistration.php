<?php
$title = "User Ragistration";
require_once 'lib/Connection.php';
require_once 'lib/siteConstant.php';
require_once 'lib/header_user.php';
require_once 'lib/navbar.php';
$buttonName = "Register";
$operation = "Registration";
//user Ragistration
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone_Number = $_POST['phone_Number'];
    $gender = $_POST['gender'];
    $street_Address = $_POST['street_Address'];
    if ($name == null || $email == null || $password == null || $phone_Number == null || $gender == null || $street_Address == null ||  is_numeric($phone_Number) == false) {
        $validate = "<div><small class='text-danger'>Enter data Properly !!</small></div>";
    } else {
        if (isset($_FILES['profile_Pic'])) {
            $fileName = $_FILES['profile_Pic']['name'];
            $fileSize = $_FILES['profile_Pic']['size'];
            $tempName = $_FILES['profile_Pic']['tmp_name'];
            $fileType = $_FILES['profile_Pic']['type'];
            $fileExtension = end(explode('/', $fileType));
            $newFileName = time() . $fileName;
            $profile_Pic = $newFileName;
            $upload = "customerUpload/$newFileName";
            if ($fileExtension == "jpeg" || $fileExtension == "png") {
                if ($fileSize >= 0 && $fileSize <= 1000000) {
                    $dataArr = array(
                        "name" => $name,
                        "image" => $profile_Pic,
                        "gender" => $gender,
                        "email" =>  $email,
                        "password" => $password,
                        "address" => $street_Address,
                        "phone_number" => $phone_Number,
                    );
                  
                    $dataForValidate=array(
                        "email" => $email,
                        "valid" => '0'
                    );
                    $conn = new Connection();
                    $conn->insert("validate",$dataForValidate);
                    $result = $conn->insert('Customers', $dataArr);
                    $dataArr = array(
                        "customer_id"=>$result,
                        "name" => $name,
                        "email" =>  $email,
                        "address" => $street_Address,
                    );
                    $AddressAdd = $conn->insert('Customer_Address', $dataArr);
                    if ($result == 'error') {
                        echo " File Not uploaded!!";
                    } else {
                        $uploadDirectory = '/var/www/html/ops/public_html/eCommerce/assets/image/customerUpload/' . $result . '/';
                        if (!file_exists($uploadDirectory)) {
                            mkdir($uploadDirectory, 0777, true);
                        }
                        $imagePath = $uploadDirectory . $profile_Pic;
                        move_uploaded_file($_FILES['profile_Pic']['tmp_name'], $imagePath);
                        $pop = "<script>
                        Swal.fire(
                            'Register Successfully!!',
                            '',
                            'success'
                          )
                          var delay = 2000;
                          setTimeout(function () {
                            window.location.href = 'index.php';
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
                            window.location.href = 'userRagistration.php';
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
                    window.location.href = 'userRagistration.php';
                  }, delay);
                  </script>";
            }
        }
    }
}
echo $pop;
?>
<!-- User Ragistration form -->
<div class="col-12 col-md-12 mb-3">
    <div class="container-fluid mt-3 border border-primary border-3 p-3 rounded">
        <div class="d-flex justify-content-center mb-3"><span class="fs-2 text-primary">Customer <?php echo $operation; ?></span></div>
        <div class="d-flex justify-content-center mb-3">
            <?php
            if (isset($_GET['customer_id'])) {
                echo $imgfield;
            } else {
                echo ' <img src="'.SITE_URL.'eCommerce/assets/image/userlogo.svg" id="userlogo" alt="..." class="rounded" width="130px">';
            }
            ?>

        </div>
        <form class="row g-3 needs-validation" id="validater" novalidate method="post" enctype="multipart/form-data">
            <div class="row justify-content-center align-items-center g-2">
                <div class="col">
                    <label for="name" class="form-label">Full Name : </label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Full Name..." value="<?php echo $updateResult['name'] ?>" required>
                    <div id="validname" class="invalid-feedback">Enter Name...</div>
                </div>
                <div class="col">
                    <label for="profile_Pic" class="form-label">Upload Profile Photo : </label>
                    <?php
                    $required = "required";
                    if (isset($_GET['customer_id'])) {
                        $required = "";
                    }
                    ?>
                    <input type="file" class="form-control" aria-label="file example" id="profile_Pic" name="profile_Pic" <?php echo $required; ?>>
                    <input type="hidden" class="form-control" aria-label="file example" id="profile_Pic_filled" name="profile_Pic_filled" value="<?php echo $updateResult['image'] ?>">
                    <div class="invalid-feedback">Upload Profile photo...</div>
                </div>
            </div>
            <div class="row justify-content-center align-items-center g-2">
                <div class="col">
                    <label for="email" class="form-label">Email : </label>
                    <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email..." value="<?php echo $updateResult['email'] ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" aria-describedby="inputGroupPrepend" required>
                        <div id="validemail" class="invalid-feedback">
                            Enter email...
                        </div>
                    </div>
                </div>
                <div class="col">
                    <label for="password" class="form-label">Password : </label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password..." value="<?php echo $updateResult['password'] ?>" required>
                    <div id="validpassword" class="invalid-feedback">Choose password...</div>
                </div>
            </div>
            <div class="row justify-content-center align-items-center g-2">
                <div class="col m-auto p-auto">
                    <label for="phone_Number" class="form-label">Phone Number : </label>
                    <input type="text" class="form-control" id="phone_Number" name="phone_Number" placeholder="Enter Phone Number..." value="<?php echo $updateResult['phone_number'] ?>" required>
                    <div class="invalid-feedback">Enter Phone Number...</div>
                    <div id='validphone_Number'></div>
                    <?php echo $validPhoneNumber; ?>
                </div>
                <div class="col gender fs-5 p-auto mt-4 ms-3">
                    <label for="gender" class="form-label">Gender : </label>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" id="genderM" value="Male" name="gender" <?php if ($updateResult['gender'] == "Male") {
                                                                                                                    echo "checked";
                                                                                                                } ?> required>
                        <label class="form-check-label" for="genderM">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" id="genderF" value="Female" name="gender" <?php if ($updateResult['gender'] == "Female") {
                                                                                                                    echo "checked";
                                                                                                                } ?> required>
                        <label class="form-check-label" for="genderF">Female</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" id="genderO" value="Others" name="gender" <?php if ($updateResult['gender'] == "Other") {
                                                                                                                    echo "checked";
                                                                                                                } ?> required>
                        <label class="form-check-label" for="genderO">Others</label>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="street_Address" class="form-label">Street Address : </label>
                <textarea class="form-control" id="street_Address" placeholder="Enter Address..." name="street_Address" required><?php echo $updateResult['address'] ?></textarea>
                <div id="validaddress" class="invalid-feedback">
                    Enter Address...
                </div>
            </div>
            <div class="d-flex gap-2 col-12">
                <button class="btn-validation btn btn-success p-2 col-5 mx-auto" id='submit' type="submit" name="submit"><?php echo $buttonName ?></button>
                <button class="btn btn-danger p-2 col-5 mx-auto" type="reset">Reset form</button>
                <?php echo "<br>" . $valid; ?>
            </div>
            <?php echo "<br>" . $validate; ?>
        </form>
    </div>
</div>
<?php
echo $script;
require_once 'lib/footer.php';
?>