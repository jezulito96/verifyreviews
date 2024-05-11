<?php

namespace App\Models;


class Master {
    private static $instancia;
    private $listaCategorias;
    private $listaNegocios;

    private $listaResenas;

    private function __construct() {}

    public static function obtenerInstancia() {
        if (self::$instancia === null) {
            self::$instancia = new Master();
        }
        return self::$instancia;
    }

    public function getListaCategorias() {
        $baseDatos = new BaseDatos();
        if ($this->listaCategorias === null) {

            $this->listaCategorias = array();        
            foreach($baseDatos->getListaCategorias() as $val){
                $this->listaCategorias[] = new Categoria($val['cod_categoria'], $val['tipo_negocio']);
            }
        }
        
        return $this->listaCategorias;
    }

    public function getListaNegocios() {
        $baseDatos = new BaseDatos();
        if ($this->listaNegocios === null) {

            $this->listaNegocios = array();        
                foreach($baseDatos->getListaNegocios() as $val){
                    $this->listaNegocios[] = new Negocio($val['nombre'], $val['email'], $val['calle'], $val['ciudad'], $val['pais'], $val['telefono_negocio'], $val['fotos'], $val['foto_principal'], $val['coordenadas'], $val['sitio_web'], $val['cod_categoria'], $val['nombre_titular'], $val['telefono_titular'], $val['activo'], $val['confirma_correo']
                );
            }
        }
        
        return $this->listaNegocios;
    }

    public function setNegocio($nombre, $email, $calle, $ciudad, $pais, $telefono_negocio, $fotos, $foto_principal, $coordenadas, $sitio_web, $cod_categoria, $nombre_titular, $telefono_titular, $activo, $confirma_correo){
        // se crea objeto y se añade a la lista de negocios
        $this->listaNegocios[] = new Negocio($nombre, $email, $calle, $ciudad, $pais, $telefono_negocio, $fotos, $foto_principal, $coordenadas, $sitio_web, $cod_categoria, $nombre_titular, $telefono_titular, $activo, $confirma_correo);
    }

    // public function setListaResenas($cod_negocio){

    // }

    // public function setTopResenas(){

    // }

    public function setResena($cod_reseña, $cod_negocio,$cod_usuario,$fecha_creacion,$fecha_servicio,$calificacion,$titulo,$opinion,$fotos,$qr_id,$estado){
        
        $baseDatos = new BaseDatos();

        // $this->listaNegocios[];
        


    }



}


