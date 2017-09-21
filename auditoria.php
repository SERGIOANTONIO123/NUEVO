<?php
    class auditoria{
        private $_conexion;
        private $_idauditoria;
        private $_fechaauditoria;
        private $_descripcionauditoria;
        private $_idusuario;
        private $_paginacion=10;
        
        function __construct($conexion,$idauditoria,$fechaauditoria,$descripcionauditoria,$idusuario){
            $this->_conexion = $conexion;
            $this->_idauditoria = $idauditoria;
            $this->_fechaauditoria = $fechaauditoria;
            $this->_descripcionauditoria = $descripcionauditoria;
            $this->_idusuario = $idusuario;
            $_SESSION['idusuario']=1;
        }
         
        function __get($k){
            return $this->$k;
        }
        
        function __set($k,$v){
            return $this->$k = $v;
        }
        
        function insertar(){
            $insercion = mysqli_query($this->_conexion,"INSERT INTO auditoria (idauditoria,fechaauditoria,descripcionauditoria,idusuario) VALUES (NULL,'$this->_fechaauditoria', '$this->_descripcionauditoria','$this->_idusuario')")  or die (mysqli_error($this->_conexion));
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, fechaauditoria, descripcionauditoria, idusuarioauditoria) VALUES (NULL, 'inserto ".static::class." ', ".$SESSION['idusuario'].",CURDATE())");
            return $insercion;
            
        }
        
        function modificar (){
            $modificacion = mysqli_query($this->_conexion,"UPDATE auditoria SET fechaauditoria='$this->_fechaauditoria',descripcionauditoria='$this->_descripcionauditoria',idusuario='$this->_idusuario' 
            WHERE idauditoria = $this->_idauditoria") or die (mysqli_error($this->_conexion));
             $auditoria = mysqli_query($this->_conexion,"    INSERT  INTO auditoria(idauditoria,fechaauditoria,descripcionauditoria,idusuarioauditoria) VALUES (NULL,'modifico ".static::class."',".$SESSION['idusuario'].",  CURDATE())");
            return $modificacion;
        }
        
        function eliminar(){
            $eliminacion = mysqli_query($this->_conexion, "DELETE FROM auditoria  WHERE idauditoria=$this->_idauditoria") or die (mysqli_error($this->_conexion));
            $auditoria = mysqli_query($this->_conexion,"    INSERT   INTO auditoria(idauditoria,fechaauditoria,descripcionauditoria,idusuarioauditoria) VALUES (NULL,'elimino ".static::class."',".$SESSION['idusuario'].",  CURDATE())");
            return $eliminacion;
        }
        
        function cantidadpaginas(){
            $cantidadbloques=mysqli_query($this->_conexion,"SELECT CEIL(COUNT(idauditoria)/$this->_paginacion) AS cantidad FROM auditoria") or die(mysqli_error($this->_conexion));
            $unregistro=mysqli_fetch_array($cantidadbloques);
            return $unregistro['cantidad'];
        }
        
        function listar ($pagina){
            if ($pagina<=0){
                $listado = mysqli_query($this->_conexion,"SELECT * FROM auditoria INNER JOIN usuario ON auditoria.idusuario = usuario.idusuario ORDER BY idauditoria");
            }else{
                $paginacionmax = $pagina * $this->_paginacion;
                $paginacionmin = $paginacionmax - $this->_paginacion;
                $listado = mysqli_query($this->_conexion,"SELECT * FROM auditoria INNER JOIN usuario ON auditoria.idusuario = usuario.idusuario LIMIT  $paginacionmin, $paginacionmax")   or die (mysqli_error($this->_conexion));
            }
            return $listado;    
        }
        function buscar ($busqueda){
            $busqueda = mysqli_query($this->_conexion,"SELECT * FROM auditoria INNER JOIN usuario ON auditoria.idusuario = usuario.idusuario WHERE idauditoria LIKE '%$busqueda%' OR fechaauditoria LIKE '%$busqueda%' OR descripcionauditoria LIKE '%$busqueda%' or auditoria.idusuario IN (SELECT usuario.idusuario FROM usuario WHERE nombreusuario LIKE '%$busqueda%') ")  or die (mysqli_error($this->_conexion));
            return $busqueda    ;    
        }
        function getpermiso ($idusuario){
            $permiso=mysqli_query($this->_conexion,"SELECT ".static::class."rol AS elpermiso FROM rol WHERE idrol IN(SELECT usuario.idrol FROM usuario WHERE usuario.idusuario =  $idusuario)") or die (mysqli_error($this->_conexion));
            $unregistro=mysqli_fetch_array($permiso);
            return $unregistro["elpermiso"];
        }
    }
?>