<?php

class Venta {
    private $_email;
    private $_marca;
    private $_tipo;
    private $_fecha;
    private int $_stock;
    private $_modelo;
    private $_precio;
    private $_estado;

    public function __construct($email, $marca, $tipo, $stock, $fecha, $modelo,  $estado = "activa") {
        $this->_email = $email;
        $this->_marca = $marca;
        $this->_tipo = $tipo;
        $this->_stock = $stock;
        $this->_modelo = $modelo;
        $this->_fecha = $fecha;
        $this->_estado = $estado;
    }

    public function getMarca() {
        return $this->_marca;
    }

    public function getEmail() {
        return $this->_email;
    }

    public function getTipo() {
        return $this->_tipo;
    }

    public function getStock() {
        return $this->_stock;
    }

    public function getModelo() {
        return $this->_modelo;
    }
    public function getPrecio() {
        return $this->_precio;
    }

    public function getFecha() {
        return $this->_fecha;
    }

    public function getEstado() {
        return $this->_estado;
    }

    public function setEstado($estado) {
        $this->_estado = $estado;
    }
}