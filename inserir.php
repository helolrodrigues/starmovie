 <?php //protege a pagina, so quem esta conectado consegue acessar
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
?>

<?php
require 'conexao.php';

// Defina os valores que quer inserir
$nome_serie = "Homem-Aranha";
$nome_filmes = "Sem Volta Para Casa";
$tipo = "Filme"; // pode ser 'Filme' ou 'Série'

// Query para inserir na tabela
$sql = "INSERT INTO titulos (nome_serie, nome_filmes, tipo) 
        VALUES (:nome_serie, :nome_filmes, :tipo)";
$stmt = $pdo->prepare($sql);

// Passa as variáveis para os parâmetros da query
$stmt->bindParam(':nome_serie', $nome_serie);
$stmt->bindParam(':nome_filmes', $nome_filmes);
$stmt->bindParam(':tipo', $tipo);

// Executa e mostra o resultado
if ($stmt->execute()) {
    echo "Título inserido com sucesso!";
} else {
    echo "Erro ao inserir título.";
}
?>

