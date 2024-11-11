<div class="row">
	<div class="col-md-12">
		<h1><i class='glyphicon glyphicon-shopping-cart'></i> Lista de Ventas</h1>
		<div class="clearfix"></div>

		<?php
		$products = SellData::getSells();

		if (count($products) > 0) {
		?>

			<div class="card">
				<div class="card-header">
					VENTAS
				</div>
				<div class="card-body">

					<!-- Tabla de ventas -->
					<table id="salesTable" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Detalles</th>
								<th>Cant. Productos</th>
								<th>Nombre Producto</th>
								<th>Total</th>
								<th>Fecha</th>
								<th>Cliente</th>
								<th>Tipo venta</th>
								<th>Opciones</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($products as $sell): ?>
								<tr>
									<td style="width:30px;">
										<a href="index.php?view=onesell&id=<?php echo $sell->id; ?>" class="btn btn-xs btn-link">
											<i class="bi bi-eye"></i>
										</a>
									</td>
									<td style="width:30px;">
										<?php
										$operations = OperationData::getAllProductsBySellId($sell->id);
										echo count($operations);
										?>
										</>
									<td style="width:40px;">
										<?php
										foreach ($operations as $operation) {
											$product = $operation->getProduct();
											echo $product->name . "<br>";
										}
										?>
									<td style="width:100px;">
										<?php
										$total = $sell->total - $sell->discount;
										echo "<b>$ " . number_format($total) . "</b>";
										?>
									</td>
									<td style="width:130px;"><?php echo $sell->created_at; ?></td>
									<td style="width:150px;">
										<?php
										if ($sell->person_id != '') {
											$client = $sell->getPerson();
											echo $client->name . " " . $client->lastname;
										} else {
											echo "<i>Cliente no registrado</i>";
										}	
										?>
									</td>
									<td style="width:70px;">
										<?php if ($sell->note == ""): ?>
											<p>De contado</p>
										<?php elseif (strtolower($sell->note) == "credito"): ?>
											<p>A crédito</h>
										<?php else: ?>
											<p><?php echo htmlspecialchars($sell->note); ?></p>
										<?php endif; ?>
									</td>
									<td style="width:30px;">
										<a href="index.php?view=delsell&id=<?php echo $sell->id; ?>" class="btn btn-xs btn-danger">
											<i class="bi bi-trash"></i>
										</a>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>

					<div class="clearfix"></div>

				<?php
			} else {
				?>
					<div class="jumbotron">
						<h2>No hay ventas</h2>
						<p>No se ha realizado ninguna venta.</p>
					</div>
				<?php
			}
				?>
				</div>
			</div>

			<br><br><br><br><br><br><br><br><br><br>
	</div>
</div>

<!-- Incluir las bibliotecas de DataTables y Buttons para exportación -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<!-- Inicializar DataTables -->
<script type="text/javascript">
	$(document).ready(function() {
		$('#salesTable').DataTable({
			dom: 'Bfrtip',
			buttons: [{
					extend: 'copyHtml5',
					text: 'Copiar'
				},
				{
					extend: 'excelHtml5',
					text: 'Exportar a Excel',
					exportOptions: {
						columns: [1, 2, 3, 4, 5] // Excluir la columna de Opciones
					}
				},
				{
					extend: 'csvHtml5',
					text: 'Exportar a CSV',
					exportOptions: {
						columns: [1, 2, 3, 4, 5] // Excluir la columna de Opciones
					}
				},
				{
					extend: 'pdfHtml5',
					text: 'Exportar a PDF',
					exportOptions: {
						columns: [1, 2, 3, 4, 5] // Excluir la columna de Opciones
					}
				},
				{
					extend: 'print',
					text: 'Imprimir',
					exportOptions: {
						columns: [1, 2, 3, 4, 5] // Excluir la columna de Opciones
					}
				}
			],
			"language": {
				"url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
			},
			"columnDefs": [{
				"targets": [4], // Columna de "Opciones"
				"visible": true,
				"searchable": false
			}]
		});
	});
</script>