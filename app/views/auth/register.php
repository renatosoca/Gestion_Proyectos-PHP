<div class="container register">
  <h1 class="titulo">Projetify</h1>
  <p class="tagline">Crea y administra tus proyectos</p>

  <div class="container-sm">
    <p class="descripcion-pagina">Crea tu Cuenta</p>

    <?php include_once __DIR__.'/../template/alerts.php'; ?>

    <form action="/register" method="POST" class="formulario">
      <div class="campo">
        <label for="name">Nombre:</label>
        <input type="text" name="name" id="name" placeholder="Tu name" value="<?php echo $user->name; ?>">
      </div>
      
      <div class="campo">
        <label for="lastname">Apellido:</label>
        <input type="text" name="lastname" id="lastname" placeholder="Tu lastname" value="<?php echo $user->lastname; ?>">
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
        <label for="confirmPassword">Confirmar contraseña:</label>
        <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirma tu Password">
      </div>
      
      <input type="submit" value="Crear Cuenta" class="btn">
    </form>

    <div class="acciones">
      <a href="/">Ya tienes una cuenta? Inicia Sesión</a>
      <a href="/forgot-password">Olvidaste tu Password?</a>
    </div>
  </div> <!-- .container-sm -->
</div> <!-- .container -->