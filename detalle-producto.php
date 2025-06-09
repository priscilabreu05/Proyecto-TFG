<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die('Producto no encontrado.');
}

$stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
$stmt->execute([$id]);
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$producto) {
    die('Producto no encontrado.');
}

// Obtener todos los productos para buscar relacionados
$stmt = $pdo->query("SELECT * FROM productos");
$todos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$tipo_actual = $producto['tipo'];
$relacionados = array_filter($todos, function ($p) use ($tipo_actual, $id) {
    return $p['tipo'] === $tipo_actual && $p['id'] != $id;
});

$esFavorito = in_array($producto['id'], $_SESSION['favoritos'] ?? []);
$imgSrc = $esFavorito
    ? ' http://localhost/tfg-proyecto-final/assets/img/heart-filled.png'
    : ' http://localhost/tfg-proyecto-final/assets/img/heart.png';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $producto['nombre'] ?> | Pam Accessories</title>
    <link rel="stylesheet" href="/tfg-proyecto-final/assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: white;
        }

        .nombre {
            margin: 0;
            font-size: 28px;
            color: #aa4343;
            font-weight: bold;
        }

        .inicio {
            font-weight: bold;
        }

        .favorito-toggle-btn {
            margin-left: 20px;
            padding: 6px;
            margin-bottom: 9px;
            font-size: 16px;
            border-radius: 5px;
        }

        .favorito-toggle-btn img {
            transition: transform 0.2s ease;
        }

        .favorito-toggle-btn:hover img {
            transform: scale(1.1);
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
                <button class="btn btn-link p-0 usuario-boton" title="Iniciar sesión/Registro">
                    <img src="/tfg-proyecto-final/assets/img/user.png" alt="Usuarios" width="24" height="24">
                </button>
                <a href="/tfg-proyecto-final/favoritos.php">
                    <button class="btn btn-link p-0 position-relative" title="Favoritos">
                        <img src="/tfg-proyecto-final/assets/img/heart.png" alt="Favoritos" width="24" height="24">
                        <span id="contadorFavoritos" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?= count($_SESSION['favoritos'] ?? []) ?>
                        </span>
                    </button>
                </a>

                <button id="abrirCarrito" class="btn  p-0 carrito-boton d-flex align-items-center gap-1" title="Carrito">
                    <img src="/tfg-proyecto-final/assets/img/carritocompra.png" alt="Carrito" width="24" height="24">
                    <span id="contadorCarrito" class="badge bg-danger text-white" style="font-size: 0.75rem; display: none;">
                        0
                    </span>
                </button>
            </div>
        </div>
    </header>

    <main class="container py-5">
        <div class="row">
            <div class="col-md-6">
                <img src="/tfg-proyecto-final <?= $producto['imagen'] ?>" class="img-fluid rounded" alt="<?= $producto['nombre'] ?>">
            </div>
            <div class="col-md-6">
                <h2><?= htmlspecialchars($producto['nombre']) ?></h2>
                <p class="text-muted"><?= ucfirst($producto['categoria']) ?></p>
                <p><?= $producto['descripcion_larga'] ?></p>
                <h4 class="text-danger"><?= $producto['precio'] ?> €</h4>
                <button class="btn btn-dark" onclick="agregarAlCarrito(<?= $producto['id'] ?>)">Añadir al carrito</button>
                <a href="#"
                    class="favorito-toggle-btn btn btn-outline-danger btn-sm mt-2"
                    data-id="<?= $producto['id'] ?>"
                    data-favorito="<?= $esFavorito ? '1' : '0' ?>">
                    <img src="<?= $imgSrc ?>" width="20" height="20" class="icon-heart">
                    Añadir a favoritos
                </a>

                <br><br>
                <a href="/tfg-proyecto-final/catalogo.php" class="btn btn-outline-secondary">← Volver al catálogo</a>

            </div>
        </div>
    </main>

    <?php if (!empty($relacionados)): ?>
        <section class="container mt-5">
            <h4 class="mb-4 text-center">💡 Te podría interesar</h4>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                <?php foreach ($relacionados as $rel_id => $rel): ?>
                    <div class="col">
                        <div class="card h-100 text-center">
                            <img src="/tfg-proyecto-final <?= $rel['imagen'] ?>" class="card-img-top" alt="<?= $rel['nombre'] ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= $rel['nombre'] ?></h5>
                                <p class="card-text"><?= $rel['descripcion'] ?></p>
                                <p class="fw-bold"><?= $rel['precio'] ?>€</p>
                                <a href="/tfg-proyecto-finaldetalle-producto.php?id=<?= $rel['id'] ?>" class="btn btn-outline-primary btn-sm">Ver más</a>
                                <button class="btn btn-dark btn-sm btn-agregar-carrito" data-id="<?= $rel['id'] ?>">Agregar al carrito</button>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>


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


    <script src="/tfg-proyecto-final/assets/js/favoritos.js"></script>
    <script src="/tfg-proyecto-final/assets/js/carrito.js"></script>

</body>

</html>