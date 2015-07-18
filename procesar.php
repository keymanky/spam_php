<?php
  session_start();
  require_once 'librery/Swift-4.3.0/lib/swift_required.php';
  ob_start();
  $status = '';
  $transporte = Swift_SmtpTransport::newInstance("smtp.gmail.com", 465, "ssl");
  $mensaje = Swift_Message::newInstance($transport);
  if(!isset($_SESSION['nombre']))
  {
    $_SESSION['id'] = $_GET['id'];
    $_SESSION['nombre']= $_POST['nombre'];
    $_SESSION['email']= $_POST['email'];
    $_SESSION['password']= $_POST['password'];
    $_SESSION['asunto']= $_POST['asunto'];
    $_SESSION['html']= $_POST['html'];
    $_SESSION['cc']= $_POST['cc'];
    $_SESSION['mensaje'] = $_POST['mensaje'];
    if($_POST['minutos'] > 1 && $_POST['minutos'] < 360)
	$_SESSION['minutos'] = $_POST['minutos'];
    else
	$_SESSION['minutos'] = 360;
    if(isset($_POST['html']))
	$_SESSION['tipo'] = 'text/html';
    else
	$_SESSION['tipo'] = 'text/plain';
    if(isset($_POST['aleatorio']))
	$_SESSION['rand'] = 1;
    else
	$_SESSION['rand'] = 0;
    $_SESSION['archivo_bin'] = 0;
  }
  
  if($_SESSION['email'] != '' && $_SESSION['password'] != '' && $_SESSION['asunto'] != '' )
  {
      if($_SESSION['total'] == ($_SESSION['id']))
	 header('Location:fin.php');
	 
      if($_SESSION['rand'])
	$_randoms = chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90));
      else
	$_randoms = '';
      if(isset($_SESSION['nombre']))
	$mensaje->setFrom(array(
				'noreplay@null.com' => $_SESSION['nombre']
				)
			  );  
      $transporte->setUsername($_SESSION['email']);
      $transporte->setPassword($_SESSION['password']);
      $mensaje->setSubject($_SESSION['asunto'] . '  ' . $_randoms);
      //Configuracion del mensaje
      if($_SESSION['rand'])
	$_randoms = ' '. chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . ' ';
      else
	$_randoms = '';      
      $mensaje->setBody(
	    $_SESSION['mensaje'] . ' . ' . $_randoms , $_SESSION['tipo']
	    );
      if(isset($_SESSION['cc']) && $_SESSION['cc'] != '') 
	$mensaje->addCc($_SESSION['cc']);
      //Archivos adjuntos  
      $archivo = $_FILES["archivo"]['name'];
      if ($archivo != "")
      {
	    if (copy($_FILES['archivo']['tmp_name'],"tmp/" . $_FILES["archivo"]['name'])) {
		$mensaje->attach(Swift_Attachment::fromPath('tmp/' . $_FILES["archivo"]['name'] ));
		$_SESSION['file_name'] = 'tmp/' . $_FILES["archivo"]['name'];
	    } else {
		$status = "Advertencia: No se cargo el archivo";
	    }
	    $_SESSION['archivo_bin'] = 1;
      }
      if($_SESSION['archivo_bin'])
	$mensaje->attach(Swift_Attachment::fromPath($_SESSION['file_name']));
      //Destinatario
        include('conexion.php');
	$id = $_SESSION['id'];
        $sql = "select correo from mails where id = $id";
        $res = $mysqli->query($sql);
        if($res->num_rows == 1)
        {
	  $k = $res->fetch_array();
	  $usuario= $k['correo'];
	  $mensaje->setTo(array(
	    $usuario  
	  ));
	  $mail = Swift_Mailer::newInstance($transporte);
	  $result = $mail->send($mensaje);	  
	}
	else
	{
	  header('Location:procesar.php');
	  $_SESSION['id']++;
	}
      if($result) {
	    $status .= "Se envio correctamente " . $result;
	    $sql = "update mails set enviado = 1 where id=". $_SESSION['id'];
            $res = $mysqli->query($sql);
      }
      else
	    $status .= "No se pudo enviar. " . $result;
    $_SESSION['id']++;
    $tmp_id = $_SESSION['id']-1;
    $tmp_total = $_SESSION['total'];
      echo'
	    <!DOCTYPE HTML>
	    <html>
	    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Envio Masivo</title>
		<link href="librery/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" /> 
		<script type="text/javascript" src="lib/jquery.js" ></script>
		<script type="text/javascript">	
		window.seconds = Math.floor(Math.random()* '. $_SESSION['minutos'] .')+1;
		window.count_barra = 100/window.seconds;
		window.step = window.seconds;    
		window.onload = function()
		{
		    if (window.seconds != 0)
		    {
			document.getElementById(\'secondsDisplay\').innerHTML = \'\' + window.seconds + \' segundo\' + ((window.seconds > 1) ? \'s\' : \'\');
			document.getElementById(\'barra\').style.width = window.count_barra + \'%\';
			document.getElementById(\'info\').innerHTML = "Se envio a: " + "' . $usuario . '" + " Con Id: " + "' . $tmp_id .'" + "<br/>" + "'.$status.'";  
			window.seconds--;
			window.count_barra += 100/window.step;
		        document.getElementById(\'barra_total\').style.width =' . ($tmp_id*100)/$tmp_total . '+ \'%\';
			setTimeout(window.onload, 1000);
		    }
		    else
		    {
			window.location = "procesar.php";
		    }
		}
		</script>    
	    </head>
	    
	    <body>
	    	<div class="normal" id=total">Progreso total: '. $tmp_id*100/$tmp_total .'%</div><br/>
		<div class="progress progress-success active" id="status_total">
		    <div class="bar" id="barra_total"></div><br/>
		</div><br/>
		
		<div class="normal" id="info"></div><br/>
		<div class="progress progress-striped active" id="status">
		    <div class="bar" id="barra"></div><br/>
		</div><br/>
		<div class="normal">El proximo se enviara en: </div>
		<div id="secondsDisplay" class="normal"></div>
		
		<link href="librery/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	    </body>
	    </html>
      ';
  }
  else
  {
      header('Location:index.php');
  }
?>