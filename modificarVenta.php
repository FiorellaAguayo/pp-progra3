<?php
require_once './ventaController.php';

$input = file_get_contents("php://input");
$data = json_decode($input, true);

/*
(1 pt.) ModificarVenta.php (por PUT)
Debe recibir el número de pedido, el email del usuario, la Marca, Tipo, Modelo y Cantidad. Si existe, se modifica;
de lo contrario, informar que no existe ese número de pedido.
*/
if (isset($data['numeroDePedido']) && isset($data['email']) && isset($data['marca']) && isset($data['tipo']) && isset($data['modelo']) && isset($data['cantidad'])) {
    $filename = 'ventas.json';
    $numeroDePedido = $data['numeroDePedido'];
    $email = $data['email'];
    $marca = $data['marca'];
    $tipo = $data['tipo'];
    $modelo = $data['modelo'];
    $cantidad = $data['cantidad'];

    $numeroDePedidoExistente = VentaController::verificarParametroExistente($filename, 'numeroDePedido', $numeroDePedido);
    if($numeroDePedidoExistente === false) {
        echo "El número de pedido ingresado no existe<br>";
    } else {
        $modificacionExitosa = VentaController::modificarVenta($filename, $numeroDePedido, $email, $marca, $tipo, $modelo, $cantidad);
        
        if($modificacionExitosa) {
            echo "La modificación del pedido número $numeroDePedido fue exitosa!<br>";
        } else {
            echo "Hubo un error al hacer la modificación<br>";
        }
    }
} else {
    echo "Faltan datos para modificar la venta<br>";
}