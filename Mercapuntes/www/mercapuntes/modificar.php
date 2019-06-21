<!--
    MODIFICAR.PHP
    Página para la modificación de anuncios. 
-->


<?php
    /*
        Comprobaciones antes de cargar la página.
        Si *NO* hay una sesión iniciada, no podemos permitir que se pueda entrar aquí.
        En tal caso, echamos al usuario a login.php.
     */
    require "./../../seguridad/mercapuntes/funciones.php";
    iniciarSesion();
    $usuario = "";
    if (!validarSesion($usuario)) {
        header("Location: ./iniciarSesion.php");
        exit;
    }

    // Recibir el ID del anuncio, si no hay ID no tiene sentido acceder a esta página
    $id_anuncio = "";
    if (isset($_GET["id"])) {
       $id_anuncio = strip_tags(trim($_GET["id"]));
    }
    else {
        header("Location: ./perfil.php");
        exit;
    }

    // Superglobal de sesión como medida de transporte
    $_SESSION["aux"] = $id_anuncio;

    /*
        Si el anuncio no pertenece al usuario o el anuncio no existe, no podemos permitir que se pueda entrar aquí.
        En tal caso, echamos al usuario a perfil.php.
     */
    require "./../../seguridad/mercapuntes/datosBD.php";
    $canal = @mysqli_connect(IP, USUARIO, CLAVE, BD);
    if (!$canal) {
        exit("ERROR DE SERVIDOR: ".mysqli_connect_errno()." ".mysqli_connect_error());
    }
    mysqli_set_charset($canal, "utf8");
    // 1. Comprobar que existe el ID del anuncio
    $sql = "SELECT COUNT(*) FROM anuncios WHERE id_anuncio = ?";
    $consulta = mysqli_prepare($canal, $sql);
    if (!$consulta) {
        exit("ERROR DE SERVIDOR: ".mysqli_connect_errno()." ".mysqli_connect_error());  
    }
    mysqli_stmt_bind_param($consulta, "s", $id_anuncio);
    mysqli_stmt_execute($consulta);
    mysqli_stmt_bind_result($consulta, $resultado);
    mysqli_stmt_fetch($consulta);
    if ($resultado == 0) {
        header("Location: ./perfil.php");
        exit;
    }
    mysqli_stmt_close($consulta);
    unset($consulta);
    // 2. Obtener el ID del usuario
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
    // 2. Comprobar que el anuncio pertenece al usuario 
    $sql = "SELECT COUNT(*) FROM anuncios WHERE id_anuncio = ? AND id_usuario = ?";
    $consulta = mysqli_prepare($canal, $sql);
    if (!$consulta) {
        exit("ERROR DE SERVIDOR: ".mysqli_connect_errno()." ".mysqli_connect_error());  
    }
    mysqli_stmt_bind_param($consulta, "ii", $id_anuncio, $id_usuario);
    mysqli_stmt_execute($consulta);
    mysqli_stmt_bind_result($consulta, $resultado);
    mysqli_stmt_fetch($consulta);
    if ($resultado == 0) {
        header("Location: ./perfil.php");
        exit;
    }
    mysqli_stmt_close($consulta);
    unset($consulta);

    // Recepción de mensajes.
    $mensaje = "";
    $mensaje2 = "";
    if (isset($_GET["mensaje"])) {
       $mensaje = strip_tags(trim($_GET["mensaje"]));
    }
    if (isset($_GET["mensaje2"])) {
       $mensaje2 = strip_tags(trim($_GET["mensaje2"]));
    }

    // Para meter los datos del anuncio a modificar en el formulario
    $titulo = "";
    $descripcion = "";
    $curso = "";
    $tematica = "";
    $precio = "";
    $imagen = "";
    $zona = "";
    $telefono = "";
    $sql = "SELECT titulo, descripcion, curso, tematica, precio, imagen, zona, telefono FROM anuncios WHERE id_anuncio = ?";
    $consulta = mysqli_prepare($canal, $sql);
    if (!$consulta) {
        exit("ERROR DE SERVIDOR: ".mysqli_connect_errno()." ".mysqli_connect_error());  
    }
    mysqli_stmt_bind_param($consulta, "i", $id_anuncio);
    mysqli_stmt_execute($consulta);
    mysqli_stmt_bind_result($consulta, $titulo, $descripcion, $curso, $tematica, $precio, $imagen, $zona, $telefono);
    mysqli_stmt_fetch($consulta);
    mysqli_stmt_close($consulta);
    unset($consulta);
    mysqli_close($canal);

    // Por si hay que volver a cargar el formulario, se anteponen estos a los de la BD
    if (isset($_GET["titulo"])) {
       $titulo = strip_tags(trim($_GET["titulo"]));
    }
    if (isset($_GET["descripcion"])) {
       $descripcion = strip_tags(trim($_GET["descripcion"]));
    }
    if (isset($_GET["curso"])) {
       $curso = strip_tags(trim($_GET["curso"]));
    }
    if (isset($_GET["tematica"])) {
       $tematica = strip_tags(trim($_GET["tematica"]));
    }
    if (isset($_GET["precio"])) {
       $precio = strip_tags(trim($_GET["precio"]));
    }
    if (isset($_GET["zona"])) {
       $zona = strip_tags(trim($_GET["zona"]));
    }
    if (isset($_GET["telefono"])) {
       $telefono = strip_tags(trim($_GET["telefono"]));
    }
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Mercapuntes - Modificar anuncio</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./css/all.css" />
    <link rel="icon" type="image/png" href="./img/favicon.png">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./js/funciones.js"></script>
