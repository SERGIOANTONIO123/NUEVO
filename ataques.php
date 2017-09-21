<?php
    class ataques{
        private $_conexion;
        private $_idataque;
        private $_fechaataque;
        private $_porcentajeataque;
        private $_idarbol;
        private $_idenfermedad;
        private $_paginacion=10;
        
        function __construct($conexion,$idataque, $fechaataque,$porcentajeataque,$idarbol, $idenfermedad){
            $this->_conexion = $conexion;
            $this->_idataque = $idataque;
            $this->_fechaataque = $fechaataque;
            $this->_porcentajeataque = $porcentajeataque;
            $this->_idarbol = $idarbol;
            $this->_idenfermedad = $idenfermedad;
            $_SESSION['idusuario']=1;
        }
        function __get($k){
            return $this->$k; 
        }
        function __set($k,$v){
            return $this->$k = $v;
        }
        function insertar(){
            $insercion = mysqli_query($this->_conexion,"INSERT INTO ataques (idataque,fechaataque,porcentajeataque,idarbol,idenfermedad) VALUES (NULL,'$this->_fechaataque', '$this->_porcentajeataque','$this->_idarbol','$this->_idenfermedad')") or die (mysqli_error($this->_conexion));
            session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'inserto ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $insercion;
            
        }
        function modificar (){
            $modificacion = mysqli_query($this->_conexion,"UPDATE ataques SET fechaataque='$this->_fechaataque',porcentajeataque='$this->_porcentajeataque', idarbol='$this->_idarbol',idenfermedad='$this->_idenfermedad' 
            WHERE idataque = $this->_idataque") or die (mysqli_error($this->_conexion));
            session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'modifico ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $modificacion;
        }
        function eliminar(){
            $eliminacion = mysqli_query($this->_conexion, "DELETE FROM ataques  WHERE idataque=$this->_idataque") or die (mysqli_error($this->_conexion));
           session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'elimino ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $eliminacion;
        }
        function cantidadpaginas(){
            $cantidadbloques=mysqli_query($this->_conexion,"SELECT CEIL(COUNT(idataque)/$this->_paginacion) AS cantidad FROM ataques") or die(mysqli_error($this->_conexion));
            $unregistro=mysqli_fetch_array($cantidadbloques);
            return $unregistro['cantidad'];
        }
        function listar ($pagina){
            if ($pagina<=0){
                $listado = mysqli_query($this->_conexion,"SELECT * FROM ataques ORDER BY idataque");
            }else{
                $paginacionmax = $pagina * $this->_paginacion;
                $paginacionmin = $paginacionmax - $this->_paginacion;
                $listado = mysqli_query($this->_conexion,"SELECT * FROM ataques LIMIT  $paginacionmin, $paginacionmax")   or die (mysqli_error($this->_conexion));
            }
            return $listado;    
        }
         function buscar ($busqueda){
            $busqueda = mysqli_query($this->_conexion,"SELECT idataque,fechaataque,porcentajeataque,idarbol,idenfermedad FROM ataques WHERE idataque LIKE '%$busqueda%' OR fechaataque LIKE '%$busqueda%' OR porcentajeataque LIKE '%$busqueda%' or ataques.idarbol IN (SELECT arbol.idarbol FROM arbol WHERE idarbol LIKE '%$busqueda%') OR ataques.idenfermedad IN(SELECT enfermedad.idenfermedad FROM enfermedad WHERE descripcionenfermedad LIKE '%$busqueda%')")  or die (mysqli_error($this->_conexion));
            return $busqueda    ;    
        }
        function getpermiso ($idusuario){
            $permiso=mysqli_query($this->_conexion,"SELECT ataquerol AS elpermiso FROM rol WHERE idrol IN(SELECT usuario.idrol FROM usuario WHERE usuario.idusuario =  $idusuario)") or die (mysqli_error($this->_conexion));
            $unregistro=mysqli_fetch_array($permiso);
            return $unregistro["elpermiso"];
        }
    }
?>