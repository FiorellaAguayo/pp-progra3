<?php

class ManejadorDeArchivos {
    public static function toJSON($entities)
    {
        return json_encode($entities, JSON_PRETTY_PRINT);
    }
    
    public static function readEntitiesFromFile($filename)
    {
        if(!file_exists($filename)) 
        {
            return [];
        }

        $data = file_get_contents($filename);
        return json_decode($data, true) ?? [];
    }

    public static function writeEntitiesToFile($filename, $entities)
    {
        $entityJSON = self::toJSON($entities);
        if(false === file_put_contents($filename, $entityJSON)) 
        {
            echo "Error al escribir en el archivo.";
            return false;
        }
        return true;
    }
}