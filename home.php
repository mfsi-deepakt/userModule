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
$result = \MFS\user\User:: showInfo();
?>
<html>
<head>
  <title>Home Page</title>
  <link rel="stylesheet" type="text/css" href="css/homedesign.css">
</head>
<body>
   <font color="#f2f2f2">
   <h1>Welcome!</h1>
  <div class="container">
  <img class="img-circle" src="images/my.jpg">
  <div class="details">
     <table>
      <tr>
        <td>Name : </td><td><?php echo $result['name']?></td>
      </tr>
      <tr> 
        <td>Email : </td><td><?php echo $result['email']?></td>
        </tr>
        <tr><td>Male/Female : </td><td><?php echo $result['sex']?></td>
        </tr>
        <tr><td>Date Of Birth : </td><td><?php echo $result['date']?></td></tr>
        <tr><td>Contact Number : </td><td><?php echo $result['number']?></td></tr>
        <tr><td>City : </td><td><?php echo $result['city']?></td></tr>
        <tr><td>Skills : </td><td><?php echo join(',', $result['skills']); ?></td></tr>
       </table>
  </div>
  </div>
 </font>
  </body>
  </html>