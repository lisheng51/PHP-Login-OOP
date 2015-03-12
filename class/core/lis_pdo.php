<?php

/**
 * Database connection class
 * 
 * @author Lisheng Ye
 * @version 1.0
 */
class LIS_PDO {

    /**
     *
     * @var object $db 
     * @var boolean $isConnected 
     */
    private static $db;
    private static $isConnected;

    /**
     * Disconnect the database
     */
    public static function disconnect() {
        self::$db = null;
        self::$isConnected = false;
    }

    /**
     * Constructor.
     * 
     * @return LIS_PDO
     */
    private function __construct() {
        self::$isConnected = true;
        try {
            self::$db = new PDO('mysql:host=localhost;dbname=test', 'root', 'root');
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            self::$isConnected = false;
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Get connection to database
     * 
     * @return obj $db
     */
    public static function get_connection() {
        if (empty(self::$db) === true) {
            new self();
        }
        return self::$db;
    }

}
