<?php
// Configuración de la base de datos
$host = "localhost";
$dbname = "abcd_medica";
$username = "root"; // Cambiar por tu usuario de DB
$password = "";     // Cambiar por tu contraseña de DB

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(["error" => "No se pudo conectar a la base de datos: " . $e->getMessage()]));
}
?>
