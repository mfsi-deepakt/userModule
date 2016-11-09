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
namespace MFS\database;

use Mysqli;

require "config.php";
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
class MySql
{
    private static $_conn;
    public  static $lastQuery;
    private static $_magicQuotes;
    private static $_newEnoughPhp;
    /**
    * Function for create database.
    *
    * @return open connection
    */
    public static function createDb()
    {
        self::$_magicQuotes   = get_magic_quotes_gpc();
        self::$_newEnoughPhp = function_exists("mysql_real_escape_string");
         self::$_conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME, 65);
        try {
            if (self::$_conn->connect_error) {
                throw new Exceeption("Failed: " . self::$_conn->connect_error);
            }
        }
        catch(Exception $e)
        {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
   
     /**
    * Function for close connection.
    *
    * @return null
    */
    public static function closeConnection()
    {
        if (isset(self::$_conn)) {
            mysqli_close(self::$_conn);
            self::$_conn ="";
        }
    }
     /**
    * Function for execute query
    *
    *@param string $sql query to be execute
    *
    * @return result
    */
    public static function query($sql)
    {
        self::$lastQuery = $sql;
        $result = mysqli_query(self::$_conn, $sql);
        self :: _confirmQuery($result);
        return $result;
    }
    public static function multiQuery($sql)
    {
        self::$lastQuery = $sql;
        $result = mysqli_multi_query(self::$_conn, $sql);
        self :: _confirmQuery($result);
        return $result;
    }
     /**
    * Function for check query.
    *
    * @param string $resultSet check the query result
    *
    * @return true / false
    */
    private static function _confirmQuery($resultSet)
    {
        if (!$resultSet) {
            $output = "Database query failed :" . mysqli_error(self::$_conn) . "<br /><br />";
            $output .= "Last SQL query: " . self::$lastQuery;
        }
    }
     /**
    * Function for preparing values for query execution.
    *
    * @param string $value to be checked before passs into query
    *
    * @return values
    */
    public static function mysqlPrep($value)
    {
        if (self::$_newEnoughPhp) {
            if (self::$_magicQuotes) {
                $value = stripcslashes($value);
            }
            $value = mysql_real_escape_string($value);
        } else {
            if (!self::$_magicQuotes) {
                $value = addslashes($value);
            }
        }
        return $value;
    }
    /**
    * Function for return the total number of rows
    *
    * @param stringarray $resultSet store query result
    *
    * @return int
    */
    public static function numRows($resultSet)
    {
        return mysqli_num_rows($resultSet);
    }
    /**
    * Function to find last inserted id !
    *
    * @return int/id
    */
    public static function insertId()
    {
        return mysqli_insert_id(self::$_conn);
    }
    /**
    * Function to find the affected rows in database
    *
    * @return resultset
    */
    public static function affectedRows()
    {
        return mysqli_affected_rows(self::$_conn);
    }
}

?>
