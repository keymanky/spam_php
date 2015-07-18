<?php
session_start();
$_SESSION = array();
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Envio Masivo</title>
    <link href="librery/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/style.css" /> 
    <script type="text/javascript" src="lib/jquery.js" ></script>
</head>

<body>
  <?php
  include('conexion.php');
  
  $sql = "select count(*) t from mails";
  $res = $mysqli->query($sql);
  if($res->num_rows == 1)
        {
	  $k = $res->fetch_array();
	  $total= $k['t'];
	  $_SESSION['total'] = $total;
	}
  else
      echo "<p><h1>Error de conexion !!!</h1></p>"
  ?>
  <form class="form-horizontal form-signin" method="post" action="procesar.php?id=1" enctype="multipart/form-data">
	
	<div class="control-group">
	  <label class="control-label" for="Nombre">Nombre</label>
	  <div class="controls">
	    <input type="text" id="Nombre" placeholder="nombre remitente" name="nombre">
	  </div>
	</div>

	<div class="control-group">
	  <label class="control-label" for="inputEmail">Email</label>
	  <div class="controls">
	    <input type="text" id="inputEmail" placeholder="Email de gmail" name="email">
	  </div>
	</div>
	
	<div class="control-group">
	  <label class="control-label" for="inputPassword">Password</label>
	  <div class="controls">
	    <input type="password" id="inputPassword" placeholder="Password" name="password">
	  </div>
	</div>
	
	<div class="control-group">
	  <label class="control-label" for="Asunto">Asunto</label>
	  <div class="controls">
	    <input type="text" id="Asunto" placeholder="Asunto" name="asunto">
	  </div>
	</div>
	
	<div class="control-group">
	  <label class="control-label" for="Mensaje">Mensaje</label>
	  <div class="controls">
	    <textarea type="text" id="Mensaje" placeholder="Escriba aqu&iacute; el mensaje" rows="5" name="mensaje"></textarea>
	  </div>
	   	
	<div class="control-group">
	  <div class="controls">
	  <label class="checkbox">
	     <input type="checkbox" name="html">El mensaje tiene codigo html
	  </label>
	  </div>
	</div>
	
	<div class="control-group">
	  <label class="control-label" for="CC">CC</label>
	  <div class="controls">
	    <input type="text" id="CC" placeholder="Copia" name="cc">
	  </div>
	</div>	
	
	<div class="control-group">
	  <label class="control-label" for="minutos">Rango de envio:</label>
	  <div class="controls">
	    <input type="text" id="mihutos" placeholder="[1-360] Default=360 (Segundos)" name="minutos">
	  </div>
	</div>	
	
	<div class="control-group">
	  <label class="control-label" for="Aj">Adjuntar archivo</label>
	  <div class="controls">
	    <input type="file" id="Aj" name="archivo">
	  </div>
	</div>
	
	<div class="control-group">
	  <div class="controls">
	    <label class="checkbox">
	      <input type="checkbox" name="aleatorio">Agregar al asunto y al contenido pocos caracteres aleatorios.<br/> Evita ser detectado como SPAM
	    </label>
	  </div>
	</div>
	
	<div class="control-group">
	  <div class="controls">
		<button type="submit" class="btn btn-success" >Arrancar</button>
	  </div>
	</div>
	
   </form>
    <link href="librery/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</body>
</html>
