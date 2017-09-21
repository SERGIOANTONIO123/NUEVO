<?php
    include_once("../modelo/conexion.php");
    $objetoconexion = new conexion();
    $conexion = $objetoconexion->conectar();
    
    include_once("../modelo/cliente.php");
    
    $opcion = $_POST["fenviar"];
    $idcliente = $_POST["fidcliente"];
    $nombrecliente = $_POST["fnombrecliente"];
    $telefonocliente = $_POST["ftelefonocliente"];
    $emailcliente = $_POST["femailcliente"];
    
    $nombrecliente    = htmlspecialchars($nombrecliente);
    $telefonocliente = htmlspecialchars($telefonocliente);
    $emailcliente = htmlspecialchars($emailcliente);

    $objetocliente = new cliente($conexion,$idcliente,$nombrecliente,$telefonocliente,$emailcliente);
    
    switch($opcion){
        case 'ingresar':
            $objetocliente->insertar();
            $mensaje = "ingresado";
            break;
        case 'modificar':
            $objetocliente->modificar();
            $mensaje = "modificado";
            break;
        case 'eliminar':
            $objetocliente->eliminar();
            $mensaje = "eliminado";
            break;
    }
    $objetoconexion->desconectar($conexion);
    header("location:../vista/formulariocliente.php?msj=$mensaje");
    ?>