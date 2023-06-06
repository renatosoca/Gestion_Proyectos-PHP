<div class="contenedor-sm">
  <?php include_once __DIR__.'/../template/alerts.php'; ?>

  <a href="/user/profile" class="btn">Volver</a>

  <form action="/user/change-password" class="formulario" method="POST">
    <div class="campo">
      <label for="currentPassword">Contraseña Actual</label>
      <input 
        type="password" 
        name="currentPassword"
        id="currentPassword" 
        placeholder="Tu contraseña actual"
      >
    </div>

    <div class="campo">
      <label for="password">Nueva contraseña</label>
      <input 
        type="password"
        name="password"
        id="password"
        placeholder="Tu nueva contraseña"
      >
    </div>

    <input
      type="submit" 
      value="Guardar Cambio" 
      class="btn"
    >
  </form>
</div>