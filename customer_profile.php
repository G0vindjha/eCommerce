<?php
session_id("customerLoginSession");
session_start();
if (!isset($_SESSION['userEmail'])) {
    header('Location:index.php');
    exit;
}
require_once 'lib/Connection.php';
//Update Employee data form database
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone_Number = $_POST['phone_Number'];
    $gender = $_POST['gender'];
    $street_Address = $_POST['street_Address'];
    $pp = $_POST['profile_Pic_filled'];
    if ($name == null || $email == null || $password == null || $phone_Number == null || $gender == null || $street_Address == null ||  is_numeric($phone_Number) == false) {
        $validate = "<div><small class='text-danger'>Enter data Properly !!</small></div>";
    } else {
        if ($_FILES['image']['name'] != '') {
            $fileName = $_FILES['image']['name'];
            $fileSize = $_FILES['image']['size'];
            $tempName = $_FILES['image']['tmp_name'];
            $fileType = $_FILES['image']['type'];
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
                        "customer_id" => $_SESSION['customer_id']
                    );
                    $conn = new Connection();
                    $result = $conn->update('Customers', $dataArr, "customer_id = :customer_id");

                    if ($result == 1) {
                        $uploadDirectory = '/var/www/html/ops/public_html/eCommerce/assets/image/customerUpload/' . $_SESSION['customer_id'] . '/';
                        if (file_exists($uploadDirectory)) {
                            $previousImagePath = $uploadDirectory . $pp;
                            unlink($previousImagePath);
                        }
                        $imagePath = $uploadDirectory . $profile_Pic;   
                        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
                        $pop = "<script>
                        Swal.fire(
                            'Details Changed Successfully!!',
                            '',
                            'success'
                          )
                          var delay = 2000;
                          setTimeout(function () {
                            window.location.href = 'customer_profile.php';
                          }, delay);
                          </script>";
                    } else {
                        $pop = "<script>
                        Swal.fire(
                            'File is not Uploaded!!',
                            '',
                            'success'
                            )
                            var delay = 2000;
                            setTimeout(function () {
                                window.location.href = 'customer_profile.php';
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
                                window.location.href = 'customer_profile.php';
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
                    window.location.href = 'customer_profile.php';
                  }, delay);
                  </script>";
            }
        } else {
            $dataArr = array(
                "name" => $name,
                "gender" => $gender,
                "email" =>  $email,
                "password" => $password,
                "address" => $street_Address,
                "phone_number" => $phone_Number,
                "customer_id" => $_SESSION['customer_id']
            );
            $conn = new Connection();
            $result = $conn->update('Customers', $dataArr, "customer_id = :customer_id");
            $pop = "<script>
                        Swal.fire(
                            'Data Updated Successfully!!',
                            '',
                            'success'
                            )
                            var delay = 2000;
                            setTimeout(function () {
                                window.location.href = 'customer_profile.php';
                            }, delay);
                            </script>";
        }
    }
}
//Fetch customer data form database
$data = array(
    ":customer_id" => array(
        "value" => $_SESSION['customer_id'],
        "type" => 'INT'
    ),
);
$conn = new Connection();
$result = $conn->select('Customers', ('customer_id,name,password,gender,email,address,`phone_Number`,`image`'), null, null, 'customer_id = :customer_id', $data);
$leftProfile = "<div class='card'>
                <div class='card-body profile-card pt-4 d-flex flex-column align-items-center'>
                    <img src='" . SITE_URL . "eCommerce/assets/image/customerUpload/" . $result[0]['customer_id'] . "/" . $result[0]['image'] . "' alt='Profile' class='rounded-circle w-50'>
                    <h2 class='mt-3'>" . $result[0]['name'] . "</h2>
                </div>
            </div>
