<?php
require_once '../config/database.php';

// Crear conexión
$db = new Database();
$conn = $db->getConnection();

// Función para calcular edad
function calcularEdad($fechaNacimiento) {
    if (!$fechaNacimiento) return 'N/A';
    $nacimiento = new DateTime($fechaNacimiento);
    $hoy = new DateTime();
    $diff = $hoy->diff($nacimiento);
    return $diff->y;
}

// Obtener total de personas
$stmt = $conn->query("SELECT COUNT(*) AS total FROM persona");
$totalPersonas = $stmt->fetch()['total'] ?? 0;

// Obtener total por sexo
$stmt = $conn->query("SELECT s.nombre, COUNT(p.id) AS total
                      FROM persona p
                      JOIN sexo s ON p.id_sexo = s.id
                      GROUP BY s.nombre");
$sexoStats = $stmt->fetchAll();

// Obtener últimas personas registradas
$stmt = $conn->query("SELECT p.nombre, p.apellido, p.fecha_nacimiento,
                             s.nombre AS sexo_nombre,
                             ec.nombre AS estado_civil_nombre
                      FROM persona p
                      LEFT JOIN sexo s ON p.id_sexo = s.id
                      LEFT JOIN estado_civil ec ON p.id_estado_civil = ec.id
                      ORDER BY p.created_at DESC
                      LIMIT 5");
$ultimasPersonas = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Personas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1>Dashboard de Personas</h1>

    <div class="row my-4">
        <div class="col-md-4">
            <div class="card bg-info text-white p-3">
                <h5>Total Personas Registradas</h5>
                <h2><?= $totalPersonas ?></h2>
            </div>
        </div>

        <?php foreach ($sexoStats as $stat): ?>
            <div class="col-md-4">
                <div class="card bg-secondary text-white p-3">
                    <h5><?= htmlspecialchars($stat['nombre']) ?></h5>
                    <h2><?= $stat['total'] ?></h2>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <h3>Últimas Personas Registradas</h3>
    <?php if (count($ultimasPersonas) > 0): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre Completo</th>
                    <th>Sexo</th>
                    <th>Estado Civil</th>
                    <th>Edad</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ultimasPersonas as $persona): ?>
                    <tr>
                        <td><?= htmlspecialchars($persona['nombre'] . ' ' . $persona['apellido']) ?></td>
                        <td><?= htmlspecialchars($persona['sexo_nombre'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($persona['estado_civil_nombre'] ?? 'N/A') ?></td>
                        <td><?= calcularEdad($persona['fecha_nacimiento']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay personas registradas.</p>
    <?php endif; ?>
</div>
</body>
</html>
