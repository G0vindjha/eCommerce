<?php
$title = "Proto";
require_once 'lib/siteConstant.php';
require_once 'lib/header_user.php';
require_once 'lib/navbar.php';
?>
<div class="container bg-light d-md-flex align-items-center">
    <div class="card box1 shadow-sm p-md-5 p-md-5 p-4">
        <div class="fw-bolder mb-4"><span class="fas fa-dollar-sign"></span><span class="ps-1">599,00</span></div>
        <div class="d-flex flex-column">
            <div class="d-flex align-items-center justify-content-between text"> <span class="">Commission</span> <span
                    class="fas fa-dollar-sign"><span class="ps-1">1.99</span></span> </div>
            <div class="d-flex align-items-center justify-content-between text mb-4"> <span>Total</span> <span
                    class="fas fa-dollar-sign"><span class="ps-1">600.99</span></span> </div>
            <div class="border-bottom mb-4"></div>
            <div class="d-flex flex-column mb-4"> <span class="far fa-file-alt text"><span class="ps-2">Invoice
                        ID:</span></span> <span class="ps-3">SN8478042099</span> </div>
            <div class="d-flex flex-column mb-5"> <span class="far fa-calendar-alt text"><span class="ps-2">Next
                        payment:</span></span> <span class="ps-3">22 july,2018</span> </div>

        </div>
    </div>
    <div class="card box2 shadow-sm">
        <div class="d-flex align-items-center justify-content-between p-md-5 p-4"> <span class="h5 fw-bold m-0">Payment
                methods</span>
        </div>
        <!-- <ul class="nav nav-tabs mb-3 px-md-4 px-2">
            <li class="nav-item"> <a class="nav-link px-2 active" aria-current="page" href="#">Credit Card</a> </li>
            <li class="nav-item"> <a class="nav-link px-2" href="#">Mobile Payment</a> </li>
        </ul> -->
        <div class="btn-group mb-5" role="group" aria-label="Basic radio toggle button group"> 
            <input type="radio" class="btn-check" name="btnradio" id="btnradio1" value="1" autocomplete="off" checked> 
            <label class="btn btn-outline-primary" for="btnradio1">Credit/Debit Card</label>
            <input type="radio" class="btn-check" name="btnradio" id="btnradio2" value="2" autocomplete="off"> <label class="btn btn-outline-primary" for="btnradio2">UPI</label>
            <input type="radio" class="btn-check" name="btnradio" id="btnradio3" value="3" autocomplete="off"> <label class="btn btn-outline-primary" for="btnradio3">COD</label>
        </div>
        <form action="">
            <div id="credit" class="row d-none">
                <div class="col-12">
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
                        <div class="inputWithIcon"> <input type="password" class="form-control" value=""> <span
                                class="fas fa-lock"></span> </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-column px-md-5 px-4 mb-4"> <span>Name</span>
                        <div class="inputWithIcon"> <input class="form-control text-uppercase" type="text"
                                value=""> <span class="far fa-user"></span> </div>
                    </div>
                </div>
                <div class="col-12 px-md-5 px-4 mt-3">
                    <div class="btn btn-dark w-100 disable">Pay $599.00</div>
                </div>
            </div>
        </form>
        <div id='upi' class='d-none'>
<div class="card">
    <div class="card-header">
      UPI Payment
    </div>
    <div class="card-body">
      <form>
        <div class="form-group">
          <label for="upiId">UPI ID:</label>
          <input type="text" class="form-control" id="upiId" placeholder="Enter UPI ID" required>
        </div>
        <div class="form-group">
          <label for="amount">Amount:</label>
          <input type="number" class="form-control" id="amount" placeholder="Enter amount" required>
        </div>
        <div class="form-group">
          <label for="upiApp">Select UPI App:</label>
          <select class="form-control" id="upiApp">
            <option value="googlepay">Google Pay</option>
            <option value="phonepe">PhonePe</option>
            <option value="paytm">Paytm</option>
            <!-- Add more UPI apps as needed -->
          </select>
        </div>
        <div class="col-12 px-md-5 px-4 mt-3">
                    <div class="btn btn-dark w-100 disable">Pay $599.00</div>
                </div>
      </form>
    </div>
  </div>
    </div>
    <div class="d-none" id='cod'>
    <div class="col-12 px-md-5 px-4 mt-3">
                    <div class="btn btn-dark w-100 disable">Order Now</div>
                </div>
    </div>
</div>

</div>
<style>
    @import url('https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap');





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

    .form-control {
        border: none;
        border-bottom: 1px solid #ddd;
        box-shadow: none;
        height: 20px;
        font-weight: 600;
        font-size: 14px;
        padding: 15px 0px;
        letter-spacing: 1.5px;
        border-radius: 0
    }

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
    .products, .footerTheme {
        background-color: <?php echo $color1;?> !important;
        color: <?php echo $color2;?> !important;
    }
    .products:hover{
        background-color: <?php echo $color3;?> !important;
        color: <?php echo $color4;?> !important;

    }
</style>
<script>
      $("input[type='radio']").click(function(){
      var selectedApp = $("input[type='radio']:checked").val();
      if(selectedApp == 1){
        $("#credit").removeClass("d-none");
        $("#upi").addClass("d-none");
        $("#cod").addClass("d-none");

    }
    if(selectedApp == 2){
        $("#credit").addClass("d-none");
        $("#upi").removeClass("d-none");
        $("#cod").addClass("d-none");

    }
    if(selectedApp == 3){
        $("#cod").removeClass("d-none");
        $("#credit").addClass("d-none");
      $("#upi").addClass("d-none");
      }
    }).trigger('click');
</script>
<?php
echo $script;
require_once 'lib/footer.php';
?>