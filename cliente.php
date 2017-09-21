<?php
    class cliente{
        private $_conexion;
        private $_idcliente;
        private $_nombrecliente;
        private $_telefonocliente;
        private $_emailcliente;
        private $_paginacion=10;
        
        function __construct($conexion,$idcliente,$nombrecliente,$telefonocliente,$emailcliente){
            $this->_conexion = $conexion;
            $this->_idcliente = $idcliente;
            $this->_nombrecliente = $nombrecliente;
            $this->_telefonocliente = $telefonocliente;
            $this->_emailcliente = $emailcliente;
            $_SESSION['idusuario']=1;
        }
        function __get($k){ 
            return $this->$k;
        }
        function __set($k,$v){
            return $this->$k = $v;
        }
        function insertar(){
            $insercion = mysqli_query($this->_conexion,"INSERT INTO cliente (idcliente,nombrecliente,telefonocliente,emailcliente) VALUES (NULL,'$this->_nombrecliente', '$this->_telefonocliente', '$this->_emailcliente')") or die (mysqli_error($this->_conexion));
             session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'inserto ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $insercion;
            
        }
        function modificar (){
            $modificacion = mysqli_query($this->_conexion,"UPDATE cliente SET nombrecliente='$this->_nombrecliente',telefonocliente='$this->_telefonocliente', emailcliente='$this->_emailcliente' 
            WHERE idcliente = $this->_idcliente") or die (mysqli_error($this->_conexion));
              session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'modifico ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $modificacion;
        }
        function eliminar(){
            $eliminacion = mysqli_query($this->_conexion, "DELETE FROM cliente  WHERE idcliente=$this->_idcliente") or die (mysqli_error($this->_conexion));
             session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'elimino ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $eliminacion;
        }
        function cantidadpaginas(){
            $cantidadbloques=mysqli_query($this->_conexion,"SELECT CEIL(COUNT(idcliente)/$this->_paginacion) AS cantidad FROM cliente") or die(mysqli_error($this->_conexion));
            $unregistro=mysqli_fetch_array($cantidadbloques);
            return $unregistro['cantidad'];
        }
        function listar ($pagina){
            if ($pagina<=0){
                $listado = mysqli_query($this->_conexion,"SELECT * FROM cliente ORDER BY idcliente");
            }else{
                $paginacionmax = $pagina * $this->_paginacion;
                $paginacionmin = $paginacionmax - $this->_paginacion;
                $listado = mysqli_query($this->_conexion,"SELECT * FROM cliente LIMIT  $paginacionmin, $paginacionmax")   or die (mysqli_error($this->_conexion));
            }
            return $listado;    
        }
        function buscar ($busqueda){
            $busqueda = mysqli_query($this->_conexion,"SELECT * FROM cliente WHERE idcliente LIKE '%$busqueda%' OR nombrecliente LIKE '%$busqueda%' OR telefonocliente LIKE '%$busqueda%' or emailcliente LIKE '%$busqueda%' ")  or die (mysqli_error($this->_conexion));
            return $busqueda;    
        }
        function getpermiso ($idusuario){
            $permiso=mysqli_query($this->_conexion,"SELECT ".static::class."rol AS elpermiso FROM rol WHERE idrol IN(SELECT usuario.idrol FROM usuario WHERE usuario.idusuario =  $idusuario)") or die (mysqli_error($this->_conexion));
            $unregistro=mysqli_fetch_array($permiso);
            return $unregistro["elpermiso"];
        }
        
        
    }
?>