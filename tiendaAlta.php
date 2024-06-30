<?php
require_once './imagen.php';
require_once './producto.php';
require_once './productoController.php';

if(isset($_POST['marca']) && isset($_POST['precio']) && isset($_POST['tipo']) && isset($_POST['modelo']) && isset($_POST['color']) && isset($_POST['stock']) && isset($_FILES['imagen'])) {
    $marca = $_POST['marca'];
    $precio = $_POST['precio'];
    $tipo = $_POST['tipo'];
    $modelo = $_POST['modelo'];
    $color = $_POST['color'];
    $stock = $_POST['stock'];
    $imagen = $_FILES['imagen'];
    $nombreDeCarpeta = './ImagenesDeProductos/2024/';

    $imagenSubida = Imagen::subirImagen($marca, $tipo, $imagen, $nombreDeCarpeta);

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
}