<?php
/**

**/

define("ROOT", dirname(__FILE__));

$debug= false;
if($debug){
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
}

include "core/autoload.php";

ob_start();
session_start();
Core::$root="";

// si quieres que se muestre las consultas SQL debes decomentar la siguiente linea
// Core::$debug_sql = true;

$lb = new Lb();
$lb->start();

?>

<?php 
if(isset($_GET['action']) && $_GET['action'] == 'deleteuser') {
    $userId = $_GET['id'];
    $user = UserData::getById($userId);
    if ($user) {
        $user->delete(); // Asegúrate de que existe el método delete() en tu modelo UserData
        header("Location: index.php?view=users"); // Redirigir de nuevo a la lista de usuarios
    }
}
