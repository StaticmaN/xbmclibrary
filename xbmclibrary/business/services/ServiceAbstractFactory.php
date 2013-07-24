<?php
	class ServiceAbstractFactory {
		public static function getService($serviceName){
			$service = null;
			
			switch ($serviceName){
				case XBMCLibraryConstants::MOVIES_SERVICE_NAME:
					$service = new MoviesService();
					break;
				case XBMCLibraryConstants::TVSHOWS_SERVICE_NAME:
					$service = new TVShowsService();
					break;
				default: 
					throw new ServiceNotFoundException("Servicio {$serviceName} no encontrado", -1);
			}
			
			return $service;
		}
	}
?>