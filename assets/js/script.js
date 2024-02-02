//uploaded image reflect
$(document).ready(function () {
  $(document).on("change", "#profile_Pic", (e) => {
    var src = URL.createObjectURL(e.target.files[0])
    $("#userlogo").attr("src", src);
  });
  $(document).on("change", "#productImage", (e) => {
    var src = URL.createObjectURL(e.target.files[0])
    $("#productpreimage").attr("src", src);

  });
  //Bootstrap Validation
  (function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms)
      .forEach(function (form) {
        form.addEventListener('submit', function (event) {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }
          form.classList.add('was-validated')
        }, false)
      })
  })()
  //User submit validation
  $("#submit").click((e) => {
    var valid = true;
    if ($.isNumeric($("#phone_Number").val()) == false) {
      e.preventDefault();
      $("#validphone_Number").html("<small class='text-danger'>Please Enter valid Phone Number!!!!</small>");
      valid = false;
    }
    return valid;
  });
  $("#productSubmit").click((e) => {
    var valid = true;
    if ($.isNumeric($("#productPrice").val()) == false || $("#productPrice").val() <= 0) {
      e.preventDefault();
      $("#validproductPrice").html("<small class='text-danger'>Please Enter valid product price!!!!</small>");
      valid = false;
    }
    if ($.isNumeric($("#Productquentity").val()) == false || $("#Productquentity").val() <= 0) {
      e.preventDefault();
      $("#validProductquentity").html("<small class='text-danger'>Please Enter valid product quantity!!!!</small>");
      valid = false;
    }
    return valid;
  })
  //delete Customer data
  $(document).on('click', ".del", function () {
    console.log(this.id.slice(3));
    Swal.fire({
      title: 'Do you want to delete this customer\'s data?',
      showDenyButton: true,
      confirmButtonText: 'Yes',
      denyButtonText: `No`,
    }).then((result) => {
      var delay = 2000;
      if (result.isConfirmed) {
        Swal.fire('Saved!', '', 'success')
        $.ajax({
          type: "post",
          data: {
            "action": "deletedata",
            "value": this.id.slice(3)
          },
          success: function (response) {
            setTimeout(function () {
              window.location.href = 'customerList.php';
            }, delay);
          }
        });
      } else if (result.isDenied) {
        Swal.fire('Customer\'s data is not deletd!!', '', 'info')
      }
    })
  });
  //Admin search 
  $("#searchValue").keyup(function () {
    var searchValue = $("#searchValue").val();
    if (searchValue != "") {
      $.ajax({
        type: "post",
        data: {
          'action': 'searchData',
          'value': searchValue
        },
        success: function (response) {
          $('#tbody').html(response);
        }
      });
    }
  });
  //Admin Logout
  $(".adminLogout").click(() => {
    $.ajax({
      type: "post",
      data: {
        "action": 'adminLogout'
      },
      success: function (response) {
        if (response == 'logout') {
          window.location.href = 'index.php';
        }
      }
    });
  });
  //Product delete
  $(document).on('click', ".productDel", function () {
    console.log(this.id.slice(3));
    Swal.fire({
      title: 'Do you want to delete this Product\'s data?',
      showDenyButton: true,
      confirmButtonText: 'Yes',
      denyButtonText: `No`,
    }).then((result) => {
      var delay = 2000;
      if (result.isConfirmed) {
        Swal.fire('Saved!', '', 'success')
        $.ajax({
          type: "post",
          data: {
            "action": "productDelete",
            "value": this.id.slice(3)
          },
          success: function (response) {
            setTimeout(function () {
              window.location.href = 'productList.php';
            }, delay);
          }
        });
      } else if (result.isDenied) {
        Swal.fire('Product is not deletd!!', '', 'info')
      }
    })
  });
  //Category Delete
  $(document).on('click', ".categoryDel", function () {
    Swal.fire({
      title: 'Do you want to delete this category\'s data?',
      showDenyButton: true,
      confirmButtonText: 'Yes',
      denyButtonText: `No`,
    }).then((result) => {
      var delay = 2000;
      if (result.isConfirmed) {
        $.ajax({
          type: "post",
          data: {
            "action": "categoryDel",
            "value": {
              "id": this.id.slice(3),
              "quantity": $(this).data('quantity')
            }
          },
          success: function (response) {
            if (response == "success") {
              Swal.fire('category is deletd!!', '', 'success')
              setTimeout(function () {
                window.location.href = 'categories.php';
              }, delay);
            }
            else {
              Swal.fire('Delete the products of this category first!!', '', 'info')
              setTimeout(function () {
                window.location.href = 'productList.php';
              }, delay);
            }

          }
        });
      } else if (result.isDenied) {
        Swal.fire('category is not deletd!!', '', 'info')
      }
    })
  });
  //Admin side stickey Header and side bar
  window.onscroll = function () { myFunction() };

  var header = document.getElementById("header");
  var navbar1 = document.getElementById("navbarLeftAlignExample");
  console.log(navbar1);
  var sticky = header.offsetTop;

  function myFunction() {
    if (window.pageYOffset > sticky) {
      header.classList.add("sticky");
      navbar1.classList.add("mt-140");
    } else {
      header.classList.remove("sticky");
      navbar1.classList.remove("mt-140");
    }
  }
  // Customer login
  $("#customerLogin").click(() => {
    if ($('#rememberMe').is(":checked")) {
      var rememberMe = 1;
    } else {
      var rememberMe = 0;
    }
    $.ajax({
      type: "post",
      data: {
        "action": 'customerLogin',
        "email": $("#email").val(),
        "password": $("#password").val(),
        "rememberMe": rememberMe
      },
      success: function (response) {
        if (response == 'success') {
          window.location.href = 'index.php';
        }
        else if (response == "varify") {
          window.location.href = 'varification.php?email=' + btoa($("#email").val()) + '';
        }
        else {
          console.log(response)
          $('#alert').html('<span class="text-danger">Invalid Username or Password</span>');
        }
      }
    })
  })
  //customer logout
  $("#userLogout").click(() => {
    $.ajax({
      type: "post",
      data: {
        "action": 'userLogout'
      },
      success: function (response) {
        console.log(response);
        if (response == 'logout') {
          window.location.href = 'index.php';
        }
      }
    });
  });
  //Product search on home page
  $("#homeSearch").keyup(function () {
    $("#catProduct").html("");
    var searchValue = $("#homeSearch").val();
    if (searchValue != null) {
      $.ajax({
        type: "post",
        data: {
          'action': 'homeSearch',
          'value': searchValue
        },
        success: function (response) {
          $("#productList").html(response);
        }
      });
    }
  });
  //Decrease no of product
  $("#productMinus").click(() => {
    var quantity = Number($("#productQuantity").val());
    if (quantity >= 1) {
      $("#productQuantity").val(quantity - 1);
    }
  });
  //Inscrease no of products
  $("#productPlus").click(() => {
    var exsistingQuantity = Number($("#exsistingQuantity").val())
    var quantity = Number($("#productQuantity").val());
    if (quantity < exsistingQuantity) {
      $("#productQuantity").val(quantity + 1);
    }
  });
  //Remove Product from cart
  $(document).on("click", ".deleteCartProduct", function () {
    var delay = 2000;
    $.ajax({
      type: "post",
      data: {
        "action": "deleteCartProduct",
        "value": this.id
      },
      success: function (response) {
        if (response == "success") {
          Swal.fire('Product is Removed!!', '', 'success')
          setTimeout(function () {
            window.location.href = 'cart.php';
          }, delay);
        }
      }
    });
  });
  //Customer Password change
  $("#userResetPassword").click(() => {
    var userEmail = $("#validationCustomemail").val();
    var userCurrentPassword = $("#userCurrentPassword").val();
    var userNewPassword = $("#userNewPassword").val();
    var delay = 2000;
    $.ajax({
      type: "post",
      data: {
        "action": "userResetPassword",
        "value": {
          "userEmail": userEmail,
          "userCurrentPassword": userCurrentPassword,
          "userNewPassword": userNewPassword
        }
      },
      success: function (response) {
        if (response == "success") {
          Swal.fire(
            'Password Reset Successfully!!!',
            '',
            'success'
          );
          setTimeout(function () {
            window.location.href = 'index.php';
          }, delay);

        } else {

          Swal.fire({
            icon: 'error',
            title: 'Password Reset Failed',
            text: 'Please enter correct email and Password!!!',
          })
        }
      }
    });
  })
  //otp varification
  $("#verifyotp").click(() => {
    var otp = $("#otp").val();
    var delay = 2000;
    $.ajax({
      type: "post",
      data: {
        "action": "verifyotp",
        "value": {
          "otp": otp
        }
      },
      success: function (response) {
        console.log(response);
        if (response == "success") {
          Swal.fire(
            'User Varification Successful!!!',
            '',
            'success'
          );
          setTimeout(function () {
            window.location.href = 'index.php';
          }, delay);

        }
        else if (response == "forgotPasswordValidationSuccess") {
          $("#changePassForm").removeClass("d-none");
          $("#changePassForm").addClass("d-block");
          $("#otpValidation").addClass("d-none");
        }
        else {

          Swal.fire({
            icon: 'error',
            title: 'incorrect OTP',
            text: 'Please enter correct OTP!!!',
          })
        }
      }
    });
  })
});
//admin password change
$("#resetPassword").click(function () {
  var adminUsername = $("#validationCustomUsername").val();
  var adminCurrentPassword = $("#currentPassword").val();
  var adminNewPassword = $("#newPassword").val();
  var delay = 2000;
  $.ajax({
    type: "post",
    data: {
      "action": "resetAdminPassword",
      "value": {
        "adminUsername": adminUsername,
        "adminCurrentPassword": adminCurrentPassword,
        "adminNewPassword": adminNewPassword
      }
    },
    success: function (response) {
      if (response == "success") {
        Swal.fire(
          'Password Reset Successfully!!!',
          '',
          'success'
        );
        setTimeout(function () {
          window.location.href = 'index.php';
        }, delay);

      } else {

        Swal.fire({
          icon: 'error',
          title: 'Password Reset Failed',
          text: 'Please enter correct username and Password!!!',
        })
      }
    }
  });
  //Add Address
  $(document).on("click","#addAddress",function(){
    console.log("hello");
  })
});