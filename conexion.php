<?php
	define('SERVERBD' , 'localhost');
	define('CONTRABD' ,  '123');
	define('USERBD','root');
	define('BD', 'masivo');
	$mysqli = new mysqli(SERVERBD,USERBD,CONTRABD,BD);
	
	if ($mysqli->connect_errno) {
	    printf("Error Fatal de Conexion: %s\n", $mysqli->connect_error);
	    exit();
	}
?>