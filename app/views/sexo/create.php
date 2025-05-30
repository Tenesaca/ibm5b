<?php
// Incluir cabecera común si existe
// session_start(); // Descomentar si necesitas manejar sesiones
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Sexo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .max-width-600 {
            max-width: 600px;
        }
        .required-field::after {
            content: " *";
            color: red;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 max-width-600">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h2 class="h5 mb-0"><i class="fas fa-venus-mars me-2"></i>Crear Nuevo Sexo</h2>
                    </div>
                    
                    <div class="card-body">
                        <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-danger">
                                <?php 
                                $errors = [
                                    'empty' => 'Todos los campos son requeridos',
                                    'invalid' => 'Datos ingresados no válidos',
                                    'duplicate' => 'Este registro ya existe'
                                ];
                                echo $errors[$_GET['error']] ?? 'Error al procesar el formulario';
                                ?>
                            </div>
                        <?php endif; ?>
                        
                        <form action="../../controllers/SexoController.php?action=create" method="POST" id="sexoForm" novalidate>
                            <div class="mb-3">
                                <label for="nombre" class="form-label required-field">Nombre del Sexo</label>
                                <input type="text" 
                                       class="form-control <?= isset($_GET['error']) ? 'is-invalid' : '' ?>" 
                                       name="nombre" 
                                       id="nombre" 
                                       required
                                       minlength="2"
                                       maxlength="50"
                                       value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>"
                                       placeholder="Ej: Masculino, Femenino, Otro">
                                <div class="invalid-feedback">
                                    Por favor ingrese un nombre válido (2-50 caracteres)
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                <a href="/ibm5b/public/sexo" class="btn btn-outline-secondary me-md-2">
                                    <i class="fas fa-arrow-left me-1"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Validación del formulario
        (function() {
            'use strict';
            
            const form = document.getElementById('sexoForm');
            
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                
                form.classList.add('was-validated');
            }, false);
        })();
        
        // Mostrar mensaje de error si existe
        <?php if (isset($_GET['error'])): ?>
            document.addEventListener('DOMContentLoaded', function() {
                const nombreField = document.getElementById('nombre');
                nombreField.focus();
            });
        <?php endif; ?>
    </script>
</body>
</html>