<?php
require_once './imagen.php';
require_once './producto.php';
require_once './ventaController.php';

$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (isset($data['numeroDePedido'])) {
    $numeroDePedido = $data['numeroDePedido'];
    $filename = "ventas.json";

    $ventaExistente = VentaController::buscarVentaPorNumeroDePedido($filename, $numeroDePedido);
    if ($ventaExistente === false) {
        echo "El número de pedido ingresado no existe<br>";
    } else {
        $estadoCambiado = "borrada";
        $modificacionExitosa = VentaController::modificarEstadoVenta($filename, $numeroDePedido, $estadoCambiado);
        
        if ($modificacionExitosa) {
            // Movimiento de la imagen a la carpeta de backup
            $marca = $ventaExistente['marca'];
            $tipo = $ventaExistente['tipo'];
            $modelo = $ventaExistente['modelo'];
            $email = $ventaExistente['email'];
            $fecha = $ventaExistente['fecha'];

            $rutaImagenOriginal = './ImagenesDeVentas/2024/';
            $rutaImagenBackup = './ImagenesBackupVentas/2024/';

            $imagenMovida = Imagen::moverImagenVenta($marca, $tipo, $modelo, $email, $fecha, $rutaImagenOriginal, $rutaImagenBackup);

            if ($imagenMovida) {
                echo "La imagen asociada se movió a la carpeta de backup correctamente.<br>";
            } else {
                echo "Error al mover la imagen a la carpeta de backup.<br>";
            }

            echo "El pedido número $numeroDePedido se borró exitosamente!<br>";
        } else {
            echo "Hubo un error al hacer la baja<br>";
        }
    }
} else {
    echo "Faltan datos para borrar la venta<br>";
}

/*
    $ventaExistente = VentaController::buscarVentaPorNumeroDePedido($filename, $numeroDePedido);
    $marca = $ventaExistente['marca'];
    $tipo = $ventaExistente['tipo'];
    $modelo = $ventaExistente['modelo'];
    $email = $ventaExistente['email'];
    $fecha = $ventaExistente['fecha'];
    $imagenSubida = Imagen::updateImageVenta($marca, $tipo, $modelo, $email, $fecha, $nombreDeCarpeta, $imagen);

    if($imagenSubida === false) {
        echo "Error al subir la imagen.<br>";
    } else {
        $producto = new Producto($marca, $precio, $tipo, $modelo, $color, $stock);
        $productoCreado = ProductoController::saveEntity('tienda.json', $producto);
        if($productoCreado === false) {
            echo "Error al guardar el producto.<br>";
        } else {
            echo "El producto se guardó exitosamente.<br>";
        }
        echo "La imagen se subió exitosamente.<br>";
    }
} else {
    echo "Faltan datos para dar de alta el producto<br>";
}*/