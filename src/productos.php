<?php
session_start();
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "productos";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header('Location: permisos.php');
}
if (!empty($_POST)) {
    $alert = "";
    $id = $_POST['id'];
    $id_zapato = $_POST['id_zapato'];
    $producto = $_POST['producto'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $tipo = $_POST['tipo'];
    $presentacion = $_POST['presentacion'];
    $laboratorio = $_POST['laboratorio'];
    $estiloo = $_POST['estiloo'];
    $id_proveedor = $_POST['id_proveedor'];
    $color = $_POST['color'];
    $id_venta = $_POST['id_venta'];
    $vencimiento = '';
    if (!empty($_POST['accion'])) {
        $vencimiento = $_POST['vencimiento'];
    }
    if (empty($id_zapato) || empty($producto) || empty($tipo) || empty($presentacion) || empty($laboratorio)  || empty($precio) || $precio <  0 || empty($cantidad) || $cantidad <  0) {
        $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Todo los campos son obligatorios
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
    } else {
        if (empty($id)) {
            $query = mysqli_query($conexion, "SELECT * FROM producto WHERE id_zapato = '$id_zapato'");
            $result = mysqli_fetch_array($query);
            if ($result > 0) {
                $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        El codigo ya existe
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            } else {
                $query_insert = mysqli_query($conexion, "INSERT INTO producto(id_zapato,descripcion,precio,existencia,id_lab,id_presentacion,id_tipo,estiloo,color,id_proveedor,id_venta,vencimiento) values ('$id_zapato', '$producto', '$precio', '$cantidad', $laboratorio, $presentacion, $tipo,'$estiloo','$color','$id_proveedor','$id_venta','vencimiento')");
                if ($query_insert) {
                    $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Producto registrado
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                } else {
                    $alert = '<div class="alert alert-danger" role="alert">
                    Error al registrar el producto
                  </div>';
                }
            }
        } else {
            $query_update = mysqli_query($conexion, "UPDATE producto SET id_zapato = '$id_zapato', descripcion = '$producto', precio= $precio, existencia = $cantidad, id_lab='$laboratorio', id_presentacion='$presentacion', id_tipo='$tipo', estiloo='$estiloo', color='$color',id_proveedor='$id_proveedor',id_venta='$id_venta', vencimiento = '$vencimiento' WHERE codproducto = $id");
            if ($query_update) {
                $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Producto Modificado
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            } else {
                $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Error al modificar
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            }
        }
    }
}
include_once "includes/header.php";
?>
<div class="card shadow-lg">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        Productos
                    </div>
                    <div class="card-body">
                        <form action="" method="post" autocomplete="off" id="formulario">
                            <?php echo isset($alert) ? $alert : ''; ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="id_zapato" class=" text-dark font-weight-bold"><i class="fas fa-barcode"></i> id_zapato </label>
                                        <input type="text" placeholder="Ingrese id_zapato" name="id_zapato" id="id_zapato" class="form-control">
                                        <input type="hidden" id="id" name="id">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="producto" class=" text-dark font-weight-bold">Producto</label>
                                        <input type="text" placeholder="Ingrese nombre del producto" name="producto" id="producto" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="precio" class=" text-dark font-weight-bold">Precio</label>
                                        <input type="text" placeholder="Ingrese precio" class="form-control" name="precio" id="precio">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="cantidad" class=" text-dark font-weight-bold">Cantidad</label>
                                        <input type="number" placeholder="Ingrese cantidad" class="form-control" name="cantidad" id="cantidad">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="estiloo" class=" text-dark font-weight-bold">estiloo</label>
                                        <input type="text" placeholder="Ingrese estiloo" class="form-control" name="estiloo" id="estiloo">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="color" class=" text-dark font-weight-bold">Color</label>
                                        <input type="text" placeholder="Ingrese color" class="form-control" name="color" id="color">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="id_proveedor" class=" text-dark font-weight-bold">id_proveedor</label>
                                        <input type="text" placeholder="Ingrese id" class="form-control" name="id_proveedor" id="id_proveedor">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="id_venta" class=" text-dark font-weight-bold">id_venta</label>
                                        <input type="text" placeholder="Ingrese id" class="form-control" name="id_venta" id="id_venta">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="tipo">talla</label>
                                        <select id="tipo" class="form-control" name="tipo" required>
                                            <?php
                                            $query_tipo = mysqli_query($conexion, "SELECT * FROM categorias");
                                            while ($datos = mysqli_fetch_assoc($query_tipo)) { ?>
                                                <option value="<?php echo $datos['id'] ?>"><?php echo $datos['talla'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="presentacion">Modelo</label>
                                        <select id="presentacion" class="form-control" name="presentacion" required>
                                            <?php
                                            $query_pre = mysqli_query($conexion, "SELECT * FROM modelo");
                                            while ($datos = mysqli_fetch_assoc($query_pre)) { ?>
                                                <option value="<?php echo $datos['id'] ?>"><?php echo $datos['nombre'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="laboratorio">Accesorios</label>
                                        <select id="laboratorio" class="form-control" name="laboratorio" required>
                                            <?php
                                            $query_lab = mysqli_query($conexion, "SELECT * FROM accesorios");
                                            while ($datos = mysqli_fetch_assoc($query_lab)) { ?>
                                                <option value="<?php echo $datos['id'] ?>"><?php echo $datos['nombre'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <input type="submit" value="Registrar" class="btn btn-primary" id="btnAccion">
                                    <input type="button" value="Nuevo" onclick="limpiar()" class="btn btn-success" id="btnNuevo">
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="tbl">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>id_zapato</th>
                            <th>descripcion</th>
                            <th>estiloo</th>
                            <th>Color</th>
                            <th>id_proveedor</th>
                            <th>talla</th>
                            <th>id_venta</th>
                            <th>Modelo</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "../conexion.php";

                        $query = mysqli_query($conexion, "SELECT p.*, t.id, t.talla, pr.id, pr.nombre FROM producto p INNER JOIN categorias t ON p.id_tipo = t.id INNER JOIN modelo pr ON p.id_presentacion = pr.id");
                        $result = mysqli_num_rows($query);
                        if ($result > 0) {
                            while ($data = mysqli_fetch_assoc($query)) { ?>
                                <tr>
                                    <td><?php echo $data['codproducto']; ?></td>
                                    <td><?php echo $data['id_zapato']; ?></td>
                                    <td><?php echo $data['descripcion']; ?></td>
                                    <td><?php echo $data['estiloo']; ?></td>
                                    <td><?php echo $data['color']; ?></td>
                                    <td><?php echo $data['id_proveedor']; ?></td>
                                    <td><?php echo $data['talla']; ?></td>
                                    <td><?php echo $data['id_venta']; ?></td>
                                    <td><?php echo $data['nombre']; ?></td>
                                    <td><?php echo $data['precio']; ?></td>
                                    <td><?php echo $data['existencia']; ?></td>
                                    <td>
                                        <a href="#" onclick="editarProducto(<?php echo $data['codproducto']; ?>)" class="btn btn-primary"><i class='fas fa-edit'></i></a>

                                        <form action="eliminar_producto.php?id=<?php echo $data['codproducto']; ?>" method="post" class="confirmar d-inline">
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
<?php include_once "includes/footer.php"; ?>