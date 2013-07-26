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
			$mysqli = new mysqli(XBMCLibraryConstants::DB_HOST, 
								 XBMCLibraryConstants::DB_USER, 
								 XBMCLibraryConstants::DB_PASSWORD, 
								 XBMCLibraryConstants::DB_MOVIESDB);
			
			if (mysqli_connect_errno()) {
				$errorMsg = "No se ha podido establecer la conexión con la base de datos: " . $mysqli->connect_error;
				$errorCode = $mysqli->connect_errno;
			}else{
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
						$tvshows = array ();
					
						while($row = $result->fetch_array()) {
							$tvshow = new BaseTVShowInfo();
							self::getBasicTVShowInfo($row, $tvshow);
							array_push($tvshows, $tvshow);
						}
					}
				}else{
					$errorMsg = "Error al consultar la base de datos: " . $mysqli->error;
					$errorCode = $mysqli->errno;
				}
				
				//Cerramos la conexión con la base de datos
				$mysqli->close();
			}
			
			//Comprobamos si ha habido algún error durante la ejecución del script
			if (isset($errorCode)){	
				throw new DBException($errorMsg, $errorCode,NULL);
			}
			
			//Devolvemos la lista de películas encotnradas
			return $tvshows;
		}
		
		/**
		 * Retorna la información completa de una serie de televisión regitrada en la 
		 * librería de XBMC.
		 * 
		 * @param unknown $id Identificador de la serie de televisión
		 * @return Movie Infomación de la serie de televisión
		 */
		public static function getResource($id){
			if (!empty($id)){
				//Conectamos con la base de datos
				$mysqli = new mysqli(XBMCLibraryConstants::DB_HOST,
									 XBMCLibraryConstants::DB_USER,
									 XBMCLibraryConstants::DB_PASSWORD,
									 XBMCLibraryConstants::DB_MOVIESDB);
					
				if (mysqli_connect_errno()) {
					$errorMsg = "No se ha podido establecer la conexión con la base de datos: " . $mysqli->connect_error;
					$errorCode = $mysqli->connect_errno;
				}else{
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
							  FROM tvshowview WHERE idShow = " . $id;
					
					if ($result = $mysqli->query($query)) {		
						if ($result->num_rows == 1) {
							$row = $result->fetch_assoc();
							$movie = self::getCompleteTVShowInfo($row);
						}
					}else{
						$errorMsg = "Error al consultar la base de datos: " . $mysqli->error;
						$errorCode = $mysqli->errno;
					}
					
					// Copnsultamos la información de los actores
					$query = "SELECT t1.iOrder as movieorder,
							         t1.strRole as role,
							         t2.strActor as name,
							         t2.strThumb as thumbs
							  FROM actorlinktvshow as t1, actors as t2
							  WHERE t1.idShow = " . $id . " and 
							        t1.idActor = t2.idActor";
					
					if ($result = $mysqli->query($query)) {
						if ($result->num_rows > 0) {
							$actors = array ();
								
							while($row = $result->fetch_array()) {
								$actor = self::getActorInfo($row);
								array_push($actors, $actor);
							}
							$movie->actors = $actors;
						}	
					}else{
						$errorMsg = "Error al consultar la base de datos: " . $mysqli->error;
						$errorCode = $mysqli->errno;
					}
					
					//Cerramos la conexión con la base de datos
					$mysqli->close();
				}
			}
			
			//Comprobamos si ha habido algún error durante la ejecución del script
			if (isset($errorCode)){
				throw new DBException($errorMsg, $errorCode,NULL);
			}
			
			if (!isset($movie)){
				$movie = new Movie();
			}
			
			return $movie;
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
		
		private static function getActorInfo($row){
			$actor = new Actor();
			
			$actor->order = $row["movieorder"];
			$actor->name = utf8_encode($row["name"]);
			$actor->role = utf8_encode($row["role"]);
			$actor->thumbs = DBUtils::getThumbs($row["thumbs"], TRUE);
			
			return $actor;
		}
	}

?>