<?php
require_once './manejadorDeArchivos.php';

class ConjuntoController {
    private static $_lastId = 0;

    public static function saveEntity($filename, $entity) {
        $existingEntities = ManejadorDeArchivos::readEntitiesFromFile($filename);
        $newId = self::createAutoincrementalId($existingEntities);

            $existingEntities[] = [
                'id' => $newId,
                'marca_impresora' => $entity->getMarcaImpresora(),
                'marca_cartucho' => $entity->getMarcaCartucho(),
                'modelo_impresora' => $entity->getModeloImpresora(),
                'modelo_cartucho' => $entity->getModeloCartucho(),
                'precio_total' => $entity->getPrecioTotal(),
                'tipo' => $entity->getTipo(),
            ];
        
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
}