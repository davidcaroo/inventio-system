<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>

<style>
	.only-pdf {
		display: none;
		/* Oculto en la vista normal */
	}
</style>



<h1>Resumen de Venta</h1>

<a href="index.php?view=sells" class="btn btn-primary"><i class="bi bi-arrow-bar-left"></i> Regresar</a><br><br>
<!-- window print -->
<a id="downloadPDF" class="btn btn-primary"><i class="bi bi-printer"></i> Imprimir factura</a><br><br>

<?php if (isset($_GET['id']) && $_GET['id'] != ''): ?>
	<?php
	$sell = SellData::getById($_GET['id']);
	$operations = OperationData::getAllProductsBySellId($_GET['id']);
	$total = 0;
	?>

	<?php if (isset($_COOKIE['selled'])): ?>
		<?php foreach ($operations as $operation): ?>
			<?php
			$qx = OperationData::getQYesF($operation->product_id);
			$p = $operation->getProduct();
			if ($qx == 0) {
				echo "<p class='alert alert-danger'>El producto <b style='text-transform:uppercase;'>$p->name</b> no tiene existencias en inventario.</p>";
			} elseif ($qx <= $p->inventary_min / 2) {
				echo "<p class='alert alert-danger'>El producto <b style='text-transform:uppercase;'>$p->name</b> tiene muy pocas existencias en inventario.</p>";
			} elseif ($qx <= $p->inventary_min) {
				echo "<p class='alert alert-warning'>El producto <b style='text-transform:uppercase;'>$p->name</b> tiene pocas existencias en inventario.</p>";
			}
			?>
		<?php endforeach; ?>
		<?php setcookie("selled", "", time() - 18600); ?>
	<?php endif; ?>
	<div class="container-to-print"> 
		<!-- Campos de la empresa y que esten centrados -->
		<div class="text-center only-pdf">
			<h3><i class="bi bi-cart4"></i> DISTRICOLOMBIA </h3>
			<p><i class="bi bi-instagram"></i> Instagram: @districolombia</p>
			<p><i class="bi bi-whatsapp"></i> 3207618561</p>
			<p><i class="bi bi-globe"></i> districolombia.shop</p>
		</div>
		<div class="card">
			<div class="card-body">
				<table class="table table-bordered">
					<?php if ($sell->person_id != ''):
						$client = $sell->getPerson();
					?>
						<tr>
							<td style="width:150px;">Cliente: </td>
							<td><?php echo $client->name . " " . $client->lastname; ?></td>
						</tr>
					<?php endif; ?>
					<?php if ($sell->user_id != ''):
						$user = $sell->getUser();
					?>
						<tr>
							<td>Atendido por: </td>
							<td><?php echo $user->name . " " . $user->lastname; ?></td>
						</tr>
					<?php endif; ?>
				</table>
				<br>
				<table id="operationsTable" class="table table-bordered table-hover">
					<thead>
						<tr>
							<!-- 	<th>Código</th> -->
							<th>Cantidad</th>
							<th>Nombre del Producto</th>
							<th>Precio Unitario</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($operations as $operation):
							$product = $operation->getProduct();
						?>
							<tr>
								<!-- <td><?php echo $product->id; ?></td> -->
								<td><?php echo $operation->q; ?></td>
								<td><?php echo $product->name; ?></td>
								<td>$ <?php echo number_format($product->price_out, 2, ".", ","); ?></td>
								<td>$ <?php echo number_format($operation->q * $product->price_out, 2, ".", ","); ?></b></td>
							</tr>
						<?php
							$total += $operation->q * $product->price_out;
						endforeach; ?>
					</tbody>
				</table>
				<br><br>
				<div class="row">
					<div class="col-md-4">
						<table class="table table-bordered">
							<tr>
								<td>
									<h4>Dto. revendedor:</h4>
								</td>
								<td>
									<?php if ($sell->discount == 0): ?>
										<h4>No aplica</h4>
									<?php else: ?>
										<h4>$ <?php echo number_format($sell->discount, 2, ".", ","); ?> </h4>
									<?php endif; ?>
								</td>
							</tr>
							<tr>
								<td>
									<h4>Total:</h4>
								</td>
								<td>
									<h4>$ <?php echo number_format($total - $sell->discount, 2, ".", ","); ?></h4>
								</td>
							</tr>
							<td>
								<h4>Tipo de venta:</h4>
							</td>
							<td>
								<?php if ($sell->note == ""): ?>
									<h4>De contado</h4>
								<?php elseif (strtolower($sell->note) == "credito"): ?>
									<h4>A crédito</h4>
								<?php else: ?>
									<h4><?php echo htmlspecialchars($sell->note); ?></h4>
								<?php endif; ?>
							</td>
						</table>
					</div>
				</div>
			</div>
		</div>




	<?php else: ?>
		<div class="jumbotron">
			<h2>No se ha seleccionado una venta</h2>
			<p>Por favor, seleccione una venta para ver su resumen.</p>
		</div>
	<?php endif; ?>
	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script>
		document.getElementById("downloadPDF").addEventListener("click", function() {
			// Seleccionamos el contenido del div que queremos convertir en PDF
			const content = document.querySelector(".container-to-print");

			// Mostrar los elementos "only-pdf" antes de capturar el contenido
			document.querySelectorAll(".only-pdf").forEach(el => el.style.display = "block");

			// Usamos html2canvas para capturar el contenido
			html2canvas(content, {
				scale: 2
			}).then((canvas) => {
				const imgData = canvas.toDataURL("image/png"); // Convertimos el canvas a imagen

				// Creamos el documento PDF
				const {
					jsPDF
				} = window.jspdf;
				const pdf = new jsPDF("p", "mm", "a4"); // Formato A4 en milímetros

				// Calculamos las dimensiones de la imagen para que quepa en el PDF
				const pdfWidth = pdf.internal.pageSize.getWidth();
				const pdfHeight = (canvas.height * pdfWidth) / canvas.width;

				// Añadimos la imagen al PDF
				pdf.addImage(imgData, "PNG", 0, 0, pdfWidth, pdfHeight);

				// Guardamos el PDF con el nombre deseado
				pdf.save("Resumen_de_Venta.pdf");

				// Ocultar los elementos "only-pdf" después de capturar el contenido
				document.querySelectorAll(".only-pdf").forEach(el => el.style.display = "none");
			});
		});
	</script>


	<!-- DataTables CSS -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">

	<!-- DataTables and Buttons JS -->
	<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.flash.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>