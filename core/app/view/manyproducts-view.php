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
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "inventiolite";
               
                $conn = new mysqli($servername, $username, $password, $dbname);
               
                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }

                // Leer el archivo línea por línea
                while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                    // Verificar que la línea tenga el número correcto de columnas
                    if (count($data) < 14) {
                        echo "Línea ignorada: " . implode(", ", $data) . " (menos de 14 columnas)<br>";
                        continue; // Ignorar esta línea y continuar con la siguiente
                    }
                    
                    // Asignar valores del CSV a variables
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
                    $q = $data[12];
                    $operation_type_id = $data[13];

                    // Verificar si el category_id existe en la tabla category
                    $check_category_stmt = $conn->prepare("SELECT 1 FROM category WHERE id = ?");
                    $check_category_stmt->bind_param("i", $category_id);
                    $check_category_stmt->execute();
                    $result = $check_category_stmt->get_result();

                    if ($result->num_rows > 0) {
                        // Preparar la consulta para insertar en la tabla product
                        $stmt = $conn->prepare("INSERT INTO product (barcode, name, description, inventary_min, price_in, price_out, unit, presentation, user_id, category_id, created_at, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        if ($stmt) {
                            $stmt->bind_param("sssddsssissi", $barcode, $name, $description, $inventary_min, $price_in, $price_out, $unit, $presentation, $user_id, $category_id, $created_at, $is_active);
                            if ($stmt->execute()) {
                                // Obtener el último ID insertado de la tabla product para usarlo en la tabla operation
                                $product_id = $conn->insert_id;

                                // Preparar la consulta para insertar en la tabla operation
                                $stmt_op = $conn->prepare("INSERT INTO operation (product_id, q, operation_type_id, created_at) VALUES (?, ?, ?, ?)");
                                if ($stmt_op) {
                                    $stmt_op->bind_param("iiis", $product_id, $q, $operation_type_id, $created_at);
                                    if (!$stmt_op->execute()) {
                                        echo "Error al insertar operación: " . $stmt_op->error . "<br>";
                                    }
                                    $stmt_op->close();
                                } else {
                                    echo "Error al preparar la consulta de operación: " . $conn->error . "<br>";
                                }
                            } else {
                                echo "Error al insertar producto: " . $stmt->error . "<br>";
                            }
                            $stmt->close();
                        } else {
                            echo "Error al preparar la consulta de producto: " . $conn->error . "<br>";
                        }
                    } else {
                        //echo "Error: `category_id` $category_id no existe en la tabla `category`. <br>";
                    }

                    $check_category_stmt->close();
                }

                // Cerrar el archivo y la conexión
                fclose($handle);
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
