<?php
	class Video {
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
	
	class Movie extends Video{
		//T�tulo original
		public $originalTitle;
		// Pa�s
		public $country;
		// Director de la pel�cula
		public $director;
	}
	
	class TVShow extends Video{
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
	
	class Actor {
		//Nombre del actor
		public $name;
		//Rol en la pel�cula o serie
		public $role;
		//Imagen del actor
		public $thumb;
	}
?>