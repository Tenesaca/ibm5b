<?php
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container py-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h2 class="h4"><i class="bi bi-person-plus"></i> Crear Nueva Persona</h2>
        </div>
        
        <div class="card-body">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            
            <form action="/sexo/ibm5b/public/persona/create" method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" required>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="id_sexo" class="form-label">Sexo</label>
                        <select class="form-select" id="id_sexo" name="id_sexo" required>
                            <option value="">Seleccione...</option>
                            <?php foreach ($sexos as $sexo): ?>
                                <option value="<?= htmlspecialchars($sexo['id']) ?>">
                                    <?= htmlspecialchars($sexo['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="id_estado_civil" class="form-label">Estado Civil</label>
                        <select class="form-select" id="id_estado_civil" name="id_estado_civil">
                            <option value="">Seleccione...</option>
                            <?php foreach ($estadosCiviles as $estado): ?>
                                <option value="<?= htmlspecialchars($estado['id']) ?>">
                                    <?= htmlspecialchars($estado['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between mt-4">
                    <a href="/sexo/ibm5b/public/persona" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Guardar Persona
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>