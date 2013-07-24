<?php
	class MoviesService extends AbstractService{
		protected function getList(){
			$result = LibraryOperations::listDirectory(XBMCLibraryConstants::MOVIES_SERVICE_DIRECTORY);
			return $result;
		}
		
		protected function getSingle($id){
			$result = array('consulta de un registro concreto');
			return $result;
		}
	}
?>