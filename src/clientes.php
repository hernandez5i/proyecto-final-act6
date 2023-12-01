<?php
session_start();
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "clientes";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header('Location: permisos.php');
}

if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['nombre']) || empty($_POST['telefono']) || empty($_POST['direccion'])) {
        $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Todo los campos son obligatorio
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
    } else {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $estilo = $_POST['estilo'];
        $id_venta = $_POST['id_venta'];
        $id_zapatoo = $_POST['id_zapatoo'];
        $correo = $_POST['correo'];
        $result = 0;
        if (empty($id)) {
            $query = mysqli_query($conexion, "SELECT * FROM cliente WHERE nombre = '$nombre'");
            $result = mysqli_fetch_array($query);
            if ($result > 0) {
                $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        El cliente ya existe
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            } else {
                $query_insert = mysqli_query($conexion, "INSERT INTO cliente(nombre,telefono,direccion,estilo,id_venta,id_zapatoo,correo) values ('$nombre', '$telefono', '$direccion', '$estilo', '$id_venta', '$id_zapatoo', '$correo')");
                if ($query_insert) {
                    $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Cliente registrado
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                } else {
                    $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Error al registrar
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                }
            }
        }else{
            $sql_update = mysqli_query($conexion, "UPDATE cliente SET nombre = '$nombre' , telefono = '$telefono', direccion = '$direccion', estilo = '$estilo', id_venta = '$id_venta', id_zapatoo = '$id_zapatoo', correo = '$correo' WHERE idcliente = $id");
            if ($sql_update) {
                $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Cliente Modificado
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            } else {
                $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Error al modificar
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            }
        }
    }
    mysqli_close($conexion);
}
include_once "includes/header.php";
?>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <?php echo (isset($alert)) ? $alert : '' ; ?>
                <form action="" method="post" autocomplete="off" id="formulario">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nombre" class="text-dark font-weight-bold">Nombre</label>
                                <input type="text" placeholder="Ingrese Nombre" name="nombre" id="nombre" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="telefono" class="text-dark font-weight-bold">Teléfono</label>
                                <input type="number" placeholder="Ingrese Teléfono" name="telefono" id="telefono" class="form-control">
                                <input type="hidden" name="id" id="id">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="direccion" class="text-dark font-weight-bold">Dirección</label>
                                <input type="text" placeholder="Ingrese Direccion" name="direccion" id="direccion" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="estilo" class="text-dark font-weight-bold">estilo</label>
                                <input type="text" placeholder="Ingrese estilo" name="estilo" id="estilo" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="id_venta" class="text-dark font-weight-bold">id_venta</label>
                                <input type="text" placeholder="Ingrese id_venta" name="id_venta" id="id_venta" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="id_zapatoo" class="text-dark font-weight-bold">id_zapatoo</label>
                                <input type="text" placeholder="Ingrese id_zapatoo" name="id_zapatoo" id="id_zapatoo" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="correo" class="text-dark font-weight-bold">Correo</label>
                                <input type="email" placeholder="Ingrese Correo" name="correo" id="correo" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <input type="submit" value="Registrar" class="btn btn-primary" id="btnAccion">
                            <input type="button" value="Nuevo" class="btn btn-success" id="btnNuevo" onclick="limpiar()">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="tbl">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th>estilo</th>
                                <th>id_venta</th>
                                <th>id_zapatoo</th>
                                <th>Correo</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "../conexion.php";

                            $query = mysqli_query($conexion, "SELECT * FROM cliente");
                            $result = mysqli_num_rows($query);
                            if ($result > 0) {
                                while ($data = mysqli_fetch_assoc($query)) { ?>
                                    <tr>
                                        <td><?php echo $data['idcliente']; ?></td>
                                        <td><?php echo $data['nombre']; ?></td>
                                        <td><?php echo $data['telefono']; ?></td>
                                        <td><?php echo $data['direccion']; ?></td>
                                        <td><?php echo $data['estilo']; ?></td>
                                        <td><?php echo $data['id_venta']; ?></td>
                                        <td><?php echo $data['id_zapatoo']; ?></td>
                                        <td><?php echo $data['correo']; ?></td>
                                        <td>
                                            <a href="#" onclick="editarCliente(<?php echo $data['idcliente']; ?>)" class="btn btn-primary"><i class='fas fa-edit'></i></a>
                                            <form action="eliminar_cliente.php?id=<?php echo $data['idcliente']; ?>" method="post" class="confirmar d-inline">
                                                <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
                                            </form>
                                        </td>
                                    </tr>
                            <?php }
                            } ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once "includes/footer.php"; ?>