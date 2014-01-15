<meta http-equiv="Content-Type" content="text/html charset=utf-8" />
<?php
session_start();
//try {
include("../lib/funciones.php");
require_once('../lib/nusoap.php');

if(isset($_POST["procesar"])){
	iraUrl("index.php");	
}

include("../views/terminoProceso.php");

if($_SESSION["sesionUsuario"]!="" && $_SESSION["usuario"]!="" && $_SESSION["instancia"]!="" && $_SESSION["siguienteTarea"]!=""){
	echo '<br>Resultado de Finalizar Actividad:<pre>';print_r($_SESSION["resultadoFinActividad3"]);
}

/*} catch (Exception $e) {
	javaalert('Lo sentimos no hay conexión');
	iraURL('../views/index.php');
}*/
?>