<?php
	class Video {
		//Id
		public $id;
		//Título del video
		public $title;
		// Año de creación
		public $year;
		//Argumento
		public $plot;
		//Control parental
		public $mpaa;
		//Array con los géneros del video
		public $genres;
		//URL al trailer del video
		public $trailer;
		//Array con objetos de clase Actor
		public $actors;
		//Votación IMDB
		public $rating;
		//Número de votos
		public $votes;
		//Array con URLs a las imágenes con los posters 
		public $posters;
		//Array con URLs a imágenes relacionadas con el video
		public $fanarts;
	}
?>