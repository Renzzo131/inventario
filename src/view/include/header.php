<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>SIGI - IES</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Sistema Integrado de Gestión Institucional" name="description" />
    <meta content="AnibalYucraC" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo BASE_URL ?>src/view/pp/assets/images/favicon.ico">

    <!-- Plugins css -->
    <script src="<?php echo BASE_URL ?>src/view/js/principal.js"></script>
    <link href="<?php echo BASE_URL ?>src/view/pp/plugins/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo BASE_URL ?>src/view/pp/plugins/datatables/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo BASE_URL ?>src/view/pp/plugins/datatables/buttons.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo BASE_URL ?>src/view/pp/plugins/datatables/select.bootstrap4.css" rel="stylesheet" type="text/css" />
    <!-- Sweet Alerts css -->
    <link href="<?php echo BASE_URL ?>src/view/pp/plugins/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="<?php echo BASE_URL ?>src/view/pp/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo BASE_URL ?>src/view/pp/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo BASE_URL ?>src/view/pp/assets/css/theme.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo BASE_URL ?>src/view/include/styles.css" rel="stylesheet" type="text/css" />
    <style>
        .btn-primary {
            background: linear-gradient(135deg, #49538C, #5a6394);
            border: none;
            color: white;
            padding: 12px 24px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 6px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-transform: none;
            letter-spacing: 0.3px;
            box-shadow: 
                0 2px 8px rgba(73, 83, 140, 0.25),
                0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
            transition: left 0.8s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #88d3ce, #9bddd9);
            transform: translateY(-1px);
            box-shadow: 
                0 4px 16px rgba(136, 211, 206, 0.3),
                0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-info {
    background: linear-gradient(135deg, #2c8c85, #3ca79f);
    border: none;
    color: white;
    padding: 12px 24px;
    font-size: 14px;
    font-weight: 500;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-transform: none;
    letter-spacing: 0.3px;
    box-shadow: 
        0 2px 8px rgba(44, 140, 133, 0.25),
        0 1px 3px rgba(0, 0, 0, 0.1);
}

.btn-info::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
    transition: left 0.8s ease;
}

.btn-info:hover {
    background: linear-gradient(135deg, #70e1c8, #91f2dc);
    transform: translateY(-1px);
    box-shadow: 
        0 4px 16px rgba(112, 225, 200, 0.3),
        0 2px 8px rgba(0, 0, 0, 0.15);
}

.btn-info:hover::before {
    left: 100%;
}

.btn-info:active {
    transform: translateY(0);
}

.btn-success {
    background: linear-gradient(135deg, #2e7d32, #388e3c);
    border: none;
    color: white;
    padding: 12px 24px;
    font-size: 14px;
    font-weight: 500;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-transform: none;
    letter-spacing: 0.3px;
    box-shadow: 
        0 2px 8px rgba(46, 125, 50, 0.25),
        0 1px 3px rgba(0, 0, 0, 0.1);
}

.btn-success::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
    transition: left 0.8s ease;
}

.btn-success:hover {
    background: linear-gradient(135deg, #66bb6a, #81c784);
    transform: translateY(-1px);
    box-shadow: 
        0 4px 16px rgba(102, 187, 106, 0.3),
        0 2px 8px rgba(0, 0, 0, 0.15);
}

.btn-success:hover::before {
    left: 100%;
}

.btn-success:active {
    transform: translateY(0);
}

.btn-danger {
    background: linear-gradient(135deg, #c62828, #d32f2f);
    border: none;
    color: white;
    padding: 12px 24px;
    font-size: 14px;
    font-weight: 500;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-transform: none;
    letter-spacing: 0.3px;
    box-shadow: 
        0 2px 8px rgba(211, 47, 47, 0.25),
        0 1px 3px rgba(0, 0, 0, 0.1);
}

.btn-danger::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
    transition: left 0.8s ease;
}

.btn-danger:hover {
    background: linear-gradient(135deg, #e57373, #ef9a9a);
    transform: translateY(-1px);
    box-shadow: 
        0 4px 16px rgba(229, 115, 115, 0.3),
        0 2px 8px rgba(0, 0, 0, 0.15);
}

.btn-danger:hover::before {
    left: 100%;
}

.btn-danger:active {
    transform: translateY(0);
}

.btn-light {
    background: linear-gradient(135deg, #f7f7f7, #e9e9e9);
    border: none;
    color: #333;
    padding: 12px 24px;
    font-size: 14px;
    font-weight: 500;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-transform: none;
    letter-spacing: 0.3px;
    box-shadow: 
        0 2px 8px rgba(150, 150, 150, 0.15),
        0 1px 3px rgba(0, 0, 0, 0.08);
}

.btn-light::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(0, 0, 0, 0.05), transparent);
    transition: left 0.8s ease;
}

.btn-light:hover {
    background: linear-gradient(135deg, #ffffff, #f2f2f2);
    transform: translateY(-1px);
    box-shadow: 
        0 4px 16px rgba(200, 200, 200, 0.25),
        0 2px 8px rgba(0, 0, 0, 0.1);
    color: #111;
}

.btn-light:hover::before {
    left: 100%;
}

.btn-light:active {
    transform: translateY(0);
}


    </style>
    <script>
        const base_url = '<?php echo BASE_URL; ?>';
        const base_url_server = '<?php echo BASE_URL_SERVER; ?>';
        const session_session = '<?php echo $_SESSION['sesion_id']; ?>';
        const session_ies = '<?php echo $_SESSION['sesion_ies']; ?>';
        const token_token = '<?php echo $_SESSION['sesion_token']; ?>';
    </script>
    <?php date_default_timezone_set('America/Lima');  ?>
</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <div class="main-content">

            <header id="page-topbar">
                <div class="navbar-header">
                    <!-- LOGO -->
                    <div class="navbar-brand-box d-flex align-items-left">
                        <a href="<?php echo BASE_URL ?>" class="logo">
                            <i class="fas fa-clipboard-list"></i>
                            <span>
                                SISTEMA DE GESTION DE INVENTARIO
                            </span>
                        </a>

                        <button type="button" class="btn btn-sm mr-2 font-size-16 d-lg-none header-item waves-effect waves-light" data-toggle="collapse" data-target="#topnav-menu-content">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item waves-effect waves-light"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="d-none d-sm-inline-block ml-1" id="menu_ies">Huanta</span>
                                <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" id="contenido_menu_ies">
                            </div>
                        </div>
                        <div class="dropdown d-inline-block ml-2">
                            <button type="button" class="btn header-item waves-effect waves-light"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="https://cdn-icons-png.flaticon.com/512/1077/1077063.png">
                                <span class="d-none d-sm-inline-block ml-1"><?php /* echo $_SESSION['sesion_sigi_usuario_nom']; */ ?></span>
                                <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                    Mi perfil
                                </a>
                                <button class="dropdown-item d-flex align-items-center justify-content-between" onclick="send_email_password();">
                                    <span>Cambiar mi Contraseña</span>
</button>
                                <button class="dropdown-item d-flex align-items-center justify-content-between" onclick="cerrar_sesion();">
                                    <span>Cerrar Sesión</span>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </header>

            <div class="topnav">
                <div class="container-fluid">
                    <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                        <div class="collapse navbar-collapse" id="topnav-menu-content">
                            <ul class="navbar-nav">

                                <!-- ---------------------------------------------- INICIO MENU SIGI ------------------------------------------------------------ -->
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo BASE_URL ?>">
                                        <i class="mdi mdi-home"></i>Inicio
                                    </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-components" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="mdi mdi-cogs"></i>Gestión <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="topnav-components">
                                        <a href="<?php echo BASE_URL ?>usuarios" class="dropdown-item">Usuarios</a>
                                        <a href="<?php echo BASE_URL ?>instituciones" class="dropdown-item">Instituciones</a>
                                        <a href="<?php echo BASE_URL ?>ambientes" class="dropdown-item">Ambientes</a>
                                        <a href="<?php echo BASE_URL ?>bienes" class="dropdown-item">Bienes</a>
                                        <a href="<?php echo BASE_URL ?>movimientos" class="dropdown-item">Movimientos</a>
                                        <a href="<?php echo BASE_URL ?>reportes" class="dropdown-item">Reportes</a>
                                    </div>
                                </li>

                                <!-- ---------------------------------------------- FIN MENU SIGI ------------------------------------------------------------ -->
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>


            <div class="page-content">
                <div class="container-fluid">
                    <!-- start page title -->

                    <!-- Popup de carga -->
                    <div id="popup-carga" style="display: none;">
                        <div class="popup-overlay">
                            <div class="popup-content">
                                <div class="spinner"></div>
                                <p>Cargando, por favor espere...</p>
                            </div>
                        </div>
                    </div>
                    <script>
                        cargar_datos_menu(<?php echo $_SESSION['sesion_ies']; ?>);
                    </script>