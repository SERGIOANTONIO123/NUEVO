 <?php
    class produccion{
        private $_conexion;
        private $_idproduccion;
        private $_fechainicioproduccion;
        private $_kilosproducidos;
        private $_kilosperdida;
        private $_idarbol;
        private $_paginacion=10;
        
        function __construct($conexion,$idproduccion, $fechainicioproduccion,$kilosproducidos,$kilosperdida, $idarbol){
            $this->_conexion = $conexion;
            $this->_idproduccion = $idproduccion;
            $this->_fechainicioproduccion = $fechainicioproduccion;
            $this->_kilosproducidos = $kilosproducidos;
            $this->_kilosperdida = $kilosperdida;
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
            $insercion = mysqli_query($this->_conexion,"INSERT INTO produccion (idproduccion,fechainicioproduccion,kilosproducidos,kilosperdida,idarbol) VALUES (NULL,'$this->_fechainicioproduccion', '$this->_kilosproducidos','$this->_kilosperdida','$this->_idarbol')") or die (mysqli_error($this->_conexion));
             session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'inserto ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $insercion;
            
        }
        function modificar (){
            $modificacion = mysqli_query($this->_conexion,"UPDATE produccion SET fechainicioproduccion='$this->_fechainicioproduccion',kilosproducidos='$this->_kilosproducidos', kilosperdida='$this->_kilosperdida',idarbol='$this->_idarbol' 
            WHERE idproduccion = $this->_idproduccion") or die (mysqli_error($this->_conexion));
             session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'modifico ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $modificacion;
        }
        function eliminar(){
            $eliminacion = mysqli_query($this->_conexion, "DELETE FROM produccion  WHERE idproduccion=$this->_idproduccion") or die (mysqli_error($this->_conexion));
             session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'elimino ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $eliminacion;
        }
        function cantidadpaginas(){
            $cantidadbloques=mysqli_query($this->_conexion,"SELECT CEIL(COUNT(idproduccion)/$this->_paginacion) AS cantidad FROM produccion") or die(mysqli_error($this->_conexion));
            $unregistro=mysqli_fetch_array($cantidadbloques);
            return $unregistro['cantidad'];
        }
        function listar ($pagina){
            if ($pagina<=0){
                $listado = mysqli_query($this->_conexion,"SELECT * FROM produccion ORDER BY idproduccion");
            }else{
                $paginacionmax = $pagina * $this->_paginacion;
                $paginacionmin = $paginacionmax - $this->_paginacion;
                $listado = mysqli_query($this->_conexion,"SELECT * FROM produccion LIMIT  $paginacionmin, $paginacionmax")   or die (mysqli_error($this->_conexion));
            }
            return $listado;    
        }
        function buscar ($busqueda){
            $busqueda = mysqli_query($this->_conexion,"SELECT * FROM produccion WHERE idproduccion LIKE '%$busqueda%' OR fechainicioproduccion LIKE '%$busqueda%' OR kilosproducidos LIKE '%$busqueda%' OR kilosperdida LIKE '%$busqueda%' OR produccion.idarbol IN(SELECT arbol.idarbol FROM arbol WHERE idarbol LIKE '%$busqueda%')")  or die (mysqli_error($this->_conexion));
            return $busqueda    ;    
        }
        function getpermiso ($idusuario){
            $permiso=mysqli_query($this->_conexion,"SELECT ".static::class."rol AS elpermiso FROM rol WHERE idrol IN(SELECT usuario.idrol FROM usuario WHERE usuario.idusuario =  $idusuario)") or die (mysqli_error($this->_conexion));
            $unregistro=mysqli_fetch_array($permiso);
            return $unregistro["elpermiso"];
        }
    }
?>