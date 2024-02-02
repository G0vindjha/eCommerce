<?php
//print_r("Working Soon");die();
// session start
session_id("adminLoginSession");
session_start();
if (!isset($_SESSION['username'])) {
    header("Location:index.php");
    exit;
}
$title = "FAQ";
$breadcrump = '<div class="pagetitle mt-4">
<h1>FAQ</h1>
<nav>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
    <li class="breadcrumb-item active">FAQ</li>
  </ol>
</nav>
</div>';
require_once '../lib/Connection.php';
require_once '../lib/siteConstant.php';
require_once '../lib/header.php';
require_once '../lib/navbar_admin.php';
?>
<div class="col-12 col-md-10 mt-5 fs-3 text-dark">
    <div class="text-center mb-3">
        <span class="display-4">FAQ</span>
    </div>
  <div class="border border-secondary border-3 p-3 mb-3 rounded">
  <p>
        <a class="text-decoration-none" data-bs-toggle="collapse" href="#question1" aria-expanded="false" aria-controls="question1">
            Why Is It Important For Business Owners To Create An Ecommerce Site?
        </a>
    </p>
    <div class="collapse" id="question1">
        <div class="card card-body">
            Today, people have very less time to purchase items, by going to physical stores. They prefer to browse their mobile devices or PC and shop online. Having an ecommerce site for your business will help you to capture this market base and keep your customers informed about all your latest products and services.
        </div>
    </div>
  </div>
  <div class="border border-secondary border-3 p-3 mb-3 rounded">
    <p>
        <a class="text-decoration-none" data-bs-toggle="collapse" href="#question2" aria-expanded="false" aria-controls="question2">
            How Can I Choose The Best Platform For My Ecommerce Business Website?
        </a>
    </p>
    <div class="collapse" id="question2">
        <div class="card card-body">
            Before getting started with your ecommerce web development, consider the few fundamentals that can help to choose the best platform. Always consider the items that you are selling. Some ecommerce platforms can handle inventory tracking and multiple product options while some others will not. Consider the design options, payment gateways, security of the site, integration with other tools, features and pricing before finalizing on the platform.
        </div>
    </div>
    </div>
    <div class="border border-secondary border-3 p-3 mb-3 rounded">
    <p>
        <a class="text-decoration-none" data-bs-toggle="collapse" href="#question3" aria-expanded="false" aria-controls="question3">
            What Are The Main Activities Of Ecommerce Sites?
        </a>
    </p>
    <div class="collapse" id="question3">
        <div class="card card-body">
            Ecommerce websites help online shoppers make a safe purchase from online stores and they are considered as platforms that help in buying and selling. It also helps in gathering and using demographics data from various channels and improves the customer service.

        </div>
    </div>
    </div>
    <div class="border border-secondary border-3 p-3 mb-3 rounded">
    <p>
        <a class="text-decoration-none" data-bs-toggle="collapse" href="#question4" aria-expanded="false" aria-controls="question4">Why Is Ecommerce Needed For Any Business?
            Why Is It Important For Business Owners To Create An Ecommerce Site?
        </a>
    </p>
    <div class="collapse" id="question4">
        <div class="card card-body">
            Ecommerce has gained much popularity nowadays because it offers business a whole range of opportunities ranging from marketing opportunities to increasing the range of products that helps to generate sales. It is with an optimized and well created e-store that you can easily create and achieve the goals and also offer the customers round the clock support services.
        </div>
    </div>
    </div>
    <div class="border border-secondary border-3 p-3 mb-3 rounded">
    <p>
        <a class="text-decoration-none" data-bs-toggle="collapse" href="#question5" aria-expanded="false" aria-controls="question5">What Are The Different Types Of Ecommerce?
        </a>
    </p>
    <div class="collapse" id="question5">
        <div class="card card-body">
            Ecommerce or internet commerce is basically related with different types of business transactions. The main four ways of ecommerce business is Business to business or B2B, Business to Customer B2C, Customer to Business (C2B and Customer to Customer C2C).
        </div>
    </div>
    </div>
    <div class="border border-secondary border-3 p-3 mb-3 rounded">
    <p>
        <a class="text-decoration-none" data-bs-toggle="collapse" href="#question6" aria-expanded="false" aria-controls="question6">How Should I Promote My Ecommerce Site ?
        </a>
    </p>
    <div class="collapse" id="question6">
        <div class="card card-body">
            There are various ways to do this and the first thing to do is to promote the site to all the customers. This will help to increase your customer base. Your website address should be present on every advertisement that your company invests in. Register with the search engines and optimize your website as this will affect the traffic of your site.
        </div>
    </div>
    </div>
    <div class="border border-secondary border-3 p-3 mb-3 rounded">
    <p>
        <a class="text-decoration-none" data-bs-toggle="collapse" href="#question7" aria-expanded="false" aria-controls="question7">What Are The Important Things That Can Turn Browsers Into Buyers?
        </a>
    </p>
    <div class="collapse" id="question7">
        <div class="card card-body">
            Ecommerce has gained much popularity nowadays because it offers business a whole range of opportunities ranging from marketing opportunities to increasing the range of products that helps to generate sales. It is with an optimized and well created e-store that you can easily create and achieve the goals and also offer the customers round the clock support services.
        </div>
    </div>
    </div>
    <div class="border border-secondary border-3 p-3 mb-3 rounded">
    <p>
        <a class="text-decoration-none" data-bs-toggle="collapse" href="#question8" aria-expanded="false" aria-controls="question8">Is There Any Limit On The Size Of My Product Or Customer Database?
        </a>
    </p>
    <div class="collapse" id="question8">
        <div class="card card-body">
            No, as such there are no limits on the size. The biggest benefit of having an online store is that you can add unlimited products and catalogues and at the same time you can grow your customer base as you require.
        </div>
    </div>
    </div>
</div>
<?php
require_once '../lib/footer.php';
?>