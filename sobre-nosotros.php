<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Sobre Nosotros | Pam Accessories</title>
  <link rel="stylesheet" href="/tfg-proyecto-final/assets/css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #ffdbd3;
      overflow-x: hidden;
    }

    .nombre{
      margin: 0;
      font-size: 28px;
      color: #aa4343;
      font-weight: bold;
    }

    .titulo, .inicio, .catalogo {
      font-weight: bold;
    }

    .subtitulo{
      text-align: center;
      font-size: 18px;
      margin-bottom: 50px;
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
      <button class="btn btn-link p-0 favoritos-boton" title="Favoritos">
        <img src="/tfg-proyecto-final/assets/img/heart.png" alt="Favoritos" width="24" height="24">
      </button>
      <button class="btn btn-link p-0 carrito-boton" title="Carrito">
        <img src="/tfg-proyecto-final/assets/img/carritocompra.png" alt="Carrito" width="24" height="24">
      </button>
    </div>
  </div>
</header>

<section class="container my-5">
  <h2 class="text-center mb-5 titulo">​📿​ Sobre Nosotros 📿​</h2>
  <h4 class="subtitulo">Diseñamos más que accesorios: creamos conexiones personales con estilo y conciencia.</h4>

  <!-- Bloque 1 -->
  <div class="row align-items-center mb-5">
    <div class="col-md-6">
      <img src="/tfg-proyecto-final/assets/img/imagen-animada-crear-joyas.jpg" alt="Estilo único" class="img-fluid rounded shadow">
    </div>
    <div class="col-md-6">
      <h3>Una marca única y con estilo</h3>
      <p> Cada pieza que ofrecemos ha sido cuidadosamente seleccionada o diseñada para personas <strong>como tú;</strong> auténticas, con estilo, que valoran los detalles y buscan brillar con ese toque que hace la diferencia. Nuestros accesorios son prácticos e <strong>inspiradores</strong>, pensados para que se adapten a tu día a día sin dejar de expresar quién eres.</p>
    </div>
  </div>

  <!-- Bloque 2 -->
  <div class="row align-items-center mb-5 flex-md-row-reverse">
    <div class="col-md-6">
      <img src="/tfg-proyecto-final/assets/img/imagen-medio-ambiente.jpg" alt="Accesorios ecológicos" class="img-fluid rounded shadow">
    </div>
    <div class="col-md-6">
      <h3>Comprometidos con el medio ambiente</h3>
      <p>Creemos en una moda más consciente. Por eso, en cada colección incluimos una selección de <strong>accesorios ecológicos y sostenibles</strong>, hechos con <strong>materiales reciclados</strong> o naturales. Este es solo un paso hacia un futuro más responsable, y estamos orgullosos de formar parte del cambio.</p>
    </div>
  </div>

  <!-- Bloque 3 -->
  <div class="row align-items-center mb-5">
    <div class="col-md-6">
      <img src="/tfg-proyecto-final/assets/img/tienda-online.jpg" alt="Tienda online" class="img-fluid rounded shadow">
    </div>
    <div class="col-md-6">
      <h3>100% Tienda Online, rápida y segura</h3>
      <p>Somos una tienda <strong>exclusivamente online</strong>, rápida, conectada que te permite explorar, elegir y comprar con seguridad y fluidez.</p>
    </div>
  </div>

  <!-- Bloque 4 -->
  <div class="row align-items-center mb-5 flex-md-row-reverse">
    <div class="col-md-6">
      <img src="/tfg-proyecto-final/assets/img/tienda-calidad.jpg" alt="Confianza y calidad" class="img-fluid rounded shadow">
    </div>
    <div class="col-md-6">
      <h3>Confianza, calidad e inspiración</h3>
      <p>Todos nuestros productos pasan por controles de selección para asegurar que lo que recibes en casa es lo que esperabas —o incluso mejor. Porque en <strong>Pam Accessories</strong>, la confianza también es un accesorio esencial.</p>
    </div>
  </div>

  <!-- Cierre -->
  <div class="text-center mt-5">
    <h4>Gracias por ser parte de Pam 💖</h4>
    <p>Estamos aquí para acompañarte con estilo, inspiración y autenticidad. Tu historia también se cuenta con accesorios.</p>
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

</body>
</html>
