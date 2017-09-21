<?php
     session_start();
     if (isset($_SESSION['id'])){
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>formulario ataques</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" >
    <link href="css/font-awesome.min.css" rel="stylesheet">
    </head>
    <body>
        <?php
           $formulario = "ataques";
           include_once("menu.php");
           $pagina = (isset($_GET['pag']))?$_GET['pag']:1;
           $busqueda = (isset($_GET['buscar']))?$_GET['buscar']:"";
        ?>
        <div class="container-fluid">
    <header>
        <br>
        <h1>FORMULARIO ATAQUES</h1>
        <br>
        <form>
            <input type="search" name="buscar" value="<?php echo $busqueda; ?>">
            <button class="btn btn-outline-primary" type="submit">Buscar</button>
        </form>
        <br>
        </header>
    <table class="table table-striped  table-responsive">
        <tbody>
        <tr>
           
            <th scope="col">FECHA ATAQUE</th>
            <th scope="col">PORCENTAJE ATAQUE</th>
            <th scope="col">ID ARBOL</th>
            <th scope="col">DESCRIPCION ENFERMEDAD</th>
            <th scope="col"></th>
        </tr>
        <?php
            
            include_once("../modelo/conexion.php");
            $objetoconexion = new conexion();
            $conexion = $objetoconexion->conectar();
            
            include_once("../modelo/ataques.php");
            $objetoataques = new ataques($conexion,0,'idataque','fechaataque','porcentajeataque', 'idarbol','idenfermedad');
            $permiso = $objetoataques->getpermiso($_SESSION['id']);
             if (empty($busqueda)){
                $listaataques = $objetoataques->listar($pagina);
            }else{
                $listaataques = $objetoataques->buscar($busqueda);
            }
            
            include_once("../modelo/arbol.php");
            $objetoarbol = new arbol($conexion,0,'idarbol','gpsarbol','alturaarbol', 'fechasiembraarbol','idvariedad','idparcela');
            $listaarbol = $objetoarbol->listar(0);
            
            include_once("../modelo/enfermedad.php");
            $objetoenfermedad = new enfermedad($conexion,0,'idenfermedad','descripcionenfermedad');
            $listaenfermedad = $objetoenfermedad->listar(0);
            
            if(stripos($permiso,"r")!==false){            //lista
            while($unregistro =mysqli_fetch_array($listaataques)){
                echo'<tr><form class="form-control" id="fmodificarataques"'.$unregistro["idataque"].' action="../controlador/controladorataques.php" method="post">';
                echo '<td><input type="hidden" name="fidataque" value=" '.$unregistro['idataque'].'">';
                echo '    <input type="date" name="ffechaataque" value="'.$unregistro['fechaataque'].'"></td>';
                
                echo '<td><input type="number" name="fporcentajeataque" value="'.$unregistro['porcentajeataque'].'"></td>';
                
                 echo '<td><select name="fidarbol">';
                while($registroa = mysqli_fetch_array($listaarbol)){
                   echo '<option value="'.$registroa['idarbol'].'"';
                   if($unregistro['idarbol'] == $registroa['idarbol']){  
                       echo " selected ";
                   }
                   echo '>'.$registroa['idarbol'].'</option>';
                }
                mysqli_data_seek($listaarbol,0);
                echo '</select></td>';
                
                 echo '<td><select name="fidenfermedad">';
                while($registroen = mysqli_fetch_array($listaenfermedad)){
                   echo '<option value="'.$registroen['idenfermedad'].'"';
                   if($unregistro['idenfermedad'] == $registroen['idenfermedad']){  
                       echo " selected ";
                   }
                   echo '>'.$registroen['descripcionenfermedad'].'</option>';
                }
                mysqli_data_seek($listaenfermedad,0);
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
            } //fin lista
        ?>    
            
            <?php
                if(stripos($permiso,"c")!==false){            //crear
            ?>
            <tr><form id="fingresarataques" class="form-control" action="../controlador/controladorataques.php" method="post">
                
            <td><input type="hidden" name="fidataque" value="0">
                <input type="date" name="ffechaataque"></td>
            <td><input type="number" name="fporcentajeataque"></td>
            
            <td><select name="fidarbol">
                    <?php
                      while($registroa = mysqli_fetch_array($listaarbol)){
                           echo '<option value="'.$registroa['idarbol'].'">'.$registroa['idarbol'].'</option>';
                      }
                    ?>
                    </select>
                    </td>
                    
                    <td><select name="fidenfermedad">
                    <?php
                      while($registroen = mysqli_fetch_array($listaenfermedad)){
                        echo '<option value="'.$registroen['idenfermedad'].'">'.$registroen['descripcionenfermedad'].'</option>';
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
            $cantPaginas=$objetoataques->cantidadPaginas();
            if($cantPaginas>1){
                if($pagina>1){
                    echo '<li class="page-item"><a class="page-link" href="formularioataques.php?pag='.($pagina-1).'" aria-label="Anterior"><span aria-hidden="true">&laquo;</span></a></li>';
                }
                for($i=1;$i<=$cantPaginas;$i++){
                    if($i==$pagina){
                        echo '<li class="page-item active"><a class="page-link" href="#">'.$i.'</a></li>';
                    }else{
                        echo '<li class="page-item" class="page-item"><a class="page-link" href="formularioataques.php?pag='.$i.'">'.$i.'</a></li>';
                    }
                }
                if ($pagina<$cantPaginas){
                    echo '<li class="page-item"><a class="page-link" href="formularioataques.php?pag='.($pagina+1).'" aria-label="Siguiente"><span aria-hidden="true">&raquo;</span></a></li>';
                }
            }
            ?>
            </ul>
        </nav>
        </div>
         <?php
            mysqli_free_result($listaataques);
            mysqli_free_result($listaarbol);
            mysqli_free_result($listaenfermedad);
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