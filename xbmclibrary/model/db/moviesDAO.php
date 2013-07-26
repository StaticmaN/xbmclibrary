<?php

	class moviesDAO implements AbstractDAO{
		
		/**
		 * M�todo para obtener la informaci�n de las pel�culas registradas en la librer�a
		 * 
		 * @throws DBException
		 * @return array
		 */
		public static function getResources(){
			//Conectamos con la base de datos
			$mysqli = DBUtils::connect();
			
			// Consultamos la lista de pel�culas
			$movies = self::getMovies($mysqli);
				
			//Cerramos la conexi�n con la base de datos
			DBUtils::disconnect($mysqli);
			
			//Devolvemos la lista de pel�culas encotnradas
			return $movies;
		}
		
		/**
		 * Retorna la informaci�n completa de una pel�cula regitrada en la 
		 * librer�a de XBMC.
		 * 
		 * @param unknown $id Identificador de la pel�cula
		 * @return Movie Infomaci�n de la pel�cula
		 */
		public static function getResource($id){
			if (!empty($id)&&(is_numeric($id))){
				//Conectamos con la base de datos
				$mysqli = DBUtils::connect();
				
				//Obtenemos la informaci�n de la pel�cula
				$movie = self::getMovie($mysqli, $id);
					
				//Obtenemos la lista de actores
				if (!is_null($movie)){
					$movie->actors = DBUtils::getActors($mysqli, 'actorlinkmovie', 'idMovie', $id);
				}
					
				//Cerramos la conexi�n con la base de datos
				DBUtils::disconnect($mysqli);
			}
			
			if (!isset($movie)){
				$movie = new Movie();
			}
			
			return $movie;
		}
		
		private static function getMovies($mysqli){
			$movies = array ();
			
			//Ejecutamos la consulta
			$query = "SELECT idMovie,
					         c00 as title,
					         c05 as rating,
					         c04 as votes,
					         c07 as year,
					         c08 as thumbs,
					         c11 as length,
					         c12 as mpaa,
					         c14 as genres,
					         dateAdded
					  FROM movieview";
			
			if ($result = $mysqli->query($query)) {
				if ($result->num_rows > 0) {	
					while($row = $result->fetch_array()) {
						$movie = new BaseMovieInfo();
						self::getBasicMovieInfo($row, $movie);
						array_push($movies, $movie);
					}
				}
			}else{
				throw new DBException("Error al consultar la base de datos: {$mysqli->error}", $mysqli->errno);
			}
			
			return $movies;
		}
		
		private static function getMovie($mysqli, $id){
			$movie = NULL;
			
			//Ejecutamos la consulta
			$query = "SELECT idMovie,
					         c00 as title,
					         c01 as plot,
					         c05 as rating,
					         c04 as votes,
					         c06 as writer,
					         c07 as year,
					         c08 as thumbs,
					         c09 as imdbid,
					         c11 as length,
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
				throw new DBException("Error al consultar la base de datos: {$mysqli->error}", $mysqli->errno);
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
			$movie->thumbs    = DBUtils::getThumbs($row["thumbs"], TRUE);
			$movie->length    = $row["length"];
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
			
			return $movie;
		}
	}

?>