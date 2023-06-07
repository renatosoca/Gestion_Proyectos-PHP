<div class="projects__container profile">
  <div class="profile__container">
    <?php include_once __DIR__.'/../template/alerts.php'; ?>
  
    <div class="profile__header">
      <h2 class="profile__title" ><?php echo $title ?? '' ?></h2>
      <a href="/user/change-password" class="profile__link">Cambiar Contraseña</a>
    </div>
  
    <form action="/user/profile" class="form" method="POST">
      <div class="form__field">
        <label for="name" class="form__field--label">Nombre</label>
        <input 
          class="form__field--input"
          type="text" 
          name="name" 
          id="name" 
          value="<?php echo sanitize($user->name ?? ''); ?>" 
          placeholder="Tu bombre"
        >
      </div>

      <div class="form__field">
        <label for="lastname" class="form__field--label">Apellido</label>
        <input 
          class="form__field--input"
          type="text" 
          name="lastname" 
          id="lastname" 
          value="<?php echo sanitize($user->lastname ?? ''); ?>" 
          placeholder="Tu bombre"
        >
      </div>
      
      <div class="form__field">
        <label for="email" class="form__field--label">Email</label>
        <input 
          class="form__field--input"
          type="email" 
          name="email" 
          id="email" 
          value="<?php echo sanitize($user->email ?? ''); ?>" 
          placeholder="Tu Email"
        >
      </div>
  
      <input type="submit" value="Guardar Cambio" class="form__submit">
    </form>
  </div>
</div>