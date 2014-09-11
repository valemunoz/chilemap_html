<?PHP
include("includes/funciones.php");
$data_server= explode("?",$_SERVER['HTTP_REFERER']);
if(strtolower($data_server[0])=="http://www.chilemap.cl/coorporativo/")
{
	if($_REQUEST['tipo']==1)
	{
		$msg="Hemos recibido un mensaje desde la web coorporativa:<br> NOMBRE:".$_REQUEST['nombre']." <br> MAIL:".$_REQUEST['mail']." <br> MENSAJe:".$_REQUEST['msg']."";
		sendMail("contacto@chilemap.cl",$msg,"Contacto desde Formulario");
		$CM_MAIL_CONTACTO_US="Hemos recibido tu mensaje, nos pondremos en contacto lo antes posible.<br><br><br><img src='http://www.chilemap.cl/images/logo.png'><br><strong>Equipo de Chilemap.cl</strong>";
		sendMail($_REQUEST['mail'],$CM_MAIL_CONTACTO_US,"Contacto Chilemap.cl");
	}
}

?>