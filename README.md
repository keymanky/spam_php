# spam_php
Envia spam a una lista de correos en sql y desde un formulario echo con php


Testeado sobre php 5.2.9 y mysql 5.6.10 en marzo de 2013

Si eres un usuario comun busca videos tutoriales de como hacer cada uno 
de los pasos (0.-instalar xampp 1.7.1)

1.- Habilitar ssl en php, quitandolo el ; al archivo php.ini a 
	la linea:
	;extension=php_openssl.dll
2.- Restaurar la tabla en una base de datos existente, con el archivo .sql( los correos se 
    enviaran siempre que esten en la tabla mails)
3.- Configura el archivo conexion.php con las variables de conexion 
    a la base de datos (base de datos, user, password, servidor)
4.- Copia todo el contenido de la carpeta a http (o ejecutalo desde el
    servidor remoto o local)
5.- Introduce los valores en el formulario



Nota: Para enviar correos debes primero saber que correos
e iinsertarlos en la tabla mails, para el funcionamiento de los scripts php
es necesario que los correos de la tabla tengan el formato correcto y que
su id sea consecutivo. Siempre se empieza a enviar desde el id=1

Te recomiendo crear una tabla temporal para cada grupo de envio

Estos scripts reducen la deteccion de spam ya que se aplica:
-Envio uno a uno a cada correo
-Sistema automatico que envia mails
-Anade caracteres aleatorios al asunto del mensaje y al final del contenido
-Los envios se realizan por un # aleatorio de segundos, especificado en el formulario
-Debes utilizar una cuenta de gmail, que tenga gran cantidad de trafico en el buzon
de entrada, como : crea una cuenta de facebook con una chava super guapa, y empieza
a enviar solicitudes, anade a todos tus amigos a "mejores amigos" y tendras muchos 
correos de entrada al dia.

Si sigues los puntos anteriores tu correo llegara a la bandeja de entrada de tu destinatario

En la carpeta hay una aplicacion que entuba los correos en el formato correcto 