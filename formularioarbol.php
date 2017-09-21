<?php
 session_start();
 if (isset($_SESSION['id'])){
?> 
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>formulario arbol</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" >
    <link rel="stylesheet" href="css/font-awesome.min.css"  >
    </head>
    <body>
        <?php
           $formulario = "arbol";
           include_once("menu.php");
          $pagina = (isset($_GET['pag']))?$_GET['pag']:1;
          $busqueda = (isset($_GET['buscar']))?$_GET['buscar']:"";
        
        ?>
       <div class="container-fluid">
    <header>
        <br> 
        <h1>FORMULARIO ARBOL</h1>
        <br>
        <form>
            <input type="search" name="buscar" value="<?php echo $busqueda; ?>">
            <button class="btn btn-outline-primary" type="submit">Buscar</button>
        </form>
        <br>
        </header>
    <table class="table table-striped table-responsive ">
        <tbody>
        <tr>
           
            <th scope="col">ubicacion arbol con gps</th>
            <th scope="col">altura arbol</th>
            <th scope="col">fecha siembra arbol</th>
            <th scope="col">descripcion variedad</th>
            <th scope="col">nombre parcela</th>
            <th scope="col"></th>
        </tr>
        <?php
            
            include_once("../modelo/conexion.php");
            $objetoconexion = new conexion();
            $conexion = $objetoconexion->conectar();
            
            include_once("../modelo/parcela.php");
            $objetoparcela = new parcela($conexion,0,'idparcela','nombreparcela', 'phparcela','idadministrador','idtiposuelo','idvereda');
            $listaparcela = $objetoparcela->listar(0);
            
            
            include_once("../modelo/variedad.php");
            $objetovariedad = new variedad($conexion,0,'idvariedad','descripcionvariedad');
            $listavariedad = $objetovariedad->listar(0);

            include_once("../modelo/arbol.php");
            $objetoarbol = new arbol($conexion,0,'idarbol','gpsarbol','alturaarbol', 'fechasiembraarbol','idvariedad','idparcela');
            $permiso = $objetoarbol->getpermiso($_SESSION['id']);
            if (empty($busqueda)){
                $listaarbol = $objetoarbol->listar($pagina);
            }else{
                $listaarbol = $objetoarbol->buscar($busqueda);
            }
            if(stripos($permiso,"r")!==false){            //lista
            while($unregistro =mysqli_fetch_array($listaarbol)){
                echo'<tr><form class="form-control" id="fmodificararbol"'.$unregistro["idarbol"].' action="../controlador/controladorarbol.php" method="post">';
                echo '<td><input type="hidden" name="fidarbol" value=" '.$unregistro['idarbol'].'">';
                
                echo '    <input type="text" name="fgpsarbol" value="'.$unregistro['gpsarbol'].'"></td>';
                
                echo '<td><input type="number" name="falturaarbol" value="'.$unregistro['alturaarbol'].'"></td>';
                
                 echo '<td><input type="date" name="ffechasiembraarbol" value="'.$unregistro['fechasiembraarbol'].'"></td>';
                 
                  echo '<td><select name="fidvariedad">';
                    while($registrova = mysqli_fetch_array($listavariedad)){
                   echo '<option value="'.$registrova['idvariedad'].'"';
                   if($unregistro['idvariedad'] == $registrova['idvariedad']){  
                       echo " selected ";
                   }
                   echo '>'.$registrova['descripcionvariedad'].'</option>';
                }
                mysqli_data_seek($listavariedad,0);
                echo '</select></td>';
                
                echo '<td><select name="fidparcela">';
                    while($registropa = mysqli_fetch_array($listaparcela)){
                   echo '<option value="'.$registropa['idparcela'].'"';
                   if($unregistro['idparcela'] == $registropa['idparcela']){  
                       echo " selected ";
                   }
                   echo '>'.$registropa['nombreparcela'].'</option>';
                }
                mysqli_data_seek($listaparcela,0);
                echo '</select></td>';
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
        ?>    
        <?php
            if(stripos($permiso,"c")!==false){            //crear
        ?>
            
            
            <tr><form id="fingresararbol" class="form-control" action="../controlador/controladorarbol.php" method="post">
                
            <td><input type="hidden" name="fidarbol" value="0">
                <input type="text" name="fgpsarbol"></td>
            <td><input type="number" name="falturaarbol"></td>
            <td><input type="date" name="ffechasiembraarbol"></td>
            <td><select name="fidvariedad">
                 <?php
                      while($registrova = mysqli_fetch_array($listavariedad)){
                           echo '<option value="'.$registrova['idvariedad'].'">'.$registrova['descripcionvariedad'].'</option>';
                      }
                    ?>
                    </select>
                    </td>
                    
                    <td><select name="fidparcela">
                 <?php
                      while($registropa = mysqli_fetch_array($listaparcela)){
                           echo '<option value="'.$registropa['idparcela'].'">'.$registropa['nombreparcela'].'</option>';
                      }
                    ?>
                    </select>
                    </td>
                    
                
            <td> <button type="submit" class="btn btn-primary btn-sm" name="fenviar" value="ingresar"><i class="fa fa-check fa-2x"></i></button>
                  <button type="reset" name="fenviar" value="limpiar" class="btn btn-warning btn-sm"><i class="fa fa-eraser fa-2x"></i></button>
                </td>
                </form> </tr>
            <?php
            } // fin crear
                ?>
        
        </tbody>
        </table>
       
              <nav>
        <ul class="pagination">
            <?php
            $cantPaginas=$objetoarbol->cantidadPaginas();
            if($cantPaginas>1){
                if($pagina>1){
                    echo '<li class="page-item"><a class="page-link" href="formularioarbol.php?pag='.($pagina-1).'" aria-label="Anterior"><span aria-hidden="true">&laquo;</span></a></li>';
                }
                for($i=1;$i<=$cantPaginas;$i++){
                    if($i==$pagina){
                        echo '<li class="page-item active"><a class="page-link" href="#">'.$i.'</a></li>';
                    }else{
                        echo '<li class="page-item" class="page-item"><a class="page-link" href="formularioarbol.php?pag='.$i.'">'.$i.'</a></li>';
                    }
                }
                if ($pagina<$cantPaginas){
                    echo '<li class="page-item"><a class="page-link" href="formularioarbol.php?pag='.($pagina+1).'" aria-label="Siguiente"><span aria-hidden="true">&raquo;</span></a></li>';
                }
            }
            ?>
            </ul>
        </nav>
        </div>
          <?php
            mysqli_free_result($listaarbol);
            mysqli_free_result($listaparcela);
            mysqli_free_result($listavariedad);
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