<?php
class Template {
    private $footer;
    private $search;
    private $pagina;

    public function __construct($description, $keywords, $pagina) {
        $this->footer = '<p><a href="Assistenza_e_contatti.html">Assistenza</a> 
                         <a href="aboutus.html">La nostra storia</a></p>
                         <p>© 2025 VAPOR - Videogames\' Useless Opinions</p>';

        $this->pagina = file_get_contents('html/template_html.html');

        $this->pagina = str_replace("[description]", $description, $this->pagina);
        $this->pagina = str_replace("[keywords]", $keywords, $this->pagina);
        $this->pagina = str_replace("[footer]", $this->footer, $this->pagina);

        $this->header($pagina);

        $main = file_get_contents($pagina);

        $this->pagina = str_replace("[main]",$main, $this->pagina);

    }

    public function header($pagina = null){
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->search = '
        <div class="search-container">
            <input type="text" placeholder="Cerca..." class="search-box">
            <button class="search-button">
                <img src="../assets/search_white.png" alt="Cerca" class="search-icon">
            </button>
        </div>';

        $header = file_get_contents('html/header.html');

        if(!($pagina === "html/login.html" || $pagina === "html/registra.html")){
            $header = str_replace("[searchbar]", $this->search, $header);
        } else {
            $header = str_replace("[searchbar]", "", $header);
        }

        if($pagina === "html/index.html"){

            $header = str_replace("[logo]",'<h1 class="logo">Vapor</h1>', $header);

            $header = str_replace("[home]",'<li class="current-page"><span lang="en">Home</span></li>',$header);
            $header = str_replace("[categorie]",'<li><a href="categorie.php">Categorie</a></li>',$header);
            $header = str_replace("[eventi]",'<li><a href="eventi.php">Prossimi eventi</a></li>',$header);
            $header = str_replace("[libreria]",' <li><a href="libreria.php">Libreria</a></li>',$header);
            $header = str_replace("[login]",'<li><a href="login.php">Profilo</a></li>',$header);

            $header = str_replace("[breadcrump]",'<div class="breadcrump"><p>Ti trovi in: <span lang="en">Home</span></p></div>',$header);

        }

        if($pagina === "html/categorie.html"){

            $header = str_replace("[logo]",'<a href="index.php"><h1 class="logo">Vapor</h1></a>', $header);

            $header = str_replace("[home]",'<li><span lang="en"><a href="index.php">Home</span></a></li>',$header);
            $header = str_replace("[categorie]",'<li class="current-page">Categorie</li>',$header);
            $header = str_replace("[eventi]",'<li><a href="eventi.php">Prossimi eventi</a></li>',$header);
            $header = str_replace("[libreria]",' <li><a href="libreria.php">Libreria</a></li>',$header);
            $header = str_replace("[login]",'<li><a href="login.php">Profilo</a></li>',$header);

            $header = str_replace("[breadcrump]",'<div class="breadcrump"><p>Ti trovi in: <a href="index.php" lang="en">Home</a> &gt; Categorie</p></div>',$header);
        }

        if($pagina === "html/eventi.html"){

            $header = str_replace("[logo]",'<a href="index.php"><h1 class="logo">Vapor</h1></a>', $header);

            $header = str_replace("[home]",'<li><span lang="en"><a href="index.php">Home</span></a></li>',$header);
            $header = str_replace("[categorie]",'<li><a href="categorie.php">Categorie</a></li>',$header);
            $header = str_replace("[eventi]",'<li class="current-page">Prossimi eventi</li>',$header);
            $header = str_replace("[libreria]",'<li><a href="libreria.php">Libreria</a></li>',$header);
            $header = str_replace("[login]",'<li><a href="login.php">Profilo</a></li>',$header);

            $header = str_replace("[breadcrump]",'<div class="breadcrump"><p>Ti trovi in: <a href="index.php" lang="en">Home</a> &gt; Eventi</p></div>',$header);
        }

        if($pagina === "html/libreria.html"){

            $header = str_replace("[logo]",'<a href="index.php"><h1 class="logo">Vapor</h1></a>', $header);

            $header = str_replace("[home]",'<li><span lang="en"><a href="index.php">Home</span></a></li>',$header);
            $header = str_replace("[categorie]",'<li><a href="categorie.php">Categorie</a></li>',$header);
            $header = str_replace("[eventi]",'<li><a href="eventi.php">Prossimi eventi</a></li>',$header);
            $header = str_replace("[libreria]",'<li class="current-page">Libreria</li>',$header);
            $header = str_replace("[login]",'<li><a href="login.php">Profilo</a></li>',$header);

            $header = str_replace("[breadcrump]",'<div class="breadcrump"><p>Ti trovi in: <a href="index.php" lang="en">Home</a> &gt; Libreria</p></div>',$header);
        }

        if($pagina === "html/login.html"){

            $header = str_replace("[logo]",'<a href="index.php"><h1 class="logo">Vapor</h1></a>', $header);

            $header = str_replace("[home]",'<li><span lang="en"><a href="index.php">Home</span></a></li>',$header);
            $header = str_replace("[categorie]",'<li><a href="categorie.php">Categorie</a></li>',$header);
            $header = str_replace("[eventi]",'<li><a href="eventi.php">Prossimi eventi</a></li>',$header);
            $header = str_replace("[libreria]",'<li><a href="libreria.php">Libreria</a></li>',$header);
            $header = str_replace("[login]",'<li class="current-page">Profilo</li>',$header);

            $header = str_replace("[breadcrump]",'<div class="breadcrump"><p>Ti trovi in: <a href="index.php" lang="en">Home</a> &gt; <span lang="en">Login</span></p></div>',$header);
            
        }

        if($pagina === "html/registra.html"){

            $header = str_replace("[logo]",'<a href="index.php"><h1 class="logo">Vapor</h1></a>', $header);

            $header = str_replace("[home]",'<li><span lang="en"><a href="index.php">Home</span></a></li>',$header);
            $header = str_replace("[categorie]",'<li><a href="categorie.php">Categorie</a></li>',$header);
            $header = str_replace("[eventi]",'<li><a href="eventi.php">Prossimi eventi</a></li>',$header);
            $header = str_replace("[libreria]",'<li><a href="libreria.php">Libreria</a></li>',$header);
            $header = str_replace("[login]",'<li><a href="login.php">Profilo</a></li>',$header);

            $header = str_replace("[breadcrump]",'<div class="breadcrump"><p>Ti trovi in: Registrati</p></div>',$header);
            
        }

        session_destroy();

        $this->aggiungiContenuto("[header]",$header);

    }

    public function getPagina(){
        echo $this->pagina;
    }

    public function aggiungiContenuto($placeholder, $valore){
        $this->pagina = str_replace($placeholder, $valore, $this->pagina);
    }

}
?>