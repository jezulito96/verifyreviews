<?php

namespace App\Models;


class Master {
    private static $instancia;
    private $listaCategorias;
    private $listaNegocios;
    public $listaResenas;

    private function __construct() {
    }

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
                $negocio = new Negocio(
                    $val['cod_negocio'], 
                    $val['nombre'], 
                    $val['email'], 
                    $val['calle'], 
                    $val['ciudad'], 
                    $val['pais'], 
                    $val['telefono_negocio'], 
                    $val['fotos'], // Cambié 'fotosBD' a 'fotos' para que coincida con el array $val
                    $val['foto_principal'], 
                    $val['coordenadas'], 
                    $val['sitio_web'], 
                    $val['cod_categoria'], 
                    $val['nombre_titular'], 
                    $val['telefono_titular'], 
                    $val['activo'],
                    $val['confirma_correo']
                );

                // $baseDatos = new BaseDatos();
                // $cat =  $baseDatos -> getListaCategorias($negocio -> getCodCategoria());
                // $nombre_categoria = $cat[0]['tipo_negocio'];
                // $negocio -> setNombreCategoria($nombre_categoria);
                $this->listaNegocios[] = $negocio;
            }
        }
        return $this->listaNegocios;
    }


    public function setNegocio($cod_negocio,$nombre, $email, $calle, $ciudad, $pais, $telefono_negocio, $fotos, $foto_principal, $coordenadas, $sitio_web, $cod_categoria, $nombre_titular, $telefono_titular, $activo, $confirma_correo) {
        // se crea objeto y se añade a la lista de negocios
        $negocio = new Negocio(
            $cod_negocio,
            $nombre, 
            $email, 
            $calle, 
            $ciudad, 
            $pais, 
            $telefono_negocio, 
            $fotos, // Cambié 'fotosBD' a 'fotos' para que coincida con el constructor de la clase Negocio
            $foto_principal, 
            $coordenadas, 
            $sitio_web, 
            $cod_categoria, 
            $nombre_titular, 
            $telefono_titular, 
            $activo,
            $confirma_correo
        );
        // $baseDatos = new BaseDatos();
        // $cat =  $baseDatos -> getListaCategorias($cod_categoria);
        // $nombre_categoria = $cat[0]['tipo_negocio'];
        // $negocio -> setNombreCategoria($nombre_categoria);
        $this->listaNegocios[] = $negocio;
    }

    public function setResena($cod_resena, $cod_negocio,$cod_usuario,$fecha_creacion,$fecha_servicio,$calificacion,$titulo,$opinion,$fotos,$qr_key,$estado,$nickname){
        $baseDatos = new BaseDatos();

        // primero tengo que sacar el qr_id del qr_key que es la clave publica 
        // $claveQr = hex2bin($qr_key);
        $id = $baseDatos ->getQr_id($qr_key);
        $baseDatos -> desactivarQr(intval($id));
        
        // después hago la insertcion a la base de datos con el id que me devuelve el metodo anterior
        if($id !=false){
            $baseDatos -> setResena($cod_resena, $cod_negocio,$cod_usuario,$fecha_creacion,$fecha_servicio,$calificacion,$titulo,$opinion,$fotos,intval($id),$estado,$nickname);
            $this->listaResenas[] = new Resena($cod_resena, $cod_negocio, $cod_usuario, $fecha_creacion, $fecha_servicio, $calificacion, $titulo, $opinion, $fotos, $id, $estado, $nickname);
            
            return true;
        }else{
            return false;
        }

    }

    public function negocios_categoria($categoria){

        $lista_negocios_cat = array();
        foreach($this -> getListaNegocios() as $key => $negocio){
            
            if($negocio -> getCodCategoria() == $categoria){
                array_push($lista_negocios_cat, $negocio);
            }
        }

        return $lista_negocios_cat;
    }

    public function getNegocio($cod_negocio){

        foreach($this -> getListaNegocios() as $key => $negocio){
            
            if($negocio -> getCodNegocio() == $cod_negocio){
                return $negocio;
            }
        }

    }

    public function getListaResenas($cod_negocio = false,$cod_usuario = false){
        
        $baseDatos = new BaseDatos();
        if ($this->listaResenas === null) {

            $this->listaResenas = array();        
            foreach($baseDatos->getlistaResenas() as $val){
                $this->listaResenas[] = new Resena($val['cod_resena'],$val['cod_negocio'],$val['cod_usuario'],$val['fecha_creacion'],$val['fecha_servicio'],$val['calificacion'],$val['titulo'],$val['opinion'],$val['fotos'],$val['qr_id'],$val['estado'],$val['nickname']);
            }
        }

        if($cod_negocio != false){
            $resenas_negocio = array();
            foreach($this -> listaResenas as $i => $resena){
                if($resena -> getCodNegocio() == $cod_negocio){
                    $resenas_negocio[] = $resena;
                }
            }

            return $resenas_negocio;
        }

        if($cod_usuario != false){
            $resenas_usuario = array();
            foreach($this -> listaResenas as $i => $resena){
                if($resena -> getCodUsuario() == $cod_usuario){
                    $resenas_usuario[] = $resena;
                }
            }
            
            return $resenas_usuario;
        }

        return $this->listaResenas;

    }

    public function setEstadisticas($cod_resena, $cod_negocio, $valoracion_final){
        $cod_categoria = 0;
        foreach($this -> getListaNegocios() as $i => $negocio){
            if($cod_negocio == $negocio -> getCodNegocio()){
                $cod_categoria = $negocio -> getCodCategoria();
            }
        }

        $baseDatos = new BaseDatos();
        $baseDatos -> setEstadisticas($cod_resena, $cod_negocio, $cod_categoria, $valoracion_final);

    }

    public function getEstadisticas($cod_negocio = false, $cod_categoria = false){

        $lista_estadisticas = array();
        $baseDatos = new BaseDatos();

        if($cod_negocio != false){

            $lista_estadisticas['nota_media'] = $baseDatos -> getNotaMediaNegocio($cod_negocio);
        }
        if($cod_categoria != false){

            $lista_estadisticas['ranking'] = $baseDatos -> getRanking($cod_categoria);
        }


        if($cod_categoria == false && $cod_negocio == false){
            $top3_categorias = array();
            
            foreach($this -> getListaCategorias() as $i => $categoria){
                $array_aux = [
                    'cod_categoria' => $categoria->getCodCategoria(),
                    'nombre_categoria' => $categoria->getTipoNegocio(),
                ];

                $ranking = $baseDatos->getRanking($categoria->getCodCategoria());
                

                $array_aux['ranking'] = $ranking;

                $lista_estadisticas[$categoria->getCodCategoria()] = $array_aux;
            }
            
            
        }

        return $lista_estadisticas;
    }

    public function filtrar($texto = false,  $filtrar = false){
        $ciudades = false;
        $categorias = false;
        $valoraciones = false;
        $resultado_busqueda = array();

        if($filtrar != false){
            foreach($this -> getListaNegocios() as $i => $negocio){

                foreach($filtrar as $i => $filtro){
                    $lista_filtros = explode("_",$filtro);
                    if($lista_filtros[0] == 1){
                        //es ciudad

                        if(preg_match("/\b$lista_filtros[1]\b/i", $negocio -> getCiudad()) ){
                            if(!in_array($negocio, $resultado_busqueda)){
                                array_push($resultado_busqueda, $negocio);
                            }
                        }else{
                            if(in_array($negocio, $resultado_busqueda)){
                                $indice = array_search($negocio, $resultado_busqueda, true);
                                unset($resultado_busqueda[$indice]);
                            }
                        }
                        
                    }elseif($lista_filtros[0] == 2){
                  
                        if(intval($lista_filtros[1]) == $negocio -> getCodCategoria()){
    
                            if(!in_array($negocio, $resultado_busqueda)){
                                array_push($resultado_busqueda, $negocio);
                            }
                        }else{
                            if(in_array($negocio, $resultado_busqueda)){
                                $indice = array_search($negocio, $resultado_busqueda, true);
                                unset($resultado_busqueda[$indice]);
                            }
                        }
                    }elseif($lista_filtros[0] == 3){
                        
                        // calculo nota media y redondeo 
                        $estadisticas = $this -> getEstadisticas($negocio -> getCodNegocio());
                        $nota_media = $estadisticas['nota_media'];
                        if(!is_int($nota_media)) $nota_media = round($nota_media);
                        // foreach($lista_filtros as $j => $filtro){
                        if(intval($lista_filtros[1]) == $nota_media){
                            
                            if(!in_array($negocio, $resultado_busqueda)){
                                array_push($resultado_busqueda, $negocio);
                            }
                        }else{
                            if(in_array($negocio, $resultado_busqueda)){
                                $indice = array_search($negocio, $resultado_busqueda, true);
                                unset($resultado_busqueda[$indice]);
                            }
                        }
                    }
                }
            }

        }
        

        if($texto != false){
            foreach($this -> getListaNegocios() as $i => $negocio){
                if(preg_match("/\b$texto\b/i", $negocio -> getNombre()) ||
                    preg_match("/\b$texto\b/i", $negocio -> getNombreCategoria()) || 
                    preg_match("/\b$texto\b/i", $negocio -> getCiudad()) ){

                        if(!in_array($negocio, $resultado_busqueda)){
                            array_push($resultado_busqueda, $negocio);
                        }
                }
            }
        }
       
        if(sizeof($resultado_busqueda) > 0){
            return $resultado_busqueda;
        }else{
            return false;
        }
        
    }
}


