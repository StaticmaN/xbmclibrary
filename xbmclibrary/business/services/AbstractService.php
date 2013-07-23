<?php
	include_once "../model/exceptions/RestOperationNotImplementedException.php";

	abstract class AbstractService {
		protected $serviceName;
		
		/*
		 * M�todo GET del servicio
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
		 * M�todo POST del servicio
		*/
		public function  post($param){
			throw new RestOperationNotImplementedException("M�todo POST no implementado para el servicio " . get_class($this));
		}
		
		/*
		 * M�todo PUT del servicio
		*/
		public function  put($param){
			throw new RestOperationNotImplementedException("M�todo PUT no implementado para el servicio " . get_class($this));
		}
		
		/*
		 * M�todo DELETE del servicio
		*/
		public function  delete($param){
			throw new RestOperationNotImplementedException("M�todo DELETE no implementado para el servicio " . get_class($this));
		}
		
		// M�todos abstractos a implementar por cada servicios
		protected abstract function getList();
		protected abstract function getSingle($id);
}

?>