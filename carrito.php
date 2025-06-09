<?php
session_start();
include 'conexion.php';

$productos = [];
$total = 0;

if (!empty($_SESSION['carrito'])) {
    $ids = implode(',', array_map('intval', array_keys($_SESSION['carrito'])));
    $query = "SELECT * FROM productos WHERE id IN ($ids)";
    $resultado = $conexion->query($query);

    while ($producto = $resultado->fetch_assoc()) {
        $producto['cantidad'] = $_SESSION['carrito'][$producto['id']];
        $producto['subtotal'] = $producto['cantidad'] * $producto['precio'];
        $productos[] = $producto;
        $total += $producto['subtotal'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Carrito de compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .btn-sm {
            width: 32px;
            height: 32px;
            padding: 0;
            font-size: 1rem;
            line-height: 1;
        }
    </style>
</head>

<body>

    <div class="container my-5">
        <h2 class="mb-4">🛒 Tu carrito</h2>

        <?php if (empty($productos)): ?>
            <?php if (isset($_GET['vacio']) && $_GET['vacio'] == '1'): ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    🧺 Tu carrito está vacío.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php endif; ?>

            <a href="/tfg-proyecto-final/catalogo.php" class="btn btn-outline-primary">Volver a comprar</a>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th></th>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $producto): ?>
                            <tr>
                                <td><img src="/tfg-proyecto-final <?= $producto['imagen'] ?>" alt="<?= $producto['nombre'] ?>" style="width: 60px; height: 60px; object-fit: cover;" class="rounded"></td>
                                <td><?= $producto['nombre'] ?></td>
                                <td><?= number_format($producto['precio'], 2) ?> €</td>
                                <td>
                                    <form method="post" action="/tfg-proyecto-final/actualizar-cantidad.php" class="d-flex align-items-center gap-1">
                                        <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                                        <button type="submit" name="accion" value="restar" class="btn btn-outline-secondary btn-sm">-</button>
                                        <span class="px-2"><?= $producto['cantidad'] ?></span>
                                        <button type="submit" name="accion" value="sumar" class="btn btn-outline-secondary btn-sm">+</button>
                                    </form>
                                </td>
                                <td><?= number_format($producto['subtotal'], 2) ?> €</td>
                                <td>
                                    <form method="post" action="/tfg-proyecto-final/eliminar-del-carrito.php" class="d-inline">
                                        <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-danger">🗑️</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-end fw-bold">Total:</td>
                            <td class="fw-bold"><?= number_format($total, 2) ?> €</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="/tfg-proyecto-final/catalogo.php" class="btn btn-outline-secondary">⬅️ Seguir comprando</a>
                <form method="post" action="/tfg-proyecto-final/vaciar-carrito.php">
                    <button type="submit" class="btn btn-outline-danger">Vaciar carrito</button>
                </form>
                <a href="#" class="btn btn-primary">Proceder al pago</a>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>