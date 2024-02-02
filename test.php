<?php

// require_once 'lib/Connection.php';
// use PHPMailer\PHPMailer\PHPMailer;
// require 'PHPMailer/src/PHPMailer.php';
// require 'PHPMailer/src/SMTP.php';

// $mail = new PHPMailer(); // create a new object
// $mail->IsSMTP(); // enable SMTP
// $mail->SMTPOptions = array(
//     'ssl' => array(
//     'verify_peer' => false,
//     'verify_peer_name' => false,
//     'allow_self_signed' => true
//     )
// );
// $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
// $mail->SMTPAuth = true; // authentication enabled
// $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
// $mail->Host = "smtp.gmail.com";
// $mail->Port = 465; // or 587
// $mail->IsHTML(true);
// $mail->Username = "";
// $mail->Password = "";
// $mail->SetFrom("");
// $mail->Subject = "Test";
// $mail->Body = "hello";
// $mail->AddAddress("");

// if(!$mail->Send()) {
//    echo "Mailer Error: " . $mail->ErrorInfo;
// } else {
//    echo "Message has been sent";
// }
// echo ((base64_encode(1)));
echo ((int)(base64_decode("MQ==")))

?>

<script>
    let text = "Hello World!";
    var decoded = btoa(text);
    var encoded = atob(decoded);
    console.log(decoded);
    console.log(encoded);
    console.log("hello");
</script>