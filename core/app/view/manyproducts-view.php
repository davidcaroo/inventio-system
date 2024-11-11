<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si se ha subido un archivo
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $fileSize = $_FILES['file']['size'];
        $fileType = $_FILES['file']['type'];

        // Verifica que el archivo sea un CSV
        if (pathinfo($fileName, PATHINFO_EXTENSION) === 'csv') {
            // Abre el archivo CSV
            if (($handle = fopen($fileTmpPath, 'r')) !== FALSE) {
                // Conectar a la base de datos (ajusta los valores según tu configuración)
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "inventiolite";

                // Crear conexión
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Verificar conexión
                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }

                // Leer el archivo línea por línea
                while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) { // Cambiado a punto y coma
                    // Verificar que la línea tenga el número correcto de columnas
                    if (count($data) < 12) {
                        echo "Línea ignorada: " . implode(", ", $data) . " (menos de 12 columnas)<br>";
                        continue; // Ignorar esta línea y continuar con la siguiente
                    }
                    // barcode, name, description, inventary_min, price_in, price_out, unit, presentation, user_id, category_id, created_at, is_active
                    $barcode = $data[0];
                    $name = $data[1];
                    $description = $data[2];
                    $inventary_min = $data[3];
                    $price_in = $data[4];
                    $price_out = $data[5];
                    $unit = $data[6];
                    $presentation = $data[7];
                    $user_id = $data[8];
                    $category_id = $data[9];
                    $created_at = $data[10];
                    $is_active = $data[11];

                    // Preparar la consulta SQL
                    $stmt = $conn->prepare("INSERT INTO product (barcode, name, description, inventary_min, price_in, price_out, unit, presentation, user_id, category_id, created_at, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    if ($stmt) {
                        $stmt->bind_param("sssddsssissi", $barcode, $name, $description, $inventary_min, $price_in, $price_out, $unit, $presentation, $user_id, $category_id, $created_at, $is_active);

                        // Ejecutar la consulta
                        if (!$stmt->execute()) {
                            echo "Error al insertar producto: " . $stmt->error . "<br>";
                        }
                    } else {
                        echo "Error al preparar la consulta: " . $conn->error . "<br>";
                    }
                }
                // Cerrar el archivo y la conexión
                fclose($handle);
                if (isset($stmt)) {
                    $stmt->close();
                }
                $conn->close();

                echo "Productos importados exitosamente.";
                print "<script>window.location='index.php?view=products';</script>";
            } else {
                echo "Error al abrir el archivo.";
                print "<script>window.location='index.php?view=products';</script>";
            }
        } else {
            echo "Por favor, suba un archivo CSV.";
            print "<script>window.location='index.php?view=products';</script>";
        }
    } else {
        echo "Error al subir el archivo.";
    }
}
