<?php
	include_once "Video.php";
	
	class TvShow extends Video{
		//Número de temporadas
		public $seasons;
		//Número de episodios
		public $episodes;
		//Fecha del estreno
		public $premiered;
		//Estudio creadora de la serie
		public $studio;
		//Array con los posters de cada temporada
		public $seasonposters;
	}
?>