<?php
require_once '../config/database.php';

class BaseController {
    protected $db;
    protected $model;

    public function __construct($model = null) {
        session_start();
        $database = new Database();
        $this->db = $database->getConnection();
        $this->model = $model;
    }

    protected function loadView($viewPath, $data = []) {
        extract($data);
        $flashMessage = $_SESSION['flash_message'] ?? null;
        $flashType = $_SESSION['flash_type'] ?? null;
        unset($_SESSION['flash_message'], $_SESSION['flash_type']);
        
        require_once "../app/views/layouts/header.php";
        require_once "../app/views/partials/menu.php";
        
        if ($flashMessage) {
            echo "<div class='container mt-3'><div class='alert alert-$flashType'>$flashMessage</div></div>";
        }
        
        require_once "../app/views/$viewPath";
        require_once "../app/views/layouts/footer.php";
    }

    protected function redirect($url, $message = null, $type = 'success') {
        if ($message) {
            $_SESSION['flash_message'] = $message;
            $_SESSION['flash_type'] = $type;
        }
        header("Location: $url");
        exit();
    }

    protected function sanitizeInput($data) {
        if (is_array($data)) {
            return array_map([$this, 'sanitizeInput'], $data);
        }
        return htmlspecialchars(strip_tags(trim($data)));
    }

    protected function validateRequiredFields($fields, $data) {
        $errors = [];
        foreach ($fields as $field) {
            if (empty($data[$field])) {
                $errors[] = "El campo $field es requerido";
            }
        }
        return $errors;
    }

    public function __destruct() {
        $this->db = null;
    }
}
?>