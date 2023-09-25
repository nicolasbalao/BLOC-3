<?php

namespace App\Db;

// Get the config constant for the database
require_once(__DIR__ . '/../config/db_config.php');

use PDO;
use PDOException;

/**
 * Handle the connection with the db 
 * use singleton design pattern.
 * 
 * For use it:
 * $db_connection = Db::getInstance();
 *
 * @package App\Db
 */
class Db extends PDO
{

    private static $instance;

    private function __construct()
    {
        // Create the dsn (Data Source Name)
        $_dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;

        try {
            // Contructor of pdo for create the connection
            // == new PDO(...)
            parent::__construct($_dsn, DB_USER, DB_PASS);

            // Options for PDO
            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    /** 
     * Handle the connection of the database, for having only one connection
     *  
     * @return self the instance of the connection
     */
    public static function getInstance(): self
    {

        // If the db connection is not init 
        if (self::$instance === null) {
            // new self() will trigger the private constructor
            self::$instance = new self();
        }
        return self::$instance;
    }
}
