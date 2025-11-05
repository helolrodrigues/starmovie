<?php
session_start();
include("conexao.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email='$email' AND senha='$senha'";
    $res = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($res) > 0) {
        $usuario = mysqli_fetch_assoc($res);
        $_SESSION['usuario'] = $usuario['nome'];
        header("Location: index.php");
        exit;
    } else {
        $erro = "Email ou senha incorretos!";
    }
}
?>
<link rel="stylesheet" href="./css/style.css">
<form method="post" class="login-form">
  <h2>Login</h2>
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="senha" placeholder="Senha" required>
  <button type="submit">Entrar</button>
  <?php if (!empty($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
</form>
