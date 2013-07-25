<?php
	class LibraryOperations {
		private static $exclude_file_list = array(".", "..");
		
		public static function listDirectory ($directoryPath){
			if (is_dir($directoryPath)){
				$entries = scandir($directoryPath);
				$entries = array_diff($entries, LibraryOperations::$exclude_file_list);
				for ($cnt=0; $cnt<count($entries); $cnt++){
					$entries[$cnt] = utf8_encode($entries[$cnt]); 
				}
			}
			
			return $entries;
		}
	}

?>