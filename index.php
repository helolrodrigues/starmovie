<?php session_start(); ?>
<?php include("header.php"); ?>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<main>
  <h2>Filmes em destaque</h2>

  <div class="filmes">
    <!-- Linha 1 -->
    <div class="card" data-bs-toggle="modal" data-bs-target="#modal1">
      <img src="img/divertidamente.jpeg" alt="Divertidamente">
      <h5 class="card-title">Saiba mais</h5>
    </div>

    <div class="card" data-bs-toggle="modal" data-bs-target="#modal2">
      <img src="img/coraline.jpg" alt="Coraline">
      <h5 class="card-title">Saiba mais</h5>
    </div>

    <div class="card" data-bs-toggle="modal" data-bs-target="#modal3">
      <img src="img/caramelo.jpg" alt="Caramelo">
      <h5 class="card-title">Saiba mais</h5>
    </div>

    <div class="card" data-bs-toggle="modal" data-bs-target="#modal4">
      <img src="img/chocolate.webp" alt="A fantástica fábrica de chocolate">
      <h5 class="card-title">Saiba mais</h5>
    </div>

    <!-- Linha 2 -->
    <div class="card" data-bs-toggle="modal" data-bs-target="#modal5">
      <img src="img/elaeoscaras.webp" alt="Ela e os caras">
      <h5 class="card-title">Saiba mais</h5>
    </div>

    <div class="card" data-bs-toggle="modal" data-bs-target="#modal6">
      <img src="img/invocacao.webp" alt="Invocação do mal 4">
      <h5 class="card-title">Saiba mais</h5>
    </div>

    <div class="card" data-bs-toggle="modal" data-bs-target="#modal7">
      <img src="img/donzela.jpg" alt="Donzela">
      <h5 class="card-title">Saiba mais</h5>
    </div>

    <div class="card" data-bs-toggle="modal" data-bs-target="#modal8">
      <img src="img/titanic.jpg" alt="Titanic">
      <h5 class="card-title">Saiba mais</h5>
    </div>
  </div>

  <!-- Modais -->
  <?php
  $filmes = [
      ['id'=>'modal1','titulo'=>'Divertidamente','img'=>'divertidamente.jpeg','desc'=>'Descrição completa do filme Divertidamente.'],
      ['id'=>'modal2','titulo'=>'Coraline','img'=>'coraline.jpg','desc'=>'Descrição completa do filme Coraline.'],
      ['id'=>'modal3','titulo'=>'Caramelo','img'=>'caramelo.jpg','desc'=>'Descrição completa do filme Caramelo.'],
      ['id'=>'modal4','titulo'=>'A Fantástica fábrica de chocolate','img'=>'chocolate.webp','desc'=>'Descrição completa do Filme 4.'],
      ['id'=>'modal5','titulo'=>'Ela e os caras','img'=>'elaeoscaras.webp','desc'=>'Descrição completa do Filme 5.'],
      ['id'=>'modal6','titulo'=>'Invocação do mal 4','img'=>'invocacao.webp','desc'=>'Descrição completa do Filme 6.'],
      ['id'=>'modal7','titulo'=>'Donzela','img'=>'donzela.webp','desc'=>'Descrição completa do Filme 7.'],
      ['id'=>'modal8','titulo'=>'Titanic','img'=>'titanic.jpg','desc'=>'Descrição completa do Filme 8.'],
  ];

  foreach($filmes as $filme): ?>
    <div class="modal fade" id="<?= $filme['id'] ?>" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><?= $filme['titulo'] ?></h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body text-center">
            <img src="img/<?= $filme['img'] ?>" class="img-fluid" alt="<?= $filme['titulo'] ?>">
            <p><?= $filme['desc'] ?></p>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>

  <!-- Botão para inserir novo filme -->
  <div class="text-center mt-4">
    <a href="inserir.php" class="btn btn-warning btn-lg">Inserir novo filme</a>
  </div>
</main>

<?php include("footer.php"); ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<style>
  body { 
    background: #000; 
    color: #fff; 
    font-family: Arial, sans-serif; 
    margin: 0; 
    padding: 20px; 
  }

  h2 { 
    text-align: center; 
    color: #ffcc00; 
    margin-bottom: 30px; 
  }

  .filmes {
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* 4 cards por linha */
    gap: 20px;
    max-width: 1200px;
    margin: 0 auto 50px auto;
  }

  .card {
    text-align: center;
    cursor: pointer;
  }

  .card img {
    width: 100%;
    height: 400px;
    object-fit: cover;
    border-radius: 10px;
    transition: transform 0.3s, box-shadow 0.3s;
  }

  .card img:hover {
    transform: scale(1.05);
    box-shadow: 0 0 20px rgba(255,204,0,0.5);
  }

  .card-title {
    margin-top: 8px;
    font-size: 1rem;
    color: #ffcc00;
  }

  .modal-content {
    background: #111;
    color: #fff;
    border-radius: 12px;
  }

  .modal-body img {
    border-radius: 10px;
    margin-bottom: 15px;
  }

  .btn-close-white {
    filter: invert(1);
  }

  .btn-warning {
    background-color: #ffcc00;
    border-color: #ffcc00;
    color: #000;
    font-weight: bold;
    padding: 10px 25px;
    transition: transform 0.2s;
  }

  .btn-warning:hover {
    transform: scale(1.05);
    color: #000;
  }
</style>
