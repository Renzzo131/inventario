<?php
    $ruta = explode("/", $_GET['views']);
    if (!isset($ruta[1]) || $ruta== "") {
        header("location:".BASE_URL."movimientos");
    }

    $curl = curl_init(); //inicia la sesión cURL
    curl_setopt_array($curl, array(
        CURLOPT_URL => BASE_URL_SERVER."src/control/Movimiento.php?tipo=buscar_movimiento_id&sesion=".$_SESSION['sesion_id']."&token=".$_SESSION['sesion_token']."&data=".$ruta[1], //url a la que se conecta
        CURLOPT_RETURNTRANSFER => true, //devuelve el resultado como una cadena del tipo curl_exec
        CURLOPT_FOLLOWLOCATION => true, //sigue el encabezado que le envíe el servidor
        CURLOPT_ENCODING => "", // permite decodificar la respuesta y puede ser"identity", "deflate", y "gzip", si está vacío recibe todos los disponibles.
        CURLOPT_MAXREDIRS => 10, // Si usamos CURLOPT_FOLLOWLOCATION le dice el máximo de encabezados a seguir
        CURLOPT_TIMEOUT => 30, // Tiempo máximo para ejecutar
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, // usa la versión declarada
        CURLOPT_CUSTOMREQUEST => "GET", // el tipo de petición, puede ser PUT, POST, GET o Delete dependiendo del servicio
        CURLOPT_HTTPHEADER => array(
            "x-rapidapi-host: ".BASE_URL_SERVER,
            "x-rapidapi-key: XXXX"
        ), //configura las cabeceras enviadas al servicio
    )); //curl_setopt_array configura las opciones para una transferencia cURL

    $response = curl_exec($curl); // respuesta generada
    $err = curl_error($curl); // muestra errores en caso de existir

    curl_close($curl); // termina la sesión 

    if ($err) {
        echo "cURL Error #:" . $err; // mostramos el error
    } else {
        $respuesta = json_decode($response);/*Usar hasta aquí para poder generar el excel------------------------*/
        //print_r ($respuesta);
         // en caso de funcionar correctamente
        /*echo $_SESSION['sesion_sigi_id'];
        echo $_SESSION['sesion_sigi_token'];*/
        $contenido_pdf = '';
        $contenido_pdf .= '
        
        <!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Papeleta de Rotación de Bienes</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 40px;
    }

    h2 {
      text-align: center;
      text-transform: uppercase;
    }

    p {
      margin: 8px 0;
    }

    .subrayado {
      display: inline-block;
      min-width: 200px;
    }

    table {
      width: 100%;
    }
    th, td {
      padding: 8px;
      text-align: center;
    }

    .firmas {
      margin-top: 60px;
      display: flex;
      justify-content: space-between;
      padding: 0 50px;
    }

    .firma {
      text-align: center;
    }

    .firma-linea {
      margin-bottom: 5px;
    }

    .footer-fecha {
      margin-top: 40px;
      text-align: right;
      padding-right: 40px;
    }

    .motivo {
      font-weight: bold;
      margin-top: 20px;
    }
  </style>
</head>
<body>
<br><br><br>
  <h2><i>Papeleta de Rotación de Bienes</i></h2>
