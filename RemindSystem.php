<?php
session_start();

require_once 'database.php';


$email = $_POST['email'];
$email2 = filter_var($email, FILTER_SANITIZE_EMAIL);

if((filter_var($email2, FILTER_VALIDATE_EMAIL)==false) || $email != $email2){
    $ok = false;
    $_SESSION['e_email'] = "Invalid e-mail";
}

$message = "Please reset your password using this link:\n\localhost/library/RemindSystem.php";
$subject = "Password Reset";
$headers = array(
    'From' => 'mateki079@gmail.com',
    'Reply-To' => 'mateki079@gmail.com',
    'X-Mailer' => 'PHP/' . phpversion()

    mail($email,$subject,$message,$headers);

//header('Location: RemindSystem.php');
echo $_SESSION['e_email'] = 'Email with reset link was send to you' ;
