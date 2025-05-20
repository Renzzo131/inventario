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
//  OBTENER CONTRASEÑA DESDE EL FORMULARIO
$password = $_POST['password'];  // Asegúrate de validar y sanitizar si es necesario

//  HASHEAR LA CONTRASEÑA CON BCRYPT
$options = ['cost' => 10];  // 10 es el valor por defecto en bcrypt
$pass_secure = password_hash($password, PASSWORD_BCRYPT, $options);

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

if ($tipo = "send_email_password") {
    $arr_Respuesta = array('status' => false, 'msg' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        $datos_sesion = $objSesion -> buscarSesionLoginById($id_sesion);
        $datos_usuario = $objUsuario->buscarUsuarioById($datos_sesion->id_usuario);
        $llave = $objAdmin->generar_llave(30);
        $token = password_hash($llave, PASSWORD_DEFAULT);
        $update = $objUsuario->updateResetPassword($datos_sesion->id_usuario, $llave, 1);
        if ($update) {
            //Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function


//Load Composer's autoloader (created by composer, not included with PHPMailer)


//Create an instance; passing `true` enables exceptions
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
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

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