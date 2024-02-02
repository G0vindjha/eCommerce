<?php 
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="<?php echo SITE_URL; ?>eCommerce/assets/image/companyIcon.png" rel="icon">
  <title><?php echo $title; ?></title>
  <link rel="stylesheet" href="<?php echo SITE_URL; ?>eCommerce/assets/thirdparty/css/bootstrap-icons.css">
  <link rel="stylesheet" href="<?php echo SITE_URL; ?>eCommerce/assets/thirdparty/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
  <link rel="stylesheet" href="<?php echo SITE_URL; ?>eCommerce/assets/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/fontawesome.min.css" integrity="sha512-SgaqKKxJDQ/tAUAAXzvxZz33rmn7leYDYfBP+YoMRSENhf3zJyx3SBASt/OfeQwBHA1nxMis7mM3EV/oYT6Fdw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
