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
		<h1>Productos</h1>
		<div class="">
			<a href="index.php?view=newproduct" class="btn btn-success"><i class="bi bi-plus-circle"></i>Agregar Producto</a>
			<div class="btn-group pull-right">
				 <a href="index.php?view=importproducts" class="btn btn-primary"><i class="bi bi-folder-plus"></i> Importar Productos</a> 
			</div>
		</div>
		
		<br>

		<div class="card">
			<div class="card-header">
				PRODUCTOS
			</div>
			<div class="card-body">

				<?php
				$page = 1;
				if (isset($_GET["page"])) {
					$page = $_GET["page"];
				}
				$limit = 10;
				if (isset($_GET["limit"]) && $_GET["limit"] != "" && $_GET["limit"] != $limit) {
					$limit = $_GET["limit"];
				}

				$products = ProductData::getAll();
				if (count($products) > 0) {

					if ($page == 1) {
						$curr_products = ProductData::getAllByPage($products[0]->id, $limit);
					} else {
						$curr_products = ProductData::getAllByPage($products[($page - 1) * $limit]->id, $limit);
					}
					$npaginas = floor(count($products) / $limit);
					$spaginas = count($products) % $limit;

					if ($spaginas > 0) {
						$npaginas++;
					}

				?>

					<h3>Pagina <?php echo $page . " de " . $npaginas; ?></h3>
				<!-- 	<div class="btn-group pull-right">
						<?php
						$px = $page - 1;
						if ($px > 0):
						?>
							<a class="btn btn-sm btn-secondary" href="<?php echo "index.php?view=products&limit=$limit&page=" . ($px); ?>"><i class="glyphicon glyphicon-chevron-left" style="margin:5px;"></i> Atras </a> 
						<?php endif; ?>

						<?php
						$px = $page + 1;
						if ($px <= $npaginas):
						?>
							<a class="btn btn-sm btn-secondary" href="<?php echo "index.php?view=products&limit=$limit&page=" . ($px); ?>">Adelante <i class="glyphicon glyphicon-chevron-right"></i></a>
						<?php endif; ?>
					</div> -->
					<div class="clearfix"></div>
					<br>
					<table id="productsTable" class="table table-bordered table-hover">
						<thead>
							<th>Codigo</th>
							<th>Imagen</th>
							<th>Nombre</th>
							<th>Precio Entrada</th>
							<th>Precio Salida</th>
							<th>Categoria</th>
							<th>Minima</th>
							<th>Activo</th>
							<th class="no-export">Opciones</th> <!-- Clase para ocultar en exportaciones -->
						</thead>
						<?php foreach ($curr_products as $product): ?>
							<tr>
								<td><?php echo $product->barcode; ?></td>
								<td>
									<?php if ($product->image != ""): ?>
										<img src="storage/products/<?php echo $product->image; ?>" style="width:64px;">
									<?php endif; ?>
								</td>
								<td><?php echo $product->name; ?></td>
								<td>$ <?php echo number_format($product->price_in, 2, '.', ','); ?></td>
								<td>$ <?php echo number_format($product->price_out, 2, '.', ','); ?></td>
								<td><?php if ($product->category_id != null) {
										echo $product->getCategory()->name;
									} else {
										echo "<center>----</center>";
									}  ?></td>
								<td><?php echo $product->inventary_min; ?></td>
								<td>
									<?php if ($product->is_active): ?>
										<i class="bi bi-check2-circle"></i>
									<?php else: ?>
										No
									<?php endif; ?>
								</td>

								<td style="width:120px;">
									<a href="index.php?view=editproduct&id=<?php echo $product->id; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
									<a href="index.php?view=delproduct&id=<?php echo $product->id; ?>" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
								</td>
							</tr>
						<?php endforeach; ?>
					</table>
					<div class="btn-group pull-right">
						<?php

						for ($i = 0; $i < $npaginas; $i++) {
							echo "<a href='index.php?view=products&limit=$limit&page=" . ($i + 1) . "' class='btn btn-secondary btn-sm'>" . ($i + 1) . "</a> ";
						}
						?>
					</div>
					<form class="form-inline">
						<label for="limit">Limite</label>
						<input type="hidden" name="view" value="products">
						<input type="number" value=<?php echo $limit ?> name="limit" style="width:60px;" class="form-control">
					</form>

					<div class="clearfix"></div>

				<?php
				} else {
				?>
					<div class="jumbotron">
						<h2>No hay productos</h2>
						<p>No se han agregado productos a la base de datos, puedes agregar uno dando click en el boton <b>"Agregar Producto"</b>.</p>
					</div>
				<?php
				}

				?>

			</div>
		</div>

		<br><br><br><br><br><br><br><br><br><br>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('#productsTable').DataTable({
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
							columns: ':not(.no-export)' // Exporta todas menos la columna de opciones
						}
					},
					{
						extend: 'excel',
						exportOptions: {
							columns: ':not(.no-export)' // Exporta todas menos la columna de opciones
						}
					},
					{
						extend: 'pdf',
						exportOptions: {
							columns: ':not(.no-export)' // Exporta todas menos la columna de opciones
						}
					},
					{
						extend: 'print',
						exportOptions: {
							columns: ':not(.no-export)' // Exporta todas menos la columna de opciones
						}
					}
				]
			}, ],
			"columns": [{
					"data": "barcode"
				},
				{
					"data": "image"
				},
				{
					"data": "name"
				},
				{
					"data": "price_in"
				},
				{
					"data": "price_out"
				},
				{
					"data": "category"
				},
				{
					"data": "inventary_min"
				},
				{
					"data": "is_active"
				},
				{
					"data": "options"
				}
			]
		});
	});
</script>