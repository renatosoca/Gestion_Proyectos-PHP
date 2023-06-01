<div class="container register">
  <h1 class="titulo">Tasks</h1>
  <p class="tagline">Crea y administra tus proyectos</p>

  <div class="container-sm">
    <p class="descripcion-pagina">Crea tu Cuenta</p>

    <?php include_once __DIR__.'/../template/alerts.php'; ?>

    <form action="/register" method="POST" class="formulario">
      <div class="campo">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" placeholder="Tu Nombre" value="<?php echo $user->nombre; ?>">
      </div>

      <div class="campo">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" placeholder="Tu Email" value="<?php echo $user->email; ?>">
      </div>

      <div class="campo">
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" placeholder="Tu Password">
      </div>

      <div class="campo">
        <label for="password2">Confirmar contraseña:</label>
        <input type="password" name="password2" id="password2" placeholder="Confirma tu Password">
      </div>
      
      <input type="submit" value="Crear Cuenta" class="btn">
    </form>

    <div class="acciones">
      <a href="/">Ya tienes una cuenta? Inicia Sesión</a>
      <a href="/forgot-password">Olvidaste tu Password?</a>
    </div>
  </div> <!-- .container-sm -->
</div> <!-- .container -->