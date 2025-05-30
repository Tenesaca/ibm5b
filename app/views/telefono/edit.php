<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Teléfono</title>
</head>
<body>

<h1>Editar Teléfono</h1>
<form action="/ibm5b/public/telefono/update" method="POST">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($telefono['id']); ?>">

    <label for="numero">Número:</label>
    <input type="text" name="numero" id="numero" value="<?php echo htmlspecialchars($telefono['numero']); ?>" required>

    <input type="submit" value="Actualizar">
</form>

<a href="index.php">Volver al listado</a>

</body>
</html>
