<?php

	class moviesDAO implements AbstractDAO{
		
		/**
		 * Método para obtener la información de las películas registradas en la librería
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
				$query = "SELECT idMovie,
						         c00 as title, 
						         c05 as rating, 
						         c04 as votes,
						         c07 as year,
						         c08 as posters,
						         c11 as duration,
						         c12 as mpaa,
						         c14 as genres,
						         dateAdded
						  FROM movieview";
				
				if ($result = $mysqli->query($query)) {
					
					if ($result->num_rows > 0) {
						$movies = array ();
					
						while($row = $result->fetch_array()) {
							$movie = new BaseMovieInfo();
							self::getBasicMovieInfo($row, $movie);
							array_push($movies, $movie);
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
			return $movies;
		}
		
		/**
		 * Retorna la información completa de una película regitrada en la 
		 * librería de XBMC.
		 * 
		 * @param unknown $id Identificador de la película
		 * @return Movie Infomación de la película
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
					$query = "SELECT idMovie,
							         c00 as title, 
							         c01 as plot,
							         c05 as rating, 
							         c04 as votes,
							         c06 as writer,
							         c07 as year,
							         c08 as posters,
							         c09 as imdbid,
							         c11 as duration,
							         c12 as mpaa,
							         c14 as genres,
							         dateadded,
							         c15 as director,
							         c16 as originaltitle,
							         c18 as studio,
							         c19 as trailer,
							         c20 as fanarts,
							         c21 as country
							  FROM movieview
							  WHERE idMovie = " . $id;
					
					if ($result = $mysqli->query($query)) {		
						if ($result->num_rows == 1) {
							$row = $result->fetch_assoc();
							$movie = self::getCompleteMovieInfo($row);
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
							  FROM actorlinkmovie as t1, actors as t2
							  WHERE t1.idMovie = " . $id . " and 
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
		 * @return BaseMovieInfo
		 */
		private static function getBasicMovieInfo($row, BaseMovieInfo & $movie){
			$movie->id        = $row["idMovie"];
			$movie->title     = utf8_encode($row["title"]);
			$movie->rating    = $row["rating"];
			$movie->votes     = $row["votes"];
			$movie->year      = $row["year"];
			$movie->posters   = DBUtils::getThumbs($row["posters"], TRUE);
			$movie->duration  = $row["duration"];
			$movie->mpaa      = $row["mpaa"];
			$movie->genres    = explode(" / ", utf8_encode($row["genres"]));
			$movie->dateAdded = $row["dateAdded"];
		}
		
		private static function getCompleteMovieInfo($row){
			$movie = new Movie();
			
			self::getBasicMovieInfo($row, $movie);
			
			$movie->plot          = utf8_encode($row["plot"]);
			$movie->writer        = utf8_encode($row["writer"]);
			$movie->imdbId        = $row["imdbid"];
			$movie->director      = utf8_encode($row["director"]);
			$movie->studio        = utf8_encode($row["studio"]);
			$movie->originalTitle = utf8_encode($row["originaltitle"]);
			$movie->trailer       = DBUtils::getTrailer($row["trailer"]);
			$movie->fanarts       = DBUtils::getThumbs($row["fanarts"]);
			$movie->country       = utf8_encode($row["country"]);
			$movie->actors        = NULL;
			
			return $movie;
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