var path_query="includes/query.php";
var SIS_LON=0;
var SIS_LAT=0;
var bar2="";

var SIS_ACCU=0;
var SIS_CALLE="";
var SIS_NUM="";
var SIS_COMUNA="";

var SIS_NOM="";
var SIS_CALL="";
var SIS_NM="";
var SIS_COM="";
var SIS_DESC="";
var SIS_CATEG="";

var CM_farma_turno=false;
var ADDPTO=0;

//document.addEventListener("offline", onready, false);
//document.addEventListener("online", onready, false);
document.addEventListener("deviceready", deviceListo, false);
function deviceListo()
{
	//document.getElementById('qr').value="";
	addServicios('Bancos',1000,'4','img/banco.png');
	bar2="";
	$("#output").load(path_query, 
				{tipo:6} 
					,function(){	
						
										
			
					}
			);
			
}
function deviceListo2()
{
	$("#output").load(path_query, 
				{tipo:9} 
					,function(){	
										
			
					}
			);
}
function loadInicioSesion()
{
	//$.mobile.changePage('#mod_inicio', { role: 'dialog'});
	$.mobile.changePage('#mod_inicio', { role: 'dialog'});
}
function volver()
{
	
	
	history.go(-1);
}
function loadInicio()
{
	//window.location="home.html";
	var mail=$.trim(document.getElementById("mail").value);
	var clave=$.trim(document.getElementById("clave").value);
	if(mail !="" && clave!="" && validarEmail(mail))
	{
	$.mobile.loading( 'show', {
			text: 'Cargando...',
			textVisible: true,
			theme: 'a',
			html: ""
		});
		$("#msg_error_reg").load(path_query, 
			{tipo:7,mail:mail,clave:clave} 
				,function(){	
				
					$.mobile.loading( 'hide');
					
				}
		); 
	}else
		{
			//mensaje("Todos los campos obligatorios","myPopup_reg");
			$("#msg_error_reg").html("Todos los campos obligatorios");
		}
}

function loadMapa()
{
	//init('-70.444','-30.988',15);
	init();
	moverCentro(-33.458943,-70.656235,12);
}
function ubicacionActual()
{
	
	$.mobile.loading( 'show', {
				text: 'Obteniendo Coordenadas...',
				textVisible: true,
				theme: 'a',
				html: ""
			});
			
	navigator.geolocation.getCurrentPosition (function (pos)
		{
			var lat = pos.coords.latitude;
  		var lng = pos.coords.longitude;
  		var accu=pos.coords.accuracy.toFixed(2);
  		
  		SIS_LON=lng;
  		SIS_LAT=lat;
  		SIS_ACCU=accu;
  	  //addMarcadores(lng,lat,'Ubicacion Actual','img/marker.png',30,30);
  	  moverCentro(lat,lng,15);
  	  
  	  //verPuntosDrag();
  	  //activarDrag();

  	  
			

			$("#output").load(path_query, 
			{tipo:2,lat:lat,lon:lng} 
				,function(){	
					addMarcadores(lng,lat,'<div class=titulo>Cerca de</div><div class=titulo_pop2>'+SIS_CALLE+' #'+SIS_NUM+'<br> '+SIS_COMUNA+'</div>','img/marker.png',35,35);
					$.mobile.loading( 'hide');
				}
		);
		
			
			},noLocation,{timeout:6000});
}

function noLocation()
{
	$.mobile.loading( 'hide');
	
	mensaje("Error en la geolocalizaci&oacute;n","myPopup");
	
}


function mensaje(texto,div)
{
	$( "#"+div ).html("<p>"+ texto+"</p>" );
                  $("#"+div).popup("close");
                  $("#"+div).popup("open");
}
function hideMensaje(div)
{
	  $("#"+div).popup("close");
}



function limpiarMapa()
{
	limpiarPuntosDrag();
	deleteTransantiago();
	deleteServicioMapaPagos(100);
	deleteMarcadores();
	$("#list_bus").html("");
			for(i=0;i<CM_servicios.length;i++)
			{
				
				deleteServicioMapa(i);
			}
}


function cerrarSesion()
{
	$("#output").load(path_query, 
				{tipo:8} 
					,function(){	
			
  	window.location.href="index.html";
					
			
					}
			);
	
}
function validarEmail( email ) {
	  var valido=true;
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(email) )
        valido=false;
        
   return valido;     
}

