<!--
    INICIARSESION.PHP
    Página de inicio de sesión. 
-->


<?php
    /*
        Comprobaciones antes de cargar la página.
        Si ya hay una sesión iniciada, no podemos permitir que se pueda volver a iniciar sesión.
        En tal caso, echamos al usuario a index.php.
    */
    require "./../../seguridad/mercapuntes/funciones.php";
    iniciarSesion();
    $usuario = "";
    if (validarSesion($usuario)) {
        header("Location: ./index.php");
        exit;
    }

    // Recepción de mensajes.
    $mensaje = "";
    if (isset($_GET["mensaje"])) {
	   $mensaje = strip_tags(trim($_GET["mensaje"]));
    }

    // Para conservar el email en el formulario
    $email = "";
    if (isset($_GET["email"])) {
       $email = strip_tags(trim($_GET["email"]));
    }
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Mercapuntes - Iniciar sesión</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./css/all.css" />
    <link rel="stylesheet" type="text/css" href="./css/iniciarSesion.css" />
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
                            <a class="nav-link active" href="./iniciarSesion.php"><i class="fas fa-sign-in-alt"></i>&nbsp;Entrar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./registro.php"><i class="fas fa-user-plus"></i>&nbsp;Registrarse</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- Formulario de log in -->
    <main class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card card-signin my-5">
                    <div class="card-body">
                        <h5 class="card-title text-center">Iniciar sesión</h5>
                        <p class="card-text text-center" id="mensaje"><?=$mensaje?></p>
                        <form class="form-signin" method="post" action="./src/sesionValidar.php">
                            <div class="form-label-group">
                                <label for="usuario"><i class="fas fa-at"></i>&nbsp;Email</label>
                                <input type="email" name="usuario" id="usuario" class="form-control" maxlength="50" size="20" required="required" autofocus="autofocus" placeholder="Email" value="<?=$email?>" />
                            </div>
                            <div class="form-label-group">
                                <label for="clave"><i class="fas fa-key"></i>&nbsp;Contraseña</label>
                                <input type="password" name="clave" id="clave" class="form-control" maxlength="20" size="20" required="required" placeholder="Contraseña" />
                            </div>
                            <button class="btn btn-lg btn-warning btn-block text-uppercase" type="submit">Iniciar sesión</button>
                            <hr class="my-4">
                            <p class="card-text text-center">¿No tienes cuenta? <a href="./registro.php">¡Regístrate!</a></p>
                        </form>
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
