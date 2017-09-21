<?php
    class usuario{
        private $_conexion;
        private $_idusuario;
        private $_nombreusuario;
        private $_emailusuario;
        private $_claveusuario;
        private $_fecharegistrousuario;
        private $_fechaultimaclave;
        private $_idrol;
        private $_paginacion=10;
        
        function __construct($conexion,$idusuario,$nombreusuario,$emailusuario,$claveusuario,$fecharegistrousuario,$fechaultimaclave,$idrol){
            $this->_conexion = $conexion;
            $this->_idusuario = $idusuario;
            $this->_nombreusuario = $nombreusuario;
            $this->_emailusuario = $emailusuario;
            $this->_claveusuario = $claveusuario;
            $this->_fecharegistrousuario = $fecharegistrousuario;
            $this->_fechaultimaclave = $fechaultimaclave;
            $this->_idrol = $idrol;
            $_SESSION['idusuario']=1;
        }
        function __get($k){
            return $this->$k;
        }
        function __set($k,$v){
            return $this->$k = $v;
        }
        function insertar(){
            $insercion = mysqli_query($this->_conexion,"INSERT INTO usuario (idusuario,nombreusuario,emailusuario,claveusuario,fecharegistrousuario,fechaultimaclave,idrol) VALUES (NULL,'$this->_nombreusuario', '$this->_emailusuario','".hash('sha256', $this->_claveusuario)."','$this->_fecharegistrousuario','$this->_fechaultimaclave','$this->_idrol')") or die (mysqli_error($this->_conexion));
            session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'inserto ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $insercion;
            
        }
        function modificar (){
            $sentencia = mysqli_query($this->_conexion,"SELECT claveusuario LIKE '$this->_claveusuario' AS Igual FROM usuario") or die (mysqli_error($this->_conexion)); //compara la clavevieja con la nueva sin aplicar hash porque se supone que ya lo tiene de la ultima vez
            $claveIgual = mysqli_fetch_array($sentencia);  //tomo el resultado
            echo "cla=".$claveIgual["Igual"]=="1"; 
            if ($claveIgual["Igual"]=="1"){
                $modificacion = mysqli_query($this->_conexion,"UPDATE usuario SET nombreusuario='$this->_nombreusuario',emailusuario='$this->_emailusuario',claveusuario='$this->_claveusuario',fecharegistrousuario='$this->_fecharegistrousuario',fechaultimaclave='$this->_fechaultimaclave',idrol='$this->_idrol' WHERE idusuario = $this->_idusuario") or die (mysqli_error($this->_conexion));
            }else{
               $modificacion = mysqli_query($this->_conexion,"UPDATE usuario SET nombreusuario='$this->_nombreusuario',emailusuario='$this->_emailusuario',claveusuario='".hash('sha256', $this->_claveusuario)."',fecharegistrousuario='$this->_fecharegistrousuario',fechaultimaclave='$this->_fechaultimaclave',idrol='$this->_idrol' WHERE idusuario = $this->_idusuario") or die (mysqli_error($this->_conexion));    
            }
             session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'modifico ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $modificacion;
        }
        function eliminar(){
            $eliminacion = mysqli_query($this->_conexion, "DELETE FROM usuario  WHERE idusuario=$this->_idusuario") or die (mysqli_error($this->_conexion));
           session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'elimino ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $eliminacion;
        }
        function cantidadpaginas(){
            $cantidadbloques=mysqli_query($this->_conexion,"SELECT CEIL(COUNT(idusuario)/$this->_paginacion) AS cantidad FROM usuario") or die(mysqli_error($this->_conexion));
            $unregistro=mysqli_fetch_array($cantidadbloques);
            return $unregistro['cantidad'];
        }
        function listar ($pagina){
            if ($pagina<=0){
                $listado = mysqli_query($this->_conexion,"SELECT * FROM usuario ORDER BY idusuario");
            }else{
                $paginacionmax = $pagina * $this->_paginacion;
                $paginacionmin = $paginacionmax - $this->_paginacion;
                $listado = mysqli_query($this->_conexion,"SELECT * FROM usuario LIMIT  $paginacionmin, $paginacionmax")   or die (mysqli_error($this->_conexion));
            }
            return $listado;    
        }
        function getpermiso ($idusuario){
            $permiso=mysqli_query($this->_conexion,"SELECT ".static::class."rol AS elpermiso FROM rol WHERE idrol IN(SELECT usuario.idrol FROM usuario WHERE usuario.idusuario =  $idusuario)") or die (mysqli_error($this->_conexion));
            $unregistro=mysqli_fetch_array($permiso);
            return $unregistro["elpermiso"];
        }
    }
?>