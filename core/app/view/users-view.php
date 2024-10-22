<div class="row">
    <div class="col-md-12">
        <h1>Lista de Usuarios</h1>
        <a href="index.php?view=newuser" class="btn btn-primary"><i class="bi bi-person-plus"></i> Nuevo Usuario</a>
        <br><br>

        <div class="card">
            <div class="card-header">USUARIOS</div>
            <div class="card-body">
                <?php
                $users = UserData::getAll();
                if (count($users) > 0) {
                    // si hay usuarios
                ?>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <th>Nombre completo</th>
                            <th>Nombre de usuario</th>
                            <th>Email</th>
                            <th>Activo</th>
                            <th>Admin</th>
                            <th>Opciones</th>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($users as $user) {
                            ?>
                                <tr>
                                    <td><?php echo $user->name . " " . $user->lastname; ?></td>
                                    <td><?php echo $user->username; ?></td>
                                    <td><?php echo $user->email; ?></td>
                                    <td>
                                        <?php if ($user->is_active): ?>
                                            <i class="bi bi-check2-circle"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($user->is_admin): ?>
                                            <i class="bi bi-check2-circle"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td style="width:150px;">
                                        <a href="index.php?view=edituser&id=<?php echo $user->id; ?>" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <!-- Botón de eliminar -->
                                        <a href="javascript:void(0);" onclick="deleteUser(<?php echo $user->id; ?>);" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                <?php
                } else {
                    echo "<p>No hay usuarios registrados.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    function deleteUser(id) {
        if (confirm("¿Estás seguro de que deseas eliminar este usuario?")) {
            window.location.href = "index.php?action=deleteuser&id=" + id;
        }
    }
</script>
