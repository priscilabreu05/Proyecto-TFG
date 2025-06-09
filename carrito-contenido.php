<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'conexion.php';

if (empty($_SESSION['carrito'])) {
    echo '<div class="alert alert-info">🧺 Tu carrito está vacío.</div>';
    return;
}


$ids = array_keys($_SESSION['carrito']);
$ids_string = implode(',', array_map('intval', $ids));

$query = "SELECT * FROM productos WHERE id IN ($ids_string)";
$resultado = $conexion->query($query);

$total = 0;

?>
<div class="carrito-productos">
    <?php while ($producto = $resultado->fetch_assoc()):
        $cantidad = $_SESSION['carrito'][$producto['id']];
        $subtotal = $producto['precio'] * $cantidad;
        $total += $subtotal;
    ?>
        <div class="d-flex mb-3 align-items-center">
            <img src="/tfg-proyecto-final <?= $producto['imagen'] ?>" alt="<?= $producto['nombre'] ?>" style="width: 100px; height: 100px; object-fit: cover;" class="me-2 rounded">
            <div>
                <strong><?= $producto['nombre'] ?></strong><br>
                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-sm btn-outline-secondary" onclick="modificarCantidad(<?= $producto['id'] ?>, -1)">-</button>
                    <span><?= $cantidad ?></span>
                    <button class="btn btn-sm btn-outline-secondary" onclick="modificarCantidad(<?= $producto['id'] ?>, 1)">+</button>
                </div>
                <small><?= $cantidad ?> x <?= $producto['precio'] ?>€ = <?= $subtotal ?>€</small>

            </div>
        </div>
    <?php endwhile; ?>

    <hr>
    <h5>Total: <?= $total ?>€</h5>
    <button id="vaciarBtn" class="btn btn-danger btn-sm mt-2">Vaciar carrito</button>

    <div id="mensajeCarritoVacio" class="mt-2 text-muted" style="display: none;">El carrito está vacío.</div>
    <a href="/tfg-proyecto-final/carrito.php" class="btn btn-dark btn-sm mt-2">Ver carrito completo</a>
</div>

