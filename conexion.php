<?php
    class conexion{
        function conectar(){
            $conexion = mysqli_connect("localhost","root","","proyecto");
            mysqli_query($conexion,"SET NAMES 'utf8'");
            return $conexion;
        }
        function desconectar($conexion){
            mysqli_close($conexion);
        }
    }
?>