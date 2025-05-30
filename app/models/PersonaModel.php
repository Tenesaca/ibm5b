<?php
class User {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Obtener todas las personas con sus relaciones
    public function getUsers() {
        $this->db->query('SELECT p.*, s.descripcion as sexo, ec.descripcion as estado_civil 
                         FROM persona p
                         LEFT JOIN sexo s ON p.id_sexo = s.id_sexo
                         LEFT JOIN estado_civil ec ON p.id_estado_civil = ec.id_estado_civil');
        return $this->db->resultSet();
    }
    
    // Obtener una persona por ID con todos sus datos
    public function getUserById($id) {
        // Datos básicos de la persona
        $this->db->query('SELECT p.*, s.descripcion as sexo, ec.descripcion as estado_civil 
                          FROM persona p
                          LEFT JOIN sexo s ON p.id_sexo = s.id_sexo
                          LEFT JOIN estado_civil ec ON p.id_estado_civil = ec.id_estado_civil
                          WHERE p.id_persona = :id');
        $this->db->bind(':id', $id);
        $persona = $this->db->single();
        
        if($persona) {
            // Teléfonos
            $this->db->query('SELECT * FROM telefono WHERE id_persona = :id');
            $this->db->bind(':id', $id);
            $persona->telefonos = $this->db->resultSet();
            
            // Dirección
            $this->db->query('SELECT * FROM direccion WHERE id_persona = :id');
            $this->db->bind(':id', $id);
            $persona->direccion = $this->db->single();
        }
        
        return $persona;
    }
    
    // Obtener opciones para formularios
    public function getSexos() {
        $this->db->query('SELECT * FROM sexo');
        return $this->db->resultSet();
    }
    
    public function getEstadosCiviles() {
        $this->db->query('SELECT * FROM estado_civil');
        return $this->db->resultSet();
    }
    
    // Agregar una persona con sus relaciones
    public function addUser($data) {
        try {
            // Iniciar transacción
            $this->db->query('START TRANSACTION');
            $this->db->execute();
            
            // Insertar persona
            $this->db->query('INSERT INTO persona (nombre, apellido, fecha_nacimiento, id_sexo, id_estado_civil) 
                             VALUES (:nombre, :apellido, :fecha_nacimiento, :id_sexo, :id_estado_civil)');
            
            $this->db->bind(':nombre', $data['nombre']);
            $this->db->bind(':apellido', $data['apellido']);
            $this->db->bind(':fecha_nacimiento', $data['fecha_nacimiento']);
            $this->db->bind(':id_sexo', $data['id_sexo']);
            $this->db->bind(':id_estado_civil', $data['id_estado_civil']);
            
            $this->db->execute();
            $id_persona = $this->db->lastInsertId();
            
            // Insertar teléfono(s)
            if(!empty($data['telefonos'])) {
                foreach($data['telefonos'] as $telefono) {
                    if(!empty($telefono['numero'])) {
                        $this->db->query('INSERT INTO telefono (id_persona, numero, tipo) 
                                         VALUES (:id_persona, :numero, :tipo)');
                        $this->db->bind(':id_persona', $id_persona);
                        $this->db->bind(':numero', $telefono['numero']);
                        $this->db->bind(':tipo', $telefono['tipo']);
                        $this->db->execute();
                    }
                }
            }
            
            // Insertar dirección
            if(!empty($data['direccion']['calle'])) {
                $this->db->query('INSERT INTO direccion (id_persona, calle, ciudad, estado, codigo_postal) 
                                 VALUES (:id_persona, :calle, :ciudad, :estado, :codigo_postal)');
                $this->db->bind(':id_persona', $id_persona);
                $this->db->bind(':calle', $data['direccion']['calle']);
                $this->db->bind(':ciudad', $data['direccion']['ciudad']);
                $this->db->bind(':estado', $data['direccion']['estado']);
                $this->db->bind(':codigo_postal', $data['direccion']['codigo_postal']);
                $this->db->execute();
            }
            
            // Confirmar transacción
            $this->db->query('COMMIT');
            $this->db->execute();
            
            return $id_persona;
        } catch(Exception $e) {
            // Revertir en caso de error
            $this->db->query('ROLLBACK');
            $this->db->execute();
            return false;
        }
    }
    
    // Actualizar una persona con sus relaciones
    public function updateUser($data) {
        try {
            // Iniciar transacción
            $this->db->query('START TRANSACTION');
            $this->db->execute();
            
            // Actualizar persona
            $this->db->query('UPDATE persona 
                             SET nombre = :nombre, 
                                 apellido = :apellido, 
                                 fecha_nacimiento = :fecha_nacimiento, 
                                 id_sexo = :id_sexo, 
                                 id_estado_civil = :id_estado_civil
                             WHERE id_persona = :id');
            
            $this->db->bind(':id', $data['id_persona']);
            $this->db->bind(':nombre', $data['nombre']);
            $this->db->bind(':apellido', $data['apellido']);
            $this->db->bind(':fecha_nacimiento', $data['fecha_nacimiento']);
            $this->db->bind(':id_sexo', $data['id_sexo']);
            $this->db->bind(':id_estado_civil', $data['id_estado_civil']);
            
            $this->db->execute();
            
            // Eliminar teléfonos existentes
            $this->db->query('DELETE FROM telefono WHERE id_persona = :id');
            $this->db->bind(':id', $data['id_persona']);
            $this->db->execute();
            
            // Insertar nuevos teléfonos
            if(!empty($data['telefonos'])) {
                foreach($data['telefonos'] as $telefono) {
                    if(!empty($telefono['numero'])) {
                        $this->db->query('INSERT INTO telefono (id_persona, numero, tipo) 
                                         VALUES (:id_persona, :numero, :tipo)');
                        $this->db->bind(':id_persona', $data['id_persona']);
                        $this->db->bind(':numero', $telefono['numero']);
                        $this->db->bind(':tipo', $telefono['tipo']);
                        $this->db->execute();
                    }
                }
            }
            
            // Actualizar dirección
            $this->db->query('DELETE FROM direccion WHERE id_persona = :id');
            $this->db->bind(':id', $data['id_persona']);
            $this->db->execute();
            
            if(!empty($data['direccion']['calle'])) {
                $this->db->query('INSERT INTO direccion (id_persona, calle, ciudad, estado, codigo_postal) 
                                 VALUES (:id_persona, :calle, :ciudad, :estado, :codigo_postal)');
                $this->db->bind(':id_persona', $data['id_persona']);
                $this->db->bind(':calle', $data['direccion']['calle']);
                $this->db->bind(':ciudad', $data['direccion']['ciudad']);
                $this->db->bind(':estado', $data['direccion']['estado']);
                $this->db->bind(':codigo_postal', $data['direccion']['codigo_postal']);
                $this->db->execute();
            }
            
            // Confirmar transacción
            $this->db->query('COMMIT');
            $this->db->execute();
            
            return true;
        } catch(Exception $e) {
            // Revertir en caso de error
            $this->db->query('ROLLBACK');
            $this->db->execute();
            return false;
        }
    }
    
    // Eliminar una persona y sus relaciones
    public function deleteUser($id) {
        try {
            // Iniciar transacción
            $this->db->query('START TRANSACTION');
            $this->db->execute();
            
            // Eliminar teléfonos
            $this->db->query('DELETE FROM telefono WHERE id_persona = :id');
            $this->db->bind(':id', $id);
            $this->db->execute();
            
            // Eliminar dirección
            $this->db->query('DELETE FROM direccion WHERE id_persona = :id');
            $this->db->bind(':id', $id);
            $this->db->execute();
            
            // Eliminar persona
            $this->db->query('DELETE FROM persona WHERE id_persona = :id');
            $this->db->bind(':id', $id);
            $this->db->execute();
            
            // Confirmar transacción
            $this->db->query('COMMIT');
            $this->db->execute();
            
            return true;
        } catch(Exception $e) {
            // Revertir en caso de error
            $this->db->query('ROLLBACK');
            $this->db->execute();
            return false;
        }
    }
}