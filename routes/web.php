<?php
// Archivo routes/web.php

require_once __DIR__ . '/../app/controllers/TelefonoController.php';
// Puedes agregar aquí otros controladores:
require_once __DIR__ . '/../app/controllers/PersonaController.php';
require_once __DIR__ . '/../app/controllers/EstadoCivilController.php';

$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

$controller = new TelefonoController();

switch ($action) {
    case 'index':
        $controller->index();
        break;
    case 'create':
        $controller->create();
        break;
    case 'edit':
        if ($id) {
            $controller->edit($id);
        } else {
            echo "Error: Falta el ID para editar.";
        }
        break;
    case 'update':
        $controller->update();
        break;
    case 'delete':
        $controller->delete();
        break;
    case 'eliminar':
        if ($id) {
            $controller->eliminar($id);
        } else {
            echo "Error: Falta el ID para eliminar.";
        }
        break;
    default:
        echo "Acción no válida.";
        break;
}
