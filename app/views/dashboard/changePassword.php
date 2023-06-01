<div class="contenedor-sm">
  <?php include_once __DIR__.'/../template/alerts.php'; ?>

  <a href="/user/profile" class="btn">Volver</a>

  <form action="/cambiar-clave" class="formulario" method="POST">
    <div class="campo">
      <label for="password_actual">Password Actual</label>
      <input 
        type="password" 
        name="password_actual" 
        id="password_actual" 
        placeholder="Tu Password Actual"
      >
    </div>

    <div class="campo">
      <label for="password_nuevo">Password Nuevo</label>
      <input 
        type="password"
        name="password_nuevo"
        id="password_nuevo"
        placeholder="Tu Password Nuevo"
      >
    </div>

    <input
      type="submit" 
      value="Guardar Cambio" 
      class="btn"
    >
  </form>
</div>