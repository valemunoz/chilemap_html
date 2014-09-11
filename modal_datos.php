<?PHP
require_once("includes/funciones.php");
require_once ('includes/mensajes.php');

?>
<div id="modal2" >
	
 <?php
	session_start();
 $data_usuario=getUsuario($_SESSION["usuario"],0);
 //print_r($data_usuario);
 for($i=0;$i< strlen($data_usuario[5]);$i++)
 {
 	$pass .="*";
	}
 ?>
 <a href="javascript:closeModalInicio();" class="close2"><img src="images/cerrar.png" /></a>
		<section id="reg_modal_us" class="MO">
        
        <H2>Mis Datos!</H2>
        <br />
				<br />
				<div id="login-box-name">Nombre:</div>
				<div id="login-box-field"><input name="nombre" id="nombre" class="form-modal" title="Username" value="<?=$data_usuario[2]?>" size="30" maxlength="2048" /></div>      

				<div id="login-box-name">Mail:</div>
				<div id="login-box-field"><input name="ml" id="ml" class="form-modal" title="Email" value="<?=$data_usuario[3]?>" size="30" maxlength="2048" /></div>      
<div id="login-box-name">Contrase&#241;a:</div>
				<div id="login-box-field"><input name="cont" id="cont" readonly=true type="password" class="form-modal" title="Username" value="<?=$pass?>" size="30" maxlength="2048" /></div>      
				<div id="login-box-name">Nueva Contrase&#241;a:</div>
				<div id="login-box-field"><input name="contn" id="contn" class="form-modal" title="Username" value="" size="30" maxlength="2048" /></div>      
				<div id="login-box-name">Repita Contrase&#241;a:</div>
				<div id="login-box-field"><input name="contn2" id="contn2"  class="form-modal" title="Username" value="" size="30" maxlength="2048" /></div>      
				<br/>
				<br/>
				<div id="msg_datos" class="msg_varios">
				</div>
				<a href="javascript:editUser();" border="0" class="btn">Guardar!</a>
				<a href="javascript:closeUser('<?=$data_usuario[3]?>');" border="0" class="btn">Cerrar Cuenta</a>
			
		</section>
	
</div>