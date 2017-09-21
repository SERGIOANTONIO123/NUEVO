<?php
    include_once("../modelo/conexion.php");
    $objetoconexion = new conexion();
    $conexion = $objetoconexion->conectar();
    
    include_once("../modelo/administrador.php");
    
    $opcion = $_POST["fenviar"];
    $idadministrador = $_POST["fidadministrador"];
    $nombreadministrador = $_POST["fnombreadministrador"];
    $telefonoadministrador =$_POST["ftelefonoadministrador"];
    
    $nombreadministrador    = htmlspecialchars($nombreadministrador);
    $telefonoadministrador = htmlspecialchars($telefonoadministrador);

    $objetoadministrador = new administrador($conexion,$idadministrador,$nombreadministrador,$telefonoadministrador);
    
    switch($opcion){
        case 'ingresar':
            $objetoadministrador->insertar();
            $mensaje = "ingresado";
            break;
        case 'modificar':
            $objetoadministrador->modificar();
            $mensaje = "modificado";
            break;
        case 'eliminar':
            $objetoadministrador->eliminar();
            $mensaje = "eliminado";
            break;
    }
    $objetoconexion->desconectar($conexion);
    header("location:../vista/formularioadministrador.php?msj=$mensaje");
    ?>