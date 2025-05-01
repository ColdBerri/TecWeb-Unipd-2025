    <?php
require_once "template.php";
$paginaHTML = new Template("Assistenza", "videgiochi, assistenza, contatti, problemi", "html/assistenza.html");

$paginaHTML->aggiungiContenuto("[titolo]", "Assistenza");
$paginaHTML->aggiungiContenuto("[descrizione]", "Ti serve aiuto? chiedi pure al nostro team.");
$paginaHTML->aggiungiContenuto("[keywords]", "assistenza, contatti, problemi");

$paginaHTML->getPagina();
?>