<?php
/**
 * MyClass File Doc Comment
 *
 * PHP version 7
 *
 * @category MyClass
 * @package  Project
 * @author   Deepak Tomar <sdeepak2610@gmail.com>
 * @license  General public license
 * @link     www.xyz.com
 */
session_start();


require "include/functions.php";
require "include/session.php";
require 'User.php';

if ($sessionUser->isLoggedIn()) {
    redirectTo("home.php");
}
$user = $pass ="";
$emailError = $passError =$error="";

if (isset($_POST['login'])) {
    $user = trim($_POST['emailLogin']);
    $pass = trim($_POST['passLogin']);
    $result = \MFS\user\User::login($user, $pass);
    if (is_numeric($result) ) {
        $sessionUser->loginUser($user);
         redirectTo("home.php");
    } elseif ($result === true) {
        $sessionUser -> loginUser($user);
        redirectTo("profile.php");
    } elseif (is_array($result)) {
        $emailError =$result['email'];
        $passError = $result['password'];
    } else {
        $error = $result;
    }
}
$msg= $fnameError = $lnameError = $emailErr = $passErr="";

if (isset($_POST['signIn'])) {
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $pass = trim($_POST['pass']);
    $user = new MFS\user\User();
    $user->data = [
      'fname'=>$fname,
      'lname'=>$lname,
      'email'=>$email,
      'password'=>$pass
      ];
      
    $result = $user->save();
   
    if ($result === true) {
        $msg =  "Data stored successfully!";
    } elseif (is_array($result)) {
        $fnameError = $result['fname'];
        $lnameError = $result['lname'];
        $emailErr = $result['email'];
        $passErr = $result['password'];
    } else {
        $msg= $result;
    } 
}
?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Sign-Up/Login Form</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <div class="form">
      
      <ul class="tab-group">
        <li class="tab active"><a href="#signup">Sign Up</a></li>
        <li class="tab"><a href="#login">Log In</a></li>
      </ul>
      
      <div class="tab-content">
        <div id="signup">   
          <h1>Sign Up for Free</h1>
          
          <form id='signUp' action="<?php
            echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
          
          <div class="top-row">
            <div class="field-wrap">
              <input type="text"  autocomplete="off" name="fname" placeholder="First Name*"/>
              <b id ="error"><?php echo $fnameError; ?></b>
            </div>
        
            <div class="field-wrap">
                <input type="text" autocomplete="off" name="lname" placeholder="Last Name*"/>
                <b id ="error"><?php echo $lnameError; ?></b>
            </div>
          </div>

          <div class="field-wrap">
            <input type="email" autocomplete="off" name="email" placeholder="Email address*"/>
            <b id ="error"><?php echo $emailErr; ?></b>
          </div>
          
          <div class="field-wrap">
            <input type="password" autocomplete="off" name="pass" placeholder="Set a password*"/>
            <b id ="error"><?php echo $passErr; ?></b>
          </div>
          <b id ="error"><?php echo $msg; ?></b>
          
          <input type="submit" value="Get Started" name="signIn" class="button button-block"/>
          
          </form>

        </div>
        
        <div id="login">   
          <h1>Welcome Back!</h1>
          
          <form id='loginUs' action="<?php
            echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
          
            <div class="field-wrap">
            <input type="email" autocomplete="off" name="emailLogin" placeholder="Email*"/>
          <b id ="error"><?php echo $emailError; ?></b>
          </div>
          
          <div class="field-wrap">
              <input type="password"required autocomplete="off" name="passLogin" placeholder="Password*"/>
              <b id ="error"><?php echo $passError; ?></b>
          </div>
          <b id ="error"><?php echo $error; ?></b>
          <p class="forgot"><a href="forgot.php">Forgot Password?</a></p>
          
          <input type="submit" value="Log In" name="login" class="button button-block"/>
          </form>

        </div>
        
      </div>
      
</div> 
</body>
 <script src='js/jquery-3.1.1.min.js' type="text/javascript"></script>
  <script src="js/jquery.validate.js" type="text/javascript"></script>
  <script src="js/index.js" type="text/javascript"></script>
</html>
