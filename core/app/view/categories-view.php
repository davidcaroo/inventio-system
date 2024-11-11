<div class="row">
	<div class="col-md-12">
		<h1>Categorias</h1>
		<div class="">
			<a href="index.php?view=newcategory" class="btn btn-success"><i class='fa fa-th-list'></i> Nueva Categoria</a>
		</div>
		<br>
		<div class="card">
			<div class="card-header">
				CATEGORIAS
			</div>
			<div class="card-body">

				<?php
				$users = CategoryData::getAll();
				if (count($users) > 0) {
					// si hay usuarios
				?>

					<table class="table table-bordered table-hover">
						<thead>
							<th>Nombre</th>
							<th>Opciones</th>
						</thead>
						<?php
						foreach ($users as $user) {
						?>
							<tr>
								<td><?php echo $user->name; ?></td>

								<td style="width:130px;">
									<a href="index.php?view=editcategory&id=<?php echo $user->id; ?>" class="btn btn-warning btn-xs btn-sm" title="Editar">
										<i class="bi bi-pencil"></i>
									</a>
									<a href="index.php?view=delcategory&id=<?php echo $user->id; ?>" class="btn btn-danger btn-xs btn-sm" title="Eliminar">
										<i class="bi bi-trash"></i>
									</a>
								</td>
							</tr>
						<?php
						}
						echo "</table>";
					} else {
						echo "<p class='alert alert-danger'>No hay Categorias</p>";
					}
				?>
			</div>
		</div>
	</div>
</div>
