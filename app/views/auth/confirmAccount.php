<div class="container confirm-account">
  <h1 class="title">Projetify</h1>
  <p class="tagline">Crea y administra tus proyectos</p>

  <div class="">
    <?php include_once __DIR__.'/../template/alerts.php'; ?>
  
    <?php if ($isVerified): ?>
      <div class="links">
        <a href="/" class="links__link">Iniciar Sesión</a>
      </div>
    <?php endif; ?>
  </div>
</div> <!-- .container -->