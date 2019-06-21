<!-- 
    USUARIOELIMINAR-S.PHP
    Borra un usuario de la base de datos.
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

    if (empty($clave) || strlen($clave)>20) {
        header("Location: ./../perfil.php");
        exit;
    }


    // Comprobación de la contraseña en la base de datos
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
        header("Location: ./../perfil.php");
        exit;
    }

    mysqli_stmt_close($consulta);
    unset($consulta);


    // Necesitamos el ID del usuario
    $sql = "SELECT id_usuario FROM usuarios WHERE email = ?";
    $consulta = mysqli_prepare($canal, $sql);
    if (!$consulta) {
        exit("ERROR DE SERVIDOR: ".mysqli_connect_errno()." ".mysqli_connect_error());  
    }
    mysqli_stmt_bind_param($consulta, "s", $usuario);

    mysqli_stmt_execute($consulta);
    mysqli_stmt_bind_result($consulta, $id_usuario);
    mysqli_stmt_fetch($consulta);

    mysqli_stmt_close($consulta);
    unset($consulta);


    // Eliminar los anuncios de la base de datos y las imágenes asociadas
    $sql = "SELECT imagen FROM anuncios WHERE id_usuario = ?";
    $consulta = mysqli_prepare($canal, $sql);
    if (!$consulta) {
        exit("ERROR DE SERVIDOR: ".mysqli_connect_errno()." ".mysqli_connect_error());  
    }
    mysqli_stmt_bind_param($consulta, "s", $id_usuario);
    mysqli_stmt_execute($consulta);
    mysqli_stmt_bind_result($consulta, $imagenAntigua);
    while (mysqli_stmt_fetch($consulta)) {
        if (!empty($imagenAntigua)) {
            unlink("./..".__ALBUM__.$imagenAntigua);
        }
    }
    mysqli_stmt_close($consulta);
    unset($consulta);
    
    $sql = "DELETE FROM anuncios WHERE id_usuario = ?";
    $consulta = mysqli_prepare($canal, $sql);
    if (!$consulta) {
        exit("ERROR DE SERVIDOR: ".mysqli_connect_errno()." ".mysqli_connect_error());  
    }
    mysqli_stmt_bind_param($consulta, "s", $id_usuario);

    mysqli_stmt_execute($consulta); 
    mysqli_stmt_close($consulta);
    unset($consulta);


    // Eliminar el usuario de la base de datos
    $sql = "DELETE FROM usuarios WHERE email = ?";
    $consulta = mysqli_prepare($canal, $sql);
    if (!$consulta) {
        exit("ERROR DE SERVIDOR: ".mysqli_connect_errno()." ".mysqli_connect_error());  
    }
    mysqli_stmt_bind_param($consulta, "s", $usuario);

    mysqli_stmt_execute($consulta); 
    mysqli_stmt_close($consulta);
    unset($consulta);
    mysqli_close($canal);

    session_destroy();
    unset($_SESSION);
    header("Location: ./../iniciarSesion.php?mensaje=".urlencode("Perfil eliminado con éxito. Hasta la próxima."));
?>
