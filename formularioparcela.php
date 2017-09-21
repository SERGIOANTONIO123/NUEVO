<?php
     session_start();
     if (isset($_SESSION['id'])){
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>formulario parcela</title>
     <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    </head>
    <body>
        <?php
           $formulario = "parcela";
           include_once("menu.php");
           $pagina = (isset($_GET['pag']))?$_GET['pag']:1;
            $busqueda = (isset($_GET['buscar']))?$_GET['buscar']:"";
        ?>
        <div class="container-fluid">
    <header>
        <br>
        <h1>FORMULARIO PARCELA</h1>
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
           
            <th scope="col">NOMBRE PARCELA</th>
            <th scope="col">PH DE LA PARCELA</th>
            <th scope="col">NOMBRE DEL ADMINISTRADOR</th>
            <th scope="col">TIPO DE SUELO</th>
            <th scope="col">NOMBRE VEREDA</th>
            <th scope="col"></th>
        </tr>
        <?php
            
            include_once("../modelo/conexion.php");
            $objetoconexion = new conexion();
            $conexion = $objetoconexion->conectar();
            
            include_once("../modelo/parcela.php");
            $objetoparcela = new parcela($conexion,0,'idparcela','nombreparcela', 'phparcela','idadministrador','idtiposuelo','idvereda');
            $permiso = $objetoparcela->getpermiso($_SESSION['id']);
              if (empty($busqueda)){
                 $listaparcela = $objetoparcela->listar($pagina);
            }else{
                $listaparcela = $objetoparcela->buscar($busqueda);
            }
           
            
            include_once("../modelo/administrador.php");
            $objetoadministrador = new administrador($conexion,0,'idadministrador','nombreadministrador','telefonoadministrador');
            $listaadministrador = $objetoadministrador->listar(0);
            
            include_once("../modelo/vereda.php");
            $objetovereda = new vereda($conexion,0,'idvereda','nombrevereda');
            $listavereda = $objetovereda->listar(0);
            
            include_once("../modelo/tiposuelo.php");
            $objetotiposuelo = new tiposuelo($conexion,0,'idtiposuelo','descripciontiposuelo');
            $listatiposuelo = $objetotiposuelo->listar(0);
    
            if(stripos($permiso,"r")!==false){            //lista
            while($unregistro =mysqli_fetch_array($listaparcela)){
                echo'<tr><form class="form-control" id="fmodificarparcela"'.$unregistro["idparcela"].' action="../controlador/controladorparcela.php" method="post">';
                echo '<td><input type="hidden" name="fidparcela" value=" '.$unregistro['idparcela'].'">';
                echo '    <input type="text" name="fnombreparcela" value="'.$unregistro['nombreparcela'].'"></td>';
                echo '<td><input type="number" name="fphparcela" value="'.$unregistro['phparcela'].'"></td>';
                
                echo '<td><select name="fidadministrador">';
                while($registroadmin = mysqli_fetch_array($listaadministrador)){
                   echo '<option value="'.$registroadmin['idadministrador'].'"';
                   if($unregistro['idadministrador'] == $registroadmin['idadministrador']){  
                       echo " selected ";
                   }
                   echo '>'.$registroadmin['nombreadministrador'].'</option>';
                }
                mysqli_data_seek($listaadministrador,0);
                echo '</select></td>';
                
                
                
                
                echo '<td><select name="fidtiposuelo">';
                    while($registrotipo = mysqli_fetch_array($listatiposuelo)){
                   echo '<option value="'.$registrotipo['idtiposuelo'].'"';
                   if($unregistro['idtiposuelo'] == $registrotipo['idtiposuelo']){  
                       echo " selected ";
                   }
                   echo '>'.$registrotipo['descripciontiposuelo'].'</option>';
                }
                mysqli_data_seek($listatiposuelo,0);
                echo '</select></td>';
                    
                    
                
                echo '<td><select name="fidvereda">';
                     while($registrovere = mysqli_fetch_array($listavereda)){
                   echo '<option value="'.$registrovere['idvereda'].'"';
                   if($unregistro['idvereda'] == $registrovere['idvereda']){  
                       echo " selected ";
                   }
                   echo '>'.$registrovere['nombrevereda'].'</option>';
                }
                mysqli_data_seek($listavereda,0);
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
     }// fin lista
         if(stripos($permiso,"c")!==false){            //crear
        ?>    
            <tr><form id="fingresarparcela" class="form-control" action="../controlador/controladorparcela.php" method="post">
                
            <td><input type="hidden" name="fidparcela" value="0">
                 <input type="text" name="fnombreparcela"></td>
            <td><input type="number" name="fphparcela"></td>
            <td><select name="fidadministrador">
                <?php
                      while($registroadmin = mysqli_fetch_array($listaadministrador)){
                           echo '<option value="'.$registroadmin['idadministrador'].'">'.$registroadmin['nombreadministrador'].'</option>';
                      }
                    ?>
                    </select>
                    </td>
                
                
            <td><select name="fidtiposuelo">
                 <?php
                      while($registrotipo = mysqli_fetch_array($listatiposuelo)){
                           echo '<option value="'.$registrotipo['idtiposuelo'].'">'.$registrotipo['descripciontiposuelo'].'</option>';
                      }
                    ?>
                    </select>
                    </td>
            <td><select name="fidvereda">
                 <?php
                      while($registrovere = mysqli_fetch_array($listavereda)){
                           echo '<option value="'.$registrovere['idvereda'].'">'.$registrovere['nombrevereda'].'</option>';
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
            $cantPaginas=$objetoparcela->cantidadPaginas();
            if($cantPaginas>1){
                if($pagina>1){
                    echo '<li class="page-item"><a class="page-link" href="formularioparcela.php?pag='.($pagina-1).'" aria-label="Anterior"><span aria-hidden="true">&laquo;</span></a></li>';
                }
                for($i=1;$i<=$cantPaginas;$i++){
                    if($i==$pagina){
                        echo '<li class="page-item active"><a class="page-link" href="#">'.$i.'</a></li>';
                    }else{
                        echo '<li class="page-item" class="page-item"><a class="page-link" href="formularioparcela.php?pag='.$i.'">'.$i.'</a></li>';
                    }
                }
                if ($pagina<$cantPaginas){
                    echo '<li class="page-item"><a class="page-link" href="formularioparcela.php?pag='.($pagina+1).'" aria-label="Siguiente"><span aria-hidden="true">&raquo;</span></a></li>';
                }
            }
            ?>
            </ul>
        </nav>
        </div>
              <?php
            mysqli_free_result($listaparcela);
            mysqli_free_result($listaadministrador);
            mysqli_free_result($listavereda);
            mysqli_free_result($listatiposuelo);
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