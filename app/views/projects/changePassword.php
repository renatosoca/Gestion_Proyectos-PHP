<div class="projects__container changePassword">
  <div class="changePassword__container">
    <?php include_once __DIR__.'/../template/alerts.php'; ?>

    <div class="changePassword__header">
      <h2 class="changePassword__title" ><?php echo $title ?? '' ?></h2>
      <a href="/user/profile" class="changePassword__link">Volver</a>
    </div>
  
    <form action="/user/change-password" class="form" method="POST">
      <div class="form__field">
        <label for="currentPassword" class="form__field--label" >Contraseña Actual</label>
        <input 
          class="form__field--input"
          type="password" 
          name="currentPassword"
          id="currentPassword" 
          placeholder="Tu contraseña actual"
        >
      </div>
  
      <div class="form__field">
        <label for="password" class="form__field--label" >Nueva contraseña</label>
        <input 
          class="form__field--input"
          type="password"
          name="password"
          id="password"
          placeholder="Tu nueva contraseña"
        >
      </div>
  
      <input
        type="submit" 
        value="Guardar Cambio" 
        class="form__submit"
      >
    </form>
  </div>
</div>