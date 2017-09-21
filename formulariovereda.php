<?php
     session_start();
     if (isset($_SESSION['id'])){
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>formulario vereda</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    </head>
    <body>
        <?php
           $formulario = "vereda";
           include_once("menu.php");
           $pagina = (isset($_GET['pag']))?$_GET['pag']:1;
            $busqueda = (isset($_GET['buscar']))?$_GET['buscar']:"";
        ?>
        <div class="container-fluid">
    <header>
        <br>
        <h2>FORMULARIO VEREDA</h2>
        <BR>
            <form>
            <input type="search" name="buscar" value="<?php echo $busqueda; ?>">
            <button class="btn btn-outline-primary" type="submit">Buscar</button>
        </form>
        <br>
        </header>
        <br>
    <table class="table table-striped table-responsive">
   
        <tbody>
        <tr>
           
            <th scope="col">NOMBRE VEREDA</th>
            <th scope="col"></th>
        </tr>
        <?php
            
            include_once("../modelo/conexion.php");
            $objetoconexion = new conexion();
            $conexion = $objetoconexion->conectar();
            
            include_once("../modelo/vereda.php");
            $objetovereda = new vereda($conexion,0,'idvereda','nombrevereda');
            $permiso = $objetovereda->getpermiso($_SESSION['id']);
             if (empty($busqueda)){
                $listavereda = $objetovereda->listar($pagina);
            }else{
               $listavereda = $objetovereda->buscar($busqueda);
            }
            
            
            
            if(stripos($permiso,"r")!==false){            //lista
            while($unregistro =mysqli_fetch_array($listavereda)){
                echo'<tr ><form class="form-control" id="fmodificarvereda"'.$unregistro["idvereda"].' action="../controlador/controladorvereda.php" method="post">';
                echo '<td><input type="hidden" name="fidvereda" value=" '.$unregistro['idvereda'].'">';
                echo '    <input type="text" name="fnombrevereda" value="'.$unregistro['nombrevereda'].'"></td>';
                
                 echo '<td>';
                
                if(stripos($permiso,"u")!==false){  //modificar
               echo' <button type="submit" name="fenviar" value="modificar" class="btn btn-success btn-sm"><i class="fa fa-pencil fa-2x"></i></button>';
                }
                if(stripos($permiso,"d")!==false){            //eliminar
                echo'<button type="submit" name="fenviar" value="eliminar" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>';
                }
                  echo'       </td>';
                echo '</form></tr>'; 
            }
            }
             if(stripos($permiso,"c")!==false){            //crear
        ?>    
            <tr ><form id="fingresarvereda" class="form-control" action="../controlador/controladorvereda.php" method="post" >
                
            <td><input type="hidden" name="fidvereda" value="0">
            <input type="text" name="fnombrevereda"></td>
                
                
          
                
               <td> <button type="submit" class="btn btn-primary btn-sm" name="fenviar" value="ingresar"><i class="fa fa-check fa-2x"></i></button>
                  <button type="reset" name="fenviar" value="limpiar" class="btn btn-warning btn-sm"><i class="fa fa-eraser fa-2x"></i></button>
                </td>
                </form> </tr>
            <?php
                }
            ?>
        </tbody>
        </table>
      
        <nav>
        <ul class="pagination">
            <?php
            $cantPaginas=$objetovereda->cantidadPaginas();
            if($cantPaginas>1){
                if($pagina>1){
                    echo '<li class="page-item"><a class="page-link" href="formulariovereda.php?pag='.($pagina-1).'" aria-label="Anterior"><span aria-hidden="true">&laquo;</span></a></li>';
                }
                for($i=1;$i<=$cantPaginas;$i++){
                    if($i==$pagina){
                        echo '<li class="page-item active"><a class="page-link" href="#">'.$i.'</a></li>';
                    }else{
                        echo '<li class="page-item" class="page-item"><a class="page-link" href="formulariovereda.php?pag='.$i.'">'.$i.'</a></li>';
                    }
                }
                if ($pagina<$cantPaginas){
                    echo '<li class="page-item"><a class="page-link" href="formulariovereda.php?pag='.($pagina+1).'" aria-label="Siguiente"><span aria-hidden="true">&raquo;</span></a></li>';
                }
            }
            ?>
            </ul>
        </nav>
        </div>
              <?php
            mysqli_free_result($listavereda);
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
