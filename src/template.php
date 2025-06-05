<?php
class Template {
    private $footer;
    private $search;
    private $pagina;
    
    public function __construct($description, $keywords, $pagina) {
        $this->footer = '<p><a href="assistenza.php">Assistenza</a> 
                         <a href="aboutus.php">La nostra storia</a></p>
                         <p><span lang="en">© 2025 VAPOR - Videogames\' Useless Opinions</span></p>';

        $this->pagina = file_get_contents('html/template_html.html');

        $this->pagina = str_replace("[description]", $description, $this->pagina);
        $this->pagina = str_replace("[keywords]", $keywords, $this->pagina);
        $this->pagina = str_replace("[footer]", $this->footer, $this->pagina);

        $this->header($pagina);

        $main = file_get_contents($pagina);

        $budi = '<body>';
        $budijs = '<body onload="riempimentoVar();">';

        if(!($pagina === "html/registra.html")){
           $this->pagina = str_replace("[body]", $budi, $this->pagina);
        } else {
            $this->pagina = str_replace("[body]", $budijs, $this->pagina);
        }

        $this->pagina = str_replace("[main]",$main, $this->pagina);

    }

    public function header($pagina = null){
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->search = '
        <div class="search-container">
            <div class="search">
                <input type="text" placeholder="Cerca..." class="search-box" aria-label="Cerca">
            </div>
            <button class="search-button" aria-label="Esegui ricerca">
                <img src="assets/search_blue.png" alt="Cerca" class="search-icon">       
            </button>
        </div>
    ';


        $header = file_get_contents('html/header.html');
        $loginLink = '';

        if(!($pagina === "html/categorie.html")){       
            $header = str_replace("[searchbar]", "", $header);
        } else {
            $header = str_replace("[searchbar]", $this->search, $header);
        }

        $budi = '<body>';
        $budijs = '<body onload="riempimentoVar();">';

        if(!($pagina === "html/registra.html")){
           $header = str_replace("[body]", $budi, $header);
        } else {
            $header = str_replace("[body]", $budijs, $header);
        }


        if($pagina === "html/index.html"){

            $header = str_replace("[logo]",'<li><div class="logo"><img src="assets/icone.png" alt="logo sito"><h1><span lang="en">Vapor</span></h1></div></li>', subject: $header);
            $header = str_replace("[home]",'<li class="current-page"><span lang="en">Home</span></li>',$header);
            $header = str_replace("[categorie]",'<li><a href="categorie.php"><div class="navbar_link">Categorie</div></a></li>',$header);
            $header = str_replace("[eventi]",'<li><a href="eventi.php"><div class="navbar_link">Prossimi eventi</div></a></li>',$header);
            if(isset($_SESSION['nickname'])){
                if($_SESSION['nickname'] === 'admin'){
                    $header = str_replace("[libreria]",' <li><a href="opzioni_sviluppatore.php"><div class="navbar_link">Opzioni sviluppatore</div></a></li>',$header);
                }else{
                    $header = str_replace("[libreria]",' <li><a href="libreria.php"><div class="navbar_link">Libreria</div></a></li>',$header);
                }
                $header = str_replace("[login]", '<li><a href="profilo.php"><div class="navbar_link">Profilo</div></a></li>', $header);
            }else{
                $header = str_replace("[libreria]", "", $header);
                $header = str_replace("[login]", '<li><a href="login.php"><div class="navbar_link"><span lang="en">Login</span>/Registrati</div></a></li>', $header);
            }   

            $header = str_replace("[breadcrump]",'<div class="breadcrump"><p>Ti trovi in: <span lang="en">Home</span></p></div>',$header);
        }
        
        if($pagina === "html/categorie.html"){

            $header = str_replace("[logo]",'<li><a href="index.php" class="logoLink"><div class="logo"><img src="assets/icone.png" alt="logo sito"><h1><span lang="en">Vapor</span></h1></div></a></li>', subject: $header);
            $header = str_replace("[home]",'<li><a href="index.php"><div class="navbar_link"><span lang="en">Home</span></div></a></li>',$header);
            $header = str_replace("[categorie]",'<li class="current-page">Categorie</li>',$header);
            $header = str_replace("[eventi]",'<li><a href="eventi.php"><div class="navbar_link">Prossimi eventi</div></a></li>',$header);
            if(isset($_SESSION['nickname'])){
            if($_SESSION['nickname'] === 'admin'){
                $header = str_replace("[libreria]",' <li><a href="opzioni_sviluppatore.php"><div class="navbar_link">Opzioni sviluppatore</div></a></li>',$header);
            }else{
                $header = str_replace("[libreria]",' <li><a href="libreria.php"><div class="navbar_link">Libreria</div></a></li>',$header);
            }                
            $header = str_replace("[login]", '<li><a href="profilo.php"><div class="navbar_link">Profilo</div></a></li>', $header);
            }else{
            $header = str_replace("[libreria]", "", $header);
            $header = str_replace("[login]", '<li><a href="login.php"><div class="navbar_link"><span lang="en">Login</span>/Registrati</div></a></li>', $header);
            }   

            $header = str_replace("[breadcrump]",'<div class="breadcrump"><p>Ti trovi in: <a href="index.php" lang="en">Home</a> &gt&gt; Categorie</p></div>',$header);
        }

        if($pagina === "html/eventi.html"){

            $header = str_replace("[logo]",'<li><a href="index.php" class="logoLink"><div class="logo"><img src="assets/icone.png" alt="logo sito"><h1><span lang="en">Vapor</span></h1></div></a></li>', subject: $header);
            $header = str_replace("[home]",'<li><a href="index.php"><div class="navbar_link"><span lang="en">Home</span></div></a></li>',$header);
            $header = str_replace("[categorie]",'<li><a href="categorie.php"><div class="navbar_link">Categorie</div></a></li>',$header);
            $header = str_replace("[eventi]",'<li class="current-page">Prossimi eventi</li>',$header);
            if(isset($_SESSION['nickname'])){
            if($_SESSION['nickname'] === 'admin'){
                $header = str_replace("[libreria]",' <li><a href="opzioni_sviluppatore.php"><div class="navbar_link">Opzioni sviluppatore</div></a></li>',$header);
            }else{
                $header = str_replace("[libreria]",' <li><a href="libreria.php"><div class="navbar_link">Libreria</div></a></li>',$header);
            }                
            $header = str_replace("[login]", '<li><a href="profilo.php"><div class="navbar_link">Profilo</div></a></li>', $header);
            }else{
            $header = str_replace("[libreria]", "", $header);
            $header = str_replace("[login]", '<li><a href="login.php"><div class="navbar_link"><span lang="en">Login</span>/Registrati</div></a></li>', $header);
            }   

            $header = str_replace("[breadcrump]",'<div class="breadcrump"><p>Ti trovi in: <a href="index.php" lang="en">Home</a> &gt&gt; Eventi</p></div>',$header);
        }

        if($pagina === "html/libreria.html"){

            $header = str_replace("[logo]",'<li><a href="index.php" class="logoLink"><div class="logo"><img src="assets/icone.png" alt="logo sito"><h1><span lang="en">Vapor</span></h1></div></a></li>', subject: $header);
            $header = str_replace("[home]",'<li><a href="index.php"><div class="navbar_link"><span lang="en">Home</span></div></a></li>',$header);
            $header = str_replace("[categorie]",'<li><a href="categorie.php"><div class="navbar_link">Categorie</div></a></li>',$header);
            $header = str_replace("[eventi]",'<li><a href="eventi.php"><div class="navbar_link">Prossimi eventi</div></a></li>',$header);
            $header = str_replace("[libreria]",'<li class="current-page">Libreria</li>',$header);
            $header = str_replace("[login]", '<li><a href="profilo.php"><div class="navbar_link">Profilo</div></a></li>', $header);
            if($_SESSION['nickname'] === 'admin'){
                $header = str_replace("[libreria]",' <li><a href="opzioni_sviluppatore.php"><div class="navbar_link">Opzioni sviluppatore</div></a></li>',$header);
            }else{
                $header = str_replace("[libreria]",' <li><a href="libreria.php"><div class="navbar_link">Libreria</div></a></li>',$header);
            }
            $header = str_replace("[breadcrump]",'<div class="breadcrump"><p>Ti trovi in: <a href="index.php" lang="en">Home</a> &gt&gt; Libreria</p></div>',$header);
        }
        
        if($pagina === "html/login.html"){

            $header = str_replace("[logo]",'<li><a href="index.php" class="logoLink"><div class="logo"><img src="assets/icone.png" alt="logo sito"><h1><span lang="en">Vapor</span></h1></div></a></li>', subject: $header);
            $header = str_replace("[home]",'<li><a href="index.php"><div class="navbar_link"><span lang="en">Home</span></div></a></li>',$header);
            $header = str_replace("[categorie]",'<li><a href="categorie.php"><div class="navbar_link">Categorie</div></a></li>',$header);
            $header = str_replace("[eventi]",'<li><a href="eventi.php"><div class="navbar_link">Prossimi eventi</div></a></li>',$header);
            $header = str_replace("[login]", '<li class="current-page"><span lang="en">Login</span>/Registrati</li>', $header);
            $header = str_replace("[libreria]", "", $header);
            $header = str_replace("[breadcrump]",'<div class="breadcrump"><p>Ti trovi in: <a href="index.php" lang="en">Home</a> &gt&gt; <span lang="en">Login</span></p></div>',$header);
            
        }

        if($pagina === "html/registra.html"){

            $header = str_replace("[logo]",'<li><a href="index.php" class="logoLink"><div class="logo"><img src="assets/icone.png" alt="logo sito"><h1><span lang="en">Vapor</span></h1></div></a></li>', subject: $header);

            $header = str_replace("[home]",'<li><a href="index.php"><div class="navbar_link"><span lang="en">Home</span></div></a></li>',$header);
            $header = str_replace("[categorie]",'<li><a href="categorie.php"><div class="navbar_link">Categorie</div></a></li>',$header);
            $header = str_replace("[eventi]",'<li><a href="eventi.php"><div class="navbar_link">Prossimi eventi</div></a></li>',$header);
            $header = str_replace("[login]", '<li><a href="login.php"><div class="navbar_link"><span lang="en">Login</span></div></a></li>', $header);
            $header = str_replace("[libreria]", "", $header);

            $header = str_replace("[breadcrump]",'<div class="breadcrump"><p>Ti trovi in:  <a href="index.php" lang="en">Home</a> &gt&gt;Registrati</p></div>',$header);
        }
        
        if($pagina === "html/aboutus.html"){

           $header = str_replace("[logo]",'<li><a href="index.php" class="logoLink"><div class="logo"><img src="assets/icone.png" alt="logo sito"><h1><span lang="en">Vapor</span></h1></div></a></li>', subject: $header);

            $header = str_replace("[home]",'<li><a href="index.php"><div class="navbar_link"><span lang="en">Home</span></div></a></li>',$header);
            $header = str_replace("[categorie]",'<li><a href="categorie.php"><div class="navbar_link">Categorie</div></a></li>',$header);
            $header = str_replace("[eventi]",'<li><a href="eventi.php"><div class="navbar_link">Prossimi eventi</div></a></li>',$header);
            if(isset($_SESSION['nickname'])){
                if($_SESSION['nickname'] === 'admin'){
                    $header = str_replace("[libreria]",' <li><a href="opzioni_sviluppatore.php"><div class="navbar_link">Opzioni sviluppatore</div></a></li>',$header);
                }else{
                    $header = str_replace("[libreria]",' <li><a href="libreria.php"><div class="navbar_link">Libreria</div></a></li>',$header);
                }                
                $header = str_replace("[login]", '<li><a href="profilo.php"><div class="navbar_link">Profilo</div></a></li>', $header);
            }else{
                $header = str_replace("[libreria]", "", $header);
                $header = str_replace("[login]", '<li><a href="login.php"><div class="navbar_link"><span lang="en">Login</span>/Registrati</div></a></li>', $header);  
            }   

            $header = str_replace("[breadcrump]",'<div class="breadcrump"><p>Ti trovi in: <a href="index.php" lang="en">Home</a> &gt&gt; <span lang="en"> AboutUS </span></p> </div>',$header);
        }
        if($pagina === "html/profilo.html"){
            $header = str_replace("[logo]",'<li><a href="index.php" class="logoLink" ><div class="logo"><img src="assets/icone.png" alt=" "><h1>Vapor</h1></div></a></li>', $header);
            $header = str_replace("[home]",'<li><a href="index.php"><div class="navbar_link"><span lang="en">Home</span></div></a></li>', $header);
            $header = str_replace("[categorie]",'<li><a href="categorie.php"><div class="navbar_link">Categorie</div></a></li>', $header);
            $header = str_replace("[eventi]",'<li><a href="eventi.php"><div class="navbar_link">Prossimi eventi</div></a></li>', $header);
            $header = str_replace("[login]", '<li class="current-page">Profilo</li>', $header);
            if($_SESSION['nickname'] === 'admin'){
                $header = str_replace("[libreria]",' <li><a href="opzioni_sviluppatore.php"><div class="navbar_link">Opzioni sviluppatore</div></a></li>', $header);
            }else{
                $header = str_replace("[libreria]",' <li><a href="libreria.php"><div class="navbar_link">Libreria</div></a></li>', $header);
            }   
            $header = str_replace("[breadcrump]",'<div class="breadcrump"><p>Ti trovi in: <a href="index.php" lang="en">Home</a> &gt&gt; Profilo</p> </div>',$header);
        }

        if($pagina === "html/assistenza.html"){
            $header = str_replace("[logo]",'<li><a href="index.php" class="logoLink" ><div class="logo"><img src="assets/icone.png" alt=" "><h1>Vapor</h1></div></a></li>', subject: $header);

            $header = str_replace("[home]",'<li><a href="index.php"><div class="navbar_link"><span lang="en">Home</span></div></a></li>',$header);
            $header = str_replace("[categorie]",'<li><a href="categorie.php"><div class="navbar_link">Categorie</div></a></li>',$header);
            $header = str_replace("[eventi]",'<li><a href="eventi.php"><div class="navbar_link">Prossimi eventi</div></a></li>',$header);
            if(isset($_SESSION['nickname'])){
                if($_SESSION['nickname'] === 'admin'){
                    $header = str_replace("[libreria]",' <li><a href="opzioni_sviluppatore.php"><div class="navbar_link">Opzioni sviluppatore</div></a></li>',$header);
                }else{
                    $header = str_replace("[libreria]",' <li><a href="libreria.php"><div class="navbar_link">Libreria</div></a></li>',$header);
                }                
                $header = str_replace("[login]", '<li><a href="profilo.php"><div class="navbar_link">Profilo</div></a></li>', $header);
            }else{
                $header = str_replace("[libreria]", "", $header);
                $header = str_replace("[login]", '<li><a href="login.php"><div class="navbar_link"><span lang="en">Login</span>/Registrati</div></a></li>', $header);
            }   

            $header = str_replace("[breadcrump]",'<div class="breadcrump"><p>Ti trovi in: <a href="index.php" lang="en">Home</a> &gt&gt; Assistenza</p> </div>',$header);
        }
        if($pagina === "html/modifica_profilo.html"){
            $header = str_replace("[logo]",'<li><a href="index.php" class="logoLink" ><div class="logo"><img src="assets/icone.png" alt=" "><h1>Vapor</h1></div></a></li>', subject: $header);

            $header = str_replace("[home]",'<li><a href="index.php"><div class="navbar_link"><span lang="en">Home</span></div></a></li>',$header);
            $header = str_replace("[categorie]",'<li><a href="categorie.php"><div class="navbar_link">Categorie</div></a></li>',$header);
            $header = str_replace("[eventi]",'<li><a href="eventi.php"><div class="navbar_link">Prossimi eventi</div></a></li>',$header);
            $header = str_replace("[libreria]",'<li><a href="libreria.php"><div class="navbar_link">Libreria</div></a></li>',$header);
            $header = str_replace("[login]", '<li><a href="profilo.php"><div class="navbar_link">Profilo</div></a></li>', $header);
            if($_SESSION['nickname'] === 'admin'){
                $header = str_replace("[libreria]",' <li><a href="opzioni_sviluppatore.php"><div class="navbar_link">Opzioni sviluppatore</div></a></li>',$header);
            }else{
                $header = str_replace("[libreria]",' <li><a href="libreria.php"><div class="navbar_link">Libreria</div></a></li>',$header);
            }

            $header = str_replace("[breadcrump]",'<div class="breadcrump"><p>Ti trovi in: <a href="index.php" lang="en">Home</a>&gt&gt;<a href="profilo.php">Profilo</a> &gt&gt; Modifica Password</p> </div>',$header);
        }

        if($pagina === "html/categoria_singola.html"){
            $header = str_replace("[logo]",'<li><a href="index.php" class="logoLink" ><div class="logo"><img src="assets/icone.png" alt=" "><h1>Vapor</h1></div></a></li>', subject: $header);

            $header = str_replace("[home]",'<li><a href="index.php"><div class="navbar_link"><span lang="en">Home</span></div></a></li>',$header);
            $header = str_replace("[categorie]",'<li><a href="categorie.php"><div class="navbar_link">Categorie</div></a></li>',$header);
            $header = str_replace("[eventi]",'<li><a href="eventi.php"><div class="navbar_link">Prossimi eventi</div></a></li>',$header);
            if(isset($_SESSION['nickname'])){
            if($_SESSION['nickname'] === 'admin'){
                $header = str_replace("[libreria]",' <li><a href="opzioni_sviluppatore.php"><div class="navbar_link">Opzioni sviluppatore</div></a></li>',$header);
            }else{
                $header = str_replace("[libreria]",' <li><a href="libreria.php"><div class="navbar_link">Libreria</div></a></li>',$header);
            }                
            $header = str_replace("[login]", '<li><a href="profilo.php"><div class="navbar_link">Profilo</div></a></li>', $header);
            }else{
            $header = str_replace("[libreria]", "", $header);
            $header = str_replace("[login]", '<li><a href="login.php"><div class="navbar_link"><span lang="en">Login</span>/Registrati</div></a></li>', $header);
            }   

            $header = str_replace("[breadcrump]",'<div class="breadcrump"><p>Ti trovi in: <a href="index.php" lang="en">Home</a> &gt&gt; <a href="categorie.php">Categorie</a> &gt&gt; Categoria Singola</p> </div>',$header);
        }
        if($pagina === "html/gioco_singolo.html"){
            $header = str_replace("[logo]",'<li><a href="index.php" class="logoLink" ><div class="logo"><img src="assets/icone.png" alt=" "><h1>Vapor</h1></div></a></li>', subject: $header);

            $header = str_replace("[home]",'<li><a href="index.php"><div class="navbar_link"><span lang="en">Home</span></div></a></li>',$header);
            $header = str_replace("[categorie]",'<li><a href="categorie.php"><div class="navbar_link">Categorie</div></a></li>',$header);
            $header = str_replace("[eventi]",'<li><a href="eventi.php"><div class="navbar_link">Prossimi eventi</div></a></li>',$header);
            if(isset($_SESSION['nickname'])){
                if($_SESSION['nickname'] === 'admin'){
                    $header = str_replace("[libreria]",' <li><a href="opzioni_sviluppatore.php"><div class="navbar_link">Opzioni sviluppatore</div></a></li>',$header);
                }else{
                    $header = str_replace("[libreria]",' <li><a href="libreria.php"><div class="navbar_link">Libreria</div></a></li>',$header);
                }                
                $header = str_replace("[login]", '<li><a href="profilo.php"><div class="navbar_link">Profilo</div></a></li>', $header);
            }else{
                $header = str_replace("[libreria]", "", $header);
                $header = str_replace("[login]", '<li><a href="login.php"><div class="navbar_link"><span lang="en">Login</span>/Registrati</div></a></li>', $header);
            }   

            $header = str_replace("[breadcrump]",'<div class="breadcrump"><p>Ti trovi in: <a href="index.php" lang="en">Home</a> &gt&gt; <a href="categorie.php">Categorie</a> &gt&gt; <a href="categoria_singola.php">Categoria Singola</a> &gt&gt;Gioco Singolo</p> </div>',$header);
        }

        if($pagina === "html/evento_singolo.html"){
            $header = str_replace("[logo]",'<li><a href="index.php" class="logoLink" ><div class="logo"><img src="assets/icone.png" alt=" "><h1>Vapor</h1></div></a></li>', subject: $header);

            $header = str_replace("[home]",'<li><a href="index.php"><div class="navbar_link"><span lang="en">Home</span></div></a></li>',$header);
            $header = str_replace("[categorie]",'<li><a href="categorie.php"><div class="navbar_link">Categorie</div></a></li>',$header);
            $header = str_replace("[eventi]",'<li><a href="eventi.php"><div class="navbar_link">Prossimi eventi</div></a></li>',$header);
            if(isset($_SESSION['nickname'])){
                if($_SESSION['nickname'] === 'admin'){
                    $header = str_replace("[libreria]",' <li><a href="opzioni_sviluppatore.php"><div class="navbar_link">Opzioni sviluppatore</div></a></li>',$header);
                }else{
                    $header = str_replace("[libreria]",' <li><a href="libreria.php"><div class="navbar_link">Libreria</div></a></li>',$header);
                }                
                $header = str_replace("[login]", '<li><a href="profilo.php"><div class="navbar_link">Profilo</div></a></li>', $header);
            }else{
                $header = str_replace("[libreria]", "", $header);
                $header = str_replace("[login]", '<li><a href="login.php"><div class="navbar_link"><span lang="en">Login</span>/Registrati</div></a></li>', $header);
            }   

            $header = str_replace("[breadcrump]",'<div class="breadcrump"><p>Ti trovi in: <a href="index.php" lang="en">Home</a> &gt&gt; <a href="eventi.php">Eventi</a> &gt&gt; Evento Singolo</p> </div>',$header);
        }

        if($pagina === "html/articolo_singolo.html"){
            $header = str_replace("[logo]",'<li><a href="index.php" class="logoLink" ><div class="logo"><img src="assets/icone.png" alt=" "><h1>Vapor</h1></div></a></li>', subject: $header);

            $header = str_replace("[home]",'<li><a href="index.php"><div class="navbar_link"><span lang="en">Home</span></div></a></li>',$header);
            $header = str_replace("[categorie]",'<li><a href="categorie.php"><div class="navbar_link">Categorie</div></a></li>',$header);
            $header = str_replace("[eventi]",'<li><a href="eventi.php"><div class="navbar_link">Prossimi eventi</div></a></li>',$header);
            if(isset($_SESSION['nickname'])){
                if($_SESSION['nickname'] === 'admin'){
                    $header = str_replace("[libreria]",' <li><a href="opzioni_sviluppatore.php"><div class="navbar_link">Opzioni sviluppatore</div></a></li>',$header);
                }else{
                    $header = str_replace("[libreria]",' <li><a href="libreria.php"><div class="navbar_link">Libreria</div></a></li>',$header);
                }                
                $header = str_replace("[login]", '<li><a href="profilo.php"><div class="navbar_link">Profilo</div></a></li>', $header);
            }else{
                $header = str_replace("[libreria]", "", $header);
                $header = str_replace("[login]", '<li><a href="login.php"><div class="navbar_link"><span lang="en">Login</span>/Registrati</div></a></li>', $header);
            }   
            $header = str_replace("[breadcrump]",'<div class="breadcrump"><p>Ti trovi in: <a href="index.php" lang="en">Home</a> &gt&gt; <a href="categorie.php">Categorie</a> &gt&gt; <a href="categoria_singola.php">Categoria Singola</a> &gt&gt; <a href= "gioco_singolo.php">Gioco Singolo</a> &gt&gt; Articolo</p> </div>',$header);
        }

        if($pagina === "html/opzioni_sviluppatore.html"){
            $header = str_replace("[logo]",'<li><a href="index.php" class="logoLink" ><div class="logo"><img src="assets/icone.png" alt=" "><h1>Vapor</h1></div></a></li>', subject: $header);

            $header = str_replace("[home]",'<li><a href="index.php"><div class="navbar_link"><span lang="en">Home</span></div></a></li>',$header);
            $header = str_replace("[categorie]",'<li><a href="categorie.php"><div class="navbar_link">Categorie</div></a></li>',$header);
            $header = str_replace("[eventi]",'<li><a href="eventi.php"><div class="navbar_link">Prossimi eventi</div></a></li>',$header);
            $header = str_replace("[login]", '<li><a href="profilo.php"><div class="navbar_link">Profilo</div></a></li>', $header);
            $header = str_replace("[libreria]", '<li class ="current-page">Opzioni Sviluppatore</li>', $header);

            $header = str_replace("[breadcrump]",'<div class="breadcrump"><p>Ti trovi in: <a href="index.php" lang="en">Home</a> &gt&gt; Opzioni Svilupppatore</p> </div>',$header);
        }
        
        if($pagina === "html/aggiungi_videogioco.html"){
            $header = str_replace("[logo]",'<li><a href="index.php" class="logoLink" ><div class="logo"><img src="assets/icone.png" alt=" "><h1>Vapor</h1></div></a></li>', subject: $header);

            $header = str_replace("[home]",'<li><a href="index.php"><div class="navbar_link"><span lang="en">Home</span></div></a></li>',$header);
            $header = str_replace("[categorie]",'<li><a href="categorie.php"><div class="navbar_link">Categorie</div></a></li>',$header);
            $header = str_replace("[eventi]",'<li><a href="eventi.php"><div class="navbar_link">Prossimi eventi</div></a></li>',$header);
            $header = str_replace("[login]", '<li><a href="profilo.php"><div class="navbar_link">Profilo</div></a></li>', $header);
            $header = str_replace("[libreria]", '<li><a href="opzioni_sviluppatore.php"><div class="navbar_link">Opzioni Sviluppatore</div></a></li>', $header);

            $header = str_replace("[breadcrump]",'<div class="breadcrump"><p>Ti trovi in: <a href="index.php" lang="en">Home</a> &gt&gt; <a href="opzioni_sviluppatore.php">Opzioni Svilupppatore</a> &gt&gt; Aggiungi Videogioco</p> </div>',$header);
        }

        if($pagina === "html/aggiungi_evento.html"){
            $header = str_replace("[logo]",'<li><a href="index.php" class="logoLink" ><div class="logo"><img src="assets/icone.png" alt=" "><h1>Vapor</h1></div></a></li>', subject: $header);

            $header = str_replace("[home]",'<li><a href="index.php"><div class="navbar_link"><span lang="en">Home</span></div></a></li>',$header);
            $header = str_replace("[categorie]",'<li><a href="categorie.php"><div class="navbar_link">Categorie</div></a></li>',$header);
            $header = str_replace("[eventi]",'<li><a href="eventi.php"><div class="navbar_link">Prossimi eventi</div></a></li>',$header);
            $header = str_replace("[login]", '<li><a href="profilo.php"><div class="navbar_link">Profilo</div></a></li>', $header);
            $header = str_replace("[libreria]", '<li><a href="opzioni_sviluppatore.php"><div class="navbar_link">Opzioni Sviluppatore</div></a></li>', $header);

            $header = str_replace("[breadcrump]",'<div class="breadcrump"><p>Ti trovi in: <a href="index.php" lang="en">Home</a> &gt&gt; <a href="opzioni_sviluppatore.php">Opzioni Svilupppatore</a> &gt&gt; Aggiungi Evento</p> </div>',$header);
        }

        if($pagina === "html/aggiungi_articolo.html"){
            $header = str_replace("[logo]",'<li><a href="index.php" class="logoLink" ><div class="logo"><img src="assets/icone.png" alt=" "><h1>Vapor</h1></div></a></li>', subject: $header);

            $header = str_replace("[home]",'<li><a href="index.php"><div class="navbar_link"><span lang="en">Home</span></div></a></li>',$header);
            $header = str_replace("[categorie]",'<li><a href="categorie.php"><div class="navbar_link">Categorie</div></a></li>',$header);
            $header = str_replace("[eventi]",'<li><a href="eventi.php"><div class="navbar_link">Prossimi eventi</div></a></li>',$header);
            $header = str_replace("[login]", '<li><a href="profilo.php"><div class="navbar_link">Profilo</div></a></li>', $header);
            $header = str_replace("[libreria]", '<li><a href="opzioni_sviluppatore.php"><div class="navbar_link">Opzioni Sviluppatore</div></a></li>', $header);

            $header = str_replace("[breadcrump]",'<div class="breadcrump"><p>Ti trovi in: <a href="index.php" lang="en">Home</a> &gt&gt; <a href="opzioni_sviluppatore.php">Opzioni Svilupppatore</a> &gt&gt; Aggiungi Articolo</p> </div>',$header);
        } 

        if($pagina === "html/gestione_recensioni.html"){
            $header = str_replace("[logo]",'<li><a href="index.php" class="logoLink" ><div class="logo"><img src="assets/icone.png" alt=" "><h1>Vapor</h1></div></a></li>', subject: $header);

            $header = str_replace("[home]",'<li><a href="index.php"><div class="navbar_link"><span lang="en">Home</span></div></a></li>',$header);
            $header = str_replace("[categorie]",'<li><a href="categorie.php"><div class="navbar_link">Categorie</div></a></li>',$header);
            $header = str_replace("[eventi]",'<li><a href="eventi.php"><div class="navbar_link">Prossimi eventi</div></a></li>',$header);
            $header = str_replace("[login]", '<li><a href="profilo.php"><div class="navbar_link">Profilo</div></a></li>', $header);
            $header = str_replace("[libreria]", '<li><a href="opzioni_sviluppatore.php"><div class="navbar_link">Opzioni Sviluppatore</div></a></li>', $header);

            $header = str_replace("[breadcrump]",'<div class="breadcrump"><p>Ti trovi in: <a href="index.php" lang="en">Home</a> &gt&gt; <a href="opzioni_sviluppatore.php">Opzioni Svilupppatore</a> &gt&gt; Aggiungi Articolo</p> </div>',$header);
        }

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