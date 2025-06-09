<?php
session_start();
session_destroy();
echo "<script>
  localStorage.removeItem('usuario');
  localStorage.setItem('logoutMsg', 'Sesión cerrada correctamente');
  window.location.href = 'index.php';
</script>";
exit;
?>
