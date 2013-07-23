<?php
	class LibraryOperations {
		private static $exclude_file_list = array(".", "..");
		
		public static function listDirectory ($directoryPath){

			if (is_dir($directoryPath)){
				$entries = scandir($directoryPath);
				$entries = array_diff($entries, LibraryOperations::$exclude_file_list);
			}
			
			return $entries;
		}
	}

?>