<div class="projects__container project" id="page-project">
  <div class="project__container">
    <div class="project__header">
      <h2 class="project__title">
        Proyecto: <span class="project__title--span"><?php echo $title ?? '' ?></span>
      </h2>

      <button 
      type="button" 
      class="project__btn project__btn--addTask" 
      id="new-task"
      >
        Agregar nueva tarea
      </button>
    </div>  <!-- END PROJECT HEADER -->

    <div class="project__filters filters" id="filters">
      <ul class="filters__list">
        <li class="filters__item">
          <button
            type="button"
            class="filters__btn filters__btn--active"
            id="all"
          >
            Todos
          </button>
        </li>
        <li class="filters__item">
          <button
            type="button"
            class="filters__btn"
            id="completed"
          >
            Completados
          </button>
        </li>
        <li class="filters__item">
          <button
            type="button"
            class="filters__btn"
            id="pending"
          >
            Pendientes
          </button>
        </li>
      </ul>
    </div>  <!-- END PROJECT FILTERS -->
  
    <div class="project__tasks tasks" id="list-tasks">
    </div>  <!-- END PROJECT TASKS -->
  </div>
</div>

<?php 
  $script = "
  "; 
?>