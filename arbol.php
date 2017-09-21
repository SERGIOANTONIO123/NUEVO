 <?php
    class arbol{
        private $_conexion;
        private $_idarbol;
        private $_gpsarbol;
        private $_alturaarbol;
        private $_fechasiembraarbol;
        private $_idvariedad;
        private $_idparcela;
        private $_paginacion=10;
        
        function __construct($conexion,$idarbol,$gpsarbol,$alturaarbol,$fechasiembraarbol, $idvariedad,$idparcela){
            $this->_conexion = $conexion;
            $this->_idarbol = $idarbol; 
            $this->_gpsarbol = $gpsarbol;
            $this->_alturaarbol = $alturaarbol;
            $this->_fechasiembraarbol = $fechasiembraarbol;
            $this->_idvariedad = $idvariedad;
            $this->_idparcela =$idparcela;
            $_SESSION['idusuario']=1;
        }
        function __get($k){
            return $this->$k;
        }
        function __set($k,$v){
            return $this->$k = $v;
        }
        function insertar(){
            
            $insercion = mysqli_query($this->_conexion,"INSERT INTO arbol (idarbol,gpsarbol,alturaarbol,fechasiembraarbol,idvariedad,idparcela) VALUES (NULL,ST_GeomFromText('$this->_gpsarbol'),'$this->_alturaarbol','$this->_fechasiembraarbol','$this->_idvariedad','$this->_idparcela')") or die (mysqli_error($this->_conexion));
            session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'inserto ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $insercion;
            
        }
        function modificar (){    
            $modificacion = mysqli_query($this->_conexion,"UPDATE arbol SET gpsarbol=ST_GeomFromText('$this->_gpsarbol'),alturaarbol='$this->_alturaarbol',fechasiembraarbol='$this->_fechasiembraarbol',idvariedad='$this->_idvariedad',idparcela='$this->_idparcela' 
            WHERE idarbol = $this->_idarbol") or die (mysqli_error($this->_conexion));
             session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'modifico ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $modificacion;
        }
        function eliminar(){
            $eliminacion = mysqli_query($this->_conexion, "DELETE FROM arbol  WHERE idarbol=$this->_idarbol") or die (mysqli_error($this->_conexion));
            session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'elimino ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $eliminacion;
        }
        function cantidadpaginas(){
            $cantidadbloques=mysqli_query($this->_conexion,"SELECT CEIL(COUNT(idarbol)/$this->_paginacion) AS cantidad FROM arbol") or die(mysqli_error($this->_conexion));
            $unregistro=mysqli_fetch_array($cantidadbloques);
            return $unregistro['cantidad'];
        }
        function listar ($pagina){
            if ($pagina<=0){
                $listado = mysqli_query($this->_conexion,"SELECT  idarbol, ST_AsText(gpsarbol) AS gpsarbol ,alturaarbol,fechasiembraarbol, idvariedad , idparcela FROM arbol ORDER BY idarbol");
            }else{
                $paginacionmax = $pagina * $this->_paginacion;
                $paginacionmin = $paginacionmax - $this->_paginacion;
                $listado = mysqli_query($this->_conexion,"SELECT idarbol, ST_AsText(gpsarbol) AS gpsarbol ,alturaarbol,fechasiembraarbol, idvariedad , idparcela FROM arbol LIMIT  $paginacionmin, $paginacionmax")   or die (mysqli_error($this->_conexion));
            }
            return $listado;    
        }
        
        function buscar ($busqueda){
            $busqueda = mysqli_query($this->_conexion,"SELECT idarbol, ST_AsText(gpsarbol) AS gpsarbol ,alturaarbol,fechasiembraarbol, idvariedad , idparcela FROM arbol WHERE idarbol LIKE '%$busqueda%' OR alturaarbol LIKE '%$busqueda%' OR fechasiembraarbol LIKE '%$busqueda%' or arbol.idvariedad IN (SELECT variedad.idvariedad FROM variedad WHERE descripcionvariedad LIKE '%$busqueda%') OR arbol.idparcela IN(SELECT parcela.idparcela FROM parcela WHERE nombreparcela LIKE '%$busqueda%')")  or die (mysqli_error($this->_conexion));
            return $busqueda    ;    
        }
         function getpermiso ($idusuario){
            $permiso=mysqli_query($this->_conexion,"SELECT ".static::class."rol AS elpermiso FROM rol WHERE idrol IN(SELECT usuario.idrol FROM usuario WHERE usuario.idusuario =  $idusuario)") or die (mysqli_error($this->_conexion));
            $unregistro=mysqli_fetch_array($permiso);
            return $unregistro["elpermiso"];
        }
        
    }
?>