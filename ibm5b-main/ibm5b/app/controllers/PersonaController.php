<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/PersonaModel.php';
require_once __DIR__ . '/../models/SexoModel.php';
require_once __DIR__ . '/../models/EstadoCivilModel.php';

class PersonaController {
    private $personaModel;
    private $sexoModel;
    private $estadoCivilModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        
        $this->personaModel = new PersonaModel($db);
        $this->sexoModel = new SexoModel($db);
        $this->estadoCivilModel = new EstadoCivilModel($db);
    }

    public function create() {
        // Obtener datos para selects
        $sexos = $this->sexoModel->getAll();
        $estadosCiviles = $this->estadoCivilModel->getAll();

        $error = null;
        $oldInput = []; // Para mantener los datos ingresados en caso de error

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recoger y sanitizar datos
            $data = [
                'nombre' => trim($_POST['nombre'] ?? ''),
                'apellido' => trim($_POST['apellido'] ?? ''),
                'fecha_nacimiento' => $_POST['fecha_nacimiento'] ?? '',
                'id_sexo' => !empty($_POST['id_sexo']) ? (int)$_POST['id_sexo'] : null,
                'id_estado_civil' => !empty($_POST['id_estado_civil']) ? (int)$_POST['id_estado_civil'] : null,
                'email' => filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL)
            ];

            $oldInput = $data; // Guardar datos para repoblar el formulario

            // Validaciones
            if (empty($data['nombre'])) {
                $error = 'El nombre es requerido';
            } elseif (empty($data['apellido'])) {
                $error = 'El apellido es requerido';
            } elseif (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $error = 'El email no tiene un formato válido';
            } elseif (!empty($data['fecha_nacimiento']) && !$this->validarFecha($data['fecha_nacimiento'])) {
                $error = 'La fecha de nacimiento no es válida';
            }

            if (!$error) {
                if ($this->personaModel->create($data)) {
                    header('Location: /../public/persona?success=created');
                    exit;
                } else {
                    $error = 'Error al crear la persona en la base de datos';
                }
            }
        }

        require_once __DIR__ . '/../views/persona/create.php';
    }

    // Método para validar fecha
    private function validarFecha($fecha, $formato = 'Y-m-d') {
        $d = DateTime::createFromFormat($formato, $fecha);
        return $d && $d->format($formato) === $fecha;
    }

    // Método para listar todas las personas
    public function index() {
        $personas = $this->personaModel->getAll();
        require_once __DIR__ . '/../views/persona/index.php';
    }

    // Método para editar una persona
    public function edit($id) {
        $sexos = $this->sexoModel->getAll();
        $estadosCiviles = $this->estadoCivilModel->getAll();
        $persona = $this->personaModel->getById($id);
        $error = null;

        if (!$persona) {
            header('Location: /../public/persona?error=not_found');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombre' => trim($_POST['nombre'] ?? ''),
                'apellido' => trim($_POST['apellido'] ?? ''),
                'fecha_nacimiento' => $_POST['fecha_nacimiento'] ?? '',
                'id_sexo' => !empty($_POST['id_sexo']) ? (int)$_POST['id_sexo'] : null,
                'id_estado_civil' => !empty($_POST['id_estado_civil']) ? (int)$_POST['id_estado_civil'] : null,
                'email' => filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL)
            ];

            // Validaciones (similar al método create)
            // ...

            if (!$error && $this->personaModel->update($id, $data)) {
                header('Location: ibm5b/public/persona?success=updated');
                exit;
            }
        }

        require_once __DIR__ . '/../views/persona/edit.php';
    }

    // Método para eliminar una persona
    public function delete($id) {
        if ($this->personaModel->delete($id)) {
            header('Location: /../public/persona?success=deleted');
        } else {
            header('Location: /../public/persona?error=delete_failed');
        }
        exit;
    }
}

// Manejo de la ruta
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

$controller = new PersonaController();

// Determinar qué método llamar basado en la acción
switch ($action) {
    case 'create':
        $controller->create();
        break;
    case 'edit':
        if ($id) $controller->edit($id);
        break;
    case 'delete':
        if ($id) $controller->delete($id);
        break;
    default:
        $controller->index();
        break;
}