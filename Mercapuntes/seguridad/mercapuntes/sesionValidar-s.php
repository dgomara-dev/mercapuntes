<!-- 
    SESIONVALIDAR-S.PHP
    Validación de inicio de sesión.
-->

<?php
    require "./../../../seguridad/mercapuntes/datosBD.php";


    // Recepción y validación de los datos del usuario
    $usuario = "";
    if (!isset($_POST["usuario"])) {
        exit("ERROR DE SERVIDOR: No se ha podido recibir el email.");
    }
    $usuario = strip_tags(trim($_POST["usuario"]));

    $clave = "";
    if (!isset($_POST["clave"])) {
        exit("ERROR DE SERVIDOR: No se ha podido recibir la contraseña.");
    }
    $clave = strip_tags(trim($_POST["clave"]));

    if (empty($usuario) || strlen($usuario)>50 || empty($clave) || strlen($clave)>20) {
        header("Location: ./../iniciarSesion.php?email=".urlencode($usuario)."&mensaje=".urlencode("El usuario no existe o la contraseña es inválida."));
        exit;
    }


    // Comprobación de los datos en la base de datos
    $canal = @mysqli_connect(IP, USUARIO, CLAVE, BD);
    if (!$canal) {
        exit("ERROR DE SERVIDOR: ".mysqli_connect_errno()." ".mysqli_connect_error());
    }
    mysqli_set_charset($canal, "utf8");

    $sql = "SELECT clave FROM usuarios WHERE email = ?";
    $consulta = mysqli_prepare($canal, $sql);
    if (!$consulta) {
        exit("ERROR DE SERVIDOR: ".mysqli_connect_errno()." ".mysqli_connect_error());	
    }
    mysqli_stmt_bind_param($consulta, "s", $usuario);

    mysqli_stmt_execute($consulta);
    mysqli_stmt_bind_result($consulta, $clave_);
    mysqli_stmt_fetch($consulta);
    
    if (!password_verify($clave, $clave_)) {
        header("Location: ./../iniciarSesion.php?email=".urlencode($usuario)."&mensaje=".urlencode("El usuario no existe o la contraseña es inválida."));
        exit;
    }
    
    mysqli_stmt_close($consulta);
    unset($consulta);
    mysqli_close($canal);


    // Damos los datos por buenos e iniciamos sesión
    iniciarSesion();
    $_SESSION["validado"] = true;
    $_SESSION["usuario"] = $usuario;

    header("Location: ./../index.php");
?>
