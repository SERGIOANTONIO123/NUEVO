<?php
    include_once("../modelo/conexion.php");
    $objetoconexion = new conexion();
    $conexion = $objetoconexion->conectar();
    
    include_once("../modelo/vereda.php");
    
    $opcion = $_POST["fenviar"];
    $idvereda = $_POST["fidvereda"];
    $nombrevereda = $_POST["fnombrevereda"];
    
    $nombrevereda    = htmlspecialchars($nombrevereda);

    $objetovereda = new vereda($conexion,$idvereda,$nombrevereda);
    
    switch($opcion){
        case 'ingresar':
            $objetovereda->insertar();
            $mensaje = "ingresado";
            break;
        case 'modificar':
            $objetovereda->modificar();
            $mensaje = "modificado";
            break;
        case 'eliminar':
            $objetovereda->eliminar();
            $mensaje = "eliminado";
            break;
    }
    $objetoconexion->desconectar($conexion);
    header("location:../vista/formulariovereda.php?msj=$mensaje");
    ?>