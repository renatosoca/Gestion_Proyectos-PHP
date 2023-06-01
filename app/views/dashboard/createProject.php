
<div class="contenedor-sm">
  <?php include_once __DIR__.'/../template/alerts.php'; ?>

  <form action="/create-project" class="formulario" method="POST">

    <?php include_once __DIR__.'/formProject.php'; ?>

    <input 
      type="submit" 
      value="Crear Proyecto" 
      class="btn"
    >
  </form>
</div>
