<?php
$emailUsuario = $_POST["fEmail"];
$claveUsuario = $_POST["fClave"];

include_once("../modelo/Conexion.php");
$objetoConexion = new Conexion();
$conexion = $objetoConexion->conectar();

$emailUsuario = mysqli_real_escape_string($conexion, $emailUsuario);

include_once("../Modelo/Login.php");
$objetoLogin = new Login($conexion, $emailUsuario, $claveUsuario);
$usuarioEsValido = $objetoLogin->verificarUsuario();

$objetoConexion->desconectar($conexion);
if($usuarioEsValido==true){
    session_start();
    $_SESSION['id']    =$objetoLogin->getIdUsuario();
    $_SESSION['nombre']=$objetoLogin->getNombreUsuario();
    $_SESSION['rol'] =$objetoLogin->getRolUsuario();
    header("location:../Vista/formularioarbol.php");
}else{
    header("location:../index.html?mensaje=incorrecto");
}
?>