<?php

	class DBUtils {
		public static function connect(){
			$mysqli = new mysqli(XBMCLibraryConstants::DB_HOST,
					XBMCLibraryConstants::DB_USER,
					XBMCLibraryConstants::DB_PASSWORD,
					XBMCLibraryConstants::DB_MOVIESDB);
				
			if (mysqli_connect_errno()) {
				throw new DBException("No se ha podido establecer la conexión con la base de datos: {$mysqli->connect_error}", $mysqli->connect_errno);
			}
			
			return $mysqli;
		}
		
		public static function disconnect($mysqli){
			//Cerramos la conexión con la base de datos
			$mysqli->close();
		}
		
		public static function getThumbs($xml, $addRoot = false){
			if ($addRoot){
				$xml = "<root>" . $xml . "</root>";
			}
			$dom = simplexml_load_string($xml);
			$thumbs = array();
			foreach ($dom->thumb as $thumbURL) {
				array_push($thumbs, (string) $thumbURL);
			}
			return $thumbs;
		}
		
		public static function getTrailer($trailerURL){
			$standardURI = "plugin://plugin.video.youtube/?action=play_video&videoid=";
			$videoId = str_replace($standardURI, "", $trailerURL);
			return $videoId;
		}
		
		public static function getActors($mysqli, $tablename, $idColumnName, $id){
			$query = "SELECT t1.iOrder as position,
							         t1.strRole as role,
							         t2.strActor as name,
							         t2.strThumb as thumbs
							  FROM {$tablename} as t1, actors as t2
							  WHERE t1.{$idColumnName} = {$id} and
							        t1.idActor = t2.idActor";
				
			if ($result = $mysqli->query($query)) {
				$actors = array ();
				if ($result->num_rows > 0) {
					while($row = $result->fetch_array()) {
						$actor = DBUtils::getActorInfo($row);
						array_push($actors, $actor);
					}
				}
			}else{
				throw new DBException("Error al consultar la base de datos: {$mysqli->error}", $mysqli->errno);
			}
			
			return $actors;
		}
		
		private static function getActorInfo($row){
			$actor = new Actor();
				
			$actor->order = $row["position"];
			$actor->name = utf8_encode($row["name"]);
			$actor->role = utf8_encode($row["role"]);
			$actor->thumbs = DBUtils::getThumbs($row["thumbs"], TRUE);
				
			return $actor;
		}
	}

?>