
<div id="modal2" >
	<div id="sub_modal" >
 <a href="javascript:closeModalInicio();"class="close2"><img src="images/cerrar.png" /></a>
		<section id="reg_modal" class="MO">
        
        <H2>Mis Favoritos!</H2>
        <?php
        session_start();
        
        ?>
      </br></br>
      <div id="cont_favo">
      	<script>
      		loadFavoritos(<?=$_SESSION['id_usuario']?>);
      		</script>
			</div>
		</section>
		<div id="msg_fav"></div>
	</div>
</div>