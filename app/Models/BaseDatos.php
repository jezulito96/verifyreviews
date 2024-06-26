<?php
namespace App\Models;

use CodeIgniter\Model;
use Predis\Connection\Parameters;


class BaseDatos extends Model
{

    function getListaCategorias($cod_categoria = false)
    {

        $where = " ";
        if($cod_categoria != false){
            $where = " WHERE cod_categoria=" . intval($cod_categoria);
        }

        $orden = "SELECT cod_categoria, tipo_negocio FROM categoria ". $where;

        $listaCategorias = $this->db->query($orden);


        return $listaCategorias->getResultArray();
    }


    function getListaNegocios()
    {

        $orden = "SELECT 
        cod_negocio,nombre, contrasena, email,calle,ciudad,pais,telefono_negocio, fotos,foto_principal, coordenadas,sitio_web,
        cod_categoria, nombre_titular,telefono_titular,activo, confirma_correo, cod_confirmacion, cod_recordar_contrasena,fecha_creacion
        FROM negocio";
        $listaNegocios = $this->db->query($orden);


        return $listaNegocios->getResultArray();
    }

    function setNegocio($nombre,$contrasena_negocio, $email, $calle, $ciudad, $pais, $telefono_negocio, $fotos, $foto_principal, $coordenadas, $sitio_web, $cod_categoria, $nombre_titular, $telefono_titular, $activo, $confirma_correo, $cod_confirmacion,$codigo_recordar_contrasena)
    {   
        
        $orden = "INSERT INTO negocio (nombre, contrasena,  email, calle, ciudad, pais, telefono_negocio, fotos, foto_principal, coordenadas, sitio_web, cod_categoria, nombre_titular, telefono_titular, activo, confirma_correo, cod_confirmacion, cod_recordar_contrasena, fecha_creacion) VALUES ('" . $nombre .  "', '"  . $contrasena_negocio . "', '"  . $email . "', '" . $calle . "', '" . $ciudad . "', '" . $pais . "', '" . $telefono_negocio . "', '" . $fotos . "', '" . $foto_principal . "', '" . $coordenadas . "', '" . $sitio_web . "', " . $cod_categoria . ", '" . $nombre_titular . "', '" . $telefono_titular . "', '" . $activo . "', '" . $confirma_correo . "', '" . $cod_confirmacion . "','" . $codigo_recordar_contrasena . "', NOW())";


        $this->db->query($orden);
    }

    function comprobarNegocio($nombre){
        $orden = "SELECT cod_negocio FROM negocio WHERE nombre=?";
            $parametros = [$nombre];
            $consulta = $this -> db -> query($orden, $parametros);
            $numeroFilas = $consulta -> getNumRows();
    
        if($numeroFilas > 0 ){
            return true;
        }else{
            return false;
        }
    }

    function comprobarUsuario($nickname){
        $orden = "SELECT cod_usuario FROM usuario_registrado WHERE nickname=?";
            $parametros = [$nickname];
            $consulta = $this -> db -> query($orden, $parametros);
            $numeroFilas = $consulta -> getNumRows();
    
        if($numeroFilas > 0 ){
            return true;
        }else{
            return false;
        }
    }

    function comprobarcorreoUsuario($email){
        $orden = "SELECT cod_usuario FROM usuario_registrado WHERE email=?";
            $parametros = [$email];
            $consulta = $this -> db -> query($orden, $parametros);
            $numeroFilas = $consulta -> getNumRows();
    
        if($numeroFilas > 0 ){
            return true;
        }else{
            return false;
        }
    }
    function comprobarCorreo($codigoConfirmacion,$tipo) {
        if($tipo == 1 || $tipo == "1"){
            $orden = "SELECT cod_confirmacion FROM usuario_registrado WHERE cod_confirmacion ='".  $codigoConfirmacion  ."'";
            $consulta = $this -> db -> query($orden);
            $numeroFilas = $consulta -> getNumRows();
    
            if($numeroFilas > 0 ){
                return true;
            }else{
                return false;
            }
        }else if($tipo == 2 || $tipo == "2"){
            $orden = "SELECT cod_confirmacion FROM negocio WHERE cod_confirmacion ='".  $codigoConfirmacion  ."'";
            $consulta = $this -> db -> query($orden);
            $numeroFilas = $consulta -> getNumRows();
    
            if($numeroFilas > 0 ){
                return true;
            }else{
                return false;
            }
        }else{
            // si no coincide el tipo
            return false;
        }
    }

