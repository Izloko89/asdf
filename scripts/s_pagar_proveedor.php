<?php session_start();
header("content-type: application/json");
include("datos.php");
$eve=$_SESSION["id_empresa"];
$monto=$_POST["monto"];
$fecha=$_POST["fecha"];
$cliente=$_POST["cliente"];

try{
	$sql="INSERT INTO `proveedores_movimientos`(`id_empresa`, `id_proveedor`, `movimiento`, `id_ref`, `cantidad`, `fecha`)
	VALUES ($eve, $cliente,'pago', 1, '$monto', '$fecha');"; 	
	
	$bd=new PDO($dsnw,$userw,$passw,$optPDO);
	
	$bd->query($sql);
	$r["continuar"]=true;
}catch(PDOException $err){
	$r["continuar"]=false;
	$r["info"]="Error: ".$err->getMessage();
}

echo json_encode($r);
?>