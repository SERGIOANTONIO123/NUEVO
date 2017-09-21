<?php
    include_once("../modelo/conexion.php");
    $objetoconexion = new conexion();
    $conexion = $objetoconexion->conectar();
    
    include_once("../modelo/podas.php");
    
    $opcion = $_POST["fenviar"];
    $idpoda = $_POST["fidpoda"];
    $fechapoda = $_POST["ffechapoda"];
    $idtipopoda =$_POST["fidtipopoda"];
    $idarbol = $_POST["fidarbol"];
    
    $fechapoda = htmlspecialchars($fechapoda);
    $idtipopoda = htmlspecialchars($idtipopoda);
    $idarbol = htmlspecialchars($idarbol);

    $objetopodas = new podas($conexion,$idpoda,$fechapoda,$idtipopoda,$idarbol);
    
    switch($opcion){
        case 'ingresar':
            $objetopodas->insertar();
            $mensaje = "ingresado";
            break;
        case 'modificar':
            $objetopodas->modificar();
            $mensaje = "modificado";
            break;
        case 'eliminar':
            $objetopodas->eliminar();
            $mensaje = "eliminado";
            break;
    }
    $objetoconexion->desconectar($conexion);
    header("location:../vista/formulariopodas.php?msj=$mensaje");
    ?>