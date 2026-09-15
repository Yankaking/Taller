<?php
require_once __DIR__ . "/../config/conexion.php";

class Cliente
{
    private $conexion;

    public function __construct()
    {
        $conexion = new Conexion();
        $this->conexion = $conexion->conectar();
    }

    public function listar()
    {
        $sql = "SELECT * FROM clientes ORDER BY CliId DESC";
        return $this->conexion->query($sql);
    }

    public function registrar($id, $nombre, $apellido, $direccion, $email, $fecha)
    {
        // Validar que el email no esté repetido
        if (!empty($email)) {
            $sql = "SELECT CliId FROM clientes WHERE CliEmail = ?";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bind_param("s", $email);
            $sentencia->execute();
            $resultado = $sentencia->get_result();

            if ($resultado->num_rows > 0) {
                return "El correo electrónico ya está registrado";
            }
        }

        $sql = "INSERT INTO clientes (CliId, CliNombre, CliApellido, CliDireccion, CliEmail, CliFecha)
                VALUES (?, ?, ?, ?, ?, ?)";
        $sentencia = $this->conexion->prepare($sql);
        $sentencia->bind_param("isssss", $id, $nombre, $apellido, $direccion, $email, $fecha);

        return $sentencia->execute() ? true : false;
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT * FROM clientes WHERE CliId = ?";
        $sentencia = $this->conexion->prepare($sql);
        $sentencia->bind_param("s", $id);
        $sentencia->execute();
        return $sentencia->get_result()->fetch_assoc();
    }

    public function editar($id, $nombre, $apellido, $direccion, $email, $fecha)
    {
        $sql = "UPDATE clientes
                SET CliNombre = ?, CliApellido = ?, CliDireccion = ?, CliEmail = ?, CliFecha = ?
                WHERE CliId = ?";
        $sentencia = $this->conexion->prepare($sql);
        $sentencia->bind_param("ssssss", $nombre, $apellido, $direccion, $email, $fecha, $id);

        return $sentencia->execute();
    }

   public function eliminar($id)
{
    // 1. Eliminar mantenimientos de los vehículos del cliente
    $sqlMantenimientos = "DELETE FROM mantenimientos 
                          WHERE VePlaca IN (SELECT VePlaca FROM vehiculos WHERE CliId = ?)";
    $stmtMantenimientos = $this->conexion->prepare($sqlMantenimientos);
    $stmtMantenimientos->bind_param("i", $id);
    $stmtMantenimientos->execute();

    // 2. Eliminar vehículos asociados al cliente
    $sqlVehiculos = "DELETE FROM vehiculos WHERE CliId = ?";
    $stmtVehiculos = $this->conexion->prepare($sqlVehiculos);
    $stmtVehiculos->bind_param("i", $id);
    $stmtVehiculos->execute();

    // 3. Eliminar cliente
    $sqlCliente = "DELETE FROM clientes WHERE CliId = ?";
    $stmtCliente = $this->conexion->prepare($sqlCliente);
    $stmtCliente->bind_param("i", $id);

    return $stmtCliente->execute();
}

}
?>
