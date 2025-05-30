<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Teléfono</title>
</head>
<body>

<h1>Eliminar Teléfono</h1>
<form action="/ibm5b/public/telefono/delete" method="POST">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($telefono['id']); ?>">

    <label for="numero">Número:</label>
    <input type="text" name="numero" id="numero" value="<?php echo htmlspecialchars($telefono['numero']); ?>" required>

    <input type="submit" value="Eliminar">
</form>

<a href="index.php">Volver al listado</a>

</body>
</html>
