<?php
     session_start();
     if (isset($_SESSION['id'])){
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>formulario auditoria</title>
   <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css"  >
    </head>
    <body>
        <?php
           $formulario = "auditoria";
           include_once("menu.php");
           $pagina = (isset($_GET['pag']))?$_GET['pag']:1;
           $busqueda = (isset($_GET['buscar']))?$_GET['buscar']:"";
        ?>
        <div class="container-fluid">
    <header>
        <br>
        <h1>FORMULARIO AUDITORIA</h1>
        <BR>
         <form>
            <input type="search" name="buscar" value="<?php echo $busqueda; ?>">
            <button class="btn btn-outline-primary" type="submit">Buscar</button>
        </form>
        <br>    
        </header>
    <table class="table table-striped table-responsive">
        <tbody>
        <tr>
             <th scope="col">ID</th>
            <th scope="col">FECHA AUDITORIA</th>
            <th scope="col">DESCRIPCION AUDITORIA</th>
            <th scope="col">NOMBRE USUARIO</th>
            
        </tr>
        <?php 
            include_once("../modelo/conexion.php");
            $objetoconexion = new conexion();
            $conexion = $objetoconexion->conectar();
            
            include_once("../modelo/auditoria.php");
            $objetoauditoria = new auditoria($conexion,0,'idauditoria','fechaauditoria','descripcionauditoria','idusuario');
            $permiso = $objetoauditoria->getpermiso($_SESSION['id']);
             if (empty($busqueda)){
                $listaauditoria = $objetoauditoria->listar($pagina);
            }else{
                $listaauditoria = $objetoauditoria->buscar($busqueda);
            }
            
            
            include_once("../modelo/usuario.php");
            $objetousuario = new usuario($conexion,0,'idusuario','nombreusuario','emailusuario','claveusuario','fecharegistrousuario','fechaultimaclave','idrol');
            $listausuario = $objetousuario->listar(0);
            
            
            if(stripos($permiso,"r")!==false){            //lista
            while($unregistro =mysqli_fetch_array($listaauditoria)){
                echo'<tr><form class="form-control" id="fmodificarauditoria"'.$unregistro["idauditoria"].' action="../controlador/controladorauditoria.php" method="post"></td>';
                echo '<td><input type="number" name="fidauditoria"        value="'.$unregistro['idauditoria'].'"></td>';
                echo '<td><input type="text" name="ffechaauditoria"       value="'.$unregistro['fechaauditoria'].'"></td>';
                echo '<td><input type="text" name="fdescripcionauditoria" value="'.$unregistro['descripcionauditoria'].'"></td>';
                echo '<td><input type="text" name="fusuario"              value="'.$unregistro['nombreusuario'].'"</td>';
                echo '</form></tr>';  
            }
            } //fin lista  
        ?>    
           
        </tbody>
        </table>
      
           <nav>
        <ul class="pagination">
            <?php
            $cantPaginas=$objetoauditoria->cantidadPaginas();
            if($cantPaginas>1){
                if($pagina>1){
                    echo '<li class="page-item"><a class="page-link" href="formularioauditoria.php?pag='.($pagina-1).'" aria-label="Anterior"><span aria-hidden="true">&laquo;</span></a></li>';
                }
                for($i=1;$i<=$cantPaginas;$i++){
                    if($i==$pagina){
                        echo '<li class="page-item active"><a class="page-link" href="#">'.$i.'</a></li>';
                    }else{
                        echo '<li class="page-item" class="page-item"><a class="page-link" href="formularioauditoria.php?pag='.$i.'">'.$i.'</a></li>';
                    }
                }
                if ($pagina<$cantPaginas){
                    echo '<li class="page-item"><a class="page-link" href="formularioauditoria.php?pag='.($pagina+1).'" aria-label="Siguiente"><span aria-hidden="true">&raquo;</span></a></li>';
                }
            }
            ?>
            </ul>
        </nav>
            </div>
        <?php
            mysqli_free_result($listaauditoria);
            mysqli_free_result($listausuario);
            $objetoconexion->desconectar($conexion);
        ?>
        <script src="js/jquery-3.1.1.slim.min.js"></script>
        <script src="js/tether.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html> 
  <?php
}else{
    header("location:../index.html?mensaje=nosesion");
}
?>