<?php
    class rol{
        private $_conexion;
        private $_idrol;
        private $_nombrerol;
        private $_arbolrol;
        private $_produccionrol;
        private $_podasrol;
        private $_tipopodarol;
        private $_variedadrol;
        private $_foliacionrol;
        private $_floracionrol;
        private $_ataquerol;
        private $_enfermedadrol;
        private $_parcelarol;
        private $_tiposuelorol;
        private $_administradorrol;
        private $_tratamientorol;
        private $_tipotratamientorol;
        private $_ventasrol;
        private $_clienterol;
        private $_auditoriarol;
        private $_usuariorol;
        private $_veredarol;
        private $_rolrol;
        private $_paginacion=10;
        
        function __construct($conexion,$idrol,$nombrerol,$arbolrol,$produccionrol,$podasrol,$tipopodarol,$variedadrol,$foliacionrol, $floracionrol, $ataquerol,$enfermedadrol,$parcelarol,$tiposuelorol, $administradorrol,$tratamientorol,$tipotratamientorol,$ventasrol,$clienterol,$auditoriarol,$usuariorol,$veredarol,$rolrol){
            
            $this->_conexion = $conexion;
            $this->_idrol = $idrol;
            $this->_nombrerol = $nombrerol;
            $this->_arbolrol = $arbolrol;
            $this->_produccionrol = $produccionrol;
            $this->_podasrol = $podasrol;
            $this->_tipopodarol = $tipopodarol;
            $this->_variedadrol = $variedadrol;
            $this->_foliacionrol = $foliacionrol;
            $this->_floracionrol = $floracionrol;
            $this->_ataquerol = $ataquerol;
            $this->_enfermedadrol = $enfermedadrol;
            $this->_parcelarol = $parcelarol;
            $this->_tiposuelorol = $tiposuelorol;
            $this->_administradorrol = $administradorrol;
            $this->_tratamientorol = $tratamientorol;
            $this->_tipotratamientorol = $tipotratamientorol;
            $this->_ventasrol = $ventasrol;
            $this->_clienterol = $clienterol;
            $this->_auditoriarol = $auditoriarol;
            $this->_usuariorol = $usuariorol;
            $this->_veredarol = $veredarol;
            $this->_rolrol = $rolrol;
            $_SESSION['idusuario']=1;
        }
        function __get($k){
            return $this->$k;
        }
        function __set($k,$v){
            return $this->$k = $v;
        }
        function insertar(){
            $insercion = mysqli_query($this->_conexion,"INSERT INTO rol (idrol, nombrerol, arbolrol, produccionrol, podasrol, tipopodarol, variedadrol, foliacionrol, floracionrol, ataquerol, enfermedadrol, parcelarol, tiposuelorol, administradorrol, tratamientorol, tipotratamientorol, ventasrol, clienterol, auditoriarol, usuariorol, veredarol, rolrol) VALUES (NULL, '$this->_nombrerol', '$this->_arbolrol', '$this->_produccionrol', '$this->_podasrol',  
            '$this->_tipopodarol', '$this->_variedadrol', '$this->_foliacionrol', '$this->_floracionrol', '$this->_ataquerol', '$this->_enfermedadrol', '$this->_parcelarol', '$this->_tiposuelorol', '$this->_administradorrol', '$this->_tratamientorol', '$this->_tipotratamientorol', '$this->_ventasrol', '$this->_clienterol', '$this->_auditoriarol', '$this->_usuariorol', '$this->_veredarol',           '$this->_rolrol')")  or die (mysqli_error($this->_conexion));
             session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'inserto ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $insercion;
            
        }
        function modificar (){
            $modificacion = mysqli_query($this->_conexion,"UPDATE rol SET nombrerol='$this->_nombrerol', 
            arbolrol='$this->_arbolrol', produccionrol='$this->_produccionrol', podasrol='$this->_podasrol', 
            tipopodarol='$this->_tipopodarol', variedadrol='$this->_variedadrol',    
            foliacionrol='$this->_foliacionrol',  floracionrol='$this->_floracionrol',
            ataquerol='$this->_ataquerol', enfermedadrol='$this->_enfermedadrol', 
            parcelarol='$this->_parcelarol', tiposuelorol='$this->_tiposuelorol', 
            administradorrol='$this->_administradorrol', tratamientorol='$this->_tratamientorol',
            tipotratamientorol='$this->_tipotratamientorol', ventasrol='$this->_ventasrol',
            clienterol='$this->_clienterol', auditoriarol='$this->_auditoriarol', 
            usuariorol='$this->_usuariorol', veredarol='$this->_veredarol', rolrol='$this->_rolrol'  
            WHERE idrol=$this->_idrol ")  or die (mysqli_error($this->_conexion));
            session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'modifico ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $modificacion;
        }
        function eliminar(){
            $eliminacion = mysqli_query($this->_conexion, "DELETE FROM rol  WHERE idrol=$this->_idrol") or die (mysqli_error($this->_conexion));
            session_start();
            $auditoria = mysqli_query($this->_conexion,"INSERT INTO auditoria(idauditoria, descripcionauditoria, idusuario, fechaauditoria)VALUES (NULL, 'elimino ".static::class." ', ".$_SESSION['id'].",CURDATE())");
            return $eliminacion;
        }
        function cantidadpaginas(){
            $cantidadbloques=mysqli_query($this->_conexion,"SELECT CEIL(COUNT(idrol)/$this->_paginacion) AS cantidad FROM rol") or die(mysqli_error($this->_conexion));
            $unregistro=mysqli_fetch_array($cantidadbloques);
            return $unregistro['cantidad'];
        }
        function listar ($pagina){
            if ($pagina<=0){
                $listado = mysqli_query($this->_conexion,"SELECT * FROM rol ORDER BY idrol");
            }else{
                $paginacionmax = $pagina * $this->_paginacion;
                $paginacionmin = $paginacionmax - $this->_paginacion;
                $listado = mysqli_query($this->_conexion,"SELECT * FROM rol LIMIT  $paginacionmin, $paginacionmax")   or die (mysqli_error($this->_conexion));
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