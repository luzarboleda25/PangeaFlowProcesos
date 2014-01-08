<meta http-equiv="Content-Type" content="text/html charset=utf-8" />
<?php
  try {
  include("../lib/funciones.php");
  require_once('../lib/nusoap.php'); 
  $wsdl_url = 'http://localhost:15362/CapaDeServiciosAdmin/GestionDeControlDeUsuarios?WSDL';
  $client = new SOAPClient($wsdl_url);
  $client->decode_utf8 = false; 
 
if (isset($_POST["Biniciar"])) {
javaalert("entro");
	 	if(isset($_POST["usuario"]) && $_POST["usuario"]!="" && isset($_POST["password"]) && $_POST["password"]!="" ){	 
			    $sesion= array('idUsuario' => $_POST["usuario"],'ip'=>'127.0.0.1','borrado'=>'0');
				$resultadoLogueo = $client->LogIn($sesion);
				echo '<pre>';print_r($resultadoLogueo); 
	    }
	}	
  include("../views/index.php");
  } catch (Exception $e) {
	javaalert('Lo sentimos no hay conexión');
	//iraURL('../views/index.php');	
	}
?>
