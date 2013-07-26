<?php
	include_once "AutoClassLoader.php";
	
	//Obtenemos de la petici�n el m�todo HTTP y la URI
	$method = $_SERVER['REQUEST_METHOD'];
	$uri = $_SERVER['REQUEST_URI'];
	
	//Obtenemos cada elemento de la URI en un array
	$uriParts = explode("/", $uri);
	
	//Eliminamos del array el contexto de la aplicaci�n y del controlador
	$isControllerPath = false;
	while((!$isControllerPath)||(count($uriParts)==0)){
		$isControllerPath = ($uriParts[0]==XBMCLibraryConstants::REST_CONTROLLER_CONTEXTPATH); 
		array_shift($uriParts);
	}
	
	//Obtenemos de la uri el nombre del servicio 
	$serviceName = $uriParts[0];
	
	//Obtenemos el servicio utilizando la factor�a
	try{
		$service = new DAOService($serviceName);
	
		//Eliminamos de los elementos de la uri el nombre del servicio, dejando as� s�lo los par�metros
		array_shift($uriParts);
		
		//Ejecutamos la operaci�n REST que corresponda con el m�todo.
		switch ($method){
			case "GET":
				$result = $service->get($uriParts);
				break;
			case "POST":
				$result = $service->post($uriParts);
				break;
			case "PUT":
				$result = $service->put($uriParts);
				break;
			case "DELETE":
				$result = $service->delete($uriParts);
				break;
		}
	}catch(Exception $e){
		$result = new RestError();
		$result->codigo = $e->getCode();
		$result->mensaje = utf8_encode($e->getMessage());
	}
	
	echo json_encode($result);
?>