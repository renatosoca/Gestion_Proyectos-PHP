<div class="contenedor-sm">
  <div class="contenedor-nueva-tarea">
    <button type="button" class="agregar-tarea" id="new-task">&#43; Nueva Tarea</button>
  </div>

  <div class="filtros" id="filtros">
    <div class="filtros-inputs">
      <h2>Filtros</h2>

      <div class="campo">
        <label for="todas">Todas</label>
        <input type="radio" name="filtro" id="todas" value="" checked>
      </div>

      <div class="campo">
        <label for="completas">Completas</label>
        <input type="radio" name="filtro" id="completas" value="1">
      </div>

      <div class="campo">
        <label for="pendiente">Pendientes</label>
        <input type="radio" name="filtro" id="pendiente" value="0">
      </div>
    </div>
  </div>

  <ul id="listado-tareas" class="listado-tareas">
  </ul>
</div>

<?php 
  $script = "
  <script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
  <script src='/build/js/main.js' ></script>
  "; 
?>