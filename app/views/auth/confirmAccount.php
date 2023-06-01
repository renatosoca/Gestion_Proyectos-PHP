<div class="container confirm-account">
  <h1 class="titulo">Tasks</h1>
  <p class="tagline">Crea y administra tus proyectos</p>

  <?php include_once __DIR__.'/../template/alerts.php'; ?>

  <?php if ($isVerified): ?>
    <div class="acciones">
      <a href="/"> Iniciar Sesión</a>
    </div>
  <?php endif; ?>
</div> <!-- .container -->