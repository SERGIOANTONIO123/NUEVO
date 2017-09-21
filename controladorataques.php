<?php
    include_once("../modelo/conexion.php");
    $objetoconexion = new conexion();
    $conexion = $objetoconexion->conectar();
    
    include_once("../modelo/ataques.php");
    
    $opcion = $_POST["fenviar"];
    $idataque = $_POST["fidataque"];
    $fechaataque = $_POST["ffechaataque"];
    $porcentajeataque =$_POST["fporcentajeataque"];
    $idarbol = $_POST["fidarbol"];
    $idenfermedad = $_POST["fidenfermedad"];
    
    $fechaataque   = htmlspecialchars($fechaataque);
    $porcentajeataque = htmlspecialchars($porcentajeataque);
    $idarbol = htmlspecialchars($idarbol);
    $idenfermedad = htmlspecialchars($idenfermedad);

    $objetoataques = new ataques($conexion,$idataque,$fechaataque,$porcentajeataque, $idarbol,$idenfermedad);
    
    switch($opcion){
        case 'ingresar':
            $objetoataques->insertar();
            $mensaje = "ingresado";
            break;
        case 'modificar':
            $objetoataques->modificar();
            $mensaje = "modificado";
            break;
        case 'eliminar':
            $objetoataques->eliminar();
            $mensaje = "eliminado";
            break;
    }
    $objetoconexion->desconectar($conexion);
    header("location:../vista/formularioataques.php?msj=$mensaje");
    ?>