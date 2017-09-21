<?php
    include_once("../modelo/conexion.php");
    $objetoconexion = new conexion();
    $conexion = $objetoconexion->conectar();
    
    include_once("../modelo/arbol.php");
    
    $opcion = $_POST["fenviar"];
    $idarbol = $_POST["fidarbol"];
    $gpsarbol = $_POST["fgpsarbol"];
    $alturaarbol =$_POST["falturaarbol"];
    $fechasiembraarbol = $_POST["ffechasiembraarbol"];
    $idvariedad = $_POST["fidvariedad"];
    $idparcela = $_POST["fidparcela"];
    
    $gpsarbol    = htmlspecialchars($gpsarbol);
    $alturaarbol = htmlspecialchars($alturaarbol);
    $fechasiembraarbol = htmlspecialchars($fechasiembraarbol);
    $idvariedad = htmlspecialchars($idvariedad);
    $idparcela = htmlspecialchars($idparcela);

    $objetoarbol = new arbol($conexion,$idarbol,$gpsarbol,$alturaarbol,$fechasiembraarbol,$idvariedad, $idparcela);
    
    switch($opcion){
        case 'ingresar':
            $objetoarbol->insertar();
            $mensaje = "ingresado";
            break;
        case 'modificar':
            $objetoarbol->modificar();
            $mensaje = "modificado";
            break;
        case 'eliminar':
            $objetoarbol->eliminar();
            $mensaje = "eliminado";
            break;
    }
    $objetoconexion->desconectar($conexion);
    header("location:../vista/formularioarbol.php?msj=$mensaje");
    ?>