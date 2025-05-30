<?php
class EstadoCivilModel {
    private $db;
    public $idestadocivil;
    public $nombre;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Obtiene todos los estados civiles
     * @return array Lista de estados civiles
     */
    public function read() {
        $query = "SELECT * FROM estado_civil"; // Cambié "estados_civiles" por "estado_civil" para coincidir con tu estructura DB
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Alias para mantener compatibilidad
    public function getAll() {
        return $this->read();
    }

    // ... el resto de tus métodos permanece igual


    /**
     * Crea un nuevo estado civil
     * @return bool True si se creó correctamente, False si hubo error
     */
    public function create() {
        $query = "INSERT INTO estados_civiles (nombre) VALUES (:nombre)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([':nombre' => $this->nombre]);
    }

    /**
     * Obtiene un estado civil por ID
     * @return array Datos del estado civil
     */
    public function readOne() {
        $query = "SELECT * FROM estados_civiles WHERE idestadocivil = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id' => $this->idestadocivil]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Actualiza un estado civil
     * @return bool True si se actualizó correctamente, False si hubo error
     */
    public function update() {
        $query = "UPDATE estados_civiles SET nombre = :nombre WHERE idestadocivil = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':id' => $this->idestadocivil,
            ':nombre' => $this->nombre
        ]);
    }

    /**
     * Elimina un estado civil
     * @return bool True si se eliminó correctamente, False si hubo error
     */
    public function delete() {
        $query = "DELETE FROM estados_civiles WHERE idestadocivil = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([':id' => $this->idestadocivil]);
    }
}