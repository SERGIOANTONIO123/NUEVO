<form action="../controlador/controladorLogin.php" method="post">
    <h2>Ingrese al sistema</h2>
    <input name="fEmail" type="email" maxlength="60" placeholder="nombre@sucorreo.co" required autofocus>
    <input name="fClave" type="password" placeholder="Pasword" required>
    <button name="fEnviar" type="submit" value="Ingresar">Ingresar</button>
</form>
<?php
    @$mensaje = $_GET['mensaje'];
    if (isset($mensaje)){
        if($mensaje=='incorrecto'){
            echo '<div class="alert alert-danger" role="alert">Usuario o clave incorrecto</div>';
        }
    }
?>