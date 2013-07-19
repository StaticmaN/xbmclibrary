<?php
	class Video {
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
	
	class Movie extends Video{
		//Título original
		public $originalTitle;
		// País
		public $country;
		// Director de la película
		public $director;
	}
	
	class TVShow extends Video{
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
	
	class Actor {
		//Nombre del actor
		public $name;
		//Rol en la película o serie
		public $role;
		//Imagen del actor
		public $thumb;
	}
?>