<?php
    class tratamiento{
        private $_conexion;
        private $_idtratamiento;
        private $_fechaaplicacion;
        private $_cantidadtratamiento;
        private $_idataque;
        private $_idtipotratamiento;
        private $_paginacion=10;
        
        function __construct($conexion,$idtratamiento, $fechaaplicacion,$cantidadtratamiento,$idataque, $idtipotratamiento){
            $this->_conexion = $conexion;
            $this->_idtratamiento = $idtratamiento;
            $this->_fechaaplicacion = $fechaaplicacion;
            $this->_cantidadtratamiento = $cantidadtratamiento;
            $this->_idataque = $idataque;
            $this->_idtipotratamiento = $idtipotratamiento;
            $_SESSION['idusuario']=1;
        }
        function __get($k){
            return $this->$k;
        }
        function __set($k,$v){
            return $this->$k = $v;
        }
        function insertar(){
            $insercion = mysqli_query($this->_conexion,"INSERT INTO tratamiento (idtratamiento,fechaaplicacion,cantidadtratamiento,idataque,idtipotratamiento) VALUES (NULL,'$this->_fechaaplicacion', '$this->_cantidadtratamiento','$this->_idataque','$this->_idtipotratamiento')") or die (mysqli_error($this->_conexion));
            session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'inserto ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $insercion;
            
        }
        function modificar (){
            $modificacion = mysqli_query($this->_conexion,"UPDATE tratamiento SET fechaaplicacion='$this->_fechaaplicacion',cantidadtratamiento='$this->_cantidadtratamiento', idataque='$this->_idataque',idtipotratamiento='$this->_idtipotratamiento' 
            WHERE idtratamiento = $this->_idtratamiento") or die (mysqli_error($this->_conexion));
             session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'modifico ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $modificacion;
        }
        function eliminar(){
            $eliminacion = mysqli_query($this->_conexion, "DELETE FROM tratamiento  WHERE idtratamiento=$this->_idtratamiento") or die (mysqli_error($this->_conexion));
             session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'elimino ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $eliminacion;
        }
        function cantidadpaginas(){
            $cantidadbloques=mysqli_query($this->_conexion,"SELECT CEIL(COUNT(idtratamiento)/$this->_paginacion) AS cantidad FROM tratamiento") or die(mysqli_error($this->_conexion));
            $unregistro=mysqli_fetch_array($cantidadbloques);
            return $unregistro['cantidad'];
        }
        function listar ($pagina){
            if ($pagina<=0){
                $listado = mysqli_query($this->_conexion,"SELECT * FROM tratamiento ORDER BY idtratamiento");
            }else{
                $paginacionmax = $pagina * $this->_paginacion;
                $paginacionmin = $paginacionmax - $this->_paginacion;
                $listado = mysqli_query($this->_conexion,"SELECT * FROM tratamiento LIMIT  $paginacionmin, $paginacionmax")   or die (mysqli_error($this->_conexion));
            }
            return $listado;    
        }
        function buscar ($busqueda){
            $busqueda = mysqli_query($this->_conexion,"SELECT * FROM tratamiento WHERE idtratamiento LIKE '%$busqueda%' OR fechaaplicacion LIKE '%$busqueda%' OR cantidadtratamiento LIKE '%$busqueda%' or tratamiento.idataque IN (SELECT ataques.idataque FROM ataques WHERE idataque LIKE '%$busqueda%') OR tratamiento.idtipotratamiento IN(SELECT tipotratamiento.idtipotratamiento FROM tipotratamiento WHERE descripciontipotratamiento LIKE '%$busqueda%')")  or die (mysqli_error($this->_conexion));
            return $busqueda    ;    
        }
        function getpermiso ($idusuario){
            $permiso=mysqli_query($this->_conexion,"SELECT ".static::class."rol AS elpermiso FROM rol WHERE idrol IN(SELECT usuario.idrol FROM usuario WHERE usuario.idusuario =  $idusuario)") or die (mysqli_error($this->_conexion));
            $unregistro=mysqli_fetch_array($permiso);
            return $unregistro["elpermiso"];
        }
    }
?>