    function confirmarCorreo($codigoConfirmacion,$tipo){
        if($tipo == 1 || $tipo == "1"){
            $orden = "UPDATE usuario SET confirma_correo = 1 WHERE cod_confirmacion ='".  $codigoConfirmacion  ."'";
            $this -> db -> query($orden);
        }else if($tipo == 2 || $tipo == "2"){
            $orden = "UPDATE negocio SET confirma_correo = 1 WHERE cod_confirmacion ='".  $codigoConfirmacion  ."'";
            $this -> db -> query($orden);
        }else{
            // si no coincide el tipo
            return false;
        }
    }

    function setUsuario($cod_usuario,$nombre, $apellidos, $nickname, $foto_perfil, $hash_contrasena, $ciudad, $pais, $coordenadas, $fecha_nacimiento, $email, $telefono, $activo, $confirma_correo,$codigoConfirmacion,$codigo_recordar_contrasena){

        $orden = "INSERT INTO usuario_registrado (cod_usuario,nombre, apellidos, nickname, foto_perfil, contrasena, ciudad, pais, coordenadas, fecha_nacimiento, email, telefono, activo, confirma_correo, cod_confirmacion, cod_recordar_contrasena, fecha_creacion) VALUES ($cod_usuario,'$nombre', '$apellidos', '$nickname', '$foto_perfil', '$hash_contrasena', '$ciudad', '$pais', '$coordenadas', '$fecha_nacimiento', '$email', '$telefono', '$activo', '$confirma_correo', '$codigoConfirmacion', '$codigo_recordar_contrasena', NOW())";
        $this -> db -> query($orden);

    }

    public function setUsu_sin_registrar($max_cod, $nickname){

        $orden = "INSERT INTO usuario_no_registrado (cod_usuario, nickname ) VALUES ($max_cod, '$nickname')";
        $this -> db -> query($orden);

    }


    // devuelve false si no coincide con Usuario o Negocio
    //devuelve 1 si coincide con usuario 
    //devuelve 2 si coincide con negocio 
    function comprobarEmail($email){
        $orden = "SELECT email FROM negocio WHERE email='" . $email . "'";
        $consulta = $this -> db -> query($orden);
        $numeroFilas = $consulta -> getNumRows();

        if($numeroFilas > 0 ){
            // email coincide con negocio 
            return 2;
        }else{
            $orden = "SELECT email FROM usuario_registrado WHERE email='" . $email . "'";
            $consulta = $this -> db -> query($orden);
            $numeroFilas = $consulta -> getNumRows();

            if($numeroFilas > 0 ){
                // email coincide con usuario
                return 1;
            }else{
                // email no coincide ni con usuario ni con negocio
                return 0;
            }
        }
    }

    public function getHashContrasena($email, $tipo){
        if($tipo == 1) $tipo = "usuario_registrado";
        if($tipo == 2) $tipo = "negocio";

        $orden = "SELECT contrasena FROM " . $tipo . " WHERE email='" . $email . "' ";
        $hash = $this->db->query($orden);
        $has_contrasena = $hash->getRow(); 
        
        $contrasena = $has_contrasena->contrasena;

        return $contrasena;
    }

    public function getUsuario($emailUsuario){
        $orden = "SELECT * FROM negocio WHERE email=?";
        $parametros = [$emailUsuario];
        $consulta = $this -> db -> query($orden, $parametros);
        $numeroFilas = $consulta -> getNumRows();

        if($numeroFilas > 0 ){
            // email coincide con negocio 

            return $consulta -> getResultArray() ;
        }else{
            $orden = "SELECT * FROM usuario_registrado WHERE email=?";
            $consulta = $this -> db -> query($orden, $parametros);

            // email coincide con usuario
            return $consulta -> getResultArray();
        }
    }

    public function getNegocio($cod_negocio){
        $activo = 1;
        $orden = "SELECT cod_negocio, nombre, email, calle, ciudad, pais, telefono_negocio, fotos, telefono_titular, foto_principal, coordenadas, sitio_web, cod_categoria  FROM negocio WHERE cod_negocio=? AND activo=?";
        $parametros = [$cod_negocio,$activo];
        $consulta = $this -> db -> query($orden, $parametros);

        // email coincide con usuario
        return $consulta -> getResultArray();
        
    }

