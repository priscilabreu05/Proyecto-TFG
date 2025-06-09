<?php

session_start();

include 'conexion.php';
// Obtener los productos de la base de datos
require 'db.php';

$filtro_nombre = strtolower($_GET['buscar'] ?? '');
$filtro_color = $_GET['color'] ?? '';
$filtro_tipo = $_GET['tipo'] ?? '';
$filtro_categoria = $_GET['categoria'] ?? '';
$orden = $_GET['orden'] ?? '';

// Consulta SQL
$resultado = $conexion->query("SELECT * FROM productos");
$sql = "SELECT * FROM productos WHERE 1=1";
$params = [];

if (!empty($filtro_nombre)) {
  $sql .= " AND LOWER(nombre) LIKE :nombre";
  $params[':nombre'] = '%' . $filtro_nombre . '%';
}
if (!empty($filtro_color)) {
  $sql .= " AND color = :color";
  $params[':color'] = $filtro_color;
}
if (!empty($filtro_tipo)) {
  $sql .= " AND tipo = :tipo";
  $params[':tipo'] = $filtro_tipo;
}
if (!empty($filtro_categoria)) {
  $sql .= " AND categoria = :categoria";
  $params[':categoria'] = $filtro_categoria;
}

// Ordenar
switch ($orden) {
  case 'precio_asc':
    $sql .= " ORDER BY precio ASC";
    break;
  case 'precio_desc':
    $sql .= " ORDER BY precio DESC";
    break;
  case 'novedad':
    $sql .= " ORDER BY novedad DESC";
    break;
  case 'mas_vendido':
    $sql .= " ORDER BY mas_vendido DESC";
    break;
  default:
    $sql .= " ORDER BY id DESC";
    break;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$filtrados = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Catálogo | Pam Accessories</title>
  <link rel="stylesheet" href="/tfg-proyecto-final/assets/css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #ffdbd3;
      overflow-x: hidden;
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

    #contadorCarrito {
      text-decoration: none;
      outline: none;
    }

    .carrito-boton:focus,
    .carrito-boton:active {
      outline: none;
      box-shadow: none;
    }

    .lupa2 {
      background: none;
      border-radius: 10px;
      border: 1px solid #333;
      padding: 5px 10px;
    }

    .lupa2:hover {
      background-color: rgba(184, 177, 177, 0.43);
    }

    .favorito-toggle-btn{
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
        <a href="http://localhost:3000/login">
          <button class="btn btn-link p-0 usuario-boton" title="Iniciar sesión/Registro">
          <img src="/tfg-proyecto-final/assets/img/user.png" alt="Usuarios" width="24" height="24">
        </button>
        </a>
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


        </button>
      </div>
    </div>
  </header>

  <div class="container my-5">
    <h2 class="text-center mb-4">Catálogo de Accesorios</h2>

    <!-- Botón hamburguesa -->
    <button class="hamburger" onclick="toggleSidebar()" aria-label="Abrir filtros">
      <span></span>
      <span></span>
      <span></span>
    </button>

    <!-- Sidebar de filtros -->
    <div id="sidebar" class="sidebar">
      <h4>Filtros</h4>
      <button class="close-btn" onclick="toggleSidebar()">✕</button>
      <form method="GET">
        <div class="mb-3">
          <label class="form-label">Ordenar por:</label>
          <select name="orden" class="form-select">
            <option value="">Selecciona</option>
            <option value="precio_asc">Precio ascendente</option>
            <option value="precio_desc">Precio descendente</option>
            <option value="novedad">Novedades</option>
            <option value="mas_vendido">Más vendidos</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Color:</label>
          <select name="color" class="form-select">
            <option value="">Todos</option>
            <option value="dorado">Dorado</option>
            <option value="plateado">Plateado</option>
            <option value="blanco">Blanco</option>
            <option value="multicolor">Multicolor</option>
            <option value="azul">Azul</option>
            <option value="verde">Verde</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Tipo de producto:</label>
          <select name="tipo" class="form-select">
            <option value="">Todos</option>
            <option value="juvenil">Juvenil</option>
            <option value="ecológico">Ecológico</option>
            <option value="sencillo">Sencillo</option>
            <option value="exotico">Exótico</option>
            <option value="elegante">Elegante</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Categoría:</label>
          <select name="categoria" class="form-select">
            <option value="">Todos</option>
            <option value="collares">Collares</option>
            <option value="anillos">Anillos</option>
            <option value="pulseras">Pulseras</option>
            <option value="pendientes">Pendientes</option>

          </select>
        </div>

        <button type="submit" class="btn btn-dark">Aplicar filtros</button>
      </form>
    </div>

    <!--Barra de busqueda-->
    <form class="d-flex" method="GET">
      <input type="search" name="buscar" class="form-control me-2" placeholder="Buscar producto..." value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>">
      <button type="submit" class="lupa2"><img src="/tfg-proyecto-final/assets/img/search.png" alt="lupa"></button>
    </form>

    <section class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
      <?php if (empty($filtrados)): ?>
        <div class="col-12 text-center">
          <p class="text-danger">😢 No encontramos ningún accesorio que coincida.</p>
        </div>
      <?php else: ?>
        <!--Tarjetas Productos-->
        <?php foreach ($filtrados as $producto): ?>
          <div class="col">
            <div class="card h-100 text-center position-relative">

              <!-- Enlace envuelve solo la parte clicable -->
              <a href="/tfg-proyecto-final/detalle-producto.php?id=<?= $producto['id'] ?>" class="stretched-link text-decoration-none text-dark">
                <!-- Etiquetas -->
                <div class="position-absolute top-0 start-0 m-2 z-1">
                  <?php if ($producto['novedad']): ?>
                    <span class="badge bg-success">Nuevo</span>
                  <?php endif; ?>
                  <?php if ($producto['mas_vendido']): ?>
                    <span class="badge bg-warning text-dark">Top ventas</span>
                  <?php endif; ?>
                </div>

                <div class="position-relative">
                  <img src="/tfg-proyecto-final <?= $producto['imagen'] ?>" class="card-img-top" alt="<?= $producto['nombre'] ?>">

                  <?php 
                  $esFavorito = in_array($producto['id'], $_SESSION['favoritos'] ?? []);
                  $imgSrc = $esFavorito ? '/tfg-proyecto-final/assets/img/heart-filled.png' : '/tfg-proyecto-final/assets/img/heart.png';
                  ?>
                  <button
                    class="favorito-toggle-btn position-absolute top-0 end-0 m-2 p-0 border-0 bg-transparent"
                    data-id="<?= $producto['id'] ?>"
                    title="Favorito">
                    <img src="<?= $imgSrc ?>" width="24" height="24" alt="Favorito">
                  </button>
                </div>

                <div class="card-body">
                  <h5 class="card-title"><?= $producto['nombre'] ?></h5>
                  <p class="card-text"><?= $producto['descripcion'] ?></p>
                  <p class="text-black fw-bold"><?= $producto['precio'] ?>€</p>
                </div>
              </a>

              <!-- Botón Carrito-->
              <div class="card-footer bg-white border-0">
                <button
                  class="btn btn-dark btn-sm btn-carrito"
                  onclick="agregarAlCarrito(<?= $producto['id'] ?>, this)"
                  type="button">
                  Añadir al carrito
                </button>
              </div>
            </div>
          </div>
        <?php endforeach; ?>

      <?php endif; ?>
    </section>
    </main>
  </div>

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


  <script src="/tfg-proyecto-final/assets/js/carrito.js"></script>
  <script defer>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('show');
    }

    function filtrarBusqueda() {
      const filtro = document.getElementById('buscador').value.toLowerCase();
      const productos = document.querySelectorAll('.producto');
      let encontrados = 0;

      productos.forEach(producto => {
        const nombre = producto.querySelector('h5').textContent.toLowerCase();
        const descripcion = producto.querySelector('p').textContent.toLowerCase();

        if (nombre.includes(filtro) || descripcion.includes(filtro)) {
          producto.style.display = '';
          encontrados++;
        } else {
          producto.style.display = 'none';
        }
      });

      document.getElementById('mensajeNoResultados').style.display = encontrados === 0 ? 'block' : 'none';
    }
  </script>

</body>

</html>