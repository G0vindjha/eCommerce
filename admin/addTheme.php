<?php 
$title = "add Theme";
require_once '../lib/siteConstant.php';
require_once '../lib/Connection.php';
require_once '../lib/header.php';
require_once '../lib/navbar_admin.php';


if(isset($_POST['submit']) && !isset($_GET['id'])){

  $themeTitle = $_POST['title'];
  $color1 = $_POST['color1'];
  $color2 = $_POST['color2'];
  $color3 = $_POST['color3'];
  $color4 = $_POST['color4'];

  $about = $_POST['about'];

if(isset($_POST['submit'])) {
  $conn = new Connection();
  $maxId = $conn->select('theme','MAX(id) as id');
  $newDir = $maxId[0]['id'] + 1;
  $uploadDirectory = "/var/www/html/eCommerce/assets/image/themeUpload/$newDir/";
  if (!file_exists($uploadDirectory)) {
    mkdir($uploadDirectory, 0777, true);
  }

    // Loop through each file input field
    $dataArr = array(
      "title" => $themeTitle,
      "color1" => $color1,
      "color2" => $color2,
      "color3" => $color3,
      "color4" => $color4, 
      "about" => $about
    );
    for ($i = 1; $i <= 6; $i++) {
        $inputName = "sliderImg$i";
        $fileName = $_FILES[$inputName]['name'];
        $fileTmpName = $_FILES[$inputName]['tmp_name'];

        if ($fileName != "") {
            $uploadPath = $uploadDirectory . basename($fileName);

            if (move_uploaded_file($fileTmpName, $uploadPath)) {
                $dataArr["img$i"] = $fileName;

            } else {
                echo "Error uploading file $fileName.<br>";
            }
        }
    }
    $result = $conn->insert('theme', $dataArr);
    $pop = "<script>
                    Swal.fire(
                        'Theme Added Successfully!!',
                        '',
                        'success'
                      )
                      var delay = 2000;
                      setTimeout(function () {
                        window.location.href = 'theme.php';
                      }, delay);
                      </script>";
    echo $pop;
}
}
if(isset($_POST['submit']) && isset($_GET['id'])){
    $themeTitle = $_POST['title'];
    $color1 = $_POST['color1'];
    $color2 = $_POST['color2'];
    $color3 = $_POST['color3'];
    $color4 = $_POST['color4'];
  
    $about = $_POST['about'];

    $conn = new Connection();
    $data = array(
        ":id" => array(
            "value" => $_GET['id'],
            "type" => 'INT'
        ),
    );
    $Result = $conn->select('theme', '*', null, null, "id = :id", $data);
    $updateResult = $Result[0];

    $uploadDirectory = "/var/www/html/eCommerce/assets/image/themeUpload/".$_GET['id']."/";
    
    $dataArr = array(
        "title" => $themeTitle,
        "color1" => $color1,
        "color2" => $color2,
        "color3" => $color3,
        "color4" => $color4, 
        "about" => $about,
        'id' => $_GET['id']
      );
      for ($i = 1; $i <= 6; $i++) {
          $inputName = "sliderImg$i";
          $fileName = $_FILES[$inputName]['name'];
          $fileTmpName = $_FILES[$inputName]['tmp_name'];
          
          if ($fileName != "") {
            if (file_exists($uploadDirectory)) {
                $previousImagePath = $uploadDirectory . $updateResult["img$i"];
                unlink($previousImagePath);
            }
              $uploadPath = $uploadDirectory . basename($fileName);
  
              if (move_uploaded_file($fileTmpName, $uploadPath)) {
                  $dataArr["img$i"] = $fileName;
  
              } else {
                  echo "Error uploading file $fileName.<br>";
              }
          }
      }
      $result = $conn->update('theme', $dataArr,'id = :id');
      $pop = "<script>
                      Swal.fire(
                          'Theme Added Successfully!!',
                          '',
                          'success'
                        )
                        var delay = 2000;
                        setTimeout(function () {
                          window.location.href = 'theme.php';
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
  $Result = $conn->select('theme', '*', null, null, "id = :id", $data);
  $updateResult = $Result[0];
  $imgPath = SITE_URL . 'eCommerce/assets/image/themeUpload/' . $_GET['id'] . '/';
}
?>
<div class="container mt-3">
    <div class="col-12 d-flex justify-content-end mb-3">
        <a class="btn btn-outline-success" href="<?php echo SITE_URL; ?>eCommerce/admin/theme.php"
            role="button">Back</a>
    </div>
    <div class="row justify-content-end">
        <div class="col-md-10">
            <div class="card custom-card">
                <div class="card-header custom-card-header bg-primary text-light text-center">
                    <h3 class="mb-0">Theme</h3>
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group mb-3">
                            <label for="textInput">Title : </label>
                            <input type="text" class="form-control custom-form-control" value="<?php if($_GET['id']) echo $updateResult['title']; ?>" id="textInput" name="title"
                                placeholder="Enter text" required /> 
                        </div>
                        <div class="form-group mb-3">
                            <label for="fileInputs">Slider Images : </label>
                            <div class="d-flex">
                                <div class="mr-2">
                                    <input type="file" class="form-control-file custom-form-control" name="sliderImg1"
                                        id="fileInput1" onchange="previewImage(this, 'preview1')" rec />
                                    <?php 
                                    if(isset($_GET['id'])){
                                    ?>
                                        <img id="preview1" class="image-preview" src="<?php echo $imgPath.$updateResult['img1']; ?>" alt="Preview">
                                    <?php
                                    }
                                    else{
                                    ?>
                                        <img id="preview1" class="image-preview" src="#" alt="Preview" style="display: none;">
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div>
                                    <input type="file" class="form-control-file custom-form-control" name="sliderImg2"
                                        id="fileInput2" onchange="previewImage(this, 'preview2')" rec />
                                        <?php 
                                    if(isset($_GET['id'])){
                                    ?>
                                        <img id="preview2" class="image-preview" src="<?php echo $imgPath.$updateResult['img2']; ?>" alt="Preview" >
                                    <?php
                                    }
                                    else{
                                    ?>
                                        <img id="preview2" class="image-preview" src="#" alt="Preview" style="display: none;">
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div>
                                    <input type="file" class="form-control-file custom-form-control" name="sliderImg3"
                                        id="fileInput3" onchange="previewImage(this, 'preview3')" rec />
                                        <?php 
                                    if(isset($_GET['id'])){
                                    ?>
                                        <img id="preview3" class="image-preview" src="<?php echo $imgPath.$updateResult['img3']; ?>" alt="Preview">
                                    <?php
                                    }
                                    else{
                                    ?>
                                        <img id="preview3" class="image-preview" src="#" alt="Preview" style="display: none;">
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <div class="d-flex">
                                <div class="mr-2">
                                    <input type="file" class="form-control-file custom-form-control" name="sliderImg4"
                                        id="fileInput4" onchange="previewImage(this, 'preview4')" rec />
                                        <?php 
                                    if(isset($_GET['id'])){
                                    ?>
                                        <img id="preview4" class="image-preview" src="<?php echo $imgPath.$updateResult['img4']; ?>" alt="Preview">
                                    <?php
                                    }
                                    else{
                                    ?>
                                        <img id="preview4" class="image-preview" src="#" alt="Preview" style="display: none;">
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div>
                                    <input type="file" class="form-control-file custom-form-control" name="sliderImg5"
                                        id="fileInput5" onchange="previewImage(this, 'preview5')" rec />
                                        <?php 
                                    if(isset($_GET['id'])){
                                    ?>
                                        <img id="preview5" class="image-preview" src="<?php echo $imgPath.$updateResult['img5']; ?>" alt="Preview">
                                    <?php
                                    }
                                    else{
                                    ?>
                                        <img id="preview5" class="image-preview" src="#" alt="Preview" style="display: none;">
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div>
                                    <input type="file" class="form-control-file custom-form-control" name="sliderImg6"
                                        id="fileInput6" onchange="previewImage(this, 'preview6')" rec />
                                        <?php 
                                    if(isset($_GET['id'])){
                                    ?>
                                        <img id="preview6" class="image-preview" src="<?php echo $imgPath.$updateResult['img6']; ?>" alt="Preview">
                                    <?php
                                    }
                                    else{
                                    ?>
                                        <img id="preview6" class="image-preview" src="#" alt="Preview" style="display: none;">
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class='form-group mb-2'>
                            <div class="row">
                                <div class="col">
                                    <label for="exampleColorInput">Background Color : </label>
                                    <input type="color" name='color1' class="form-control form-control-color"
                                        id="exampleColorInput" value="<?php echo ($_GET['id']) ? $updateResult['color1'] : '#563d7c'; ?>" title="Choose your color" rec />
                                </div>
                                <div class="col">
                                    <label for="exampleColorInput1">Text Color : </label>
                                    <input type="color" name='color2' class="form-control form-control-color"
                                        id="exampleColorInput1" value="<?php echo ($_GET['id']) ? $updateResult['color2'] : '#563d7c'; ?>" title="Choose your color" rec />
                                </div>
                                <div class="col">
                                    <label for="exampleColorInput2">Hover Color : </label>
                                    <input type="color" name='color3' class="form-control form-control-color"
                                        id="exampleColorInput2" value="<?php echo ($_GET['id']) ? $updateResult['color3'] : '#563d7c'; ?>" title="Choose your color" rec />
                                </div>
                                <div class="col">
                                    <label for="exampleColorInput2">Hover Text Color : </label>
                                    <input type="color" name='color4' class="form-control form-control-color"
                                        id="exampleColorInput2" value="<?php echo ($_GET['id']) ? $updateResult['color4'] : '#563d7c'; ?>" title="Choose your color" rec />
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="textBox">About Theme : </label>
                            <textarea class="form-control custom-form-control" name="about" id="textBox"
                                rows="3"><?php if($_GET['id']) echo $updateResult['about']; ?></textarea>
                        </div>
                        <div class="form-group ">
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            <button type="button" name="preview" class="btn btn-warning">Preview</button>
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

<script>
function previewImage(input, imageId) {
    var preview = document.getElementById(imageId);
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = '#';
        preview.style.display = 'none';
    }
}
// var btnUpload = $("#upload_file"),
// 	btnOuter = $(".button_outer");
// btnUpload.on("change", function(e){
// 	var ext = btnUpload.val().split('.').pop().toLowerCase();
// 	if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
// 		$(".error_msg").text("Not an Image...");
// 	} else {
// 		$(".error_msg").text("");
// 		btnOuter.addClass("file_uploading");
// 		setTimeout(function(){
// 			btnOuter.addClass("file_uploaded");
// 		},3000);
// 		var uploadedFile = URL.createObjectURL(e.target.files[0]);
// 		setTimeout(function(){
// 			$("#uploaded_view").append('<img src="'+uploadedFile+'" />').addClass("show");
// 		},3500);
// 	}
// });
// $(".file_remove").on("click", function(e){
// 	$("#uploaded_view").removeClass("show");
// 	$("#uploaded_view").find("img").remove();
// 	btnOuter.removeClass("file_uploading");
// 	btnOuter.removeClass("file_uploaded");
// });
</script>
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