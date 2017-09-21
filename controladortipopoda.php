<?php
    include_once("../modelo/conexion.php");
    $objetoconexion = new conexion();
    $conexion = $objetoconexion->conectar();
    
    include_once("../modelo/tipopoda.php");
    
    $opcion = $_POST["fenviar"];
    $idtipopoda = $_POST["fidtipopoda"];
    $descripciontipopoda = $_POST["fdescripciontipopoda"];
    
    $descripciontipopoda    = htmlspecialchars($descripciontipopoda);

    $objetotipopoda = new tipopoda($conexion,$idtipopoda,$descripciontipopoda);
    
    switch($opcion){
        case 'ingresar':
            $objetotipopoda->insertar();
            $mensaje = "ingresado";
            break;
        case 'modificar':
            $objetotipopoda->modificar();
            $mensaje = "modificado";
            break;
        case 'eliminar':
            $objetotipopoda->eliminar();
            $mensaje = "eliminado";
            break;
    }
    $objetoconexion->desconectar($conexion);
    header("location:../vista/formulariotipopoda.php?msj=$mensaje");
    ?>