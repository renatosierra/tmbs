<?php
	require_once '../../models/Rol.php';	 
	$request_body = file_get_contents('php://input');
	$request = json_decode($request_body);
	$data = get_object_vars($request);
	switch ($data['action']) {
	    case "insert":
	    	$rol = new Rol();
	    	if(isset($data['rolName'])){
		    	$rol -> insertRol($data['rolName']);
		        echo json_encode($rol);
	        }else{
	        	echo '{"success":false}';
	        }
	        break;
	    case "1":
	        echo "i es igual a 1";
	        break;
	    case "2":
	        echo "i es igual a 2";
	        break;
	}
?>