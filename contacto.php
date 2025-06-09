<?php

require 'db.php';

$mensaje = "";

// Validacion
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = htmlspecialchars(trim($_POST["nombre"]));
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $mensajeTexto = htmlspecialchars(trim($_POST["mensaje"]));

    if (!empty($nombre) && !empty($email) && !empty($mensajeTexto) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Guardar en la base de datos
        $sql = "INSERT INTO mensajes_contacto (nombre, email, mensaje) VALUES (:nombre, :email, :mensaje)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nombre' => $nombre,
            ':email' => $email,
            ':mensaje' => $mensajeTexto
        ]);

        $mensaje = "<div class='alert alert-success'>¡Gracias por tu mensaje, $nombre! Lo hemos recibido correctamente.</div>";
    } else {
        $mensaje = "<div class='alert alert-danger'>Por favor, completa todos los campos correctamente.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Contacto | Pam Accessories</title>
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

  <section style="padding:40px;">

    <h2 class="titulo">Contacto</h2>
    <br>

    <img src="/tfg-proyecto-final/assets/img/chica-contacto.avif" width="250px" height="250px">
    <br><br>

    <div class="p-4 shadow rounded atencion">
      <h3>¿Dudas? Estamos aquí para ayudarte</h3>
      <p>🕒 Lunes a Viernes: 10:00 - 18:00 hrs</p>
      <p>📧 Email: contacto@pamaccessories.com</p>
      <p>📱 WhatsApp: +34 .........</p>
    </div>
    <br>
    <hr>
    <br>

    <h3>¿Tienes preguntas o sugerencias?</h3>
    <p>Rellena este formulario y te responderemos lo antes posible 💌</p>
    <form method="POST" action="/tfg-proyecto-final/contacto.php" class="p-4 shadow rounded">
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre</label>
      <input type="text" name="nombre" id="nombre" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Correo electrónico</label>
      <input type="email" name="email" id="email" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="mensaje" class="form-label">Mensaje</label>
      <textarea name="mensaje" id="mensaje" rows="5" class="form-control" required></textarea>
    </div>

    <button type="submit" class="btn btn-dark">Enviar mensaje</button>
  </form>
    <?= $mensaje ?>
    <br>
    <hr>
    <br>

    <div class="p-4 shadow rounded info-envios">
      <h3>📍 Envíos desde Madrid, España</h3>
      <p>Realizamos envíos a todo el país a través de servicios de confianza.</p>
      <p>¡Pronto tendremos envíos internacionales!</p>

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