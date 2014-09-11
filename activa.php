<?php
include("includes/funciones.php");
require_once ('includes/mensajes.php');
$usuario=getUsuario(urldecode($_REQUEST['mail']),1);
if(count($usuario)>0 and $usuario[8]==$_REQUEST['co'])
{
	updateEstadoUsuario(urldecode($_REQUEST['mail']),0);
	header( 'Location: '.$CM_path_base2.'?act=1' );
}else
{
	//echo "Error de activacion. Para cuaquier consulta enviar mail a contacto@chilemap.cl";
	header( 'Location: '.$CM_path_base2.'?act=2' );
}
?>