<?php
	spl_autoload_register('AutoClassLoader::autoload');
	
	class AutoClassLoader {
	
		public function __construct(){
		}
	
		// autoload specified file
		public static function autoload($className){
			// the path should be defined as a constant or similar
			$path = $_SERVER['DOCUMENT_ROOT'];
			
			$filepath = AutoClassLoader::recursive_autoload($className, $path);
			
			if ($filepath!=NULL){
				require_once($filepath);
			}
		}
		
		// try to load recursively the specified file
		private static function recursive_autoload($className, $path){
			$result = NULL;
			
			if (is_dir($path)){
				$filepath = $path . '/' . $className . '.php';
				
				if (file_exists($filepath)){
					$result = $filepath;
				}else{
					//Buscamos de forma recursiva
					$handler = opendir($path);
					while ((FAlSE !== ($dir = readdir($handler)))&&($result==NULL)){
						$dirpath = $path . "/" . $dir;
						if (($dir[0]!=='.') && (is_dir($dirpath))){
							$result = AutoClassLoader::recursive_autoload($className, $dirpath);
						}
					}
					closedir($handler);
				}
			}
			
			return $result;
		}
	}

?>