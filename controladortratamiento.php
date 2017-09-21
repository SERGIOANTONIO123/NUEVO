<?php
    include_once("../modelo/conexion.php");
    $objetoconexion = new conexion();
    $conexion = $objetoconexion->conectar();
    
    include_once("../modelo/tratamiento.php");
    
    $opcion = $_POST["fenviar"];
    $idtratamiento = $_POST["fidtratamiento"];
    $fechaaplicacion = $_POST["ffechaaplicacion"];
    $cantidadtratamiento =$_POST["fcantidadtratamiento"];
    $idataque = $_POST["fidataque"];
    $idtipotratamiento = $_POST["fidtipotratamiento"];
    
    $fechaaplicacion   = htmlspecialchars($fechaaplicacion);
    $cantidadtratamiento = htmlspecialchars($cantidadtratamiento);
    $idataque = htmlspecialchars($idataque);
    $idtipotratamiento = htmlspecialchars($idtipotratamiento);

    $objetotratamiento = new tratamiento($conexion,$idtratamiento,$fechaaplicacion,$cantidadtratamiento, $idataque,$idtipotratamiento);
    
    switch($opcion){
        case 'ingresar':
            $objetotratamiento->insertar();
            $mensaje = "ingresado";
            break;
        case 'modificar':
            $objetotratamiento->modificar();
            $mensaje = "modificado";
            break;
        case 'eliminar':
            $objetotratamiento->eliminar();
            $mensaje = "eliminado";
            break;
    }
    $objetoconexion->desconectar($conexion);
    header("location:../vista/formulariotratamiento.php?msj=$mensaje");
    ?>