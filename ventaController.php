<?php
require_once './manejadorDeArchivos.php';
require_once './productoController.php';

class VentaController {
    public static function guardarVenta($filename, $venta) {
        $existingEntities = ManejadorDeArchivos::readEntitiesFromFile($filename);
        $nuevoID = ProductoController::createAutoincrementalId($existingEntities);
        $numeroPedido = uniqid();
        $precioProducto = self::obtenerPrecioProducto($venta->getMarca(), $venta->getTipo());
        //$estado = true;

        if($precioProducto === false) {
            echo "Error: Producto no encontrado al obtener precio.";
            return false;
        }
    
        $existingEntities[] = [
            'id' => $nuevoID,
            'fecha' => $venta->getFecha(),
            'numeroDePedido' => $numeroPedido,
            'email' => $venta->getEmail(),
            'marca' => $venta->getMarca(),
            'tipo' => $venta->getTipo(),
            'modelo' => $venta->getModelo(),
            'cantidad' => $venta->getStock(),
            'precio' => $precioProducto,
            'estado' => $venta->getEstado(),
        ];
    
        return ManejadorDeArchivos::writeEntitiesToFile($filename, $existingEntities);
    }

    private static function obtenerPrecioProducto($marca, $tipo) {
        $productos = ManejadorDeArchivos::readEntitiesFromFile('tienda.json');
        foreach ($productos as $producto) {
            if ($producto['marca'] === $marca && $producto['tipo'] === $tipo) {
                return $producto['precio'];
            }
        }
        return false;
    }

    public static function searchByItem($filename, $marca, $tipo, $stock) {
        $existingEntities = ManejadorDeArchivos::readEntitiesFromFile($filename);
    
        foreach($existingEntities as &$existingEntity)  {
            if($existingEntity['marca'] === $marca && $existingEntity['tipo'] === $tipo) {
                if($existingEntity['stock'] >= $stock) {
                    $existingEntity['stock'] -= $stock;
                    ManejadorDeArchivos::writeEntitiesToFile($filename, $existingEntities);
                    return $existingEntity['stock'];
                }
                return 1;
            }
        }
        return 2;
    }

    // -------------------------------------- VENTAS_CONSULTAR ---------------------------------------

    public static function buscarVentaPorFecha($filename, $fecha = null) {
        $ventas = ManejadorDeArchivos::readEntitiesFromFile($filename);
        $ventasPorFecha = [];
        foreach ($ventas as $venta) {
            if ($fecha === null || $venta['fecha'] === $fecha) {
                $ventasPorFecha[] = $venta;
            }
        }
        return $ventasPorFecha;
    }

    public static function verificarParametroExistente($filename, $clave, $valor) {
        $existingEntities = ManejadorDeArchivos::readEntitiesFromFile($filename);
        foreach($existingEntities as &$existingEntity) {
            if($existingEntity[$clave] === $valor) {
                return true;    
            }
        }
        return false;
    }

    private static function obtenerListaVentasPorParametro($filename, $clave, $valor) {
        $listaVentas = [];
        $existingEntities = ManejadorDeArchivos::readEntitiesFromFile($filename);
        foreach($existingEntities as $existingEntity) {
            if($existingEntity[$clave] === $valor) {
                $listaVentas[] = $existingEntity;
            }
        }
        return $listaVentas;
    }

    public static function mostrarVentasPorParametro($filename, $clave) {
        $valor = $_GET[$clave];
        $ventasPorParametro = self::obtenerListaVentasPorParametro($filename, $clave, $valor);

        echo "Ventas por $clave: $valor<br>";
        echo "-------------------------<br>";
        foreach ($ventasPorParametro as $venta) {
            echo "id: " . $venta['id'] . "<br>";
            echo "fecha: " . $venta['fecha'] . "<br>";
            echo "email: " . $venta['email'] . "<br>";
            echo "numeroDePedido: " . $venta['numeroDePedido'] . "<br>";
            echo "marca: " . $venta['marca'] . "<br>";
            echo "tipo: " . $venta['tipo'] . "<br>";
            echo "modelo: " . $venta['modelo'] . "<br>";
            // echo "precio: " . $venta['precio'] . "<br>";
            echo "cantidad: " . $venta['cantidad'] . "<br>";
            echo "estado: " . $venta['estado'] . "<br>";
            echo "-------------------------<br>";
        }
    }

    public static function obtenerListaEntrePrecios($filename, $precio1, $precio2) {
        $existingEntities = ManejadorDeArchivos::readEntitiesFromFile($filename);
        $listaFiltrada = [];
        foreach ($existingEntities as $entity)  {
            $precio = $entity['precio'];
            if ($precio >= $precio1 && $precio <= $precio2) {
                $listaFiltrada[] = $entity;
            }
        }
        return $listaFiltrada;
    }

