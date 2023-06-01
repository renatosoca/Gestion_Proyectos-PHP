<div class="container-sm">
  <?php include_once __DIR__.'/../template/alerts.php'; ?>

  <a href="/user/change-password" class="btn">Cambiar Contraseña</a>

  <form action="/profile" class="formulario" method="POST">
    <div class="campo">
      <label for="nombre">Nombre</label>
      <input 
        type="text" 
        name="nombre" 
        id="nombre" 
        value="<?php echo sanitize($user->nombre); ?>" 
        placeholder="Tu Nombre"
      >
    </div>
    
    <div class="campo">
      <label for="email">Email</label>
      <input 
        type="email" 
        name="email" 
        id="email" 
        value="<?php echo sanitize($user->email); ?>" 
        placeholder="Tu Email"
      >
    </div>

    <input type="submit" value="Guardar Cambio" class="btn">
  </form>
</div>