<?php
	include_once "AbstractService.php";
	include_once "../config/XBMCLibraryConstants.php";
	include_once "../exceptions/RestOperationNotImplementedException.php";

	class TVShowsService extends AbstractService{
		public function  get($param){
			if(count($param)==0){
				$result = LibraryOperations::listDirectory(XBMCLibraryConstants::$TVSHOWS_SERVICE_DIRECTORY);
			}else{
				$result = array('consulta de un registro concreto');
			}
			return $result;
		}
		
		public function  post($param){
			throw new RestOperationNotImplementedException("Método POST no implementado para el servicio " . XBMCLibraryConstants::$TVSHOWS_SERVICE_NAME);
		}
		
		public function  put($param){
			throw new RestOperationNotImplementedException("Método PUT no implementado para el servicio " . XBMCLibraryConstants::$TVSHOWS_SERVICE_NAME);
		}
		
		public function  delete($param){
			throw new RestOperationNotImplementedException("Método DELETE no implementado para el servicio " . XBMCLibraryConstants::$TVSHOWS_SERVICE_NAME);
		}
	}
?>