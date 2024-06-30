<?php
require_once './manejadorDeArchivos.php';

class ProductoController {
    private static $_lastId = 0;

    public static function saveEntity($filename, $entity) {
        $existingEntities = ManejadorDeArchivos::readEntitiesFromFile($filename);
        $newId = self::createAutoincrementalId($existingEntities);
        $updated = self::updateEntity($existingEntities, $entity);

        if($updated === false) {
            $existingEntities[] = [
                'id' => $newId,
                'marca' => $entity->getMarca(),
                'precio' => $entity->getPrecio(),
                'tipo' => $entity->getTipo(),
                'modelo' => $entity->getModelo(),
                'color' => $entity->getColor(),
                'stock' => $entity->getStock(),
            ];
        }
        return ManejadorDeArchivos::writeEntitiesToFile($filename, $existingEntities);
    }
    
    public static function createAutoincrementalId($entities) {
        if(empty($entities)) {
            self::$_lastId = 0;
        } else {
            $lastEntity = end($entities);
            self::$_lastId = $lastEntity['id'];
        }
        self::$_lastId++;
        return self::$_lastId;
    }

    private static function updateEntity(&$existingEntities, $entity) {
        foreach ($existingEntities as &$existingEntity) {
            if ($existingEntity['tipo'] === $entity->getTipo() && $existingEntity['marca'] === $entity->getMarca()) {
                $existingEntity['precio'] = $entity->getPrecio();
                $existingEntity['stock'] += $entity->getStock();
                return true;
            }
        }
        return false;
    }

    public static function searchExistingEntity($filename, $marca, $tipo, $color) {
        $existingEntities = ManejadorDeArchivos::readEntitiesFromFile($filename);
        foreach($existingEntities as $existingEntity) {
            if($existingEntity['tipo'] === $tipo && $existingEntity['marca'] === $marca && $existingEntity['color'] === $color) {
                return 3; //Existe
            }
    
            if($existingEntity['marca'] === $marca) {
                $marcaExiste = true;
            }
    
            if($existingEntity['tipo'] === $tipo) {
                $tipoExiste = true;
            }

            if($existingEntity['color'] === $color) {
                $colorExiste = true;
            }
            
        }
    
        if(isset($marcaExiste) && !isset($tipoExiste) && !isset($colorExiste)) {
            return 2;
        }

        if (isset($marcaExiste) && isset($tipoExiste) && !isset($colorExiste)) {
            return 1;
        }

        if (isset($marcaExiste) && !isset($tipoExiste) && isset($colorExiste)) {
            return 4;
        }

        if (!isset($marcaExiste) && isset($tipoExiste) && isset($colorExiste)) {
            return 5;
        }
    
        return 0;
    }

    public static function verificarProductoPorMarcaYModelo($filename, $marca, $modelo) {
        $existingEntities = ManejadorDeArchivos::readEntitiesFromFile($filename);
    
        foreach($existingEntities as &$existingEntity)  {
            if($existingEntity['marca'] === $marca && $existingEntity['modelo'] === $modelo) {
                return true;
            }
        }
        return false;
    }

    public static function obtenerPrecioPorMarcaYModelo($filename, $marca, $modelo) {
        $productos = ManejadorDeArchivos::readEntitiesFromFile($filename);
        foreach ($productos as $producto) {
            if ($producto['marca'] === $marca && $producto['modelo'] === $modelo) {
                return $producto['precio'];
            }
        }
        return false;
    }
}