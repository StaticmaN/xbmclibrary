<?php
	include_once "AbstractService.php";
	include_once "../config/XBMCLibraryConstants.php";
	include_once "../business/LibraryOperations.php";
	include_once "../exceptions/RestOperationNotImplementedException.php";

	class MoviesService extends AbstractService{		
		public function  get($param){
			if(count($param)==0){
				$result = LibraryOperations::listDirectory(XBMCLibraryConstants::$MOVIES_SERVICE_DIRECTORY);
			}else{
				$result = array('consulta de un registro concreto');
			}
			return $result;
		}
		
		public function  post($param){
			throw new RestOperationNotImplementedException("M�todo POST no implementado para el servicio " . XBMCLibraryConstants::$MOVIES_SERVICE_NAME);
		}
		
		public function  put($param){
			throw new RestOperationNotImplementedException("M�todo PUT no implementado para el servicio " . XBMCLibraryConstants::$MOVIES_SERVICE_NAME);
		}
		
		public function  delete($param){
			throw new RestOperationNotImplementedException("M�todo DELETE no implementado para el servicio " . XBMCLibraryConstants::$MOVIES_SERVICE_NAME);
		}
	}
?>