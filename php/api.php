<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Content-Type");

require_once 'db_config.php';

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if ($action === 'register') {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$data['email']]);
        if ($stmt->fetch()) {
            echo json_encode(["error" => "El usuario ya existe"]);
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        // En un entorno de producción, usa password_hash
        $stmt->execute([$data['name'], $data['email'], $data['password']]);
        echo json_encode(["success" => true]);
    }

    if ($action === 'login') {
        $stmt = $pdo->prepare("SELECT id, name, email, password, role FROM users WHERE email = ? AND password = ?");
        $stmt->execute([$data['email'], $data['password']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            unset($user['password']); // No enviar la contraseña de vuelta
            echo json_encode(["success" => true, "user" => $user]);
        } else {
            echo json_encode(["error" => "Credenciales incorrectas"]);
        }
    }

    if ($action === 'save_record') {
        $stmt = $pdo->prepare("INSERT INTO records (user_id, symptoms, diagnosis, status) VALUES (?, ?, ?, ?)");
        $stmt->execute([$data['userId'], $data['symptoms'], $data['diagnosis'], $data['status']]);
        echo json_encode(["success" => true, "recordId" => $pdo->lastInsertId()]);
    }

    if ($action === 'update_payment_status') {
        $stmt = $pdo->prepare("UPDATE records SET status = 'PAID' WHERE id = ?");
        $stmt->execute([$data['recordId']]);
        echo json_encode(["success" => true]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($action === 'get_records') {
        $userId = $_GET['userId'] ?? 0;
        $stmt = $pdo->prepare("SELECT * FROM records WHERE user_id = ? ORDER BY date DESC");
        $stmt->execute([$userId]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    if ($action === 'get_paid_consultations') {
        $stmt = $pdo->prepare("SELECT r.*, u.name as patient_name FROM records r JOIN users u ON r.user_id = u.id WHERE r.status = 'PAID' ORDER BY r.date DESC");
        $stmt->execute();
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
}
?>
