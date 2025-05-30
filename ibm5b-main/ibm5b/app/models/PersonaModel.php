<?php
class PersonaModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear una nueva persona
    public function create($data) {
        $query = "INSERT INTO persona (nombre, apellido, fecha_nacimiento, id_sexo, id_estado_civil, email) 
                  VALUES (:nombre, :apellido, :fecha_nacimiento, :id_sexo, :id_estado_civil, :email)";
        
        $stmt = $this->conn->prepare($query);

        // Limpiar y vincular los datos
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':apellido', $data['apellido']);
        $stmt->bindParam(':fecha_nacimiento', $data['fecha_nacimiento']);
        $stmt->bindParam(':id_sexo', $data['id_sexo']);
        $stmt->bindParam(':id_estado_civil', $data['id_estado_civil']);
        $stmt->bindParam(':email', $data['email']);

        return $stmt->execute();
    }

    // Obtener todas las personas
    public function getAll() {
        $query = "SELECT p.*, s.descripcion as sexo, ec.descripcion as estado_civil 
                  FROM persona p
                  LEFT JOIN sexo s ON p.id_sexo = s.id_sexo
                  LEFT JOIN estado_civil ec ON p.id_estado_civil = ec.id_estado_civil";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener una persona por ID
    public function getById($id) {
        $query = "SELECT p.*, s.descripcion as sexo, ec.descripcion as estado_civil 
                  FROM persona p
                  LEFT JOIN sexo s ON p.id_sexo = s.id_sexo
                  LEFT JOIN estado_civil ec ON p.id_estado_civil = ec.id_estado_civil
                  WHERE p.id_persona = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar una persona
    public function update($id, $data) {
        $query = "UPDATE persona 
                  SET nombre = :nombre, 
                      apellido = :apellido, 
                      fecha_nacimiento = :fecha_nacimiento, 
                      id_sexo = :id_sexo, 
                      id_estado_civil = :id_estado_civil,
                      email = :email
                  WHERE id_persona = :id";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':apellido', $data['apellido']);
        $stmt->bindParam(':fecha_nacimiento', $data['fecha_nacimiento']);
        $stmt->bindParam(':id_sexo', $data['id_sexo']);
        $stmt->bindParam(':id_estado_civil', $data['id_estado_civil']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    // Eliminar una persona
    public function delete($id) {
        $query = "DELETE FROM persona WHERE id_persona = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        
        return $stmt->execute();
    }

    // Métodos adicionales para relaciones

    // Obtener teléfonos de una persona
    public function getTelefonos($id_persona) {
        $query = "SELECT * FROM telefono WHERE id_persona = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id_persona);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener direcciones de una persona
    public function getDirecciones($id_persona) {
        $query = "SELECT * FROM direccion WHERE id_persona = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id_persona);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}