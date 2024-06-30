<?php
require_once './productoController.php';

if(isset($_POST['marca']) && isset($_POST['tipo']) && isset($_POST['color'])) {
    $marca = $_POST['marca'];
    $tipo = $_POST['tipo'];
    $color = $_POST['color'];

    $productoExiste = ProductoController::searchExistingEntity('tienda.json', $marca, $tipo, $color);

    switch($productoExiste) {
        case 1:
            echo "No existe el color";
            break;

        case 2:
            echo "No existe el tipo y el color";
            break;

        case 3:
            echo "Existe";
            break;

        case 4:
            echo "No existe el tipo";
            break;
        
        case 5:
            echo "No existe la marca";
            break;
            
        default:
            echo "No existen el tipo, el color y la marca";
            break;
    }

} else {
    echo "Faltan datos para dar de alta el producto<br>";
}