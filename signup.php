<?php

//start session
session_start();

include('connection.php');


//check user inputs
// Define error messages

$missingUsername='<p><strong>Please enter a username!</strong></p>';
$missingEmail='<p><strong>Please enter your email address!</strong></p>';
$invalidEmail='<p><strong>Please enter a valid email address!</strong></p>';
$missingPassword='<p><strong>Please enter a Password!</strong></p>';
$invalidPassword='<p><strong>Your password should be at least 6 characters long and include one capital letter and one number! !</strong></p>';
$missingPassword2='<p><strong>Please confirm your Password!</strong></p>';
$differentPassword='<p><strong>Password don\'t match!</strong></p>';


//<!--Get username,email,password,password2-->
//Get username
if(empty($_POST["username"])){
    $error .= $missingUsername;
}
else{
    $username = filter_var($_POST["username"],FILTER_SANITIZE_STRING);
}
//Get email
if(empty($_POST["email"])){
    $error .= $missingEmail;
}
else{
    $email = filter_var($_POST["email"],FILTER_SANITIZE_EMAIL);
    if(!filter_var($_POST["email"],FILTER_SANITIZE_EMAIL))
    {
        $error .= $invalidEmail;
    }
}
//Get password
if(empty($_POST["password"])){
    $error .= $missingPassword;
}
else if(!(strlen($_POST["password"])>=6 and preg_match('/[A-Z]/',$_POST["password"]) and preg_match('/[0-9]/',$_POST["password"]))){
    $error .= $invalidPassword;
}
else{
    $password = filter_var($_POST["password"],FILTER_SANITIZE_STRING);
//Get password2
if(empty($_POST["password2"]))
{
    $error .= $missingPassword2;
}
else{
    $password2 = filter_var($_POST["password2"],FILTER_SANITIZE_STRING);
    if($password !== $password2)
    {
        $error .= $differentPassword;
    }
    }
}

// if there are any errors then print errors
if($error)
{
    $resultMessage = '<div class="alert alert-danger">'. $error . '</div>';
    echo $resultMessage;
    exit;
}

//no error
//prepare variable for inputs
//no errors

//Prepare variables for the queries
$username = mysqli_real_escape_string($link, $username);
$email = mysqli_real_escape_string($link, $email);
$password = mysqli_real_escape_string($link, $password);

$password = hash('sha256', $password);
//If username exists in the users table print error
$sql = "SELECT * FROM users1 WHERE username = '$username'";
$result = mysqli_query($link, $sql);
if(!$result){
    echo '<div class="alert alert-danger">Error running the query!</div>';

    exit;
}
$results = mysqli_num_rows($result);
if($results){
    echo '<div class="alert alert-danger">That username is already registered. Do you want to log in?</div>';  exit;
}
//If email exists in the users table print error
$sql = "SELECT * FROM users1 WHERE email = '$email'";
$result = mysqli_query($link, $sql);
if(!$result){
    echo '<div class="alert alert-danger">Error running the query!</div>'; exit;
}
$results = mysqli_num_rows($result);
if($results){
    echo '<div class="alert alert-danger">That email is already registered. Do you want to log in?</div>';  exit;
}
//Create a unique activation code
$activationKey =  bin2hex(openssl_random_pseudo_bytes(16));

//Insert user details and activation code in users1 table

$sql = "INSERT INTO `users1` (`username`, `email`, `password`,`activation`) VALUES ('$username', '$email', '$password','$activationKey')";
$result = mysqli_query($link,$sql);
if(!$result)
{
    echo '<div class="alert alert-danger">There was an error inserting the user details in Database!</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link). '</div>';
    exit;
}

//send the user an email with a link to activate.php with their email and activation code
$message = "Please click on this link to activate your account:\n\n";
$message .= 
    "http://dreamchasers.offyoucode.co.uk/notesapp/activate.php?email=" . urlencode($email) . "&key=$activationKey";
if(mail($email,'Confirm your Registration',$message,'From:'.'nikhilkalani486@gmail.com')
){
    echo "<div class='alert alert-success'>Thanks for registring!A confirmation email has been sent to $email.Please click on the activation link to activate your account</div>"; 
}


?>