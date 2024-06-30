<?php

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "Los resultados son de acción POST<br>";
    if(isset($_POST['accion'])) {
        $accion = $_POST['accion'];

        switch($accion) {
            case 'tienda_alta':
                require './tiendaAlta.php';
                break;

            case 'producto_consultar':
                require './productoConsultar.php';
                break;

            case 'alta_venta':
                require './altaVenta.php';
                break;

            case 'alta_conjuntos':
                require './altaConjuntos.php';
                break;
        }
    } else {
        echo "No se especificó la acción";
    }
}

if($_SERVER['REQUEST_METHOD'] === 'GET')
{
    echo "Los resultados son de acción GET<br>";
    if(isset($_GET['accion'])) {
        $accion = $_GET['accion'];
        switch($accion) {
            case 'consultas_ventas':
                require './consultasVentas.php';
                break;
        }
    } else {
        echo "No se especificó la acción";
    }
}

if($_SERVER['REQUEST_METHOD'] === 'PUT')
{
    echo "Los resultados son de acción PUT<br>";
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);
    $accion = $data['accion'];
    if(isset($accion)) {
        switch($accion) {
            case 'modificar_venta':
                require './modificarVenta.php';
                break;
        }
    }
}

if($_SERVER['REQUEST_METHOD'] === 'DELETE')
{
    echo "Los resultados son de acción DELETE<br>";
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);
    $accion = $data['accion'];
    if(isset($accion)) {
        switch($accion) {
            case 'borrar_venta':
                require './borrarVenta.php';
                break;
        }
    }
}