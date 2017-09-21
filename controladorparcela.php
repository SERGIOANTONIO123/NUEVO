<?php
    include_once("../modelo/conexion.php");
    $objetoconexion = new conexion();
    $conexion = $objetoconexion->conectar();
    
    include_once("../modelo/parcela.php");
    
    $opcion = $_POST["fenviar"];
    $idparcela = $_POST["fidparcela"];
    $nombreparcela = $_POST["fnombreparcela"];
    $phparcela =$_POST["fphparcela"];
    $idadministrador = $_POST["fidadministrador"];
    $idtiposuelo = $_POST["fidtiposuelo"];
    $idvereda = $_POST["fidvereda"];
    
    $nombreparcela = htmlspecialchars($nombreparcela);
    $phparcela = htmlspecialchars($phparcela);
    $idadministrador = htmlspecialchars($idadministrador);
    $idtiposuelo = htmlspecialchars($idtiposuelo);
    $idvereda = htmlspecialchars($idvereda);

    $objetoparcela = new parcela($conexion,$idparcela,$nombreparcela,$phparcela, $idadministrador,$idtiposuelo,$idvereda);
    
    switch($opcion){
        case 'ingresar':
            $objetoparcela->insertar();
            $mensaje = "ingresado";
            break;
        case 'modificar':
            $objetoparcela->modificar();
            $mensaje = "modificado";
            break;
        case 'eliminar':
            $objetoparcela->eliminar();
            $mensaje = "eliminado";
            break;
    }
    $objetoconexion->desconectar($conexion);
    header("location:../vista/formularioparcela.php?msj=$mensaje");
    ?>