<?php
session_start();
$favoritos = $_SESSION['favoritos'] ?? [];
echo count($favoritos);
?>