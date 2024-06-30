<?php
require_once './ventaController.php';
require_once './productoController.php';

// A.
if (isset($_GET['fecha'])) {
    $fecha = $_GET['fecha'] ? $_GET['fecha'] : null;
    $filename = 'ventas.json';
    $ventasPorFecha = VentaController::buscarVentaPorFecha($filename, $fecha);

    if(empty($ventasPorFecha)) {
        echo "No hay ventas para la fecha proporcionada.<br>";
    } else {
        if($fecha) {
            echo "Ventas para la fecha: $fecha<br>";
        } else {
            echo "Ventas de todas las fechas:<br>";
        }
        echo "-------------------------<br>";
        foreach ($ventasPorFecha as $venta) {
            echo "id: " . $venta['id'] . "<br>";
            echo "fecha: " . $venta['fecha'] . "<br>";
            echo "email: " . $venta['email'] . "<br>";
            echo "numeroDePedido: " . $venta['numeroDePedido'] . "<br>";
            echo "marca: " . $venta['marca'] . "<br>";
            echo "tipo: " . $venta['tipo'] . "<br>";
            echo "modelo: " . $venta['modelo'] . "<br>";
            //echo "precio: " . $venta['precio'] . "<br>";
            echo "cantidadVendida: " . $venta['cantidadVendida'] . "<br>";
            echo "-------------------------<br>";
        }
    }
}

// B.
if(isset($_GET['email'])) {
    $filename = 'ventas.json';
    $emailExistente = VentaController::verificarParametroExistente($filename, 'email', $_GET['email']);
    if($emailExistente === false) {
        echo "El email ingresado no existe";
    } else {
        VentaController::mostrarVentasPorParametro($filename, 'email');
    }
}

// C.
if(isset($_GET['tipo'])) {
    $filename = 'ventas.json';
    $tipoExistente = VentaController::verificarParametroExistente($filename, 'tipo', $_GET['tipo']);
    if($tipoExistente === false) {
        echo "El tipo ingresado no existe";
    } else {
        VentaController::mostrarVentasPorParametro($filename, 'tipo');
    }
}

// D.
if(isset($_GET['precio_1']) && isset($_GET['precio_2'])) {
    $precio1 = $_GET['precio_1'];
    $precio2 = $_GET['precio_2'];
    if(VentaController::verificarPreciosVacios($precio1, $precio2) === false) {
        echo "Ingresa los precios correctamente";
    } else {
        $filename = 'ventas.json';
        $listaOrdenada = VentaController::obtenerListaEntrePrecios($filename, $precio1, $precio2);
        VentaController::mostrarListaVentas($listaOrdenada);
    }
}

/*
- El listado de ingresos (ganancia de las ventas) por día de una fecha ingresada. Si no se ingresa una fecha, se
muestran los ingresos de todos los días.
*/
// E.
if(isset($_GET['fecha_ingresos'])) {
    $fechaIngresos = $_GET['fecha_ingresos'];
    $ingresosPorDia = VentaController::ingresosPorDia('ventas.json', $fechaIngresos);
    if(!empty($fechaIngresos)) {
        echo "Ingresos por día $fechaIngresos: $ingresosPorDia<br>";
    } else {
        $todosLosDias = VentaController::ingresosPorTodosLosDias('ventas.json');
        echo "Ingresos de todos los días:<br>";
        echo "-------------------------<br>";
        foreach ($todosLosDias as $fecha => $ingresos) {
            echo "Fecha: $fecha - Ingresos: $ingresos<br>";
        }
    }
}

// F.
if(isset($_GET['productoMasVendido'])) {
    $filename = 'ventas.json';
    $productoMasVendido = VentaController::productoMasVendido($filename);
    echo "Producto más vendido: $productoMasVendido";
}