function buscar()
{
		var CM_centro= map.getCenter().transform(
        new OpenLayers.Projection("EPSG:900913"), // de WGS 1984
        new OpenLayers.Projection("EPSG:4326") // a Proyección Esférica Mercator
      );
      
      if(SIS_LON==0 || SIS_LAT==0)
      {
      	lon=CM_centro.lon;
      	lat=CM_centro.lat;
      }else
      	{
      		lon=SIS_LON;
      		lat=SIS_LAT;
      	}
	var qr=$.trim(document.getElementById("qr").value);
	var bus=1;
	$( '#tot_dir' ).html( '' );
	$( '#tot_pto' ).html( '' );
	if(qr!="")
	{
		$.mobile.loading( 'show', {
					text: 'Buscando...',
					textVisible: true,
					theme: 'a',
					html: ""
				});
		$("#list_bus").load(path_query, 
				{tipo:10,query:qr,bus:bus,lon:lon, lat:lat} 
					,function(){	
							
						//$('#cola_bus').trigger('create');
						$('#list_bus').listview('refresh');
			
					}
			);
			$("#list_bus2").load(path_query, 
				{tipo:3,query:qr,lon:lon, lat:lat} 
					,function(){	
						$.mobile.loading( 'hide');	
						//$('#cola_bus').trigger('create');
						$('#list_bus2').listview('refresh');
			
					}
			);
	}else
		{
			mensaje("Debe ingresar una consulta","myPopup");
		}
		
		
}

function verMapa(texto,lon,lat,icono)
{
	
	moverCentro(lat,lon,15);
  addMarcadores(lon,lat,texto,icono,30,30);
}
function loadCategorias()
{
	$("#list_cat").load(path_query, 
				{tipo:11} 
					,function(){	
							
						//$('#cola_bus').trigger('create');
						$('#list_cat').listview('refresh');
						
  	
					
			
					}
			);
}

function loadCategMapa(categ)
{
	
	
	$("#list_bus").load(path_query, 
				{tipo:12, cat:categ} 
					,function(){	
						$('#list_bus').listview('refresh');
						verPuntosDrag();
					}
			);
}

function senContacto()
{
	var mail=$.trim(document.getElementById("mail").value);
	var nom=$.trim(document.getElementById("nom").value);
	var tel=$.trim(document.getElementById("tel").value);
	var descrip=$.trim(document.getElementById("descrip").value);
	
	if(mail !="" && nom!="" && validarEmail(mail) && descrip!="")
	{
		$("#output").load(path_query, 
				{tipo:13, mail:mail,nom:nom,tel:nom,descrip:descrip} 
					,function(){
						$("#mod_contacto").dialog("close");	
						setTimeout('mensaje("Mensaje Enviado.","myPopup");',500);
						
						
					}
			);
		
	}else
		{
			$("#msg_error_contacto").html("Nombres, mail y descripci&oacute;n son campos obligatorios.");
		}
}
function regUser()
{
	
	var nombre=document.getElementById("nombre").value;
	var clave=$.trim(document.getElementById("clave_regi").value);
	var mail=document.getElementById("mail_regi").value;
	var newsletter=document.getElementById("envio").checked;
	var msg="";
	var valida=true;
	
	if($.trim(nombre)=="" || $.trim(clave)=="" || $.trim(mail)=="")
	{		
		valida=false;
		msg="<strong>Todos los campos son obligatorios.</strong><br>";
	}
	if(!validarEmail(mail))
	{		
		msg=""+msg+" <strong>E-mail debe tener formato correcto.</strong><br>";
		valida=false;
	}
	if(clave.length != 6)
	{		
		msg=""+msg+" <strong>La clave debe contener 6 caracteres.</strong><br>";
		valida=false;
	}
	
	if(!valida)
	{
		var capaContenedora = document.getElementById("msg_error_registro");
		capaContenedora.innerHTML=msg;
		
	}else
	{
		
		$("#msg_error_registro").load(path_query, 
			{tipo:14, nombre:""+nombre+"", clave:""+clave+"", mail:""+mail+"", tipo_usuario:1,news:newsletter, pais:"Chile"} 
				,function(){	
				}
		);
	}
}
function msgActivacion()
{
	var mail=document.getElementById("mail").value;
$("#output").load("confirmacion.php", 
			{tipo:1, mail:mail} 
				,function(){	
				}
		);
}