<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/PersonaModel.php';
require_once __DIR__ . '/../models/SexoModels.php';
require_once __DIR__ . '/../models/EstadoCivil.php';

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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombre' => $_POST['nombre'] ?? '',
                'apellido' => $_POST['apellido'] ?? '',
                'fecha_nacimiento' => $_POST['fecha_nacimiento'] ?? '',
                'id_sexo' => $_POST['id_sexo'] ?? null,
                'id_estado_civil' => $_POST['id_estado_civil'] ?? null,
                'email' => $_POST['email'] ?? ''
            ];

            if ($this->personaModel->create($data)) {
                header('Location: /sexo/ibm5b/public/persona?success=created');
                exit;
            } else {
                $error = 'Error al crear la persona';
            }
        }

        require_once __DIR__ . '/../views/persona/create.php';
    }
}

$controller = new PersonaController();
$controller->create();
?>