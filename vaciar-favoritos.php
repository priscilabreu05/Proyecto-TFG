<?php

session_start();
unset($_SESSION['favoritos']);
header('Location: favoritos.php');
exit;

?>