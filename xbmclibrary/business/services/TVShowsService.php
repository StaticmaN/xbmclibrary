<?php
	class TVShowsService extends AbstractService{
		
		protected function getList(){
			$result = TVShowsDAO::getTVShows();
			return $result;
		}
		
		protected function getSingle($id){
			$result = TVShowsDAO::getTVShow($id);
			return $result;
		}
	}
?>