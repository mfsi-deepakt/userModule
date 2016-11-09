<?php
/**
 * MyClass File Doc Comment
 *
 * PHP version 7
 *
 * @category Session_Class
 * @package  MyPackage
 * @author   Deepak Tomar <sdeepak2610@gmail.com>
 * @license  General public license
 * @link     www.xyz.com
 */
use mysqli;
/**
 * MyClass File Doc Comment
 *
 * PHP version 7
 *
 * @category MyClass
 * @package  MyPackage
 * @author   Deepak Tomar <sdeepak2610@gmail.com>
 * @license  General public license
 * @link     www.xyz.com
 */
class Session
{
    private $_loggedIn = false;
    private $_userId;
    /**
    * Constructor
    *
    *@return void
    */
    public function __construct()
    {
        session_start();
    }
    /**
    *Function to return tru of false on the basis of state of user
    *
    * @return true /false
    */
    public function isLoggedIn()
    {
        return ($_SESSION['user']);
    }
    /**
    *Function to login the user
    *
    * @param int $useId perform login operation on user (useid)
    *
    * @return void
    */
    public function loginUser($useId)
    {
        $this->_userId   = $_SESSION['user'] = $useId;
        $this->_loggedIn = true;
    }
    /**
    *Funtion to perform the logout task
     *
    *@return void
    */
    public function logout()
    {
        unset($this->_userId);
        unset($_SESSION['user']);
        $this->_loggedIn = false;
    }
    public function logoutAdmin()
    {
        unset($this->_userId);
        unset($_SESSION['admin']);
        $this->_loggedIn = false;
    }

    public function loginAdmin($useId)
    {
        $this->_userId   = $_SESSION['admin'] = $useId;
        $this->_loggedIn = true;
    }
    public function isLoggedInAdmin()
    {
        return ($_SESSION['admin']);
    }
}
$sessionUser  = new Session();