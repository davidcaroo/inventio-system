<?php
$products = ProductData::getAll();
?>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <h1>Reportes</h1>

            <form>
                <input type="hidden" name="view" value="reports">
                <div class="row">
                    <div class="col-md-3">
                        <select name="product_id" class="form-control">
                            <option value="">--  TODOS --</option>
                            <?php foreach($products as $p): ?>
                            <option value="<?php echo $p->id; ?>"><?php echo $p->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="sd" value="<?php if(isset($_GET["sd"])) { echo $_GET["sd"]; } ?>" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="ed" value="<?php if(isset($_GET["ed"])) { echo $_GET["ed"]; } ?>" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <input type="submit" class="btn btn-success btn-block" value="Procesar">
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">MOVIMIENTOS</div>
                <div class="card-body">
                    <?php if(isset($_GET["sd"]) && isset($_GET["ed"])): ?>
                    <?php if($_GET["sd"] != "" && $_GET["ed"] != ""): ?>
                    <?php 
                        $operations = array();
                        if($_GET["product_id"] == "") {
                            $operations = OperationData::getAllByDateOfficial($_GET["sd"], $_GET["ed"]);
                        } else {
                            $operations = OperationData::getAllByDateOfficialBP($_GET["product_id"], $_GET["sd"], $_GET["ed"]);
                        }
                    ?>

                    <?php if(count($operations) > 0): ?>
                    <table id="movimientosTable" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Operacion</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($operations as $operation): ?>
                            <tr>
                                <td><?php echo $operation->id; ?></td>
                                <td><?php echo $operation->getProduct()->name; ?></td>
                                <td><?php echo $operation->q; ?></td>
                                <td><?php echo $operation->getOperationType()->name; ?></td>
                                <td><?php echo $operation->created_at; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    <script>
                        $("#wellcome").hide();
                    </script>
                    <div class="jumbotron">
                        <h2>No hay operaciones</h2>
                        <p>El rango de fechas seleccionado no proporcionó ningún resultado de operaciones.</p>
                    </div>
                    <?php endif; ?>
                    <?php else: ?>
                    <script>
                        $("#wellcome").hide();
                    </script>
                    <div class="">
                        <h2>Fechas Incorrectas</h2>
                        <p>Puede ser que no seleccionó un rango de fechas, o el rango seleccionado es incorrecto.</p>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <br><br><br><br>
</section>

<!-- Incluir DataTables, Buttons y ColVis -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>

<script>
$(document).ready(function() {
    // Inicializa DataTables con Buttons y ColVis
    $('#movimientosTable').DataTable({
        dom: 'Bfrtip', // Define la estructura: B = Botones, f = filtro, r = procesamiento, t = tabla, i = información, p = paginación
        buttons: [
             'csv', 'excel', 'pdf', 'print', // Botones que deseas habilitar
        ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json", // Traducción completa al español
            buttons: {
                copyTitle: 'Copiado al portapapeles',
                copySuccess: {
                    _: '%d filas copiadas',
                    1: '1 fila copiada'
                },
                colvis: 'Visibilidad de columnas'
            }
        }
    });
});
</script>
