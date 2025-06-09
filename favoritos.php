<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'conexion.php';

$favoritos = $_SESSION['favoritos'] ?? [];
$productos = [];

if (!empty($favoritos)) {
    $ids = implode(',', array_map('intval', $favoritos));
    $query = "SELECT * FROM productos WHERE id IN ($ids)";
    $resultado = $conexion->query($query);
    if ($resultado && $resultado->num_rows > 0) {
        $productos = $resultado->fetch_all(MYSQLI_ASSOC);
    }
}

// Si se solicita JSON (JS lo usa)
if (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) {
    header('Content-Type: application/json');
    echo json_encode($productos);
    exit;
}
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mis Favoritos | Pam Accessories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/tfg-proyecto-final/assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .nombre {
            margin: 0;
            font-size: 28px;
            color: #aa4343;
            font-weight: bold;
        }

        .inicio {
            font-weight: bold;
        }

        .catalogo {
            font-weight: bold;
        }

        .favoritos-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .favoritos-card img {
            height: 200px;
            object-fit: cover;
        }

        #contadorCarrito {
            text-decoration: none;
            outline: none;
        }

        .carrito-boton:focus,
        .carrito-boton:active {
            outline: none;
            box-shadow: none;
        }
    </style>
</head>

<body>

    <header class="encabezado py-3">
        <div class="container-fluid d-flex justify-content-between align-items-center px-3">

            <!--Logo + nombre-->
            <div class="d-flex align-items-center" style="margin-left: 3px;">
                <a href="/tfg-proyecto-final/index.php" class="d-flex align-items-center text-decoration-none">
                    <img src="/tfg-proyecto-final/assets/img/logo-tfg-removebg-preview.png" width="80" height="40" alt="Logo">
                    <h1 class="h5 ms-2 mb-0 nombre">Pam Accessories</h1>
                </a>
            </div>

            <!-- Iconos-->
            <div class="d-flex align-items-center" style="gap: 30px; margin-right: 3px;">
                <a href="/tfg-proyecto-final/index.php" class="text-dark text-decoration-none inicio">Inicio</a>
                <a href="/tfg-proyecto-final/catalogo.php" class="text-dark text-decoration-none catalogo">Catálogo</a>
                <button class="btn btn-link p-0 usuario-boton" title="Iniciar sesión/Registro">
                    <img src="/tfg-proyecto-final/assets/img/user.png" alt="Usuarios" width="24" height="24">
                </button>
                <button id="abrirCarrito" class="btn  p-0 carrito-boton d-flex align-items-center gap-1" title="Carrito">
                    <img src="/tfg-proyecto-final/assets/img/carritocompra.png" alt="Carrito" width="24" height="24">
                    <span id="contadorCarrito" class="badge bg-danger text-white" style="font-size: 0.75rem; display: none;">
                        0
                    </span>
                </button>
            </div>
        </div>
    </header>

    <!-- Panel lateral del carrito -->
    <div id="carritoPanel" class="carrito-offcanvas">
        <div class="carrito-header">
            <h5 class="mb-0">🛒 Tu carrito</h5>
            <button id="cerrarCarrito" class="btn-close"></button>
        </div>
        <div class="carrito-body" id="contenedorCarrito">
            <?php include __DIR__ . '/carrito-contenido.php'; ?>
        </div>
    </div>

    <div class="container py-5">
        <div class="favoritos-header mb-4">
            <h2>💖 Mis favoritos</h2>
            <?php if (!empty($favoritos)): ?>
                <form action="/tfg-proyecto-final/vaciar-favoritos.php" method="post">
                    <button type="submit" class="btn btn-outline-danger btn-sm">Eliminar todos</button>
                </form>
            <?php endif; ?>
        </div>

        <?php if (empty($favoritos)): ?>
            <div class="alert alert-info">No tienes productos en favoritos.</div>
        <?php else: ?>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                <?php foreach ($productos as $producto): ?>
                    <div class="col">
                        <div class="card favoritos-card h-100 text-center">
                            <img src="/tfg-proyecto-final<?= $producto['imagen'] ?>" class="card-img-top" alt="<?= $producto['nombre'] ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= $producto['nombre'] ?></h5>
                                <p class="card-text"><?= $producto['descripcion'] ?></p>
                                <p class="fw-bold"><?= $producto['precio'] ?>€</p>
                                <a href="/tfg-proyecto-final/detalle-producto.php?id=<?= $producto['id'] ?>" class="btn btn-outline-primary btn-sm mb-2">Ver más</a>
                                <form action="/tfg-proyecto-final/eliminar-favorito.php" method="post">
                                    <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <footer class="footer">
        <div class="footer-contenido">
            <div class="footer-enlaces">
                <a href="/tfg-proyecto-final/blog-inspiracion.html">Blog / Inspiración</a>
                <a href="/tfg-proyecto-final/sobre-nosotros.php">Sobre Nosotros</a>
                <a href="/tfg-proyecto-final/contacto.php">Contacto</a>
                <a href="/tfg-proyecto-final/politica-privacidad.php">Política de Privacidad</a>
                <a href="/tfg-proyecto-final/terminos-condiciones.php">Términos y Condiciones</a>
            </div>
            <div class="footer-redes">
                <p>Síguenos:</p>
                <a href="#" target="_blank">Instagram</a>
                <a href="#" target="_blank">TikTok</a>
                <a href="#" target="_blank">Pinterest</a>
            </div>
            <p class="footer-copy">© 2025 Pam Accessories. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="/tfg-proyecto-final/assets/js/carrito.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>