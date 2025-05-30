<?php
class SexoModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM sexo ORDER BY nombre";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM sexo WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($nombre) {
        // Verificar si ya existe
        if ($this->exists($nombre)) {
            return false;
        }

        $query = "INSERT INTO sexo (nombre) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$nombre]);
    }

    public function update($id, $nombre) {
        // Verificar si ya existe (excluyendo el actual)
        if ($this->exists($nombre, $id)) {
            return false;
        }

        $query = "UPDATE sexo SET nombre = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$nombre, $id]);
    }

    public function delete($id) {
        $query = "DELETE FROM sexo WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    private function exists($nombre, $excludeId = null) {
        $query = "SELECT COUNT(*) FROM sexo WHERE nombre = ?";
        $params = [$nombre];
        
        if ($excludeId) {
            $query .= " AND id != ?";
            $params[] = $excludeId;
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }
}
?>