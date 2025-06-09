<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
$usuario = $_SESSION['usuario'] ?? null;
require 'db.php';

$stmt = $pdo->query("SELECT * FROM productos WHERE novedad = 1");
$novedades = $stmt->fetchAll(PDO::FETCH_ASSOC);

$nombre = isset($_GET['nombre']) ? htmlspecialchars($_GET['nombre']) : null;
?>


<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inicio | Pam Accessories</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/tfg-proyecto-final/assets/css/style.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
  <script src="/assets/js/main.js" defer></script>

  <style>
    .portada {
      background-image: url('/tfg-proyecto-final/assets/img/portada.jpg');
      background-size: cover;
      background-position: center;
      height: 90vh;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      color: white;
      position: relative;
    }

    .portada h2 {
      font-size: 3rem;
      font-weight: bold;
    }

    .portada p {
      font-size: 1.2rem;
    }

    .overlay {
      position: absolute;
      inset: 0;
      background-color: rgba(0, 0, 0, 0.4);
    }

    .portada-contenido {
      z-index: 1;
    }

    .novedades-titulo {
      margin-top: 3rem;
      margin-bottom: 1rem;
    }

    .card-horizontal {
      display: flex;
      flex-direction: row;
      gap: 1rem;
    }

    .card-horizontal img {
      width: 150px;
      object-fit: cover;
    }

    .carousel-control-prev,
    .carousel-control-next {
      width: 50px;
      height: 50px;
      top: 50%;
      transform: translateY(-50%);
      background-color: rgba(255, 255, 255, 0.4);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
      filter: invert(1);
      width: 20px;
      height: 20px;
    }

    .catalogo {
      font-weight: bold;
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

    .dropdown-menu li {
      font-size: 14px;
      margin-bottom: 4px;
    }

    #userDropdown {
      left: 50% !important;
      transform: translateX(-50%) !important;
      background-color: #ffdbd3;
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

      <!-- Barra de búsqueda-->
      <form action="/tfg-proyecto-final/catalogo.php" method="GET" class="d-flex w-50" style="max-width: 500px;">
        <input class="form-control me-2 busqueda" type="search" placeholder="Buscar accesorios..." name="buscar" aria-label="Buscar">
        <button class="lupa" type="submit">
          <img src="/tfg-proyecto-final/assets/img/search.png" alt="Buscar" width="16" height="16">
        </button>
      </form>

      <!-- Iconos-->
      <div class="d-flex align-items-center" style="gap: 30px; margin-right: 3px;">
        <a href="/tfg-proyecto-final/catalogo.php" class="text-dark text-decoration-none catalogo">Catálogo</a>

        <!-- Usuario logueado -->
        <?php if ($usuario): ?>
          <div id="userMenu" class="dropdown">
            <button class="btn btn-link-black p-0 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="/tfg-proyecto-final/assets/img/user.png" alt="Mi Cuenta" width="24" height="24">
            </button>
            <ul id="userDropdown" class="dropdown-menu p-3 shadow" style="min-width: 250px;">
              <h4 style="text-align: center;">Mi Cuenta</h4>
              <li><strong>Nombre:</strong> <?= htmlspecialchars($usuario['nombre']) ?></li>
              <li><strong>Email:</strong> <?= htmlspecialchars($usuario['email']) ?></li>
              <li><strong>Teléfono:</strong> <?= htmlspecialchars($usuario['telefono'] ?? 'No disponible') ?></li>
              <li><strong>Registro:</strong> <?= date("F Y", strtotime($usuario['creado_en'])) ?></li>
              <li class="mt-2">
                <form id="logoutForm" action="/tfg-proyecto-final/logout.php" method="post">
                  <button type="submit" class="btn btn-danger btn-sm w-100">Cerrar sesión</button>
                </form>
              </li>
            </ul>
          </div>
        <?php else: ?>
          <!-- No logueado -->
          <a id="userMenu" href="http://localhost:3000/login" title="Iniciar sesión">
            <img src="/tfg-proyecto-final/assets/img/user.png" alt="Iniciar sesión" width="24" height="24">
          </a>
        <?php endif; ?>

        <!--
            <a href="http://localhost:3000/login">
              <button class="btn btn-link p-0 usuario-boton" title="Iniciar sesión/Registro">
                <img src="/tfg-proyecto-final/assets/img/user.png" alt="Usuarios" width="24" height="24">
              </button>
            </a>
          -->

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



  <section class="portada position-relative">
    <div class="overlay"></div>
    <div class="portada-contenido">
      <?php if ($nombre): ?>
        <h1>Bienvenido/a, <?php echo $nombre; ?>!</h1>
      <?php endif; ?>

      <h2>Accesorios con estilo, para todos</h2>
      <p>Diseños únicos y de calidad que elevan tu look en cada ocasión. ¡Descubre nuestras nuevas colecciones!</p>
    </div>
  </section>

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

  <!-- Novedades -->
  <section class="container mt-5">
    <h3 class="text-center novedades-titulo">✨ Novedades</h3>

    <div id="novedadesCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">

        <?php foreach (array_chunk($novedades, 2) as $index => $grupo): ?>
          <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
            <div class="d-flex justify-content-center gap-4 flex-wrap">
              <?php foreach ($grupo as $producto): ?>
                <div class="card card-horizontal">
                  <img src="/tfg-proyecto-final <?= $producto['imagen'] ?>" class="img-fluid" alt="<?= htmlspecialchars($producto['nombre']) ?>">
                  <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($producto['nombre']) ?></h5>
                    <p class="card-text"><?= htmlspecialchars($producto['descripcion'] ?? 'Descubre nuestra última creación.') ?></p>
                    <a href="/tfg-proyecto-final/detalle-producto.php?id=<?= $producto['id'] ?>" class="btn btn-outline-primary btn-sm">Ver más</a>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endforeach; ?>

      </div>

      <button class="carousel-control-prev" type="button" data-bs-target="#novedadesCarousel" data-bs-slide="prev" style="left: -130px;">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#novedadesCarousel" data-bs-slide="next" style="right: -130px;">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Siguiente</span>
      </button>
    </div>
  </section>


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
  <script>
    const logoutForm = document.getElementById('logoutForm');
    if (logoutForm) {
      logoutForm.addEventListener('submit', function() {
        localStorage.removeItem('usuario'); // Limpiar localStorage en logout
      });
    }

    const userMenu = document.getElementById('userMenu');
    const dropdown = document.getElementById('userDropdown');

    if (userMenu && dropdown) {
      userMenu.addEventListener('mouseenter', () => {
        dropdown.style.display = 'block';
      });

      userMenu.addEventListener('mouseleave', () => {
        dropdown.style.display = 'none';
      });
    }

    const logoutMsg = localStorage.getItem('logoutMsg');
    if (logoutMsg) {
      alert(logoutMsg);
      localStorage.removeItem('logoutMsg');
    }
  </script>

</body>

</html>