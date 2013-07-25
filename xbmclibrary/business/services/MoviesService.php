<?php
	class MoviesService extends AbstractService{
		protected function getList(){
			$result = MoviesDAO::getMovies();
			return $result;
		}
		
		protected function getSingle($id){
			$result = MoviesDAO::getMovie($id);
			return $result;
		}
	}
?>