<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo "
    <style>
        body {
            background-color: #000;
            color: #fff;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
        .msg {
            background-color: #111;
            border: 2px solid #ffcc00;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 20px #ffcc00;
            width: 350px;
        }
        a {
            color: #ffcc00;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            color: #fff200;
        }
    </style>
    <div class='msg'>
        <h2>⚠️ Acesso restrito!</h2>
        <p>Você precisa se conectar para acessar esta página.</p>
        <a href='login.php'>Fazer login</a>
    </div>
    ";
    exit;
}


require 'conexao.php';

// Verifica se recebeu o ID pela URL
if (!isset($_GET['id'])) {
    die("Erro: ID não informado!");
}

$id = (int) $_GET['id']; 

try { //exclui do banco
   $sql = "DELETE FROM titulos WHERE id_titulos = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // verifica se apagou
    if ($stmt->rowCount() > 0) {
        header("Location: listar.php?msg=deletado");
        exit;
    } else {
        echo "Nenhum registro encontrado com esse ID.";
    }

} catch (PDOException $e) {
    echo "Erro ao excluir: " . $e->getMessage();
}

?>

