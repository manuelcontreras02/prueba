<?php

namespace App\Service;

//require __DIR__."/../../vendor/autoload.php";

use App\Modelos\Pelicula;
use \Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__."/../../");
$dotenv->load();

//define("URL","https://api.themoviedb.org/3/movie/popular?api_key=cb37d7c15d2f6131f863aee37f9118bb&language=en-US&page=1");//DEFINIMOS UNA CONSTANTE CON LA URL DE LA API KEY
//define("image","https://image.tmdb.org/t/p/w500");
define("URL",$_ENV['URL_BASE'].$_ENV['API_KEY']);


define ("image",$_ENV['URL_IMG']);

class ApiService{
    public function getPeliculas(): array{
        $pelis=[];
        $datos =file_get_contents(URL);                 //ESTO PILLA EL ARCHIVO EN BRUTO
        $datosJson=json_decode($datos);                 //ESTO LOS DECODIFICA
        $datosPelis =$datosJson->results;
      

        foreach($datosPelis as $objPeliculas)
        {
            $peliculas[]=(new Pelicula)->setTitulo($objPeliculas->title)
            ->setResumen($objPeliculas->overview)->setCaratula(image.$objPeliculas->backdrop_path)
            ->setFechaEstreno($objPeliculas->release_date)->setPoster(image.$objPeliculas->poster_path);
        }

        return $peliculas;

    }
}

