 <?php
    class parcela{
        private $_conexion;
        private $_idparcela;
        private $_nombreparcela;
        private $_phparcela;
        private $_idadministrador;
        private $_idtiposuelo;
        private $_idvereda;
        private $_paginacion=10;
        
        function __construct($conexion,$idparcela,$nombreparcela,$phparcela, $idadministrador,$idtiposuelo,$idvereda){
            $this->_conexion = $conexion;
            $this->_idparcela = $idparcela;
            $this->_nombreparcela = $nombreparcela;
            $this->_phparcela = $phparcela;
            $this->_idadministrador = $idadministrador;
            $this->_idtiposuelo = $idtiposuelo;
            $this->_idvereda = $idvereda;
            $_SESSION['idusuario']=1;
        }
        function __get($k){
            return $this->$k;
        }
        function __set($k,$v){
            return $this->$k = $v;
        }
        function insertar(){
            $insercion = mysqli_query($this->_conexion,"INSERT INTO parcela (idparcela,nombreparcela,phparcela,idadministrador, idtiposuelo,idvereda) VALUES (NULL,'$this->_nombreparcela', '$this->_phparcela','$this->_idadministrador','$this->_idtiposuelo','$this->_idvereda')") or die (mysqli_error($this->_conexion));
            session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'inserto ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $insercion;
            
        }
        function modificar (){
            $modificacion = mysqli_query($this->_conexion,"UPDATE parcela SET nombreparcela='$this->_nombreparcela',phparcela='$this->_phparcela',idadministrador='$this->_idadministrador',idtiposuelo='$this->_idtiposuelo',idvereda='$this->_idvereda' 
            WHERE idparcela = $this->_idparcela")  or die (mysqli_error($this->_conexion));
              session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'modifico ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $modificacion;
        }
        function eliminar(){
            $eliminacion = mysqli_query($this->_conexion, "DELETE FROM parcela  WHERE idparcela=$this->_idparcela")  or die (mysqli_error($this->_conexion));
            session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'elimino ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $eliminacion;
        }
        function cantidadpaginas(){
            $cantidadbloques=mysqli_query($this->_conexion,"SELECT CEIL(COUNT(idparcela)/$this->_paginacion) AS cantidad FROM parcela") or die(mysqli_error($this->_conexion));
            $unregistro=mysqli_fetch_array($cantidadbloques);
            return $unregistro['cantidad'];
        }
        function listar ($pagina){
            if ($pagina<=0){
                $listado = mysqli_query($this->_conexion,"SELECT * FROM parcela ORDER BY idparcela");
            }else{
                $paginacionmax = $pagina * $this->_paginacion;
                $paginacionmin = $paginacionmax - $this->_paginacion;
                $listado = mysqli_query($this->_conexion,"SELECT * FROM parcela LIMIT  $paginacionmin, $paginacionmax")   or die (mysqli_error($this->_conexion));
            }
            return $listado;    
        }
        function buscar ($busqueda){
            $busqueda = mysqli_query($this->_conexion,"SELECT * FROM parcela WHERE idparcela LIKE '%$busqueda%' OR nombreparcela LIKE '%$busqueda%' OR phparcela LIKE '%$busqueda%' or parcela.idadministrador IN (SELECT administrador.idadministrador FROM administrador WHERE nombreadministrador LIKE '%$busqueda%') OR parcela.idtiposuelo IN(SELECT tiposuelo.idtiposuelo FROM tiposuelo WHERE descripciontiposuelo LIKE '%$busqueda%') OR parcela.idvereda IN(SELECT vereda.idvereda FROM vereda WHERE nombrevereda LIKE '%$busqueda%') ")  or die (mysqli_error($this->_conexion));
            return $busqueda    ;    
        }
        function getpermiso ($idusuario){
            $permiso=mysqli_query($this->_conexion,"SELECT ".static::class."rol AS elpermiso FROM rol WHERE idrol IN(SELECT usuario.idrol FROM usuario WHERE usuario.idusuario =  $idusuario)") or die (mysqli_error($this->_conexion));
            $unregistro=mysqli_fetch_array($permiso);
            return $unregistro["elpermiso"];
        }
    }
?>