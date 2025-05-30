<?php
$successMessages = [
    'created' => 'Sexo creado exitosamente',
    'updated' => 'Sexo actualizado correctamente',
    'deleted' => 'Sexo eliminado con éxito'
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Sexos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h2 class="h4">Listado de Sexos</h2>
                <a href="create.php" class="btn btn-light btn-sm float-end">
                    <i class="bi bi-plus"></i> Nuevo Sexo
                </a>
            </div>
            
            <div class="card-body">
                <?php if (isset($_GET['success']) && isset($successMessages[$_GET['success']])): ?>
                    <div class="alert alert-success"><?= $successMessages[$_GET['success']] ?></div>
                <?php endif; ?>
                
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sexos as $sexo): ?>
                            <tr>
                                <td><?= htmlspecialchars($sexo['id']) ?></td>
                                <td><?= htmlspecialchars($sexo['nombre']) ?></td>
                                <td>
                                    <a href="edit.php?id=<?= $sexo['id'] ?>" class="btn btn-sm btn-warning">
                                        Editar
                                    </a>
                                    <a href="index.php?action=delete&id=<?= $sexo['id'] ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('¿Eliminar este sexo?')">
                                        Eliminar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>