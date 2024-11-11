

<div class="row">
    <div class="col-md-12">
        <h1>Cargar Productos desde Excel</h1>
        <div class="card">
            <div class="card-header">
                Aquí puede cargar productos desde un archivo Excel.
            </div>
            <div class="card-body">

                <!-- Formulario para cargar el archivo Excel -->
                <form class="form-horizontal" method="post" enctype="multipart/form-data" action="index.php?view=manyproducts" role="form">
                    <div class="form-group">
                        <label for="file" class="col-lg-2 control-label">Seleccione el archivo:</label>
                        <div class="col-md-6">
                            <input type="file" name="file" id="file" required class="form-control">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button type="submit" class="btn btn-primary">Cargar Productos</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>