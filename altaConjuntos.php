<?php
require_once './imagen.php';
require_once './conjunto.php';
require_once './productoController.php';
require_once './conjuntoController.php';

if(isset($_POST['impresora_marca']) && isset($_POST['impresora_modelo']) && isset($_POST['cartucho_marca']) && isset($_POST['cartucho_modelo']) && isset($_POST['tipo']) && isset($_FILES['imagen'])) {
    $impresora_marca = $_POST['impresora_marca'];
    $impresora_modelo = $_POST['impresora_modelo'];
    $cartucho_marca = $_POST['cartucho_marca'];
    $cartucho_modelo = $_POST['cartucho_modelo'];
    $tipo = $_POST['tipo'];
    $imagen = $_FILES['imagen'];
    $nombreDeCarpeta = './ImagenesDeConjuntos/2024/';
    $filename = 'tienda.json';

    $imagenSubida = Imagen::subirImagenConjunto($impresora_marca, $cartucho_marca, $imagen, $nombreDeCarpeta);

    if($imagenSubida === false) {
        echo "Error al subir la imagen.<br>";
    } else {
        $impresoraExiste = ProductoController::verificarProductoPorMarcaYModelo($filename, $impresora_marca, $impresora_modelo);
        $cartuchoExiste = ProductoController::verificarProductoPorMarcaYModelo($filename, $cartucho_marca, $cartucho_modelo);
        if($impresoraExiste === false || $cartuchoExiste === false) {
            echo "No existe esa marca y/o ese modelo.<br>";
        } else {
            $precioImpresora = ProductoController::obtenerPrecioPorMarcaYModelo($filename, $impresora_marca, $impresora_modelo);
            $precioCartucho = ProductoController::obtenerPrecioPorMarcaYModelo($filename, $cartucho_marca, $cartucho_modelo);
            $precio_total = $precioImpresora + $precioCartucho;

            $conjunto = new Conjunto($impresora_marca, $cartucho_marca, $impresora_modelo, $cartucho_modelo, $precio_total, $tipo);
            $conjuntoCreado = ConjuntoController::saveEntity('tienda.json', $conjunto);
            if($conjuntoCreado === false) {
                echo "Error al guardar el producto.<br>";
            } else {
                echo "El producto se guardó exitosamente.<br>";
            }
        }
        echo "La imagen se subió exitosamente.<br>";
    }
} else {
    echo "Faltan datos para dar de alta del conjunto<br>";
}