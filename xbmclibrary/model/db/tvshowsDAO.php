<?php

	class tvshowsDAO implements AbstractDAO{
		
		/**
		 * Método para obtener la información de las series de TV registradas en la librería
		 * 
		 * @throws DBException
		 * @return array
		 */
		public static function getResources(){
			//Conectamos con la base de datos
			$mysqli = DBUtils::connect();
				
			// Consultamos la lista de películas
			$tvshows = self::getTvShows($mysqli);
			
			//Cerramos la conexión con la base de datos
			DBUtils::disconnect($mysqli);
			
			//Devolvemos la lista de películas encotnradas
			return $tvshows;
		}
		
		/**
		 * Retorna la información completa de una serie de televisión regitrada en la 
		 * librería de XBMC.
		 * 
		 * @param unknown $id Identificador de la serie de televisión
		 * @return TVShow Infomación de la serie de televisión
		 */
		public static function getResource($id){
			if (!empty($id)&&(is_numeric($id))){
				//Conectamos con la base de datos
				$mysqli = DBUtils::connect();
				
				//Obtenemos la información de la serie
				$tvshow = self::getTvShow($mysqli, $id);
				
				//Obtenemos la lista de actores
				if (!is_null($tvshow)){
					$tvshow->actors = DBUtils::getActors($mysqli, 'actorlinktvshow', 'idShow', $id);
				}
				
				//Cerramos la conexión con la base de datos
				DBUtils::disconnect($mysqli);	
			}
			
			if (!isset($tvshow)){
				$tvshow = new TvShow();
			}
			
			return $tvshow;
		}
		
		private static function getTvShows($mysqli){
			$tvshows = array ();
			
			//Ejecutamos la consulta
			$query = "SELECT idShow,
					         c00 as title,
					         c04 as rating,
					         c06 as thumbs,
					         c08 as genres,
					         c13 as mpaa,
					         c14 as network
					  FROM tvshowview";
			
			if ($result = $mysqli->query($query)) {
				if ($result->num_rows > 0) {
					while($row = $result->fetch_array()) {
						$tvshow = new BaseTVShowInfo();
						self::getBasicTVShowInfo($row, $tvshow);
						array_push($tvshows, $tvshow);
					}
				}
			}else{
				throw new DBException("Error al consultar la base de datos: {$mysqli->error}", $mysqli->errno);
			}
			
			return $tvshows;
		}
		
		private static function getTvShow($mysqli, $id){
			$tvshow = NULL;
			
			//Ejecutamos la consulta
			$query = "SELECT idShow,
							 c00 as title,
							 c01 as plot,
							 c04 as rating,
							 c05 as premiered,
							 c06 as thumbs,
							 c08 as genres,
							 c09 as originalTitle,
							 c11 as fanarts,
							 c13 as mpaa,
							 c14 as network
					  FROM tvshowview WHERE idShow = {$id}";
				
			if ($result = $mysqli->query($query)) {
				if ($result->num_rows == 1) {
					$row = $result->fetch_assoc();
					$tvshow = self::getCompleteTVShowInfo($row);
				}
			}else{
				throw new DBException("Error al consultar la base de datos: {$mysqli->error}", $mysqli->errno);
			}
			
			return $tvshow;
		}
		
		/**
		 * 
		 * @param unknown $row
		 * @return BaseTVShowInfo
		 */
		private static function getBasicTVShowInfo($row, BaseTVShowInfo & $tvshow){
			$tvshow->id      = $row["idShow"];
			$tvshow->title   = utf8_encode($row["title"]);
			$tvshow->rating  = $row["rating"];
			$tvshow->thumbs = DBUtils::getThumbs($row["thumbs"], TRUE);
			$tvshow->genres  = explode(" / ", utf8_encode($row["genres"]));
			$tvshow->mpaa    = $row["mpaa"];
			$tvshow->network = $row["network"];
		}
		
		private static function getCompleteTVShowInfo($row){
			$tvshow = new TVShow();
			
			self::getBasicTVShowInfo($row, $tvshow);
			
			$tvshow->plot          = utf8_encode($row["plot"]);
			$tvshow->premiered     = utf8_encode($row["premiered"]);
			$tvshow->originalTitle = utf8_encode($row["originalTitle"]);
			$tvshow->fanarts       = DBUtils::getThumbs($row["fanarts"]);
			
			return $tvshow;
		}
	}

?>