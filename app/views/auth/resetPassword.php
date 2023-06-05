<div class="contenedor reset-password">
  <h1 class="title">UpTask</h1>
  <p class="tagline">Crea y administra tus proyectos</p>

  <div class="contenedor-sm">
    <p class="descripcion-pagina">Coloca tu nuevo Password</p>

    <?php 
      include_once __DIR__.'/../template/alerts.php'; 
      if (!$error) :
    ?>

    <form method="POST" class="form">
      <div class="form__field">
        <label for="password" class="form__field--label">Contraseña</label>
        <input
          class="form__field--input"
          type="password" 
          name="password" 
          id="password" 
          placeholder="Tu Password"
        >
      </div>
      
      <input 
        type="submit" 
        value="Cambiar Password" 
        class="form__submit"
      >
    </form>

    <?php endif; ?>

    <div class="links">
      <p class="links__link--text">Ya tienes una cuenta? <a href="/" class="links__link">Inicia sesión</a></p>
      <p class="links__link--text">Aún no tienes una Cuenta? <a href="/register" class="links__link">Crear Una</a></p>
    </div>
  </div> <!-- .contenedor-sm -->
</div> <!-- .contenedor -->