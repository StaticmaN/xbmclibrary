<?php
	class Movie extends BaseMovieInfo{
		//Argumento
		public $plot;
		// Título original
		public $originalTitle;
		// País
		public $country;
		// Escritor de la película
		public $writer;
		// Director de la película
		public $director;
		//Estudio
		public $studio;
		//Array con objetos de clase Actor
		public $actors;
		//Array con URLs a imágenes relacionadas con el video
		public $fanarts;
		//Código del video de youtube
		public $trailer;
		// Id de IMDB
		public $imdbId;
	}
?>