<?php
class TelefonoModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerTelefonos() {
        return $this->conexion->query("SELECT * FROM telefono");
    }

    public function insertarTelefono($numero) {
        return $this->conexion->query("INSERT INTO telefono(numero) VALUES('$numero')");
    }

    public function eliminarTelefono($id) {
        return $this->conexion->query("DELETE FROM telefono WHERE id=$id");
    }

    public function obtenerTelefono($id) {
        return $this->conexion->query("SELECT * FROM telefono WHERE id=$id")->fetch_assoc();
    }

    public function actualizarTelefono($id, $numero) {
        return $this->conexion->query("UPDATE telefono SET numero='$numero' WHERE id=$id");
    }
}
?>
