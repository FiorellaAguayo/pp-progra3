<?php

class Producto {
    private $_marca;
    private $_precio;
    private $_tipo;
    private $_modelo;
    private $_color;
    private int $_stock;

    public function __construct($marca, $precio, $tipo, $modelo, $color, $stock) {
        $this->_marca = $marca;
        $this->_precio = $precio;
        $this->_tipo = $tipo;
        $this->_modelo = $modelo;
        $this->_color = $color;
        $this->_stock = $stock;
    }

    public function getMarca() {
        return $this->_marca;
    }

    public function getPrecio() {
        return $this->_precio;
    }

    public function getTipo() {
        return $this->_tipo;
    }
   
    public function getModelo() {
        return $this->_modelo;
    }

    public function getColor() {
        return $this->_color;
    }

    public function getStock() {
        return $this->_stock;
    }

    public function setStock($newStock) {
        $this->_stock = $newStock;
    }
}