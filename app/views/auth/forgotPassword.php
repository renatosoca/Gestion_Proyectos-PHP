<div class="container forgot-password">
  <h1 class="titulo">Tasks</h1>
  <p class="tagline">Crea y administra tus proyectos</p>

  <div class="container-sm">
    <p class="descripcion-pagina">Recupera tu contraseña</p>

    <?php include_once __DIR__.'/../template/alerts.php'; ?>

    <form action="/forgot-password" method="POST" class="formulario">
      <div class="campo">
        <label for="email">Email</label>
        <input 
          type="email" 
          name="email" 
          id="email" 
          placeholder="Tu Email"
        >
      </div>
      
      <input type="submit" value="Enviar Instrucciones" class="btn">
    </form>

    <div class="acciones">
      <a href="/">Ya tienes una cuenta? Inicia Sesión</a>
      <a href="/register">Aún no tienes una Cuenta? Crea Una</a>
    </div>
  </div> <!-- .container-sm -->
</div> <!-- .container -->