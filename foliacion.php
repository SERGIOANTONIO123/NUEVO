<?php
    class foliacion{
        private $_conexion;
        private $_idfoliacion;
        private $_cantidadhojas;
        private $_areahoja;
        private $_fechafoliacion;
        private $_idarbol;
        private $_paginacion=10;
        
        function __construct($conexion,$idfoliacion,$cantidadhojas, $areahoja,$fechafoliacion,$idarbol ){
            $this->_conexion = $conexion;
            $this->_idfoliacion = $idfoliacion;
            $this->_cantidadhojas = $cantidadhojas;
            $this->_areahoja = $areahoja;
            $this->_fechafoliacion = $fechafoliacion;
            $this->_idarbol = $idarbol;
            $_SESSION['idusuario']=1;
        }
        function __get($k){
            return $this->$k;
        }
        function __set($k,$v){
            return $this->$k = $v;
        }
        function insertar(){
            $insercion = mysqli_query($this->_conexion,"INSERT INTO foliacion (idfoliacion,cantidadhojas,areahoja,fechafoliacion,idarbol) VALUES (NULL,'$this->_cantidadhojas', '$this->_areahoja','$this->_fechafoliacion','$this->_idarbol')") or die (mysqli_error($this->_conexion));
            session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'inserto ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $insercion;
            
        }
        function modificar (){
            $modificacion = mysqli_query($this->_conexion,"UPDATE foliacion SET cantidadhojas='$this->_cantidadhojas',areahoja='$this->_areahoja',fechafoliacion='$this->_fechafoliacion',idarbol='$this->_idarbol' 
            WHERE idfoliacion = $this->_idfoliacion") or die (mysqli_error($this->_conexion));
             session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'modifico ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $modificacion;
        }
        function eliminar(){
            $eliminacion = mysqli_query($this->_conexion, "DELETE FROM foliacion  WHERE idfoliacion=$this->_idfoliacion") or die (mysqli_error($this->_conexion));
             session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'elimino ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $eliminacion;
        }
        function cantidadpaginas(){
            $cantidadbloques=mysqli_query($this->_conexion,"SELECT CEIL(COUNT(idfoliacion)/$this->_paginacion) AS cantidad FROM foliacion") or die(mysqli_error($this->_conexion));
            $unregistro=mysqli_fetch_array($cantidadbloques);
            return $unregistro['cantidad'];
        }
        function listar ($pagina){
            if ($pagina<=0){
                $listado = mysqli_query($this->_conexion,"SELECT * FROM foliacion ORDER BY idfoliacion");
            }else{
                $paginacionmax = $pagina * $this->_paginacion;
                $paginacionmin = $paginacionmax - $this->_paginacion;
                $listado = mysqli_query($this->_conexion,"SELECT * FROM foliacion LIMIT  $paginacionmin, $paginacionmax")   or die (mysqli_error($this->_conexion));
            }
            return $listado;    
        }
          function buscar ($busqueda){
            $busqueda = mysqli_query($this->_conexion,"SELECT * FROM foliacion WHERE idfoliacion LIKE '%$busqueda%' OR cantidadhojas LIKE '%$busqueda%' OR areahoja LIKE '%$busqueda%' OR fechafoliacion LIKE '%$busqueda%' OR foliacion.idarbol IN (SELECT arbol.idarbol FROM arbol WHERE idarbol LIKE '%$busqueda%')")  or die (mysqli_error($this->_conexion));
            return $busqueda    ;    
        }
        function getpermiso ($idusuario){
            $permiso=mysqli_query($this->_conexion,"SELECT ".static::class."rol AS elpermiso FROM rol WHERE idrol IN(SELECT usuario.idrol FROM usuario WHERE usuario.idusuario =  $idusuario)") or die (mysqli_error($this->_conexion));
            $unregistro=mysqli_fetch_array($permiso);
            return $unregistro["elpermiso"];
        }
        
    }
?>