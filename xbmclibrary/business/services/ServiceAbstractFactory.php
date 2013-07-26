<?php
	class ServiceAbstractFactory {
		public static function getService($serviceName){
			$service = null;
			
			switch ($serviceName){
				case XBMCLibraryConstants::MOVIES_SERVICE_NAME:
					$service = new DAOService(XBMCLibraryConstants::MOVIES_SERVICE_NAME);
					break;
				case XBMCLibraryConstants::TVSHOWS_SERVICE_NAME:
					$service = new DAOService(XBMCLibraryConstants::TVSHOWS_SERVICE_NAME);
					break;
				default: 
					throw new ServiceNotFoundException("Servicio {$serviceName} no encontrado", -1);
			}
			
			return $service;
		}
	}
?>