<?php
    include_once("../modelo/conexion.php");
    $objetoconexion = new conexion();
    $conexion = $objetoconexion->conectar();
    
    include_once("../modelo/rol.php");
    
    $opcion =               $_POST["fenviar"];
    $idrol =                $_POST["fidrol"];
    $nombrerol =    $_POST["fnombrerol"];
    $arbolrol = $_POST["farbolrol"];
    $produccionrol = $_POST["fproduccionrol"];
    $podasrol = $_POST["fpodasrol"];
    $tipopodarol = $_POST["ftipopodarol"];
    $variedadrol = $_POST["fvariedadrol"];
    $foliacionrol = $_POST["ffoliacionrol"];
    $floracionrol = $_POST["ffloracionrol"];
    $ataquerol = $_POST["fataquerol"];
    $enfermedadrol = $_POST["fenfermedadrol"];
    $parcelarol = $_POST["fparcelarol"];
    $tiposuelorol = $_POST["ftiposuelorol"];
    $administradorrol = $_POST["fadministradorrol"];
    $tratamientorol = $_POST["ftratamientorol"];
    $tipotratamientorol = $_POST["ftipotratamientorol"];
    $ventasrol = $_POST["fventasrol"];
    $clienterol = $_POST["fclienterol"];
    $auditoriarol = $_POST["fauditoriarol"];
    $usuariorol = $_POST["fusuariorol"];
    $veredarol = $_POST["fveredarol"];
    $rolrol = $_POST["frolrol"];
    
    
    $nombrerol           = htmlspecialchars($nombrerol);
    $arbolrol            = htmlspecialchars($arbolrol);
    $produccionrol       = htmlspecialchars($produccionrol);
    $podasrol            = htmlspecialchars($podasrol);
    $tipopodarol         = htmlspecialchars($tipopodarol);
    $variedadrol         = htmlspecialchars($variedadrol);
    $foliacionrol        = htmlspecialchars($foliacionrol);
    $floracionrol        = htmlspecialchars($floracionrol);
    $ataquerol           = htmlspecialchars($ataquerol);
    $enfermedadrol       = htmlspecialchars($enfermedadrol);
    $parcelarol          = htmlspecialchars($parcelarol);
    $tiposuelorol        = htmlspecialchars($tiposuelorol);
    $administradorrol    = htmlspecialchars($administradorrol);
    $tratamientorol      = htmlspecialchars($tratamientorol);
    $tipotratamientorol  = htmlspecialchars($tipotratamientorol);
    $ventasrol           = htmlspecialchars($ventasrol);
    $clienterol          = htmlspecialchars($clienterol); 
    $auditoriarol        = htmlspecialchars($auditoriarol);
    $usuariorol          = htmlspecialchars($usuariorol);
    $veredarol           = htmlspecialchars($veredarol);
    $rolrol              = htmlspecialchars($rolrol);
    
    $objetorol = new rol($conexion,$idrol,$nombrerol,$arbolrol,$produccionrol,$podasrol, $tipopodarol,$variedadrol,$foliacionrol,$floracionrol, $ataquerol, $enfermedadrol, $parcelarol,$tiposuelorol,$administradorrol,$tratamientorol, $tipotratamientorol,$ventasrol,$clienterol,$auditoriarol,$usuariorol, $veredarol,$rolrol);
    
    switch($opcion){
        case 'ingresar':
            $objetorol->insertar();
            $mensaje = "ingresado";
            break;
        case 'modificar':
            $objetorol->modificar();
            $mensaje = "modificado";
            break;
        case 'eliminar':
            $objetorol->eliminar();
            $mensaje = "eliminado";
            break;
    }
    $objetoconexion->desconectar($conexion);
    header("location:../vista/formulariorol.php?msj=$mensaje");
    ?>