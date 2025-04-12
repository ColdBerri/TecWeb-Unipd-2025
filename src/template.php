<?php
class Template {
    private $footer;
    private $pagina;

    public function __construct($description, $keywords) {
        $this->footer = '<p><a href="Assistenza_e_contatti.html">Assistenza</a> 
                         <a href="aboutus.html">La nostra storia</a></p>
                         <p>© 2025 VAPOR - Videogames\' Useless Opinions</p>';

        $this->pagina = file_get_contents('html/templ/template_html.html');

        $this->pagina = str_replace("[description]", $description, $this->pagina);
        $this->pagina = str_replace("[keywords]", $keywords, $this->pagina);
        $this->pagina = str_replace("[footer]", $this->footer, $this->pagina);
    }

    public function navbar($pagina = null){
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $header = file_get_contents('html/templ/header.html');

        if($pagina === "../html/index.html"){
            $header = str_replace("[categorie]",'<li><a href="categorie.php">Categorie</a></li>',$header);
            $header = str_replace("[eventi]",'<li><a href="eventi.html">Prossimi eventi</a></li>',$header);
            $header = str_replace("[libreria]",' <li><a href="libreria.html">Libreria</a></li>',$header);
            $header = str_replace("[login]",'<li><a href="login.php">Profilo</a></li>',$header);
        }

        session_destroy();

    }

    public function getPagina(){
        echo $this->pagina;
    }

    public function aggiungiContenuto($placeholder, $valore){
        $this->pagina = str_replace($placeholder, $valore, $this->pagina);
    }

}
?>