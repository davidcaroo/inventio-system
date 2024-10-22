<?php
class Database {
    public static $db;
    public static $con;

    // El constructor debe llamarse __construct en PHP moderno
    function __construct() {
        $this->user = "root";
        $this->pass = "";
        $this->host = "localhost";
        $this->ddbb = "inventiolite";
    }

    function connect() {
        // Declaramos self::$con directamente para consistencia
        self::$con = new mysqli($this->host, $this->user, $this->pass, $this->ddbb);
        
        // Verificar si hay errores de conexión
        if (self::$con->connect_error) {
            die("Connection failed: " . self::$con->connect_error);
        }
        
        self::$con->query("SET sql_mode=''");

        return self::$con;
    }

    public static function getCon() {
        if (self::$con == null && self::$db == null) {
            self::$db = new Database();
            self::$con = self::$db->connect();
        }
        return self::$con;
    }
}
?>
