<!--
    PERFIL.PHP
    Página manejo de perfil del usuario. 
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

    // Recepción de mensajes.
    $mensaje = "";
    if (isset($_GET["mensaje"])) {
       $mensaje = strip_tags(trim($_GET["mensaje"]));
    }

    // Recibir el correo del usuario
    $usuario = $_SESSION["usuario"];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Mercapuntes - Perfil</title>
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
        <div class="container p-0">
            <div class="row">
                <div class="col-md-5 col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title text-center">Perfil</h5>
                        </div>
                        <div class="list-group list-group-flush" role="tablist">
                            <a class="list-group-item list-group-item-action active" data-toggle="list" href="#datos" role="tab">Datos personales</a>
                            <a class="list-group-item list-group-item-action" data-toggle="list" href="#anuncios" role="tab">Gestionar anuncios</a>
                            <a class="list-group-item list-group-item-action" data-toggle="modal" href="#eliminarCuenta" role="tab" style="color: red;">Eliminar cuenta</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 col-xl-8">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="datos" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title text-center">Datos personales</h5>
                                </div>
                                <div class="card-body">
                                    <h5>Email</h5>
                                    <input type="text" class="form-control" value="<?=$usuario?>" disabled="disabled" />
                                    <hr class="my-4">
                                    <h5>Cambiar contraseña</h5>
                                    <p class="card-text" id="mensaje"><?=$mensaje?></p>
                                    <form method="post" action="./src/usuarioActualizar.php">
                                        <div class="form-label-group">
                                            <label for="clave"><i class="fas fa-unlock-alt"></i>&nbsp;Contraseña actual</label>
                                            <input type="password" id="clave" class="form-control" placeholder="Contraseña actual" name="clave" maxlength="20" size="20" required="required" />
                                        </div>
                                        <div class="form-label-group">
                                            <label for="clave2"><i class="fas fa-key"></i>&nbsp;Contraseña nueva</label>
                                            <input type="password" id="clave2" class="form-control" placeholder="Contraseña nueva" name="clave2" minlength="8" maxlength="20" size="20" required="required" />
                                        </div>
                                        <div class="form-label-group">
                                            <label for="clave3"><i class="fas fa-key"></i>&nbsp;Repita la contraseña nueva</label>
                                            <input type="password" id="clave3" class="form-control" placeholder="Repita la contraseña nueva" name="clave3" minlength="8" maxlength="20" size="20" required="required" />
                                        </div>
                                        <button class="btn btn-lg btn-warning btn-block text-uppercase" type="submit">Guardar cambios</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="anuncios" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title text-center">Gestionar anuncios</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped">
                                        <tbody>
                                            <?php
                                                require "./../../seguridad/mercapuntes/datosBD.php";
                                                $canal = @mysqli_connect(IP, USUARIO, CLAVE, BD);
                                                if (!$canal) {
                                                    exit("ERROR DE SERVIDOR: ".mysqli_connect_errno()." ".mysqli_connect_error());
                                                }
                                                mysqli_set_charset($canal, "utf8");
                                                // 1. Obtener el ID de usuario
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
                                                // 2. Obtener la lista de IDs y de títulos de los anuncios del usuario
                                                $sql = "SELECT id_anuncio, titulo FROM anuncios WHERE id_usuario = ?";
                                                $consulta = mysqli_prepare($canal, $sql);
                                                if (!$consulta) {
                                                    exit("ERROR DE SERVIDOR: ".mysqli_connect_errno()." ".mysqli_connect_error());  
                                                }
                                                mysqli_stmt_bind_param($consulta, "s", $id_usuario);
                                                mysqli_stmt_execute($consulta);
                                                mysqli_stmt_bind_result($consulta, $id_anuncio, $titulo);
                                                $cont = 0;
                                                while (mysqli_stmt_fetch($consulta)) {
                                                    echo "<tr>
                                                            <td style='word-break:break-all'><a href='./anuncio.php?id=".$id_anuncio."' class='text-uppercase font-weight-bold'>".$titulo."</td>
                                                            <td><a href='./modificar.php?id=".$id_anuncio."' class='btn btn-lg btn-warning btn-block text-uppercase' role='button'><i class='fas fa-edit'></i>&nbsp;Modificar</a>
                                                        </tr>";
                                                    $cont++;
                                                }
                                                if ($cont == 0) {
                                                    echo "<tr><td class='text-center'>No hay anuncios para mostrar.</td></tr>";
                                                }
                                                mysqli_stmt_close($consulta);
                                                unset($consulta);
                                                mysqli_close($canal);
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="eliminarCuenta" tabindex="-1" role="dialog" aria-labelledby="eliminarCuenta" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header col-12 text-center">
                                        <h5 class="modal-title">Eliminar cuenta</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <i class="fas fa-window-close"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body mx-3">
                                        <span>¿Seguro que deseas borrar tu perfil? Todos los anuncios que tengas publicados se eliminarán y no podrás recuperarlos.</span>
                                        <div class="md-form mb-4">
                                            <form method="post" action="./src/usuarioEliminar.php" style="margin-top: 20px;">
                                                <label for="clave"><i class="fas fa-unlock-alt"></i>&nbsp;Contraseña actual</label>
                                                <input type="password" id="clave" class="form-control validate" placeholder="Contraseña actual" name="clave" maxlength="20" size="20" required="required" style="margin-bottom:20px; height:50px;" />
                                                <button class="btn btn-lg btn-danger btn-block text-uppercase" type="submit">Eliminar cuenta y salir</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