</head>

<body>
    <!-- Barra de navegación -->
    <header class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
            <div class="container">
                <a class="navbar-brand" href="./index.php">
                    <img src="./img/logo2.png" alt="Mercapuntes" height="65px" />
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="./index.php"><i class="fas fa-home"></i>&nbsp;Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="./perfil.php"><i class="fas fa-user"></i>&nbsp;Perfil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./subir.php"><i class="fas fa-check"></i>&nbsp;Subir anuncio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./src/sesionCerrar.php"><i class="fas fa-sign-out-alt"></i>&nbsp;Cerrar sesión</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- Parte principal -->
    <main class="container">
        <div class="card card-signin">
            <div class="card-header">
                <h5 class="card-title text-center">Modificar anuncio</h5>
            </div>
            <div class="card-body">
                <h5><i class="fas fa-book"></i>&nbsp;Datos del artículo</h5>
                <p class="card-text text-center" id="mensaje"><?=$mensaje?></p>
                <form id="formulario" method="post" enctype="multipart/form-data" action="./src/anuncioModificar.php">
                    <div class="form-row">
                        <div class="form-label-group col-md-6">
                            <label for="titulo">Título (*)</label>
                            <input type="text" name="titulo" id="titulo" class="form-control" minlenght="4" maxlength="45" size="20" required="required" autofocus="autofocus" placeholder="Título" value="<?=$titulo?>" />
                        </div>
                        <div class="form-label-group col-md-6">
                            <label for="imagen">Sube una foto <small>(opcional)</small></label>
                            <input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
                            <input type="file" name="imagen" id="imagen" class="form-control" />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label-group col-md-12">
                            <label for="descripcion">Descripción (*)</label>
                            <textarea name="descripcion" id="descripcion" class="form-control" minlength="20" maxlength="250" form="formulario" required="required" placeholder="Escribe aquí cualquier información importante sobre tus apuntes"><?=$descripcion?></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label-group col-md-5">
                            <label for="curso">Curso (*)</label>
                            <select class="form-control" name="curso" id="curso" form="formulario" required="required">
                                <?php
                                    mostrarSelect("cursos", "id_curso", $curso, false);
                                ?>
                            </select>
                        </div>
                        <div class="form-label-group col-md-5">
                            <label for="tematica">Temática (*)</label>
                            <select class="form-control" name="tematica" id="tematica" form="formulario" required="required">
                                <?php
                                    mostrarSelect("tematicas", "id_tematica", $tematica, false);
                                ?>
                            </select>
                        </div>
                        <div class="form-label-group col-md-2">
                            <label for="descripcion">Precio (€) (*)</label>
                            <input type="number" name="precio" id="precio" class="form-control currency" min="0" max="9999" step="0.01" required="required" placeholder="0,00" value="<?=$precio?>" />
                        </div>
                    </div>
                    <hr class="my-4">
                    <h5><i class="fas fa-globe-europe"></i>&nbsp;Datos del anunciante</h5>
                    <p class="card-text text-center" id="mensaje2"><?=$mensaje2?></p>
                    <div class="form-row">
                        <div class="form-label-group col-md-6">
                            <label for="zona">Zona (*)</label>
                            <select class="form-control" name="zona" id="zona" form="formulario" required="required">
                                <?php
                                    mostrarSelect("zonas", "id_zona", $zona, false);
                                ?>
                            </select>
                        </div>
                        <div class="form-label-group col-md-6">
                            <label for="telefono">Teléfono <small>(opcional)</small></label>
                            <input type="text" name="telefono" id="telefono" class="form-control" minlength="9" maxlength="9" size="20" placeholder="Teléfono de contacto" value="<?=$telefono?>" />
                        </div>
                    </div>
                    <button class="btn btn-lg btn-warning btn-block text-uppercase" type="submit">Modificar anuncio</button>
                </form>
                <button class="btn btn-lg btn-danger btn-block text-uppercase" data-toggle="modal" href="#eliminarAnuncio" type="button" style="margin-top: 10px;">Eliminar anuncio</button>
            </div>
        </div>
        <div class="modal fade" id="eliminarAnuncio" tabindex="-1" role="dialog" aria-labelledby="eliminarAnuncio" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header col-12 text-center">
                        <h5 class="modal-title">Eliminar anuncio</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-window-close"></i>
                        </button>
                    </div>
                    <div class="modal-body mx-3">
                        <span>Vas a eliminar este anuncio, ¿estás seguro?</span>
                        <div class="md-form mb-4">
                            <form method="post" action="./src/anuncioEliminar.php" style="margin-top: 20px;">
                                <button class="btn btn-lg btn-danger btn-block text-uppercase" type="submit">Si, eliminar anuncio</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Aviso legal -->
        <div id="avisoLegal" class="modal">
            <div id="avisoLegal-content" class="modal-content">
                <div id="avisoLegal-header" class="modal-header">
                    <h2 class="text-uppercase" style="padding: 10px">Aviso legal</h2>
                    <span id="cerrarAvisoLegal" class="close"><i class="fas fa-window-close"></i></span>
                </div>
                <div id="avisoLegal-body" class="modal-body" style="margin-top: 10px">
                    <h5>POLÍTICA DE PRIVACIDAD</h5>
                    <p class="small">En cumplimiento de lo dispuesto en la Ley Orgánica 15/1999, de 13 de Diciembre, de Protección de Datos de Carácter Personal (LOPD) se informa al usuario que todos los datos que nos proporcione serán incorporados a un fichero, creado y mantenido bajo la responsabilidad de Mercapuntes.</p>
                    <p class="small">Siempre se va a respetar la confidencialidad de sus datos personales que sólo serán utilizados con la finalidad de gestionar los servicios ofrecidos, atender a las solicitudes que nos plantee, realizar tareas administrativas, así como remitir información técnica, comercial o publicitaria por vía ordinaria o electrónica.</p><br />
                    <h5>POLÍTICA DE COOKIES</h5>
                    <p class="small">Mercapuntes por su propia cuenta o la de un tercero contratado para prestación de servicios de medición, pueden utilizar cookies cuando el usuario navega por el sitio web. Las cookies son ficheros enviados al navegador por medio de un servicio web con la finalidad de registrar las actividades del usuario durante su tiempo de navegación.</p>
                    <p class="small">Las cookies utilizadas se asocian únicamente con un usuario anónimo y su ordenador, y no proporcionan por sí mismas los datos personales del usuario.</p>
                </div>
            </div>
        </div>
    </main>
    <!-- Footer -->
    <footer class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="text-center font-weight-bold">
                        <span id="abrirAvisoLegal" style="color:white">AVISO LEGAL</span>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="small text-center">Copyright &copy; 2019 - Mercapuntes</div>
                </div>
                <div class="col-sm-4">
                    <div class="text-center">
                        <a href="https://twitter.com/mercapuntes/" target="_blank"><i class="fab fa-twitter-square"></i></a>
                        <a href="https://www.facebook.com/Mercapuntes-2108176312628206/" target="_blank"><i class="fab fa-facebook-square"></i></a>
                        <a href="https://www.instagram.com/mercapuntes/" target="_blank"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
