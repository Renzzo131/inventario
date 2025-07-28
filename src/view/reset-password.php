<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <style>

    .login-container input::placeholder {
      color: #888;
    }

    .login-container button {
      width: 100%;
      padding: 10px;
      margin-top: 20px;
      background: #384759;
      border: none;
      border-radius: 5px;
      color: #fff;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .login-container button:hover {
      background: #384759;
    }



    .login-container a {
      display: block;
      margin-top: 15px;
      color: #49538C;
      text-decoration: none;
      font-size: 0.9rem;
    }

    .login-container a:hover {
      text-decoration: underline;
    }
  </style>
  <!-- Sweet Alerts css -->
  <link href="<?php echo BASE_URL ?>src/view/pp/plugins/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
  <script>
    const base_url = '<?php echo BASE_URL; ?>';
    const base_url_server = '<?php echo BASE_URL_SERVER; ?>';
  </script>
</head>

<body>
    <input type="hidden" id="data" value="<?php echo $_GET['data'];?>">
    <input type="hidden" id="data2" value="<?php echo urldecode($_GET['data2']);?>">
  <div class="login-container">
    <h1>Actualizar contraseña</h1>
    <img src="https://sispa.iestphuanta.edu.pe/img/logo.png" alt="" width="100%">
    <h4>Sistema de Control de Inventario</h4>
    <form id="frm_reset_password">
      <input type="password" name="password" id="password" placeholder="Nueva contraseña" required>
      <input type="password" name="password1" id="password1" placeholder="Confirmar contraseña" required>
      <button type="button" onclick="validar_inputs_password();">Actualizar</button>
    </form>
  </div>
</body>
<script src="<?php echo BASE_URL; ?>src/view/js/principal.js"></script>
<script>
  validar_datos_reset_password();
</script>
<!-- Sweet Alerts Js-->
<script src="<?php echo BASE_URL ?>src/view/pp/plugins/sweetalert2/sweetalert2.min.js"></script>


</html>