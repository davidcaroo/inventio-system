<div class="row">
	<div class="col-md-12">

		<!-- Single button -->

		<h1><i class='fa fa-archive'></i> Corte de Caja #<?php echo $_GET["id"]; ?></h1>
		<div class="">
			<a href="./index.php?view=boxhistory" class="btn btn-secondary"><i class="fa fa-clock-o"></i> Historial</a>
			<div class="btn-group">
				<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-download"></i> Descargar <span class="caret"></span>
				</button>
				<ul class="dropdown-menu pull-right" role="menu">
					<li><a href="report/box-word.php?id=<?php echo $_GET["id"]; ?>">Word 2007 (.docx)</a></li>
				</ul>
			</div>
		</div>
		<div class="clearfix"></div>
		<br>
		<div class="card">
			<div class="card-header">
				CORTE DE CAJA
			</div>
			<div class="card-body">



				<?php
				$products = SellData::getByBoxId($_GET["id"]);
				if (count($products) > 0) {
					$total_total = 0;
				?>
					<br>
					<table class="table table-bordered table-hover	">
						<thead>
							<th>Detalles</th>
							<th>Total</th>
							<th>Fecha</th>
							<th>Ganancia por venta</th>
						</thead>
						<?php foreach ($products as $sell): ?>

							<tr>
								<td style="width:30px;">
									<a href="./index.php?view=onesell&id=<?php echo $sell->id; ?>" class="btn btn-default btn-SM"><i class="bi bi-eye"></i></a>


									<?php
									$operations = OperationData::getAllProductsBySellId($sell->id);
									?>
								</td>
								<td>

									<?php
									$total = 0;
									foreach ($operations as $operation) {
										$product  = $operation->getProduct();
										$total += $operation->q * $product->price_out;
									}
									$total_total += $total;
									echo "<b>$ " . number_format($total, 2, ".", ",") . "</b>";

									?>

								</td>
								<td><?php echo $sell->created_at; ?></td>
								<td>
									<!-- Calcula la ganancia del día teniendo en cuenta el valor de compra del producto por el valor de venta, por el total de productos vendidos -->
									<?php
									$ganancia = 0;
									foreach ($operations as $operation) {
										$product  = $operation->getProduct();
										$ganancia += $operation->q * ($product->price_out - $product->price_in);
									}
									echo "<b>$ " . number_format($ganancia, 2, ".", ",") . "</b>";

									?>
								</td>

							</tr>

						<?php endforeach; ?>

					</table>
					<h1>Total corte: <?php echo "$ " . number_format($total_total, 2, ".", ","); ?></h1>
					<!-- Imprime la suma total de las ganancias obtenidas por venta para dar la ganancia total del día, al momento del cierre de caja -->
					<h2>Ganancia total día: <?php
											$ganancia_total = 0;
											foreach ($products as $sell) {
												$operations = OperationData::getAllProductsBySellId($sell->id);
												foreach ($operations as $operation) {
													$product  = $operation->getProduct();
													$ganancia_total += $operation->q * ($product->price_out - $product->price_in);
												}
											}
											echo "$ " . number_format($ganancia_total, 2, ".", ",");
											?></h2>

				<?php
				} else {

				?>
					<div class="jumbotron">
						<h2>No hay ventas</h2>
						<p>No se ha realizado ninguna venta.</p>
					</div>

				<?php } ?>
			</div>
		</div>

	</div>
</div>