<?php
     session_start();
     if (isset($_SESSION['id'])){
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>FORMULARIO ROL</title>
   <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    </head>
    <body>
        <?php
           $formulario = "rol";
           include_once("menu.php");
           $pagina = (isset($_GET['pag']))?$_GET['pag']:1;
        ?>
        <div class="container-fluid">
    <header>
        <br>
        <h1>FORMULARIO ROL</h1>
        <BR>
        </header>
    <table class="table table-striped  table-responsive">
        <tbody>
        <tr>
           
            <th scope="col">nombre rol</th>
            <th scope="col">arbol rol</th>
            <th scope="col">produccion rol</th>
            <th scope="col">podas rol</th>
            <th scope="col">tipo poda rol</th>
            <th scope="col">variedad rol</th>
            <th scope="col">foliacion rol</th>
            <th scope="col">floracion rol</th>
            <th scope="col">ataque rol</th>
            <th scope="col">enfermedad rol</th>
            <th scope="col">parcela rol</th>
            <th scope="col">tipo suelo rol</th>
            <th scope="col">administrador rol</th>
            <th scope="col">tratamiento rol</th>
            <th scope="col">tipo tratamiento rol</th>
            <th scope="col">ventas rol</th>
            <th scope="col">cliente rol</th>
            <th scope="col">auditoria rol</th>
            <th scope="col">usuario rol</th>
            <th scope="col">vereda rol</th>
            <th scope="col">rol rol</th>
            <th scope="col">  </th>
        </tr>
        <?php
            
            include_once("../modelo/conexion.php");
            $objetoconexion = new conexion();
            $conexion = $objetoconexion->conectar();
            
            include_once("../modelo/rol.php");
            $objetorol = new rol($conexion,0,'idrol','nombrerol','arbolrol','produccionrol','podasrol','tipopodarol', 'variedadrol', 'foliacionrol','floracionrol','ataquerol', 'enfermedadrol', 'parcelarol', 'tiposuelorol', 'administradorrol','tratamientorol','tipotratamientorol'  ,'ventasrol','clienterol','auditoriarol','usuariorol', 'veredarol','rolrol');
            $permiso = $objetorol->getpermiso($_SESSION['id']);
            $listarol = $objetorol->listar($pagina);
            
            
            if(stripos($permiso,"r")!==false){            //lista
            while($unregistro =mysqli_fetch_array($listarol)){
                echo'<tr><form class="form-control" id="fmodificarrol"'.$unregistro["idrol"].' action="../controlador/controladorrol.php" method="post">';
                echo '<td><input type="hidden" name="fidrol" value=" '.$unregistro['idrol'].'">';
                echo '    <input type="text" name="fnombrerol" value="'.$unregistro['nombrerol'].'"></td>';
                echo '<td><input type="text" name="farbolrol" value="'.$unregistro['arbolrol'].'"></td>';
                echo '<td><input type="text" name="fproduccionrol" value="'.$unregistro['produccionrol'].'"></td>';
                echo '<td><input type="text" name="fpodasrol"  value="'.$unregistro['podasrol'].'"></td>';
                echo '<td><input type="text" name="ftipopodarol"  value="'.$unregistro['tipopodarol'].'"></td>';
                echo '<td><input type="text" name="fvariedadrol"  value="'.$unregistro['variedadrol'].'"></td>';
                echo '<td><input type="text" name="ffoliacionrol"  value="'.$unregistro['foliacionrol'].'"></td>';
                echo '<td><input type="text" name="ffloracionrol"  value="'.$unregistro['floracionrol'].'"></td>';
                echo '<td><input type="text" name="fataquerol"  value="'.$unregistro['ataquerol'].'"></td>';
                echo '<td><input type="text" name="fenfermedadrol"  value="'.$unregistro['enfermedadrol'].'"></td>';
                echo '<td><input type="text" name="fparcelarol"  value="'.$unregistro['parcelarol'].'"></td>';
                echo '<td><input type="text" name="ftiposuelorol"  value="'.$unregistro['tiposuelorol'].'"></td>';
                echo '<td><input type="text" name="fadministradorrol"  value="'.$unregistro['administradorrol'].'"></td>';
                echo '<td><input type="text" name="ftratamientorol"  value="'.$unregistro['tratamientorol'].'"></td>';
                echo '<td><input type="text" name="ftipotratamientorol"  value="'.$unregistro['tipotratamientorol'].'"></td>';
                echo '<td><input type="text" name="fventasrol"  value="'.$unregistro['ventasrol'].'"></td>';
                echo '<td><input type="text" name="fclienterol"  value="'.$unregistro['clienterol'].'"></td>';
                echo '<td><input type="text" name="fauditoriarol"  value="'.$unregistro['auditoriarol'].'"></td>';
                echo '<td><input type="text" name="fusuariorol" value="'.$unregistro['usuariorol'].'"></td>';
                echo '<td><input type="text" name="fveredarol" value="'.$unregistro['veredarol'].'"></td>';
                echo '<td><input type="text" name="frolrol" value="'.$unregistro['rolrol'].'"></td>';
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
            <tr><form id="fingresarrol" class="form-control" action="../controlador/controladorrol.php" method="post">
                
            <td> <input type="hidden" name="fidrol" value="0">
                 <input type="text" name="fnombrerol"></td>
            <td> <input  type="text" name="farbolrol"></td>
            <td> <input  type="text" name="fproduccionrol"></td>
            <td> <input  type="text" name="fpodasrol"></td>
            <td> <input  type="text" name="ftipopodarol"></td>
            <td> <input  type="text" name="fvariedadrol"></td>
            <td> <input  type="text" name="ffoliacionrol"></td>
            <td> <input  type="text" name="ffloracionrol"></td>
            <td> <input  type="text" name="fataquerol"></td>
            <td> <input  type="text" name="fenfermedadrol"></td>
            <td> <input  type="text" name="fparcelarol"></td>
            <td> <input  type="text" name="ftiposuelorol"></td>
            <td> <input  type="text" name="fadministradorrol"></td>
            <td> <input  type="text" name="ftratamientorol"></td>
            <td> <input  type="text" name="ftipotratamientorol"></td>
            <td> <input  type="text" name="fventasrol"></td>
            <td> <input  type="text" name="fclienterol"></td>
            <td> <input  type="text" name="fauditoriarol"></td>
            <td> <input  type="text" name="fusuariorol"></td>
            <td> <input  type="text" name="fveredarol"></td>
            <td> <input  type="text" name="frolrol"></td>
            <td> <button type="submit" class="btn btn-primary btn-sm" name="fenviar" value="ingresar"><i class="fa fa-check fa-2x"></i></button>
                  <button type="reset" name="fenviar" value="limpiar" class="btn btn-warning btn-sm"><i class="fa fa-eraser fa-2x"></i></button>
                </td>
              </form> </tr>
            <?php
           }// fin crear
            ?>
        </tbody>
        </table>
       <nav>
        <ul class="pagination">
            <?php
            $cantPaginas=$objetorol->cantidadPaginas();
            if($cantPaginas>1){
                if($pagina>1){
                    echo '<li class="page-item"><a class="page-link" href="formulariorol.php?pag='.($pagina-1).'" aria-label="Anterior"><span aria-hidden="true">&laquo;</span></a></li>';
                }
                for($i=1;$i<=$cantPaginas;$i++){
                    if($i==$pagina){
                        echo '<li class="page-item active"><a class="page-link" href="#">'.$i.'</a></li>';
                    }else{
                        echo '<li class="page-item" class="page-item"><a class="page-link" href="formulariorol.php?pag='.$i.'">'.$i.'</a></li>';
                    }
                }
                if ($pagina<$cantPaginas){
                    echo '<li class="page-item"><a class="page-link" href="formulariorol.php?pag='.($pagina+1).'" aria-label="Siguiente"><span aria-hidden="true">&raquo;</span></a></li>';
                }
            }
            ?>
            </ul>
        </nav>
            
        </div>
        <?php
            mysqli_free_result($listarol);
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