<?php
	require_once './../../models/Agenda.php';	
	require_once './../../models/Usuario.php';	 
	$request_body = file_get_contents('php://input');
	$request = json_decode($request_body);
	$data = get_object_vars($request);
	switch ($data['action']) {

	    case "insert":
	    	if(isset($data['agenda'])){
	    		$gasto = new Agenda();
		     	$objGasto = $gasto -> newEvent($data['agenda']);
		     	$result = $objGasto[0];
		     	echo json_encode($result);
		     }
	        break;
	    case "query":
		        $gasto = new Agenda();
		       	$usuario = new Usuario();   
                $u = $_SESSION['usuario'];
                $id_u = $u[0]['id_usuario'];
                $cambiar_usuario="false";
                $contador = count($_SESSION['permisos']);
                $arreglo = $_SESSION['permisos'];
	              for($c=0;$c<$contador;$c++){
	                    switch($arreglo[$c]['nombre']){
	                        case "UsuarioCitas":
	                            $cambiar_usuario = "true";
	                            break;
	                    }
	              }
                  
                  if($cambiar_usuario==="true"){
                    $objGasto = $gasto -> getCitas();
                    $objUsuario = $usuario -> getUsers();
                  }else{
                    $objGasto = $gasto ->getCitasxId($id_u);
                    $objUsuario = $usuario ->getUsersbyId($id_u);
                  }

		        echo '{"usuarios":'.json_encode($objUsuario).',"citas":'.json_encode($objGasto).'}';
	    	break;
	    case "update":
	        $gasto = new Agenda();
	        if(isset($data['agenda'])){
	        	$updatedGasto = get_object_vars($data['agenda']);
	        	$objUser = $gasto -> updateAgenda($updatedGasto);
	        	echo json_encode($objUser);
	        }
	        break;
	    case "delete":
		    $gasto = new Agenda();
		    if(isset($data['gasto'])){
		    	$deleteSpend = get_object_vars($data['agenda']);
	        	$objGasto = $gasto -> deleteCita($deleteSpend['id_agenda']);
	        	echo json_encode($objGasto);
		    }
		        break;
	}
?>