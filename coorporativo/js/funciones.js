

function validaContacto()
{
	
	var nombre=document.getElementById("name").value;
	
	var mail=document.getElementById("email").value;
	var mensaje=document.getElementById("msg").value;
	//alert(nombre+"-"+telefono+"-"+mail+"-"+mensaje);
	var msg="";
	$("#msg_contacto").html(msg);
	var valida=true;
	if($.trim(nombre)=="" || $.trim(mail)=="" || $.trim(mensaje)=="")
	{		
		valida=false;
		msg="<strong>Los campos nombre,mail y mensaje son obligatorios.</strong><br>";
	}
	if(!validarEmail(mail))
	{		
		msg=""+msg+" <strong>E-mail debe tener formato correcto.</strong><br>";
		valida=false;
	}
	
	if(!valida)
	{
		
		
		$("#msg_contacto").html(msg);
		
	}else
	{
		
		$("#msg_contacto").load("query.php", 
			{tipo:1,nombre:nombre,mail:mail,msg:mensaje} 
				,function(){	
					$("#msg_contacto").html("Mensaje Enviado.");
				}
		);
	}
}

function validarEmail( email ) {
	  var valido=true;
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(email) )
        valido=false;
        
   return valido;     
}
