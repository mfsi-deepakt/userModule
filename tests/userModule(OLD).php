<?php
class User
{
	private static $user = [];
    private static $login = '0';
    public $errors ;

    public function validate()
    {   
        if(is_array($this->data)) {
            if (empty($this->data)) {
               $errors= 'Plese enter the details';
            }
            else { 
                  $errors = [];
                if(empty($this->data['email']))
                {  
                    $errors['email'] = "Email cant be empty!";
                } elseif (!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
                   $errors['email'] = 'FILTER_VALIDATE_EMAIL';
                }else {
                    foreach (static::$user as $data) {
                        foreach ($data as $key => $value) {
                            if($value == $this->data['email']) {
                                $errors ="Email already exists!";
                            }
                        }
                    }
                }
                if(empty($this->data['fname']))
                {  
                    $errors['Name'] = "Name cant be empty!";
                } elseif ((!preg_match("/^[a-zA-Z ]*$/", $this->data['fname']) ) && (!preg_match("/^[a-zA-Z ]*$/", $this->data['fname']) ) ) {
                 $errors['Name'] = 'Invalid Name';
                 } 
                if(empty($this->data['password']))
                {  
                    $errors['password'] = "Password cant be empty!";
                }elseif (!preg_match("/^[a-zA-Z ]{8,}$/", $this->data['password']) ){
                 $errors['password'] = 'Invalid Password';
                 } 
            }
            return $errors;
        }  
    }
    private function validateId($id)
    {
        if(empty($id) || !is_numeric($id))
        {
            return false;
        }
        else{
            return true;
        }
    }
    private function validateEmail($email)
    {  $errors ="";
        if(empty($email)) {
            $errors ="Email cant be empty!";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                   $errors = 'Invalid email';
        }else {
            $tempUser=0;
            foreach (static::$user as $data) {
                 foreach ($data as $key => $value) {
                    if($value == $email) {
                        $tempUser =1;
                    }
              }
            }
            if($tempUser == 0) {
                $errors ="Email is not register with us!";
            }
           }
           return $errors;
    }
    public function validateLogin($email, $password)
    {   $errors=[];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email";
       } 
       if(empty($password)) {
        $errors['password'] = "Invalid password";
       }
       return $errors;
    }
    
    public function save()
    {  
        $result = $this->validate();
        if ( empty($result)) {
        	$id = count(static::$user) + 1;
        	static::$user[$id] = $this->data;
        	return true;
        } else {
            if(is_array($result)) 
                {
                foreach($result as $key => $value)
                {
                    echo $key."  :  ".$value;
                } 
                }
            else {
             echo $result;
            }
        	return false;
        }

    }

    public static function findById($id)
    {   
        return static::$user[$id];
    }

     public static function findAll()
    {
       	return static::$user;
    }

    public static function delete($id)
    {
       if($id <= count(static::$user))
       {
           unset(static::$user[$id]);
           return true;
       } else  {
        return false;
       }
    }
    public static function login($email, $password)
    {
         $temp = new User();
        $result = $temp->validateLogin($email,$password);
        if(empty($result)) {
            foreach(static::$user as $data)
            { 
                if(static::$login == '0' && $data['email'] == $email && $data['password'] == $password) {
                    static::$login = '1';
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }
    public static function forgot($email)
    {
        $temp = new User();
       $result = $temp->validateEmail($email);
       if(empty($result)) {
        return true;
       } else {
        echo $result;
        return false;
       }
    }

    public static function logout()
    {
        if(static::$login =='1')
        {
            static::$login == '0';
            return true;
        }else {
            return false;
        }
    }
}