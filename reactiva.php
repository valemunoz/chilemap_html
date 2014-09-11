<?php
include("includes/funciones.php");
require_once ('includes/mensajes.php');
$usuario=getUsuario(urldecode($_REQUEST['mail']),2);
if(count($usuario)>0 and $usuario[7]==2)
{
	updateEstadoUsuario(urldecode($_REQUEST['mail']),0);
	header( 'Location: '.$CM_path_base2.'?act=1' );
}else
{
	//echo "Error de activacion. Para cuaquier consulta enviar mail a contacto@chilemap.cl";
	header( 'Location: '.$CM_path_base2.'?act=2' );
}
?>