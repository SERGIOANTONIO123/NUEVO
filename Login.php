<?php
class Login{
    private $_conexion;
    private $_idUsuario;
    private $_emailUsuario;
    private $_hashedClaveUsuario;
    private $_nombreUsuario;
    private $_rolUsuario;
    
        function __construct($conexion, $correo, $clave){
            $this->_conexion            = $conexion;
            $this->_emailUsuario        = $correo;
            $this->_hashedClaveUsuario  = hash('sha256', $clave);
        }
    function verificarUsuario(){
        $verificacion = mysqli_query($this->_conexion, "SELECT idusuario, nombreusuario, idrol FROM usuario WHERE emailusuario LIKE '$this->_emailUsuario' AND CONVERT (claveusuario,CHAR(100)) LIKE '$this->_hashedClaveUsuario'") or die(mysqli_error($this->_conexion));
        
        
        if(mysqli_num_rows($verificacion)){
            $unUsuario = mysqli_fetch_array($verificacion);
            $this->_idUsuario           = $unUsuario["idusuario"];
            $this->_nombreUsuario       = $unUsuario["nombreusuario"];
            $this->_rolUsuario          = $unUsuario["idrol"];
            return true;
        }
        return false;
    }
    function getIdUsuario(){
        return $this->_idUsuario;
    }
    function getNombreUsuario(){
        return $this->_nombreUsuario;
    }
    function getRolUsuario(){
        return $this->_rolUsuario;
    }
}
?>