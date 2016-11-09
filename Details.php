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
if (!$sessionUser->isLoggedIn()) {
    redirectTo("index.php");
}
$msg1= $msg2= $msg3= $standard = $marks = $details = $hobbie = "";
$hobbyError = $projectError =  $eduError = "";

if (isset($_POST['submitEducation'])) {
    $standard = trim($_POST[]);
    $marks = trim($_POST[]);
    $details = trim($_POST[]);
    $result = \MFS\user\User :: addEducation($standard, $marks, $details);
    if ($result) {
        $msg1 = "Education add successfully!"; 
    } else {
        $eduError = $result;
    }  
}

if (isset($_POST['submitProject'])) {
    $project = trim($_POST[]);
    $result = \MFS\user\User :: addProjects($project);
    if ($result) {
        $msg2 = "Project add successfully!"; 
    } else {
        $projectError = $result;
    }
}

if (isset($_POST['submitHobbie'])) {
    $hobbie = trim($_POST['hobby']);
    $result = \MFS\user\User::addHobbies($hobbie);
    if ($result) {
        $msg3 = "Hobby add successfully!"; 
    } else {
        $hobbyError = $result;
    }
}
?>
<!doctype html>
<html lanf="en-US">
<head>
	<meta charset="UTF-8"/>
		<link rel="stylesheet" type="text/css" href="css/style.css">
    <title>
			Details
</title>
</head>
<body >
<div class="form">
      
      <ul class="tab-group">
        <li class="tab active"><a href="#edu">Education</a></li>
        <li class="tab"><a href="#projects">Projects</a></li>
        <li class="tab"><a href="#hobbies">Hobbies</a></li>
      </ul>
      
      <div class="tab-content">
        <div id="edu">   
          <h1>Enter your Education</h1>
          
          <form id='education' action="<?php
            echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
          
          <div class="top-row">
            <div class="field-wrap">
              <input type="text"  required autocomplete="off" name="standard" placeholder="ex 10, 12/ b.tech *"/>
            </div>
        
            <div class="field-wrap">
                <input type="text" required autocomplete="off" name="marks" placeholder="**.** %"/>
            </div>
          </div>

          <div class="field-wrap">
            <input type="text" autocomplete="off" name="eduDetail" placeholder="Enter Details"/>
          </div>
          
          <input type="submit" value="Submit" name="submitEducation" class="button button-block"/>
          <b id="info"><?php echo $msg1 ?></b>
          <b id ="error"><?php echo $eduError ?></b>
          
          </form>

        </div>
        
        <div id="projects">   
          <h1>Enter your Project's Details</h1>
          
          <form id='project' action="<?php
            echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
          
            <div class="field-wrap">
            <textarea autocomplete="off" name="projectData" placeholder="Project's Details"></textarea>
          </div> 
          <input type="submit" value="Submit" name="submitProject" class="button button-block"/>
          <b id="info"><?php echo $msg2 ?></b>
          <b id ="error"><?php echo $projectError ?></b>
          
          </form>

        </div>
        
         <div id="hobbies">   
          <h1>Enter your Hobbies</h1>
          
          <form id='form3' action="<?php
            echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
          
            <div class="field-wrap">
            <textarea autocomplete="off" name="hobby" placeholder="Your Hobbies"></textarea>
          </div> 
          <input type="submit" value="Submit" name="submitHobbie" class="button button-block"/>
          <b id="info"><?php echo $msg3 ?></b>
          <b id ="error"><?php echo $hobbyError ?></b>
          </form>

        </div>
      </div>
      
</div>
</body>
<script src="js/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="js/jquery.validate.js" type="text/javascript"></script>
<script src="js/validate.js" type="text/javascript"></script>
</html>

 