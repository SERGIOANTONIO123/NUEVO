<?php
    class administrador{
        private $_conexion;
        private $_idadministrador;
        private $_nombreadministrador;
        private $_telefonoadministrador;
        private $_paginacion=10;
        
        function __construct($conexion,$idadministrador,$nombreadministrador,$telefonoadministrador){
            $this->_conexion = $conexion;
            $this->_idadministrador = $idadministrador;
            $this->_nombreadministrador = $nombreadministrador;
            $this->_telefonoadministrador = $telefonoadministrador;
            $_SESSION['idusuario']=1;
        }
        function __get($k){
            return $this->$k;
        }
        function __set($k,$v){
            return $this->$k = $v; 
        }
        function insertar(){
            $insercion = mysqli_query($this->_conexion,"INSERT INTO administrador (idadministrador,nombreadministrador,telefonoadministrador) VALUES (NULL,'$this->_nombreadministrador', '$this->_telefonoadministrador')") or die (mysqli_error($this->_conexion));
           session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'inserto ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $insercion;
            
        }
        function modificar (){
            $modificacion = mysqli_query($this->_conexion,"UPDATE administrador SET nombreadministrador='$this->_nombreadministrador',telefonoadministrador='$this->_telefonoadministrador' 
            WHERE idadministrador = $this->_idadministrador") or die (mysqli_error($this->_conexion));
            session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'modifico ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $modificacion;
        }
        function eliminar(){
            $eliminacion = mysqli_query($this->_conexion, "DELETE FROM administrador  WHERE idadministrador=$this->_idadministrador") or die (mysqli_error($this->_conexion));
            session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'elimino ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $eliminacion;
        }
        function cantidadpaginas(){
            $cantidadbloques=mysqli_query($this->_conexion,"SELECT CEIL(COUNT(idadministrador)/$this->_paginacion) AS cantidad FROM administrador") or die(mysqli_error($this->_conexion));
            $unregistro=mysqli_fetch_array($cantidadbloques);
            return $unregistro['cantidad'];
        }
        function listar ($pagina){
            if ($pagina<=0){
                $listado = mysqli_query($this->_conexion,"SELECT * FROM administrador ORDER BY idadministrador");
            }else{
                $paginacionmax = $pagina * $this->_paginacion;
                $paginacionmin = $paginacionmax - $this->_paginacion;
                $listado = mysqli_query($this->_conexion,"SELECT * FROM administrador LIMIT  $paginacionmin, $paginacionmax")   or die (mysqli_error($this->_conexion));
            }
            return $listado;    
        }
         function buscar ($busqueda){
            $busqueda = mysqli_query($this->_conexion,"SELECT * FROM administrador WHERE idadministrador LIKE '%$busqueda%' OR nombreadministrador LIKE '%$busqueda%' OR telefonoadministrador LIKE '%$busqueda%'")  or die (mysqli_error($this->_conexion));
            return $busqueda    ;    
        }
        function getpermiso ($idusuario){
            $permiso=mysqli_query($this->_conexion,"SELECT ".static::class."rol AS elpermiso FROM rol WHERE idrol IN(SELECT usuario.idrol FROM usuario WHERE usuario.idusuario =  $idusuario)") or die (mysqli_error($this->_conexion));
            $unregistro=mysqli_fetch_array($permiso);
            return $unregistro["elpermiso"];
        }
    }
?>