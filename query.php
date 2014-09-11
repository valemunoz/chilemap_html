<?PHP
include("includes/funciones.php");
require_once ('includes/mensajes.php');
$data_server= explode("?",$_SERVER['HTTP_REFERER']);
//if(strtolower($data_server[0])==$CM_path_base2)
if(substr(strtolower($data_server[0]),0,strlen($CM_path_base))==$CM_path_base)
{
	if($_REQUEST['tipo']==1)//registra usuario
	{
		
		$usuario=getUsuario($_REQUEST['mail'],10);
		
		if(count($usuario)==0) // no existe usuario con ese mail, se procede a registrar
		{
			$key=generar_clave(10);
			addUsuario($_REQUEST['tipo_usuario'],$_REQUEST['nombre'],$_REQUEST['mail'],$_REQUEST['pais'],$_REQUEST['clave'],1,$key,$_REQUEST['news']);
			$url="".$CM_path_activa_mail."?mail=".urlencode($_REQUEST['mail'])."&co=".$key."";
			$mensaje = str_replace("URL_CONF",$url,$CM_MAIL_CONFIRMACION);	
			$envio=false;
			try
			{
				$envio=sendMail($_REQUEST['mail'],$mensaje,"Registro de Usuario ChileMap");
			}catch (Exception $e){
			}
			if($envio)
			{
				$msg=$CM_USUARIO_REG_OK;
			}else
			{
				$msg=$CM_MSG_ERROR;
			}
			
		}else
		{
			if($usuario[7]==0)
			   $msg=$CM_USUARIO_REGISTRADO;
			if($usuario[7]==1)
			   $msg=str_replace("CM_MAIL",$_REQUEST['mail'],$CM_USUARIO_ESPERA_ACTIVACION);
			if($usuario[7]==2)
			   $msg=str_replace("_MAIL_",$_REQUEST['mail'],$CM_USUARIO_INACTIVO);
	   
	   
		}
		?>
			$("#reg_modal_reg").html("<?=$msg?>");		 
		
	   <?PHP
	
	}elseif($_REQUEST['tipo']==2) //inicio sesion
	{
		$usuario=getUsuario($_REQUEST['mail'],10);
		if(count($usuario)>0)
		{
			if($usuario[7]==0 and $usuario[5]==$_REQUEST['clave'])
			{
				inicioSesion($_REQUEST['mail'],$usuario[2],$usuario[0]);
				?>
				closeModalInicio();
				window.location.href="<?=$CM_path_base2?>";
				<?PHP
				
				
			}elseif($usuario[7]==0 and $usuario[5]!=$_REQUEST['clave'])
			{
				$msg=$CM_INICIO_CLAVE;
			}
			if($usuario[7]==1)
			{
				$msg=str_replace("CM_MAIL",$_REQUEST['mail'],$CM_INICIO_ESPERA_ACT);
				
			}
		  if($usuario[7]==2)
				$msg=str_replace("_MAIL_",$_REQUEST['mail'],$CM_INICIO_CTA_INACTIVA);
		}else
		{		
			$msg=$CM_USUARIO_NO_REG;
			
		}
		?>
			var capaContenedora = document.getElementById("msg_error");
		 	capaContenedora.innerHTML="<br><?=$msg?>";
			<?PHP
	}elseif($_REQUEST['tipo']==3) //cerrar sesion
	{
		cerrar_sesion();
		?>
		window.location.href="index_mapa.php";
		<?PHP
		
	}elseif($_REQUEST['tipo']==4) //formulario contacto
	{
		$msg=$CM_MAIL_CONTACTO_US;
		$titulo="Contacto ChileMap";
		$msg_empresa="Recibimos un contacto desde formulario web de:<br> NOMBRE:".$_REQUEST['nombre']." <br>MAIL:".$_REQUEST['mail']." <br>MENSAJE:".$_REQUEST['msg']."";
		try
		{
			$envio=sendMail("contacto@chilemap.cl",$msg_empresa,"Contacto desde formulario mobile");
			$envio=sendMail($_REQUEST['mail'],$msg,$titulo);
		}catch (Exception $e){
			$envio=false;
			}
		if($envio)
		{
			$msg=$CM_MSG_RECIBIDO;
			?>
		  <script>
				$("#reg_modal_cont").html("<?=$msg?>");		 		
		 	</script>
	  <?php 
		}else
		{
			$msg=$CM_MSG_ERROR;
			?>
		<script>
			$("#reg_modal_cont").html("<?=$msg?>");
			</script>
	  <?php 
		}
	}elseif($_REQUEST['tipo']==5)//olvido contraseña
	{
		
		$usuario=getUsuario($_REQUEST['mail'],10);
		
		if(count($usuario)==0) // no existe usuario con ese mail, se procede a registrar
		{
			$msg=$CM_MSG_OLVIDO_NOUSER;
			
		}else
		{
			if($usuario[7]==0)
			{
				$msg=str_replace("US_CONTRASENA",$usuario[5],$CM_MAIL_OLVIDO);
				$envio=sendMail($_REQUEST['mail'],$msg,"Recuperacion de contraseña");
				if($envio)
				{
					$msg=$CM_MSG_OLVIDO_ENV;
				}else
				{
					$msg=$CM_MSG_ERROR;
				}
				
			}elseif($usuario[7]==1)
			   $msg=$CM_USUARIO_ESPERA_ACTIVACION;
			elseif($usuario[7]==2)
			   $msg=str_replace("_MAIL_",$_REQUEST['mail'],$CM_USUARIO_INACTIVO);
			else
				$msg=$CM_MSG_ERROR;
		
		}
		?>	
					var capaContenedora = document.getElementById("msg_olvido");
		 			capaContenedora.innerHTML="<?=$msg?>";
	  <?php 
			
	}elseif($_REQUEST['tipo']==6) //envia mail modal
	{
		
		$msg=str_replace("_NOMBRE_",$_REQUEST['nombre'],$CM_mail);
		$msg=str_replace("_LINK_",$_REQUEST['link'],$msg);
		
		$envio=sendMail($_REQUEST['mail'],$msg,"".$_REQUEST['nombre'].", compartio un link contigo.");
		if($envio)
		{
			$msg=$CM_msg_mail_ok;
			?>
		  <script>
			$("#reg_modal_mail").html("<?=$msg?>");
		 	</script>
	  <?php 
		}else
		{
			$msg="No se pudo enviar link.";
			?>
		<script>
			$("#reg_modal_mail").html("<?=$msg?>");
		 	</script>
	  <?php 
		}
	}elseif($_REQUEST['tipo']==7) //add favoritos
	{
		
		session_start();
		$datos=getFavorito($_REQUEST['id'],$_REQUEST['tipo_data'],$_SESSION['id_usuario']);
		//print_r($datos);
		if(count($datos)==0)
		{
			$data[]=$_REQUEST['tipo_data'];
			$data[]=$_REQUEST['id'];
			addFavoritos($data);
			?>
			<script>
				showMensaje("Agregado a Favoritos");
			</script>
			<?php
		}else
		{
			?>
			<script>
				showMensaje("Punto ya agregado a favoritos.");
				
				</script>
			<?php
		}
		
		
	}elseif($_REQUEST['tipo']==8) //edit usuario
	{
	
		$data[]=$_REQUEST['nombre'];
		$data[]=$_REQUEST['cl'];
		updateUsuario($_REQUEST['ml'],$data);
		?>
		<script>
			var capaContenedora = document.getElementById("reg_modal_us");
		  capaContenedora.innerHTML="<?=$CM_USUARIO_EDIT?>";
			setTimeout("closeModalInicio();",4000);
		</script>
		<?php
	}elseif($_REQUEST['tipo']==9) //cerrar usuario
	{
		updateEstadoUsuario($_REQUEST['ml'],2);
		?>
		<script>
			var capaContenedora = document.getElementById("reg_modal_us");
		  capaContenedora.innerHTML="<?=$CM_USUARIO_CLOSE?>";
			setTimeout("closeModalInicio();",4000);
		</script>
		
		
		<?php
		cerrar_sesion();
		?>
		<script>
				window.location.href="<?=$CM_path_base2?>";
			</script>
		<?php
	
	}elseif($_REQUEST['tipo']==10) //eliminar fav
	{
		eliminarFav($_REQUEST['id_fav']);
	}elseif($_REQUEST['tipo']==11)//cargar fav en modal
	{
				$datos=getFavoritoXUsuario($_REQUEST['id_usuario']);
				if(count($datos)>0)
				{

?>        
			  <ul id="favoritos">
			  	<?php
			  	foreach($datos as $dat)
			  	{
			  	
			  	if($dat[2]==1)
			  	{
			  		$data_serv=getDireccionXId($dat[3]);  			  		
			  	  $tipo="DIRECCION";
			  	  
			  	  $direccion="".ucwords($data_serv[5])." #".$data_serv[6]."";
			  	  $titulo=$direccion;
			  		$id_pto=$dat[3];  
			  		$lat=$dat[5];
			  		$lon=$dat[6];
			  		$comuna=ucwords(strtolower($data_serv[7]));
			  	  
			  	}
			  	
			  	elseif($dat[2]==2)  
			  	{
			  		$data_serv=getServicioXId($dat[3]);  			  		
			  	  $tipo="LUGAR";
			  	  $titulo=ucwords(strtolower($data_serv[1]));
			  	  $direccion="".ucwords($data_serv[5])." #".$data_serv[6]."";
			  		$id_pto=$dat[3];  
			  		$lat=$dat[5];
			  		$lon=$dat[6];
			  		$comuna=ucwords(strtolower($data_serv[7]));
			  	}
			  	elseif($dat[2]==3)  
			  	{
			  		$data_serv=getServicioPagoXId($dat[3]);  			  		
			  	  $tipo="LUGAR";
			  	  $titulo=ucwords(strtolower($data_serv[1]));
			  	  $direccion="".ucwords($data_serv[5])." #".$data_serv[6]."";
			  		$id_pto=$dat[3];  
			  		$lat=$dat[5];
			  		$lon=$dat[6];
			  		$comuna=ucwords(strtolower($data_serv[7]));
			  	}  
			  	
			  	$texto ="<div id=titulo2>".$titulo."</div>";
					
					$texto .="<div id=titulo5>".$direccion."</div>";
					$texto .="<div id=titulo6>".ucwords($data_serv[7])."</div>";			
					$texto .="<div id=botonera><img class=img_boton src=images/favorito.png title=Agregar a favoritos onclick=javascript:addFavorito(".$estado_ses.",".$id_pto.",2);><img class=img_boton src=images/mail.png title=Enviar por correo><img class=img_boton src=images/facebook.png title=Compartir en Facebook onclick=javascript:compartirFace();> <img class=img_boton src=images/twitter.png title=Compartir en Twitter></div>";
					$texto .="<div id=botonera><img class=img_boton src=images/favorito.png title=Agregar a favoritos onclick=javascript:addFavorito(".$estado_ses.",".$data_serv[0].",1);><img class=img_boton src=images/mail.png title=Enviar por correo onclick=compartirPto(".$data_serv[0].",1);><img class=img_boton src=images/facebook.png title=Compartir en Facebook onclick=javascript:compartirFace(**".$CM_path_base2."&ptot=1&pto=".$data_serv[0]."**);> <a href=**https://twitter.com/share?url=".$CM_path_base2."?ptot=1&pto=".$data_serv[0]."&via=chilemap&text=Revisa este link** target=_BLANK><img  class=img_boton src=images/twitter.png title=Compartir en Twitter></a></div>";
			
			  		?>
			  		<li>
			  			<div id="fav_titulo" onclick='javascript:addMarcador("<?=$CM_ICONO_SERV?>","35,35",<?=$lat?>,<?=$lon?>,"<?=$texto?>","<?=$titulo?>");moverCentro(<?=$lat?>,<?=$lon?>,17);'><?=$titulo?></div>
			  			<div id="fav_nombre"><?=$tipo?></div>
			  			<div id="fav_direccion"><?=$direccion?>, <?=$comuna?></div>
			  		<ul id="ico_favo">
			  				<li><img title="Cargar en el mapa" src="iconos/ver2.png" onclick="javascript:addMarcador('<?=$CM_ICONO_SERV?>','35,35',<?=$lat?>,<?=$lon?>,'<?=$texto?>','<?=$titulo?>');moverCentro(<?=$lat?>,<?=$lon?>,17);"></li>
			  				<!--li><img title="Enviar por mail" src="iconos/correo.png"></li-->
                            <li><img title="Eliminar" onclick="javascript:delFav(<?=$dat[0]?>,<?=$_REQUEST['id_usuario']?>);" src="iconos/eliminar.png"></li>
			  			</ul>	
			  			
			  		</li>
			  	<?php
			  	}
			  	?>
			  
			  </ul>     
			<?php
		}else
		{
			echo "No hay favoritos.";
		}
	}elseif($_REQUEST['tipo']==12)
	{
	
		addQuery($_REQUEST['q']);
	}elseif($_REQUEST['tipo']==13)//carga banner
	{
		$banners=getBanner();
		if(count($banners)>0)
		{
			?>
			<script>
				//alert("busco");
			 	
				 	swfobject.embedSWF("<?=$banners[5]?>", "swf_div", "332", "80", "9.0.0", "js/expressInstall.swf",var1,var2,var3);
				</script>
			<?php
		}
	}elseif($_REQUEST['tipo']==14)//load ciudad
	{
		//echo $_REQUEST['region'];
		$comuna=getComunaxRegion($_REQUEST['region']);
		foreach($comuna as $com)
		{
		?>
		<option value="<?=strtolower($com[0])?>"><?=ucwords(strtolower($com[0]))?></option>
		<?php
		}
	}elseif($_REQUEST['tipo']==15)//busca direccion lugar
	{
		$query="".$_REQUEST['calle']." ".$_REQUEST['numero']." ".$_REQUEST['comuna']."";
		$direcciones=getDireccion($query,10);
		if(count($direcciones)>0)
		{
			?>
			<option value=0>Selecciona una direccion</option>
			<?php
				foreach($direcciones as $direc)
				{
				?>
				<option value=<?=$direc[7]?>,<?=$direc[6]?>><?=ucwords($direc[8])?></option>
				<?php
				}
		 }else
		 {
		 	  $direcciones=getDireccionGoogle($query);
		 	  //print_r($direcciones);
		 	  if(count($direcciones)>0)
		 	  {
		 	  	?>
		 	  	<option value=0>Selecciona una direccion</option>
					<?php
					foreach($direcciones as $direc)
					{
					?>
					<option value=<?=$direc[8]?>,<?=$direc[7]?>><?=ucwords($direc[3])?> #<?=ucwords($direc[2])?>, <?=ucwords($direc[4])?></option>
					<?php
					}
				}else
				{
					$direcciones=buscarDireccionOSM($query);
		 	  	//print_r($direcciones);
		 	 		if(count($direcciones)>0)
		 	 		{
		 	 			?>
		 	 			<option value=0>Selecciona una direccion</option>
							<?php
							foreach($direcciones as $direc)
							{
							?>
							<option value=<?=$direc[0]?>,<?=$direc[1]?>><?=ucwords($direc[3])?> #<?=ucwords($direc[2])?>, <?=ucwords($direc[4])?></option>
							<?php
							}
					}else
					{
							?>
								<script>
									
									showAlerta("Direccion no encontrada!",3000);
									
								</script>
							<?php
					}
				}
		 }
		
	}elseif($_REQUEST['tipo']==16)//addLugarUsuario
	{
		$data=array();
		$data[]=strtolower($_REQUEST['calle']);
		$data[]=strtolower($_REQUEST['numero']);
		$data[]=strtolower($_REQUEST['lat']);
		$data[]=strtolower($_REQUEST['lon']);
		$data[]=strtolower($_REQUEST['comuna']);
		$com=getComuna($_REQUEST['comuna']);
		$data[]=strtolower($com[1]);
		$reg=getRegionxId(trim($_REQUEST['region']));
		$data[]=strtolower($reg[0]);
		$data[]=$_REQUEST['region'];
		$cat=getCategoriaxId($_REQUEST['categoria']);
		$data[]=strtolower($cat[1]);
		$data[]=$_REQUEST['categoria'];
		$data[]=strtolower(trim($_REQUEST['lugar']));
		
		$data[]=strtolower(trim($_REQUEST['lugar']))." ".strtolower(trim($_REQUEST['calle']))." ".strtolower(trim($_REQUEST['numero']))." ". strtolower(trim($_REQUEST['comuna']))." ".strtolower(trim($reg[0]));
		$data[]=4; //usuario
		$data[]=0;
		
		$data[]='';
		$data[]='';
		$data[]='';
		$data[]=0;
		
		addServicioLibre($data);
		?>
		<script>
			CloseModalGrilla();
			showAlerta("Tu lugar ha sido almacenado!",3000);
			
		</script>
		<?php
	}
}

?>