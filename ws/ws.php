<?php
include("funciones.php");
$direcciones=getDireccion($_REQUEST['query'],1);
if(count($direcciones)>0)
{
	echo implode($direcciones[0],",");
}else
{
	$direcciones=buscarDireccionOSM($_REQUEST['query']." chile");
	if(count($direcciones)>0)
	{
		echo implode($direcciones[0],",");
	}else
	{
		$direcciones=getDireccionGoogle($_REQUEST['query']." chile");
		if(count($direcciones)>0)
		{
			echo utf8_decode(implode($direcciones[0],","));
		}else
		{
			echo "0";
		}
	}
	//echo "0";
}
?>