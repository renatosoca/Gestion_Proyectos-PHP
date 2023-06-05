<div class="container forgot-password">
  <h1 class="title">Tasks</h1>
  <p class="tagline">Recupera el acceso a tu cuenta</p>

  <div class="container-sm">

    <?php include_once __DIR__.'/../template/alerts.php'; ?>

    <form action="/forgot-password" method="POST" class="form">
      <div class="form__field">
        <label for="email" class="form__field--label">Email</label>
        <input 
          class="form__field--input"
          type="email" 
          name="email" 
          id="email" 
          placeholder="Tu Email"
        >
      </div>
      
      <button type="submit" class="form__submit">
        Enviar Instrucciones
      </button>
    </form>

    <div class="links">
      <p class="links__link--text">Ya tienes una cuenta? <a href="/" class="links__link">Inicia sesión</a></p>
    </div>
  </div> <!-- .container-sm -->
</div> <!-- .container -->