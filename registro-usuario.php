<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Content-Type');

ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

// Validar los datos
$nombre     = isset($data['nombre']) ? trim($data['nombre']) : null;
$apellidos  = isset($data['apellidos']) ? trim($data['apellidos']) : null;
$email      = isset($data['email']) ? trim($data['email']) : null;
$telefono   = isset($data['telefono']) ? trim($data['telefono']) : null;
$password   = isset($data['password']) ? $data['password'] : null;

if (!$nombre || !$apellidos || !$email || !$telefono || !$password) {
    echo json_encode(['success' => false, 'message' => 'Faltan campos obligatorios']);
    exit;
}

// Verificar si el email o teléfono ya existen
$check = $pdo->prepare("SELECT id FROM usuarios WHERE email = ? OR telefono = ?");
$check->execute([$email, $telefono]);

if ($check->rowCount() > 0) {
    echo json_encode(['success' => false, 'message' => 'Este email o teléfono ya ha sido registrado']);
    exit;
}

// Hash de contraseña
$hash = password_hash($password, PASSWORD_DEFAULT);

// Insertar nuevo usuario
$stmt = $pdo->prepare("INSERT INTO usuarios (nombre, apellidos, email, telefono, password, creado_en) VALUES (?, ?, ?, ?, ?, NOW())");

try {
    $stmt->execute([$nombre, $apellidos, $email, $telefono, $hash]);
    echo json_encode(['success' => true, 'message' => 'Usuario registrado correctamente']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error al registrar el usuario', 'error' => $e->getMessage()]);
}
