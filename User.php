<?php
/**
 * MyClass File Doc Comment
 *
 * PHP version 7
 *
 * @category MyUserClass
 * @package  Project
 * @author   Deepak Tomar <sdeepak2610@gmail.com>
 * @license  General public license
 * @link     www.xyz.com
 */
namespace MFS\user;
require_once "include/database.php";
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
class User
{
    public $errors ;

    public function validate()
    {   
        if (is_array($this->data)) {
            if (empty($this->data)) {
                $errors= 'Plese enter the details';
            } else { 
                  $errors = [];
                if (empty($this->data['email'])) {  
                    $errors['email'] = "Email cant be empty!";
                } elseif (!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
                    $errors['email'] = 'Email is invalid!';
                } else {
                    \MFS\database\MySql::createDb();
                    $sql= "select * from tempUser where email ='{$this->data['email']}'";
                    $result= \MFS\database\MySql::query($sql);
                    if ($row = $result->fetch_assoc()) {
                        $errors['email'] = "Email used already! <Not Verified>";
                    }
                    $sql= "select * from user where email ='{$this->data['email']}'";
                    $result= \MFS\database\MySql::query($sql);
                    if ($row = $result->fetch_assoc()) {
                        $errors['email'] = "Email used already! <Verified>";
                    }
                    \MFS\database\MySql::closeConnection();
                }
                if (empty($this->data['fname'])) {  
                    $errors['fname'] = "Name cant be empty!";
                } elseif ((!preg_match("/^[a-zA-Z ]*$/", $this->data['fname']) ) ) {
                    $errors['fname'] = 'Invalid Name';
                } 
                if (empty($this->data['lname'])) {
                    $errors['lname'] = 'Last name cant be empty!';
                } elseif (!preg_match("/^[a-zA-Z ]*$/", $this->data['fname']) ) {
                    $errors['lname'] = "Invalid last name!";
                }
                if (empty($this->data['password'])) {  
                    $errors['password'] = "Password cant be empty!";
                } elseif (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $this->data['password']) ) {
                    $errors['password'] = 'Invalid Password';
                } 
            }
            return $errors;
        }  
    }
   
    public function validateEmail($email)
    {
        $errors ="";
        if (empty($email)) {
            $errors ="Email cant be empty!";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                   $errors = 'Invalid email';
        } else {
                \MFS\database\MySql::createDb();
                $_sql = "select * from user where email='{$email}' LIMIT 1";
                $result= \MFS\database\MySql::query($_sql);
            if ($row = $result->fetch_assoc()) {
                  //sendsms
                \MFS\database\MySql::closeConnection();
                  return true;
            }
                $_sql = "select * from tempUser where email ='{$email}' LIMIT 1";
                $result= \MFS\database\MySql::query($_sql);
            if ($row = $result->fetch_assoc()) {
                    //sendsms;
                \MFS\database\MySql::closeConnection();
                return true;
            } 
                $errors= "Email is not registered with us!";
        }
           return $errors;
    }
    public function validateLogin($email, $password)
    {
        $errors=[];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email";
        } 
        if (empty($password)) {
            $errors['password'] = "Invalid password";
        }
        return $errors;
    }
    public function validateProfile($phone, $city, $gender, $skillsId, $date)
    {
        $errors=[];
        if (empty($phone)) {
            $errors['phone'] ="Phone cant be Empty!";
        } elseif (!preg_match("/^[1-9]{1}\d{9}$/", $phone)) {
            $errors['phone'] = "Invalid phone Number!";
        }
        if (empty($city)) {
            $errors['city'] = "This field cant be empty!";
        } elseif (!preg_match("/^[a-zA-Z ]*$/", $city)) {
            $errors['city'] = "Invalid city name!";
        }
        if (empty($skillsId)) {
            $errors['skill'] = "please select atleast one skills!";
        }
        if (empty($gender)) {
            $errors['gender'] = "Plese enter your gender!";
        }
        if (empty($date)) {
            $errors['date'] = "Please provide your date of birth!";
        }
        return $errors;
    }
    
    public function save()
    {  
        $result = $this->validate();
        if (empty($result)) {
            \MFS\database\MySql::createDb();
            $_sql = "insert into tempUser (`fname`, `lname`, `email`, `password`) values('{$this->data['fname']}','{$this->data['lname']}','{$this->data['email']}','{$this->data['password']}')";
            $result = \MFS\database\MySql::query($_sql);
            \MFS\database\MySql::closeConnection();
            return true;
        } else {
            return $result;
        }

    }

    public static function submitProfile($phone, $city, $gender, $skillsId, $date)
    {
            $temp = new User();
            $fname = $lname = $id = $pass = $email =$profileid="";
            $result = $temp->validateProfile($phone, $city, $gender, $skillsId, $date);
        if (empty($result)) {
            \MFS\database\MySql::createDb();
            $_sql= "select * from tempUser WHERE email='{$_SESSION['user']}' LIMIT 1";
            $result = \MFS\database\MySql::query($_sql);
            if ($row = $result->fetch_assoc()) {
                    $fname= $row['fname'];
                    $lname = $row['lname'];
                    $id = $row['idd'];
                    $pass = $row['password'];
                    $email = $row['email'];
            }
            $_sql = "INSERT INTO `user`(`id`, `email`, `password`, `type`) VALUES({$id},'{$email}','{$pass}','U')";
            $result = \MFS\database\MySql::query($_sql);
            $_sql ="delete from `tempUser` WHERE email ='{$email}'";
            $result = \MFS\database\MySql::query($_sql); 
            $_sql="INSERT INTO `profile`(`fname`, `lastname`, `email`, `gender`, `dob`, `contact`, `city`, `user_id`) VALUES('{$fname}','{$lname}','{$email}','{$gender}','{$date}','{$phone}','{$city}',{$id});";
            $result = \MFS\database\MySql::query($_sql);
            $_sql ="SELECT * FROM `profile` WHERE email='{$email}' LIMIT 1";
            $result = \MFS\database\MySql::query($_sql);
            if ($row = $result->fetch_assoc()) {
                $profileid = $row['id'];
            }
            $_sql = "";
            foreach ($skillsId as $value) {
                $_sql .="INSERT INTO `profileSkills`(`sId`, `profileId`) VALUES ({$value},{$profileid}); "; 
            } 
            $result = \MFS\database\MySql::multiQuery($_sql); 
            \MFS\database\MySql::closeConnection();
            return true;
        } else {
            return $result;
        }

    }
   
    public static function addEducation()
    {

    }
    public static function addProjects($project)
    {

    }
    public static function addHobbies($hobbies)
    {

    }
    public static function showInfo()
    {
        $data=[];
        $id="";
        \MFS\database\MySql::createDb();
        $_sql = "select * from profile where email='{$_SESSION['user']}' LIMIT 1";
        $result = \MFS\database\MySql::query($_sql);
        if ($row = $result->fetch_assoc()) {
                $data['name'] = $row['fname']." ".$row['lname'];
                $data['email'] = $row['email'];
                $data['sex'] = $row['gender'];
                $data['date'] = $row['dob'];
                $data['number'] = $row['contact'];
                $data['city'] = $row['city'];
                $id= $row['id'];
        } 
        $_sql= "select * from Skills where id in (select sId from profileSkills where profileId={$id})";
        $result = \MFS\database\MySql::query($_sql);
        while ($row = $result->fetch_assoc()) {
            $data['skills'][]= $row['name'];
        } 
        \MFS\database\MySql::closeConnection();
        return $data;
    }
    public static function skills()
    {
        $data = [];
         $_sql = "select * from Skills";
         \MFS\database\MySql::createDb();
         $result= \MFS\database\MySql::query($_sql);
        while ($row = $result->fetch_assoc()) {
            $data[] = $row['name'];
        }
         \MFS\database\MySql::closeConnection();
         return $data;
    }

    public static function delete($id)
    {
        if ($id <= count(static::$user)) {
            unset(static::$user[$id]);
            return true;
        } else {
            return false;
        }
    }
    public static function login($email, $password)
    {
         $temp = new User();
         $result = $temp->validateLogin($email, $password);

        if (empty($result)) {
            \MFS\database\MySql::createDb();
            $_sql = "select * from tempUser where email = '{$email}' AND password  = '{$password}' LIMIT 1";
            $result = \MFS\database\MySql::query($_sql);
            if ($row = $result->fetch_assoc()) {
                return true;
            }
            $_sql    = "select * from user where email = '{$email}' AND password  = '{$password}' LIMIT 1";
            $result = \MFS\database\MySql::query($_sql);
            if ($row = $result->fetch_assoc()) {
                return $row['id'];
            } else {
                return "User does'nt exists!";
            }
        } else {
            return $result;
        }
    }
    public static function forgot($email)
    {
        $temp = new User();
        $result = $temp->validateEmail($email);
        return $result;
    }

    public static function logout()
    {
        
    }
}