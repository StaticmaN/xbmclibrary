<?php
	include_once "Video.php";
	
	class TvShow extends Video{
		//N�mero de temporadas
		public $seasons;
		//N�mero de episodios
		public $episodes;
		//Fecha del estreno
		public $premiered;
		//Estudio creadora de la serie
		public $studio;
		//Array con los posters de cada temporada
		public $seasonposters;
	}
?>