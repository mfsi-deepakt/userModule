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
require 'User.php';
require "include/session.php";
if (!$sessionUser->isLoggedIn()) {
    redirectTo("index.php");
}
$skillsId=[];
$msg="";
$phoneError = $cityError = $genderError = $skillError = $dateError = "";
if (isset($_POST['submit'])) {
    $phone = trim($_POST['phone']);
    $city = trim($_POST['city']);
    $gender = $_POST['gender'];
    foreach ($_POST['check_list'] as $check) {
        $skillsId[]= $check;
    }
    $date= $_POST['DOB'];
    $result =\MFS\user\User::submitProfile($phone, $city, $gender, $skillsId, $date);
    if ($result) {
        $msg = "Profile update succesfully! You will be redirect to home page in 3s";
        waitRedirect("home.php");
    } else {
        $phoneError = $result['phone'];
        $cityError = $result['city'];
        $genderError = $result['gender'];
        $skillError = $result['skill'];
        $dateError = $result['date'];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Personal Profile</title>
<link rel="stylesheet" href="css/j-forms.css">
<link href="css/profile.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
<div class="content">
		<h1>Personal Profile form widget</h1>
		<div class="main w3l">
			<form class="contact-forms wthree" name="profile" id="profile" action="<?php
            echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
					<div class="first-line agileits">
						<div class="span6 main-row">
							<div class="input">
								
								<h1><font color="#66ff66">Welcome</font></h1>
							</div>
						</div>
						<div class="span6 main-row">
							<div class="input">
								
								<h1><font color="#66ff66">Deepak Tomar</font></h1>
								
							</div>
						</div>
					</div>
					<div class="first-line agileits">
						<div class="span6 main-row">
							<div class="input">
								<input type="text" placeholder="Phone" id="phone" name="phone" >
								<b id ="error"><?php echo $phoneError ?></b>
							</div>
						</div>
						<div class="span6 main-row">
							
						</div>
					</div>
				<div class="main-row">
						<label class="input select">
							<select name="gender">
								<option value='0' selected disabled="">Gender</option>
								<option value="male">Male</option>
								<option value="female"> Female</option>
							</select>
							<b id ="error"><?php echo $genderError ?></b>
						</label>
					</div>
        <div class="first-line agileits">
            <div class="span6 main-row">
              <div class="input">
                <input type="date" placeholder="Date Of Birth" id="DOB" name="DOB" required="" value="<?php echo date('Y-m-d');?>">
				<b id ="error"><?php echo $dateError ?></b>              
              </div>
            </div>
            <div class="span6 main-row">
              <div class="input">
                
                <input type="text" placeholder="City" id="city" name="city">
                <b id ="error"><?php echo $cityError ?></b>
              </div>
            </div>
          </div>

					<!-- start country -->
					<div class="main-row">
						<div class="input"><font color="#66ff66" size="5px"> Skills <br>
        <?php
        $result = \MFS\user\User::skills();
        $i =1; 
        foreach ($result as $row) {
            echo "<input type='checkbox' name='check_list[]' value=".$i.">{$row}";
            $i++;
        }
        ?>
             					<b id ="error"><?php echo $skillError ?></b>
						</div>
					</div>
					
				<div class="footer">
					<input type="submit" name="submit" class="primary-btn" value="Send">
					<button type="reset" class="secondary-btn">Reset</button>
					<b id="info"><?php echo $msg?></b>
				</div>
		</div>
		<div class="main w3l">
			<form action="upload.php"  class="contact-forms wthree" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <div class="footer">
    <input type="submit" value="Upload Image" class="primary-btn" name="upload">
</div>
</form>
		</div>
		</div>
		<script src='js/jquery-3.1.1.min.js' type="text/javascript"></script>
		<script src="js/jquery.validate.js" type="text/javascript"></script>
		<script type="text/javascript" src="js/profile.js"></script>
</body>
</html>
