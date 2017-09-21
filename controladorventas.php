<?php
    include_once("../modelo/conexion.php");
    $objetoconexion = new conexion();
    $conexion = $objetoconexion->conectar();
    
    include_once("../modelo/ventas.php");
    
    $opcion = $_POST["fenviar"];
    $idventas = $_POST["fidventas"];
    $kilosvendidos = $_POST["fkilosvendidos"];
    $fechaventa = $_POST["ffechaventa"];
    $idcliente = $_POST["fidcliente"];
    
    $kilosvendidos    = htmlspecialchars($kilosvendidos);
    $fechaventa = htmlspecialchars($fechaventa);
    $idcliente = htmlspecialchars($idcliente);
 
    $objetoventas = new ventas($conexion,$idventas,$kilosvendidos,$fechaventa,$idcliente);
    
    switch($opcion){
        case 'ingresar':
            $objetoventas->insertar();
            $mensaje = "ingresado";
            break;
        case 'modificar':
            $objetoventas->modificar();
            $mensaje = "modificado";
            break;
        case 'eliminar':
            $objetoventas->eliminar();
            $mensaje = "eliminado";
            break;
    }
    $objetoconexion->desconectar($conexion);
    header("location:../vista/formularioventas.php?msj=$mensaje");
    ?>