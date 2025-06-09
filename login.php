<?php
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Content-Type');

session_start();

require __DIR__ . '/db.php'; 

// Leer datos del cuerpo JSON
$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

// Validación simple
if (!$email || !$password) {
    echo json_encode(['success' => false, 'message' => 'Faltan campos']);
    exit;
}

// Buscar usuario por email
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->execute([$email]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if ($usuario && password_verify($password, $usuario['password'])) {
    // Guardar datos en la sesión
    $_SESSION['usuario'] = [
        'id' => $usuario['id'],
        'nombre' => $usuario['nombre'],
        'apellidos' => $usuario['apellidos'],
        'email' => $usuario['email'],
        'telefono' => $usuario['telefono'],
        'creado_en' => $usuario['creado_en']
    ];

    echo json_encode([
        'success' => true,
        'message' => 'Inicio de sesión correcto',
        'usuario' => $_SESSION['usuario']
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Credenciales inválidas']);
}

