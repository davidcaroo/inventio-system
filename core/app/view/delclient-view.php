<?php

$client_id = $_GET["id"];
$client = PersonData::getById($client_id);

// Verificar si el cliente tiene ventas asociadas
$sales = SellData::getByPersonId($client_id);

if (count($sales) > 0) {
    // Si hay ventas asociadas, mostrar un mensaje de alerta
    echo "<script>alert('No puedes eliminar este cliente porque tiene ventas asociadas.'); window.location='./index.php?view=clients';</script>";
} else {
    // Si no tiene ventas asociadas, eliminar el cliente
    $client->del();
    echo "<script>alert('Cliente eliminado exitosamente.'); window.location='./index.php?view=clients';</script>";
}

?>
<? echo $client_id; ?>