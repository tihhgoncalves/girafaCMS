<?
// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);

header('Content-Type: application/json');
/*
 * {
"url": "https://www.youtube.com/watch?v=b1dYkXjj-1o",
"type": "video",
"version": "1.0",
"title": "Xuxa - Estátua",
"author": "xuxaVEVO",
"provider_name": "YouTube",
"description": "Music video by Xuxa performing Estátua. (C) 2003 Xuxa Prom. e Prod. artísticas Ltda",
"thumbnail_url": "https://i.ytimg.com/vi/b1dYkXjj-1o/maxresdefault.jpg",
"thumbnail_width": 1920,
"thumbnail_height": 1080,
"html": "<div><div style=\"left: 0px; width: 100%; height: 0px; position: relative; padding-bottom: 56.2493%;\"><iframe src=\"https://www.youtube.com/embed/b1dYkXjj-1o?wmode=transparent&amp;rel=0&amp;autohide=1&amp;showinfo=0&amp;enablejsapi=1\" frameborder=\"0\" allowfullscreen style=\"top: 0px; left: 0px; width: 100%; height: 100%; position: absolute;\"></iframe></div></div>",
"cache_age": 86400
}

*/

if(!isset($_GET['url'])){
  $erro = array('error' => 'Parâmetro (get) url não foi enviado;');
  die(json_encode($erro));
}

// Youtube
$re = '/http[s!]?:\/\/(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?/';
preg_match_all($re, $_GET['url'], $matches);


$xml = array();

$xml['url'] = $_GET['url'];
$xml['provider_name'] = 'Youtube';
$xml['code'] = $matches[1][0];



echo(json_encode($xml));