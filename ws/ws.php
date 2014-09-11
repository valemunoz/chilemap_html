<?php
include("funciones.php");
$direcciones=getDireccion($_REQUEST['query'],1);
if(count($direcciones)>0)
{
	echo implode($direcciones[0],",");
}else
{
	echo "0";
}
?>