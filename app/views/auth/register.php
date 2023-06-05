<div class="container register">
  <h1 class="title">Projetify</h1>
  <p class="tagline">Crea y administra tus proyectos</p>

  <div class="container-sm">

    <?php include_once __DIR__.'/../template/alerts.php'; ?>

    <form action="/register" method="POST" class="form">
      <div class="form__field">
        <label for="name" class="form__field--label">Nombre:</label>
        <input
          class="form__field--input" 
          type="text" 
          name="name" 
          id="name" 
          placeholder="Tu name" 
          value="<?php echo $user->name; ?>"
        >
      </div>
      
      <div class="form__field">
        <label for="lastname" class="form__field--label">Apellido:</label>
        <input
          class="form__field--input" 
          type="text" 
          name="lastname" 
          id="lastname" 
          placeholder="Tu lastname" 
          value="<?php echo $user->lastname; ?>"
        >
      </div>

      <div class="form__field">
        <label for="email" class="form__field--label">Email:</label>
        <input
          class="form__field--input" 
          type="email" 
          name="email" 
          id="email" 
          placeholder="Tu Email" 
          value="<?php echo $user->email; ?>"
        >
      </div>

      <div class="form__field">
        <label for="password" class="form__field--label">Contraseña:</label>
        <input
          class="form__field--input" 
          type="password" 
          name="password"
          id="password" 
          placeholder="Tu Password"
        >
      </div>

      <div class="form__field">
        <label for="confirmPassword" class="form__field--label">Confirmar contraseña:</label>
        <input
          class="form__field--input" 
          type="password" 
          name="confirmPassword" 
          id="confirmPassword" 
          placeholder="Confirma tu Password"
        >
      </div>
      
      <button 
        type="submit"
        class="form__submit"
      >
        Crear Cuenta
      </button>
    </form>

    <div class="links">
      <p class="links__link--text">Ya tienes una cuenta? <a href="/" class="links__link">Inicia sesión</a></p>
      <a href="/forgot-password" class="links__link">Olvidé mi contraseña</a>
    </div>
  </div> <!-- .container-sm -->
</div> <!-- .container -->