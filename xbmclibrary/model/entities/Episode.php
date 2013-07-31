<?php
	class Episode extends BaseEpisodeInfo{
		//Argumento
		public $plot;
		// Escritor del episodio
		public $writer;
		// Director del episodio
		public $director;
		//Fecha de estreno del episodio
		public $premiered;
		//Array con objetos de clase Actor
		public $actors;
		//Array con URLs a las imágenes con los posters
		public $thumbs;
	}
?>