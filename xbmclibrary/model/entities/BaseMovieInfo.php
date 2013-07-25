<?php
	class BaseMovieInfo{
		//Id
		public $id;
		//Título del video
		public $title;
		// Año de creación
		public $year;
		//Control parental
		public $mpaa;
		//Array con los géneros del video
		public $genres;
		//Votación IMDB
		public $rating;
		//Número de votos
		public $votes;
		//Array con URLs a las imágenes con los posters
		public $posters;
		// Duración de la película
		public $duration;
		// Fecha donde se añadió a la librería
		public $dateAdded;
	}
?>