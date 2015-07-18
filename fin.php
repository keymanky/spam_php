<?
        $total=0;
        include('conexion.php');
        $sql = "select count(*) t from mails where enviado=1";
        $res = $mysqli->query($sql);
        if($res->num_rows == 1)
        {
	  $k = $res->fetch_array();
	  $total= $k['t'];	  
	}
        echo 'Se enviaron: ' . $total;
        
        $sql = "update mails set enviado = 0";
        $res = $mysqli->query($sql);
    
?>