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
require "include/functions.php";
require 'User.php';
$msg = $info ="";
if (isset($_POST['reset'])) {
    $email = trim($_POST['email']);
    $result = \MFS\user\User::forgot($email);
    if ($result === true) {
        $info = "Mail sent to your registered email-id ".$email.". You will redirect to login page in 3s!";
        waitRedirect('index.php');
    } else {
        $msg= $result;
    }
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Reset Password Form</title>
<link href="css/forgotPage.css" rel="stylesheet" type="text/css" media="all"/>
</head>
<body>
<div class="elelment">
    <h2>Reset Password Form</h2>
    <div class="element-main">
        <h1>Forgot Password</h1>
        <p> Please share your registered email id with us!</p>
        <form id="forgotPass" action="<?php
            echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
            <input type="text"  name="email" value="Your e-mail address" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Your e-mail address';}" />
            <b id='error'><?php echo $msg; ?></b>
            <b id="info"><?php echo $info; ?></b>
            <input type="submit" value="Reset my Password" name='reset' />
        </form>
        <p><a href="index.php">Login</a></p>
    </div>
</div>
</body>
  <script src='js/jquery-3.1.1.min.js' type="text/javascript"></script>
  <script src="js/jquery.validate.js" type="text/javascript"></script>
  <script src="js/forgot.js" type="text/javascript"></script>
</html>