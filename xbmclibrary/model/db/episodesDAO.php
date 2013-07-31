<?php

	class episodesDAO implements AbstractDAO{
		
		/**
		 * Método para consultas sobre el recurso
		 *
		 * @param unknown $param
		 * @return unknown
		 */
		public function  get($param){
			if (count($param)==0){
				$result = $this->getListEpisodes(NULL);
			}else if(count($param)==1){
				$result = $this->getListEpisodes($param[0]);
			}else{
				$result = $this->getResource($param[1]);
			}
			return $result;
		}
		
		/**
		 * Método para obtener la información de los episodios registrados en la 
		 * librería, o si se incluye en la llamda el identificador de una serie 
		 * de televisión se retornarán los episodios pertenecientes a dicha serie 
		 * de televisión.
		 * 
		 * @param unknown $idTVShow
		 * @return array
		 */
		private function getListEpisodes($idTVShow){
			//Conectamos con la base de datos
			$mysqli = DBUtils::connect();
				
			// Consultamos la lista de episodios
			$episodes = self::getEpisodes($mysqli, $idTVShow);
			
			//Cerramos la conexión con la base de datos
			DBUtils::disconnect($mysqli);
			
			//Devolvemos la lista de episodios
			return $episodes;
		}
		
		/**
		 * Retorna la información completa de un episodio registrado en la 
		 * librería de XBMC.
		 * 
		 * @param unknown $idEpisode Identificador del episodio
		 * @return Episode Infomación del episodio
		 */
		private function getResource($idEpisode){
			if (!empty($idEpisode)&&(is_numeric($idEpisode))){
				//Conectamos con la base de datos
				$mysqli = DBUtils::connect();
				
				//Obtenemos la información del episodio
				$episode = self::getEpisode($mysqli, $idEpisode);
				
				//Obtenemos la lista de actores
				if (!is_null($episode)){
					$episode->actors = DBUtils::getActors($mysqli, 'actorlinkepisode', 'idEpisode', $idEpisode);
				}
				
				//Cerramos la conexión con la base de datos
				DBUtils::disconnect($mysqli);	
			}
			
			if (!isset($episode)){
				$episode = new Episode();
			}
			
			return $episode;
		}
		
		private static function getEpisodes($mysqli, $idTVShow){
			$episodes = array ();
			
			//Ejecutamos la consulta
			$query = "SELECT idEpisode,
					         c00 as title,
					         c03 as rating,
					         c09 as lenght,
					         c12 as season,
					         c13 as episodenumber,
					         dateadded,
					         idShow
					  FROM episodeview";
			if (isset($idTVShow)){
				$query .= " WHERE idShow = {$idTVShow}"; 
			}		  
			
			if ($result = $mysqli->query($query)) {
				if ($result->num_rows > 0) {
					while($row = $result->fetch_array()) {
						$episode = new BaseEpisodeInfo();
						self::getBasicEpisodeInfo($row, $episode);
						array_push($episodes, $episode);
					}
				}
			}else{
				throw new DBException("Error al consultar la base de datos: {$mysqli->error}", $mysqli->errno);
			}
			
			return $episodes;
		}
		
		private static function getEpisode($mysqli, $id){
			$episode = NULL;
			
			//Ejecutamos la consulta
			$query = "SELECT idEpisode,
					         c00 as title,
					         c03 as rating,
					         c09 as lenght,
					         c12 as season,
					         c13 as episodenumber,
					         dateadded,
					         idShow,
					         c01 as plot,
					         c04 as writer,
					         c10 as director,
					         c05 as premiered,
					         c06 as thumbs
			  		FROM episodeview
					WHERE idEpisode = {$id}";
				
			if ($result = $mysqli->query($query)) {
				if ($result->num_rows == 1) {
					$row = $result->fetch_assoc();
					$episode = self::getCompleteEpisodeInfo($row);
				}
			}else{
				throw new DBException("Error al consultar la base de datos: {$mysqli->error}", $mysqli->errno);
			}
			
			return $episode;
		}
		
		/**
		 * 
		 * @param unknown $row
		 * @return BaseEpisodeInfo
		 */
		private static function getBasicEpisodeInfo($row, BaseEpisodeInfo & $episode){
			$episode->id            = $row["idEpisode"];
			$episode->idShow        = $row["idShow"];
			$episode->season        = $row["season"];
			$episode->episodenumber = $row["episodenumber"];
			$episode->title         = utf8_encode($row["title"]);
			$episode->rating        = $row["rating"];
			$episode->length        = $row["lenght"];
			$episode->dateAdded     = $row["dateAdded"];
		}
		
		private static function getCompleteEpisodeInfo($row){
			$episode = new Episode();
			
			self::getBasicEpisodeInfo($row, $episode);
			
			$episode->plot          = utf8_encode($row["plot"]);
			$episode->premiered     = $row["premiered"];
			$episode->writer        = utf8_encode($row["writer"]);
			$episode->director      = utf8_encode($row["director"]);
			$episode->thumbs       = DBUtils::getThumbs($row["thumbs"], TRUE);
			
			return $episode;
		}
	}

?>