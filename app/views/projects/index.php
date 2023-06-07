
<div class="projects__container">
  <h2 class="projects__title"><?php echo $title; ?></h2>
  <?php if (count($projects) <= 0) : ?>
    <p class='projects__empty'>No hay Proyectos Aún</p>
    <a href="/create-project" class="btn">Crea Uno</a>
  <?php endif; ?>

  <?php if (count($projects) >= 0) : ?>
    <ul class="projects__list">
      <?php foreach ($projects as $row) { ?>
        <li class="projects__link">
          <a href="/project/<?php echo $row->projectName; ?>" class="projects__link--content">
            <?php echo $row->name; ?>
          </a>
        </li>
      <?php } ?>
    </ul>
  <?php endif; ?>
</div>
