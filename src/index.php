<?php
require "../conexion.php";
$usuarios = mysqli_query($conexion, "SELECT * FROM usuario");
$total['usuarios'] = mysqli_num_rows($usuarios);
$clientes = mysqli_query($conexion, "SELECT * FROM cliente");
$total['clientes'] = mysqli_num_rows($clientes);
$productos = mysqli_query($conexion, "SELECT * FROM producto");
$total['productos'] = mysqli_num_rows($productos);
$ventas = mysqli_query($conexion, "SELECT * FROM ventas WHERE fecha > CURDATE()");
$total['ventas'] = mysqli_num_rows($ventas);
session_start();
include_once "includes/header.php";
?>
<!-- Content Row -->
<div class="row">
    

    <div class="card">
        <div class="card-header">
            Bienvenido a la zapatería IkerSneackers
        </div>
        <div class="card-body">
            
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header card-header-primary">
                <h3 class="title-2 m-b-40">Producto mas Popular</h3>
            </div>
            <div class="card-body">
                <canvas id="ProductosVendidos"></canvas>
            </div>
        </div>
    </div>
</div>

<?php include_once "includes/footer.php"; ?>
