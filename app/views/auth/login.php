<div class="container login">
  <h1 class="titulo">Tasks</h1>
  <p class="tagline">Crea y administra tus proyectos</p>

  <div class="container-sm">
    <p class="descripcion-pagina">Iniciar Sesión</p>

    <?php include_once __DIR__.'/../template/alerts.php'; ?>

    <form action="/" method="POST" class="formulario">
      <div class="campo">
        <label for="email">Correo</label>
        <input 
          type="email" 
          name="email" 
          id="email" 
          placeholder="ejm: renato@renato.com"
        >
      </div>

      <div class="campo">
        <label for="password">Contraseña</label>
        <input 
          type="password" 
          name="password" 
          id="password"
          placeholder="Tu contraseña"
        >
      </div>
      
      <input 
        type="submit" 
        value="Ingresar" 
        class="btn"
      >
    </form>

    <div class="acciones">
      <a href="/register">Aún no tienes una Cuenta? Crea Una</a>
      <a href="/forgot-password">Olvidaste tu Password?</a>
    </div>
  </div> <!-- .container-sm -->
</div> <!-- .container -->