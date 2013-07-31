<?php
	class DAOService {
		//Nombre del servicio, usado para vincularlo a su clase DAO
		protected $serviceName;
		protected $daoName;
		
		public function __construct($servicename){
			$this->serviceName = $servicename;
			$this->daoName = $this->serviceName . 'DAO';
			
			// Comprobamos que la clase DAO existe
			if (!class_exists($this->daoName)){
				throw new ServiceNotFoundException("Servicio {$this->serviceName} no encontrado", -1);
			}
		}
		
		/**
		 * Método GET del servicio
		 * 
		 * @param unknown $param
		 * @return unknown
		 */
		public function  get($param){
			$daoClass = $this->daoName;
			$dao = new $daoClass();
			$result = $dao->get($param);
			return $result;
		}
		
		/**
		 * Método POST del servicio
		 * 
		 * @param unknown $param
		 * @throws RestOperationNotImplementedException
		 */
		public function  post($param){
			throw new RestOperationNotImplementedException("Método POST no implementado para el servicio " . $this->serviceName);
		}
		
		/**
		 * Método PUT del servicio
		 * 
		 * @param unknown $param
		 * @throws RestOperationNotImplementedException
		 */
		public function  put($param){
			throw new RestOperationNotImplementedException("Método PUT no implementado para el servicio " . $this->serviceName);
		}
		
		/**
		 * Método DELETE del servicio
		 * 
		 * @param unknown $param
		 * @throws RestOperationNotImplementedException
		 */
		public function  delete($param){
			throw new RestOperationNotImplementedException("Método DELETE no implementado para el servicio " . $this->serviceName);
		}
}

?>