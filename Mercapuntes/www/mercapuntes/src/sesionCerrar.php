<!-- 
    SESIONCERRAR.PHP
    Cerrar la sesión actual y volver al login.
-->


<?php
    /*
        Comprobaciones antes de cargar la página.
        Si *NO* hay una sesión iniciada, no podemos permitir que se pueda entrar aquí.
        En tal caso, echamos al usuario a iniciarSesion.php.
     */
    require "./../../../seguridad/mercapuntes/funciones.php";
    iniciarSesion();
    $usuario = "";
    if (!validarSesion($usuario)) {
        header("Location: ./../iniciarSesion.php");
        exit;
    }

    session_destroy();
    unset($_SESSION);
    header("Location: ./../iniciarSesion.php?mensaje=".urlencode("Se ha cerrado la sesión."));
    exit;
?>
