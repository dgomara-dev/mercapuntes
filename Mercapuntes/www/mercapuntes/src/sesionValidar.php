<!-- 
    SESIONVALIDAR.PHP
    Se manda a validar el usuario, fuera en la carpeta de seguridad.
-->


<?php
    /*
        Comprobaciones antes de cargar la página.
        Si ya hay una sesión iniciada, no podemos permitir que se pueda volver a iniciar sesión.
        En tal caso, echamos al usuario a index.php.
    */
    require "./../../../seguridad/mercapuntes/funciones.php";
    iniciarSesion();
    $usuario = "";
    if (validarSesion($usuario)) {
        header("Location: ./../index.php");
        exit;
    }

    require "./../../../seguridad/mercapuntes/sesionValidar-s.php";
?>
