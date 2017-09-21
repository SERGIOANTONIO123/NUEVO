<?php
    include_once("../modelo/conexion.php");
    $objetoconexion = new conexion();
    $conexion = $objetoconexion->conectar();
    
    include_once("../modelo/variedad.php");
    
    $opcion = $_POST["fenviar"];
    $idvariedad = $_POST["fidvariedad"];
    $descripcionvariedad = $_POST["fdescripcionvariedad"];
    
    $descripcionvariedad    = htmlspecialchars($descripcionvariedad);

    $objetovariedad = new variedad($conexion,$idvariedad,$descripcionvariedad);
    
    switch($opcion){
        case 'ingresar':
            $objetovariedad->insertar();
            $mensaje = "ingresado";
            break;
        case 'modificar':
            $objetovariedad->modificar();
            $mensaje = "modificado";
            break;
        case 'eliminar':
            $objetovariedad->eliminar();
            $mensaje = "eliminado";
            break;
    }
    $objetoconexion->desconectar($conexion);
    header("location:../vista/formulariovariedad.php?msj=$mensaje");
    ?>