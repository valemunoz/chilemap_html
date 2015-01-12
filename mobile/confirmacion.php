<?PHP
include("../includes/funciones.php");
require_once('../includes/mensajes.php');
if(isset($_REQUEST['mail']))
{
	$usuario=getUsuario($_REQUEST['mail'],10);
	
	if(count($usuario)>0)
	{
		if($usuario[7]==1)
		{
			
			$url="".$CM_path_activa_mail."?mail=".urlencode($_REQUEST['mail'])."&co=".$usuario[8]."";
			$mensaje = str_replace("URL_CONF",$url,$CM_MAIL_CONFIRMACION);	
			$envio=sendMail($_REQUEST['mail'],$mensaje,"Registro de Usuario ChileMap");
			if($envio)
			{
				$msg=$CM_MSG_REENV_CONF;
			}else
			{
				$msg=$CM_MSG_ERROR;
			}
		}
		
	}else
	{
		$msg= $CM_USUARIO_NO_REG;
	}
	
}else
{
	$msg= $CM_ERROR_GENERAL;
}
echo $msg;

?>
<script>
	window.location="<?=$CM_path_base2?>";
	</script>