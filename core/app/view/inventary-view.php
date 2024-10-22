<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">

<!-- DataTables y Button JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>

<div class="row">
	<div class="col-md-12">
		<h1><i class="glyphicon glyphicon-stats"></i> Inventario de Productos</h1>
		<div class="clearfix"></div>
		<br>
		<div class="card">
			<div class="card-header">INVENTARIO</div>
			<div class="card-body">
				<?php
				$products = ProductData::getAll();
				if (count($products) > 0) {
				?>
					<!-- Tabla del inventario -->
					<table id="inventaryTable" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Codigo</th>
								<th>Nombre</th>
								<th>Disponible</th>
								<th class="no-export">Acciones</th> <!-- Clase para ocultar en exportaciones -->
							</tr>
						</thead>
						<tbody>
							<?php foreach ($products as $product): ?>
								<tr>
									<td><?php echo $product->id; ?></td>
									<td><?php echo $product->name; ?></td>
									<td><?php echo OperationData::getQYesF($product->id); ?></td>
									<td>
										<a href="index.php?view=history&product_id=<?php echo $product->id; ?>" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-time"></i> Historial</a>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>

				<?php } else { ?>
					<div class="jumbotron">
						<h2>No hay productos</h2>
						<p>No se han agregado productos a la base de datos.</p>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		$('#inventaryTable').DataTable({
			"pageLength": 10,
			"responsive": true,
			"lengthChange": true,
			"autoWidth": false,
			"language": {
				"emptyTable": "No hay información",
				"info": "Mostrando _START_ a _END_ de _TOTAL_ productos",
				"infoEmpty": "Mostrando 0 a 0 de 0 productos",
				"infoFiltered": "(filtrado de _MAX_ productos totales)",
				"lengthMenu": "Mostrar _MENU_ productos",
				"loadingRecords": "Cargando...",
				"processing": "Procesando...",
				"search": "Buscar:",
				"zeroRecords": "No se encontraron resultados",
				"paginate": {
					"first": "Primero",
					"last": "Último",
					"next": "Siguiente",
					"previous": "Anterior"
				}
			},
			dom: 'Bfrtip', // Define la estructura de la tabla con botones
			buttons: [{
					extend: 'collection',
					text: 'Descargar',
					buttons: [{
							extend: 'csv',
							exportOptions: {
								columns: ':not(.no-export)' // Exporta todas menos la columna de acciones
							}
						},
						{
							extend: 'excel',
							exportOptions: {
								columns: ':not(.no-export)' // Exporta todas menos la columna de acciones
							}
						},
						{
							extend: 'pdf',
							exportOptions: {
								columns: ':not(.no-export)' // Exporta todas menos la columna de acciones
							}
						},
						{
							extend: 'print',
							exportOptions: {
								columns: ':not(.no-export)' // Exporta todas menos la columna de acciones
							}
						}
					]
				},
				{
					extend: 'colvis',
					text: 'Visibilidad de Columnas'
				}
			]
		});
	});
</script>