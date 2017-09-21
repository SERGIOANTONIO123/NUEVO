<?php
    include_once("../modelo/conexion.php");
    $objetoconexion = new conexion();
    $conexion = $objetoconexion->conectar();
    
    include_once("../modelo/floracion.php");
    
    $opcion = $_POST["fenviar"];
    $idfloracion = $_POST["fidfloracion"];
    $cantidadflores = $_POST["fcantidadflores"];
    $fechainiciofloracion = $_POST["ffechainiciofloracion"];
    $fechafinfloracion = $_POST["ffechafinfloracion"];
    $idarbol = $_POST["fidarbol"];
    
    $cantidadflores    = htmlspecialchars($cantidadflores);
    $fechainiciofloracion  = htmlspecialchars($fechainiciofloracion);
    $fechafinfloracion = htmlspecialchars($fechafinfloracion);
    $idarbol = htmlspecialchars($idarbol);

    $objetofloracion = new floracion($conexion,$idfloracion,$cantidadflores,$fechainiciofloracion, $fechafinfloracion,$idarbol);
    
    switch($opcion){
        case 'ingresar':
            $objetofloracion->insertar();
            $mensaje = "ingresado";
            break;
        case 'modificar':
            $objetofloracion->modificar();
            $mensaje = "modificado";
            break;
        case 'eliminar':
            $objetofloracion->eliminar();
            $mensaje = "eliminado";
            break;
    }
    $objetoconexion->desconectar($conexion);
    header("location:../vista/formulariofloracion.php?msj=$mensaje");
    ?>