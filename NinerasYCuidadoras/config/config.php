<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('DB_HOST', 'localhost');
define('DB_USER', 'c2800304_Ninera');
define('DB_PASS', 'Nicobau2025');
define('DB_NAME', 'c2800304_Ninera');

try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        throw new Exception("Error de conexión: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8");
} catch (Exception $e) {
    error_log($e->getMessage());
    die("Error de conexión a la base de datos");
}
?>