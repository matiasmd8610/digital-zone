<?php

if($_SERVER['REQUEST_METHOD'] != 'POST' ){
    header("Location: index.html" );
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/PHPMailer.php';
require 'phpmailer/Exception.php';
require 'phpmailer/SMTP.php';

$name = $_POST['name'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];
$message = $_POST['message'];
$subject = 'Mensaje recibido desde www.digital-zonee.com';

$recaptcha_secret = "6LeDPtgpAAAAAFDTU6iEMc76TKTme_sv9BLIAFD5"; //Add secret key
$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$recaptcha_secret."&response=".$_POST['g-recaptcha-response']);
$response = json_decode($response, true);

if( empty(trim($name)) ) $name = 'anonimo';

$body = <<<HTML
    <h1 style="font-size: 22px;">Mensaje recibido desde www.digital-zonee.com</h1>
    <p>De: $name | $email</p>
    <h2 style="font-size: 18px;">Mensaje:</h2>
    <p>$message</p>
    
HTML;

$mailer = new PHPMailer(true);

try {
    //Server setting
    $mailer->SMTPDebug = 0;
    $mailer->isSMTP();
    $mailer->Host = 'c1302585.ferozo.com'; //Servidor de correo saliente SMTP del hosting
    $mailer->SMTPAuth = true;  
    $mailer->Username = 'contacto@digital-zonee.com';
    $mailer->Password = 'uRAsAV*5dR';                          
    $mailer->SMTPSecure = 'ssl';
    $mailer->Port = 465;
    $mailer->AltBody = strip_tags($body);
    $mailer->CharSet = 'UTF-8';

    //Recipients
    $mailer->setFrom( $email, "$name" );
    $mailer->addAddress('contacto@digital-zonee.com','Sitio web');

    //Content
    $mailer->isHTML(true);
    $mailer->Subject = $subject;
    $mailer->msgHTML($body);
    $mailer->AltBody = strip_tags($body);
    $mailer->CharSet = 'UTF-8';

    if($response["success"] === true){
        $mailer->send();
        header("Location: thank-you.html" );
    } else {
        header("Location: 404.html" );
    }

} catch (Exception $e) {
    return "El mensaje no pudo ser enviado. Error: $mailer->ErrorInfo";
}

?>