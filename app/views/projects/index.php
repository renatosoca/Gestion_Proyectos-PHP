
<div class="project__container">
  <h2 class="project__title"><?php echo $title; ?></h2>
  <?php if (count($projects) <= 0) : ?>
    <p class='no-proyectos'>No hay Proyectos Aún</p>
    <a href="/create-project" class="btn">Crea Uno</a>
  <?php endif; ?>

  <?php if (count($projects) >= 0) : ?>
    <ul class="listado-proyectos">
      <?php foreach ($projects as $row) { ?>
        <li>
          <a href="/project/<?php echo $row->projectName; ?>" class="proyecto">
            <?php echo $row->name; ?>
          </a>
        </li>
      <?php } ?>
    </ul>
  <?php endif; ?>
</div>
