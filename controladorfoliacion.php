<?php
    include_once("../modelo/conexion.php");
    $objetoconexion = new conexion();
    $conexion = $objetoconexion->conectar();
    
    include_once("../modelo/foliacion.php");
    
    $opcion = $_POST["fenviar"];
    $idfoliacion = $_POST["fidfoliacion"];
    $cantidadhojas = $_POST["fcantidadhojas"];
    $areahoja = $_POST["fareahoja"];
    $fechafoliacion = $_POST["ffechafoliacion"];
    $idarbol = $_POST["fidarbol"];
    
    $cantidadhojas    = htmlspecialchars($cantidadhojas);
    $areahoja  = htmlspecialchars($areahoja);
    $fechafoliacion = htmlspecialchars($fechafoliacion);
    $idarbol = htmlspecialchars($idarbol);

    $objetofoliacion = new foliacion($conexion,$idfoliacion,$cantidadhojas,$areahoja, $fechafoliacion,$idarbol);
    
    switch($opcion){
        case 'ingresar':
            $objetofoliacion->insertar();
            $mensaje = "ingresado";
            break;
        case 'modificar':
            $objetofoliacion->modificar();
            $mensaje = "modificado";
            break;
        case 'eliminar':
            $objetofoliacion->eliminar();
            $mensaje = "eliminado";
            break;
    }
    $objetoconexion->desconectar($conexion);
    header("location:../vista/formulariofoliacion.php?msj=$mensaje");
    ?>