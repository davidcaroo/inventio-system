<?php $user = UserData::getById($_GET["id"]); ?>
<div class="row">
  <div class="col-md-12">
    <h1>Editar Usuario</h1>
    <br>
    <div class="card">
      <div class="card-header">EDITAR USUARIO</div>
      <div class="card-body">
        <form class="form-horizontal" method="post" id="addproduct" action="index.php?view=updateuser" role="form">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="name" class="control-label">Nombre*</label>
                <input type="text" name="name" value="<?php echo $user->name; ?>" class="form-control" id="name" placeholder="Nombre" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="lastname" class="control-label">Apellido*</label>
                <input type="text" name="lastname" value="<?php echo $user->lastname; ?>" class="form-control" id="lastname" placeholder="Apellido" required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="username" class="control-label">Nombre de usuario*</label>
                <input type="text" name="username" value="<?php echo $user->username; ?>" class="form-control" id="username" placeholder="Nombre de usuario" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="email" class="control-label">Email*</label>
                <input type="email" name="email" value="<?php echo $user->email; ?>" class="form-control" id="email" placeholder="Email" required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="password" class="control-label">Contrase&ntilde;a</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Contrase&ntilde;a">
                <small class="text-muted">La contrase&ntilde;a solo se modificara si escribes algo, en caso contrario no se modifica.</small>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="is_active" id="is_active" <?php echo ($user->is_active) ? "checked" : ""; ?>>
                  <label class="form-check-label" for="is_active">Está activo</label>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="is_admin" id="is_admin" <?php echo ($user->is_admin) ? "checked" : ""; ?>>
                  <label class="form-check-label" for="is_admin">Es administrador</label>
                </div>
              </div>
            </div>
          </div>

          <p class="alert alert-info">*Campos obligatorios</p>

          <div class="form-group">
            <div class="col-lg-12 text-right">
              <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
              <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>