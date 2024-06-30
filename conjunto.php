<?php

class Conjunto {
    private $_marca_impresora;
    private $_marca_cartucho;
    private $_modelo_impresora;
    private $_modelo_cartucho;
    private $_precio_total;
    private $_tipo;

    public function __construct($marca_impresora, $marca_cartucho, $modelo_impresora, $modelo_cartucho, $precio_total, $tipo) {
        $this->_marca_impresora = $marca_impresora;
        $this->_marca_cartucho = $marca_cartucho;
        $this->_modelo_impresora = $modelo_impresora;
        $this->_modelo_cartucho = $modelo_cartucho;
        $this->_precio_total = $precio_total;
        $this->_tipo = $tipo;
    }

    public function getMarcaImpresora() {
        return $this->_marca_impresora;
    }

    public function getMarcaCartucho() {
        return $this->_marca_cartucho;
    }

    public function getModeloImpresora() {
        return $this->_modelo_impresora;
    }

    public function getModeloCartucho() {
        return $this->_modelo_cartucho;
    }

    public function getPrecioTotal() {
        return $this->_precio_total;
    }

    public function getTipo() {
        return $this->_tipo;
    }
}