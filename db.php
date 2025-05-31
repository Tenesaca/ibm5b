<?php
$host = 'localhost';
$dbname = 'imb5b';
$user = 'root';
$password = ''; // Si cambiaste la contraseña, escríbela aquí

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $password);
    echo "✅ Conexión exitosa a la base de datos '$dbname'";
} catch (PDOException $e) {
    echo "❌ Error de conexión: " . $e->getMessage();
}
?>
