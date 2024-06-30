<?php

require_once './imagen.php';
require_once './venta.php';
require_once './ventaController.php';

if(isset($_POST['email']) && isset($_POST['marca']) && isset($_POST['tipo']) && isset($_POST['modelo']) && isset($_POST['cantidad']) && isset($_FILES['imagen'])) {
    $email = $_POST['email'];
    $marca = $_POST['marca'];
    $tipo = $_POST['tipo'];
    $cantidad = $_POST['cantidad'];
    $modelo = $_POST['modelo'];
    $imagen = $_FILES['imagen'];
    $filename = 'tienda.json';
    $newFile = 'ventas.json';

    if(VentaController::validarTipo($tipo) === false) {
        echo "Los valores de tipo no son válidos.<br>";
        return;
    }

    if(VentaController::validarEmail($email) === false) {
        echo "El email no es válido.<br>";
        return;
    }

    $resultado = VentaController::searchByItem($filename, $marca, $tipo, $cantidad); // devuelve errores y en caso correcto devuelve cantidad

    switch($resultado) {
        case 1:
            echo 'No hay stock.<br>';
            break;

        case 2:
            echo 'Los valores de marca y tipo no existen.<br>';
            break;
        default:
            $fecha = VentaController::obtenerRandomDate(2023);
            $estado = "activa";
            $venta = new Venta($email, $marca, $tipo, $cantidad, $fecha, $modelo, $estado);
            $nuevoStock = $resultado;
            $entitySaved = VentaController::guardarVenta($newFile, $venta);
            $newEmail = VentaController::obtenerNombreDeEmail($email);
            $fecha = $venta->getFecha();
            $imagenSubida = Imagen::updateImageVenta($marca, $tipo, $modelo, $newEmail, $fecha, './ImagenesDeVentas/2024/', $imagen);
            
            if($entitySaved === false) {
                echo "Hubo un error al hacer el alta de venta<br>";
                return;
            } else {
                echo "Se agregó una venta exitosamente!<br>";
            }

            if($imagenSubida === false) {
                echo "Error al subir la imagen.<br>";
            } else {
                echo "La imagen se subio exitosamente.<br>";
            }
            break;
    }

} else {
    echo "Faltan datos para dar de alta la venta<br>";
}