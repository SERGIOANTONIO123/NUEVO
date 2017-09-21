<?php
    include_once("../modelo/conexion.php");
    $objetoconexion = new conexion();
    $conexion = $objetoconexion->conectar();
    
    include_once("../modelo/tipotratamiento.php");
    
    $opcion = $_POST["fenviar"];
    $idtipotratamiento = $_POST["fidtipotratamiento"];
    $descripciontipotratamiento = $_POST["fdescripciontipotratamiento"];
    
    $descripciontipotratamiento    = htmlspecialchars($descripciontipotratamiento);

    $objetotipotratamiento = new tipotratamiento($conexion,$idtipotratamiento,$descripciontipotratamiento);
    
    switch($opcion){
        case 'ingresar':
            $objetotipotratamiento->insertar();
            $mensaje = "ingresado";
            break;
        case 'modificar':
            $objetotipotratamiento->modificar();
            $mensaje = "modificado";
            break;
        case 'eliminar':
            $objetotipotratamiento->eliminar();
            $mensaje = "eliminado";
            break;
    }
    $objetoconexion->desconectar($conexion);
    header("location:../vista/formulariotipotratamiento.php?msj=$mensaje");
    ?>