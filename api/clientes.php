<?php
require_once __DIR__ . "/../modelos/CliModelo.php"; 

header("Content-Type: application/json");
// Indicamos que todas las respuestas serán en formato JSON 

$cliente = new Cliente(); 
// Creamos una instancia del modelo para poder usar sus métodos (listar, registrar, etc.).

switch ($_SERVER['REQUEST_METHOD']) { 
// Detectamos el método HTTP usado en la petición (GET, POST, PUT, DELETE).

    case 'GET':
        // Si la petición es GET, puede ser para listar todos o buscar por ID.
        if (isset($_GET['id'])) {
            // Si viene un parámetro id en la URL, buscamos un cliente específico.
            echo json_encode($cliente->buscarPorId($_GET['id']));
        } else {
            // Si no hay id, listamos todos los clientes.
            $resultado = $cliente->listar();
            echo json_encode($resultado->fetch_all(MYSQLI_ASSOC));
        }
        break;

    case 'POST':
        // Si la petición es POST, significa que queremos registrar un nuevo cliente.
        $data = json_decode(file_get_contents("php://input"), true);
        // Leemos el cuerpo de la petición en formato JSON y lo convertimos en array.
        
        $resultado = $cliente->registrar(
            $data['CliId'],
            $data['CliNombre'],
            $data['CliApellido'],
            $data['CliDireccion'],
            $data['CliEmail'],
            $data['CliFecha']
        );
        // Llamamos al método registrar del modelo con los datos recibidos.
        
        echo json_encode(["success" => $resultado]);
        // Respondemos en JSON si fue exitoso o no.
        break;

    case 'PUT':
        // Si la petición es PUT, significa que queremos editar un cliente existente.
        $data = json_decode(file_get_contents("php://input"), true);
        // Igual que en POST, leemos el JSON enviado.
        
        $resultado = $cliente->editar(
            $data['CliId'],
            $data['CliNombre'],
            $data['CliApellido'],
            $data['CliDireccion'],
            $data['CliEmail'],
            $data['CliFecha']
        );
        echo json_encode(["success" => $resultado]);
        break;

    case 'DELETE':
        // Si la petición es DELETE, queremos eliminar un cliente.
        parse_str(file_get_contents("php://input"), $data);
        // Leemos el cuerpo de la petición (puede venir como texto plano).
        
        $resultado = $cliente->eliminar($data['CliId']);
        // Llamamos al método eliminar del modelo.
        
        echo json_encode(["success" => $resultado]);
        break;
}
