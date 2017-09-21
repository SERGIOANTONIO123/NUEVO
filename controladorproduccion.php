<?php
    include_once("../modelo/conexion.php");
    $objetoconexion = new conexion();
    $conexion = $objetoconexion->conectar();
    
    include_once("../modelo/produccion.php");
    
    $opcion = $_POST["fenviar"];
    $idproduccion = $_POST["fidproduccion"];
    $fechainicioproduccion = $_POST["ffechainicioproduccion"];
    $kilosproducidos =$_POST["fkilosproducidos"];
    $kilosperdida =$_POST["fkilosperdida"];
    $idarbol = $_POST["fidarbol"];
    
    $fechainicioproduccion   = htmlspecialchars($fechainicioproduccion);
    $kilosproducidos = htmlspecialchars($kilosproducidos);
    $kilosperdida = htmlspecialchars($kilosperdida);
    $idarbol = htmlspecialchars($idarbol);

    $objetoproduccion = new produccion($conexion,$idproduccion,$fechainicioproduccion,$kilosproducidos, $kilosperdida,$idarbol);
    
    switch($opcion){
        case 'ingresar':
            $objetoproduccion->insertar();
            $mensaje = "ingresado";
            break;
        case 'modificar':
            $objetoproduccion->modificar();
            $mensaje = "modificado";
            break;
        case 'eliminar':
            $objetoproduccion->eliminar();
            $mensaje = "eliminado";
            break;
    }
    $objetoconexion->desconectar($conexion);
    header("location:../vista/formularioproduccion.php?msj=$mensaje");
    ?>