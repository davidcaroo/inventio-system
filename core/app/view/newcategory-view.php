<div class="row">
  <div class="col-md-12">
    <h1>Nueva Categoria</h1>
    <br>
    <div class="card">
      <div class="card-header">
        NUEVA CATEGORIA
      </div>
      <div class="card-body">


        <form class="form-horizontal" method="post" id="addcategory" action="index.php?view=addcategory" role="form">


          <div class="form-group">
            <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
            <div class="col-md-6">
              <input type="text" name="name" required class="form-control" id="name" placeholder="Nombre">
            </div>
          </div>
          <br>
          <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
              <button type="submit" class="btn btn-primary">Agregar Categoria</button>
            </div>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>