<br><br>
  <p>ENTIDAD <span class="subrayado">: DIRECCION REGIONAL DE EDUCACION - AYACUCHO</span></p>
  <p>ÁREA <span class="subrayado">: OFICINA DE ADMINISTRACIÓN</span></p>
  <p>ORIGEN <span class="subrayado">: '. $respuesta->amb_origen->codigo.' - '.$respuesta->amb_origen->detalle.'</span></p>
  <p>DESTINO <span class="subrayado">: '. $respuesta->amb_destino->codigo. ' - '. $respuesta->amb_destino->detalle .'</span></p>

  <p class="motivo">MOTIVO (*): <span class="subrayado">'. $respuesta->movimiento->descripcion.'</span></p>

  <table style="width: 100%; border-collapse: collapse; margin-top: 20px;" cellspacing="0" cellpadding="4">
    <thead>
      <tr>
        <th style="border: 0.3px solid #444; background-color: #f2f2f2;">ITEM</th>
        <th style="border: 0.3px solid #444; background-color: #f2f2f2;">CÓDIGO PATRIMONIAL</th>
        <th style="border: 0.3px solid #444; background-color: #f2f2f2;">NOMBRE DEL BIEN</th>
        <th style="border: 0.3px solid #444; background-color: #f2f2f2;">MARCA</th>
        <th style="border: 0.3px solid #444; background-color: #f2f2f2;">COLOR</th>
        <th style="border: 0.3px solid #444; background-color: #f2f2f2;">MODELO</th>
        <th style="border: 0.3px solid #444; background-color: #f2f2f2;">ESTADO</th>
      </tr>
    </thead>
    <tbody>
        
        ';
     if (empty($respuesta->detalle)) {
      $contenido_pdf .= '<tr>
      <td colspan = "7" style="text-align: center; border: 0.3px solid #444; font-size: 12.5px; font-weight: 300; ">
      No se encontraron bienes registrados para este movimiento
      </td>
      </tr>
      ';
     } else {
        $contador = 1;
foreach ($respuesta->detalle as $bien) {
    $contenido_pdf .= '<tr>';
    $contenido_pdf .= '<td style="border: 0.3px solid #444;">'.$contador.'</td>';
    $contenido_pdf .= '<td style="border: 0.3px solid #444;">'.$bien->cod_patrimonial.'</td>';
    $contenido_pdf .= '<td style="border: 0.3px solid #444;">'.$bien->denominacion.'</td>';
    $contenido_pdf .= '<td style="border: 0.3px solid #444;">'.$bien->marca.'</td>';
    $contenido_pdf .= '<td style="border: 0.3px solid #444;">'.$bien->color.'</td>';
    $contenido_pdf .= '<td style="border: 0.3px solid #444;">'.$bien->modelo.'</td>';
    $contenido_pdf .= '<td style="border: 0.3px solid #444;">'.$bien->estado_conservacion.'</td>';
    $contenido_pdf .= '</tr>';
    $contador++;
}
     }
     
      

$fecha_raw = $respuesta->movimiento->fecha_registro; // esta es la que te llega

// 1. Convertir la fecha al formato correcto
$fecha_obj = DateTime::createFromFormat('Y-m-d H:i:s', $fecha_raw);

// 2. Array de meses en español
$meses = [
    1 => "enero", "febrero", "marzo", "abril", "mayo", "junio",
    "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"
];

// 3. Verificamos que se haya parseado bien
if ($fecha_obj instanceof DateTime) {
    $dia = $fecha_obj->format('j');
    $mes = (int)$fecha_obj->format('n');
    $anio = $fecha_obj->format('Y');

    // 4. Formatear la fecha
    $fecha_formateada = "$dia de " . $meses[$mes] . " de $anio";
} else {
    $fecha_formateada = "Fecha inválida";
}


$contenido_pdf .= '

    </tbody>
  </table>

  <p style="text-align: right; padding-right: 40px;">
  Ayacucho, '.$dia.' de '.$meses[$mes].' de '.$anio.'
</p>
 <table style="width: 100%; border: none;" cellspacing="0" cellpadding="0">
    <tr>
      <td style="height: 40px;"></td>
    </tr>
    <tr>
      <td style="width: 50%; text-align: center;">
        ------------------------------<br>
        ENTREGUE CONFORME
      </td>
      <td style="width: 50%; text-align: center;">
        ------------------------------<br>
        RECIBÍ CONFORME
      </td>
    </tr>
  </table>

</body>
</html>

';



    require_once('./vendor/tecnickcom/tcpdf/tcpdf.php');


class MYPDF extends TCPDF {
    public function Header() {

        $this->Image('./src/view/pp/assets/images/gobierno_logo.jpg', 15, 10, 28, '', 'JPG', '', 'T', false, 150); // logo izquierdo
        $this->Image('./src/view/pp/assets/images/drea_logo.jpg', 165, 10, 28, '', 'JPG', '', 'T', false, 150); // logo derecho

        $this->SetY(10);
        $this->SetFont('helvetica', 'B', 10);
        $this->Cell(0, 10, 'GOBIERNO REGIONAL DE AYACUCHO', 0, false, 'C');
        $this->Ln(8);
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 10, 'DIRECCIÓN REGIONAL DE EDUCACIÓN DE AYACUCHO', 0, false, 'C');
        $this->Ln(8);
        $this->SetFont('helvetica', 'B', 10);
        $this->Cell(0, 10, 'DIRECCIÓN DE ADMINISTRACIÓN', 0, false, 'C');
    }

    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().' de '.$this->getAliasNbPages(), 0, false, 'C');
    }
}

$pdf = new MYPDF();



$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Renzo Gamboa');
$pdf->SetTitle('Reporte de movimientos');

//asignar márgenes
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//Salto de página automático
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//Va por secciones si quieres utilizar distintas fuentes(tipo de fuente, grosor, tamaño de la letra)
$pdf->SetFont('courier', '', 9);
// add a page
$pdf->AddPage();

// output the HTML content
$pdf->writeHTML($contenido_pdf);

//Close and output PDF document
$pdf->Output('reporte de movimientos.pdf', 'I');

    }
    
    