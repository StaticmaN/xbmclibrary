<?php
	class BaseEpisodeInfo{
		//Id
		public $id;
		//Identificador de la serie a la que pertenece el episodio
		public $idShow;
		//Temporada a la que pertenece el episodio
		public $season;
		//Número de episodio dentro de la temporada
		public $episodenumber;
		//Título del video
		public $title;
		//Votación IMDB
		public $rating;
		// Duración de la película
		public $length;
		// Fecha donde se añadió a la librería
		public $dateAdded;
	}
?>