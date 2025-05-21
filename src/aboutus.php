<?php
require_once "template.php";
$pagina = new Template(
    "Chi siamo - Il nostro team e la nostra storia",
    "chi siamo, team, missione, gaming",
    "html/aboutus.html"
);

$pagina->aggiungiContenuto("[titolo]", "Chi Siamo");
$pagina->aggiungiContenuto("[descrizione]", "Scopri chi siamo e cosa facciamo nel mondo del gaming.");
$pagina->aggiungiContenuto("[keywords]", "about us, team, chi siamo, gaming");

$pagina->getPagina();
?>
