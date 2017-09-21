 <?php
    class podas{
        private $_conexion;
        private $_idpoda;
        private $_fechapoda;
        private $_idtipopoda;
        private $_idarbol;
        private $_paginacion=10;
        
        function __construct($conexion,$idpoda,$fechapoda,$idtipopoda,$idarbol){
            $this->_conexion = $conexion;
            $this->_idpoda = $idpoda;
            $this->_fechapoda = $fechapoda;
            $this->_idtipopoda = $idtipopoda;
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
            $insercion = mysqli_query($this->_conexion,"INSERT INTO podas (idpoda,fechapoda,idtipopoda,idarbol) VALUES (NULL,'$this->_fechapoda', '$this->_idtipopoda','$this->_idarbol')")  or die (mysqli_error($this->_conexion));
             session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'inserto ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $insercion;
            
        }
        function modificar (){
            $modificacion = mysqli_query($this->_conexion,"UPDATE podas SET fechapoda='$this->_fechapoda',idtipopoda='$this->_idtipopoda',idarbol='$this->_idarbol' 
            WHERE idpoda = $this->_idpoda") or die (mysqli_error($this->_conexion));
             session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'modifico ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $modificacion;
        }
        function eliminar(){
            $eliminacion = mysqli_query($this->_conexion, "DELETE FROM podas  WHERE idpoda=$this->_idpoda") or die (mysqli_error($this->_conexion));
             session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'elimino ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $eliminacion;
        }
        function cantidadpaginas(){
            $cantidadbloques=mysqli_query($this->_conexion,"SELECT CEIL(COUNT(idpoda)/$this->_paginacion) AS cantidad FROM podas") or die(mysqli_error($this->_conexion));
            $unregistro=mysqli_fetch_array($cantidadbloques);
            return $unregistro['cantidad'];
        }
        function listar ($pagina){
            if ($pagina<=0){
                $listado = mysqli_query($this->_conexion,"SELECT * FROM podas ORDER BY idpoda");
            }else{
                $paginacionmax = $pagina * $this->_paginacion;
                $paginacionmin = $paginacionmax - $this->_paginacion;
                $listado = mysqli_query($this->_conexion,"SELECT * FROM podas LIMIT  $paginacionmin, $paginacionmax") or die (mysqli_error($this->_conexion));
            }
            return $listado;    
        }
        function buscar ($busqueda){
            $busqueda = mysqli_query($this->_conexion,"SELECT * FROM podas WHERE idpoda LIKE '%$busqueda%' OR fechapoda LIKE '%$busqueda%' or podas.idtipopoda IN (SELECT tipopoda.idtipopoda FROM tipopoda WHERE descripciontipopoda LIKE '%$busqueda%') OR podas.idarbol IN(SELECT arbol.idarbol FROM arbol WHERE idarbol LIKE '%$busqueda%')")  or die (mysqli_error($this->_conexion));
            return $busqueda    ;    
        }
        function getpermiso ($idusuario){
            $permiso=mysqli_query($this->_conexion,"SELECT ".static::class."rol AS elpermiso FROM rol WHERE idrol IN(SELECT usuario.idrol FROM usuario WHERE usuario.idusuario =  $idusuario)") or die (mysqli_error($this->_conexion));
            $unregistro=mysqli_fetch_array($permiso);
            return $unregistro["elpermiso"];
        }
    }
?>