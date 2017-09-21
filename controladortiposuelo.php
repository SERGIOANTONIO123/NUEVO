<?php
    include_once("../modelo/conexion.php");
    $objetoconexion = new conexion();
    $conexion = $objetoconexion->conectar();
    
    include_once("../modelo/tiposuelo.php");
    
    $opcion = $_POST["fenviar"];
    $idtiposuelo = $_POST["fidtiposuelo"];
    $descripciontiposuelo = $_POST["fdescripciontiposuelo"];
    
    $descripciontiposuelo    = htmlspecialchars($descripciontiposuelo);

    $objetotiposuelo = new tiposuelo($conexion,$idtiposuelo,$descripciontiposuelo);
    
    switch($opcion){
        case 'ingresar':
            $objetotiposuelo->insertar();
            $mensaje = "ingresado";
            break;
        case 'modificar':
            $objetotiposuelo->modificar();
            $mensaje = "modificado";
            break;
        case 'eliminar':
            $objetotiposuelo->eliminar();
            $mensaje = "eliminado";
            break;
    }
    $objetoconexion->desconectar($conexion);
    header("location:../vista/formulariotiposuelo.php?msj=$mensaje");
    ?>