<div class="container login">
  <h1 class="title">Tasks</h1>
  <p class="tagline">Administra tus proyectos</p>

  <div class="container-sm">

    <?php include_once __DIR__.'/../template/alerts.php'; ?>

    <form action="/" method="POST" class="form">
      <div class="form__field">
        <label for="email" class="form__field--label">Correo</label>
        <input 
          class="form__field--input"
          type="email" 
          name="email" 
          id="email" 
          placeholder="ejm: renato@renato.com"
        >
      </div>

      <div class="form__field">
        <label for="password" class="form__field--label">Contraseña</label>
        <input 
        class="form__field--input"
          type="password" 
          name="password" 
          id="password"
          placeholder="Tu contraseña"
        >
      </div>
      
      <button 
        type="submit" 
        class="form__submit"
      >
        Iniciar sesión
      </button>
    </form>

    <div class="links">
      <p class="links__link--text">Aún no tienes una Cuenta? <a href="/register" class="links__link">Crear Una</a></p>
      <a class="links__link" href="/forgot-password">Olvide mi contraseña</a>
    </div>
  </div> <!-- .container-sm -->
</div> <!-- .container -->