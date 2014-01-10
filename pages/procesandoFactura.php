<meta http-equiv="Content-Type" content="text/html charset=utf-8" />
<?php
  include("../lib/funciones.php");
  require_once('../lib/nusoap.php');
  
	//Codigo para guardar
	if(isset($_POST["procesar"])){
		
		if(isset($_POST["descripcion"]) && isset($_POST["monto"])		 
			&& $_POST["descripcion"]!="" && $_POST["monto"]!=""){
				
				$descripcion = $_POST["descripcion"];
				$monto = $_POST["monto"];
				
				javaalert("Datos Procesados");			
		}		
	}
	
include("../views/procesandoFactura.php");
?>
