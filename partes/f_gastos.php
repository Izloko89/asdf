<?php session_start(); 
include("../scripts/funciones.php");
include("../scripts/func_form.php");
include("../scripts/datos.php");
?>
<script >

$(document).ready(function(e) {
	$("#gra").click(function(e) {
	  if(requerido()){
		term = document.getElementById("nombre").value;
		//datos de los formularios
		//procesamiento de datos
		$.ajax({
			url:'scripts/s_guardar_gastos.php',
			cache:false,
			async:false,
			type:'POST',
			data:{
				'term':term
			},
			success: function(r){
				if(r){
					alerta("info","Registro añadido satisfactoriamente");
					ingresar=true;
					$("#formularios_modulo").hide("slide",{direction:'right'},rapidez,function(){
						$("#botones_modulo").fadeIn(rapidez);
					});
				}else{
					alerta("error","ocurrio un error al agregar el registro");
				}
			}
		});
	  }//if del requerido
    });
	
    $(".volver").click(function(e) {
		ingresar=true;
    	$("#formularios_modulo").hide("slide",{direction:'right'},rapidez,function(){
			$("#botones_modulo").fadeIn(rapidez);
		});
    });
});

function get_items_cot(id){
	$(".lista_articulos").remove();
	$.ajax({
		url:'scripts/get_items_gastos.php',
		cache:false,
		async:false,
		data:{
			'id_cotizacion':id
		},
		success: function(r){
			$("#articulos").append(r);
		}
	});
}

function requerido(){
	selector=".requerido";
	continuar=true;
	$.each($(selector).parent().find(".requerido"),function(i,v){
		if($(this).val()==""){
			$(this).addClass("falta_llenar");
			continuar=false;
		}
	});
	return continuar;
}

function eliminar_gasto(elemento, id_item){
		$.ajax({
			url:'scripts/eGasto.php',
			cache:false,
			type:'POST',
			data:{
				'id_item':id_item
			},
			success: function(r){
			  if(r){
				document.getElementById("tableEve").deleteRow(elemento);
					alerta("info","<strong>Tipo de Evento</strong> Eliminado");
					ingresar=true;
					$("#formularios_modulo").hide("slide",{direction:'right'},rapidez,function(){
						$("#botones_modulo").fadeIn(rapidez);
					});
			  }else{
				alerta("error", r);
			  }
			}
		});
	}
	
</script>
<style>
#f_tipo_evento .guardar_individual{
	position:relative;
}
#f_tipo_evento .modificar{
	position:relative;
}
.salon{
	padding:5px 10px;
	margin-right:10px;
	margin-bottom:10px;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	display:inherit;
	font-weight:bold;
}
.eliminar_tevento{
	background: blue url('img/cruz.png') left center no-repeat;
	background-size:contain;
	cursor:pointer;
	width:20px;
	height:20px;
	display:inherit;
	margin-right:10px;
}
</style>
<form id="f_tipo_evento" class="formularios">
  <h3 class="titulo_form">Tipo de gasto</h3>
  	<input type="hidden" name="id_tipo" class="id_tipo" id="id_tipo" value="" />
    <div class="campo_form">
        <label class="label_width">Concepto</label>
        <input type="text" name="nombre" id="nombre" class="nombre text_mediano">
    </div>
   	<div align="right">
        <input type="button" class="guardar_individual guardar" id="gra" value="GUARDAR" data-m="individual" />
        <input type="button" class="modificar" value="MODIFICAR" style="display:none;" />
        <input type="button" class="nueva" value="NUEVA" />
    </div>
    
</form>
<table id="tableEve">
<tr><td><h2>Tipo de Gasto</h2></td></tr>
<?php
	try{
		$bd=new PDO($dsnw,$userw,$passw,$optPDO);
		$id_empresa=$_SESSION["id_empresa"];
		$res=$bd->query("SELECT * FROM gastos WHERE id_empresa=$id_empresa;");
		$cont = 1;
		foreach($res->fetchAll(PDO::FETCH_ASSOC) as $v){
			echo '<tr class="salon fondo_azul" ><td ><div align="left" >'.$v["nombre"].'</div></td><td colspan="2" align="right"><span class="eliminar_tevento" onclick="eliminar_gasto('. $cont .',' . $v["id_gasto"] . ')"/></td></tr>';
			$cont++;
		}
	}catch(PDOException $err){
		echo '<tr><td colspan="20">Error encontrado: '.$err->getMessage().'</td></tr>';
	}
?>
</table>
<div align="right">
    <input type="button" class="volver" value="VOLVER">
</div>