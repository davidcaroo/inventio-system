<?php
include "../core/autoload.php";
include "../core/app/model/ProductData.php";
include "../core/app/model/OperationData.php";
include "../core/app/model/OperationTypeData.php";

require_once '../PhpWord/Autoloader.php';
use PhpOffice\PhpWord\Autoloader;
use PhpOffice\PhpWord\Settings;

Autoloader::register();

// Crear el documento Word
$word = new PhpOffice\PhpWord\PhpWord();
$products = ProductData::getAll();

$section1 = $word->AddSection();
$section1->addText("INVENTARIO", array("size" => 22, "bold" => true, "align" => "right"));

$styleTable = array('borderSize' => 6, 'borderColor' => '888888', 'cellMargin' => 40);
$styleFirstRow = array('borderBottomColor' => '0000FF', 'bgColor' => 'AAAAAA');

$table1 = $section1->addTable("table1");
$table1->addRow();
$table1->addCell()->addText("Id");
$table1->addCell()->addText("Nombre");
$table1->addCell()->addText("Disponible");

foreach($products as $product) {
    $q = OperationData::getQYesF($product->id);
    $table1->addRow();
    $table1->addCell(300)->addText($product->id);
    $table1->addCell(11000)->addText($product->name);
    $table1->addCell(500)->addText($q);
}

$word->addTableStyle('table1', $styleTable, $styleFirstRow);

// Guardar el archivo temporalmente
$temp_file = tempnam(sys_get_temp_dir(), 'inventary') . ".docx";
$word->save($temp_file, "Word2007");

// Cabeceras para forzar la descarga
header("Content-Description: File Transfer");
header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
header("Content-Disposition: attachment; filename=inventary-" . time() . ".docx");
header("Content-Transfer-Encoding: binary");
header("Expires: 0");
header("Cache-Control: must-revalidate");
header("Pragma: public");
header("Content-Length: " . filesize($temp_file));

// Enviar el archivo al navegador
readfile($temp_file);

// Eliminar el archivo temporal
unlink($temp_file);

?>
