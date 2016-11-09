    <?php
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
   
    /**
    * Function : Implement redirect features in project
    *
    * @param string $url destination url for redirecting
    * 
    *@return void
    */
    function redirectTo($url)
    {
        header('Location: ' . $url, true);  
    }
    function waitRedirect($url)
    {
        header("refresh:3;url={$url}");
    }
?>