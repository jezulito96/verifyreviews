<?php

namespace App\Models;
use App\Models\Categoria;
class Negocio {
    private $nombre;
    private $email;
    private $calle;
    private $ciudad;
    private $pais;
    private $telefono_negocio;
    private $fotosBD;
    private $foto_principal;
    private $coordenadas;
    private $sitio_web;
    private $categoria;
    private $nombre_titular;
    private $telefono_titular;
    private $activo;
    private $confirma_correo;

    public function __construct($nombre, $email, $calle, $ciudad, $pais, $telefono_negocio, $fotosBD, $foto_principal, $coordenadas, $sitio_web, Categoria $categoria, $nombre_titular, $telefono_titular, $activo,$confirma_correo) {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->calle = $calle;
        $this->ciudad = $ciudad;
        $this->pais = $pais;
        $this->telefono_negocio = $telefono_negocio;
        $this->fotosBD = $fotosBD;
        $this->foto_principal = $foto_principal;
        $this->coordenadas = $coordenadas;
        $this->sitio_web = $sitio_web;
        $this->categoria = $categoria;
        $this->nombre_titular = $nombre_titular;
        $this->telefono_titular = $telefono_titular;
        $this->activo = $activo;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getCalle() {
        return $this->calle;
    }

    public function getCiudad() {
        return $this->ciudad;
    }

    public function getPais() {
        return $this->pais;
    }

    public function getTelefonoNegocio() {
        return $this->telefono_negocio;
    }

    public function getFotosBD() {
        return $this->fotosBD;
    }

    public function getFotoPrincipal() {
        return $this->foto_principal;
    }

    public function getCoordenadas() {
        return $this->coordenadas;
    }

    public function getSitioWeb() {
        return $this->sitio_web;
    }

    public function getCodCategoria() {
        return $this->cod_categoria;
    }

    public function getNombreTitular() {
        return $this->nombre_titular;
    }

    public function getTelefonoTitular() {
        return $this->telefono_titular;
    }

    public function getActivo() {
        return $this->activo;
    }

    public function getConfirmaCorreo() {
        return $this->confirma_correo;
    }
}