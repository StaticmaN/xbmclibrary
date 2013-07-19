<?php
	class LibraryOperations {
		public static function listDirectory ($directoryPath){
			$entries = array();
			if ($directory = opendir($directoryPath)) {
				while (false !== ($entry = readdir($directory))) {
					if (($entry!=".")&&($entry!=".."))
					array_push($entries,$entry); 
				}
				closedir($directory);
			}
			
			return $entries;
		}
	}

?>