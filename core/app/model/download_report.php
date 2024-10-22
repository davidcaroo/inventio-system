<?php
if (isset($_GET["sd"]) && isset($_GET["ed"])) {
    $client_id = isset($_GET["client_id"]) ? $_GET["client_id"] : "";
    $sd = $_GET["sd"];
    $ed = $_GET["ed"];

    // Obtener las operaciones
    if ($client_id == "") {
        $operations = SellData::getAllByDateOp($sd, $ed, 2);
    } else {
        $operations = SellData::getAllByDateBCOp($client_id, $sd, $ed, 2);
    }

    // Configurar el encabezado para la descarga del archivo CSV
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="reporte_ventas.csv"');

    // Abrir el archivo en modo escritura
    $output = fopen('php://output', 'w');

    // Escribir la cabecera del CSV
    fputcsv($output, ['Id', 'Subtotal', 'Descuento', 'Total', 'Fecha']);

    // Escribir los datos de las operaciones
    foreach ($operations as $operation) {
        fputcsv($output, [
            $operation->id,
            number_format($operation->total, 2, '.', ''),
            number_format($operation->discount, 2, '.', ''),
            number_format($operation->total - $operation->discount, 2, '.', ''),
            $operation->created_at
        ]);
    }

    // Cerrar el archivo
    fclose($output);
    exit();
}
?>