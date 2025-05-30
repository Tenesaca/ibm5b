<?php
class Telefono {
    private $db;
    public $id;
    public $numero;
    public $tipo;
    public $id_persona;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Obtiene todos los teléfonos
     * @return array Lista de teléfonos
     */
    public function read() {
        $query = "SELECT * FROM telefono";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Crea un nuevo teléfono
     * @return bool True si se creó correctamente, False si hubo error
     */
    public function create() {
        $query = "INSERT INTO telefono (numero, tipo, id_persona) VALUES (:numero, :tipo, :id_persona)";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':numero', $this->numero);
        $stmt->bindParam(':tipo', $this->tipo);
        $stmt->bindParam(':id_persona', $this->id_persona);
        
        return $stmt->execute();
    }

    /**
     * Obtiene un teléfono por ID
     * @return array Datos del teléfono
     */
    public function readOne() {
        $query = "SELECT * FROM telefono WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Actualiza un teléfono
     * @return bool True si se actualizó correctamente, False si hubo error
     */
    public function update() {
        $query = "UPDATE telefono SET numero = :numero, tipo = :tipo, id_persona = :id_persona WHERE id = :id";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':numero', $this->numero);
        $stmt->bindParam(':tipo', $this->tipo);
        $stmt->bindParam(':id_persona', $this->id_persona);
        
        return $stmt->execute();
    }

    /**
     * Elimina un teléfono
     * @return bool True si se eliminó correctamente, False si hubo error
     */
    public function delete() {
        $query = "DELETE FROM telefono WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->id);
        
        return $stmt->execute();
    }

    /**
     * Obtiene teléfonos por persona
     * @param int $id_persona ID de la persona
     * @return array Teléfonos asociados
     */
    public function getByPersona($id_persona) {
        $query = "SELECT * FROM telefono WHERE id_persona = :id_persona";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_persona', $id_persona);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}