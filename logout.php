<?php
session_start();

// tira todas as informações restritas
$_SESSION = array();

//encerra a sessao
session_destroy();

// volta para a pagina inicial
header("Location: index.php");
exit;
?>
