<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Personas</title>
    <link rel="stylesheet" href="/ibm5b/public/css/style.css">
</head>
<body>

<div class="container">
    <h1>Listar Personas</h1>
    <a href="/ibm5b/app/views/persona/create.php"><button>Agregar</button></a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Fecha de Nacimiento</th>
                <th>Sexo</th>
                <th>Estado Civil</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($personas) && is_array($personas)): ?>
                <?php foreach ($personas as $persona): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($persona['idpersona']); ?></td>
                        <td><?php echo htmlspecialchars($persona['nombres']); ?></td>
                        <td><?php echo htmlspecialchars($persona['apellidos']); ?></td>
                        <td><?php echo htmlspecialchars($persona['fechanacimiento']); ?></td>
                        <td><?php echo htmlspecialchars($persona['nombre_sexo']); ?></td> <td><?php echo htmlspecialchars($persona['nombre_estadocivil']); ?></td> <td>
                            <a href="/ibm5b/public/persona/editForm?id=<?php echo htmlspecialchars($persona['idpersona']); ?>">
                                <button>Editar</button>
                            </a>
                            <a href="/ibm5b/public/persona/deleteForm?id=<?php echo htmlspecialchars($persona['idpersona']); ?>"
                               onclick="return confirm('¿Estás seguro de eliminar esta persona?');">
                                <button>Eliminar</button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No hay registros de personas disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="/ibm5b/public/js/script.js"></script>
</body>
</html>