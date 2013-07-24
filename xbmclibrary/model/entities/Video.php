<?php
	class Video {
		//Id
		public $id;
		//T�tulo del video
		public $title;
		// A�o de creaci�n
		public $year;
		//Argumento
		public $plot;
		//Control parental
		public $mpaa;
		//Array con los g�neros del video
		public $genres;
		//URL al trailer del video
		public $trailer;
		//Array con objetos de clase Actor
		public $actors;
		//Votaci�n IMDB
		public $rating;
		//N�mero de votos
		public $votes;
		//Array con URLs a las im�genes con los posters 
		public $posters;
		//Array con URLs a im�genes relacionadas con el video
		public $fanarts;
	}
?>