";
$name = $result[0]['name'];
$gender = $result[0]['gender'];
$email = $result[0]['email'];
$phone_Number = $result[0]['phone_Number'];
$address = $result[0]['address'];
$password = $result[0]['password'];
$image = $result[0]['image'];
$title = 'Home Page';
require_once 'lib/siteConstant.php';
require_once 'lib/header_user.php';
require_once 'lib/navbar.php';
echo $pop;
?>
<div class='col-11 mt-5 py-5 mx-auto' style="margin-bottom: 25vh;">
    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">
                <?php echo $leftProfile; ?>
            </div>

            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body pt-3">
                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Personal Details</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2">

                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title">Profile Details</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                    <div class="col-lg-9 col-md-8"><?php echo $name; ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Gender</div>
                                    <div class="col-lg-9 col-md-8"><?php echo $gender;; ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">E-mail</div>
                                    <div class="col-lg-9 col-md-8"><?php echo $email; ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Contact</div>
                                    <div class="col-lg-9 col-md-8"><?php echo $phone_Number; ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Address</div>
                                    <div class="col-lg-9 col-md-8"><?php echo $address; ?></div>
                                </div>
                            </div>

                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                <form class="row g-3 needs-validation" novalidate method="post" enctype="multipart/form-data">
                                    <div class="row justify-content-center align-items-center g-2">
                                        <div class="col">
                                            <label for="name" class="form-label">Full Name : </label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Full Name..." value="<?php echo $name; ?>" required>
                                            <div class="invalid-feedback">Enter Name...</div>
                                        </div>
                                        <div class="col">
                                            <label for="profile_Pic" class="form-label">Upload Profile Photo : </label>
                                            <input type="file" class="form-control" aria-label="file example" id="image" name="image" value="<?php echo $image; ?>" <?php if (!isset($_SESSION['customer_id'])) {
                                                                                                                                                                        echo 'required';
                                                                                                                                                                    } ?>>
                                            <input type="hidden" class="form-control" aria-label="file example" id="profile_Pic_filled" name="profile_Pic_filled" value="<?php echo $image; ?>">
                                            <div class="invalid-feedback">Upload Profile photo...</div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center align-items-center g-2">
                                        <div class="col">
                                            <label for="email" class="form-label">Email : </label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email..." value="<?php echo $email; ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" aria-describedby="inputGroupPrepend" required>
                                                <div class="invalid-feedback">
                                                    Enter email...
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label for="password" class="form-label">Password : </label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password..." value="<?php echo $password; ?>" required>
                                            <div class="invalid-feedback">Choose password...</div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center align-items-center g-2">
                                        <div class="col">
                                            <label for="birth_Date" class="form-label">Phone Number : </label>
                                            <input type="text" class="form-control" id="phone_Number" name="phone_Number" placeholder="Enter Phone Number..." value="<?php echo $phone_Number ?>" required>
                                            <div class="invalid-feedback">Enter Phone Number...</div>
                                            <div id='validphone_Number'></div>
                                            <?php echo $validPhoneNumber; ?>
                                        </div>
                                    </div>
                                    <div class="gender fs-5">
                                        <label for="gender" class="form-label">Gender : </label>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" id="genderM" value="Male" name="gender" <?php if ($gender == "Male") {
                                                                                                                                        echo "checked";
                                                                                                                                    } ?> required>
                                            <label class="form-check-label" for="genderM">Male</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" id="genderF" value="Female" name="gender" <?php if ($gender == "Female") {
                                                                                                                                        echo "checked";
                                                                                                                                    } ?> required>
                                            <label class="form-check-label" for="genderF">Female</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" id="genderO" value="Other" name="gender" <?php if ($result[0]['gender'] == "Other") {
                                                                                                                                        echo "checked";
                                                                                                                                    } ?> required>
                                            <label class="form-check-label" for="genderO">Others</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="street_Address" class="form-label">Address : </label>
                                        <textarea class="form-control" id="street_Address" placeholder="Enter Address..." name="street_Address" required><?php echo $address ?></textarea>
                                        <div class="invalid-feedback">
                                            Enter Address...
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 col-12">
                                        <button class="btn btn-success p-2 col-5 mx-auto" id='submit' type="submit" name="submit">Update Details</button>
                                        <button class="btn btn-danger p-2 col-5 mx-auto" type="reset">Reset form</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php
echo $script;
require_once 'lib/footer.php';
?>