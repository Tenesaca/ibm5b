<?php
require_once '../config/database.php';
require_once '../models/SexoModel.php';

class SexoController {
    private $model;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->model = new SexoModel($db);
    }

   public function index() {
    $sexos = $this->model->getAll();
    require_once __DIR__ . '/../views/sexo/index.php';
}

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            
            if ($this->model->create($nombre)) {
                header('Location: /eysphp/public/sexo?success=created');
            } else {
                header('Location: /eysphp/public/sexo/create?error=duplicate');
            }
            exit;
        }
        require_once '../views/sexo/create.php';
    }

    public function edit() {
        if (!isset($_GET['id'])) {
            header('Location: /eysphp/public/sexo');
            exit;
        }

        $id = $_GET['id'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            
            if ($this->model->update($id, $nombre)) {
                header('Location: /eysphp/public/sexo?success=updated');
            } else {
                header("Location: /eysphp/public/sexo/edit?id=$id&error=duplicate");
            }
            exit;
        }

        $sexo = $this->model->getById($id);
        if (!$sexo) {
            header('Location: /eysphp/public/sexo');
            exit;
        }

        require_once '../views/sexo/edit.php';
    }

    public function delete() {
        if (isset($_GET['id'])) {
            $this->model->delete($_GET['id']);
        }
        header('Location: /eysphp/public/sexo');
        exit;
    }
}

// Routing
$action = $_GET['action'] ?? 'index';
$controller = new SexoController();

switch ($action) {
    case 'create':
        $controller->create();
        break;
    case 'edit':
        $controller->edit();
        break;
    case 'delete':
        $controller->delete();
        break;
    default:
        $controller->index();
        break;
}
?>