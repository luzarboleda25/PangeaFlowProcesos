<?php

function iraURL($url){
	$ini='<script language="javascript">
				window.location = "';
	$fin='"; </script>';
	
	echo $ini.$url.$fin;
}

//alertas
function javaalert($msj){
	$ini='<script language="javascript">	alert("';
	$fin='"); </script>';
	echo $ini.$msj.$fin;
}

?>