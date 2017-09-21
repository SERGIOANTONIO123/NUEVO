<?php
    class ventas{
        private $_conexion;
        private $_idventas;
        private $_kilosvendidos;
        private $_fechaventa;
        private $_idciente;
        private $_paginacion=10;
        
        function __construct($conexion,$idventas,$kilosvendidos,$fechaventa, $idcliente){
            $this->_conexion = $conexion;
            $this->_idventas = $idventas;
            $this->_kilosvendidos = $kilosvendidos;
            $this->_fechaventa = $fechaventa;
            $this->_idcliente = $idcliente;
            $_SESSION['idusuario']=1;
        }
        function __get($k){
            return $this->$k;
        }
        function __set($k,$v){
            return $this->$k = $v;
        }
        function insertar(){
            $insercion = mysqli_query($this->_conexion,"INSERT INTO ventas (idventas,kilosvendidos,fechaventa,idcliente) VALUES (NULL,'$this->_kilosvendidos', 
            '$this->_fechaventa','$this->_idcliente')") or die (mysqli_error($this->_conexion));
            session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'inserto ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $insercion;
            
        } 
        function modificar (){
            $modificacion = mysqli_query($this->_conexion,"UPDATE ventas SET kilosvendidos='$this->_kilosvendidos',fechaventa='$this->_fechaventa',idcliente='$this->_idcliente' 
            WHERE idventas = $this->_idventas") or die (mysqli_error($this->_conexion));
             session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'modifico ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $modificacion;
        }
        function eliminar(){
            $eliminacion = mysqli_query($this->_conexion, "DELETE FROM ventas  WHERE idventas=$this->_idventas") or die (mysqli_error($this->_conexion));
            session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'elimino ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $eliminacion;
        }
        function cantidadpaginas(){
            $cantidadbloques=mysqli_query($this->_conexion,"SELECT CEIL(COUNT(idventas)/$this->_paginacion) AS cantidad FROM ventas") or die(mysqli_error($this->_conexion));
            $unregistro=mysqli_fetch_array($cantidadbloques);
            return $unregistro['cantidad'];
        }
        function listar ($pagina){
            if ($pagina<=0){
                $listado = mysqli_query($this->_conexion,"SELECT * FROM ventas ORDER BY idventas");
            }else{
                $paginacionmax = $pagina * $this->_paginacion;
                $paginacionmin = $paginacionmax - $this->_paginacion;
                $listado = mysqli_query($this->_conexion,"SELECT * FROM ventas LIMIT  $paginacionmin, $paginacionmax")   or die (mysqli_error($this->_conexion));
            }
            return $listado;    
        }
        function buscar ($busqueda){
            $busqueda = mysqli_query($this->_conexion,"SELECT * FROM ventas WHERE idventas LIKE '%$busqueda%' OR kilosvendidos LIKE '%$busqueda%' OR fechaventa LIKE '%$busqueda%' or ventas.idcliente IN (SELECT cliente.idcliente FROM cliente WHERE nombrecliente LIKE '%$busqueda%')")  or die (mysqli_error($this->_conexion));
            return $busqueda    ;    
        }
        function getpermiso ($idusuario){
            $permiso=mysqli_query($this->_conexion,"SELECT ".static::class."rol AS elpermiso FROM rol WHERE idrol IN(SELECT usuario.idrol FROM usuario WHERE usuario.idusuario =  $idusuario)") or die (mysqli_error($this->_conexion));
            $unregistro=mysqli_fetch_array($permiso);
            return $unregistro["elpermiso"];
        }
    }
?>