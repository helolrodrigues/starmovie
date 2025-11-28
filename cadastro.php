<?php
session_start();
include("conexao.php"); // deve conter $pdo

$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $senha = $_POST['senha'] ?? '';

    if (empty($nome) || empty($email) || empty($senha)) {
        $erro = "Preencha todos os campos.";
    } else {
        // Verifica se o email já existe
        $sql = "SELECT id_usuario FROM usuarios WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Usuário já existe → atualizar
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $id = $row['id_usuario'];

            $hash = password_hash($senha, PASSWORD_DEFAULT);

            $upd = $pdo->prepare("
                UPDATE usuarios
                SET nome = :nome, senha = :senha
                WHERE id_usuario = :id
            ");
            $upd->execute([
                ':nome' => $nome,
                ':senha' => $hash,
                ':id'    => $id
            ]);

        } else {
            // Criar novo usuário
            $hash = password_hash($senha, PASSWORD_DEFAULT);

            $ins = $pdo->prepare("
                INSERT INTO usuarios (nome, email, senha)
                VALUES (:nome, :email, :senha)
            ");
            $ins->execute([
                ':nome' => $nome,
                ':email' => $email,
                ':senha' => $hash
            ]);

            // Capturar ID inserido
            $id = $pdo->lastInsertId();
        }

        // Login automático
        $_SESSION['usuario'] = $nome;
        $_SESSION['usuario_email'] = $email;
        $_SESSION['usuario_id'] = $id;

        header("Location: index.php");
        exit;
    }
}
?>
 <!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro / Login Automático</title>
    <style>
        body {
            background-color: #000;
            color: #fff;
            font-family: Arial, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .login-form {
            background-color: #111;
            border: 2px solid #ffcc00;
            border-radius: 12px;
            box-shadow: 0 0 20px #ffcc00;
            padding: 35px;
            width: 350px;
            text-align: center;
            animation: fadeIn 0.6s ease;
        }

        h2 {
            color: #ffcc00;
            margin-bottom: 20px;
            font-size: 1.4rem;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 6px;
            outline: none;
            background-color: #222;
            color: #fff;
            font-size: 0.95rem;
            transition: box-shadow 0.3s, border 0.3s;
        }

        input:focus {
            box-shadow: 0 0 10px #ffcc00;
            border: 1px solid #ffcc00;
        }

        button {
            background-color: #ffcc00;
            color: #000;
            border: none;
            padding: 10px;
            border-radius: 6px;
            width: 100%;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background-color: #fff200;
        }

        p {
            color: #ff4d4d;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<!-- coleta informações para o cadastro -->
<form method="post" class="login-form">
    <h2>Faça seu cadastro na StarMovie!</h2>
    <input type="text" name="nome" placeholder="Nome" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="senha" placeholder="Senha" required>
    <button type="submit">Entrar</button>

    <?php if (!empty($erro)) echo "<p>$erro</p>"; ?>
</form>

</body>
</html>
