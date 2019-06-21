<!-- 
    FUNCIONES.PHP
    Funciones habituales entre varias páginas
-->


<?php
    // Función inicia el manejo de sesiones
    function iniciarSesion() {
        session_name("mercapuntes");
        session_cache_limiter("nocache");
        session_start();
    }

    // Función que comprueba si hay una sesión activa
    function validarSesion(&$usuario) {
        $validado = false;
        if (isset($_SESSION["validado"]) && $_SESSION["validado"]) {
            $validado = true;
            $usuario = $_SESSION["usuario"];
        }
        return $validado;
    }

    // Función que prepara un input tipo select
    function mostrarSelect($tabla, $id, $valor, $vacio) {
        $canal = @mysqli_connect(IP, USUARIO, CLAVE, BD);
        if (!$canal) {
            exit("ERROR DE SERVIDOR: ".mysqli_connect_errno()." ".mysqli_connect_error());
        }
        mysqli_set_charset($canal, "utf8");
        $sql = "SELECT nombre FROM ".$tabla." ORDER BY ".$id;
        $consulta = mysqli_prepare($canal, $sql);
        if (!$consulta) {
            exit("ERROR DE SERVIDOR: ".mysqli_connect_errno()." ".mysqli_connect_error());  
        }
        mysqli_stmt_execute($consulta);
        mysqli_stmt_bind_result($consulta, $valor_);
        if ($vacio == true) {
            if (strcmp($tabla, "cursos") == 0) {
                echo "<option style='color:lightgray' value=''>Elige un curso</option>";
            }
            else if (strcmp($tabla, "tematicas") == 0) {
                echo "<option style='color:lightgray' value=''>Elige una temática</option>";
            }
            else if (strcmp($tabla, "zonas") == 0) {
                echo "<option style='color:lightgray' value=''>Elige una zona</option>";
            }
            else {
                echo "<option style='color:lightgray' value=''>-</option>";
            }             
        }
        while (mysqli_stmt_fetch($consulta)) {
            if (strcmp($valor, $valor_) == 0) {
                echo "<option value='".$valor_."' selected='selected'>".$valor_."</option>";
            }
            else {
                echo "<option value='".$valor_."'>".$valor_."</option>";
            }
        }
        mysqli_stmt_close($consulta);
        unset($consulta);
        mysqli_close($canal);
    }

    // Función que comprueba un input tipo select
    function comprobarSelect($tabla, $valor) {
        $canal = @mysqli_connect(IP, USUARIO, CLAVE, BD);
        if (!$canal) {
            exit("ERROR DE SERVIDOR: ".mysqli_connect_errno()." ".mysqli_connect_error());
        }
        mysqli_set_charset($canal, "utf8");
        $sql = "SELECT COUNT(*) FROM ".$tabla." WHERE nombre = ?";
        $consulta = mysqli_prepare($canal, $sql);
        if (!$consulta) {
            exit("ERROR DE SERVIDOR: ".mysqli_connect_errno()." ".mysqli_connect_error());  
        }
        mysqli_stmt_bind_param($consulta, "s", $valor);
        mysqli_stmt_execute($consulta);
        mysqli_stmt_bind_result($consulta, $resultado);
        mysqli_stmt_fetch($consulta);
        mysqli_stmt_close($consulta);
        unset($consulta);
        mysqli_close($canal);
        return $resultado;
    }
?>
