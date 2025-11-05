<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "starmovie"; // ou o nome exato do seu banco

$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

// Teste de conexão (opcional)
if (!$conexao) {
    die("Erro de conexão: " . mysqli_connect_error());
}
?>
