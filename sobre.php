<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Starmovie</title>
    <link rel="stylesheet" href="css/style.css">

    <style>
        /* ===== Estilos gerais ===== */
        body {
            margin: 0;
            background-color: #000;
            color: #fff;
            font-family: Arial, Helvetica, sans-serif;
        }

        header {
            background-color: #111;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 60px;
        }

        main {
           display: flex;
           flex-direction: column;
           align-items: flex-start;
           justify-content: center;
           padding: 40px 20px;
           font-size: 1.2rem;
           text-align: left;
           max-width: 1300px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo img {
            height: 40px;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 25px;
            margin: 0;
            padding: 0;
        }

        nav ul li a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            transition: color 0.3s;
        }

        nav ul li a:hover {
            color: #ffcc00;
        }

        .search-login {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .search-login input[type="text"] {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
        }

        .btn-login {
            background-color: #c00;
            color: #fff;
            padding: 8px 15px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
        }

        .btn-login:hover {
            background-color: #ff0000;
        }

        .center-img {
            align-self: center;
            max-width: 40%;
            height: auto;
            display: block;
            margin: 30px 0; 
        }

        /* Estiliza os títulos */
        .h2 {
            color: #ddb71fff;         
            position: relative;
            display: inline-block;
            padding-bottom: 10px;
            text-align: left;
        }

        .h2::after {
           content: "";
           position: absolute;
           bottom: 0;
           left: 50%;
           transform: translateX(-50%);
           width: 60%;
           height: 3px;
           background: red;   
        }

        .footer {
            text-align: center;
        }

        /* Botão GitHub */
        .btn-github {
            display: inline-flex;
            align-items: center;
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s, color 0.3s;
        }

        .btn-github:hover {
            background-color: #ffcc00;
            color: #000;
        }

        .btn-github img {
            width: 20px;
            vertical-align: middle;
            margin-right: 8px;
        }
    </style>
</head>
<body>

<?php include("header.php"); ?>

<main>
    <h2 class="h2">Sobre o Starmovie</h2>
    <p>O Starmovie nasceu com a proposta de oferecer um ambiente moderno e fácil de usar para amantes do cinema.  
       Aqui você encontra avaliações, notas e informações sobre filmes de diversos gêneros.  
       Nosso objetivo é ajudar você a decidir o que assistir e compartilhar suas impressões com outros usuários.
    </p>

    <h2 class="h2">Nossa missão</h2>
    <p>Nossa missão é transformar a forma como você descobre novos filmes, oferecendo um ambiente moderno, rápido e intuitivo. Queremos que
        cada usuário tenha uma experiência simples e agradável ao explorar o universo do cinema.
    </p>

    <h2 class="h2">Propósito do Starmovie</h2>
    <p>Acreditamos que o cinema aproxima pessoas, inspira histórias e desperta emoções. Por isso, nosso propósito é oferecer
        um espaço onde todos possam expressar seu amor pelo cinema de forma simples e divertida.
    </p>

    <h2 class="h2">Nosso projeto e equipe</h2>
    <p>Este site também faz parte de um projeto desenvolvido na matéria de SW  
      da Escola Maria Cristina Medeiros, onde buscamos aplicar nossos  
      conhecimentos em desenvolvimento web criando uma plataforma prática,  
      intuitiva e voltada para os fãs de cinema.
    </p>
    <img src="img/nos.jpeg" class="img-fluid center-img" alt="Nossa equipe">

    <!-- Seção de Contato com botão GitHub -->
    <p>
        <a href="https://github.com/helolrodrigues/starmovie" target="_blank" class="btn-github">
            <img src="img/icon-github.png" alt="GitHub">
            Acesse nosso GitHub
        </a>
    </p>

</main>

<?php include("footer.php"); ?>
</body>
</html>
