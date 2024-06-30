<?php

class Imagen {
    public static function subirImagen($marca, $tipo, $imagen, $nombreDeCarpeta) {
        $nombreArchivo = $marca . '_' . $tipo;
        $extension = pathinfo($imagen['name'], PATHINFO_EXTENSION);
        $nombreArchivo .= '.' . $extension;
        $rutaImagen = $nombreDeCarpeta . $nombreArchivo;
        
        if(move_uploaded_file($imagen['tmp_name'], $rutaImagen)) {
            return true;
        } else {
            return false;
        }
    }

    public static function updateImageVenta($marca, $tipo, $modelo, $email, $fecha, $folderName, $imagen) {
        $nombreArchivo = $marca . '_' . $tipo . '_' . $modelo . '_' . $email . '_' . $fecha;
        $extension = pathinfo($imagen['name'], PATHINFO_EXTENSION);
        $nombreArchivo .= '.' . $extension;
        $rutaImagen = $folderName . $nombreArchivo;
        
        if(move_uploaded_file($imagen['tmp_name'], $rutaImagen)) {
            return true;
        } else {
            return false;
        }
    }

    public static function moverImagenVenta($marca, $tipo, $modelo, $email, $fecha, $rutaOrigen, $rutaDestino) {
        $newEmail = VentaController::obtenerNombreDeEmail($email);
        $nombreArchivo = $marca . '_' . $tipo . '_' . $modelo . '_' . $newEmail . '_' . $fecha;
        $extension = 'jpg';
        $nombreArchivo .= '.' . $extension;
        $rutaImagenOrigen = $rutaOrigen . $nombreArchivo;
        $rutaImagenDestino = $rutaDestino . $nombreArchivo;
    
        if (rename($rutaImagenOrigen, $rutaImagenDestino)) {
            return true;
        } else {
            return false;
        }
    }

    public static function subirImagenConjunto($marcaImpresora, $marcaCartucho, $imagen, $nombreDeCarpeta) {
        $nombreArchivo = $marcaImpresora . '_' . $marcaCartucho;
        $extension = pathinfo($imagen['name'], PATHINFO_EXTENSION);
        $nombreArchivo .= '.' . $extension;
        $rutaImagen = $nombreDeCarpeta . $nombreArchivo;
        
        if(move_uploaded_file($imagen['tmp_name'], $rutaImagen)) {
            return true;
        } else {
            return false;
        }
    }
}