<?php
	include_once "../model/exceptions/RestOperationNotImplementedException.php";

	abstract class AbstractService {
		protected $serviceName;
		
		/*
		 * Método GET del servicio
		*/
		public function  get($param){
			if(count($param)==0){
				$result = $this->getList();
			}else{
				$result = $this->getSingle($param);
			}
			return $result;
		}
		
		/*
		 * Método POST del servicio
		*/
		public function  post($param){
			throw new RestOperationNotImplementedException("Método POST no implementado para el servicio " . get_class($this));
		}
		
		/*
		 * Método PUT del servicio
		*/
		public function  put($param){
			throw new RestOperationNotImplementedException("Método PUT no implementado para el servicio " . get_class($this));
		}
		
		/*
		 * Método DELETE del servicio
		*/
		public function  delete($param){
			throw new RestOperationNotImplementedException("Método DELETE no implementado para el servicio " . get_class($this));
		}
		
		// Métodos abstractos a implementar por cada servicios
		protected abstract function getList();
		protected abstract function getSingle($id);
}

?>