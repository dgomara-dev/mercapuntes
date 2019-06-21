<!-- 
    USUARIOACTUALIZAR-S.PHP
    Actualiza determinados datos del usuario.
-->

<?php
    require "./../../../seguridad/mercapuntes/datosBD.php";


    // Recepción y validación de los datos
    $usuario = $_SESSION["usuario"];

    $clave = "";
    if (!isset($_POST["clave"])) {
        exit("ERROR DE SERVIDOR: No se ha podido recibir la contraseña.");
    }
    $clave = strip_tags(trim($_POST["clave"]));

    $clave2 = "";
    if (!isset($_POST["clave2"])) {
        exit("ERROR DE SERVIDOR: No se ha podido recibir la nueva contraseña.");
    }
    $clave2 = strip_tags(trim($_POST["clave2"]));

    $clave3 = "";
    if (!isset($_POST["clave3"])) {
        exit("ERROR DE SERVIDOR: No se ha podido recibir la segunda nueva contraseña.");
    }
    $clave3 = strip_tags(trim($_POST["clave3"]));

    if (empty($clave2) || strlen($clave2)>20) {
        header("Location: ./../perfil.php?mensaje=".urlencode("Introduzca una nueva contraseña válida."));
        exit;
    }
    if (strlen($clave2) < 8) {
        header("Location: ./../perfil.php?mensaje=".urlencode("La nueva contraseña debe contener como mínimo 8 caracteres."));
        exit;
    }
    if (strcmp($clave2, $clave3) != 0) {
        header("Location: ./../perfil.php?mensaje=".urlencode("Las nuevas contraseñas no coinciden."));
        exit;
    }


    // Comprobación de la contraseña original en la base de datos
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
        header("Location: ./../perfil.php?mensaje=".urlencode("La contraseña original no es válida."));
        exit;
    }
    else if (password_verify($clave2, $clave_)) {
        header("Location: ./../perfil.php?mensaje=".urlencode("La contraseña nueva tiene que ser distinta a la actual."));
        exit;
    }

    mysqli_stmt_close($consulta);
    unset($consulta);


    // Actualizamos la contraseña
    $clave2 = password_hash($clave2, PASSWORD_DEFAULT);

    $sql = "UPDATE usuarios SET clave = ? WHERE email = ?";
    $consulta = mysqli_prepare($canal, $sql);
    if (!$consulta) {
        exit("ERROR DE SERVIDOR: ".mysqli_connect_errno()." ".mysqli_connect_error());  
    }
    mysqli_stmt_bind_param($consulta, "ss", $clave2, $usuario);

    mysqli_stmt_execute($consulta); 
    mysqli_stmt_close($consulta);
    unset($consulta);
    mysqli_close($canal);

    header("Location: ./../perfil.php?&mensaje=".urlencode("Contraseña actualizada con éxito."));
?>