    public function setCodigoQr($clave_publica,$clave_privada, $vector_inicializacion){
        $orden = "INSERT INTO codigo_qr (clave_publica, clave_privada, vector_inicializacion) VALUES ('$clave_publica','$clave_privada', '$vector_inicializacion')";
        $this -> db -> query($orden);
    }

    public function getClavePrivada($claveCifradaHex){
        $orden = "SELECT clave_privada FROM codigo_qr WHERE clave_publica=?";
        $parametros = [$claveCifradaHex];
        $consulta = $this -> db -> query($orden, $parametros);
        $numeroFilas = $consulta -> getNumRows();

        if($numeroFilas > 0 ){
            // email coincide con negocio 
            $clave = $consulta -> getRow();
            
            return $clave->clave_privada;
        }else{
            return false;
        }
    }

    public function getVectorInicializacion($claveCifradaHex){
        $orden = "SELECT vector_inicializacion FROM codigo_qr WHERE clave_publica=?";
        $parametros = [$claveCifradaHex];
        $consulta = $this -> db -> query($orden, $parametros);
        $numeroFilas = $consulta -> getNumRows();

        if($numeroFilas > 0 ){
            // email coincide con negocio 
            $clave = $consulta -> getRow();
            
            return $clave->vector_inicializacion;
        }else{
            return false;
        }
    }

    public function getMaxResena(){

        $orden = "SELECT MAX(cod_resena) as max_cod FROM resena";
        $consulta = $this -> db -> query($orden);
        $numeroFilas = $consulta -> getNumRows();

        if($numeroFilas > 0 ){
            $clave = $consulta -> getRow();
            return $clave -> max_cod;
        }else{
            return 1;
        }


    }

    public function getMaxNegocio(){

        $orden = "SELECT MAX(cod_negocio) as max_cod FROM negocio";
        $consulta = $this -> db -> query($orden);
        $numeroFilas = $consulta -> getNumRows();

        if($numeroFilas > 0 ){
            $clave = $consulta -> getRow();
            return $clave -> max_cod;
        }else{
            return 1;
        }


    }

    public function getMaxUsuario(){
        $max_no_registrado = 0;
        $max_registrado = 0;
        
        $orden = "SELECT MAX(cod_usuario) as max_cod FROM usuario_no_registrado";
        $consulta = $this -> db -> query($orden);
        $numeroFilas = $consulta -> getNumRows();

        if($numeroFilas > 0 ){
            $clave = $consulta -> getRow();
            $max_no_registrado = $clave -> max_cod;
        }else{
            $max_no_registrado = 1;
        }

        $sql = "SELECT MAX(cod_usuario) as max_cod_usu FROM usuario_registrado";
        $stmt = $this -> db -> query($sql);
        $numFilas = $stmt -> getNumRows();

        if($numFilas > 0 ){
            $key = $stmt -> getRow();
            $max_registrado = $key -> max_cod_usu;
        }else{
            $max_registrado = 1;
        }

        $max_no_registrado = intval($max_no_registrado);
        $max_registrado = intval($max_registrado);

        if($max_no_registrado > $max_registrado){
            return $max_no_registrado + 1 ;
        }else{
            return $max_registrado + 1;
        }
        
    }

    public function desactivarQr($id ){

        $orden = "UPDATE codigo_qr SET estado=0 WHERE id=?";
        $parametros = [$id];
        $this -> db -> query($orden,$parametros);

    }

    public function getQr_id($qr_key){
        $orden = "SELECT id FROM codigo_qr WHERE clave_publica=?";
        $parametros = [$qr_key];
        $consulta = $this -> db -> query($orden, $parametros);
        $numeroFilas = $consulta -> getNumRows();

        if($numeroFilas > 0 ){
            // email coincide con negocio 
            $clave = $consulta -> getRow();
            return $clave->id;
        }else{
            return false;
        }
    }

    public function comprobarEstado($claveCifradaHex){
        $orden = "SELECT estado FROM codigo_qr WHERE clave_publica=?";
        $parametros = [$claveCifradaHex];
        $consulta = $this -> db -> query($orden, $parametros);
        $clave = $consulta -> getRow();
        
        if($clave->estado == 1 || $clave->estado == "1"){
            return true;
        }else{
            return false;
        }
        
    }

    public function comprobarDuplicidad($txt_descripccion){
        $orden = "SELECT cod_resena FROM resena WHERE opinion=?";
        $parametros = [$txt_descripccion];
        $consulta = $this -> db -> query($orden, $parametros);
        $numeroFilas = $consulta -> getNumRows();

        if($numeroFilas > 0 ){
            return true;
        }else{
            return false;
        }
    }

