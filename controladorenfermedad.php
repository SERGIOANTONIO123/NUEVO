<?php
    include_once("../modelo/conexion.php");
    $objetoconexion = new conexion();
    $conexion = $objetoconexion->conectar();
    
    include_once("../modelo/enfermedad.php");
    
    $opcion = $_POST["fenviar"];
    $idenfermedad = $_POST["fidenfermedad"];
    $descripcionenfermedad = $_POST["fdescripcionenfermedad"];
    
    $descripcionenfermedad    = htmlspecialchars($descripcionenfermedad);

    $objetoenfermedad = new enfermedad($conexion,$idenfermedad,$descripcionenfermedad);
    
    switch($opcion){
        case 'ingresar':
            $objetoenfermedad->insertar();
            $mensaje = "ingresado";
            break;
        case 'modificar':
            $objetoenfermedad->modificar();
            $mensaje = "modificado";
            break;
        case 'eliminar':
            $objetoenfermedad->eliminar();
            $mensaje = "eliminado";
            break;
    }
    $objetoconexion->desconectar($conexion);
    header("location:../vista/formularioenfermedad.php?msj=$mensaje");
    ?>