    public static function mostrarListaVentas($lista) {
        foreach ($lista as $producto) {
            echo "id: " . $producto['id'] . "<br>";
            echo "fecha: " . $producto['fecha'] . "<br>";
            echo "email: " . $producto['email'] . "<br>";
            echo "numeroDePedido: " . $producto['numeroDePedido'] . "<br>";
            echo "marca: " . $producto['marca'] . "<br>";
            echo "tipo: " . $producto['tipo'] . "<br>";
            echo "modelo: " . $producto['modelo'] . "<br>";
            echo "precio: " . $producto['precio'] . "<br>";
            echo "cantidad: " . $producto['cantidad'] . "<br>";
            echo "estado: " . $producto['estado'] . "<br>";
            echo "-------------------------<br>";
        }
    }

    public static function verificarPreciosVacios($precio1, $precio2) {
        if($precio1 === '' || $precio2 === '') {
            return false;
        }
        return true;
    }

    public static function ingresosPorDia($filename, $fecha) {
        $ventas = ManejadorDeArchivos::readEntitiesFromFile($filename);
        $ingresos = 0;
        foreach ($ventas as $venta) {
            if ($venta['fecha'] === $fecha) {
                $ingresos += $venta['cantidad'] * $venta['precio'];
            }
        }
        return $ingresos;
    }

    public static function productoMasVendido($filename) {
        $ventas = ManejadorDeArchivos::readEntitiesFromFile($filename);
        $productosVendidos = [];
        
        foreach ($ventas as $venta) {
            $producto = $venta['marca'] . ' - ' . $venta['tipo'];
            if (isset($productosVendidos[$producto])) {
                $productosVendidos[$producto] += $venta['cantidad'];
            } else {
                $productosVendidos[$producto] = $venta['cantidad'];
            }
        }

        $maxCantidad = 0;
        $productoMasVendido = null;
        foreach ($productosVendidos as $producto => $cantidad) {
            if ($cantidad > $maxCantidad) {
                $maxCantidad = $cantidad;
                $productoMasVendido = $producto;
            }
        }

        return $productoMasVendido;
    }

    public static function ingresosPorTodosLosDias($filename) {
        $ventas = ManejadorDeArchivos::readEntitiesFromFile($filename);
        $ingresosPorDia = [];
        foreach ($ventas as $venta) {
            $fecha = $venta['fecha'];
            $ingresosPorDia[$fecha] = isset($ingresosPorDia[$fecha]) ? $ingresosPorDia[$fecha] : 0;
            $ingresosPorDia[$fecha] += $venta['cantidad'] * $venta['precio'];
        }
        return $ingresosPorDia;
    }

    // -------------------------------------- MODIFICAR_VENTA --------------------------------------

    public static function modificarVenta($filename, $numeroDePedido, $email, $marca, $tipo, $modelo, $cantidad) {
        $existingEntities = ManejadorDeArchivos::readEntitiesFromFile($filename);
        $modificacionExitosa = false;
    
        foreach($existingEntities as &$existingEntity) {
            if($existingEntity['numeroDePedido'] === $numeroDePedido) {
                $existingEntity['email'] = $email;
                $existingEntity['marca'] = $marca;
                $existingEntity['tipo'] = $tipo;
                $existingEntity['modelo'] = $modelo;
                $existingEntity['cantidad'] = $cantidad;
                $modificacionExitosa = true;
                break;
            }
        }
    
        if($modificacionExitosa) {
            return ManejadorDeArchivos::writeEntitiesToFile($filename, $existingEntities);
        } else {
            return false;
        }
    }

    // -------------------------------------- DELETE_VENTA --------------------------------------

    public static function modificarEstadoVenta($filename, $numeroDePedido, $nuevoEstado) {
        $existingEntities = ManejadorDeArchivos::readEntitiesFromFile($filename);
        $modificacionExitosa = false;

        foreach ($existingEntities as &$existingEntity) {
            if ($existingEntity['numeroDePedido'] === $numeroDePedido) {
                $existingEntity['estado'] = $nuevoEstado;
                $modificacionExitosa = true;
                break;
            }
        }

        if ($modificacionExitosa) {
            return ManejadorDeArchivos::writeEntitiesToFile($filename, $existingEntities);
        } else {
            return false;
        }
    }

    public static function buscarVentaPorNumeroDePedido($filename, $numeroDePedido) {
        $ventas = ManejadorDeArchivos::readEntitiesFromFile($filename);
        foreach ($ventas as $venta) {
            if ($venta['numeroDePedido'] === $numeroDePedido) {
                return $venta;
            }
        }
        return false;
    }
    // -------------------------------------- VALIDACIONES --------------------------------------

    public static function validarTipo($tipo) {
        if($tipo !== 'impresora' && $tipo !== 'cartucho') {
            return false;
        }
        return true;
    }

    public static function validarEmail($email) {
        if(strpos($email, '@') === false && strpos($email, '.') === false) {
            return false;
        }
        return true;
    }

    public static function obtenerRandomDate($añoInicio) {
        $startTimestamp = strtotime("$añoInicio-01-01");
        $endTimestamp = time();
        $randomTimestamp = mt_rand($startTimestamp, $endTimestamp);
        $fechaRandom = date('Y-m-d', $randomTimestamp);
        return $fechaRandom;
    }

    public static function obtenerNombreDeEmail($email) {
        $partes = explode('@', $email);
        return $partes[0];
    }
}