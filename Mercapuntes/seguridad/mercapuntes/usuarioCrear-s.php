<!-- 
    USUARIOCREAR-S.PHP
    Crear un nuevo usuario.
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

    $clave2 = "";
    if (!isset($_POST["clave2"])) {
        exit("ERROR DE SERVIDOR: No se ha podido recibir la segunda contraseña.");
    }
    $clave2 = strip_tags(trim($_POST["clave2"]));

    if (empty($usuario) || strlen($usuario)>50) {
        header("Location: ./../registro.php?email=".urlencode($usuario)."&email=".urlencode($usuario)."&mensaje=".urlencode("Introduzca un email válido."));
        exit;
    }
    if (empty($clave) || strlen($clave)>20) {
        header("Location: ./../registro.php?email=".urlencode($usuario)."&mensaje=".urlencode("Introduzca una contraseña válida."));
        exit;
    }
    if (strlen($clave) < 8) {
        header("Location: ./../registro.php?email=".urlencode($usuario)."&mensaje=".urlencode("La contraseña debe contener como mínimo 8 caracteres."));
        exit;
    }
    if (strcmp($clave, $clave2) != 0) {
        header("Location: ./../registro.php?email=".urlencode($usuario)."&mensaje=".urlencode("Las contraseñas no coinciden."));
        exit;
    }


    // Comprobación de los datos en la base de datos
    $canal = @mysqli_connect(IP, USUARIO, CLAVE, BD);
    if (!$canal) {
        exit("ERROR DE SERVIDOR: ".mysqli_connect_errno()." ".mysqli_connect_error());
    }
    mysqli_set_charset($canal, "utf8");

    $sql = "SELECT COUNT(*) FROM usuarios WHERE email = ?";
    $consulta = mysqli_prepare($canal, $sql);
    if (!$consulta) {
        exit("ERROR DE SERVIDOR: ".mysqli_connect_errno()." ".mysqli_connect_error());	
    }
    mysqli_stmt_bind_param($consulta, "s", $usuario);

    mysqli_stmt_execute($consulta);
    mysqli_stmt_bind_result($consulta, $resultado);
    mysqli_stmt_fetch($consulta);

    if ($resultado > 0) {
        header("Location: ./../registro.php?email=".urlencode($usuario)."&mensaje=".urlencode("Ya existe un usuario con ese email."));
        exit;
    }

    mysqli_stmt_close($consulta);
    unset($consulta);

    
    // Damos los datos por buenos y creamos el usuario
    $clave = password_hash($clave, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (email, clave) VALUES (?, ?)";
    $consulta = mysqli_prepare($canal, $sql);
    if (!$consulta) {
        exit("ERROR DE SERVIDOR: ".mysqli_connect_errno()." ".mysqli_connect_error());  
    }
    mysqli_stmt_bind_param($consulta, "ss", $usuario, $clave);

    mysqli_stmt_execute($consulta);    
    mysqli_stmt_close($consulta);
    unset($consulta);
    mysqli_close($canal);

    header("Location: ./../iniciarSesion.php?email=".urlencode($usuario)."&mensaje=".urlencode("Usuario creado con éxito, ya puedes iniciar sesión."));
?>
