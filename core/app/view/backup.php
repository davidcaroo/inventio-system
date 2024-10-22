<?php
// Datos de conexión a la base de datos
$host = 'localhost'; // o tu host de base de datos
$dbname = 'inventiolite'; // nombre de tu base de datos
$username = 'root'; // usuario de la base de datos
$password = ''; // contraseña del usuario

// Conexión a la base de datos
$mysqli = new mysqli($host, $username, $password, $dbname);

// Verificar la conexión
if ($mysqli->connect_error) {
	die("Conexión fallida: " . $mysqli->connect_error);
}

// Nombre del archivo de respaldo
$backupFile = $dbname . "_" . date("Y-m-d_H-i-s") . ".sql";

// Comando para generar el archivo SQL (utilizando mysqldump)
$command = "mysqldump --user=$username --password=$password --host=$host $dbname > $backupFile";

// Ejecutar el comando para generar el backup
system($command);

// Comprobar si el archivo fue creado
if (file_exists($backupFile)) {
	// Establecer cabeceras para la descarga del archivo
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename=' . basename($backupFile));
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . filesize($backupFile));
	flush(); // Limpiar el buffer del sistema
	readfile($backupFile);
	// Eliminar el archivo de backup después de la descarga
	unlink($backupFile);
	exit;
} else {
	echo "Error al crear la copia de seguridad.";
}
?>
