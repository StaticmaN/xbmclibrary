<?php

	class DBUtils {
		
		public static function getThumbsInfo($xml, $addRoot = false){
			if ($addRoot){
				$xml = "<root>" . $xml . "</root>";
			}
			$dom = simplexml_load_string($xml);
			$thumbs = array();
			foreach ($dom->thumb as $thumbURL) {
				array_push($thumbs, (string) $thumbURL['preview']);
			}
			return $thumbs;
		}
		
		public static function getTrailer($trailerURL){
			$standardURI = "plugin://plugin.video.youtube/?action=play_video&videoid=";
			$videoId = str_replace($standardURI, "", $trailerURL);
			return $videoId;
		}
	}

?>