    public function setResena($cod_reseña, $cod_negocio,$cod_usuario,$fecha_creacion,$fecha_servicio,$calificacion,$titulo,$opinion,$fotos,$id,$estado,$nickname){
        $orden = "INSERT INTO resena (cod_negocio, cod_usuario, fecha_creacion,	fecha_servicio,	calificacion,titulo,opinion,fotos,qr_id,estado,	nickname) 
                  VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        $parametros = [$cod_negocio,$cod_usuario,$fecha_creacion,$fecha_servicio,$calificacion,$titulo,$opinion,$fotos,$id,$estado,$nickname];
        $this -> db -> query($orden, $parametros);
    }

    public function setResena_no_registrado($cod_reseña, $cod_negocio,$cod_usuario,$fecha_creacion,$fecha_servicio,$calificacion,$titulo,$opinion,$fotos,$id,$estado,$nickname){
        $orden = "INSERT INTO resena (cod_negocio, cod_usuario, fecha_creacion,	fecha_servicio,	calificacion,titulo,opinion,fotos,qr_id,estado,	nickname) 
                  VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        $parametros = [$cod_negocio,$cod_usuario,$fecha_creacion,$fecha_servicio,$calificacion,$titulo,$opinion,$fotos,$id,$estado,$nickname];
        $this -> db -> query($orden, $parametros);
    }

    public function getlistaResenas(){
        $orden = "SELECT cod_resena, cod_negocio, cod_usuario, fecha_creacion, fecha_servicio, calificacion, titulo, opinion, fotos, qr_id, estado, nickname 
                FROM resena";

        $listaResenas = $this->db->query($orden);

        return $listaResenas->getResultArray();
    }

    public function get_foto_perfil_usuario($cod_usuario){

        $orden = "SELECT foto_perfil FROM usuario_registrado WHERE cod_usuario=?";
        $parametros = [$cod_usuario];
        $consulta = $this -> db -> query($orden, $parametros);
        $numeroFilas = $consulta -> getNumRows();
        
        if($numeroFilas > 0 ){
            $clave = $consulta -> getRow();
            return $clave->foto_perfil;
        }else{

            $orden = "SELECT foto_perfil FROM usuario_no_registrado WHERE cod_usuario=?";
            $parametros = [$cod_usuario];
            $consulta = $this -> db -> query($orden, $parametros);

            $clave = $consulta -> getRow();
            return $clave->foto_perfil;
        }
              
    }

    public function get_nombre_negocio($cod_negocio){
        $orden = "SELECT nombre FROM negocio WHERE cod_negocio=?";
        $parametros = [$cod_negocio];
        $consulta = $this -> db -> query($orden, $parametros);
        
        $clave = $consulta -> getRow();
        return $clave->nombre;
    }

    public function setEstadisticas($cod_resena, $cod_negocio, $cod_categoria, $valoracion_final){
        $orden = "INSERT INTO estadisticas_resena (cod_resena, cod_negocio, categoria_negocio, calificacion, fecha) VALUES ($cod_resena, $cod_negocio, $cod_categoria, $valoracion_final, NOW())";
        $this -> db -> query($orden);
    }

    public function getNotaMediaNegocio($cod_negocio){

        $orden = "SELECT SUM(calificacion) / COUNT(calificacion) as nota_media FROM estadisticas_resena WHERE cod_negocio=?";
        $parametros = [$cod_negocio];
        $consulta = $this -> db -> query($orden, $parametros);
        
        $clave = $consulta -> getRow();
        return $clave->nota_media;
    }

    public function getRanking($cod_categoria){

        $orden = "SELECT e.cod_negocio, SUM(e.calificacion) / COUNT(e.calificacion) as nota_media , n.foto_principal, n.nombre
        FROM estadisticas_resena e
        INNER JOIN negocio n ON e.cod_negocio= n.cod_negocio
        WHERE categoria_negocio=?
        GROUP BY cod_negocio 
        ORDER BY nota_media DESC
        LIMIT 3";
        $parametros = [$cod_categoria];
        $consulta = $this -> db -> query($orden, $parametros);

        return $consulta->getResultArray();
    }


}



//ejemplo con condicion
// $orden = "SELECT cod_categoria, tipo_negocio FROM categoria WHERE cod_categoria = :categoria:";
// $listaCategorias = $this -> db -> query($orden, [
//     'categoria' => 1
// ]);
