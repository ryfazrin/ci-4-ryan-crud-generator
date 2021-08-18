<?php include_once 'templates/header.php'; ?>

<?php include_once 'templates/navbar.php'; ?>

<div class="container">
  <div class="text-center">
    <h1><?= $title; ?></h1>
    <a href="<?= BASE_URL ?>/?page=generator" class="btn btn-success">Let's Create Your first CRUD</a>
  </div>
</div>

<?php include_once 'templates/footer.php' ?>