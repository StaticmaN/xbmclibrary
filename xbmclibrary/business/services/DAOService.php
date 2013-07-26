<?php
	class DAOService {
		//Nombre del servicio, usado para vincularlo a su clase DAO
		protected $serviceName;
		protected $daoName;
		
		public function __construct($servicename){
			$this->serviceName = $servicename;
			$this->daoName = $this->serviceName . 'DAO';
		}
		
		/**
		 * Método GET del servicio
		 * 
		 * @param unknown $param
		 * @return unknown
		 */
		public function  get($param){
			if(count($param)==0){
				$result = $this->getList();
			}else{
				$result = $this->getSingle($param[0]);
			}
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
		
		protected function getList(){
			$daoClass = $this->daoName;
			$result = $daoClass::getResources();
			return $result;
		}
		
		protected function getSingle($id){
			$daoClass = $this->daoName;
			$result = $daoClass::getResource($id);
			return $result;
		}
}

?>