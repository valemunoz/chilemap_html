<?PHP
/*URL*/
//$CM_path_base="http://www.chilemap.cl";
//$CM_path_base2="http://www.chilemap.cl/index_mapa.php";
//$CM_path_coorporativo="http://www.chilemap.cl/coorporativo";
//$CM_path_logo="http://www.chilemap.cl/images/logo.png";
$CM_path_activa_mail="http://www.chilemap.cl/activa.php";
$CM_PATH_REENVIO_CONF="http://www.chilemap.cl/confirmacion.php?mail=CM_MAIL";
$CM_path_re_activa_mail="http://www.chilemap.cl/reactiva.php";
//$CM_path_mobile="http://movil.chilemap.cl/index.php";
//$CM_dominio_mobile="http://movil.chilemap.cl";
//$CM_path_base="http://desarrollo.chilemap.cl";
//$CM_path_base2="http://desarrollo.chilemap.cl/index_mapa.php";
//$CM_path_coorporativo="http://desarrollo.chilemap.cl/coorporativo";
//$CM_path_logo="http://desarrollo.chilemap.cl/images/logo.png";
//$CM_path_activa_mail="http://desarrollo.chilemap.cl/activa.php";
//$CM_PATH_REENVIO_CONF="http://desarrollo.chilemap.cl/confirmacion.php?mail=CM_MAIL";
//$CM_path_mobile="http://www.chilemap.cl/mobile/index.php";
$CM_path_base="http://localhost/chilemap_html";
$CM_path_base2="http://localhost/chilemap_html/index_mapa.php";
$CM_path_coorporativo="http://localhost/chilemap_html/coorporativo";
$CM_path_logo="http://localhost/chilemap_html/images/logo.png";
$CM_path_mobile="http://localhost/chilemap/mobile/index.php";
$CM_dominio_mobile="http://localhost/chilemap/mobile";
$CM_path_re_activa_mail="http://localhost/chilemap_html/reactiva.php";


$CM_GOOGLE_SEARCH=true;
$CM_OSM_SEARCH=true;

$CM_FACE_LINK=$CM_path_base2."?idp=IDPTO&tp=TPTO";
$CM_SIZE_ICONO_MAPA="30,30";
$CM_SIZE_ICONO_MAPA_SERV_ODM="30,30";
$CM_SIZE_ICONO_MAPA_SERV_ODM_FULL="20,20";
$CM_ICONO_DIR='iconos/direccion.png';
$CM_ICONO_TRANSANTIAGO='iconos/trans_stop.png';

$CM_ICONO_FARMACIA='iconos/farma_turno.png';


$CM_ICONO_SERV="iconos/servicio.png";
$CM_ZOOM_SERV=16;
$CM_ZOOM_DIR=16;

/*FIN URL*/

/*MSG REGISTRO USUARIO*/
$CM_USUARIO_REGISTRADO="Lo sentimos pero tu mail ya est&aacute; registrado.";
$CM_USUARIO_ESPERA_ACTIVACION="Ya estas registrado!, estamos esperando que confirmes tu direcci&oacute;n de correo.<br><br>Quieres que te reenviemos el correo de confirmaci&oacute;n? <a href='".$CM_PATH_REENVIO_CONF."'>Haz click AQUI</a>.";
$CM_USUARIO_INACTIVO="Lo sentimos pero tu mail ya est&aacute; registrado e inactivo. Quieres volver a activar tu cuenta? <a href='".$CM_path_re_activa_mail."?mail=_MAIL_'>Haz click AQUI</a>";
$CM_USUARIO_NO_REG="Lo sentimos pero no estas registrado en nuestro sitio.";
$CM_USUARIO_REG_OK="<strong>Bienvenido a la familia ChileMap!</strong><br><br>Te enviamos un correo para confirmar tu direcci&oacuten.<br><br><br>Equipo ChileMap!";

$CM_USUARIO_EDIT="<strong>Cambios realizados!</strong>";
$CM_USUARIO_CLOSE="<strong>Es una l&aacute;stima! esperamos verte pronto!</strong>";

/*FIN*/


/*MSG INICIO SESION*/
$CM_INICIO_CLAVE="Tu correo o clave no coincide con nuestros registros, por favor int&2acute;ntalo nuevamente.";
$CM_INICIO_ESPERA_ACT="Lo sentimos pero no puedes iniciar sesi&oacute;n hasta que confirmes el mail enviado luego del registro.<br>Necesitas que lo enviemos nuevamente? <a href='javascript:onclick:msgActivacion();'>haz click aqui</a>";
$CM_INICIO_CTA_INACTIVA="Lo sentimos pero no puedes iniciar sesi&oacute;n, tu cuenta esta inactiva. <a href='".$CM_path_re_activa_mail."?mail=_MAIL_'>Quieres activarla nuevamente? haz click aqu&iacute;</a>";
$CM_MSG_REENV_CONF="Hemos enviado un mail para que confirmemos tu cuenta de correo. <br>Por favor revisa tu bandeja de entrada o SPAM.";

/*FIN*/

/*MSG CONTACTO*/
$CM_MSG_RECIBIDO="Hemos recibido tu mensaje, nos pondremos en contacto lo antes posible.<br><br><br>Equipo Chilemap.cl";
$CM_MSG_ERROR="Ocurri&oacute; un error, por favor int&eacute;ntelo mas tarde.";
/*FIN*/

/*MSG OLVIDO*/
$CM_MSG_OLVIDO_ENV="Hemos enviado un correo con tu cotrase&ntildea.";
$CM_MSG_OLVIDO_NOUSER="Lo sentimos pero el mail no est&aacute; registrado en nuestro sitio.";
/*FIN*/
/*Mail*/
$CM_MAIL_CONTACTO_US="Hemos recibido tu mensaje, nos pondremos en contacto lo antes posible.<br><br><br><img src='".$CM_path_logo."'><br><strong>Equipo de Chilemap.cl</strong>";
$CM_MAIL_OLVIDO="Hola<br><br> Haz solicitado recuperar tu contraseña y esta es:<br><br><strong>US_CONTRASENA</strong><br><br><img src='".$CM_path_logo."'><br><strong>Equipo de Chilemap.cl</strong>";
$CM_MAIL_CONFIRMACION='Hola!<br><br> Este correo es para confirmar tu direcci&oacute;n de Email ingresado en el sitio chilemap.cl, por favor haz click en el link <br> m&aacute;s adelante para confirmar tu correo y terminar con el registro.<br> URL_CONF <br><br><br><img src="'.$CM_path_logo.'"><br><strong>Equipo de Chilemap.cl</strong>';
/*FIN*/

$CM_msg_mail_ok="El mail ha sido enviado.";
$CM_msg_mail_err="Lo sentimos ha ocurrido un error. Por favor int&eacute;talo nuevamente.";
$CM_mail="_NOMBRE_ ha compartido un link contigo. <br><br> Haz click en este link para verlo <a href='_LINK_'>Link chilemap.cl</a><br><br>Equipo Chilemap.cl";

$CM_ERROR_GENERAL="Lo sentimos pero no entendemos tu solicitud <a href='".$CM_path_base."'>Volver al Home</a>";

$CM_msg_direccion_no="<div class='msg_comun'>Lo sentimos, pero no encontramos resultados para direcciones.</div>";
$CM_msg_servicio_no="<div class='msg_comun'>Lo sentimos, pero no encontramos resultados para puntos.</div>";

?>
