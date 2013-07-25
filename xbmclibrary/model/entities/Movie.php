<?php
	class Movie extends BaseMovieInfo{
		//Argumento
		public $plot;
		// T�tulo original
		public $originalTitle;
		// Pa�s
		public $country;
		// Escritor de la pel�cula
		public $writer;
		// Director de la pel�cula
		public $director;
		//Estudio
		public $studio;
		//Array con objetos de clase Actor
		public $actors;
		//Array con URLs a im�genes relacionadas con el video
		public $fanarts;
		//C�digo del video de youtube
		public $trailer;
		// Id de IMDB
		public $imdbId;
	}
?>