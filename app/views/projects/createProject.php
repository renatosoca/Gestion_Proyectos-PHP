
<div class="project__container createProject">
  <div class="createProject__container">
    <h2 class="createProject__title">Crear un proyecto</h2>
    <?php include_once __DIR__.'/../template/alerts.php'; ?>
  
    <form action="/create-project" class="form" method="POST">
  
      <?php include_once __DIR__.'/formProject.php'; ?>
  
      <input 
        type="submit" 
        value="Crear Proyecto" 
        class="form__submit"
      >
    </form>
  </div>
</div>
