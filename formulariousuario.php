<?php
 session_start();
            if (isset($_SESSION['id'])){
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>formulario usuario</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" >
    <link href="css/font-awesome.min.css" rel="stylesheet" >
    </head>
    <body>
        <?php
           $formulario = "usuario";
           include_once("menu.php");
           $pagina = (isset($_GET['pag']))?$_GET['pag']:1;
            
        ?>
        <div class="container-fluid">
    <header>
        <br>
        <h1>FORMULARIO USUARIO</h1>
        <BR>
        </header>
    <table class="table table-striped table-responsive">
        <tbody>
        <tr>
           
            <th scope="col">NOMBRE</th>
            <th scope="col">EMAIL</th>
            <th scope="col">CLAVE</th>
            <th scope="col">FECHA DE REGISTRO</th>
            <th scope="col">FECHA ULTIMA CLAVE</th>
            <th scope="col">NOMBRE ROL</th>
            <th scope="col"></th>
        </tr>
        <?php
            
            include_once("../modelo/conexion.php");
            $objetoconexion = new conexion();
            $conexion = $objetoconexion->conectar();
            
            include_once("../modelo/usuario.php");
            $objetousuario = new usuario($conexion,0,'idusuario','nombreusuario','emailusuario','claveusuario','fecharegistrousuario','fechaultimaclave','idrol');
            $permiso = $objetousuario->getpermiso($_SESSION['id']);
            $listausuario = $objetousuario->listar($pagina);
            
            include_once("../modelo/rol.php");
            $objetorol = new rol($conexion,0,'idrol','nombrerol','arbolrol','produccionrol','podasrol','tipopodarol', 'variedadrol', 'foliacionrol','floracionrol','ataquerol', 'enfermedadrol', 'parcelarol', 'tiposuelorol', 'administradorrol','tratamientorol','tipotratamientorol'  ,'ventasrol','clienterol','auditoriarol','usuariorol', 'veredarol','rolrol');
            $listarol = $objetorol->listar(0);
            
            
            if(stripos($permiso,"r")!==false){            //lista
            while($unregistro =mysqli_fetch_array($listausuario)){
                echo'<tr><form class="form-control" id="fmodificarusuario"'.$unregistro["idusuario"].' action="../controlador/controladorusuario.php" method="post">';
                
                echo '<td><input type="hidden" name="fidusuario" value=" '.$unregistro['idusuario'].'">';
                echo '    <input type="text" name="fnombreusuario" value="'.$unregistro['nombreusuario'].'"></td>';
                echo '<td><input type="text" name="femailusuario" value="'.$unregistro['emailusuario'].'"></td>';
                echo '<td><input type="password" name="fclaveusuario" value="'.$unregistro['claveusuario'].'"></td>';
                echo '<td><input type="date" name="ffecharegistrousuario" value="'.$unregistro['fecharegistrousuario'].'"></td>';
                echo '<td><input type="date" name="ffechaultimaclave" value="'.$unregistro['fechaultimaclave'].'"></td>';
                echo '<td><select name="fidrol">';
                    while($registrorol = mysqli_fetch_array($listarol)){
                    echo '<option value="'.$registrorol['idrol'].'"';
                    if($unregistro['idrol'] == $registrorol['idrol']){  
                       echo " selected ";
                   }
                   echo '>'.$registrorol['nombrerol'].'</option>';
                }
                mysqli_data_seek($listarol,0);
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
            <tr><form id="fingresarusuario" class="form-control" action="../controlador/controladorusuario.php" method="post">
                
            <td><input type="hidden" name="fidusuario" value="0">
                <input type="text" name="fnombreusuario"></td>
            <td><input type="text" name="femailusuario"></td>
            <td><input type="password" name="fclaveusuario"></td>
            <td><input type="date" name="ffecharegistrousuario"></td>
            <td><input type="date" name="ffechaultimaclave"></td>
                <td><select name="fidrol">
                     <?php
                      while($registrorol = mysqli_fetch_array($listarol)){
                           echo '<option value="'.$registrorol['idrol'].'">'.$registrorol['nombrerol'].'</option>';
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
            $cantPaginas=$objetousuario->cantidadPaginas();
            if($cantPaginas>1){
                if($pagina>1){
                    echo '<li class="page-item"><a class="page-link" href="formulariousuario.php?pag='.($pagina-1).'" aria-label="Anterior"><span aria-hidden="true">&laquo;</span></a></li>';
                }
                for($i=1;$i<=$cantPaginas;$i++){
                    if($i==$pagina){
                        echo '<li class="page-item active"><a class="page-link" href="#">'.$i.'</a></li>';
                    }else{
                        echo '<li class="page-item" class="page-item"><a class="page-link" href="formulariousuario.php?pag='.$i.'">'.$i.'</a></li>';
                    }
                }
                if ($pagina<$cantPaginas){
                    echo '<li class="page-item"><a class="page-link" href="formulariousuario.php?pag='.($pagina+1).'" aria-label="Siguiente"><span aria-hidden="true">&raquo;</span></a></li>';
                }
            }
            ?>
            </ul>
        </nav>
    </div>
        <?php
            mysqli_free_result($listausuario);
            mysqli_free_result($listarol);
            $objetoconexion->desconectar($conexion);
        ?>
        <script src="js/jquery-3.1.1.slim.min.js" ></script>
<script src="js/tether.min.js" ></script>
<script src="js/bootstrap.min.js" ></script>
    </body>
</html> 
    <?php
}else{
    header("location:../index.html");
}
?>