<?php
    class floracion{
        private $_conexion;
        private $_idfloracion;
        private $_cantidadflores;
        private $_fechainiciofloracion;
        private $_fechafinfloracion;
        private $_idarbol;
        private $_paginacion=10;
        
        function __construct($conexion,$idfloracion,$cantidadflores, $fechainiciofloracion,$fechafinfloracion,$idarbol ){
            $this->_conexion = $conexion;
            $this->_idfloracion = $idfloracion;
            $this->_cantidadflores = $cantidadflores;
            $this->_fechainiciofloracion = $fechainiciofloracion;
            $this->_fechafinfloracion = $fechafinfloracion;
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
            $insercion = mysqli_query($this->_conexion,"INSERT INTO floracion (idfloracion,cantidadflores,fechainiciofloracion,fechafinfloracion,idarbol) VALUES (NULL,'$this->_cantidadflores', '$this->_fechainiciofloracion','$this->_fechafinfloracion','$this->_idarbol')") or die (mysqli_error($this->_conexion));
            session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'inserto ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $insercion;
            
        }
        function modificar (){
            $modificacion = mysqli_query($this->_conexion,"UPDATE floracion SET cantidadflores='$this->_cantidadflores',fechainiciofloracion='$this->_fechainiciofloracion',fechafinfloracion='$this->_fechafinfloracion', idarbol='$this->_idarbol' 
            WHERE idfloracion = $this->_idfloracion") or die (mysqli_error($this->_conexion));
              session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'modifico ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $modificacion;
        }
        function eliminar(){
            $eliminacion = mysqli_query($this->_conexion, "DELETE FROM floracion  WHERE idfloracion=$this->_idfloracion") or die (mysqli_error($this->_conexion));
             session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'elimino ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $eliminacion;
        }
        function cantidadpaginas(){
            $cantidadbloques=mysqli_query($this->_conexion,"SELECT CEIL(COUNT(idfloracion)/$this->_paginacion) AS cantidad FROM floracion") or die(mysqli_error($this->_conexion));
            $unregistro=mysqli_fetch_array($cantidadbloques);
            return $unregistro['cantidad'];
        }
        function listar ($pagina){
            if ($pagina<=0){
                $listado = mysqli_query($this->_conexion,"SELECT * FROM floracion ORDER BY idfloracion");
            }else{
                $paginacionmax = $pagina * $this->_paginacion;
                $paginacionmin = $paginacionmax - $this->_paginacion;
                $listado = mysqli_query($this->_conexion,"SELECT * FROM floracion LIMIT  $paginacionmin, $paginacionmax")   or die (mysqli_error($this->_conexion));
            }
            return $listado;    
        }
        function buscar ($busqueda){
            $busqueda = mysqli_query($this->_conexion,"SELECT * FROM floracion WHERE idfloracion LIKE '%$busqueda%' OR cantidadflores LIKE '%$busqueda%' OR fechainiciofloracion LIKE '%$busqueda%' or  fechafinfloracion LIKE '%$busqueda%' or  floracion.idarbol IN (SELECT arbol.idarbol FROM arbol WHERE idarbol LIKE '%$busqueda%')")  or die (mysqli_error($this->_conexion));
            return $busqueda    ;    
        }
        function getpermiso ($idusuario){
            $permiso=mysqli_query($this->_conexion,"SELECT ".static::class."rol AS elpermiso FROM rol WHERE idrol IN(SELECT usuario.idrol FROM usuario WHERE usuario.idusuario =  $idusuario)") or die (mysqli_error($this->_conexion));
            $unregistro=mysqli_fetch_array($permiso);
            return $unregistro["elpermiso"];
        }
        
    }
?>