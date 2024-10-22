<?php
// Incluye tu conexión a la base de datos aquí
// require_once "core/app/model/db.php";

// Recibe todas las configuraciones del formulario
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $configurations = ConfigurationData::getAll();

    foreach($configurations as $conf){
        if(isset($_POST[$conf->short])){
            $new_value = $_POST[$conf->short];

            // Si es un checkbox y no está marcado, lo tratamos como valor '0'
            if($conf->kind == 1 && !isset($_POST[$conf->short])){
                $new_value = 0;
            }

            // Actualiza el valor en la base de datos
            ConfigurationData::updateValue($conf->short, $new_value);
        }
    }

    // Redirige de vuelta a la página de configuración
    header("Location: configuration.php");
    exit();
}

?>
