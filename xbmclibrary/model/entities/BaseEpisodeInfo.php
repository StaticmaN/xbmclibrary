<?php
	class BaseEpisodeInfo{
		//Id
		public $id;
		//Identificador de la serie a la que pertenece el episodio
		public $idShow;
		//Temporada a la que pertenece el episodio
		public $season;
		//N�mero de episodio dentro de la temporada
		public $episodenumber;
		//T�tulo del video
		public $title;
		//Votaci�n IMDB
		public $rating;
		// Duraci�n de la pel�cula
		public $length;
		// Fecha donde se a�adi� a la librer�a
		public $dateAdded;
	}
?>