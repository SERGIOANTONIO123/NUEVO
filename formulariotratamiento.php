<?php
     session_start();
     if (isset($_SESSION['id'])){
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>formulario tratamiento</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="css/font-awesome.min.css" rel="stylesheet">
</head>
    <body>
        <?php
           $formulario = "tratamiento";
           include_once("menu.php");
          $pagina = (isset($_GET['pag']))?$_GET['pag']:1;
         $busqueda = (isset($_GET['buscar']))?$_GET['buscar']:"";
        ?>
        <div class="container-fluid">
    <header>
        <br>
        <h1>FORMULARIO TRATAMIENTO</h1>
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
           
            <th scope="col">fecha aplicacion</th>
            <th scope="col">cantidad tratamiento</th>
            <th scope="col">id del ataque</th>
            <th scope="col">descripcion del tipo de tratamiento</th>
            <th scope="col"></th>
        </tr>
        <?php
            
            include_once("../modelo/conexion.php");
            $objetoconexion = new conexion();
            $conexion = $objetoconexion->conectar();
            
            include_once("../modelo/tratamiento.php");
            $objetotratamiento = new tratamiento($conexion,0,'idtratamiento','fechaaplicacion','cantidadtratamiento', 'idataque','idtipotratamiento');
            $permiso = $objetotratamiento->getpermiso($_SESSION['id']);
             if (empty($busqueda)){
                $listatratamiento = $objetotratamiento->listar($pagina);
            }else{
                $listatratamiento = $objetotratamiento->buscar($busqueda);
            }
            
            
            include_once("../modelo/ataques.php");
            $objetoataques = new ataques($conexion,0,'idataque','fechaataque','porcentajeataque', 'idarbol','idenfermedad');
            $listaataques = $objetoataques->listar(0);
            
            include_once("../modelo/tipotratamiento.php");
            $objetotipotratamiento = new tipotratamiento($conexion,0,'idtipotratamiento', 'descripciontipotratamiento');
            $listatipotratamiento = $objetotipotratamiento->listar(0);
         
            if(stripos($permiso,"r")!==false){            //lista
            while($unregistro =mysqli_fetch_array($listatratamiento)){
                echo'<tr><form class="form-control" id="fmodificartratamiento"'.$unregistro["idtratamiento"].' action="../controlador/controladortratamiento.php" method="post">';
                echo '<td><input type="hidden" name="fidtratamiento" value=" '.$unregistro['idtratamiento'].'">';
                echo '    <input type="date" name="ffechaaplicacion" value="'.$unregistro['fechaaplicacion'].'"></td>';
                
                echo '<td><input type="number" name="fcantidadtratamiento" value="'.$unregistro['cantidadtratamiento'].'"></td>';
                
                 echo '<td><select name="fidataque">';
                while($registroat = mysqli_fetch_array($listaataques)){
                   echo '<option value="'.$registroat['idataque'].'"';
                   if($unregistro['idataque'] == $registroat['idataque']){  
                       echo " selected ";
                   }
                   echo '>'.$registroat['idataque'].'</option>';
                }
                mysqli_data_seek($listaataques,0);
                echo '</select></td>';
                
                 echo '<td><select name="fidtipotratamiento">';
                while($registrott = mysqli_fetch_array($listatipotratamiento)){
                   echo '<option value="'.$registrott['idtipotratamiento'].'"';
                   if($unregistro['idtipotratamiento'] == $registrott['idtipotratamiento']){  
                       echo " selected ";
                   }
                   echo '>'.$registrott['descripciontipotratamiento'].'</option>';
                }
                mysqli_data_seek($listatipotratamiento,0);
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
            if(stripos($permiso,"c")!==false){            //crear
        ?>    
            <tr><form id="fingresartratamiento" class="form-control" action="../controlador/controladortratamiento.php" method="post">
                
            <td><input type="hidden" name="fidtratamiento" value="0">
                <input type="date" name="ffechaaplicacion"></td>
            <td><input type="number" name="fcantidadtratamiento"></td>
            
            <td><select id="sele" name="fidataque">
                    <?php
                      while($registroat = mysqli_fetch_array($listaataques)){
                           echo '<option value="'.$registroat['idataque'].'">'.$registroat['idataque'].'</option>';
                      }
                    ?>
                    </select>
                    </td>
                    
                    <td><select name="fidtipotratamiento">
                    <?php
                      while($registrott = mysqli_fetch_array($listatipotratamiento)){
                        echo '<option value="'.$registrott['idtipotratamiento'].'">'.$registrott['descripciontipotratamiento'].'</option>';
                      }
                    ?>
                    </select>
                    </td>
                
                
             
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
            $cantPaginas=$objetotratamiento->cantidadPaginas();
            if($cantPaginas>1){
                if($pagina>1){
                    echo '<li class="page-item"><a class="page-link" href="formulariotratamiento.php?pag='.($pagina-1).'" aria-label="Anterior"><span aria-hidden="true">&laquo;</span></a></li>';
                }
                for($i=1;$i<=$cantPaginas;$i++){
                    if($i==$pagina){
                        echo '<li class="page-item active"><a class="page-link" href="#">'.$i.'</a></li>';
                    }else{
                        echo '<li class="page-item" class="page-item"><a class="page-link" href="formulariotratamiento.php?pag='.$i.'">'.$i.'</a></li>';
                    }
                }
                if ($pagina<$cantPaginas){
                    echo '<li class="page-item"><a class="page-link" href="formulariotratamiento.php?pag='.($pagina+1).'" aria-label="Siguiente"><span aria-hidden="true">&raquo;</span></a></li>';
                }
            }
            ?>
            </ul>
        </nav>
            </div>
      <?php
            mysqli_free_result($listaataques);
            mysqli_free_result($listatratamiento);
            mysqli_free_result($listatipotratamiento);
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
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    