<?php
session_start();
require_once('../model/admin-sesionModel.php');
require_once('../model/admin-usuarioModel.php');
require_once('../model/adminModel.php');

require '../../vendor/autoload.php';

$tipo = $_GET['tipo'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$objSesion = new SessionModel();
$objUsuario = new UsuarioModel();
$objAdmin = new AdminModel();

$id_sesion = $_POST['sesion'];
$token = $_POST['token'];

if ($tipo == "validar_datos_reset_password") {
  $id_email = $_POST['id'];
  $token_email = $_POST['token'];

  $arr_Respuesta = array('status' => false, 'mensaje' => 'Link caducado');
  $datos_usuario = $objUsuario->buscarUsuarioById($id_email);
  if ($datos_usuario->reset_password == 1 && password_verify($datos_usuario->token_password,$token_email)) {
      $arr_Respuesta = array('status' => true, 'mensaje' => 'Ok');
  }
  echo json_encode($arr_Respuesta);
}

if ($tipo == "listar_usuarios_ordenados_tabla") {
    $arr_Respuesta = array('status' => false, 'msg' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        $pagina = $_POST['pagina'];
        $cantidad_mostrar = $_POST['cantidad_mostrar'];
        $busqueda_tabla_dni = $_POST['busqueda_tabla_dni'];
        $busqueda_tabla_nomap = $_POST['busqueda_tabla_nomap'];
        $busqueda_tabla_estado = $_POST['busqueda_tabla_estado'];

        $arr_Respuesta = array('status' => false, 'contenido' => '');
        $busqueda_filtro = $objUsuario->buscarUsuariosOrderByApellidosNombres_tabla_filtro($busqueda_tabla_dni, $busqueda_tabla_nomap, $busqueda_tabla_estado);
        $arr_Usuario = $objUsuario->buscarUsuariosOrderByApellidosNombres_tabla($pagina, $cantidad_mostrar, $busqueda_tabla_dni, $busqueda_tabla_nomap, $busqueda_tabla_estado);

        $arr_contenido = [];
        if (!empty($arr_Usuario)) {
            for ($i = 0; $i < count($arr_Usuario); $i++) {
                $arr_contenido[$i] = (object)[
                    'id' => $arr_Usuario[$i]->id,
                    'dni' => $arr_Usuario[$i]->dni,
                    'nombres_apellidos' => $arr_Usuario[$i]->nombres_apellidos,
                    'correo' => $arr_Usuario[$i]->correo,
                    'telefono' => $arr_Usuario[$i]->telefono,
                    'estado' => $arr_Usuario[$i]->estado,
                    'options' => '<button type="button" title="Editar" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target=".modal_editar' . $arr_Usuario[$i]->id . '"><i class="fa fa-edit"></i></button>
                                  <button class="btn btn-info" title="Resetear Contraseña" onclick="reset_password(' . $arr_Usuario[$i]->id . ')"><i class="fa fa-key"></i></button>'
                ];
            }
            $arr_Respuesta['total'] = count($busqueda_filtro);
            $arr_Respuesta['status'] = true;
            $arr_Respuesta['contenido'] = $arr_contenido;
        }
    }
    echo json_encode($arr_Respuesta);
}

if ($tipo == "registrar") {
    $arr_Respuesta = array('status' => false, 'msg' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        if ($_POST) {
            $dni = $_POST['dni'];
            $apellidos_nombres = $_POST['apellidos_nombres'];
            $correo = $_POST['correo'];
            $telefono = $_POST['telefono'];

            if ($dni == "" || $apellidos_nombres == "" || $correo == "" || $telefono == "") {
                $arr_Respuesta = array('status' => false, 'mensaje' => 'Error, campos vacíos');
            } else {
                $arr_Usuario = $objUsuario->buscarUsuarioByDni($dni);
                if ($arr_Usuario) {
                    $arr_Respuesta = array('status' => false, 'mensaje' => 'Registro Fallido, Usuario ya se encuentra registrado');
                } else {

$password = $_POST['password'];

$pass_secure = password_hash($password, PASSWORD_DEFAULT);


//  REGISTRAR USUARIO
$id_usuario = $objUsuario->registrarUsuario($dni, $apellidos_nombres, $correo, $telefono, $pass_secure);

if ($id_usuario > 0) {
    $arr_Respuesta = array('status' => true, 'mensaje' => 'Registro Exitoso.');
} else {
    $arr_Respuesta = array('status' => false, 'mensaje' => 'Error al registrar usuario');
}


                }
            }
        }
    }
    echo json_encode($arr_Respuesta);
}

if ($tipo == "actualizar") {
    $arr_Respuesta = array('status' => false, 'msg' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        if ($_POST) {
            $id = $_POST['data'];
            $dni = $_POST['dni'];
            $nombres_apellidos = $_POST['nombres_apellidos'];
            $correo = $_POST['correo'];
            $telefono = $_POST['telefono'];
            $estado = $_POST['estado'];

            if ($id == "" || $dni == "" || $nombres_apellidos == "" || $correo == "" || $telefono == "" || $estado == "") {
                $arr_Respuesta = array('status' => false, 'mensaje' => 'Error, campos vacíos');
            } else {
                $arr_Usuario = $objUsuario->buscarUsuarioByDni($dni);
                if ($arr_Usuario && $arr_Usuario->id != $id) {
                    $arr_Respuesta = array('status' => false, 'mensaje' => 'DNI ya está registrado');
                } else {
                    $consulta = $objUsuario->actualizarUsuario($id, $dni, $nombres_apellidos, $correo, $telefono, $estado);
                    if ($consulta) {
                        $arr_Respuesta = array('status' => true, 'mensaje' => 'Actualizado Correctamente');
                    } else {
                        $arr_Respuesta = array('status' => false, 'mensaje' => 'Error al actualizar registro');
                    }
                }
            }
        }
    }
    echo json_encode($arr_Respuesta);
}

if ($tipo == "reiniciar_password") {
    $arr_Respuesta = array('status' => false, 'msg' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        $id_usuario = $_POST['id'];
        $password = $objAdmin->generar_llave(10);
        $pass_secure = password_hash($password, PASSWORD_DEFAULT);
        $actualizar = $objUsuario->actualizarPassword($id_usuario, $pass_secure);
        if ($actualizar) {
            $arr_Respuesta = array('status' => true, 'mensaje' => 'Contraseña actualizada correctamente a: ' . $password);
        } else {
            $arr_Respuesta = array('status' => false, 'mensaje' => 'Hubo un problema al actualizar la contraseña, intente nuevamente');
        }
    }
    echo json_encode($arr_Respuesta);
}

if ($tipo == "send_email_password") {
    $arr_Respuesta = array('status' => false, 'msg' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        $datos_sesion = $objSesion -> buscarSesionLoginById($id_sesion);
        $datos_usuario = $objUsuario->buscarUsuarioById($datos_sesion->id_usuario);
        $llave = $objAdmin->generar_llave(30);
        $token = password_hash($llave, PASSWORD_DEFAULT);
        $update = $objUsuario->updateResetPassword($datos_sesion->id_usuario, $llave, 1);
        if ($update) {

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'mail.programacion2024.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'renzo_1304@programacion2024.com';                     //SMTP username
    $mail->Password   = 'mqaaGWIP1Ci%';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('renzo_1304@programacion2024.com', 'Cambio de contraseña - TB');
    $mail->addAddress($datos_usuario->correo, $datos_usuario->nombres_apellidos);     //Add a recipient
    /*$mail->addAddress('ellen@example.com');               //Name is optional
    $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');

    //Attachments
    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    */
    //Content
    $mail->isHTML(true);   
    $mail->CharSet = 'UTF-8';                           //Set email format to HTML
    $mail->Subject = 'Cambio de contraseña papu - Sistema de virus';
    $mail->Body    = '
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Correo Empresarial</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #8DE0F2;
    }
    .container {
      max-width: 600px;
      margin: auto;
      background-color: #ffffff;
      font-family: Arial, sans-serif;
      color: #333333;
      border: 1px solid #dddddd;
      border-radius: 10px;
      overflow: hidden;
    }
    .header {
      background-color: #03588C;
      color: white;
      padding: 20px;
      text-align: center;
    }
    .header h2 {
      margin: 0 0 8px 0;
      font-size: 18px;
    }
    .header-subtitle {
      margin: 0;
      font-size: 13px;
      opacity: 0.9;
    }
    .color-bar {
      height: 5px;
      background: linear-gradient(90deg, #9FD923 0%, #F2E205 50%, #8DE0F2 100%);
    }
    .content {
      padding: 30px;
    }
    .content h1 {
      font-size: 22px;
      margin-bottom: 20px;
      color: #03588C;
    }
    .content p {
      font-size: 16px;
      line-height: 1.5;
    }
    .alert-box {
      background-color: #F2E205;
      border: 2px solid #9FD923;
      padding: 15px;
      margin: 20px 0;
      border-radius: 8px;
      text-align: center;
    }
    .alert-box p {
      margin: 0;
      font-size: 14px;
      font-weight: bold;
      color: #333;
    }
    .button {
      display: inline-block;
      background-color: #03588C;
      color: #ffffff !important;
      padding: 15px 30px;
      margin: 20px 0;
      text-decoration: none;
      border-radius: 30px;
      font-weight: bold;
      font-size: 16px;
      box-shadow: 0 4px 8px rgba(3, 88, 140, 0.3);
      transition: all 0.3s;
    }
    .button:hover {
      background-color: #9FD923;
      color: #333333 !important;
      transform: translateY(-3px);
      box-shadow: 0 6px 12px rgba(159, 217, 35, 0.4);
    }
    .highlight {
      color: #03588C;
      font-weight: bold;
    }
    .footer {
      background-color: #03588C;
      text-align: center;
      padding: 15px;
      font-size: 12px;
      color: #ffffff;
    }
    .footer a {
      color: #8DE0F2;
      text-decoration: none;
    }
    .footer a:hover {
      color: #9FD923;
    }
    @media screen and (max-width: 600px) {
      .content, .header, .footer {
        padding: 15px !important;
      }
      .button {
        padding: 10px 20px !important;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h2>Instituto de Educación Superior Tecnológico Público Huanta</h2>
      <p class="header-subtitle">Excelencia Educativa - Innovación Tecnológica</p>
    </div>
    <div class="color-bar"></div>
    <div class="content">
    <center><img src="https://sispa.iestphuanta.edu.pe/img/logo.png"  width="200"></center>
      <h1>Hola '.$datos_usuario->nombres_apellidos.',</h1>
      <p>
        Te saludamos cordialmente desde el Instituto de Educación Superior Tecnológico Público Huanta. Hemos recibido una solicitud para cambiar la contraseña de tu cuenta en nuestro sistema académico.
      </p>
      <div class="alert-box">
        <p>🔒 Por tu seguridad, este enlace expirará en 24 horas</p>
      </div>
      <p>
        Si solicitaste este cambio, haz clic en el botón de abajo para crear tu nueva contraseña. Si no realizaste esta solicitud, puedes ignorar este correo de forma segura.
      </p>
      <center>
        <a href="'.BASE_URL.'reset-password/?data='.$datos_usuario->id.'&data2='.urlencode($token).'" class="button">Cambiar Contraseña</a>
      </center>
      <p class="highlight">Gracias por confiar en nosotros para tu formación profesional.</p>
    </div>
    <div class="footer">
      © 2025 Instituto de Educación Superior Tecnológico Público Huanta. Todos los derechos reservados.<br>
      Ayacucho, Perú | <a href="mailto:soporte@iestphuanta.edu.pe">soporte@iestphuanta.edu.pe</a><br>
      <a href="'.BASE_URL.'">Cancelar suscripción</a>
    </div>
  </div>
</body>
</html>
    ';
    
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
        }else{
            echo 'falló al actualizar';
        }
        //print_r($token);
    }
}

if ($tipo == "nuevo_password") {
    $arr_Respuesta = array('status' => false, 'msg' => 'Error al procesar la solicitud');

    if ($_POST) {
        $id_usuario = $_POST['id'] ?? '';
        $nueva_password = $_POST['password'] ?? '';

        if ($id_usuario == "" || $nueva_password == "") {
            $arr_Respuesta = array('status' => false, 'mensaje' => 'Error, datos incompletos');
        } else {
            // Encriptar contraseña
            $pass_secure = password_hash($nueva_password, PASSWORD_DEFAULT);

            // Actualizar en base de datos: password, reset_password = 0 y token_password = ''
            $actualizado = $objUsuario->nuevoPassword($id_usuario, $pass_secure);

            if ($actualizado) {
                $arr_Respuesta = array('status' => true, 'mensaje' => 'Contraseña actualizada exitosamente.');
            } else {
                $arr_Respuesta = array('status' => false, 'mensaje' => 'Error al actualizar la contraseña.');
            }
        }
    }

    echo json_encode($arr_Respuesta);
}
